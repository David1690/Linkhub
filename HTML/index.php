<?php
include_once '../PHP/funciones.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['email'];
    $contrasena = $_POST['password'];

    // Conectar a la base de datos
    $conn = conectarBD(); // Función que retorna la conexión válida a la BD

    // Consulta para obtener el trabajador
    $sql = "SELECT * FROM trabajadores WHERE Correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Obtener los datos del trabajador
        $trabajador = $result->fetch_assoc();

        // Comparar la contraseña proporcionada por el usuario con el hash almacenado
        $hashAlmacenado = $trabajador['Pass'];
        $sha1Contrasena = sha1($contrasena); // Encriptamos la contraseña proporcionada

        if (password_verify($sha1Contrasena, $hashAlmacenado)) {
            // Las credenciales son válidas, iniciar sesión
            session_start();
            $_SESSION['trabajador_id'] = $trabajador['ID_Trabajador'];
            $nombreUsuario = $trabajador['Username'];

            // Redirigir al usuario a la página de inicio
            header("Location: contacto_trab.php?nombreUsuario=" . urlencode($nombreUsuario));
            exit(); // Detiene la ejecución del script
        } else {
            // Contraseña o correo incorrectos
            header("Location: index.php?error=1");
            exit(); // Detiene la ejecución del script
        }
    } else {
        // No se encontró al trabajador
        header("Location: index.php?error=1");
        exit(); // Detiene la ejecución del script
    }
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Trabajadores - LinkHub CRM</title>
    <link rel="stylesheet" href="../CSS/login.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
               body {
background: url(../IMG/Oficina.jpg);
background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Iniciar Sesión - Trabajadores</h2>
        <form action="index.php" method="POST">
            <div class="form-group">
                <input type="email" class="form-control" id="email" name="email" placeholder=" " required>
                <label for="email">Correo Electrónico</label>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" id="password" name="password" placeholder=" " required>
                <label for="password">Contraseña</label>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
            <br><br>
        <button onclick="window.location.href='login.php';" class="btn btn-secondary">Cambiar a Login Administradores</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
