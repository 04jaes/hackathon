<?php
// Obtener datos del formulario
$idUsuario1 = $_POST['idUsuario1'];
$idUsuario2 = $_POST['idUsuario2'];
$idPublicacion = $_POST['idPublicacion'];
$mensaje = $_POST['mensaje'];

// Insertar el mensaje en la base de datos
$sql = "INSERT INTO chat (idUsuario1, idUsuario2, idPublicacion, mensaje, idEstado) 
        VALUES ($idUsuario1, $idUsuario2, $idPublicacion, '$mensaje', 1)";
if ($conn->query($sql) === TRUE) {
    header("Location: chat.php"); // Redirigir al chat
    exit();
} else {
    echo "Error al enviar el mensaje: " . $conn->error;
}
?>
