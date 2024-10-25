<?php
// Configuración de la conexión a la base de datos usando PDO
$db_host = 'localhost';
$db_name = 'corposystemas_bd';
$db_username = 'root';
$db_password = ''; 

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES utf8");
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Consulta para obtener los contratos de tipo B
$sql = "SELECT id_contrato, nombre_distribuidor, entidad, tipo_documento, 
               nit, fecha_inicio, fecha_fin, direccion_distribuidora, 
               fecha_creacion, fecha_actualizacion 
        FROM contrato_b";

try {
    $result = $pdo->query($sql);
} catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
}
?>

<div class="card mt-4" style="max-width: 720px; margin: auto; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
    <div class="card-header text-center py-2 bg-primary text-white">
        <h6 class="mb-0">Listado de Contratos - Distribuidores</h6>
    </div>
    <div class="card-body p-4">
        <table class="table table-sm table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Distribuidor</th>
                    <th>Entidad</th>
                    <th>Tipo Documento</th>
                    <th>NIT</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr>
                            <td>' . $row['id_contrato'] . '</td>
                            <td>' . $row['nombre_distribuidor'] . '</td>
                            <td>' . $row['entidad'] . '</td>
                            <td>' . $row['tipo_documento'] . '</td>
                            <td>' . $row['nit'] . '</td>
                            <td>' . $row['fecha_inicio'] . '</td>
                            <td>' . $row['fecha_fin'] . '</td>
                            <td class="d-flex justify-content-between">
                                <button class="btn btn-sm btn-info me-1" title="Descargar">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button class="btn btn-sm btn-warning me-1" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" 
                                    onclick="eliminarContrato(' . $row['id_contrato'] . ', \'B\')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>';
                    }
                } else {
                    echo '<tr><td colspan="8" class="text-center">No se encontraron contratos.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Función para eliminar un contrato tipo B utilizando AJAX y SweetAlert
    function eliminarContrato(id, tipo) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esta acción.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../Backend/eliminar_contrato.php',
                    type: 'POST',
                    data: { id: id, tipo: tipo },
                    success: function(response) {
                        Swal.fire(
                            'Eliminado',
                            'El contrato ha sido eliminado.',
                            'success'
                        ).then(() => {
                            location.reload(); // Recargar la página para actualizar la lista
                        });
                    },
                    error: function() {
                        Swal.fire(
                            'Error',
                            'Hubo un problema al eliminar el contrato.',
                            'error'
                        );
                    }
                });
            }
        });
    }
</script>
