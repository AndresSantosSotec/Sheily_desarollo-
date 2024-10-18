<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Corpo_Inicio</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="./Assets/css/login_styles.css">
</head>

<body class="bg-light d-flex align-items-center" style="min-height: 100vh;">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card shadow-lg p-4">
                    <div class="row">
                        <!-- Caja Trasera -->
                        <div class="col-md-6 d-flex flex-column align-items-center justify-content-center bg-primary text-white p-4">
                            <h3>¿Ya tienes una cuenta?</h3>
                            <p>Inicia sesión para entrar en la página</p>
                            <button class="btn btn-light mt-3" id="btn__iniciar-sesion">Iniciar Sesión</button>

                            <hr class="text-white w-75">

                            <h3>¿Aún no tienes una cuenta?</h3>
                            <p>Regístrate para poder iniciar sesión</p>
                            <button class="btn btn-light" id="btn__registrarse">Registrarse</button>
                        </div>

                        <!-- Formularios de Login y Registro -->
                        <div class="col-md-6">
                            <!-- Navegación de Pestañas -->
                            <ul class="nav nav-tabs" id="loginRegisterTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="login-tab" data-bs-toggle="tab" href="#login" role="tab"
                                       aria-controls="login" aria-selected="true">Iniciar Sesión</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="register-tab" data-bs-toggle="tab" href="#register" role="tab"
                                       aria-controls="register" aria-selected="false">Registrarse</a>
                                </li>
                            </ul>

                            <div class="tab-content" id="loginRegisterContent">
                                <!-- Formulario de Login -->
                                <div id="login" class="tab-pane fade show active" role="tabpanel" aria-labelledby="login-tab">
                                    <h2 class="text-center mt-3">Iniciar Sesión</h2>
                                    <form action="./Backend/login.php" method="POST" class="p-4">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Correo Electrónico</label>
                                            <input type="email" class="form-control" id="email" name="correo" placeholder="Ingresa tu correo" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Contraseña</label>
                                            <input type="password" class="form-control" id="password" name="contrasena" placeholder="Ingresa tu contraseña" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                                    </form>
                                </div>

                                <!-- Formulario de Registro -->
                                <div id="register" class="tab-pane fade" role="tabpanel" aria-labelledby="register-tab">
                                    <h2 class="text-center mt-3">Registrarse</h2>
                                    <form action="./Backend/Register.php" method="POST" class="p-4">
                                        <div class="mb-3">
                                            <label for="nombre" class="form-label">Nombre</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa tu nombre" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="apellido" class="form-label">Apellido</label>
                                            <input type="text" class="form-control" id="apellido" name="apellidos" placeholder="Ingresa tu apellido" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email-register" class="form-label">Correo Electrónico</label>
                                            <input type="email" class="form-control" id="email-register" name="correo" placeholder="Ingresa tu correo" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="usuario" class="form-label">Usuario</label>
                                            <input type="text" class="form-control" id="usuario" name="Usuario" placeholder="Ingresa tu nombre de usuario" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password-register" class="form-label">Contraseña</label>
                                            <input type="password" class="form-control" id="password-register" name="password" placeholder="Crea una contraseña" required>
                                        </div>
                                        <button type="submit" class="btn btn-success w-100">Registrarse</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Cambiar entre Login y Registro usando Bootstrap Tabs
        document.getElementById('btn__iniciar-sesion').addEventListener('click', () => {
            const loginTab = new bootstrap.Tab(document.querySelector('#login-tab'));
            loginTab.show();
        });

        document.getElementById('btn__registrarse').addEventListener('click', () => {
            const registerTab = new bootstrap.Tab(document.querySelector('#register-tab'));
            registerTab.show();
        });
    </script>
</body>

</html>
