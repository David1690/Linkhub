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

    // Consulta para obtener los trabajadores
    $sql = "SELECT ID_Trabajador, Namefull, Username, Correo, Pass, TypeAccount FROM trabajadores";
    $result = $conn->query($sql);

    // Configurar el encabezado para la descarga del archivo CSV
    header('Content-Type: text/csv; charset=UTF-8'); // Especificar la codificación UTF-8
    header('Content-Disposition: attachment; filename="reporte_trabajadores.csv"');

    // Agregar BOM para UTF-8 (mejora compatibilidad con Excel)
    echo "\xEF\xBB\xBF";

    $output = fopen('php://output', 'w');

    // Escribir encabezados en el CSV
    fputcsv($output, array('ID_Trabajador', 'Nombre Completo', 'Usuario', 'Correo', 'Contraseña', 'Tipo de Cuenta'));

    // Escribir los datos de los trabajadores en el CSV
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);
        }
    }

    fclose($output);
    exit(); // Terminar el script
}
?>
