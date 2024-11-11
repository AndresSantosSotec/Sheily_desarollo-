<?php
require_once '../Backend/conexion_bd.php';

// Obtener el token de la URL
$token = $_GET['token'] ?? null;

if (!$token) {
    die('Enlace inválido.');
}

// Consultar el token en la base de datos
$query = "SELECT * FROM contrato_tokens WHERE token = :token AND usado = 0";
$stmt = $pdo->prepare($query);
$stmt->execute([':token' => $token]);
$tokenData = $stmt->fetch();

if (!$tokenData || new DateTime() > new DateTime($tokenData['fecha_expiracion'])) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Enlace expirado o ya utilizado',
                text: 'El enlace que estás intentando acceder ha expirado o ya ha sido utilizado.',
                confirmButtonText: 'Cerrar'
            }).then(() => {
                window.close();
            });
        });
    </script>";
    exit;
}

// Marcar el token como usado para que el enlace expire
$updateTokenQuery = "UPDATE contrato_tokens SET usado = 1 WHERE token = :token";
$updateTokenStmt = $pdo->prepare($updateTokenQuery);
$updateTokenStmt->execute([':token' => $token]);

// Aviso con SweetAlert antes de abrir el PDF
echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'info',
            title: 'Aviso Importante',
            text: 'Al cerrar esta pestaña, el enlace no podrá abrirse de nuevo.',
            confirmButtonText: 'Abrir Contrato'
        }).then(() => {
            // Redirigir al PDF del contrato específico
            let tipoContrato = '{$tokenData['tipo_contrato']}';
            let idContrato = '{$tokenData['id_contrato']}';

            switch (tipoContrato) {
                case 'A':
                    window.location.href = 'repoA.php?id_contrato=' + idContrato;
                    break;
                case 'B':
                    window.location.href = 'repoB.php?id_contrato=' + idContrato;
                    break;
                case 'C':
                    window.location.href = 'repoC.php?id_contrato=' + idContrato;
                    break;
                default:
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Tipo de contrato inválido.',
                        confirmButtonText: 'Cerrar'
                    }).then(() => {
                        window.close();
                    });
            }
        });
    });
</script>";
?>
