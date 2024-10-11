<?php
include_once '../PHP/funciones.php'; // Asegúrate de que esta función conecta a la BD correctamente

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
            header("Location: alta_empresas.php?nombreUsuario=" . urlencode($nombreUsuario));
            exit(); // Detiene la ejecución del script
        } else {
            // Contraseña o correo incorrectos
            header("Location: alta_empresas.php?error=1");
            exit(); // Detiene la ejecución del script
        }
    } else {
        // No se encontró al trabajador
        header("Location: alta_empresas.php?error=1");
        exit(); // Detiene la ejecución del script
    }
}
?>
