<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario para Crear Usuarios</title>
    <link rel="stylesheet" href="..\assets\css\create.css">
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="../assets/img/Imagotipo.png" alt="Polaris Logo">
        </div>
        <!-- Navegación o cualquier otra opción de menú que desees añadir -->
    </header>

    <div class="main-content">
        <h2>Formulario para Crear Usuario</h2>
        <form action="../controller/sesion/addUsu.php" method="POST">
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="Nombre" required>
            </div>

            <div>
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="Mail" required>
            </div>

            <div>
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="Contrasena" required>
            </div>

            <div>
                <label for="tipoUsuario">Tipo de Usuario:</label>
                <select id="tipoUsuario" name="idTipoUsuario" required>
                    <option value="1">Admin</option>
                    <option value="2">Usuario</option>
                    <option value="3">Invitado</option>
                </select>
            </div>

            <button type="submit">Crear Usuario</button>
        </form>
    </div>

</body>
</html>
