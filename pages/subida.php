<?php
// Conectar a la base de datos
$servername = "localhost"; // Cambiar por tus datos
$username = "root"; // Cambiar por tu usuario
$password = ""; // Cambiar por tu contraseña
$dbname = "hackathon"; // Cambiar por el nombre de tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
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

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos del formulario
    $productName = $_POST['productName'];
    $productDescription = $_POST['productDescription'];
    $ageRange = $_POST['ageRange']; // Aquí llega el rango de edad seleccionado
    $productCategory = $_POST['productCategory']; // id de la categoría seleccionada

    // Obtener el idFranja correspondiente al rango de edad seleccionado
    $idFranja = null;
    foreach ($ageRanges as $range) {
        if ($range['Franja'] == $ageRange) {  // Asegúrate de usar el nombre correcto de la columna
            $idFranja = $range['id'];  // Asegúrate de usar el nombre correcto de la columna
            break;
        }
    }

    if ($idFranja !== null) {
        // Insertar los datos en la base de datos, con idEstado y idDisponibilidad fijos a 1 y FechaCreacion como la fecha actual
        $sql_insert = "INSERT INTO publicacion (nombre, descripcion, idFranja, idobjeto, idEstado, idDisponibilidad, FechaCreacion) 
                       VALUES ('$productName', '$productDescription', '$idFranja', '$productCategory', 1, 1, NOW())";
        
        if ($conn->query($sql_insert) === TRUE) {
            echo "Producto subido exitosamente";
        } else {
            echo "Error: " . $sql_insert . "<br>" . $conn->error;
        }
    } else {
        echo "Error: No se encontró el rango de edad seleccionado.";
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Producto - Página de Acogida</title>
    <link href="https://fonts.googleapis.com/css2?family=Articulat+Bond:wght@400;700&family=Articulat+Light:wght@300&family=Poppins:wght@200&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/subida.css"> <!-- Enlace al CSS externo -->
</head>
<body>

    <?php 
    include 'sideNav.php';
    include 'conexion.php';
    ?>
    
    <!-- Formulario para Subir Producto -->
    <form method="POST" enctype="multipart/form-data" class="formu">
        <div class="form-container">
            <!-- Sección izquierda: Foto -->
            <div class="image-section">
                <label for="productImage" class="image-label">Seleccionar Foto</label>
                <input type="file" id="productImage" name="productImage" accept="image/*" required>
                <div id="imagePreview">Previsualización</div>
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
                    <label for="ageRange">Rango de Edad</label>
                    <select id="ageRange" name="ageRange" required>
                        <?php
                        // Cargar las franjas de edad desde la base de datos
                        foreach ($ageRanges as $range) {
                            echo "<option value=\"{$range['Franja']}\">{$range['Franja']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="productCategory">Categoría</label>
                    <select id="productCategory" name="productCategory" required>
                        <?php
                        // Cargar las categorías desde la base de datos
                        foreach ($categorias as $categoria) {
                            echo "<option value=\"{$categoria['id']}\">{$categoria['tipo']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit">Subir Producto</button>
            </div>
        </div>
    </form>

</body>
</html>
