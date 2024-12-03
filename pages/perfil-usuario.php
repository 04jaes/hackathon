<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="../assets/css/perfil-usuario.css">
</head>
<body>
    <?php include 'sideNav.php'; ?>

    <div class="profile-container">
        <!-- Contenedor en dos columnas -->
        <div class="profile-grid">
            <!-- Columna izquierda: Avatar -->
            <div class="avatar-section">
                <div class="avatar">
                    <img src="../assets/img/perfil.png" alt="Avatar del usuario">
                </div>
            </div>

            <!-- Columna derecha: Información del usuario -->
            <div class="user-info-section">
                <div class="info-block">
                    <h2>Nombre</h2>
                    <p>Juan Pérez</p>
                </div>
                <div class="info-block">
                    <h2>Email</h2>
                    <p>juanperez@email.com</p>
                </div>
                <div class="info-block">
                    <h2>Ubicación</h2>
                    <p>Madrid</p>
                </div>
                <div class="info-block">
                    <h2>Miembro desde</h2>
                    <p>Enero 2023</p>
                </div>
                <div class="info-block">
                    <h2>Donaciones</h2>
                    <p>5</p>
                </div>
                <div class="info-block">
                    <h2>Artículos donados</h2>
                    <p>12</p>
                </div>
            </div>
        </div>

        <!-- Sección de artículos favoritos -->
        <div class="favorites">
            <h3>Mis Artículos Favoritos</h3>
            <div class="favorites-grid">
                <div class="favorite-item">
                    <img src="../assets/img/cocina.jpeg" alt="Libro de cocina">
                    <p>Libro de cocina</p>
                </div>
                <div class="favorite-item">
                    <img src="mochila.jpg" alt="Mochila de senderismo">
                    <p>Mochila de senderismo</p>
                </div>
                <div class="favorite-item">
                    <img src="juguetes.jpg" alt="Juguetes educativos">
                    <p>Juguetes educativos</p>
                </div>
            </div>
        </div>

        <!-- Botón para ir a "Mis Artículos" -->
        <div class="my-items">
            <a href="mis-articulos.html" class="button">Mis Artículos</a>
        </div>
    </div>
</body>
</html>
