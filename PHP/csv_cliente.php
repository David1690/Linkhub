<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
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

    // Consulta para obtener los clientes
    $sql = "SELECT ID_Cliente, Nombre, Apellido, Correo, Telefono, Direccion, Edad, TypeClient FROM clientes";
    $result = $conn->query($sql);

    // Configurar el encabezado para la descarga del archivo CSV
    header('Content-Type: text/csv; charset=UTF-8'); // Especificar la codificación UTF-8
    header('Content-Disposition: attachment; filename="reporte_clientes.csv"');

    // Agregar BOM para UTF-8 (mejora compatibilidad con Excel)
    echo "\xEF\xBB\xBF";

    $output = fopen('php://output', 'w');

    // Escribir encabezados en el CSV
    fputcsv($output, array('ID_Cliente', 'Nombre', 'Apellido', 'Correo', 'Teléfono', 'Dirección', 'Edad', 'Tipo de Cliente'));

    // Escribir los datos de los clientes en el CSV
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);
        }
    }

    fclose($output);
    exit(); // Terminar el script
}
?>
