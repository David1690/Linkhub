<?php
include '../PHP/funciones.php';
// Verificar si se ha enviado el ID del cliente
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_cliente = $_GET['id'];
    
    try {
        // Llamar a la función para eliminar el cliente
        $resultado = eliminarCliente($id_cliente);
        
        // Preparar el mensaje
        if ($resultado) {
            $mensaje = "Cliente eliminado exitosamente.";
            $tipo = "success"; // Éxito
        } else {
            $mensaje = "Error al eliminar el cliente.";
            $tipo = "error"; // Error
        }
    } catch (Exception $e) {
        $mensaje = "No se puede eliminar el cliente porque hay registros relacionados.";
        $tipo = "error"; // Error
    }
} else {
    $mensaje = "ID de cliente no válido.";
    $tipo = "error";
}

// Redirigir a EditContactos.php con el mensaje y tipo
header("Location: EditContactos.php?mensaje=" . urlencode($mensaje) . "&tipo=" . $tipo);
exit;
?>
