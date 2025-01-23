<?php
// Conexión a la base de datos
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'hackathon';

$conn = new mysqli($host, $user, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar las localidades para los select
$sql_localidades = "SELECT id, Localidad FROM localidad";
$result_localidades = $conn->query($sql_localidades);

// Consultar los estados para los select
$sql_estados = "SELECT id, Estado FROM estado";
$result_estados = $conn->query($sql_estados);

// Consultar las franjas de edades para los select
$sql_franjas = "SELECT id, Franja FROM franjaedades";
$result_franjas = $conn->query($sql_franjas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juguetes</title>
    <link rel="stylesheet" href="../assets/css/catalogo.css">
    <link rel="stylesheet" href="../assets/css/principal.css">
</head>
<body>
<?php include 'topNavFinal.php'; ?>

    <div class="contenedor">
        <header>
            <h1>
                <?php
                $tipo = $_GET['tipo'] ?? '';
                echo !empty($tipo) ? htmlspecialchars($tipo) : "Categoría no especificada";
                ?>
            </h1>
        </header>

        <main>
            <section class="filtros">
                <form action="" method="get">
                    <input type="hidden" name="tipo" value="<?php echo htmlspecialchars($tipo); ?>">

                    <select name="localidad" id="localidad">
                        <option value="">Selecciona una localidad</option>
                        <?php if ($result_localidades && $result_localidades->num_rows > 0): ?>
                            <?php while ($localidad = $result_localidades->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($localidad['id']); ?>">
                                    <?php echo htmlspecialchars($localidad['Localidad']); ?>
                                </option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </select>

                    <select name="estado" id="estado">
                        <option value="">Selecciona un estado</option>
                        <?php if ($result_estados && $result_estados->num_rows > 0): ?>
                            <?php while ($estado = $result_estados->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($estado['id']); ?>">
                                    <?php echo htmlspecialchars($estado['Estado']); ?>
                                </option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </select>

                    <select name="franja" id="franja">
                        <option value="">Selecciona una franja de edad</option>
                        <?php if ($result_franjas && $result_franjas->num_rows > 0): ?>
                            <?php while ($franja = $result_franjas->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($franja['id']); ?>">
                                    <?php echo htmlspecialchars($franja['Franja']); ?>
                                </option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </select>

                    <button type="submit">Filtrar</button>
                </form>
            </section>

            <section class="productos-categoria">
                <?php
                // Filtrar solo por tipo (idObjeto)
                if (!empty($tipo)) {
                    $tipo_filtro = $conn->real_escape_string($tipo);
                    $sql_productos = "SELECT id, Nombre, Descripcion FROM publicacion WHERE idObjeto = '$tipo_filtro'";

                    $result_productos = $conn->query($sql_productos);

                    if ($result_productos && $result_productos->num_rows > 0) {
                        while ($producto = $result_productos->fetch_assoc()) {
                            echo "<div class='producto'>
                                    <a href='info.php?id={$producto['id']}' class='item'>
                                        <img src='../assets/img/fotoejemplo.jpg' alt='Imagen'>
                                        <p>" . htmlspecialchars($producto['Nombre']) . "</p>
                                    </a>
                                  </div>";
                        }
                    } else {
                        echo "<p>No hay productos disponibles en esta categoría.</p>";
                    }
                } else {
                    echo "<p>No se especificó ninguna categoría para filtrar.</p>";
                }
                ?>
            </section>
        </main>
    </div>

</body>
</html>

<?php
$conn->close();
?>
