<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkHub CRM</title>
    <link rel="stylesheet" href="../CSS/soporte_trab.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @font-face {
            font-family: "hidayatullah";
            src: url(../font/Roboto-Italic.ttf);
        }
        .lelo{
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
            <a class="navbar-brand" href="#">SOPORTE</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="contacto_trab.php">Contactos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ventas_trab.php">Ventas</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="lelo">
            <div id="soporte" class="mt-4">
                <h2>Soporte al Cliente</h2>
                <form action="pro_sop_trab.php" method="POST" id="formSoporte" onsubmit="mostrarModal(event)">
                    <div class="form-group">
                        <label for="cliente">Cliente:</label>
                        <select class="form-control" id="cliente" name="cliente" required>
                            <?php
                            // Conexión a la base de datos
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $database = "linkhub";
                            $conn = new mysqli($servername, $username, $password, $database);

                            // Verificar conexión
                            if ($conn->connect_error) {
                                die("Error en la conexión: " . $conn->connect_error);
                            }

                            // Consultar los clientes
                            $clientes_query = "SELECT ID_Cliente, Nombre, Apellido FROM clientes"; 
                            $resultado_clientes = $conn->query($clientes_query);

                            if ($resultado_clientes->num_rows > 0) {
                                while ($fila = $resultado_clientes->fetch_assoc()) {
                                    echo "<option value='" . $fila['ID_Cliente'] . "'>" . $fila['Nombre'] . " " . $fila['Apellido'] . "</option>";
                                }
                            } else {
                                echo "<option>No hay clientes disponibles</option>";
                            }

                            // Cerrar conexión
                            $conn->close();
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="vendedor">Trabajador que genera el reporte:</label>
                        <select class="form-control" id="vendedor" name="vendedor" required>
                            <?php
                            // Conexión a la base de datos
                            $conn = new mysqli($servername, $username, $password, $database);

                            // Consultar los vendedores
                            $vendedores_query = "SELECT ID_Trabajador, Namefull FROM trabajadores WHERE TypeAccount = 'Trabajador'";
                            $resultado_vendedores = $conn->query($vendedores_query);

                            if ($resultado_vendedores->num_rows > 0) {
                                while ($fila = $resultado_vendedores->fetch_assoc()) {
                                    echo "<option value='" . $fila['ID_Trabajador'] . "'>" . $fila['Namefull'] . "</option>";
                                }
                            } else {
                                echo "<option>No hay vendedores disponibles</option>";
                            }

                            // Cerrar conexión
                            $conn->close();
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="asunto">Asunto:</label>
                        <input type="text" class="form-control" id="asunto" name="asunto" placeholder="Asunto del soporte" required>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción:</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Descripción del problema" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-custom">Enviar Solicitud</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación -->
    <div class="modal fade" id="ventaModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Confirmación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Solicitud Enviada Exitosamente
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="confirmarEnvio">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function mostrarModal(event) {
            event.preventDefault(); // Evita que se envíe el formulario inmediatamente
            $('#ventaModal').modal('show'); // Muestra el modal
        }

        // Confirmar el envío
        document.getElementById('confirmarEnvio').addEventListener('click', function () {
            document.getElementById('formSoporte').submit(); // Envía el formulario
        });
    </script>
</body>

</html>
