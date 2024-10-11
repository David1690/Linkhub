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
    $id_cliente = mysqli_real_escape_string($conn, $_POST['cliente']);
    $id_trabajador = mysqli_real_escape_string($conn, $_POST['vendedor']);
    $asunto = mysqli_real_escape_string($conn, $_POST['asunto']);
    $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);

    // Inserta el soporte en la tabla SOPORTE
    $query = "INSERT INTO soporte (ID_Cliente, ID_Trabajador, Asunto, Descripcion) 
              VALUES ('$id_cliente', '$id_trabajador', '$asunto', '$descripcion')";

    // Ejecuta la consulta y verifica el resultado
    if (mysqli_query($conn, $query)) {
        // Si la inserción fue exitosa, redirige a la página de soporte con un mensaje de éxito
        header('Location: ../HTML/soporte_trab.php?mensaje=Solicitud+de+soporte+enviada+correctamente');
        exit(); // Asegúrate de salir después de redirigir
    } else {
        // Si hubo un error en la inserción, muestra un mensaje de error
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }

} else {
    // Si no se recibieron los datos, redirige de nuevo con un mensaje de error
    header('Location: ../HTML/soporte_trab.php?mensaje=Error+al+enviar+la+solicitud');
    exit();
}

// Cierra la conexión a la base de datos
mysqli_close($conn);
?>
