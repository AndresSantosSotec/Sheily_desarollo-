<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CORPO SISTEMAS</title>
    <!-- Favicon -->
    <link rel="icon" href="Assets/img/logos/logo.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="Assets/css/login_styles.css" rel="stylesheet">
    <!-- SweetAlert CSS & JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="container auth-container">
    <div class="card auth-card">
        <div class="form-header">
            <h3 id="form-title">Iniciar Sesión</h3>
            <p id="form-description">Por favor, inicia sesión para continuar</p>
        </div>

        <!-- Alert success message (hidden by default) -->
        <div id="register-success" class="alert alert-success" role="alert" style="display:none;">
            ¡Usuario registrado correctamente! Ahora puedes iniciar sesión.
        </div>

        <!-- Login Form -->
        <form id="login-form" action="../Backend/auth.php" method="POST" onsubmit="handleLogin(event)">
            <input type="hidden" name="action" value="login">
            <div class="mb-3">
                <label for="login-email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" name="correo_electronico" id="login-email" placeholder="Ingresa tu correo" required>
            </div>
            <div class="mb-3">
                <label for="login-password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="contrasena" id="login-password" placeholder="Ingresa tu contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
        </form>

        <!-- Register Form -->
        <form id="register-form" action="../Backend/auth.php" method="POST" style="display: none;" onsubmit="handleRegister(event)">
            <input type="hidden" name="action" value="register">
            <div class="mb-3">
                <label for="register-name" class="form-label">Nombre Completo</label>
                <input type="text" class="form-control" name="nombre_completo" id="register-name" placeholder="Ingresa tu nombre completo" required>
            </div>
            <div class="mb-3">
                <label for="register-email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" name="correo_electronico" id="register-email" placeholder="Ingresa tu correo" required>
            </div>
            <div class="mb-3">
                <label for="register-password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="contrasena" id="register-password" placeholder="Crea una contraseña" required>
            </div>
            <div class="mb-3">
                <label for="register-confirm-password" class="form-label">Confirmar Contraseña</label>
                <input type="password" class="form-control" id="register-confirm-password" placeholder="Confirma tu contraseña" required>
            </div>
            <div id="register-alert" class="alert alert-danger" role="alert" style="display:none;"></div>
            <button type="submit" class="btn btn-success w-100">Crear Cuenta</button>
        </form>

        <div class="form-footer">
            <span id="login-link">¿No tienes una cuenta? <a href="#" onclick="showRegisterForm()">Regístrate aquí</a></span>
            <span id="register-link" style="display: none;">¿Ya tienes una cuenta? <a href="#" onclick="showLoginForm()">Inicia sesión aquí</a></span>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function showRegisterForm() {
        document.getElementById('login-form').style.display = 'none';
        document.getElementById('register-form').style.display = 'block';
        document.getElementById('form-title').innerText = 'Crear Cuenta';
        document.getElementById('form-description').innerText = 'Por favor, completa el formulario para registrarte';
        document.getElementById('login-link').style.display = 'none';
        document.getElementById('register-link').style.display = 'block';
    }

    function showLoginForm() {
        document.getElementById('login-form').style.display = 'block';
        document.getElementById('register-form').style.display = 'none';
        document.getElementById('form-title').innerText = 'Iniciar Sesión';
        document.getElementById('form-description').innerText = 'Por favor, inicia sesión para continuar';
        document.getElementById('login-link').style.display = 'block';
        document.getElementById('register-link').style.display = 'none';
    }

    function handleLogin(event) {
        event.preventDefault();
        const formData = new FormData(document.getElementById('login-form'));

        fetch('../Backend/auth.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                sessionStorage.setItem('api_key', data.api_key);
                sessionStorage.setItem('usos_restantes', data.usos_restantes);
                sessionStorage.setItem('usuario_id', data.usuario_id);
                window.location.href = data.redirect;
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un problema en el servidor.');
        });
    }

    function handleRegister(event) {
        event.preventDefault();
        const formData = new FormData(document.getElementById('register-form'));

        fetch('../Backend/auth.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('register-success').style.display = 'block';
                document.getElementById('register-alert').style.display = 'none';
                showLoginForm();
            } else {
                document.getElementById('register-alert').style.display = 'block';
                document.getElementById('register-alert').innerText = data.message;
                document.getElementById('register-success').style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un problema en el servidor.');
        });
    }
</script>

</body>
</html>
