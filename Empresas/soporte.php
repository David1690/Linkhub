<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkHub CRM</title>
    <link rel="stylesheet" href="../CSS/soporte_emp.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @font-face {
            font-family: "hidayatullah";
            src: url(../font/Roboto-Italic.ttf);
        }

        /* Estilos generales */
        body {
            font-family: "hidayatullah", Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        /* Encabezado */
        .header {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .logo {
            width: 150px;
        }

        /* Título */
        .header h1 {
            color: #343a40;
            margin: 0;
            text-align: left;
            margin-top: 10px;
        }

        /* Estilo del contenedor principal */
        .container {
            position: relative;
            width: 100%;
            max-width: 900px !important;
            min-height: 900px !important;
            background: #fff;
            margin: 50px auto;
            box-shadow: 0 35px 55px #81689D;
            border-radius: 10px;
            padding: 20px;
        }

        /* Estilo del formulario */
        .form-group {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 15px;
            width: 100%;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        select {
            width: 40%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            transition: border-color 0.3s;
            margin-bottom: 10px;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="number"]:focus,
        select:focus {
            border-color: #80bdff;
            outline: none;
        }

        .btn-container {
            display: flex;
            flex-direction: row-reverse;
            align-items: flex-end;
        }

        .btn-custom {
            border: 1px solid #000 !important;
            border-radius: 5px !important;
            padding: 10px 20px !important;
            margin: 5px !important;
        }
        .lelo{
margin-left: 50px !important;
}
    </style>
</head>

<body>
    <div class="btn-container">
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
                        <a class="nav-link" href="reportes.php">Reportes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="alta_empresas.php">Empresas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ventas.php">Ventas</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div  class="lelo">
        <div id="soporte" class="mt-4">
            <form action="../HTML/pro_sop_trab.php" method="POST" onsubmit="mostrarModal(event)">
                <div class="form-group">
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
                    ?>
                </div>

                <div class="mt-4">
                    <h2>Reportes de Soporte Empresarial</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID Soporte</th>
                                <th>Empresa</th>
                                <th>Trabajador</th>
                                <th>Asunto</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Consultar la tabla soporteempresarial
                            $soporte_query = "
                                SELECT s.ID_SoporteEmp, e.Nom_Empresa, t.Namefull, s.Asunto, s.Descripcion 
                                FROM soporteempresarial s
                                JOIN empresas e ON s.ID_Empresas = e.ID_Empresas
                                JOIN trabajadores t ON s.ID_Trabajador = t.ID_Trabajador";
                            $resultado_soporte = $conn->query($soporte_query);

                            if ($resultado_soporte->num_rows > 0) {
                                while ($fila = $resultado_soporte->fetch_assoc()) {
                                    echo "<tr>
                                            <td>" . $fila['ID_SoporteEmp'] . "</td>
                                            <td>" . $fila['Nom_Empresa'] . "</td>
                                            <td>" . $fila['Namefull'] . "</td>
                                            <td>" . $fila['Asunto'] . "</td>
                                            <td>" . $fila['Descripcion'] . "</td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No hay reportes disponibles</td></tr>";
                            }

                            // Cerrar conexión
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function mostrarModal(event) {
            event.preventDefault();
            $('#ventaModal').modal('show');
            // Enviar el formulario después de mostrar el modal
            setTimeout(() => {
                event.target.submit();
            }, 1000);
        }
    </script>
</body>

</html>
