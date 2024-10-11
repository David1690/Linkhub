<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Recibir los datos del formulario, validarlos y sanitizarlos
    $namefull = filter_var(trim($_POST['nombreCompleto']), FILTER_SANITIZE_STRING);
    $username = filter_var(trim($_POST['usuario']), FILTER_SANITIZE_STRING);
    $correo = filter_var(trim($_POST['correo']), FILTER_VALIDATE_EMAIL);
    $pass = trim($_POST['password']);
    $tipoCuenta = filter_var(trim($_POST['tipoCuenta']), FILTER_SANITIZE_STRING); // Nuevo campo

    // Validaciones
    if (empty($namefull) || empty($username) || empty($correo) || empty($pass) || empty($tipoCuenta)) {
        $mensajeError = "Todos los campos son obligatorios.";
        $mostrarModalError = true;
    } elseif (!$correo) {
        $mensajeError = "Correo electrónico no válido.";
        $mostrarModalError = true;
    } else {
        // Encriptación de la contraseña usando password_hash
        $passwordHash = password_hash(sha1($pass), PASSWORD_BCRYPT);

        // Verificar si el nombre de usuario o correo ya existen
        $sql = "SELECT * FROM trabajadores WHERE Username = ? OR Correo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $correo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $mensajeError = "El nombre de usuario o el correo electrónico ya están registrados.";
            $mostrarModalError = true;
        } else {
            // Insertar los datos en la base de datos
            $sql = "INSERT INTO trabajadores (Namefull, Username, Correo, Pass, TypeAccount) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $namefull, $username, $correo, $passwordHash, $tipoCuenta); // Añadir el tipo de cuenta

            if ($stmt->execute()) {
                $registroExitoso = true;
            } else {
                $mensajeError = "Error: " . $stmt->error;
                $mostrarModalError = true;
            }
        }

        // Cerrar la conexión
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Trabajadores - LinkHub</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

<!-- Modal de éxito -->
<div class="modal fade" id="modalGuardado" tabindex="-1" role="dialog" aria-labelledby="modalGuardadoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalGuardadoLabel">Éxito</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Contacto guardado correctamente.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"  onclick="window.location.href='../HTML/login.php'">Cerrar</button>
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
                <?php echo isset($mensajeError) ? $mensajeError : ''; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"  onclick="window.location.href='../HTML/altas_trabajadores.php'">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Mostrar modal de éxito si el registro fue exitoso
    <?php if (isset($registroExitoso) && $registroExitoso): ?>
        $(document).ready(function() {
            $('#modalGuardado').modal('show');
        });
    <?php endif; ?>

    // Mostrar modal de error si hubo un error
    <?php if (isset($mostrarModalError) && $mostrarModalError): ?>
        $(document).ready(function() {
            $('#modalError').modal('show');
        });
    <?php endif; ?>
</script>

</body>
</html>
