<?php
include '../PHP/funciones.php';

// Conexión a la base de datos
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

// Verifica si se recibieron todos los datos del formulario
if (isset($_POST['cliente'], $_POST['vendedor'], $_POST['asunto'], $_POST['descripcion'])) {

    // Reseteamos los datos recibidos para evitar inyecciones SQL
    $id_cliente = $_POST['cliente'];
    $id_trabajador = $_POST['vendedor'];
    $asunto = $_POST['asunto'];
    $descripcion = $_POST['descripcion'];

    // Preparar la consulta
    $stmt = $conn->prepare("INSERT INTO SoporteEmp (ID_Cliente, ID_Trabajador, Asunto, Descripcion) VALUES (?, ?, ?, ?)");

    // Verificar la preparación de la consulta
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    // Vincular los parámetros
    $stmt->bind_param("iiss", $id_cliente, $id_trabajador, $asunto, $descripcion);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Si la inserción fue exitosa, redirige a la página de soporte con un mensaje de éxito
        header('Location: ../HTML/soporte_trab.php?mensaje=Solicitud+de+soporte+enviada+correctamente');
        exit(); // Asegúrate de salir después de redirigir
    } else {
        // Si hubo un error en la inserción, muestra un mensaje de error
        echo "Error: " . $stmt->error;
    }

    // Cerrar la consulta preparada
    $stmt->close();
} else {
    // Si no se recibieron los datos, redirige de nuevo con un mensaje de error
    header('Location: ../HTML/soporte_trab.php?mensaje=Error+al+enviar+la+solicitud');
    exit();
}

// Cierra la conexión a la base de datos
$conn->close();
?>
