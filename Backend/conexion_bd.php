<?php
// Configuración de la conexión a la base de datos usando PDO
$db_host = 'localhost';
$db_name = 'corposystemas_bd';
$db_username = 'root';
$db_password = ''; // Cambia si tienes una contraseña configurada

try {
    // Crear la conexión usando PDO
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES utf8"); // Asegura la codificación UTF-8
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
