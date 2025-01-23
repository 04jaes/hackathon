<?php
// Conexión a la base de datos
$host = 'localhost';
$user = 'root';  // Cambia si es necesario
$password = '';  // Cambia si es necesario
$database = 'hackathon';  // Nombre de la base de datos

$conn = new mysqli($host, $user, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener categorías (basado en la tabla 'tipoobjeto')
$sql_categorias = "SELECT id, tipo FROM tipoobjeto";
$result_categorias = $conn->query($sql_categorias);

// Inicializar las variables para los artículos
$articulos_mostrados = 0;  // Contador de artículos mostrados
$max_articulos_mostrar = 6; // Número máximo de artículos a mostrar

session_start();
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
    <link rel="stylesheet" href="../assets/css/estilos.css"> <!-- Enlace al archivo CSS -->
    <link rel="stylesheet" href="../assets/css/sideNav.css"> <!-- Enlace al archivo CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body style="padding: 0;">
    <div class="contenedor">
        <!-- Barra lateral -->
        <?php include 'topNavFinal.php'; ?>

        <!-- Contenido principal -->
        <main class="principal">
            <header class="buscador">
                <input type="text" id="searchInput" placeholder="Buscar...">
                <button onclick="buscarPublicacion()">🔍</button>
            </header>
            <div id="resultadoBusqueda"></div> 

            <!-- Sección de "Visto recientemente" -->
            <section class="visto-recientemente">
    <h2>CATÁLOGO</h2>
    <div class="visto-items">
    <?php if ($result_categorias && $result_categorias->num_rows > 0): ?>
        <?php while($row = $result_categorias->fetch_assoc()): ?>
            <a href="categoria_productos.php?tipo=<?php echo urlencode($row['tipo']); ?>" class="btn-categoria">
                <img src="../assets/img/cocina.jpeg" alt="<?php echo htmlspecialchars($row['tipo']); ?>" />
                <p><?php echo htmlspecialchars($row['tipo']); ?></p>
            </a>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No hay publicaciones recientes.</p>
    <?php endif; ?>
    <a href = "subida.php" class = "subida">+</a>

</div>

            </section>

            
        </main>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
    // Detectar la tecla Enter en el campo de entrada
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            buscarPublicacion();
        }
    });

    // Función para realizar la búsqueda
    function buscarPublicacion() {
        const query = searchInput.value.trim();

        if (query.length === 0) {
            document.getElementById('resultadoBusqueda').innerHTML = '';
            return;
        }

        // Realizar solicitud AJAX para buscar publicaciones
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'buscar.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById('resultadoBusqueda').innerHTML = this.responseText;
            }
        };
        xhr.send('query=' + encodeURIComponent(query));
    }

    // Funcionalidad para favoritos
    const favoritos = document.querySelectorAll('.favorito-icon');
    favoritos.forEach(favorito => {
        favorito.addEventListener('click', function () {
            const itemId = this.getAttribute('data-id'); // Obtener el ID del artículo
            const estadoFavorito = this.classList.contains('favorito-activo') ? 0 : 1; // Cambiar estado

            // Cambiar estado visual
            this.classList.toggle('favorito-activo', estadoFavorito === 1);

            // Llamada AJAX para actualizar el estado en la base de datos
            fetch('actualizar_favorito.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `item_id=${itemId}&estado=${estadoFavorito}`,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Favorito actualizado');
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error en la solicitud AJAX:', error);
                    alert('Error en la solicitud AJAX');
                });
        });
    });
});
    </script>

</body>
</html>

<?php
// Cerrar la conexión a la base de datos
$conn->close();
?>
