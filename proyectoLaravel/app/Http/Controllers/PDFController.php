<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use FPDF;

class PDFController extends Controller
{
    protected $pdf;

    public function __construct()
    {
        // Crear instancia de FPDF
        $this->pdf = new FPDF();
    }

    public function generarPDF()
    {
        // Configuración inicial del PDF
        $this->pdf->AddPage();
        $this->pdf->SetFont('Arial', 'B', 16);
        
        // Título
        $this->pdf->Cell(190, 10, 'Mi Primer Reporte', 1, 1, 'C');
        
        // Contenido
        $this->pdf->SetFont('Arial', '', 12);
        $this->pdf->Cell(190, 10, 'Este es un reporte de ejemplo', 0, 1, 'L');
        
        // Descargar el PDF
        return response($this->pdf->Output('S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="mi_reporte.pdf"');
    }

    public function reporteTabla()
    {
        // Agregar página
        $this->pdf->AddPage();
        
        // Título
        $this->pdf->SetFont('Arial', 'B', 16);
        $this->pdf->Cell(190, 10, 'Reporte con Tabla', 1, 1, 'C');
        
        // Encabezados de la tabla
        $this->pdf->SetFont('Arial', 'B', 12);
        $this->pdf->Cell(40, 10, 'ID', 1);
        $this->pdf->Cell(75, 10, 'Nombre', 1);
        $this->pdf->Cell(75, 10, 'Email', 1);
        $this->pdf->Ln();
        
        // Datos de ejemplo
        $this->pdf->SetFont('Arial', '', 12);
        for($i = 1; $i <= 10; $i++) {
            $this->pdf->Cell(40, 10, $i, 1);
            $this->pdf->Cell(75, 10, "Usuario " . $i, 1);
            $this->pdf->Cell(75, 10, "usuario{$i}@email.com", 1);
            $this->pdf->Ln();
        }
        
        return response($this->pdf->Output('S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="reporte_tabla.pdf"');
    }

    public function reporteConImagen()
    {
        $this->pdf->AddPage();
        
        // Agregar imagen (asegúrate de que la ruta sea correcta)
        $this->pdf->Image(public_path('logo.png'), 10, 10, 50);
        
        $this->pdf->SetFont('Arial', 'B', 16);
        $this->pdf->Cell(190, 10, 'Reporte con Imagen', 0, 1, 'C');
        
        return response($this->pdf->Output('S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="reporte_imagen.pdf"');
    }
}