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
if (isset($_POST['producto'], $_POST['precio'], $_POST['estado'], $_POST['cliente'], $_POST['vendedor'])) {

    // Reseteamos los datos recibidos para evitar inyecciones SQL
    $producto = mysqli_real_escape_string($conn, $_POST['producto']);
    $precio = mysqli_real_escape_string($conn, $_POST['precio']);
    $estado = mysqli_real_escape_string($conn, $_POST['estado']);
    $id_cliente = mysqli_real_escape_string($conn, $_POST['cliente']);
    $id_trabajador = mysqli_real_escape_string($conn, $_POST['vendedor']);

    // Inserta la venta en la tabla VENTAS
    $query = "INSERT INTO VENTAS (Producto, Precio, Estado, ID_Cliente, ID_Trabajador) 
              VALUES ('$producto', '$precio', '$estado', '$id_cliente', '$id_trabajador')";

    // Ejecuta la consulta y verifica el resultado
    if (mysqli_query($conn, $query)) {
        // Si la inserción fue exitosa, redirige a la página de ventas con un mensaje de éxito
        header('Location: ../HTML/ventas.php?mensaje=Venta+registrada+correctamente');
        exit(); // Asegúrate de salir después de redirigir
    } else {
        // Si hubo un error en la inserción, muestra un mensaje de error
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }

} else {
    // Si no se recibieron los datos, redirige de nuevo con un mensaje de error
    header('Location: ../HTML/ventas.php?mensaje=Error+al+registrar+la+venta');
    exit();
}

// Cierra la conexión a la base de datos
mysqli_close($conn);
?>
