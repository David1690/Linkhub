<?php
include '../PHP/funciones.php';

$contactoGuardado = false;  // Variable para verificar si el contacto fue guardado
$mostrarError = false;     // Variable para verificar si se debe mostrar un mensaje de error

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $apellido = isset($_POST['apellido']) ? $_POST['apellido'] : '';
    $correo = isset($_POST['email']) ? $_POST['email'] : '';
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
    $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';
    $edad = isset($_POST['edad']) ? $_POST['edad'] : '';
    $tipoCliente = isset($_POST['typeCli']) ? $_POST['typeCli'] : '';

    // Validar los campos
    if (empty($nombre) || empty($apellido) || empty($correo) || empty($telefono) || empty($direccion) || empty($edad) || empty($tipoCliente)) {
        header("Location: contacto.php?status=error&message=Todos los campos son obligatorios");
        exit();
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        header("Location: contacto.php?status=error&message=Correo electrónico no válido");
        exit();
    } elseif (!filter_var($telefono, FILTER_VALIDATE_INT) || !filter_var($edad, FILTER_VALIDATE_INT)) {
        header("Location: contacto.php?status=error&message=El teléfono y la edad deben ser números");
        exit();
    } else {
        // Guardar los datos
        if (guardarCliente($nombre, $apellido, $correo, $telefono, $direccion, $edad, $tipoCliente)) {
            header("Location: contacto.php?status=success");
        } else {
            header("Location: contacto.php?status=error&message=Hubo un error al guardar el contacto");
        }
        exit();
    }
}
?>
