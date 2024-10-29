<?php
// Configuración de la conexión a la base de datos usando PDO
$db_host = 'localhost';
$db_name = 'corposystemas_bd';
$db_username = 'root';
$db_password = ''; // Cambia si tienes contraseña configurada



try {
    // Crear la conexión usando PDO
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES utf8"); // Asegura la codificación UTF-8
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Consulta SQL para obtener los contratos de la tabla contratos_a
$sql = "SELECT id_contrato, nombre_receptor, tarifa_mensual, 
               rango_documentos, fecha_validez, fecha_creacion 
        FROM contratos_a";

try {
    $result = $pdo->query($sql); // Ejecutar la consulta
} catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
}
?>

<div class="card mt-3" style="max-width: 800px; margin: auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <div class="card-header text-center py-2 bg-primary text-white">
        <h6 class="mb-0">Listado de Contratos</h6>
    </div>
    <div class="card-body p-3">
        <table class="table table-sm table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Receptor</th>
                    <th>Tarifa Mensual</th>
                    <th>Rango</th>
                    <th>Fecha de Validez</th>
                    <th>Fecha de Creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Generar las filas de la tabla con los datos obtenidos
                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr>
                            <td>' . $row['id_contrato'] . '</td>
                            <td>' . $row['nombre_receptor'] . '</td>
                            <td>Q' . number_format($row['tarifa_mensual'], 2) . '</td>
                            <td>' . $row['rango_documentos'] . '</td>
                            <td>' . $row['fecha_validez'] . '</td>
                            <td>' . $row['fecha_creacion'] . '</td>
                                <td>
                                    <a href="../Docs/Documentos/repoA.php?id_contrato=' . $row['id_contrato'] . '" 
                                       class="btn btn-sm btn-info" title="Descargar" target="_blank">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <button class="btn btn-sm btn-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" 
                                        onclick="eliminarContrato(' . $row['id_contrato'] . ', \'A\')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                        </tr>';
                    }
                } else {
                    echo '<tr><td colspan="7" class="text-center">No se encontraron contratos.</td></tr>';
                }
                ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-end mt-3">
            <button class="btn btn-success" onclick="agregarRegistro()">
                <i class="fas fa-plus"></i> Agregar Registro
            </button>
        </div>
    </div>
</div>

<script>
    // Función para manejar el evento de agregar un nuevo registro
    function agregarRegistro() {
        // Redirigir al formulario de registro de un nuevo contrato
        window.location.href = './ContratoA.php';
    }

    // Función para eliminar un contrato con SweetAlert y AJAX
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
                // Enviar solicitud AJAX para eliminar el contrato
                $.ajax({
                    url: '../Backend/eliminar_contrato.php',
                    type: 'POST',
                    data: {
                        id: id,
                        tipo: tipo
                    },
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

<!-- Incluir SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>