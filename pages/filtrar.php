<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/filtros.css">
    <title>Filtrar Publicaciones</title>
</head>
<body>
    <?php
    // Conexión a la base de datos
    $host = 'localhost';
    $database = 'hackathon1';
    $user = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo '<p>Error al conectar con la base de datos: ' . htmlspecialchars($e->getMessage()) . '</p>';
        exit;
    }

    // Obtener opciones para los filtros
    $localidades = $pdo->query("SELECT id, Localidad FROM localidad")->fetchAll(PDO::FETCH_ASSOC);
    $franjasEdades = $pdo->query("SELECT id, Franja FROM franjaedades")->fetchAll(PDO::FETCH_ASSOC);
    try {
        $estados = $pdo->query("SELECT id, Estado FROM estado")->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $categorias = $pdo->query("SELECT DISTINCT Tipo FROM tipoobjeto")->fetchAll(PDO::FETCH_ASSOC);

    // Obtener los valores de los filtros
    $localidad = $_GET['localidad'] ?? '';
    $edad = $_GET['edad'] ?? '';
    $estados = $_GET['estado'] ?? '';
    $categoria = $_GET['categoria'] ?? '';


    // Construir la consulta SQL dinámicamente
    $sql = "SELECT p.Nombre, p.Descripcion, l.Localidad, f.Franja AS Edad, e.Estado, t.Tipo AS Categoria
            FROM publicacion p
            LEFT JOIN localidad l ON p.idLocalidad = l.id
            LEFT JOIN franjaedades f ON p.idFranja = f.id
            LEFT JOIN estado e ON p.idEstado = e.id
            LEFT JOIN tipoobjeto t ON p.idObjeto = t.id
            WHERE 1";

    $params = [];
    if ($localidad) {
        $sql .= " AND l.id = :localidad";
        $params[':localidad'] = $localidad;
    }
    if ($edad) {
        $sql .= " AND f.id = :edad";
        $params[':edad'] = $edad;
    }
    if ($estados) {
        $sql .= " AND e.id = :estado";
        $params[':estado'] = $estadoSeleccionado;
    }
    if ($categoria) {
        $sql .= " AND t.Tipo = :categoria";
        $params[':categoria'] = $categoria;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <form action="" method="GET">
        <label for="localidad">Localidad:</label>
        <select name="localidad" id="localidad">
            <option value="">Seleccionar localidad</option>
            <?php foreach ($localidades as $loc): ?>
                <option value="<?= htmlspecialchars($loc['id']) ?>" <?= $localidad == $loc['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($loc['Localidad']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="edad">Edad:</label>
        <select name="edad" id="edad">
            <option value="">Seleccionar edad</option>
            <?php foreach ($franjasEdades as $franja): ?>
                <option value="<?= htmlspecialchars($franja['id']) ?>" <?= $edad == $franja['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($franja['Franja']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="estado">Estado:</label>
        <select name="estado" id="estado">
            <option value="">Seleccionar estado</option>
            <?php foreach ($estadoSeleccionado as $est): ?>
                <option value="<?= htmlspecialchars($est['id']) ?>" <?= $estadoSeleccionado == $est['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($est['Estado']) ?>
                    

                </option>
            <?php endforeach; ?>
        </select>

        <label for="categoria">Categoría:</label>
        <select name="categoria" id="categoria">
            <option value="">Seleccionar categoría</option>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= htmlspecialchars($cat['Tipo']) ?>" <?= $categoria == $cat['Tipo'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['Tipo']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Filtrar</button>
    </form>

    <h2>Resultados</h2>
    <?php if ($resultados): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Localidad</th>
                    <th>Edad</th>
                    <th>Estado</th>
                    <th>Categoría</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultados as $fila): ?>
                    <tr>
                        <td><?= htmlspecialchars($fila['Nombre']) ?></td>
                        <td><?= htmlspecialchars($fila['Descripcion']) ?></td>
                        <td><?= htmlspecialchars($fila['Localidad']) ?></td>
                        <td><?= htmlspecialchars($fila['Edad']) ?></td>
                        <td><?= htmlspecialchars($fila['Estado']) ?></td>
                        <td><?= htmlspecialchars($fila['Categoria']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No se encontraron resultados.</p>
    <?php endif; ?>
</body>
</html>
