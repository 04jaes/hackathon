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

// Query para obtener las publicaciones y sus disponibilidades
$query = "SELECT publicacion1.Nombre AS nombre, publicacion1.id AS id, disponibilidad.Disponibilidad AS disponibilidad, publicacion1.idDisponibilidad AS idDisponibilidad 
          FROM publicacion1 
          JOIN disponibilidad ON publicacion1.idDisponibilidad = disponibilidad.id 
          ORDER BY publicacion1.idDisponibilidad DESC";

$result = $conn->query($query);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $p_id = $row["id"];  // ID de la publicación
        $nombre = $row["nombre"];  // Nombre de la publicación
        $disponibilidad = $row["disponibilidad"];  // Disponibilidad actual (ej. Disponible o No Disponible)
        $idDisponibilidad = $row["idDisponibilidad"];  // ID de la disponibilidad (ej. 1 para Disponible, 2 para No Disponible)

        // Determinar la clase del punto según la disponibilidad
        $puntoClase = ($idDisponibilidad == 1) ? "disponible" : "no-disponible";

        // Generar el HTML para mostrar la publicación
        echo "<div class='articulo' data-id='" . $p_id . "'> 
    <a href='perfil-publicacion.php?id=" . $p_id . "'>" . $nombre . "</a> 
    <span class='estado'>
        <span class='punto " . $puntoClase . "'></span> " . $disponibilidad . "
    </span> 
    <button class='btn-articulo-disponible' data-id='" . $p_id . "' onclick='toggleEstadoArticulo(this, 1)'>Hacer Disponible</button>
    <button class='btn-articulo-no-disponible' data-id='" . $p_id . "' onclick='toggleEstadoArticulo(this, 2)'>Hacer No Disponible</button>
</div>";

    }
} else {
    echo "<p>No se encontraron publicaciones.</p>";
}

// Cerrar conexión
$conn->close();
?>
