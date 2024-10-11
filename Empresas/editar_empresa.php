<?php
$mostrarModal = false; 
$mensajeModal = ''; 

$servername = "localhost";
$username = "root";
$password = ""; 
$database = "linkhub";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_empresa = $_POST['id_empresa']; 
    $nombre = $_POST['nom_empresa'];
    $direccion = $_POST['direccion'];
    $correoEmp = $_POST['correo_emp'];
    $cantEmp = $_POST['cant_emp'];
    $rubro = $_POST['rubro'];
    $nombreRepresentante = $_POST['nom_representante'];
    $cargo = $_POST['cargo'];
    $numTelefono = $_POST['telefono_representante'];

    $sql = "UPDATE empresas SET 
            Nom_Empresa='$nombre', 
            Direccion='$direccion', 
            CorreoEmp='$correoEmp', 
            CantEmp='$cantEmp', 
            Rubro='$rubro', 
            NombreRepresentante='$nombreRepresentante', 
            Cargo='$cargo', 
            NumTelefono='$numTelefono' 
            WHERE ID_Empresas='$id_empresa'";

    if ($conn->query($sql) === TRUE) {
        $mostrarModal = true;
        $mensajeModal = 'Empresa actualizado correctamente.';
    } else {
        $mostrarModal = true;
        $mensajeModal = 'Error al actualizar el Empresa: ' . $conn->error;
    }
}

$id_empresa = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($id_empresa)) {
    header('Location: editar_empresa.php?error=id_no_proporcionado');
    exit;
}

$sql = "SELECT * FROM empresas WHERE ID_Empresas='$id_empresa'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $empresa = $result->fetch_assoc();
} else {
    $mostrarModal = true;
    $mensajeModal = 'Error: Empresa no encontrada.';
    exit;
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="es">    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkHub CRM - Editar Empresa</title>
    <link rel="stylesheet" href="../CSS/alta_empresa.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @font-face {
            font-family: "hidayatullah"; /* Define una fuente personalizada llamada "hidayatullah" */
            src: url(../font/Roboto-Italic.ttf); /* Ruta al archivo de la fuente personalizada */
        }

        /* Estilos generales */
        body {
            font-family: "hidayatullah", Arial, sans-serif; /* Aplica la fuente personalizada con fuentes de respaldo */
            background-color: #f8f9fa; /* Color de fondo claro */
            margin: 0;
            padding: 0;
        }

        /* Encabezado */
        .header {
            display: flex;
            flex-direction: row; /* Cambiar a columna para que el logo y el título se apilen */
            align-items: flex-start; /* Alinear al inicio */
            margin-bottom: 20px;
        }

        .logo {
            width: 150px; /* Tamaño del logo */
        }

        /* Título */
        .header h1 {
            color: #343a40; /* Color del título */
            margin: 0; /* Eliminar márgenes para alinear a la izquierda */
            text-align: left; /* Alinear el texto a la izquierda */
            margin-top: 10px; /* Espacio entre el logo y el título */
        }

        /* Estilo del contenedor principal */
        .container {
            position: relative;
            width: 100%;
            max-width: 900px !important;
            min-height: 900px !important;
            background: #fff;
            margin: 50px auto; /* Centrar el contenedor horizontalmente */
            box-shadow: 0 35px 55px #81689D;
            border-radius: 10px;
            padding: 20px; /* Añadir padding interno */
        }

        /* Estilo del formulario */
        .form-group {
            display: flex;
            flex-direction: column; /* Alinear elementos en columna */
            align-items: flex-start; /* Alinear los inputs y las etiquetas a la izquierda */
            margin-bottom: 15px;
            width: 100%; /* Ajustar el ancho */
        }

        label {
            font-weight: bold;
            margin-bottom: 5px; /* Espacio entre la etiqueta y el input */
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        select {
            width: 40%; /* Ocupa todo el ancho disponible */
            padding: 10px;
            border: 1px solid #ced4da; /* Borde gris */
            border-radius: 4px; /* Bordes redondeados */
            transition: border-color 0.3s;
            margin-bottom: 10px; /* Espacio inferior para separación entre inputs */
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="number"]:focus,
        select:focus {
            border-color: #80bdff; /* Color de borde al hacer foco */
            outline: none; /* Sin contorno */
        }

        /* Estilo de los botones */
        button[type="submit"] {
            background-color: #3498db;
            border: none;
            color: white;
            padding: 12px 20px;
            text-align: center;
            font-size: 16px;
            border-radius: 25px;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #2980b9;
        }

        .btn-custom {
            border: 1px solid #000 !important; /* Borde de 1 píxel */
            border-radius: 5px !important; /* Borde redondeado, opcional */
            padding: 10px 20px !important; /* Espaciado interno para mayor comodidad */
            margin: 5px !important; /* Espaciado entre los botones */
        }

        .btn-container {
            display: flex; /* Usar flexbox para la alineación */
            flex-direction: row-reverse; /* Colocar los botones en columna */
            align-items: flex-end; /* Alinear los elementos al final (derecha) */
        }

        .lelo {
            margin-left: 50px;
        }

        .loader-container {
            display: none;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8); /* Fondo con opacidad */
            z-index: 9999;
        }

        .loader {
            border: 16px solid #f3f3f3;
            border-top: 16px solid #3498db; /* Color del borde superior */
            border-radius: 50%;
            width: 120px; /* Tamaño del loader */
            height: 120px;
            animation: spin 2s linear infinite; /* Animación de rotación */
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        select {
            width: 40% !important; /* Forzar el ancho a 30% */
            padding: 10px;
            border: 1px solid #ced4da; /* Borde gris */
            border-radius: 4px; /* Bordes redondeados */
            transition: border-color 0.3s;
            margin-bottom: 10px; /* Espacio inferior para separación entre inputs */
        }
    </style>
</head>

<body>
    <div class="btn-container">
    </div>
    <br><br>

    <div class="container">
        <div class="header">
            <img src="../IMG/LOGO_LinkHub_sf.png" alt="Logo LinkHub" class="logo">
            <h1 class="mt-4">LinkHub CRM</h1>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">EMPRESAS</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="ver_empresas.php">Regresar</a>
                    </li>
                </ul>
            </div>
        </nav>

        <h2 class="text-center">Editar Empresa</h2>
        <form method="POST" action="">
            <input type="hidden" name="id_empresa" value="<?php echo $empresa['ID_Empresas']; ?>">
            <div class="form-group">
                <label for="nom_empresa">Nombre de la Empresa:</label>
                <input type="text" id="nom_empresa" name="nom_empresa" value="<?php echo $empresa['Nom_Empresa']; ?>" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" value="<?php echo $empresa['Direccion']; ?>" required>
            </div>
            <div class="form-group">
                <label for="correo_emp">Correo Electrónico:</label>
                <input type="email" id="correo_emp" name="correo_emp" value="<?php echo $empresa['CorreoEmp']; ?>" required>
            </div>
            <div class="form-group">
                <label for="cant_emp">Cantidad de Empleados:</label>
                <input type="number" id="cant_emp" name="cant_emp" value="<?php echo $empresa['CantEmp']; ?>" required>
            </div>
            <div class="form-group">
                <label for="rubro">Rubro de la Empresa:</label>
                <div class="form-group">
    <select id="rubro" name="rubro" required>
        <option value="" disabled selected>Selecciona un rubro</option>
        <option value="Comercio" <?php if ($empresa['Rubro'] == 'Comercio') echo 'selected'; ?>>Comercio</option>
        <option value="Industria" <?php if ($empresa['Rubro'] == 'Industria') echo 'selected'; ?>>Industria</option>
        <option value="Servicios" <?php if ($empresa['Rubro'] == 'Servicios') echo 'selected'; ?>>Servicios</option>
        <option value="Tecnología" <?php if ($empresa['Rubro'] == 'Tecnología') echo 'selected'; ?>>Tecnología</option>
        <option value="Agropecuario" <?php if ($empresa['Rubro'] == 'Agropecuario') echo 'selected'; ?>>Agropecuario</option>
        <option value="Salud" <?php if ($empresa['Rubro'] == 'Salud') echo 'selected'; ?>>Salud</option>
        <option value="Finanzas" <?php if ($empresa['Rubro'] == 'Finanzas') echo 'selected'; ?>>Finanzas</option>
    </select>
</div>

            </div>
            <div class="form-group">
                <label for="nom_representante">Nombre del Representante:</label>
                <input type="text" id="nom_representante" name="nom_representante" value="<?php echo $empresa['NombreRepresentante']; ?>" required>
            </div>
            <div class="form-group">
                <label for="cargo">Cargo del Representante:</label>
                <select class="form-control" id="cargo" name="cargo" required>
                    <option value="Director General" <?php if ($empresa['Cargo'] == 'Director General') echo 'selected'; ?>>Director General</option>
                    <option value="Gerente General" <?php if ($empresa['Cargo'] == 'Gerente General') echo 'selected'; ?>>Gerente General</option>
                    <option value="Director Comercial" <?php if ($empresa['Cargo'] == 'Director Comercial') echo 'selected'; ?>>Director Comercial</option>
                    <option value="Otro" <?php if ($empresa['Cargo'] == 'Otro') echo 'selected'; ?>>Otro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="telefono_representante">Teléfono del Representante:</label>
                <input type="text" id="telefono_representante" name="telefono_representante" value="<?php echo $empresa['NumTelefono']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary btn-custom">Actualizar Empresa</button>
        </form>
    </div>
    
        <!-- Modal de éxito -->
        <div class="modal fade" id="modalExito" tabindex="-1" role="dialog" aria-labelledby="modalExitoLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalExitoLabel">Éxito</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo $mensajeModal; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
         <!-- Modal de error -->
         <div class="modal fade" id="modalError" tabindex="-1" role="dialog" aria-labelledby="modalErrorLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalErrorLabel">Error</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo $mensajeModal; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <script>
            // Mostrar el modal de éxito o error si es necesario
            <?php if ($mostrarModal): ?>
                $(document).ready(function() {
                    var mensaje = '<?php echo $mensajeModal; ?>';
                    var modalId = mensaje.includes('Error') ? '#modalError' : '#modalExito';
                    $(modalId).modal('show');
                });
            <?php endif; ?>
        </script>
</body>
</html>
