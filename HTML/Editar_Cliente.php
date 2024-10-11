<?php
include '../PHP/funciones.php';

$cliente = null;
$mostrarModal = false;  // Variable para controlar la visualización de los modales
$mensajeModal = '';     // Mensaje para mostrar en el modal

if (isset($_GET['id'])) {
    $idCliente = $_GET['id'];
    $cliente = obtenerClientePorId($idCliente);

    if (!$cliente) {
        header('Location: contacto.php?error=cliente_no_encontrado');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['Nombre'];
        $apellido = $_POST['Apellido'];
        $correo = $_POST['Correo'];
        $telefono = $_POST['Telefono'];
        $direccion = $_POST['Direccion'];
        $edad = $_POST['Edad'];
        $tipoCliente = $_POST['TypeClient']; // Asegúrate de que este nombre coincide con el del formulario

        $resultado = actualizarCliente($idCliente, $nombre, $apellido, $correo, $telefono, $direccion, $edad, $tipoCliente);

        if ($resultado) {
            $mostrarModal = true;
            $mensajeModal = 'Cliente actualizado correctamente.';
        } else {
            $mostrarModal = true;
            $mensajeModal = 'Error al actualizar el cliente.';
        }
    }
} else {
    header('Location: contacto.php?error=id_no_proporcionado');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente - LinkHub CRM</title>
    <link rel="stylesheet" href="../CSS/EditContactos.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="container">

        <div class="container">
            <div class="header">
                <img src="../IMG/LOGO_LinkHub_sf.png" alt="Logo LinkHub" class="logo">
                <h1 class="mt-4">LinkHub CRM</h1>
            </div>

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">INICIO</a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="EditContactos.php">Regresar</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="container">
            <h2 class="mt-4">Editar Información del Cliente</h2>

            <?php if ($cliente): ?>
                <form action="" method="POST" class="mt-4">
                    <div class="form-group">
                        <label for="ID_Cliente">ID Cliente</label>
                        <input type="text" class="form-control" id="ID_Cliente"
                            value="<?php echo htmlspecialchars($cliente['ID_Cliente']); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="Nombre">Nombre</label>
                        <input type="text" class="form-control" id="Nombre" name="Nombre"
                            value="<?php echo htmlspecialchars($cliente['Nombre']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="Apellido">Apellido</label>
                        <input type="text" class="form-control" id="Apellido" name="Apellido"
                            value="<?php echo htmlspecialchars($cliente['Apellido']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="Correo">Correo Electrónico</label>
                        <input type="email" class="form-control" id="Correo" name="Correo"
                            value="<?php echo htmlspecialchars($cliente['Correo']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="Telefono">Teléfono</label>
                        <input type="text" class="form-control" id="Telefono" name="Telefono"
                            value="<?php echo htmlspecialchars($cliente['Telefono']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="Direccion">Dirección</label>
                        <input type="text" class="form-control" id="Direccion" name="Direccion"
                            value="<?php echo htmlspecialchars($cliente['Direccion']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="Edad">Edad</label>
                        <input type="number" class="form-control" id="Edad" name="Edad"
                            value="<?php echo htmlspecialchars($cliente['Edad']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Tipo de Cliente</label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="Potencial" name="TypeClient" value="Potencial"
                                <?php echo ($cliente['TypeClient'] === 'Potencial') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="Potencial">Potencial</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="Recurrente" name="TypeClient" value="Recurrente"
                                <?php echo ($cliente['TypeClient'] === 'Recurrente') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="Recurrente">Recurrente</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="Fiel" name="TypeClient" value="Fiel"
                                <?php echo ($cliente['TypeClient'] === 'Fiel') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="Fiel">Fiel</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            <?php else: ?>
                <p class="text-danger">No se encontró el cliente.</p>
            <?php endif; ?>
        </div>

        <!-- Modal de éxito -->
        <div class="modal fade" id="modalExito" tabindex="-1" role="dialog" aria-labelledby="modalExitoLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalExitoLabel">Éxito</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo $mensajeModal; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de error -->
        <div class="modal fade" id="modalError" tabindex="-1" role="dialog" aria-labelledby="modalErrorLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalErrorLabel">Error</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo $mensajeModal; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <script>
            // Mostrar el modal de éxito o error si es necesario
            <?php if ($mostrarModal): ?>
                $(document).ready(function() {
                    var mensaje = '<?php echo $mensajeModal; ?>';
                    var modalId = mensaje.includes('Error') ? '#modalError' : '#modalExito';
                    $(modalId).modal('show');
                });
            <?php endif; ?>
        </script>
    </div>

</body>

</html>
