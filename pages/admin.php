<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <title>Página de Usuarios y Artículos</title>
    
</head>
<body>
    <?php include "../controller/sesion/auth.php";?>
    <div class="container">
        
         
        <div class="usuarios">
            <h3>Usuarios</h3>
            <?php include "ad_usuario.php";?>
            
        </div>
    
          
        <div class="articulos">
            <h3>Artículos</h3>
            <?php include "ad_articulo.php";?>  
        </div>
    </div>


    <!-- Sección de Chat -->
    <div class="chat">
        <h3>Chats Activos</h3>
        <div id="chat-list">
            <!-- Los chats activos aparecerán aquí -->
        </div>
    </div>
    <a href = "crearUsu.php" class = "create">+</a>
    <script src = "../controller/db/estado.js"></script>
    <script src = "../controller/db/articulo.js"></script>
    
</body>
</html>
