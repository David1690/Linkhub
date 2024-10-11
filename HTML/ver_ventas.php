<?php
include '../PHP/funciones.php';

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

// Actualizar el estado de la venta o eliminarla si se envía una solicitud
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'], $_POST['id_venta'])) {
        $id_venta = mysqli_real_escape_string($conn, $_POST['id_venta']);
        $action = $_POST['action'];

        if ($action == 'finalizar') {
            $update_query = "UPDATE ventas SET Estado = 'Finalizada' WHERE ID_Ventas = '$id_venta'";
            mysqli_query($conn, $update_query);
        } elseif ($action == 'cancelar') {
            $update_query = "UPDATE ventas SET Estado = 'Cancelada' WHERE ID_Ventas = '$id_venta'";
            mysqli_query($conn, $update_query);
        } elseif ($action == 'eliminar') {
            $delete_query = "DELETE FROM ventas WHERE ID_Ventas = '$id_venta'";
            mysqli_query($conn, $delete_query);
        }
    }
}

// Consulta para obtener datos de ventas
$consulta = "
    SELECT 
        v.ID_Ventas,
        v.Producto,
        v.Precio,
        v.Estado,
        c.Nombre AS Nombre_Cliente,
        t.Namefull AS Nombre_Trabajador
    FROM ventas v
    INNER JOIN clientes c ON v.ID_Cliente = c.ID_Cliente
    INNER JOIN trabajadores t ON v.ID_Trabajador = t.ID_Trabajador
";
$resultado = mysqli_query($conn, $consulta);

// Verificar si la consulta devolvió resultados
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkHub CRM</title>
    <link rel="stylesheet" href="../CSS/cont_res.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>

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
                        <a class="nav-link" href="ventas.php">Regresar</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Tabla de ventas -->
        <div class="mt-4">
            <h2>Datos de Ventas</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID de la venta</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Estado de la venta</th>
                        <th>Cliente</th>
                        <th>Trabajador</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($resultado) {
                        while ($fila = mysqli_fetch_assoc($resultado)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($fila['ID_Ventas']) . "</td>";
                            echo "<td>" . htmlspecialchars($fila['Producto']) . "</td>";
                            echo "<td>" . htmlspecialchars($fila['Precio']) . "</td>";
                            echo "<td>" . htmlspecialchars($fila['Estado']) . "</td>";
                            echo "<td>" . htmlspecialchars($fila['Nombre_Cliente']) . "</td>";
                            echo "<td>" . htmlspecialchars($fila['Nombre_Trabajador']) . "</td>";
                            echo "<td>
                                    <form method='POST'>
                                        <input type='hidden' name='id_venta' value='" . $fila['ID_Ventas'] . "'>
                                        <button type='submit' name='action' value='finalizar' class='btn btn-success'>Finalizar</button>
                                        <button type='submit' name='action' value='cancelar' class='btn btn-warning'>Cancelar</button>
                                        <button type='submit' name='action' value='eliminar' class='btn btn-danger'>Eliminar</button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No se encontraron resultados.</td></tr>";
                    }

                    // Cerrar la conexión
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
