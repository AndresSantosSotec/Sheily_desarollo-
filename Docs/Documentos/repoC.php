<?php
require('../fpdf186/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        // Ruta de la imagen de fondo
        $path = realpath(__DIR__ . '/ContratoBC.jpeg');
        if (!$path) {
            die('Error: Imagen de fondo no encontrada.');
        }

        // Insertar imagen de fondo que cubra toda la página
        $this->Image($path, 0, 0, $this->GetPageWidth(), $this->GetPageHeight());

        // Posicionar el título
        $this->SetY(15);
        $this->SetFont('Times', 'B', 16);
        $this->SetTextColor(0, 0, 128);
        $this->Cell(0, 10, utf8_decode('CONTRATO DE PRESTACIÓN DE SERVICIOS -FEL-'), 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer()
    {
        // Posicionar el pie de página a 15mm del final
        $this->SetY(-15);
        $this->SetFont('Times', 'I', 8);
        $this->SetTextColor(128, 128, 128);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }

    function AddSection($title, $content)
    {
        // Título en negrita
        $this->SetFont('Times', 'B', 12);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(0, 10, utf8_decode($title), 0, 1, 'L');
        $this->Ln(2);

        // Contenido con ciertas partes en negrita
        $this->SetFont('Times', '', 12);
        $this->MultiCell(0, 8, utf8_decode($content), 0, 'J');
        $this->Ln(8);
    }

    function WriteTextWithBold($text, $boldSections = [])
    {
        $this->SetFont('Times', '', 12);
        $this->SetTextColor(0, 0, 0);
        
        foreach ($boldSections as $bold) {
            $parts = explode($bold, $text, 2);
            $this->Write(8, utf8_decode($parts[0]));  // Texto normal
            $this->SetFont('Times', 'B', 12);
            $this->Write(8, utf8_decode($bold));  // Texto en negrita
            $this->SetFont('Times', '', 12);
            $text = $parts[1] ?? '';
        }
        // Escribir el resto del texto si quedó algo
        if (!empty($text)) {
            $this->Write(8, utf8_decode($text));
        }
    }
}

// Crear instancia del PDF
$pdf = new PDF();
$pdf->AddPage();

// Variables dinámicas
$nombre_emisor = 'ERIK LEONEL PAZ CHÉN';
$edad_emisor = 'cuarenta y ocho años';
$dpi_emisor = '1636 88699 1608';
$municipio_emisor = 'Cobán';
$departamento_emisor = 'Alta Verapaz';

// Texto con secciones en negrita
$entreNosotros = "
a) $nombre_emisor, de $edad_emisor, casado, empresario, guatemalteco, de este domicilio, quien se identifica con Documento Personal de Identificación (DPI) con Código Único de Identificación (CUI) un mil seiscientos treinta y seis, ochenta y ocho mil seiscientos noventa y nueve, un mil seiscientos ocho ($dpi_emisor) extendido por el Registro Nacional de las Personas de la República de Guatemala, en el municipio de $municipio_emisor, del departamento de $departamento_emisor, quien comparece en su calidad de ADMINISTRADOR ÚNICO Y REPRESENTANTE LEGAL de la entidad CORPOSISTEMAS, SOCIEDAD ANONIMA, en lo sucesivo CORPOSISTEMAS calidad que acredita con el Acta Notarial de su nombramiento autorizada en esta ciudad el día tres de julio del dos mil veinte por el Notario MANUEL ANTONIO LÓPEZ OLIVA, el cual se encuentra debidamente inscrito en el Registro Mercantil General de la República bajo el número de Registro seiscientos mil doscientos dos (600202) folio doscientos quince (215) del Libro setecientos cincuenta y uno (751) de Auxiliares de Comercio.
";

// Secciones en negrita
$boldSections = [
    'ERIK LEONEL PAZ CHÉN', 
    'ADMINISTRADOR ÚNICO Y REPRESENTANTE LEGAL',
    'CORPOSISTEMAS, SOCIEDAD ANONIMA'
];

// Añadir el contenido de la sección con negritas
$pdf->WriteTextWithBold($entreNosotros, $boldSections);

// Generar el PDF
$pdf->Output('I', 'Contrato_FEL_Entre_Nosotros.pdf');
?>
