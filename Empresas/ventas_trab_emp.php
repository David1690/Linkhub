<?php
// Conexión a la base de datos
require_once '../PHP/funciones.php'; // Asegúrate de que esta ruta sea correcta

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

// Habilitar la visualización de errores de MySQL y PHP
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Consulta para obtener trabajadores
$queryTrabajadores = "SELECT ID_Trabajador, Namefull FROM trabajadores";
$resultTrabajadores = mysqli_query($conn, $queryTrabajadores);

// Consulta para obtener empresas
$queryEmpresas = "SELECT ID_Empresas, Nom_Empresa FROM empresas";
$resultEmpresas = mysqli_query($conn, $queryEmpresas);

// Verificar que los datos del formulario estén presentes
if (isset($_POST['producto'], $_POST['precio'], $_POST['estado'], $_POST['detalles'], $_POST['id_trabajador'], $_POST['id_empresas'])) {

    // Sanitización de los datos
    $producto = $conn->real_escape_string($_POST['producto']);
    $precio = (int) $_POST['precio'];
    $estado = $conn->real_escape_string($_POST['estado']);
    $detalles = $conn->real_escape_string($_POST['detalles']);
    $id_trabajador = (int) $_POST['id_trabajador'];
    $id_empresas = (int) $_POST['id_empresas'];

    // Insertar los datos en la tabla ventasemp
    $query = "INSERT INTO ventasemp (Producto, Precio, EstadoVenta, Detalles, ID_Trabajador, ID_Empresas)
              VALUES ('$producto', $precio, '$estado', '$detalles', $id_trabajador, $id_empresas)";

    if ($conn->query($query) === TRUE) {
        echo "Venta registrada con éxito.";
    } else {
        // Mostrar el error detallado si la consulta falla
        echo "Error al registrar la venta: " . $conn->error;
    }
}
// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkHub CRM</title>
    <link rel="stylesheet" href="../CSS/ventas_emp.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .btn-custom {
            border: 1px solid #000 !important; 
            border-radius: 5px !important; 
            padding: 10px 20px !important;
            margin: 5px !important; 
        }
        .lelo {
            margin-left: 50px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <img src="../IMG/LOGO_LinkHub_sf.png" alt="Logo LinkHub" class="logo">
            <h1 class="mt-4">LinkHub CRM</h1>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">VENTAS</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                        <a class="nav-link" href="soporte_trab_emp.php">Soporte</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="alta_trab_empresas.php">Empresas</a>
                    </li>
                  
                </ul>
            </div>
        </nav>

        <div class="lelo">
            <div id="ventas" class="mt-4">
                <h2>Gestión de Ventas</h2>
                <form id="form-ventas" method="POST">
                    <div class="form-group">
                        <label for="producto">Producto:</label>
                        <input type="text" class="form-control" id="producto" name="producto" maxlength="100" placeholder="Producto o servicio" required>
                    </div>
                    <div class="form-group">
                        <label for="precio">Precio:</label>
                        <input type="number" class="form-control" id="precio" name="precio" placeholder="Precio del producto" required min="0" max="2147483647">
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
                        <label for="detalles">Detalles en la venta:</label>
                        <input type="text" class="form-control" id="detalles" name="detalles" maxlength="100" placeholder="Detalles relacionado a la venta" required>
                    </div>
                    <div class="form-group">
                        <label for="id_trabajador">Trabajador que le da seguimiento a la venta:</label>
                        <select class="form-control" id="id_trabajador" name="id_trabajador" required>
                            <option value="">Seleccione un trabajador</option>
                            <?php while ($row = mysqli_fetch_assoc($resultTrabajadores)): ?>
                                <option value="<?php echo $row['ID_Trabajador']; ?>"><?php echo $row['Namefull']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_empresas">Empresa que adquiere el producto:</label>
                        <select class="form-control" id="id_empresas" name="id_empresas" required>
                            <option value="">Seleccione una empresa</option>
                            <?php while ($row = mysqli_fetch_assoc($resultEmpresas)): ?>
                                <option value="<?php echo $row['ID_Empresas']; ?>"><?php echo $row['Nom_Empresa']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-custom">Registrar Venta</button>
                    <button class="btn btn-danger btn-custom" onclick="window.location.href='ver_ventas_trab.php'">Editar</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Bootstrap -->
    <div class="modal fade" id="modalMensaje" tabindex="-1" aria-labelledby="modalMensajeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMensajeLabel">Registro de Venta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalMensajeBody">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
       $('#form-ventas').on('submit', function(e) {
    e.preventDefault();

    // Deshabilitar el botón de registrar venta para evitar múltiples clics
    $('button[type="submit"]').attr('disabled', 'disabled');

    $.ajax({
        url: 'procesar_ventas.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                $('#modalMensajeBody').text(response.message);
            } else {
                $('#modalMensajeBody').text('Hubo un error al registrar la venta.');
            }
            $('#modalMensaje').modal('show');

            // Volver a habilitar el botón de enviar después de mostrar el mensaje
            $('button[type="submit"]').removeAttr('disabled');
        },
        error: function() {
            $('#modalMensajeBody').text('Error en la conexión.');
            $('#modalMensaje').modal('show');

            // Volver a habilitar el botón de enviar en caso de error
            $('button[type="submit"]').removeAttr('disabled');
        }
    });
});

    </script>

</body>
</html>
