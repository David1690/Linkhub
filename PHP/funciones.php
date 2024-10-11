<?php
// Función para obtener todos los clientes
function obtenerClientes() {
    // Configuración de la conexión a la base de datos
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

    // Consulta para obtener los datos
    $sql = "SELECT ID_Cliente, Nombre, Apellido, Correo, Telefono, Direccion, Edad, TypeClient FROM clientes";
    $result = $conn->query($sql);

    // Devolver los resultados
    $clientes = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $clientes[] = $row;
        }
    }
    $conn->close();
    return $clientes;
}

// Función para guardar un nuevo cliente
function guardarCliente($nombre, $apellido, $correo, $telefono, $direccion, $edad, $tipoCliente) {
    // Configuración de la conexión a la base de datos
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

    // Preparar la consulta SQL para evitar inyecciones SQL
    $stmt = $conn->prepare("INSERT INTO clientes (Nombre, Apellido, Correo, Telefono, Direccion, Edad, TypeClient) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssis", $nombre, $apellido, $correo, $telefono, $direccion, $edad, $tipoCliente);

    // Ejecutar la consulta
    $resultado = $stmt->execute();

    // Cerrar la conexión
    $stmt->close();
    $conn->close();

    return $resultado;
}

// Función para obtener un cliente por su ID
function obtenerClientePorId($idCliente) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "linkhub";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Error en la conexión: " . $conn->connect_error);
    }

    $sql = "SELECT ID_Cliente, Nombre, Apellido, Correo, Telefono, Direccion, Edad, TypeClient FROM clientes WHERE ID_Cliente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idCliente);
    $stmt->execute();
    $result = $stmt->get_result();

    $cliente = $result->fetch_assoc();

    $stmt->close();
    $conn->close();

    return $cliente;
}

// Función para actualizar los datos de un cliente sin modificar su ID
function actualizarCliente($idCliente, $nombre, $apellido, $correo, $telefono, $direccion, $edad, $tipoCliente) {
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

    // Preparar la consulta SQL para actualizar el cliente
    $sql = "UPDATE clientes SET Nombre = ?, Apellido = ?, Correo = ?, Telefono = ?, Direccion = ?, Edad = ?, TypeClient = ? WHERE ID_Cliente = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    // Vincular los parámetros
    $stmt->bind_param("sssssiss", $nombre, $apellido, $correo, $telefono, $direccion, $edad, $tipoCliente, $idCliente);

    // Ejecutar la consulta
    $resultado = $stmt->execute();

    if (!$resultado) {
        die("Error en la ejecución de la consulta: " . $stmt->error);
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();

    return $resultado;
}

function eliminarCliente($id_cliente) {
    // Conectar a la base de datos
    $conn = new mysqli('localhost', 'root', '', 'linkhub');

    // Verificar si la conexión tuvo éxito
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Preparar y ejecutar la consulta SQL para eliminar el cliente
    $sql = "DELETE FROM clientes WHERE ID_Cliente = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id_cliente);
        $resultado = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $resultado;
    } else {
        return false;
    }
}

function conectarBD() {
    // Configuración de la conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "linkhub";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    return $conn; // Devolver el objeto de conexión
}

?>
