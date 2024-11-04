<?php
require('../fpdf186/fpdf.php');
//include './Backend/conexion_bd.php';

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
        $this->SetFont('Times', 'B', 12);
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
        $this->SetFont('Times', '', 10);
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

// Crear instancia del PDF y establecer márgenes personalizados (25.4 mm)
$pdf = new PDF();
$pdf->SetMargins(25.4, 25.4, 25.4);  // Margen de 25.4 mm (2.54 cm) en izquierda, arriba y derecha
$pdf->SetAutoPageBreak(true, 25.4);   // Margen de 25.4 mm (2.54 cm) abajo
$pdf->AddPage();

// Variables dinámicas
$Corpo_nombre = 'ERIK LEONEL PAZ CHÉN';
$Corpor_edad = 'cuarenta y ocho años';
$Dpi_corpo = '1636 88699 1608';
$Muni_corpo = 'Cobán';
$Dep_corpo = 'Alta Verapaz';

// Texto con secciones en negrita
$entreNosotros = "

            Entre Nosotros
                    
        a) $Corpo_nombre, de $Corpor_edad, casado, empresario, guatemalteco, de este domicilio, quien se identifica con Documento Personal de Identificación (DPI) con Código Único de Identificación (CUI) un mil seiscientos treinta y seis, ochenta y ocho mil seiscientos noventa y nueve, un mil seiscientos ocho ($Dpi_corpo) extendido por el Registro Nacional de las Personas de la República de Guatemala, en el municipio de $Muni_corpo, del departamento de $Dep_corpo, quien comparece en su calidad de ADMINISTRADOR ÚNICO Y REPRESENTANTE LEGAL de la entidad CORPOSISTEMAS, SOCIEDAD ANONIMA, en lo sucesivo CORPOSISTEMAS calidad que acredita con el Acta Notarial de su nombramiento autorizada en esta ciudad el día tres de julio del dos mil veinte por el Notario MANUEL ANTONIO LÓPEZ OLIVA, el cual se encuentra debidamente inscrito en el Registro Mercantil General de la República bajo el número de Registro seiscientos mil doscientos dos (600202) folio doscientos quince (215) del Libro setecientos cincuenta y uno (751) de Auxiliares de Comercio.

        b)

        C)
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
// Función para convertir números en letras
function num2letras($num)
{
    $unidades = ['', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve', 'diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve'];
    $decenas = ['', '', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
    $centenas = ['', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos'];

    if ($num == 0) {
        return 'cero';
    }

    if ($num == 100) {
        return 'cien';
    }

    if ($num < 20) {
        return $unidades[$num];
    }

    if ($num < 100) {
        $decena = intdiv($num, 10);
        $unidad = $num % 10;
        return $unidad ? $decenas[$decena] . ' y ' . $unidades[$unidad] : $decenas[$decena];
    }

    if ($num < 1000) {
        $centena = intdiv($num, 100);
        $resto = $num % 100;
        return $centenas[$centena] . ' ' . num2letras($resto);
    }

    if ($num < 1000000) {
        $miles = intdiv($num, 1000);
        $resto = $num % 1000;
        if ($miles == 1) {
            return 'mil ' . num2letras($resto);
        }
        return num2letras($miles) . ' mil ' . num2letras($resto);
    }

    if ($num < 1000000000) {
        $millones = intdiv($num, 1000000);
        $resto = $num % 1000000;
        if ($millones == 1) {
            return 'un millón ' . num2letras($resto);
        }
        return num2letras($millones) . ' millones ' . num2letras($resto);
    }

    return 'Número demasiado grande para convertir';
}

// Función para convertir DPI a letras
function num2letrasDPI($dpi)
{
    $partes = str_split($dpi, 4);  // Dividir el DPI en bloques de 4 dígitos
    $letras = [];
    
    foreach ($partes as $parte) {
        $letras[] = num2letras(intval($parte));  // Convertir cada parte a letras
    }

    return implode(' ', $letras);  // Unir las partes convertidas con espacios
}

// Función para convertir fechas a letras
function fechaALetras($fecha)
{
    setlocale(LC_TIME, 'es_ES.UTF-8');  // Configurar localización en español
    return strftime('%d de %B de %Y', strtotime($fecha));  // Formato: 1 de enero de 2023
}



?>
