<?php
include '../PHP/funciones.php'; // Asegúrate de que esta función inicialice la conexión a la base de datos correctamente.

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

// Consulta para obtener los datos de empresas
$queryEmpresas = "SELECT ID_Empresas, Nom_Empresa FROM empresas";
$resultEmpresas = mysqli_query($conn, $queryEmpresas);

// Consulta para obtener los trabajadores con TypeAccount 'Trabajador'
$queryTrabajadores = "SELECT ID_Trabajador, Namefull FROM trabajadores WHERE TypeAccount = 'Trabajador'";
$resultTrabajadores = mysqli_query($conn, $queryTrabajadores);

// Procesar el formulario al enviarlo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idEmpresa = $_POST['empresa'];
    $idTrabajador = $_POST['trabajador'];
    $asunto = $_POST['asunto'];
    $descripcion = $_POST['descripcion'];

    // Consulta para insertar en la tabla soporteempresarial
    $insertQuery = "INSERT INTO soporteempresarial (ID_Empresas, ID_Trabajador, Asunto, Descripcion) 
                    VALUES ('$idEmpresa', '$idTrabajador', '$asunto', '$descripcion')";
    
    if ($conn->query($insertQuery) === TRUE) {
        echo "<script>alert('Reporte enviado con éxito');</script>";
    } else {
        echo "<script>alert('Error al enviar el reporte: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkHub CRM</title>
    <link rel="stylesheet" href="../CSS/soporte_emp.css">
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
            border: 1px solid #000 !important; /* Borde de 5 píxeles, puedes cambiar el color */
            border-radius: 5px !important; /* Borde redondeado, opcional */
            padding: 10px 20px !important; /* Espaciado interno para mayor comodidad */
            margin: 5px !important; /* Espaciado entre los botones */
        }

        /* Estilo para el modal */
        .modal-header {
            background-color: #343a40;
            color: white;
        }
        .lelo{
margin-left: 50px !important;
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
        <!-- Aquí puedes añadir otros botones si lo deseas -->
    </div>

    <div class="container">
        <div class="header">
            <img src="../IMG/LOGO_LinkHub_sf.png" alt="Logo LinkHub" class="logo">
            <h1 class="mt-4">LinkHub CRM </h1>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">SOPORTE</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="alta_trab_empresas.php">Empresas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ventas_trab_emp.php">Ventas</a>
                    </li>
                </ul>
            </div>
        </nav>
        <br>
        <br>
        <div  class="lelo">
        <form id="reportForm" method="POST" onsubmit="return confirmSubmit();">
        <h2>Soporte al Cliente</h2>
            <div class="form-group">
                <label for="empresa">EMPRESA ASOCIADA AL PROBLEMA</label>
                <select name="empresa" id="empresa" required>
                    <option value="">Seleccione una empresa</option>
                    <?php while ($row = mysqli_fetch_assoc($resultEmpresas)): ?>
                        <option value="<?= $row['ID_Empresas']; ?>"><?= $row['Nom_Empresa']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="trabajador">TRABAJADOR QUE GENERA EL REPORTE</label>
                <select name="trabajador" id="trabajador" required>
                    <option value="">Seleccione un trabajador</option>
                    <?php while ($row = mysqli_fetch_assoc($resultTrabajadores)): ?>
                        <option value="<?= $row['ID_Trabajador']; ?>"><?= $row['Namefull']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="asunto">ASUNTO</label>
                <input type="text" name="asunto" id="asunto" placeholder="Asunto del soporte" required>
            </div>

            <div class="form-group">
                <label for="descripcion">DESCRIPCIÓN</label>
                <input type="text" name="descripcion" id="descripcion" placeholder="Descripción del problema" required>
            </div>

            <button type="submit" class="btn btn-primary btn-custom">Enviar Reporte</button>
        </form>
    </div>
</div>
    <!-- Modal de confirmación -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirmación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Está seguro de que desea enviar este reporte?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirmButton">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function confirmSubmit() {
            $('#confirmModal').modal('show');
            return false; // Evitar que el formulario se envíe automáticamente
        }

        document.getElementById('confirmButton').addEventListener('click', function() {
            document.getElementById('reportForm').submit(); // Enviar el formulario al confirmar
        });
    </script>
</body>

</html>
