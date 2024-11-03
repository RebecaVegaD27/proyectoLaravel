<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use FPDF;

class PDFController extends Controller
{
    protected $pdf;

    public function index()
    {
        // Definición de los reportes como un array
        $reportes = [
            ['id' => 1, 'cliente' => 'REYSAC S.A', 'fecha_reporte' => '2024-11-02', 'no_reporte' => '001'],
            ['id' => 2, 'cliente' => 'PROTEMAXI', 'fecha_reporte' => '2024-11-02', 'no_reporte' => '002'],
            ['id' => 3, 'cliente' => 'MOLINOS CHAMPION', 'fecha_reporte' => '2024-11-02', 'no_reporte' => '003'],
        ];

        return view('welcome', compact('reportes'));
    }

    public function __construct()
    {
        // Crear instancia de FPDF extendida para incluir encabezado
        $this->pdf = new class extends FPDF {
            function Header()
            {
                // Agregar imagen de encabezado en la parte superior de cada página
                $this->Image(public_path('images/logo_reporte.png'), 10, 10, 190); // Ajusta la ruta y tamaño según necesidad
                $this->Ln(40);
            }
        };
    }

    public function generarPDF(Request $request)
    {
        // Configuración inicial del PDF
        $datos = $request->all();

        if (!isset($datos['cliente'])) {
            return response()->json(['error' => 'Cliente no especificado'], 400);
        }

        $this->pdf->AddPage();
        // $this->pdf->SetFont('Arial', 'B', 16);

        $this->pdf->SetFont('Arial', 'B', 14);
        $this->pdf->Cell(0, 10, 'INFORME DE GESTION - PROTEMAXI', 0, 1, 'C');
        $this->pdf->Ln(5); // Espacio debajo del encabezado

        $this->pdf->SetFont('Arial', 'B', 12);
        $this->pdf->Cell(0, 10, 'CORRESPONDIENTE AL SERVICIO DE SEGURIDAD FISICA DE', 0, 1, 'C');
        $this->pdf->Cell(0, 10, 'PROTEMAXI C. LTDA.,  EN EL PROYECTO ' . $datos['cliente'] , 0, 1, 'C');
        $this->pdf->Ln(20); // Espacio debajo del encabezado

    

        // Configuración de la fuente y márgenes
        $this->pdf->SetFont('Arial', '', 9);
        $lineHeight = 5;
        $this->pdf->SetMargins(10, 10, 10);

        $this->pdf->SetFont('Arial', 'B', 9);

        // Crear una tabla simple con bordes solo en el lado derecho
        $this->pdf->Cell(40, $lineHeight, 'CLIENTE:', 0, 0, 'L'); // Reduced width for left cell
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->Cell(0, $lineHeight, $datos['cliente'], 1, 1, 'L');

        $this->pdf->Ln(3); // Add spacing between rows

        $this->pdf->Cell(40, $lineHeight, 'DESTINATARIOS:', 0, 0, 'L');
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->Cell(0, $lineHeight, $datos['cliente'], 1, 1, 'L');

        $this->pdf->Ln(3);

        $this->pdf->Cell(40, $lineHeight, 'FECHA DE REPORTE:', 0, 0, 'L');
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->Cell(0, $lineHeight, $datos['cliente'], 1, 1, 'L');

        $this->pdf->Ln(3);

        $this->pdf->SetFont('Arial', 'B', 9);
        // ... (similarly for other fields)

        $this->pdf->Cell(30, $lineHeight, 'PERIODO:', 0, 0, 'L');
        $this->pdf->Cell(30, $lineHeight, $datos['cliente'], 1, 0, 'L'); // Agregamos borde a la derecha
        
        // Agregar un espacio en blanco entre las celdas
        $this->pdf->Cell(10, $lineHeight, '', 0, 0, 'L');
        
        $this->pdf->Cell(30, $lineHeight, 'No DE REPORTE:', 0, 0, 'L');
        $this->pdf->Cell(30, $lineHeight, $datos['cliente'], 1, 1, 'L');


        // ... (resto del contenido del PDF)

        // ... (otros campos que desees agregar)

        // Salto de línea
        $this->pdf->Ln();

        
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
        
        // Configuración del contenido del reporte
        $this->pdf->SetFont('Arial', 'B', 16);
        $this->pdf->Cell(190, 10, 'Reporte con Imagen', 0, 1, 'C');
        
        return response($this->pdf->Output('S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="reporte_imagen.pdf"');
    }
}
