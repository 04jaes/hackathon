<?php
// Parámetros de conexión
$servidor = "localhost";     // Dirección del servidor, si es local, usar 'localhost'
$usuario = "root";     // Tu usuario de la base de datos
$contraseña = ""; // La contraseña de tu base de datos
$baseDatos = "hackathon";    // El nombre de la base de datos (en tu caso 'hackathon')

// Crear la conexión
$conexion = new mysqli($servidor, $usuario, $contraseña, $baseDatos);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Establecer el conjunto de caracteres a UTF-8
$conexion->set_charset("utf8");
?>
