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

$query = "SELECT usuarios.id AS id, 
       usuarios.nombre AS nombre, 
       disponibilidad.Disponibilidad AS disponibilidad, 
       usuarios.idDisponibilidad AS d 
FROM usuarios 
JOIN disponibilidad ON usuarios.idDisponibilidad = disponibilidad.id 
WHERE usuarios.idTipoUsuario = 2;;";
$result = $conn -> query($query);
while($row = $result->fetch_assoc()){
    $u_id = $row["id"];
    $nombre = $row["nombre"];
    $estado = $row["disponibilidad"];
    echo "<div class ='usuario' data-id=".$u_id."> \n"
    ."<a href='perfil-usuario.php?id=".$u_id."'  > ".$nombre."</a> \n"
    ."<span class='estado'>  <span class='punto activado'></span> ".$estado." </span> \n"
    . "<button class='btn-usuario-activarr' data-id = ".$u_id."' onclick='toggleEstado(this, 1)'>Activar</button> \n"     
    ."<button class='btn-usuario-bloquear' data-id = ".$u_id."' onclick='toggleEstado(this, 2)'>Bloquear</button> \n" 
    ."</div>"
    ;
}