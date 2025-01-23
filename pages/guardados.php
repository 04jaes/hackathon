<?php
// Conexión a la base de datos
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'hackathon';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Suponiendo que el usuario está autenticado y su ID está disponible (pero no se usa para filtrar)
session_start(); // Asegúrate de tener las sesiones activadas
$usuario_id = $_SESSION['usuario_id'] ?? 1; // Cambiar por el ID real del usuario autenticado

// Consulta para obtener los favoritos sin filtrar por usuario_id
$sql_favoritos = "
    SELECT p.id, p.nombre
    FROM publicacion p
    INNER JOIN favoritos f ON p.id = f.id";

// No necesitamos pasar el usuario_id aquí, porque no estamos filtrando
$stmt = $conn->prepare($sql_favoritos);
$stmt->execute();
$result_favoritos = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favoritos</title>
    <link rel="stylesheet" href="../assets/css/guardados.css"> <!-- Enlace al archivo CSS -->
</head>
<body>
<?php include 'topNavFinal.php'; ?>
    <div class="contenedor">
        <!-- Contenido principal -->
        <main class="principal">
            <!-- Encabezado -->
            <header class="favoritos">
                <h2>Mis Publicaciones Favoritas</h2>
            </header>

            <!-- Sección de favoritos -->
            <section class="favoritos-items">
                <?php if ($result_favoritos && $result_favoritos->num_rows > 0): ?>
                    <?php while ($row = $result_favoritos->fetch_assoc()): ?>
                        <a href="info.php?id=<?php echo $row['id']; ?>" class="item">
                            <!-- Mostrar imagen -->
                            <img src="<?php echo $row['imagen'] ?? '../assets/img/fotoejemplo.jpg'; ?>" alt="Imagen de la publicación">
                             <!-- Mostrar nombre -->
                            <p><?php echo htmlspecialchars($row['nombre']); ?></p>
                        </a>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No tienes publicaciones favoritas aún.</p>
                <?php endif; ?>
            </section>
        </main>
    </div>

    <!-- Cierre de conexión -->
    <?php $conn->close(); ?>
</body>
</html>
