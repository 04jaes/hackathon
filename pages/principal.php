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

// Consulta para obtener publicaciones recientemente vistas
$sql_visto_recientemente = "SELECT id, nombre FROM publicacion ORDER BY FechaCreacion DESC LIMIT 3";
$result_visto_recientemente = $conn->query($sql_visto_recientemente);

// Consulta para obtener categorías (basado en la tabla 'tipoobjeto')
$sql_categorias = "SELECT tipo FROM tipoobjeto";
$result_categorias = $conn->query($sql_categorias);

// Consulta para obtener artículos
$sql_articulos = "SELECT id, nombre FROM publicacion"; // Ajusta según tu tabla
$result_articulos = $conn->query($sql_articulos);

// Inicializar las variables para los artículos
$articulos_mostrados = 0;  // Contador de artículos mostrados
$max_articulos_mostrar = 6; // Número máximo de artículos a mostrar
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

</head>
<body style="padding: 0;">
    <div class="contenedor">
        <!-- Barra lateral -->
        <?php include 'sideNav.php'; ?>

        <!-- Contenido principal -->
        <main class="principal">
            <header class="buscador">
                <input type="text" id="searchInput" placeholder="Buscar...">
                <button onclick="buscarPublicacion()">🔍</button>
            </header>
            <div id="resultadoBusqueda"></div> 

            <!-- Sección de "Visto recientemente" -->
            <section class="visto-recientemente">
                <h2>Visto recientemente</h2>
                <div class="visto-items">
                    <?php if ($result_visto_recientemente && $result_visto_recientemente->num_rows > 0): ?>
                        <?php while($row = $result_visto_recientemente->fetch_assoc()): ?>
                            <a href="info.php?id=<?php echo $row['id']; ?>" class="item">
                                <img src="<?php echo isset($row['imagen']) ? $row['imagen'] : '../assets/img/fotoejemplo.jpg'; ?>" alt="Imagen">
                                <p><?php echo $row['nombre']; ?></p>
                            </a>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>No hay publicaciones recientes.</p>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Sección de categorías -->
            <section class="categorias">
                <h3>Categorías</h3>
                <div class="categorias-items">
                    <?php if ($result_categorias && $result_categorias->num_rows > 0): ?>
                        <?php while($row = $result_categorias->fetch_assoc()): ?>
                            <a href="#" class="categoria">
                                <p><?php echo $row['tipo']; ?></p>
                            </a>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>No hay categorías disponibles.</p>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Sección de Artículos Disponibles -->
            <section class="articulos-disponibles">
                <h2>Artículos Disponibles</h2>
                <div class="articulo-items">
                    <?php
                    if ($result_articulos && $result_articulos->num_rows > 0): 
                        $articulos = $result_articulos->fetch_all(MYSQLI_ASSOC); 

                        foreach ($articulos as $row): 
                            if ($articulos_mostrados < $max_articulos_mostrar): ?>
                                <div class="item">
                                    <a href="info.php?id=<?php echo $row['id']; ?>">
                                        <img src="<?php echo isset($row['imagen']) ? $row['imagen'] : '../assets/img/fotoejemplo.jpg'; ?>" alt="Imagen">
                                        <p><?php echo $row['nombre']; ?></p>
                                    </a>
                                    <!-- Estrella para añadir a favoritos -->
                                    <span class="favorito-icon" data-id="<?php echo $row['id']; ?>">
                                        <i class="fas fa-star"></i> <!-- Aquí se usa FontAwesome para la estrella -->
                                    </span>
                                </div>
                                <?php 
                                $articulos_mostrados++; 
                            endif;
                        endforeach;
                    else: ?>
                        <p>No hay artículos disponibles.</p>
                    <?php endif; ?>
                </div>
                <?php if ($articulos_mostrados >= $max_articulos_mostrar): ?>
                    <button id="cargar-mas" onclick="cargarMasArticulos()">Cargar más</button>
                <?php endif; ?>
            </section>
        </main>
    </div>

    <script>
        function buscarPublicacion() {
            const query = document.getElementById('searchInput').value;

            if (query.length === 0) {
                document.getElementById('resultadoBusqueda').innerHTML = '';
                return;
            }

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'buscar.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    document.getElementById('resultadoBusqueda').innerHTML = this.responseText;
                }
            };

            xhr.send('query=' + encodeURIComponent(query));
        }

        // Espera a que el documento esté listo
        document.addEventListener("DOMContentLoaded", function() {
    const favoritos = document.querySelectorAll('.favorito-icon');

    favoritos.forEach(favorito => {
        favorito.addEventListener('click', function() {
            const itemId = this.getAttribute('data-id'); // Obtén el ID del artículo
            const estadoFavorito = this.classList.contains('favorito-activo') ? 0 : 1; // Cambia el estado del favorito

            // Agregar un alert para verificar los valores
            alert(`Item ID: ${itemId}, Estado: ${estadoFavorito}`);

            // Cambiar el estado visual
            this.classList.toggle('favorito-activo', estadoFavorito === 1);

            // Llamada AJAX para actualizar el estado en la base de datos
            fetch('actualizar_favorito.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `item_id=${itemId}&estado=${estadoFavorito}`
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
