<?php
include_once '../PHP/funciones.php';
include_once '../PHP/v_login.php';
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkHub CRM</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/index_emp.css">
</head>

<body>

    <!-- Contenedor para los botones de cerrar sesión y empresas -->
    <div class="btn-container">
        <button type="button" class="btn btn-success" onclick="window.location.href='altas_trabajadores.php'">Crear cuentas</button>
        <!-- Botón de cerrar sesión -->
        <button class="btn btn-danger" onclick="window.location.href='../HTML/login.php'">Cerrar Sesión</button>
    </div>

    <div class="container">
        <div class="header">
            <img src="../IMG/LOGO_LinkHub_sf.png" alt="Logo LinkHub" class="logo">
            <h1 class="mt-4">LinkHub CRM</h1>
        </div>

        <!-- Menú de navegación -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">INICIO</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="alta_empresas.php">Empresas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contratos.php">Contratos</a>
                    </li>
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
    </div>

    <br><br>
    <!-- Tarjeta para Modo Ventas Individuales -->
    <div class="card" style="width: 18rem;">
        <img src="../IMG/Empresas.jpg" class="card-img-top" alt="Imagen Empresas">
        <div class="card-body">
            <h5 class="card-title">Modo ventas individuales</h5>
            <p class="card-text">Optimiza la gestión de tus clientes identificando a aquellos compradores individuales y estableciendo relaciones más sólidas con las empresas que forman parte de tu negocio.</p>
            <a href="#" class="btn btn-success" onclick="mostrarLoader()">Acceder</a>
        </div>
    </div>

    <!-- Contenedor de la animación de carga (inicialmente oculto) -->
    <div id="loader" class="loader-container" style="display: none;">
        <div class="loader"></div>
    </div>

    <!-- Modal de bienvenida -->
    <?php if (isset($_GET['nombreUsuario'])): ?>
        <div class="modal fade" id="welcomeModal" tabindex="-1" role="dialog" aria-labelledby="welcomeModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="welcomeModalLabel">Bienvenido</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Bienvenido: <?php echo htmlspecialchars($_GET['nombreUsuario']); ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- JavaScript para mostrar loader y redirigir después de 8 segundos -->
    <script>
        function mostrarLoader() {
            // Mostrar el contenedor del loader
            document.getElementById('loader').style.display = 'flex';

            // Esperar 8 segundos y luego redirigir a la página principal
            setTimeout(function () {
                window.location.href = '../HTML/contacto.php';
            }, 1500); // 1500 milisegundos = 1.5 segundos
        }

        // Mostrar el modal si existe el parámetro 'nombreUsuario' en la URL
        <?php if (isset($_GET['nombreUsuario'])): ?>
            $(document).ready(function () {
                $('#welcomeModal').modal('show');
            });
        <?php endif; ?>
    </script>

</body>

</html>
