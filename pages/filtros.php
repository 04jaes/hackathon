<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/filtros.css">
    <title>Filtrar Publicaciones</title>
    <style>
        .hidden { display: none; }
    </style>
</head>
<body>
<?php include 'sideNav.php'; ?>

    <?php
    // Conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hackathon1";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consultar datos para los filtros
    $localidades = $conn->query("SELECT id, Localidad FROM localidad");
    $edades = $conn->query("SELECT id, Franja FROM franjaedades");
    $estados = $conn->query("SELECT  id, Estado FROM estado");
    $categorias = $conn->query("SELECT DISTINCT Tipo FROM tipoobjeto");

    // Depuración: Verificar si las consultas se ejecutan correctamente
    if (!$localidades || !$edades || !$estados || !$categorias) {
        die("Error en la consulta: " . $conn->error);
    }
    ?>
    
    <form action="" method="GET">
        <label for="localidad">Localidad:</label>
        <select name="localidad" id="localidad">
            <option value="">Seleccionar localidad</option>
            <?php while ($row = $localidades->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= $row['Localidad'] ?></option>
            <?php endwhile; ?>
        </select>
        
        <label for="edad">Edad:</label>
        <select name="edad" id="edad">
            <option value="">Seleccionar edad</option>
            <?php while ($row = $edades->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= $row['Franja'] ?></option>
            <?php endwhile; ?>
        </select>

        <label for="estado">Estado:</label>
        <select name="estado" id="estado">
            <option value="">Seleccionar estado</option>
            <?php while ($row = $estados->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= $row['Estado'] ?></option>
            <?php endwhile; ?>
        </select>

        <label for="categoria">Categoría:</label>
        <select name="categoria" id="categoria">
            <option value="">Seleccionar categoría</option>
            <?php while ($row = $categorias->fetch_assoc()): ?>
                <option value="<?= $row['Tipo'] ?>"><?= $row['Tipo'] ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Filtrar</button>
    </form>
    
    <div class="results">
    <?php
    // Mostrar resultados filtrados
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $localidad = $_GET['localidad'] ?? '';
        $edad = $_GET['edad'] ?? '';
        $estado = $_GET['estado'] ?? '';
        $categoria = $_GET['categoria'] ?? '';

        $query = "SELECT p.Nombre, p.Descripcion, l.Localidad, f.Franja, p.idEstado AS Estado, t.Tipo
                  FROM publicacion p
                  LEFT JOIN localidad l ON p.idLocalidad = l.id
                  LEFT JOIN franjaedades f ON p.idFranja = f.id
                  LEFT JOIN tipoobjeto t ON p.idObjeto = t.id
                  WHERE 1=1";  

        // Agregar filtros a la consulta
        if ($localidad) $query .= " AND l.id = '$localidad'";
        if ($edad) $query .= " AND f.id = '$edad'";
        if ($estado) $query .= " AND p.idEstado = '$estado'";
        if ($categoria) $query .= " AND t.Tipo = '$categoria'";

        // Depuración: Verificar la consulta final antes de ejecutarla
        // echo "Consulta SQL: $query"; // Descomenta solo si necesitas depurar la consulta

        $result = $conn->query($query);

        // Depuración: Verificar si la consulta devuelve resultados
        if (!$result) {
            die("Error en la consulta: " . $conn->error);
        }

        // Mostrar resultados solo si existen
        if ($result->num_rows > 0): ?>
            <h2>Resultados</h2>
            <div class="items-container">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="item">
                        <a href="info.php?id=<?php echo $row['id']; ?>">
                            <img src="<?php echo isset($row['imagen']) && $row['imagen'] ? $row['imagen'] : '../assets/img/fotoejemplo.jpg'; ?>" alt="Imagen">
                            <p><?php echo $row['Nombre']; ?></p>
                        </a>
                        <!-- Estrella para añadir a favoritos -->
                        <span class="favorito-icon" data-id="<?php echo $row['id']; ?>">
                            <i class="fas fa-star"></i> <!-- Aquí se usa FontAwesome para la estrella -->
                        </span>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No se encontraron resultados para los filtros seleccionados.</p>
        <?php endif;

        $result->free();
    }
    ?>
    </div>

    <?php include 'footer.php'; ?>

</body>
</html>
