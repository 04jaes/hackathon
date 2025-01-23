<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/index.css">
</head>
<body>
    <header class="header">
        <div class="logo">
            <a href="../index.php">
            <img src="../assets/img/Imagotipo.png" alt="Polaris Logo">
            </a>
        </div>
        <nav class="nav">
            <a href="../index.php">Home</a>
            <a href="login.php">Login</a>
            <a href="#">Partners</a>
        </nav>
    </header>

    <main class="main-content">
        <div class="container">
            <h2>Iniciar sesión</h2>
            <form action="../controller/db/verifier.php" method="POST">
                <div>
                    <label for="username">Nombre de usuario:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div>
                    <label for="password">Contraseña:</label>
                    <input type="password" id="u_Password" name="password" required>
                </div>
                <button type="submit" class="login-button">Iniciar sesión</button>
            </form>
        </div>
    </main>

    <?php
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Database connection settings
        $servername = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbname = "hackathon";

        try {
            // Crear una conexión PDO básica
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Query para verificar el usuario y la contraseña
            $sql = "SELECT id, Nombre FROM usuarios WHERE Nombre = :username AND Contrasena = :password";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':username' => $username, ':password' => $password]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Iniciar sesión
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $user['Nombre']; // Usar el nombre del usuario para mostrar en las vistas

                // Redirigir a la página principal
                header('Location: principal.php');
                exit;
            } else {
                echo "<p style='color:red;'>Invalid username or password.</p>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $conn = null; // Cerrar la conexión después de usarla
    }
    ?>

    <?php include 'footer.php';?> 
</body>
</html>
