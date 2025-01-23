<?php
// Parámetros de conexión
$servidor = "localhost";     // Dirección del servidor, si es local, usar 'localhost'
$usuario = "root";     // Tu usuario de la base de datos
$contraseña = ""; // La contraseña de tu base de datos
$baseDatos = "hackathon";    // El nombre de la base de datos (en tu caso 'hackathon')

// Crear la conexión
$conn = new mysqli($servidor, $usuario, $contraseña, $baseDatos);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


// File paths and variables
$jsonFilePath = 'products.json';
$uploadDir = 'uploads/';
$uploadedImages = [3];

// Create the uploads directory if it doesn't exist
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Obtener las franjas de edad desde la tabla `franjaedades`
$sql_edad = "SELECT id, Franja FROM franjaedades"; // Asegúrate de que las columnas sean correctas
$result_edad = $conn->query($sql_edad);

if ($result_edad->num_rows > 0) {
    // Guardar las franjas de edad en un array
    $ageRanges = [];
    while($row = $result_edad->fetch_assoc()) {
        $ageRanges[] = $row;
    }
} else {
    $ageRanges = []; // Si no hay resultados, dejamos el array vacío
}

$idUsuario = isset($_GET['usu']) ? intval($_GET['usu']) : null;

// Obtener las categorías desde la tabla `tipoobjeto`
$sql_categorias = "SELECT id, tipo FROM tipoobjeto"; // Asegúrate de que las columnas sean correctas
$result_categorias = $conn->query($sql_categorias);

if ($result_categorias->num_rows > 0) {
    // Guardar las categorías en un array
    $categorias = [];
    while($row = $result_categorias->fetch_assoc()) {
        $categorias[] = $row;
    }
} else {
    $categorias = []; // Si no hay resultados, dejamos el array vacío
}

// Obtener las localidades desde la tabla `Localidad`
$sql_localidades = "SELECT id, Localidad FROM Localidad"; // Asegúrate de que las columnas sean correctas
$result_localidades = $conn->query($sql_localidades);

if ($result_localidades->num_rows > 0) {
    // Guardar las localidades en un array
    $localidades = [];
    while($row = $result_localidades->fetch_assoc()) {
        $localidades[] = $row;
    }
} else {
    $localidades = []; // Si no hay resultados, dejamos el array vacío
}

// Obtener las localidades desde la tabla `estado`
$sql_estados = "SELECT  id,Estado FROM estado"; // Asegúrate de que las columnas sean correctas
$result_estados = $conn->query($sql_estados);

if ($result_estados->num_rows > 0) {
    // Guardar las localidades en un array
    $estados = [];
    while($row = $result_estados->fetch_assoc()) {
        $estados[] = $row;
    }
} else {
    $estados = []; // Si no hay resultados, dejamos el array vacío
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Producto - Página de Acogida</title>
    <link href="https://fonts.googleapis.com/css2?family=Articulat+Bond:wght@400;700&family=Articulat+Light:wght@300&family=Poppins:wght@200&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/subida.css"> <!-- Enlace al CSS externo -->
    <link rel="stylesheet" href="../assets/css/footer.css"> 

    <style>
        .boton2{
            display: none;
        }
        .carousel-container{
            overflow: hidden;
            position: relative;
        }
        .dynamic-box {
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px dashed #007bff;
            background-color: #f8f9fa;
            width: 400px; /* Ancho fijo */
            height: 600px; /* Alto fijo */
            overflow: hidden; /* Evita que las imágenes desborden */
            position: relative; /* Para un mejor control del diseño interno */
        }
        .dynamic-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain; /* Escala proporcional */
            display: block; /* Elimina espacios blancos */
        }
    </style>
</head>
<body>

    <?php 
    include 'sideNav.php'; 
    include 'conexion.php';   
    ?>
    
    <!-- Formulario para Subir Producto -->
    <form action="../controller/CRUDpublicaciones/upload_script.php" method="post" enctype="multipart/form-data" class="formu">
        <div class="form-container">
        <input type="hidden" name="action" value="upload">
            <!-- Sección izquierda: Foto -->
            <div class="image-section">
                <label for="images" class="image-label">Seleccionar Foto</label>
                <input type="file" id="images" name="images[]" accept="image/*" multiple required class="boton2">
                <div id="error-message" style="color: red; font-weight: bold; margin-top: 10px;"></div>
                <div id="carouselContainer" class="carousel-container" style="width: 400px; margin: 20px auto;">
                    <div id="dynamicBox" class="carousel"></div>
                    <button id="prevBtn" style="display: none;">&#10094; Anterior</button>
                    <button id="nextBtn" style="display: none;">Siguiente &#10095;</button>
                        <p>Máximo 3 imágenes</p>
                </div>
            </div>
            <!-- Sección derecha: Campos del formulario -->
            <div class="fields-section">
                <div>
                    <label for="productName">Nombre del Producto</label>
                    <input type="text" id="productName" name="productName" required>
                </div>
                <div>
                    <label for="productDescription">Descripción del Producto</label>
                    <textarea id="productDescription" name="productDescription" required></textarea>
                </div>
                <div>
                    <label for="estado">Estado</label>
                    <select id="estado" name="estado" required>
                        <?php
                        // Cargar las franjas de edad desde la base de datos
                        foreach ($estados as $estado) {
                            echo "<option value=\"{$estado['id']}\">{$estado['Estado']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="ageRange">Rango de Edad</label>
                    <select id="ageRange" name="ageRange" required>
                        <?php
                        foreach ($ageRanges as $range) {
                            echo "<option value=\"{$range['id']}\">{$range['Franja']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="productCategory">Categoría</label>
                    <select id="productCategory" name="productCategory" required>
                        <?php
                        foreach ($categorias as $categoria) {
                            echo "<option value=\"{$categoria['id']}\">{$categoria['tipo']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="idlocalidad">Localidad</label>
                    <select id="idlocalidad" name="localidad" required>
                        <?php
                        foreach ($localidades as $localidad) {
                            echo "<option value=\"{$localidad['id']}\">{$localidad['Localidad']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" name="submit">Subir Producto</button>
            </div>
        </div>
    </form>
    <?php
    // Include the product selection script
    include '../controller/CRUDpublicaciones/select_script.php';
    ?>
    
    <?php 
    include '../pages/footer.php';
    ?>

    
<script>
        // Previsualización de imagen
        document.getElementById('images').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('preview');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        });

        const fileInput = document.getElementById('images');
        const dynamicBox = document.getElementById('dynamicBox');

        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                // Mostrar la imagen escalada dentro del contenedor
                const reader = new FileReader();
                reader.onload = function(e) {
                    dynamicBox.innerHTML = `<img src="${e.target.result}" alt="Vista previa">`;
                };
                reader.readAsDataURL(file);
            } else {
                // Restaurar el estado inicial si no hay archivo
                dynamicBox.innerHTML = '<p>El archivo aparecerá aquí</p>';
            }
        });
</script>
</body>

</html>
