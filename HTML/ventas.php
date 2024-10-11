<?php
include '../PHP/funciones.php';

// Conexión a la base de datos
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

// Consulta para obtener los clientes
$clientes_query = "SELECT ID_Cliente, Nombre, Apellido FROM CLIENTES";
$clientes_result = mysqli_query($conn, $clientes_query);

// Consulta para obtener los trabajadores
$trabajadores_query = "SELECT ID_Trabajador, Namefull FROM TRABAJADORES";
$trabajadores_result = mysqli_query($conn, $trabajadores_query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkHub CRM</title>
    <link rel="stylesheet" href="..\CSS\ventas.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .lelo{
            margin-left: 50px !important;
        }
    </style>
</head>
<body>
    <div class="btn-container">
        <!-- Botones de navegación -->
        <button type="button" class="btn btn-success btn-special" onclick="window.location.href='altas_trabajadores.php'">Crear cuentas</button>
        <button class="btn btn-danger btn-special" onclick="window.location.href='login.php'">Cerrar Sesión</button>
    </div>

    <div class="container">
        <!-- Encabezado con logo y título -->
        <div class="header">
            <img src="../IMG/LOGO_LinkHub_sf.png" alt="Logo LinkHub" class="logo">
            <h1 class="mt-4">LinkHub CRM</h1>
        </div>

        <!-- Menú de navegación -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">VENTAS</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="soporte.php">Soporte</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reportes.php">Reportes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contacto.php">Contactos</a>
                    </li>
                </ul>
            </div>
        </nav>
        
        <!-- Sección de gestión de ventas -->
        <div class="lelo">
            <div id="ventas" class="mt-4">
                <h2>Gestión de Ventas</h2>
                <form action="../PHP/procesar_venta.php" method="POST" onsubmit="mostrarModal();">
                    <div class="form-group">
                        <label for="producto">Producto:</label>
                        <input type="text" class="form-control" id="producto" name="producto" placeholder="Producto o servicio" required>
                    </div>
                    <div class="form-group">
                        <label for="precio">Precio:</label>
                        <input type="number" class="form-control" id="precio" name="precio" placeholder="Precio del producto" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado de la Venta:</label>
                        <select class="form-control" id="estado" name="estado" required>
                            <option value="En Proceso">En Proceso</option>
                            <option value="Finalizada">Finalizada</option>
                            <option value="Cancelada">Cancelada</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cliente">Cliente que Adquiere el Producto:</label>
                        <select class="form-control" id="cliente" name="cliente" required>
                            <?php while ($row = mysqli_fetch_assoc($clientes_result)) { ?>
                                <option value="<?php echo $row['ID_Cliente']; ?>">
                                    <?php echo $row['Nombre'] . ' ' . $row['Apellido']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="vendedor">Vendedor que gestiona la venta:</label>
                        <select class="form-control" id="vendedor" name="vendedor" required>
                            <?php while ($row = mysqli_fetch_assoc($trabajadores_result)) { ?>
                                <option value="<?php echo $row['ID_Trabajador']; ?>">
                                    <?php echo $row['Namefull']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-custom">Guardar Venta</button>
                    <button type="button" class="btn btn-success btn-custom" onclick="window.location.href='ver_ventas.php'">Ver registro de ventas</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación -->
    <div class="modal fade" id="modalConfirmacion" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Confirmación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas guardar esta venta?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="enviarFormulario()">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts para el manejo del modal -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function mostrarModal() {
            // Evitar que el formulario se envíe de inmediato
            event.preventDefault();

            // Mostrar el modal para pedir confirmación
            $('#modalConfirmacion').modal('show');
        }

        function enviarFormulario() {
            // Envía el formulario una vez confirmada la acción en el modal
            document.querySelector('form').submit();
        }
    </script>
</body>
</html>
