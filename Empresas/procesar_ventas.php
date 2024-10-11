<?php
// Conexión a la base de datos
require_once '../PHP/funciones.php'; // Asegúrate de que esta ruta sea correcta

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

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $producto = $conn->real_escape_string($_POST['producto']);
    $precio = (int)$_POST['precio'];
    $estado = $conn->real_escape_string($_POST['estado']);
    $detalles = $conn->real_escape_string($_POST['detalles']);
    $id_trabajador = (int)$_POST['id_trabajador'];
    $id_empresas = (int)$_POST['id_empresas'];

    // Verificar si ya existe la venta
    $checkSql = "SELECT COUNT(*) as count FROM empresaventas WHERE Producto = '$producto' 
                 AND ID_Trabajador = $id_trabajador 
                 AND ID_Empresas = $id_empresas 
                 AND EstadoVenta = '$estado'";
    $result = $conn->query($checkSql);
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        echo json_encode(['status' => 'error', 'message' => 'La venta ya existe.']);
        exit; // Salir si ya existe
    }

    // Inserción de los datos en la tabla empresaventas
    $sql = "INSERT INTO empresaventas (Producto, Precio, EstadoVenta, Detalles, ID_Trabajador, ID_Empresas) 
            VALUES ('$producto', $precio, '$estado', '$detalles', $id_trabajador, $id_empresas)";

    if ($conn->query($sql) === TRUE) {
        // Si la inserción es exitosa, devolvemos un JSON para manejar la respuesta con JavaScript
        echo json_encode(['status' => 'success', 'message' => 'Venta registrada con éxito.']);
    } else {
        // Si ocurre un error, devolvemos un mensaje de error
        error_log('Error en la inserción: ' . $conn->error); // Registra el error
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $conn->error]);
    }
}

$conn->close();
?>
