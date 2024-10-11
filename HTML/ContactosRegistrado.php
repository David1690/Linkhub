<?php
include '../PHP/funciones.php';
$clientes = obtenerClientes();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkHub CRM</title>
    <link rel="stylesheet" href="../CSS/cont_res.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <!-- Botón de cerrar sesión -->

        <div class="container">
            <!-- Encabezado con logo y título -->
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
                            <a class="nav-link" href="contacto.php">Regresar</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="container">
            <h2 class="mt-4">Lista de Clientes</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Cliente</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Correo Electrónico</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Edad</th>
                        <th>Tipo de Cliente</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Mostrar los datos en la tabla
                    if (!empty($clientes)) {
                        foreach ($clientes as $cliente) {
                            echo "<tr>";
                            echo "<td>" . $cliente['ID_Cliente'] . "</td>";
                            echo "<td>" . $cliente['Nombre'] . "</td>";
                            echo "<td>" . $cliente['Apellido'] . "</td>";
                            echo "<td>" . $cliente['Correo'] . "</td>";
                            echo "<td>" . $cliente['Telefono'] . "</td>";
                            echo "<td>" . $cliente['Direccion'] . "</td>";
                            echo "<td>" . $cliente['Edad'] . "</td>";
                            echo "<td>" . $cliente['TypeClient'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No se encontraron registros</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>