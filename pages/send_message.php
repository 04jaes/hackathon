<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['chatId']) && isset($data['contenido'])) {
        $chatId = $data['chatId'];
        $contenido = $data['contenido'];

        // Aquí debería ir la conexión a la base de datos
        $dsn = "mysql:host=localhost;dbname=hackathon;charset=utf8mb4";
        $username = "root";
        $password = "";

        try {
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Insertar el mensaje en la base de datos
            $stmt = $pdo->prepare("INSERT INTO mensajes (FechaEnvio, idChat, texto) VALUES (CURRENT_TIMESTAMP, :chatId, :contenido)");
            $stmt->execute(['chatId' => $chatId, 'contenido' => $contenido]);

            echo json_encode(['status' => 'success', 'message' => 'Mensaje enviado correctamente']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error al enviar el mensaje: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
    }
}
