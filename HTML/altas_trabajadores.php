<?php
include '../PHP/registro_trabaj.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - LinkHub CRM</title>
    <link rel="stylesheet" href="../CSS/altas_trab.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .register-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-primary:disabled {
            background-color: #c0c0c0;
            border-color: #c0c0c0;
        }

        .form-check-label a {
            color: #007bff;
            text-decoration: none;
        }

        .form-check-label a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="register-container">
        <h2 class="text-center mb-4">Registro de Usuario</h2>
        <form id="registroForm" action="../PHP/registro_trabaj.php" method="POST">
            <div class="form-group">
                <label for="nombreCompleto">Nombre Completo</label>
                <input type="text" class="form-control" id="nombreCompleto" name="nombreCompleto" required>
            </div>
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="tipoCuenta">Tipo de Cuenta</label>
                <select class="form-control" id="tipoCuenta" name="tipoCuenta" required>
                    <option value="Trabajador">Trabajador</option>
                    <option value="Administrador">Administrador</option>
                </select>
            </div>

            <div class="text-center">
                <!-- Botón de registro deshabilitado inicialmente -->
                <button type="submit" id="botonRegistro" class="btn btn-primary">Dar de alta en el sistema</button>
                <!-- Botón de regresar -->
                <button type="button" class="btn btn-outline-danger btn-block mt-2"
                    onclick="window.location.href='contacto.php'">Regresar</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function guardarDatosFormulario() {
            localStorage.setItem('nombreCompleto', document.getElementById('nombreCompleto').value);
            localStorage.setItem('usuario', document.getElementById('usuario').value);
            localStorage.setItem('correo', document.getElementById('correo').value);
            localStorage.setItem('password', document.getElementById('password').value);
        }

        function cargarDatosFormulario() {
            if (localStorage.getItem('nombreCompleto')) {
                document.getElementById('nombreCompleto').value = localStorage.getItem('nombreCompleto');
            }
            if (localStorage.getItem('usuario')) {
                document.getElementById('usuario').value = localStorage.getItem('usuario');
            }
            if (localStorage.getItem('correo')) {
                document.getElementById('correo').value = localStorage.getItem('correo');
            }
            if (localStorage.getItem('password')) {
                document.getElementById('password').value = localStorage.getItem('password');
            }
        }

        document.getElementById('registroForm').addEventListener('input', guardarDatosFormulario);
        window.addEventListener('load', cargarDatosFormulario);
    </script>
</body>

</html>