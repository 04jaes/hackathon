<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/changepass.css">
    <title>Document</title>
</head>
<body>
    <!-- Header fijo en la parte superior -->
    <header class="header">
        <div class="logo">
            <img src="../assets/img/Imagotipo.png" alt="Polaris Logo">
            <span>Polaris</span>
        </div>
        <nav class="nav">
            <a href="#">Inicio</a>
            <a href="#">Ayuda</a>
        </nav>
    </header>

    <!-- Contenido principal -->
    <div class="main-content">
        <h1>Cambiar Contraseña</h1>
        <p>Por favor, ingrese su nueva contraseña y confírmela.</p>

        <!-- Formulario -->
        <form method="POST" action="../controller/session/changePassword.php">
            <div>
                <label for="password">Nueva Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <label for="rpassword">Repita la Nueva Contraseña:</label>
                <input type="password" id="rpassword" name="rpassword" required>
            </div>
            <button type="submit">Cambiar Contraseña</button>
        </form>
    </div>
</html>