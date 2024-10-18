<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gestión de Contratos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../Assets/css/sidebar.css">
</head>

<body>
    <!-- Sidebar -->
    <?php include "./side/sidebar_ds.php"; ?>

    <!-- Main Content -->
    <div class="content">
        <header class="text-center">
            <h1>Dashboard - Gestión de Contratos</h1>
        </header>

        <div class="container dashboard-container">
            <div class="row justify-content-center g-4">
                <div class="col-md-4 d-flex align-items-stretch">
                    <div class="card w-100" onclick="location.href='ContratoA.php'">
                        <div class="card-body text-center">
                            <i class="fas fa-file-contract card-icon"></i>
                            <h3 class="card-title mt-3">Contrato de Servicio a Terceros</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 d-flex align-items-stretch">
                    <div class="card w-100" onclick="location.href='ContratoB.php'">
                        <div class="card-body text-center">
                            <i class="fas fa-handshake card-icon"></i>
                            <h3 class="card-title mt-3">Contrato con Distribuidores</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 d-flex align-items-stretch">
                    <div class="card w-100" onclick="location.href='ContratoC.php'">
                        <div class="card-body text-center">
                            <i class="fas fa-users card-icon"></i>
                            <h3 class="card-title mt-3">Contrato con Clientes</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>Sistema de Gestión de Contratos &copy; 2024</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('closed');
        }
    </script>
</body>

</html>