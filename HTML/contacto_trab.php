<?php
include '../PHP/funciones.php';

$contactoGuardado = false;  // Variable para verificar si el contacto fue guardado
$mostrarError = false;     // Variable para verificar si se debe mostrar un mensaje de error

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['email'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $edad = $_POST['edad'];
    $tipoCliente = $_POST['typeCli'];

    // Validar que los campos no estén vacíos
    if (empty($nombre) || empty($apellido) || empty($correo) || empty($telefono) || empty($direccion) || empty($edad) || empty($tipoCliente)) {
        $mostrarError = true;
        $mensajeError = "Todos los campos son obligatorios";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mostrarError = true;
        $mensajeError = "El correo electrónico no es válido";
    } elseif (!filter_var($telefono, FILTER_VALIDATE_INT) || !filter_var($edad, FILTER_VALIDATE_INT)) {
        $mostrarError = true;
        $mensajeError = "El teléfono y la edad deben ser números";
    } else {
        // Llamar a la función para guardar el cliente
        if (guardarCliente($nombre, $apellido, $correo, $telefono, $direccion, $edad, $tipoCliente)) {
            $contactoGuardado = true; // El contacto fue guardado
        } else {
            $mostrarError = true;
            $mensajeError = "Hubo un error al guardar el contacto";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkHub CRM</title>
    <link rel="stylesheet" href="../CSS/contacto_trab.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @font-face {
            font-family: "hidayatullah";
            src: url(../font/Roboto-Italic.ttf);
        }

        .loader-container {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .loader {
            border: 16px solid #f3f3f3;
            border-top: 16px solid #3498db;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
        .lelo{
margin-left: 30px;
}
    </style>
</head>

<body>
    <div class="loader-container" id="loader">
        <div class="loader"></div>
    </div>

    <div class="btn-container">
        <a href="#" class="btn btn-info btn-special" onclick="mostrarLoader()">Modo Empresas</a>
        <button class="btn btn-danger btn-special" onclick="window.location.href='index.php'">Cerrar Sesión</button>
    </div>

    <div class="container">
        <div class="header">
            <img src="../IMG/LOGO_LinkHub_sf.png" alt="Logo LinkHub" class="logo">
            <h1 class="mt-4">LinkHub CRM</h1>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">CONTACTOS</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="ventas_trab.php">Ventas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="soporte_trab.php">Soporte</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="lelo">
            <div id="contactos" class="mt-4">
                <h2>Gestión de Contactos</h2>
                <form method="POST" action="" >
                <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                            placeholder="Nombre del cliente" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido:</label>
                        <input type="text" class="form-control" id="apellido" name="apellido"
                            placeholder="Apellido del cliente" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Correo Electrónico:</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Correo electrónico" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="number" class="form-control" id="telefono" name="telefono"
                            placeholder="Número de teléfono" required>
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección:</label>
                        <input type="text" class="form-control" id="direccion" name="direccion"
                            placeholder="Dirección del cliente" required>
                    </div>
                    <div class="form-group">
                        <label for="edad">Edad:</label>
                        <input type="number" class="form-control" id="edad" name="edad" placeholder="Edad del cliente"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="typeCli">Tipo de Cliente:</label>
                        <select class="form-control" id="typeCli" name="typeCli" required>
                            <option value="Potencial">Potencial</option>
                            <option value="Recurrente">Recurrente</option>
                            <option value="Fiel">Fiel</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-custom">Guardar</button>
                </form>
            </div>
        </div>
        </div>

<div class="modal fade" id="modalGuardado" tabindex="-1" role="dialog" aria-labelledby="modalGuardadoLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalGuardadoLabel">Éxito</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Contacto guardado correctamente.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de error -->
<div class="modal fade" id="modalError" tabindex="-1" role="dialog" aria-labelledby="modalErrorLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalErrorLabel">Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo isset($mensajeError) ? $mensajeError : ''; ?>
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
<div class="loader-container" id="loader" style="display: none;">
    <div class="loader"></div>
    </div>


    <script>
        // Mostrar el modal de éxito si el contacto fue guardado correctamente
        <?php if ($contactoGuardado) { ?>
            $(document).ready(function () {
                $("#modalGuardado").modal('show');
            });
        <?php } ?>

        // Mostrar el modal de error si se debe mostrar un mensaje de error
        <?php if ($mostrarError) { ?>
            $(document).ready(function () {
                $("#modalError").modal('show');
            });
        <?php } ?>



        function mostrarLoader() {
            // Mostrar el contenedor del loader
            document.getElementById('loader').style.display = 'flex';

            // Esperar 8 segundos y luego redirigir a la página de empresas
            setTimeout(function () {
                window.location.href = '../Empresas/alta_trab_empresas.php';
            }, 1500); // 1500 milisegundos = 1.5 segundos
        }

    </script>
</body>

</html>