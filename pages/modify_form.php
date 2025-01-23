<?php
session_start();
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

$product = null; // Initialize $product to avoid undefined variable errors
if (isset($_GET['modify_product_id'])) {
    $productId = intval($_GET['modify_product_id']); // Sanitize input
    $query = "SELECT * FROM publicacion WHERE id = $productId";
    $result = $conn->query($query);

    if ($result === false) {
        die("Error en la consulta: " . $conn->error . " - Consulta: " . $query);
    }

    $product = $result->fetch_assoc();
    if (!$product) {
        die("Producto no encontrado.");
    }
} else {
    die("No se recibió un ID de producto válido.");
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

// Obtener las localidades desde la tabla `Localidad`
$sql_estados = "SELECT  Estado FROM estado"; // Asegúrate de que las columnas sean correctas
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modificar Producto</title>
    <link href="https://fonts.googleapis.com/css2?family=Articulat+Bond:wght@400;700&family=Articulat+Light:wght@300&family=Poppins:wght@200&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/subida.css"> <!-- Enlace al CSS externo -->
    <link rel="stylesheet" href="../assets/css/footer.css"> 

</head>
<body>

<?php 
    include 'sideNav.php'; 
    include 'conexion.php';   
?>

    <h1>Modificar Producto </h1>
    <form action="../controller/CRUDpublicaciones/update_script.php" method="post" class="formu">
    <input type="hidden" name="modify_product_id" value="<?= htmlspecialchars($product['id']) ?>">
    <div class="form-container">
    <div class="fields-section">
    <div>
        <label for="productName">Nombre del Producto</label>
        <input type="text" id="productName" name="productName" value="<?= htmlspecialchars($product['Nombre']) ?>" required>
    </div>
    <div>
        <label for="productDescription">Descripción del Producto</label>
        <textarea id="productDescription" name="productDescription" required><?= htmlspecialchars($product['Descripcion']) ?></textarea>
    </div>
        <div>
            <label for="estado">Estado</label>
            <select id="estado" name="estado" required>
                <?php
                foreach ($estados as $estado) {
                    $selected = ($estado['id'] == $product['idEstado']) ? 'selected' : '';
                    echo "<option value=\"{$estado['id']}\" $selected>{$estado['Estado']}</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <label for="ageRange">Rango de Edad</label>
            <select id="ageRange" name="ageRange" required>
                <?php
                foreach ($ageRanges as $range) {
                    $selected = ($range['id'] == $product['idFranja']) ? 'selected' : '';
                    echo "<option value=\"{$range['id']}\" $selected>{$range['Franja']}</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <label for="productCategory">Categoría</label>
            <select id="productCategory" name="productCategory" required>
                <?php
                foreach ($categorias as $categoria) {
                    $selected = ($categoria['id'] == $product['idObjeto']) ? 'selected' : '';
                    echo "<option value=\"{$categoria['id']}\" $selected>{$categoria['tipo']}</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <label for="idlocalidad">Localidad</label>
            <select id="idlocalidad" name="localidad" required>
                <?php
                foreach ($localidades as $localidad) {
                    $selected = ($localidad['id'] == $product['idLocalidad']) ? 'selected' : '';
                    echo "<option value=\"{$localidad['id']}\" $selected>{$localidad['Localidad']}</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit">Guardar Cambios</button>
        </div>
        </div>
    </form>

    <?php 
    include '../pages/footer.php';
    ?>
</body>
</html>
