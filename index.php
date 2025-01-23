<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/footer.css">

</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="assets/img/Imagotipo.png" alt="Polaris Logo">
        </div>
        <nav class="nav">
            <a href="#">Home</a>
            <a href="#cons">About us</a>
            <a href="#">Partners</a>
        </nav>
        <!-- Enlace al login.php para el inicio de sesión -->
        <a href="pages/login.php" class="login-button">Iniciar sesión</a>
    </header>
    <main class="main-content">
     
        <div class="container">
            <h2>“Enciende la estrella de cada hogar”</h2>
        </div>
        <div class="slider-container">
            <div class="slider">
              <img src="assets\img\DALL·E 2024-10-30 09.22.49 - A warm and lively family scene with parents and children enjoying a day at home, with cozy lighting. The family members are gathered in a living room,.webp" alt="Image 1">
              <img src="assets\img\DALL·E 2024-10-30 09.22.50 - A cheerful family scene of parents with children, outdoors in a park, enjoying a sunny day. They are sitting on a picnic blanket surrounded by trees a.webp" alt="Image 2">
              <img src="assets\img\DALL·E 2024-10-30 09.22.51 - A warm, candid family scene of grandparents, parents, and children gathered around a dining table, sharing a meal together in a cozy home setting. The.webp" alt="Imagen 3">
              <img src="assets\img\descarga.jpeg" alt="Imagen 4"><!-- Añade más imágenes si es necesario -->
            </div>
        </div>
    </main>

    <div class="constellation-separator" id="cons">
        <img src="assets/img/PNG estrellas separación web.png" alt="Constellation" class="constellation-image">
    </div>

    <section class="about" id="about">
        <div class="about-section">
            <div class="about-text">
                <h2>¿QUÉ ES POLARIS?</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi id porta turpis. Aliquam tristique magna sed purus dictum, ac molestie enim tempor.</p>
            </div>
            <div class="about-image">
                <div class="image-placeholder">Imagen recurso</div>
            </div>
        </div>
        <div class="about-section">
            <div class="about-image">
                <div class="image-placeholder">Imagen recurso</div>
            </div>
            <div class="about-text">
                <h2>MISIÓN Y VISIÓN</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi id porta turpis. Aliquam tristique magna sed purus dictum, ac molestie enim tempor.</p>
            </div>
        </div>
    </section>

    <div class="constellation-separator">
        <img src="assets/img/PNG estrellas separación web.png" alt="Constellation" class="constellation-image">
    </div>

    <section class="partners-section">
        <div class="cards-container">
            <div class="card"></div>
            <div class="card"></div>
            <div class="card"></div>
        </div>
        <button class="view-all-button">Ver todos los partners</button>
    </section>

    <footer class="footer">
    <div class="footer-links">
        <div>
            <a href="index.php">Home</a>
            <a href="#">Colaboradores</a>
        </div>
        <div>
            <a href="pages/politica_privacidad.php">Política de privacidad</a>
            <a href="pages/politica_cookies.php">Política de cookies</a>
            <a href="pages/aviso_legal.php">Aviso legal</a>
            <a href="#">Buzón ético</a>
        </div>
        <div>
            <a href="#">Contacto y horarios</a>
            <a href="#">Encuéntranos en redes</a>
            <img src="assets/img/Isotipo.png" alt="Polaris" class="footer-image">

        </div>
    </div>
</footer>
    <script src="controller/script.js"></script>
    <script src="asset/js/cookie.js"></script>
</body>
</html>
