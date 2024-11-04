<?php
require('fpdf.php');

// Crear un nuevo objeto PDF
$this->pdf->pdf = new FPDF();
$this->pdf->pdf->AddPage();

// Fuente y tamaño
$this->pdf->pdf->SetFont('Arial', 'B', 12);

// Cabecera de la tabla
$header = array('SITIO', 'SERVICIO', '24H', '12H', 'TURNO', 'DIAS', 'CIUDAD');
$w = array(40, 60, 15, 15, 20, 20, 30);

// Color de fondo de la cabecera
$this->pdf->pdf->SetFillColor(224, 235, 255);

// Cabecera
for($i=0;$i<count($header);$i++)
    $this->pdf->pdf->Cell($w[$i],7,$header[$i],1,0,'C',1);
$this->pdf->pdf->Ln();

// Restaurar color
$this->pdf->pdf->SetFillColor(224, 235, 255);

// Datos de la tabla (ajusta los datos según tus necesidades)
$data = array(
    array('VIGILANCIA (CONTROL ACCESOS)', '3', '24 H', 'L-D', 'GUAYAQUIL'),
    array('PLANTA DE PROCESAMIENTO GYE', 'VIGILANCIA (JEFE DE GRUPO)', '1', 'DIURNO', 'L-V', 'GUAYAQUIL'),
    // ... Agrega más filas aquí
);

// Contenido de la tabla
foreach($data as $row)
{
    $this->pdf->pdf->Cell($w[0],6,$row[0],1);
    for($i=1;$i<count($row);$i++)
        $this->pdf->pdf->Cell($w[$i],6,$row[$i],1);
    $this->pdf->pdf->Ln();
}

foreach ($datos as $reporte) {
    $this->pdf->SetFont('Arial', '', 10);
    $this->pdf->Cell(30, 10, $reporte['id'], 1);
    $this->pdf->Cell(60, 10, $reporte['cliente'], 1);
    $this->pdf->Cell(30, 10, $reporte['fecha_reporte'], 1);
    $this->pdf->Cell(30, 10, $reporte['no_reporte'], 1);
    $this->pdf->Ln();

    foreach ($reporte['incidentes'] as $lugar => $incidentes) {
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->Cell(0, 10, 'Incidentes en: ' . $lugar, 0, 1);
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->Cell(30, 10, 'Fecha', 1);
        $this->pdf->Cell(30, 10, 'Hora', 1);
        $this->pdf->Cell(60, 10, 'Incidente', 1);
        $this->pdf->Cell(0, 10, 'Descripción', 1);
        $this->pdf->Ln();

        foreach ($incidentes as $incidente) {
            $this->pdf->Cell(30, 10, $incidente['Fecha'], 1);
            $this->pdf->Cell(30, 10, $incidente['Hora'], 1);
            $this->pdf->Cell(60, 10, $incidente['Incidente'], 1);
            $this->pdf->Cell(0, 10, $incidente['Descripción'], 1);
            $this->pdf->Ln();
        }
        $this->pdf->Ln();
    }
}