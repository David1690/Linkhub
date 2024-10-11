<?php
include '../PHP/funciones.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkHub CRM</title>
    <link rel="stylesheet" href="../CSS/reportes.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>/* Estilos generales */
@font-face {
    font-family: "hidayatullah"; /* Define una fuente personalizada llamada "hidayatullah" */
    src: url(../font/Roboto-Italic.ttf); /* Ruta al archivo de la fuente personalizada */
}
/* Estilos generales */
body {
    font-family: "hidayatullah", Arial, sans-serif; /* Aplica la fuente personalizada con fuentes de respaldo */
    background-color: #f8f9fa; /* Color de fondo claro */
    margin: 0;
    padding: 0;
}

/* Encabezado */
.header {
    display: flex;
    flex-direction:row; /* Cambiar a columna para que el logo y el título se apilen */
    align-items: flex-start; /* Alinear al inicio */
    margin-bottom: 20px;
}

.logo {
    width: 150px; /* Tamaño del logo */
}

/* Título */
.header h1 {
    color: #343a40; /* Color del título */
    margin: 0; /* Eliminar márgenes para alinear a la izquierda */
    text-align: left; /* Alinear el texto a la izquierda */
    margin-top: 10px; /* Espacio entre el logo y el título */
}

/* Estilo del contenedor principal */
.container {
    position: relative;
    width: 100%;
    max-width: 900px !important;
    min-height: 400px !important;
    background: #fff;
    margin: 50px auto; /* Centrar el contenedor horizontalmente */
    box-shadow: 0 35px 55px #81689D;
    border-radius: 10px;
    padding: 20px; /* Añadir padding interno */
}

/* Estilo del formulario */
.form-group {
    flex-direction: column; /* Alinear elementos en columna */
    justify-content: space-between; /* Alinea los botones horizontalmente */
    align-items: flex-start; /* Alinear los inputs y las etiquetas a la izquierda */
    margin-bottom: 15px;
    width: 100%; /* Ajustar el ancho */
}


label {
    font-weight: bold;
    margin-bottom: 5px; /* Espacio entre la etiqueta y el input */
}

.btn-custom {
    border: 1px solid #000 !important; /* Borde de 5 píxeles, puedes cambiar el color */
    border-radius: 5px !important; /* Borde redondeado, opcional */
    padding: 10px 20px !important; /* Espaciado interno para mayor comodidad */
    margin: 5px !important; /* Espaciado entre los botones */
}

/* Estilo para la barra de navegación */
.navbar {
    justify-content: center !important; /* Centra el contenido de la navbar */
}

.navbar-nav {
    display: flex; /* Habilita Flexbox */
    justify-content: center; /* Centra los elementos en el eje horizontal */
    align-items: center; /* Centra los elementos en el eje vertical */
    gap: 20px; /* Espacio entre cada enlace */
    width: 100%; /* Asegura que ocupe todo el ancho disponible */
}

/* Estilo para los enlaces de la barra de navegación */
.navbar-nav .nav-link {
    text-align: center; /* Asegura que el texto esté centrado */
    color: #000; /* Color de texto negro */
    font-weight: normal; /* Peso de la fuente normal */
    padding: 10px 15px; /* Espaciado para crear el efecto de cuadrado */
    border-radius: 5px; /* Bordes redondeados del cuadrado */
    transition: all 0.3s ease-in-out; /* Suaviza la transición del efecto hover */
    display: block; /* Cambia el enlace a bloque para que ocupe todo el ancho disponible */
}

/* Efecto hover para los enlaces de la navbar */
.navbar-nav .nav-link:hover {
    background-color: #974cc8; /* Fondo color morado */
    color: #000; /* Color de texto negro */
    font-weight: bold; /* Texto en negrita */
}


.btn-container {
    display: flex; /* Usar flexbox para la alineación */
    flex-direction:row-reverse; /* Colocar los botones en columna */
    align-items: flex-end; /* Alinear los elementos al final (derecha) */
}

.btn-special {
    border: 1px solid #000 !important; /* Borde de 1 píxel, puedes cambiar el color */
    border-radius: 5px !important; /* Borde redondeado, opcional */
    padding: 10px 20px !important; /* Espaciado interno para mayor comodidad */
    margin: 5px !important; /* Espaciado entre los botones */
}

.lelo{
margin-left: 50px;
}
</style>
</head>

<body>

<div class="btn-container">

    <!-- Botón de cerrar sesión -->
    <button type="button" class="btn btn-success btn-special" onclick="window.location.href='altas_trabajadores.php'">Crear cuentas</button>

    <button class="btn btn-danger btn-special" onclick="window.location.href='login.php'">Cerrar Sesión</button>
</div>

        <div class="container">
            <!-- Encabezado con logo y título -->
            <div class="header">
                <img src="../IMG/LOGO_LinkHub_sf.png" alt="Logo LinkHub" class="logo">
                <h1 class="mt-4">LinkHub CRM</h1>
            </div>

            <!-- Menú de navegación -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">REPORTES</a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="contacto.php">Contactos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="ventas.php">Ventas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="soporte.php">Soporte</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <div  class="lelo">

            <!-- Sección de reportes -->
            <div id="reportes" class="mt-4 mb-4">
                <h2>Reportes</h2>
                <div class="form-group">
                    <button type="button" class="btn btn-primary btn-custom" onclick="window.location.href='../PHP/csv_cliente.php'">Reporte de Clientes</button>
                    <button type="button" class="btn btn-success btn-custom" onclick="window.location.href='../PHP/csv_ventas.php'">Reporte de Ventas</button>
                    <button type="button" class="btn btn-danger btn-custom" onclick="window.location.href='../PHP/csv_trabajadores.php'">Reporte de Trabajadores</button>
                </div>
            </div>
        </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
       


<script>
   
</script>
</body>

</html>
