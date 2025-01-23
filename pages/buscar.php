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

// Obtener el término de búsqueda
$query = isset($_POST['query']) ? $_POST['query'] : '';

// Preparar la consulta
$sql = "SELECT id, nombre FROM publicacion WHERE nombre LIKE ?";
$stmt = $conn->prepare($sql);
$searchTerm = "%" . $query . "%"; // Utilizar el comodín % para buscar en cualquier parte
$stmt->bind_param("s", $searchTerm);

// Ejecutar la consulta
$stmt->execute();
$result = $stmt->get_result();

// Mostrar los resultados
echo '<div class="visto-items">';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<a href="info.php?id=' . htmlspecialchars($row['id']) . '" class="item">';
        echo '<img src="' . (isset($row['imagen']) ? htmlspecialchars($row['imagen']) : '../assets/img/fotoejemplo.jpg') . '" alt="Imagen">';
        echo '<p>' . htmlspecialchars($row['nombre']) . '</p>';
        echo '</a>';
    }
} else {
    echo '<p>No se encontraron resultados.</p>';
}
echo '</div>';

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
