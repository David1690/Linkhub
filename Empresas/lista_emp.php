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

// Consulta para obtener los datos de la tabla empresas
$query = "SELECT ID_Empresas, Nom_Empresa, Direccion, CorreoEmp, CantEmp, Rubro, NombreRepresentante, Cargo, NumTelefono FROM empresas";
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
    <title>LinkHub CRM - Empresas</title>
    <link rel="stylesheet" href="../CSS/alta_empresa.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="btn-container">
        <button type="button" class="btn btn-success btn-special" onclick="window.location.href='alta_empresa.php'">Agregar Empresa</button>
    </div>

    <div class="container">
        <div class="header">
            <img src="../IMG/LOGO_LinkHub_sf.png" alt="Logo LinkHub" class="logo">
            <h1 class="mt-4">LinkHub CRM - Empresas</h1>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">EMPRESAS</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="alta_trab_empresas.php">Regresar</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="mt-4">
            <h2>Registros de Empresas</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre de la Empresa</th>
                        <th>Dirección</th>
                        <th>Correo Electrónico</th>
                        <th>Cantidad de Empleados</th>
                        <th>Rubro</th>
                        <th>Nombre del Representante</th>
                        <th>Cargo</th>
                        <th>Número de Teléfono</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['ID_Empresas']; ?></td>
                            <td><?php echo $row['Nom_Empresa']; ?></td>
                            <td><?php echo $row['Direccion']; ?></td>
                            <td><?php echo $row['CorreoEmp']; ?></td>
                            <td><?php echo $row['CantEmp']; ?></td>
                            <td><?php echo $row['Rubro']; ?></td>
                            <td><?php echo $row['NombreRepresentante']; ?></td>
                            <td><?php echo $row['Cargo']; ?></td>
                            <td><?php echo $row['NumTelefono']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php
// Cerrar conexión
$conn->close();
?>
