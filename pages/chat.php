<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="../assets/css/chat.css">
</head>
<body>
<?php 
session_start();

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: login.php');  // Si no está autenticado, redirige a la página de inicio de sesión
    exit();
}

include 'topNavFinal.php'; 
?>

    <div class="chat-container">
        <!-- Lista de chats -->
        <div class="chat-list">
            <?php
            $dsn = "mysql:host=localhost;dbname=hackathon;charset=utf8mb4";
            $username = "root";
            $password = "";

            try {
                $pdo = new PDO($dsn, $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $loggedUser = $_SESSION['username']; // Usuario logueado

                // Obtener el ID del usuario logueado
                $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE Nombre = :username");
                $stmt->execute(['username' => $loggedUser]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    $userId = $user['id'];

                    // Consultar los chats en los que participa el usuario logueado
                    $stmt = $pdo->prepare("
                        SELECT c.id, u1.Nombre AS Usuario1, u2.Nombre AS Usuario2, c.idEstado, c.idPublicacion
                        FROM chat c
                        JOIN usuarios u1 ON c.idUsuario1 = u1.id
                        JOIN usuarios u2 ON c.idUsuario2 = u2.id
                        WHERE c.idUsuario1 = :userId OR c.idUsuario2 = :userId
                    ");
                    $stmt->execute(['userId' => $userId]);
                    $chats = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($chats) {
                        foreach ($chats as $chat) {
                            // Determinar el otro usuario en el chat
                            $otherUser = ($chat['Usuario1'] === $loggedUser) ? $chat['Usuario2'] : $chat['Usuario1'];
                            echo '<div class="chat-item" onclick="selectChat(' . htmlspecialchars(json_encode($otherUser)) . ', ' . htmlspecialchars(json_encode($chat['id'])) . ')">';
                            echo '<h4>' . htmlspecialchars($otherUser) . '</h4>';
                            echo '<p>Chat ID: ' . htmlspecialchars($chat['id']) . '</p>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div>No hay chats disponibles.</div>';
                    }
                } else {
                    echo '<div>Error: Usuario no encontrado.</div>';
                }
            } catch (PDOException $e) {
                echo "Error al cargar los chats: " . $e->getMessage();
            }
            ?>
        </div>

        <!-- Ventana de chat -->
        <div class="chat-window">
            <div class="chat-header">
                <h3 id="chat-title">Selecciona un chat</h3>
            </div>
            <div class="messages" id="messages">
                <!-- Los mensajes se mostrarán dinámicamente aquí -->
                <div class="no-messages">No hay mensajes aún.</div>
            </div>

            <!-- Input para enviar mensajes -->
            <div class="input">
                <form id="message-form" method="post">
                    <input type="hidden" name="chatId" id="hidden-chat-id">
                    <input type="text" id="message-input" name="mensaje" placeholder="Escribe un mensaje...">
                    <button type="submit">➤</button>
                </form>
            </div>
        </div>
    </div>

    <script>
    let currentChat = null;
    let currentChatId = null;

    function selectChat(chatTitle, chatId) {
        currentChat = chatTitle;
        currentChatId = chatId;
        document.getElementById("chat-title").innerText = `Chat con ${chatTitle}`;

        // Cargar los mensajes iniciales almacenados en localStorage
        loadMessages();
    }

    function loadMessages() {
        const messagesContainer = document.getElementById("messages");
        messagesContainer.innerHTML = '';

        const savedMessages = JSON.parse(localStorage.getItem('chatMessages')) || [];

        if (savedMessages.length > 0) {
            savedMessages.forEach(message => {
                const messageElement = document.createElement("div");
                messageElement.className = `message ${message.type}`;
                messageElement.innerHTML = `${message.text}<span>${new Date(message.time).toLocaleTimeString()}</span>`;
                messagesContainer.appendChild(messageElement);
            });
        } else {
            messagesContainer.innerHTML = '<div class="no-messages">No hay mensajes aún.</div>';
        }
    }

    document.getElementById("message-form").addEventListener("submit", function(e) {
        e.preventDefault(); // Prevenir el envío por defecto

        const messageInput = document.getElementById("message-input");
        const messageText = messageInput.value.trim();

        if (!messageText || !currentChatId) {
            alert("Selecciona un chat y escribe un mensaje.");
            return;
        }

        // Crear un nuevo elemento de mensaje
        const messageElement = document.createElement("div");
        messageElement.className = "message sent";
        messageElement.innerHTML = `${messageText}<span>${new Date().toLocaleTimeString()}</span>`;

        // Agregar el mensaje al contenedor
        const messagesContainer = document.getElementById("messages");
        const noMessages = messagesContainer.querySelector(".no-messages");
        if (noMessages) noMessages.remove(); // Eliminar el texto "No hay mensajes aún"
        messagesContainer.appendChild(messageElement);

        // Limpiar el input de mensaje
        messageInput.value = "";

        // Desplazarse al final de los mensajes
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        // Almacenar el mensaje en localStorage
        const savedMessages = JSON.parse(localStorage.getItem('chatMessages')) || [];
        savedMessages.push({
            type: 'sent',
            text: messageText,
            time: new Date(),
            username: '<?php echo $_SESSION['username']; ?>'
        });
        localStorage.setItem('chatMessages', JSON.stringify(savedMessages));
    });
    </script>

</body>
</html>
