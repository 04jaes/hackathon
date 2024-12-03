<?php
// Conexión a la base de datos
$host = 'localhost';
$user = 'root';  // Cambia esto si es necesario
$password = '';  // Cambia esto si es necesario
$database = 'hackathon';

// Crear conexión
$conn = new mysqli($host, $user, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener las publicaciones recientes (ajustado a la estructura de la base de datos)
$sql = "SELECT p.Titulo, p.Descripcion, u.Nombre as Usuario, e.Estado
        FROM publicacion p
        JOIN usuarios u ON p.idUsuario = u.id
        JOIN estado e ON p.idEstado = e.id
        ORDER BY p.fecha_creacion DESC
        LIMIT 3";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Visto recientemente</h2>";
    echo "<div class='recent-posts'>";
    while($row = $result->fetch_assoc()) {
        echo "<div class='post'>";
        echo "<h3>" . $row['Titulo'] . "</h3>";
        echo "<p>" . $row['Descripcion'] . "</p>";
        echo "<p><strong>Usuario:</strong> " . $row['Usuario'] . "</p>";
        echo "<p><strong>Estado:</strong> " . $row['Estado'] . "</p>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "No se encontraron publicaciones recientes.";
}

$conn->close();
?>
