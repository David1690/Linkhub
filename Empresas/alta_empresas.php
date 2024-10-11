<?php
$empresaGuardada = null; // Variable para manejar el estado de la operación
$mensajeError = ""; // Variable para manejar el mensaje de error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Configura tu conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = ""; 
    $database = "linkhub";

    // Crear la conexión
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error en la conexión: " . $conn->connect_error);
    }

    // Recoger y sanitizar datos del formulario
    $nombre = $conn->real_escape_string($_POST['nom_empresa']);
    $direccion = $conn->real_escape_string($_POST['direccion']);
    $correoEmp = $conn->real_escape_string($_POST['correo_emp']);
    $cantEmp = $conn->real_escape_string($_POST['cant_emp']);
    $rubro = $conn->real_escape_string($_POST['rubro']);
    $nombreRepresentante = $conn->real_escape_string($_POST['nom_representante']);
    $cargo = $conn->real_escape_string($_POST['cargo']);
    $numTelefono = $conn->real_escape_string($_POST['telefono_representante']);

    // Consulta de inserción
    $sql = "INSERT INTO empresas (Nom_Empresa, Direccion, CorreoEmp, CantEmp, Rubro, NombreRepresentante, Cargo, NumTelefono)
    VALUES ('$nombre', '$direccion', '$correoEmp', '$cantEmp', '$rubro', '$nombreRepresentante', '$cargo', '$numTelefono')";

    if ($conn->query($sql) === TRUE) {
        $empresaGuardada = true; // Empresa guardada correctamente
    } else {
        $empresaGuardada = false; // Ocurrió un error
        $mensajeError = "Error: " . $conn->error; // Mensaje de error
    }

    // Cerrar la conexión
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkHub CRM</title>
    <link rel="stylesheet" href="../CSS/alta_empresa.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Tus estilos aquí */
        /* ... (mantén tus estilos CSS actuales) ... */
   /* Tus estilos aquí */ @font-face {
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
/* Estilo para la barra de navegación */
.navbar {
    justify-content: center !important; /* Centra el contenido de la navbar */
}

.navbar-nav {
    display: flex; /* Habilita Flexbox */
    justify-content: center; /* Centra los elementos en el eje horizontal */
    align-items: center; /* Centra los elementos en el eje vertical */
    gap: 20px; /* Espacio entre cada enlace */
    width: 100%; /* Asegura que ocupe todo el ancho disponible */
}

/* Estilo para los enlaces de la barra de navegación */
.navbar-nav .nav-link {
    text-align: center; /* Asegura que el texto esté centrado */
    color: #000; /* Color de texto negro */
    font-weight: normal; /* Peso de la fuente normal */
    padding: 10px 15px; /* Espaciado para crear el efecto de cuadrado */
    border-radius: 5px; /* Bordes redondeados del cuadrado */
    transition: all 0.3s ease-in-out; /* Suaviza la transición del efecto hover */
    display: block; /* Cambia el enlace a bloque para que ocupe todo el ancho disponible */
}

/* Efecto hover para los enlaces de la navbar */
.navbar-nav .nav-link:hover {
    background-color: #974cc8; /* Fondo color morado */
    color: #000; /* Color de texto negro */
    font-weight: bold; /* Texto en negrita */
}

</style>
</head>
<body>
<div class="btn-container">
        <a href="#" class="btn btn-info btn-special" onclick="mostrarLoader()">Modo ventas individuales</a>
    </div>
    <br><br>   
<div class="container">
    <!-- Formulario -->
    <div class="header">
        <img src="../IMG/LOGO_LinkHub_sf.png" alt="Logo LinkHub" class="logo">
        <h1 class="mt-4">LinkHub CRM</h1>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">EMPRESAS</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="ventas.php">Ventas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="soporte.php">Soporte</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reportes.php">Reportes</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="lelo">
        <div id="contactos" class="mt-4">
            <h2>Gestión de Empresas</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="nombre">Nombre de la empresa:</label>
                    <input type="text" class="form-control" id="nombre" name="nom_empresa" placeholder="Nombre de la empresa" required>
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección:</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección de la empresa" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo Electrónico de la empresa:</label>
                    <input type="email" class="form-control" id="email" name="correo_emp" placeholder="Correo electrónico" required>
                </div>
                <div class="form-group">
                    <label for="cant_emp">Cantidad de empleados:</label>
                    <input type="number" class="form-control" id="cant_emp" name="cant_emp" placeholder="Cantidad de empleados" required>
                </div>
                <div class="form-group">
                    <label for="rubro">Rubro de la empresa:</label>
                    <select class="form-control" id="rubro" name="rubro" required>
                        <option value="Comercio">Comercio</option>
                        <option value="Industria">Industria</option>
                        <option value="Servicios">Servicios</option>
                        <option value="Tecnología">Tecnología</option>
                        <option value="Agropecuario">Agropecuario</option>
                        <option value="Salud">Salud</option>
                        <option value="Finanzas">Finanzas</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nom_representante">Nombre del representante de la empresa:</label>
                    <input type="text" class="form-control" id="nom_representante" name="nom_representante" placeholder="Nombre del representante de la empresa" required>
                </div>
                <div class="form-group">
                    <label for="cargo">Cargo del representante:</label>
                    <select class="form-control" id="cargo" name="cargo" required>
                        <option value="Director General">Director General</option>
                        <option value="Gerente General">Gerente General</option>
                        <option value="Director Comercial">Director Comercial</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="telefono_representante">Número telefónico del representante:</label>
                    <input type="number" class="form-control" id="telefono_representante" name="telefono_representante" placeholder="Número de teléfono del representante" required>
                </div>
                <button type="submit" class="btn btn-primary btn-custom">Guardar</button>
                <button type="button" class="btn btn-success btn-custom" onclick="window.location.href='ver_empresas.php'">Ver listas</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal para mostrar el mensaje de éxito o error -->
<div class="modal fade" id="modalMensaje" tabindex="-1" role="dialog" aria-labelledby="modalMensajeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalMensajeLabel"><?php echo $empresaGuardada ? '¡Éxito!' : 'Error'; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                if ($empresaGuardada) {
                    echo "La empresa ha sido guardada exitosamente.";
                } else {
                    echo "Ocurrió un error al guardar la empresa: " . $mensajeError;
                }
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<div class="loader-container" id="loader" style="display: none;">
        <div class="loader"></div>
    </div>
<script>
    // Mostrar el modal si la operación fue realizada (empresa guardada o error)
    <?php if ($empresaGuardada !== null): ?>
    $(document).ready(function() {
        $('#modalMensaje').modal('show');
    });
    <?php endif; ?>

     // Función para mostrar el loader y redirigir
     function mostrarLoader() {
        // Mostrar el contenedor del loader
        document.getElementById('loader').style.display = 'flex';

        // Esperar 8 segundos y luego redirigir a la página principal
        setTimeout(function () {
            window.location.href = '../HTML/contacto.php';
        }, 1500); // 1.5 segundos
    };
</script>
</body>
</html>
