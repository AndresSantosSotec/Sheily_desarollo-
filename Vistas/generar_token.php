<?php
require_once '../Backend/conexion_bd.php';

// Obtener ID de contrato y tipo de contrato desde POST
$id_contrato = $_POST['id_contrato'] ?? null;
$tipo_contrato = $_POST['tipo_contrato'] ?? null;

if (!$id_contrato || !$tipo_contrato) {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
    exit;
}

// Generar un token único y definir una fecha de expiración (por ejemplo, en 1 hora)
$token = bin2hex(random_bytes(16));
$fecha_expiracion = date('Y-m-d H:i:s', strtotime('+1 hour'));

// Guardar el token en la base de datos
$query = "INSERT INTO contrato_tokens (id_contrato, tipo_contrato, token, fecha_expiracion, usado) VALUES (:id_contrato, :tipo_contrato, :token, :fecha_expiracion, 0)";
$stmt = $pdo->prepare($query);
$stmt->execute([
    ':id_contrato' => $id_contrato,
    ':tipo_contrato' => $tipo_contrato,
    ':token' => $token,
    ':fecha_expiracion' => $fecha_expiracion
]);

// Generar enlace dinámico adaptado a cualquier servidor y ruta de base
$protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$basePath = dirname($_SERVER['REQUEST_URI'], 2); // Ajusta la base de acuerdo a la estructura de carpetas
$enlace = "{$protocolo}://{$host}{$basePath}/Vistas/ver_contrato.php?token=$token";

// Devolver el enlace en formato JSON para ser usado en SweetAlert
echo json_encode(['status' => 'success', 'enlace' => $enlace]);
?>
