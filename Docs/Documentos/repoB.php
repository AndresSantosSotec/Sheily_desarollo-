<?php
require('../fpdf186/fpdf.php');
require('conexion_bd.php'); // Conexión a la base de datos

class PDF extends FPDF
{
    function Header()
    {
        // Imagen de fondo
        $path = realpath(__DIR__ . '/ContratoBC.jpeg');
        if (!$path) {
            die('Error: Imagen de fondo no encontrada.');
        }
        $this->Image($path, 0, 0, $this->GetPageWidth(), $this->GetPageHeight());

        // Encabezado del contrato
        $this->SetY(15);
        $this->SetFont('Times', 'B', 12);
        $this->SetTextColor(0, 0, 128);
        $this->Cell(0, 10, utf8_decode('CONTRATO DE DISTRIBUCIÓN Y SERVICIOS - B'), 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer()
    {
        // Pie de página
        $this->SetY(-15);
        $this->SetFont('Times', 'I', 8);
        $this->SetTextColor(128, 128, 128);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }

    function AddSection($title, $content)
    {
        $this->SetFont('Times', 'B', 12);
        $this->SetTextColor(0, 0, 128);
        $this->Cell(0, 10, utf8_decode($title), 0, 1);
        
        $this->SetLineWidth(0.5);
        $this->SetDrawColor(0, 0, 128);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(5);

        $this->SetFont('Times', '', 10);
        $this->SetTextColor(0, 0, 0);
        $this->MultiCell(0, 8, utf8_decode($content), 0, 'J');
        $this->Ln(8);
    }
}

// Validación del ID del contrato
if (isset($_GET['id_contrato']) && is_numeric($_GET['id_contrato'])) {
    $id_contrato = $_GET['id_contrato'];

    $sql = "SELECT * FROM contrato_b WHERE id_contrato = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$id_contrato]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        $pdf = new PDF();
        $pdf->AddPage();

        // Variables dinámicas del contrato B
        $nombre_emisor = $data['nombre_emisor'];
        $edad_emisor = ucfirst(num2letras($data['edad_emisor']));
        $dpi_emisor = $data['dpi_emisor'];
        $nombre_distribuidor = $data['nombre_distribuidor'];
        $edad_distribuidor = ucfirst(num2letras($data['edad_distribuidor']));
        $dpi_distribuidor = $data['dpi_distribuidor'];
        $municipio = $data['municipio'];
        $departamento = $data['departamento'];
        $representante_legal = $data['representante_legal'];
        $entidad = $data['entidad'];
        $nit = $data['nit'];
        $fecha_inicio = fechaALetras($data['fecha_inicio']);
        $fecha_fin = fechaALetras($data['fecha_fin']);
        $direccion_distribuidora = $data['direccion_distribuidora'];

        // Secciones del contrato
        $intro = "
Entre nosotros:
a) $nombre_emisor, de $edad_emisor años, identificado con DPI $dpi_emisor...
b) $nombre_distribuidor, de $edad_distribuidor años, identificado con DPI $dpi_distribuidor, domiciliado en $municipio, $departamento, en calidad de $representante_legal de $entidad.
        ";

        $pdf->AddSection('Introducción', $intro);
        $pdf->AddSection('Cláusula Primera', "
El representante legal de CORPOSISTEMAS declara que su empresa es una entidad mercantil organizada y reconocida según las leyes de Guatemala.
        ");
        $pdf->AddSection('Cláusula Segunda', "
El DISTRIBUIDOR declara que su empresa se dedica a: (Objeto según la patente de comercio)...
        ");
        $pdf->AddSection('Vigencia del Contrato', "
Este contrato tendrá vigencia desde el $fecha_inicio hasta el $fecha_fin, renovándose automáticamente si no se notifica lo contrario.
        ");
        $pdf->AddSection('Confidencialidad', "
Ambas partes se comprometen a mantener la confidencialidad de la información intercambiada durante y después de la vigencia del contrato.
        ");

        // Salida del PDF
        $pdf->Output('I', 'Contrato_B.pdf');
    } else {
        echo "Contrato no encontrado.";
    }
} else {
    echo "ID del contrato no proporcionado o no válido.";
}

// Funciones auxiliares
function num2letras($num) {
    $unidades = ['', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
    $decenas = ['', 'diez', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];

    if ($num < 10) return $unidades[$num];
    if ($num < 100) {
        $unidad = $num % 10;
        $decena = intdiv($num, 10);
        return $unidad ? $decenas[$decena] . ' y ' . $unidades[$unidad] : $decenas[$decena];
    }
    return (string)$num;
}

function fechaALetras($fecha) {
    setlocale(LC_TIME, 'es_ES.UTF-8');
    return strftime('%d de %B de %Y', strtotime($fecha));
}
?>
