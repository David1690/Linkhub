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

// Consulta para obtener los datos de soporte con nombres de clientes y trabajadores
$query = "SELECT s.ID_Soporte, c.Nombre AS NombreCliente, c.Apellido AS ApellidoCliente, 
                 t.Namefull AS NombreTrabajador, s.Asunto, s.Descripcion 
          FROM soporte s 
          JOIN clientes c ON s.ID_Cliente = c.ID_Cliente
          JOIN trabajadores t ON s.ID_Trabajador = t.ID_Trabajador";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkHub CRM</title>
    <link rel="stylesheet" href="../CSS/soporte.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .lelo{
margin-left: 50px !important;
}
    </style>
</head>

<body>
    <div class="btn-container">
        <button type="button" class="btn btn-success btn-special" onclick="window.location.href='altas_trabajadores.php'">Crear cuentas</button>
        <button class="btn btn-danger btn-special" onclick="window.location.href='login.php'">Cerrar Sesión</button>
    </div>

    <div class="container">
        <div class="header">
            <img src="../IMG/LOGO_LinkHub_sf.png" alt="Logo LinkHub" class="logo">
            <h1 class="mt-4">LinkHub CRM - Soporte</h1>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">SOPORTE</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="reportes.php">Reportes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contacto.php">Contactos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ventas.php">Ventas</a>
                    </li>
                </ul>
            </div>
        </nav>
    <div  class="lelo">
        <div class="mt-4">
            <h2>Registros de Soporte</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Numero de caso</th>
                        <th>Cliente</th>
                        <th>Trabajador</th>
                        <th>Asunto</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['ID_Soporte']; ?></td>
                            <td><?php echo $row['NombreCliente'] . ' ' . $row['ApellidoCliente']; ?></td>
                            <td><?php echo $row['NombreTrabajador']; ?></td>
                            <td><?php echo $row['Asunto']; ?></td>
                            <td><?php echo $row['Descripcion']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
