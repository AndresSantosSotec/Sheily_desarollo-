<?php 
// Mostrar todos los errores de PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'conexion_bd.php'; // Incluye el archivo de conexión a la base de datos

header('Content-Type: application/json'); // Asegura que la respuesta siempre sea JSON
// Control de CORS, esto es opcional si estás trabajando en diferentes dominios.
// Si no es necesario, puedes eliminar estos encabezados.
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Verificar la conexión a la base de datos
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Error de conexión a la base de datos: ' . $conn->connect_error]);
    exit();
}

// Función para verificar si un correo ya está registrado
function verificarCorreoExistente($email, $conn) {
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0; // Retorna true si el correo ya está registrado
}

// Función para registrar un nuevo usuario
function registrarUsuario($nombre, $email, $password, $conn) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Encripta la contraseña
    $rol = 'user'; // El rol por defecto será 'user', puede cambiarse según sea necesario

    $sql = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $email, $hashed_password, $rol);
    
    if ($stmt->execute()) {
        return true; // Usuario registrado correctamente
    } else {
        return false; // Error en el registro
    }
}

// Función para iniciar sesión y actualizar el último acceso
function iniciarSesion($email, $password, $conn) {
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verifica si la contraseña es correcta
    if ($user && password_verify($password, $user['password'])) {
        // Actualiza la fecha del último acceso
        $sql_update = "UPDATE usuarios SET ultimo_acceso = NOW() WHERE id_usuario = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("i", $user['id_usuario']);
        $stmt_update->execute();

        // Iniciar sesión exitosamente
        session_start();
        $_SESSION['usuario_id'] = $user['id_usuario'];
        $_SESSION['nombre'] = $user['nombre'];
        $_SESSION['rol'] = $user['rol']; // Puede ser útil para manejar roles

        return ['status' => 'success', 'message' => 'Inicio de sesión exitoso', 'redirect' => 'Vistas/Dashboard.php'];
    } else {
        return ['status' => 'error', 'message' => 'Correo o contraseña incorrectos'];
    }
}

// Procesar las solicitudes
try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $action = $_POST['action'];

        if ($action == 'register') {
            $nombre = $_POST['nombre_completo'];
            $email = $_POST['correo_electronico'];
            $password = $_POST['contrasena'];

            // Validar que los campos no estén vacíos
            if (empty($nombre) || empty($email) || empty($password)) {
                echo json_encode(['status' => 'error', 'message' => 'Todos los campos son obligatorios']);
                exit();
            }

            // Verificar si el correo ya está registrado
            if (verificarCorreoExistente($email, $conn)) {
                echo json_encode(['status' => 'error', 'message' => 'Este correo ya está registrado']);
                exit();
            }

            // Registrar al usuario
            if (registrarUsuario($nombre, $email, $password, $conn)) {
                echo json_encode(['status' => 'success', 'message' => 'Usuario registrado correctamente']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error en el registro']);
            }

        } elseif ($action == 'login') {
            $email = $_POST['correo_electronico'];
            $password = $_POST['contrasena'];

            // Validar que los campos no estén vacíos
            if (empty($email) || empty($password)) {
                echo json_encode(['status' => 'error', 'message' => 'Todos los campos son obligatorios']);
                exit();
            }

            // Iniciar sesión
            $loginResponse = iniciarSesion($email, $password, $conn);
            echo json_encode($loginResponse);
        }
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Error en el servidor: ' . $e->getMessage()]);
}
