<?php
include '../PHP/funciones.php';
$clientes = obtenerClientes();

// Obtener mensajes de la URL
$mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkHub CRM</title>
    <link rel="stylesheet" href="../CSS/EditContactos.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .modal-dialog {
            top: 20%;
        }
    </style>
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
                        <th>Acciones</th>
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
                            echo "<td>
                                        <button class='btn btn-success btn-sm' onclick=\"window.location.href='Editar_Cliente.php?id=" . $cliente['ID_Cliente'] . "'\">EDITAR INFORMACIÓN</button>
                                        <button class='eliminar-cliente-btn' onclick=\"window.location.href='eliminar_cliente.php?id=" . $cliente['ID_Cliente'] . "'\">ELIMINAR INFORMACIÓN</button>
                                      </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No se encontraron registros</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <?php if ($mensaje): ?>
        <div class="modal fade" id="resultadoModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel"><?php echo $tipo === 'success' ? 'Éxito' : 'Error'; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo $mensaje; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.href='EditContactos.php'">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            // Mostrar el modal al cargar la página
            $(document).ready(function() {
                <?php if ($mensaje): ?>
                    $('#resultadoModal').modal('show');
                <?php endif; ?>
            });
        </script>
    </div>
</body>

</html>
