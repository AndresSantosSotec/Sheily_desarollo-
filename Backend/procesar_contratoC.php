<?php
// Incluir la configuración de la conexión a la base de datos
include "conexion_bd.php";

// Asegurarse de que $pdo esté disponible en este archivo
global $pdo;

// Variable para almacenar el mensaje de alerta
$alertMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombreEmisor = $_POST['nombreEmisor'];
    $edadEmisor = $_POST['edadEmisor'];
    $dpiEmisor = $_POST['dpiEmisor'];
    $departamentoEmisionEmisor = $_POST['departamentoEmisor'];
    $municipioEmisionEmisor = $_POST['municipioEmisor'];
    $representanteEmisor = $_POST['representanteEmisor'];
    $entidadEmisor = $_POST['entidadEmisor'];
    $acreditaEmisor = $_POST['acreditaEmisor'];
    $notarioEmisor = $_POST['notarioEmisor'];
    $registroMercantilEmisor = $_POST['registroMercantilEmisor'];
    $folioEmisor = $_POST['folioEmisor'];
    $libroEmisor = $_POST['libroEmisor'];
    
    $nombreDistribuidor = $_POST['nombreDistribuidor'];
    $edadDistribuidor = $_POST['edadDistribuidor'];
    $dpiDistribuidor = $_POST['dpiDistribuidor'];
    $departamentoEmisionDistribuidor = $_POST['departamentoDistribuidor'];
    $municipioEmisionDistribuidor = $_POST['municipioDistribuidor'];
    $representanteDistribuidor = $_POST['representanteDistribuidor'];
    $entidadDistribuidor = $_POST['entidadDistribuidor'];
    $acreditaDistribuidor = $_POST['acreditaDistribuidor'];
    $notarioDistribuidor = $_POST['notarioDistribuidor'];
    $registroMercantilDistribuidor = $_POST['registroMercantilDistribuidor'];
    $folioDistribuidor = $_POST['folioDistribuidor'];
    $libroDistribuidor = $_POST['libroDistribuidor'];
    $actividadEconomica = $_POST['actividadEconomica'];
    $nitDistribuidor = $_POST['nitDistribuidor'];
    $fechaVigencia = $_POST['fechaVigencia'];

    // Consulta SQL de inserción
    $sql = "INSERT INTO contrato_c (
                nombre_emisor, edad_emisor, dpi_emisor, 
                departamento_emision_emisor, municipio_emision_emisor, 
                representante_emisor, entidad_emisor, acredita_emisor, 
                notario_emisor, registro_mercantil_emisor, folio_emisor, libro_emisor, 
                nombre_distribuidor, edad_distribuidor, dpi_distribuidor, 
                departamento_emision_distribuidor, municipio_emision_distribuidor, 
                representante_distribuidor, entidad_distribuidor, acredita_distribuidor, 
                notario_distribuidor, registro_mercantil_distribuidor, folio_distribuidor, 
                libro_distribuidor, actividad_economica, nit_distribuidor, 
                fecha_vigencia
            ) VALUES (
                :nombreEmisor, :edadEmisor, :dpiEmisor, 
                :departamentoEmisionEmisor, :municipioEmisionEmisor, 
                :representanteEmisor, :entidadEmisor, :acreditaEmisor, 
                :notarioEmisor, :registroMercantilEmisor, :folioEmisor, :libroEmisor, 
                :nombreDistribuidor, :edadDistribuidor, :dpiDistribuidor, 
                :departamentoEmisionDistribuidor, :municipioEmisionDistribuidor, 
                :representanteDistribuidor, :entidadDistribuidor, :acreditaDistribuidor, 
                :notarioDistribuidor, :registroMercantilDistribuidor, :folioDistribuidor, 
                :libroDistribuidor, :actividadEconomica, :nitDistribuidor, 
                :fechaVigencia
            )";

    $stmt = $pdo->prepare($sql);

    // Asignar los valores a los parámetros
    $stmt->bindParam(':nombreEmisor', $nombreEmisor);
    $stmt->bindParam(':edadEmisor', $edadEmisor);
    $stmt->bindParam(':dpiEmisor', $dpiEmisor);
    $stmt->bindParam(':departamentoEmisionEmisor', $departamentoEmisionEmisor);
    $stmt->bindParam(':municipioEmisionEmisor', $municipioEmisionEmisor);
    $stmt->bindParam(':representanteEmisor', $representanteEmisor);
    $stmt->bindParam(':entidadEmisor', $entidadEmisor);
    $stmt->bindParam(':acreditaEmisor', $acreditaEmisor);
    $stmt->bindParam(':notarioEmisor', $notarioEmisor);
    $stmt->bindParam(':registroMercantilEmisor', $registroMercantilEmisor);
    $stmt->bindParam(':folioEmisor', $folioEmisor);
    $stmt->bindParam(':libroEmisor', $libroEmisor);
    $stmt->bindParam(':nombreDistribuidor', $nombreDistribuidor);
    $stmt->bindParam(':edadDistribuidor', $edadDistribuidor);
    $stmt->bindParam(':dpiDistribuidor', $dpiDistribuidor);
    $stmt->bindParam(':departamentoEmisionDistribuidor', $departamentoEmisionDistribuidor);
    $stmt->bindParam(':municipioEmisionDistribuidor', $municipioEmisionDistribuidor);
    $stmt->bindParam(':representanteDistribuidor', $representanteDistribuidor);
    $stmt->bindParam(':entidadDistribuidor', $entidadDistribuidor);
    $stmt->bindParam(':acreditaDistribuidor', $acreditaDistribuidor);
    $stmt->bindParam(':notarioDistribuidor', $notarioDistribuidor);
    $stmt->bindParam(':registroMercantilDistribuidor', $registroMercantilDistribuidor);
    $stmt->bindParam(':folioDistribuidor', $folioDistribuidor);
    $stmt->bindParam(':libroDistribuidor', $libroDistribuidor);
    $stmt->bindParam(':actividadEconomica', $actividadEconomica);
    $stmt->bindParam(':nitDistribuidor', $nitDistribuidor);
    $stmt->bindParam(':fechaVigencia', $fechaVigencia);

    // Ejecutar la consulta y mostrar mensaje de éxito o error
    if ($stmt->execute()) {
        $alertMessage = "
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>¡Éxito!</strong> El contrato ha sido creado con éxito.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        ";
    } else {
        $alertMessage = "
            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>¡Error!</strong> Ocurrió un problema al crear el contrato.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        ";
    }
}
?>

<!-- HTML para mostrar la alerta -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesar Contrato C</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <?php if (!empty($alertMessage)) echo $alertMessage; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
