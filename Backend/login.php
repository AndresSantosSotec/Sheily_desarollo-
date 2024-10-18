<?php
// Inicializa la sesión y llama a la conexión
session_start();
include 'conexion_bd.php'; // Incluir conexión a la base de datos

// Recibir valores del formulario
$correo = mysqli_real_escape_string($conexion, $_POST['correo']);
$contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);

// Consulta para obtener el hash de la contraseña almacenada en la base de datos
$validar_login = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo = '$correo'");

if (mysqli_num_rows($validar_login) > 0) {
    $usuario = mysqli_fetch_assoc($validar_login);

    // Verificar si la contraseña ingresada coincide con el hash almacenado
    if (password_verify($contrasena, $usuario['password'])) {
        // Almacenar datos en la sesión
        $_SESSION['id_usuario'] = $usuario['id'];
        $_SESSION['correo'] = $usuario['correo'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['usuario'] = $usuario['usuario'];

        // Redirigir al usuario al Dashboard
        header("location: ../Vistas/Dashboard.php");
        exit; // Detener la ejecución después de la redirección
    } else {
        echo '
            <script>
                alert("Contraseña incorrecta. Inténtalo de nuevo.");
                window.location = "../index.php";
            </script>';
        exit;
    }
} else {
    echo '
        <script>
            alert("El correo no está registrado.");
            window.location = "../index.php";
        </script>';
    exit;
}
?>
