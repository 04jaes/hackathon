<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="assets/img/Imagotipo.png" alt="Polaris Logo">
            <!--<span>Polaris</span>-->
        </div>
        <nav class="nav">
            <a href="#">Home</a>
            <a href="#about">About us</a>
            <a href="#">Partners</a>
        </nav>
        <button class="login-button" id="SignIn">Iniciar sesión</button>
    </header>
    <main class="main-content">

        <div class="container">
            <p>
                “Enciende la estrella de cada hogar”
            </p>
        </div>


        <div class="slider-container">
            <div class="slider">
              <img src="assets/img/DALL·E 2024-10-30 09.22.49 - A warm and lively family scene with parents and children enjoying a day at home, with cozy lighting. The family members are gathered in a living room,.webp" alt="Image 1">
              <img src="assets/img/DALL·E 2024-10-30 09.22.50 - A cheerful family scene of parents with children, outdoors in a park, enjoying a sunny day. They are sitting on a picnic blanket surrounded by trees a.webp" alt="Image 2">
              <img src="assets/img/DALL·E 2024-10-30 09.22.51 - A warm, candid family scene of grandparents, parents, and children gathered around a dining table, sharing a meal together in a cozy home setting. The.webp" alt="Imagen 3">
              <img src="assets/img/descarga.jpeg" alt="Imagen 4"><!-- Añade más imágenes si es necesario -->
            </div>
        </div>
    </main>

    <div class="constellation-separator">
        <img src="assets/img/PNG estrellas separación web.png" alt="Constellation" class="constellation-image">
    </div>

    <section class="about" id="about">
        <div class="about-section">
            <div class="about-text">
                <h2>¿QUÉ ES POLARIS?</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi id porta turpis. Aliquam tristique magna sed purus dictum, ac molestie enim tempor. Donec tincidunt pellentesque venenatis. Morbi pretium luctus nunc. Vestibulum congue, erat quis aliquet porttitor, libero risus gravida velit, at laoreet massa ligula eu eros.</p>
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
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi id porta turpis. Aliquam tristique magna sed purus dictum, ac molestie enim tempor. Donec tincidunt pellentesque venenatis. Morbi pretium luctus nunc. Vestibulum congue, erat quis aliquet porttitor, libero risus gravida velit, at laoreet massa ligula eu eros.</p>
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
      

    <div id="loginPopup" class="popup">
        <div class="popup-content">
            <span class="close" id="closePopup">&times;</span>
            <h2>Iniciar Sesión</h2>
            <form>
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
                <br>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
                <br>
                <button type="submit"><a href="pages/principal.php">Entrar</a></button>
            </form>
        </div>
    </div>
    
    <?php include 'pages/footer.php';?> 
    
    <script src="controller/script.js"></script>
</body>
</html>
    