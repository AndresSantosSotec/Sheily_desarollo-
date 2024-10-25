<?php
require('../fpdf186/fpdf.php');

class PDF extends FPDF
{
    // Sobrescribimos el método Header para colocar la imagen de fondo
    function Header()
    {
        // Definir la ruta exacta del archivo
        $path = realpath(__DIR__ . '/ContratoA.jpeg');
        
        if (!$path) {
            die('Error: Imagen de fondo no encontrada en la ruta proporcionada.');
        }

        $this->Image($path, 0, 0, $this->GetPageWidth(), $this->GetPageHeight());
    }

    // Pie de página opcional
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }

    // Agregar el contenido del contrato
    function AddContent($content)
    {
        $this->SetFont('Times', '', 12);
        $this->MultiCell(0, 10, utf8_decode($content));
    }
}

// Crear una instancia del PDF
$pdf = new PDF();
$pdf->AddPage();

// Contenido del contrato (ejemplo reducido)
$contrato = "
CONTRATO DE PRESTACIÓN DE SERVICIOS -FEL-

Entre nosotros:

a) ERIK LEONEL PAZ CHÉN, de cincuenta años, casado, empresario, guatemalteco, ...
";

$pdf->AddContent($contrato);

// Generar y mostrar el PDF en el navegador
$pdf->Output('I', 'Contrato.pdf');
?>
