<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/img/isotipo.png">
    <link rel="stylesheet" href="../assets/css/chat.css">
    <title>Polaris</title>
</head>
<body>
    <?php 
    include 'sideNav.php';
    include 'conexion.php';
    ?>

    <div class="chat">
        <div class="description">
            <img src="../assets/img/image_icon-icons.webp" alt="Descripción del producto">
            <p>Nombre del Producto</p>
        </div>
        <div class="messages">
            <?php
            // Validar que la conexión esté establecida
            if (!isset($conexion) || $conexion === null) {
                die('<p>Error: La conexión a la base de datos no está definida.</p>');
            }

            // Parámetros necesarios
            $idUsuario = 1; // Cambia según el usuario autenticado
            $idUsuario2 = 2; // Cambia según el chat seleccionado
            $idPublicacion = 1; // Cambia según la publicación seleccionada

            // Obtener el ID del chat correspondiente
            $sqlChat = "SELECT id FROM chat 
                        WHERE (idUsuario1 = $idUsuario AND idUsuario2 = $idUsuario2) 
                           OR (idUsuario1 = $idUsuario2 AND idUsuario2 = $idUsuario)
                        AND idPublicacion = $idPublicacion 
                        LIMIT 1";

            $resultChat = $conexion->query($sqlChat);
            if ($resultChat && $resultChat->num_rows > 0) {
                $rowChat = $resultChat->fetch_assoc();
                $idChat = $rowChat['id'];

                // Recuperar mensajes desde la tabla `mensajes`
                $sqlMessages = "SELECT  Texto, fechaEnvio FROM mensajes WHERE idChat = $idChat ORDER BY fechaEnvio ASC";
                $resultMessages = $conexion->query($sqlMessages);

                if ($resultMessages && $resultMessages->num_rows > 0) {
                    while ($rowMessage = $resultMessages->fetch_assoc()) {
                        $isOwnMessage = $rowMessage['id'] == $idUsuario;

                        // Renderizar mensajes con clases específicas
                        echo '<div class="' . ($isOwnMessage ? 'msgOutPut' : 'msgInPut') . '">
                                <p>' . htmlspecialchars($rowMessage['Texto']) . '</p>
                              </div>';
                    }
                } else {
                    echo '<p>No hay mensajes aún.</p>';
                }
            } else {
                echo '<p>Error: No se encontró el chat.</p>';
                $idChat = null; // Asegurarse de que esté definido
            }
            ?>
        </div>
        <div class="input">
            <form method="POST" action="">
                <input type="text" name="texto" placeholder="Escribe tu mensaje..." required>
                <button type="submit"><p>⬆️</p></button>
            </form>
            <?php
            // Verificar si el formulario fue enviado
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['texto']) && !empty($_POST['texto'])) {
                    $texto = $conexion->real_escape_string($_POST['texto']);
                    $fechaEnvio = date('Y-m-d H:i:s'); // Fecha y hora actuales

                    // Verificar que el ID del chat esté definido
                    if (!empty($idChat)) {
                        $sqlInsertMessage = "INSERT INTO mensajes (idChat, idUsuario, Texto, fechaEnvio) 
                                             VALUES ($idChat, $idUsuario, '$texto', '$fechaEnvio')";

                        if ($conexion->query($sqlInsertMessage)) {
                            // Redirigir para evitar reenvío del formulario
                            header("Location: " . $_SERVER['PHP_SELF']);
                            exit;
                        } else {
                            echo '<p>Error al enviar el mensaje: ' . $conexion->error . '</p>';
                        }
                    } else {
                        echo '<p>Error: El chat no está definido.</p>';
                    }
                } else {
                    echo '<p>Error: El mensaje no fue enviado correctamente.</p>';
                }
            }
            ?>
        </div>
    </div>

    <div class="chatsAvailable">
        <?php for ($i = 0; $i < 4; $i++): ?>
            <article class="chatAvailable">
                <img src="../assets/img/image_icon-icons.webp" alt="Chat disponible">
                <p>Nombre Producto</p>
            </article>
        <?php endfor; ?>
    </div>
</body>
</html>
