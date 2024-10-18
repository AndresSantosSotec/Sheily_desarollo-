<?php
// Incluye la conexión a la base de datos
include 'conexion_bd.php';

// Recibe los valores desde el formulario y escapa los caracteres especiales
$nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
$apellidos = mysqli_real_escape_string($conexion, $_POST['apellidos']);
$correo = mysqli_real_escape_string($conexion, $_POST['correo']);
$usuario = mysqli_real_escape_string($conexion, $_POST['Usuario']); // Este campo es "Usuario" con mayúscula según el formulario
$password = mysqli_real_escape_string($conexion, $_POST['password']);

// Verificar si el correo ya está registrado
$consultaCorreo = "SELECT * FROM usuarios WHERE correo = '$correo'";
$resultadoCorreo = mysqli_query($conexion, $consultaCorreo);

if (mysqli_num_rows($resultadoCorreo) > 0) {
    echo '
        <script>
        alert("Error: El correo electrónico ya está registrado. Utiliza otro.");
        window.location="../index.php";
        </script>';
    exit;
}

// Verificar si el usuario ya está registrado
$consultaUsuario = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
$resultadoUsuario = mysqli_query($conexion, $consultaUsuario);

if (mysqli_num_rows($resultadoUsuario) > 0) {
    echo '
        <script>
        alert("Error: El nombre de usuario ya está registrado. Elige otro.");
        window.location="../index.php";
        </script>';
    exit;
}

// Hashear la contraseña antes de almacenarla
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insertar el nuevo usuario en la base de datos
$query = "INSERT INTO usuarios (nombre, apellidos, correo, usuario, password) 
          VALUES ('$nombre', '$apellidos', '$correo', '$usuario', '$hashed_password')";

$ejecutar = mysqli_query($conexion, $query);

// Verificar si se realizó la inserción correctamente
if ($ejecutar) {
    echo '
        <script>
        alert("Usuario registrado correctamente.");
        window.location="../index.php";
        </script>';
} else {
    // Si hay un error, mostrar el error de MySQL para ayudar con la depuración
    echo '
        <script>
        alert("Error: ' . mysqli_error($conexion) . '");
        window.location="../index.php";
        </script>';
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
