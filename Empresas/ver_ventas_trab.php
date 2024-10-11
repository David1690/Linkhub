<?php
// Conexión a la base de datos
require_once '../PHP/funciones.php'; 

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

// Procesar acciones de actualización o eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $id_venta = $_POST['id_venta'];

        if ($_POST['action'] === 'finalizada') {
            $updateQuery = "UPDATE empresaventas SET EstadoVenta = 'Finalizada' WHERE ID_VentasEmpresa = ?";
        } elseif ($_POST['action'] === 'cancelada') {
            $updateQuery = "UPDATE empresaventas SET EstadoVenta = 'Cancelada' WHERE ID_VentasEmpresa = ?";
        } elseif ($_POST['action'] === 'eliminar') {
            $deleteQuery = "DELETE FROM empresaventas WHERE ID_VentasEmpresa = ?";
            $stmt = $conn->prepare($deleteQuery);
            $stmt->bind_param('i', $id_venta);
            $stmt->execute();
            $stmt->close();
        }

        if (isset($updateQuery)) {
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param('i', $id_venta);
            $stmt->execute();
            $stmt->close();
        }

        // Redireccionar a la misma página para evitar reenvío de formulario
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Consulta para obtener todas las ventas
$queryVentas = "SELECT * FROM empresaventas";
$resultVentas = mysqli_query($conn, $queryVentas);

// Verificar si hay errores en la consulta
if (!$resultVentas) {
    die("Error en la consulta: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkHub CRM - Editar Ventas</title>
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
    padding: 5px 10px !important;
    margin: 5px !important;
    width: 100px; /* Ancho fijo */
    height: 40px; /* Alto fijo, opcional */
    display: inline-block; /* Para que se respeten las dimensiones */
}

    </style>
</head>
<body>

    <div class="btn-container">
    </div>

    <div class="container">
        <div class="header">
            <img src="../IMG/LOGO_LinkHub_sf.png" alt="Logo LinkHub" class="logo">
            <h1 class="mt-4">LinkHub CRM - Editar Ventas</h1>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">VENTAS</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link" href="ventas_trab_emp.php">Regresar</a></li>
                </ul>
            </div>
        </nav>

        <div id="ventas" class="mt-4">
            <h2>Lista de Ventas</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Venta Empresa</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Estado Venta</th>
                        <th>Detalles</th>
                        <th>ID Trabajador</th>
                        <th>ID Empresa</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($resultVentas) == 0): ?>
                        <tr>
                            <td colspan="8">No hay datos disponibles.</td>
                        </tr>
                    <?php else: ?>
                        <?php while ($row = mysqli_fetch_assoc($resultVentas)): ?>
                            <tr>
                                <td><?php echo $row['ID_VentasEmpresa']; ?></td>
                                <td><?php echo $row['Producto']; ?></td>
                                <td><?php echo $row['Precio']; ?></td>
                                <td><?php echo $row['EstadoVenta']; ?></td>
                                <td><?php echo $row['Detalles']; ?></td>
                                <td><?php echo $row['ID_Trabajador']; ?></td>
                                <td><?php echo $row['ID_Empresas']; ?></td>
                                <td>
                                    <form method="post" style="display:inline;">
                                    <input type="hidden" name="id_venta" value="<?php echo $row['ID_VentasEmpresa']; ?>">

<!-- Botón Finalizada -->
<button type="submit" name="action" value="finalizada" class="btn-custom" style="background-color: #28a745;">
    Finalizada
</button>

<!-- Botón Cancelada -->
<button type="submit" name="action" value="cancelada" class="btn-custom" style="background-color: #ffc107;">
    Cancelada
</button>



                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
