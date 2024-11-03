<?php
require('fpdf.php');

// Crear un nuevo objeto PDF
$this->pdf = new FPDF();
$this->pdf->AddPage();

// Fuente y tamaño
$this->pdf->SetFont('Arial', 'B', 12);

// Cabecera de la tabla
$header = array('SITIO', 'SERVICIO', '24H', '12H', 'TURNO', 'DIAS', 'CIUDAD');
$w = array(40, 60, 15, 15, 20, 20, 30);

// Color de fondo de la cabecera
$this->pdf->SetFillColor(224, 235, 255);

// Cabecera
for($i=0;$i<count($header);$i++)
    $this->pdf->Cell($w[$i],7,$header[$i],1,0,'C',1);
$this->pdf->Ln();

// Restaurar color
$this->pdf->SetFillColor(224, 235, 255);

// Datos de la tabla (ajusta los datos según tus necesidades)
$data = array(
    array('VIGILANCIA (CONTROL ACCESOS)', '3', '24 H', 'L-D', 'GUAYAQUIL'),
    array('PLANTA DE PROCESAMIENTO GYE', 'VIGILANCIA (JEFE DE GRUPO)', '1', 'DIURNO', 'L-V', 'GUAYAQUIL'),
    // ... Agrega más filas aquí
);

// Contenido de la tabla
foreach($data as $row)
{
    $this->pdf->Cell($w[0],6,$row[0],1);
    for($i=1;$i<count($row);$i++)
        $this->pdf->Cell($w[$i],6,$row[$i],1);
    $this->pdf->Ln();
}

