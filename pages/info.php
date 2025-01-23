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

// Obtener el ID de la publicación desde la URL
$id_publicacion = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;

// Si el ID no es válido, redirigir a una página de error o de inicio
if ($id_publicacion <= 0) {
    die("ID no válido.");
}

// Consulta para obtener los detalles de la publicación
$sql_publicacion = "SELECT nombre, descripcion FROM publicacion WHERE id = $id_publicacion";
$result_publicacion = $conn->query($sql_publicacion);

// Verificar si se ha encontrado la publicación
if ($result_publicacion && $result_publicacion->num_rows > 0) {
    $publicacion = $result_publicacion->fetch_assoc();
} else {
    die("Publicación no encontrada.");
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Publicación</title>
    <link rel="stylesheet" href="../assets/css/InfoArticulo.css">
</head>
<body>
<?php 
    include 'topNavFinal.php';
    include 'conexion.php';
    ?>
    <div class="container">
        <div class="main-content">
            <!-- Mostrar detalles de la publicación -->
            <div class="product-header">
                <img src="<?php echo isset($publicacion['imagen']) ? htmlspecialchars($publicacion['imagen']) : '../assets/img/fotoejemplo.jpg'; ?>" alt="Imagen de la publicación">
                <div class="product-details">
                    <h1><?php echo htmlspecialchars($publicacion['nombre']); ?></h1>
                    <div class="product-info">
                        <h2>Descripción</h2>
                        <p class="product-description"><?php echo htmlspecialchars($publicacion['descripcion']); ?></p>
                    </div>
                    <div class="action-buttons">
                        <button class="contact-seller">Contactar Vendedor</button>
                    </div>
                    <div class="action-buttons">
                        <a class="contact-seller" href="chat.php?id=<?php echo $id_publicacion; ?>" >Contactar Vendedor</a>
</div>

                </div>
            </div>
        </div>
        <div class="suggestions">
            <h2>Publicaciones Sugeridas</h2>
            <!-- Aquí puedes agregar las publicaciones sugeridas, si las tienes -->
        </div>
    </div>
</body>
</html>
