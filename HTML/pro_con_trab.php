<?php
include '../PHP/funciones.php';

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

// Inicializar variables
$contactoGuardado = false;
$mostrarError = false;
$mensajeError = "";

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $edad = $_POST['edad'];
    $typeCli = $_POST['typeCli'];

    // Insertar datos en la base de datos
    $sql = "INSERT INTO clientes (Nombre, Apellido, Correo, Telefono, Direccion, Edad, TypeClient) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Preparar y enlazar parámetros
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisis", $nombre, $apellido, $email, $telefono, $direccion, $edad, $typeCli);

    if ($stmt->execute()) {
        // Si se guardó correctamente, mostrar el modal de éxito
        $contactoGuardado = true;
    } else {
        // Si hubo un error, mostrar el modal de error
        $mostrarError = true;
        $mensajeError = "Error al guardar el contacto: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
