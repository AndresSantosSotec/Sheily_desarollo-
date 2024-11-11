<?php
// Conexión a la base de datos
require_once '../Backend/conexion_bd.php';

// Variables de filtro
$filtroNombre = $_GET['nombre'] ?? '';
$filtroTipo = $_GET['tipo_contrato'] ?? '';

// Variables de paginación
$registrosPorPagina = 8;
$paginaActual = $_GET['pagina'] ?? 1;
$offset = ($paginaActual - 1) * $registrosPorPagina;

// Consultas para obtener el número total de registros de cada tipo de contrato con filtros
$queryCount = "SELECT COUNT(*) FROM (
    SELECT id_contrato FROM contratos_a WHERE nombre_emisor LIKE :nombre AND (:tipo = '' OR 'A' = :tipo)
    UNION ALL
    SELECT id_contrato FROM contrato_b WHERE nombre_emisor LIKE :nombre AND (:tipo = '' OR 'B' = :tipo)
    UNION ALL
    SELECT id_contrato FROM contrato_c WHERE nombre_emisor LIKE :nombre AND (:tipo = '' OR 'C' = :tipo)
) AS all_contratos";

$params = [
    ':nombre' => "%$filtroNombre%",
    ':tipo' => $filtroTipo
];

$totalStmt = $pdo->prepare($queryCount);
$totalStmt->execute($params);
$totalRegistros = $totalStmt->fetchColumn();
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);

// Consultas para obtener los registros actuales con límite y offset
$query = "(
    SELECT id_contrato, 'A' AS tipo, nombre_emisor, fecha_creacion FROM contratos_a WHERE nombre_emisor LIKE :nombre AND (:tipo = '' OR 'A' = :tipo)
    UNION ALL
    SELECT id_contrato, 'B' AS tipo, nombre_emisor, fecha_creacion FROM contrato_b WHERE nombre_emisor LIKE :nombre AND (:tipo = '' OR 'B' = :tipo)
    UNION ALL
    SELECT id_contrato, 'C' AS tipo, nombre_emisor, fecha_creacion FROM contrato_c WHERE nombre_emisor LIKE :nombre AND (:tipo = '' OR 'C' = :tipo)
) ORDER BY fecha_creacion DESC LIMIT :offset, :limit";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':nombre', $params[':nombre']);
$stmt->bindParam(':tipo', $params[':tipo']);
$stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
$stmt->bindValue(':limit', (int)$registrosPorPagina, PDO::PARAM_INT);
$stmt->execute();
$contratos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de contratos - Gestión de Contratos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../Assets/css/sidebar.css">
    <link rel="stylesheet" href="../Assets/css/renv.css">
</head>

<body>
    <!-- Sidebar -->
    <div id="sidebar">
        <?php include "./side/sidebar_enviar.php"; ?>
    </div>

    <!-- Main Content -->
    <div class="content" style="margin-left: 220px;">
        <header class="text-center">
            <h1 class="header-title">Registro de contratos - Gestión de Contratos</h1>
        </header>

        <div id="content-area">
            <!-- Card para el filtro y la tabla -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="mb-0">Filtros de Búsqueda</h6>
                </div>
                <div class="card-body">
                    <!-- Formulario de Filtro -->
                    <form method="GET" class="row g-2 mb-3">
                        <div class="col-md-4">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control form-control-sm" name="nombre" id="nombre" value="<?php echo htmlspecialchars($filtroNombre); ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="tipo_contrato" class="form-label">Tipo de Contrato</label>
                            <select class="form-select form-select-sm" name="tipo_contrato" id="tipo_contrato">
                                <option value="">Todos</option>
                                <option value="A" <?php echo $filtroTipo === 'A' ? 'selected' : ''; ?>>A</option>
                                <option value="B" <?php echo $filtroTipo === 'B' ? 'selected' : ''; ?>>B</option>
                                <option value="C" <?php echo $filtroTipo === 'C' ? 'selected' : ''; ?>>C</option>
                            </select>
                        </div>
                        <div class="col-md-4 align-self-end">
                            <button type="submit" class="btn btn-primary btn-sm w-100">Aplicar Filtro</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="mb-0">Resultados de Contratos</h6>
                </div>
                <div class="card-body">
                    <!-- Tabla con la información de todos los contratos -->
                    <table class="table table-sm table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Tipo de Contrato</th>
                                <th>Nombre</th>
                                <th>Fecha de Creación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($contratos)): ?>
                                <tr>
                                    <td colspan="4" class="text-center">No se encontraron contratos con los filtros aplicados.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($contratos as $contrato): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($contrato['tipo']); ?></td>
                                        <td><?php echo htmlspecialchars($contrato['nombre_emisor']); ?></td>
                                        <td><?php echo htmlspecialchars($contrato['fecha_creacion']); ?></td>
                                        <td>
                                            <!-- Botón para reenviar el enlace temporal -->
                                            <form action="reenviar_enlace.php" method="post" class="d-inline">
                                                <input type="hidden" name="id_contrato" value="<?php echo $contrato['id_contrato']; ?>">
                                                <input type="hidden" name="tipo_contrato" value="<?php echo $contrato['tipo']; ?>">
                                                <button type="button" class="btn btn-primary btn-sm reenviar-btn" data-id="<?php echo $contrato['id_contrato']; ?>" data-tipo="<?php echo $contrato['tipo']; ?>">
                                                    <i class="fas fa-share-square"></i> Reenviar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <!-- Paginación -->
                    <nav aria-label="Page navigation example">
                        <ul class="pagination pagination-sm justify-content-center" style="margin-top: 0.3rem;">
                            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                                <li class="page-item <?php echo $i == $paginaActual ? 'active' : ''; ?>">
                                    <a class="page-link" href="?pagina=<?php echo $i; ?>&nombre=<?php echo htmlspecialchars($filtroNombre); ?>&tipo_contrato=<?php echo htmlspecialchars($filtroTipo); ?>">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>Sistema de Gestión de Contratos &copy; 2024</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.querySelectorAll('.reenviar-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id_contrato = this.getAttribute('data-id');
                const tipo_contrato = this.getAttribute('data-tipo');

                // AJAX para generar token
                fetch('generar_token.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `id_contrato=${id_contrato}&tipo_contrato=${tipo_contrato}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire({
                                title: 'Enlace Generado',
                                text: 'Copia el enlace o envíalo por WhatsApp:',
                                input: 'text',
                                inputValue: data.enlace,
                                showCancelButton: true,
                                confirmButtonText: 'Copiar enlace',
                                cancelButtonText: 'Enviar por WhatsApp'
                            }).then(result => {
                                if (result.isConfirmed) {
                                    navigator.clipboard.writeText(data.enlace);
                                    Swal.fire('Enlace copiado', '', 'success');
                                } else if (result.dismiss === Swal.DismissReason.cancel) {
                                    const whatsappLink = `https://wa.me/?text=${encodeURIComponent('Aquí tienes el enlace para acceder al contrato: ' + data.enlace)}`;
                                    window.open(whatsappLink, '_blank');
                                }
                            });
                        } else {
                            Swal.fire('Error', 'No se pudo generar el enlace. Inténtalo de nuevo.', 'error');
                        }
                    });
            });
        });
    </script>

</body>

</html>