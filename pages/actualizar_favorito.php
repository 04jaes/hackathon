<?php
include("conexion.php");

if (isset($_POST['item_id']) && isset($_POST['estado'])) {
    $item_id = $_POST['item_id'];
    $estado = $_POST['estado'];

    // Asumiendo que 'estado' es un valor 1 o 0, y que item_id es publicacion_id
    $query = "SELECT * FROM favoritos WHERE publicacion_id = ?"; // Verificamos si ya existe el favorito
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $item_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si el favorito existe, actualizamos
    if ($result->num_rows > 0) {
        $query = "UPDATE favoritos SET estado = ? WHERE publicacion_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $estado, $item_id);
        $stmt->execute();
        echo json_encode(['success' => true, 'message' => 'Favorito actualizado']);
    } else {
        // Si el favorito no existe, lo insertamos
        $query = "INSERT INTO favoritos (publicacion_id, estado) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $item_id, $estado);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Favorito agregado']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al agregar el favorito']);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
}

$conn->close();
?>
