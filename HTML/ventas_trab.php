<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkHub CRM</title>
    <link rel="stylesheet" href="..\CSS\ventas_trab.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @font-face {
            font-family: "hidayatullah";
            src: url(../font/Roboto-Italic.ttf);
        }
        .lelo {
            margin-left: 30px;
        }
    </style>
</head>

<body>
    <div class="btn-container">
        <button class="btn btn-danger btn-special" onclick="window.location.href='index.php'">Cerrar Sesión</button>
    </div>

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
                        <a class="nav-link" href="soporte_trab.php">Soporte</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contacto_trab.php">Contactos</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="lelo">
            <div id="ventas" class="mt-4">
                <h2>Gestión de Ventas</h2>
                <form id="ventaForm" action="pro_ven_trab.php" method="POST">
                    <div class="form-group">
                        <label for="producto">Producto:</label>
                        <input type="text" class="form-control" id="producto" name="producto" placeholder="Producto o servicio" required>
                    </div>
                    <div class="form-group">
                        <label for="precio">Precio:</label>
                        <input type="number" class="form-control" id="precio" name="precio" placeholder="Precio del producto" required>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado de la Venta:</label>
                        <select class="form-control" id="estado" name="estado" required>
                            <option value="En Proceso">En Proceso</option>
                            <option value="Finalizada">Finalizada</option>
                            <option value="Cancelada">Cancelada</option>
                        </select>
                    </div>

                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = ""; 
                    $database = "linkhub";
                    $conn = new mysqli($servername, $username, $password, $database);
                    if ($conn->connect_error) {
                        die("Error en la conexión: " . $conn->connect_error);
                    }

                    // Consultar los clientes
                    $clientes_query = "SELECT ID_Cliente, Nombre, Apellido FROM clientes";
                    $resultado_clientes = $conn->query($clientes_query);

                    // Consultar los vendedores (trabajadores)
                    $vendedores_query = "SELECT ID_Trabajador, Namefull FROM trabajadores WHERE TypeAccount = 'Trabajador'";
                    $resultado_vendedores = $conn->query($vendedores_query);
                    ?>

                    <!-- Select de clientes -->
                    <div class="form-group">
                        <label for="cliente">Cliente que Adquiere el Producto:</label>
                        <select class="form-control" id="cliente" name="cliente" required>
                            <?php
                            if ($resultado_clientes->num_rows > 0) {
                                while ($fila = $resultado_clientes->fetch_assoc()) {
                                    echo "<option value='" . $fila['ID_Cliente'] . "'>" . $fila['Nombre'] . " " . $fila['Apellido'] . "</option>";
                                }
                            } else {
                                echo "<option>No hay clientes disponibles</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Select de vendedores -->
                    <div class="form-group">
                        <label for="vendedor">Vendedor que gestiona la venta:</label>
                        <select class="form-control" id="vendedor" name="vendedor" required>
                            <?php
                            if ($resultado_vendedores->num_rows > 0) {
                                while ($fila = $resultado_vendedores->fetch_assoc()) {
                                    echo "<option value='" . $fila['ID_Trabajador'] . "'>" . $fila['Namefull'] . "</option>";
                                }
                            } else {
                                echo "<option>No hay vendedores disponibles</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary btn-custom">Guardar Venta</button>
                    <button type="button" class="btn btn-success btn-custom" onclick="window.location.href='ver_ventas_tra.php'">Seguimiento de ventas</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
