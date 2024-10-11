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

    // Consulta para obtener las empresas
    $sql = "SELECT ID_Empresas, Nom_Empresa, Direccion, CorreoEmp, CantEmp, Rubro, NombreRepresentante, Cargo, NumTelefono FROM empresas";
    $result = $conn->query($sql);

    // Configurar el encabezado para la descarga del archivo CSV
    header('Content-Type: text/csv; charset=UTF-8'); // Especificar la codificación UTF-8
    header('Content-Disposition: attachment; filename="reporte_empresas.csv"');

    // Agregar BOM para UTF-8 (mejora compatibilidad con Excel)
    echo "\xEF\xBB\xBF";

    $output = fopen('php://output', 'w');

    // Escribir encabezados en el CSV
    fputcsv($output, array('ID_Empresas', 'Nombre Empresa', 'Dirección', 'Correo', 'Cantidad de Empleados', 'Rubro', 'Nombre Representante', 'Cargo', 'Número de Teléfono'));

    // Escribir los datos de las empresas en el CSV
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);
        }
    }

    fclose($output);
    exit(); // Terminar el script
}
?>
