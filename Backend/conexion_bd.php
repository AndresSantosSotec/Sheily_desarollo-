<?php
// Configuración de bd en localHost
$db_host = 'localhost';
$db_username = 'root';
$db_password = ''; // Cambia por una contraseña si la tienes configurada
$db_name = 'corposystemas_bd'; // Asegúrate de que este nombre sea correcto y existe

// Conexión a la base de datos
$conexion = new mysqli($db_host, $db_username, $db_password, $db_name);

// Manejo de errores
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
} else {
    $conexion->set_charset("utf8"); // Asegúrate de que la conexión sea exitosa antes de intentar esto
}

?>
