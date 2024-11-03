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
            [
                'id' => 1,
                'cliente' => 'REYSAC S.A',
                'fecha_reporte' => '2024-11-02',
                'no_reporte' => '001',
                'items' => [
                    'Primera descripción del sitio o actividad.',
                    'Segunda descripción del sitio o actividad.',
                    'Tercera descripción del sitio o actividad.',
                ],
                'tabla' => [
                    ['VIGILANCIA (CONTROL ACCESOS)', '3', '24 H', 'L-D', 'GUAYAQUIL', 'DIURNO', 'GUAYAQUIL'],
                    ['MONITOREO', '2', '12 H', 'L-V', 'GUAYAQUIL', 'NOCTURNO', 'GUAYAQUIL'],
                ]
            ],
            // ... otros reportes
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
        $margenOriginal = $this->pdf->GetX();
  

        $this->pdf->SetFont('Arial', 'B', 14);
        $this->pdf->Cell(0, 10, utf8_decode('INFORME DE GESTIÓN - PROTEMAXI'), 0, 1, 'C');
        $this->pdf->Ln(5); // Espacio debajo del encabezado

        $this->pdf->SetFont('Arial', 'B', 12);
        $this->pdf->Cell(0, 10, utf8_decode('CORRESPONDIENTE AL SERVICIO DE SEGURIDAD FÍSICA DE'), 0, 1, 'C');
        $this->pdf->Cell(0, 10, utf8_decode('PROTEMAXI C. LTDA.,  EN EL PROYECTO ' . $datos['cliente'] ), 0, 1, 'C');
        $this->pdf->Ln(20); // Espacio debajo del encabezado

    

        // Configuración de la fuente y márgenes
        $this->pdf->SetFont('Arial', '', 9);
        $lineHeight = 5;
        $this->pdf->SetMargins(10, 10, 10);

        $this->pdf->SetFont('Arial', 'B', 9);

        // Crear una tabla simple con bordes solo en el lado derecho
        $this->pdf->Cell(40, $lineHeight, 'CLIENTE:', 0, 0, 'L'); // Reduced width for left cell
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->Cell(0, $lineHeight, utf8_decode($datos['cliente']), 1, 1, 'L');

        $this->pdf->Ln(3); // Add spacing between rows

        $this->pdf->Cell(40, $lineHeight, 'DESTINATARIOS:', 0, 0, 'L');
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->Cell(0, $lineHeight, utf8_decode($datos['cliente']), 1, 1, 'L');

        $this->pdf->Ln(3);

        $this->pdf->Cell(40, $lineHeight, 'FECHA DE REPORTE:', 0, 0, 'L');
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->Cell(0, $lineHeight, utf8_decode($datos['fecha_reporte']), 1, 1, 'L');

        $this->pdf->Ln(3);

        $this->pdf->SetFont('Arial', 'B', 9);
        // ... (similarly for other fields)

        $this->pdf->Cell(40, $lineHeight, 'PERIODO:', 0, 0, 'L');
        $this->pdf->Cell(60, $lineHeight, utf8_decode($datos['cliente']), 1, 0, 'L'); // Agregamos borde a la derecha
        
        // Agregar un espacio en blanco entre las celdas
        $this->pdf->Cell(10, $lineHeight, '', 0, 0, 'L');
        
        $this->pdf->Cell(30, $lineHeight, 'NO. DE REPORTE:', 0, 0, 'L');
        $this->pdf->Cell(50, $lineHeight, utf8_decode($datos['cliente']), 1, 1, 'L');


        // ... (resto del contenido del PDF)

        // ... (otros campos que desees agregar)

        // Salto de línea
        $this->pdf->Ln();

        
      
        
        // Contenido
        $this->pdf->SetFont('Arial', 'B', 11);
        $this->pdf->Cell(190, 10, utf8_decode('1.	INTRODUCCIÓN'), 0, 1, 'L');
        $this->pdf->SetFont('Arial', '', 9);
        $this->pdf->MultiCell(190, $lineHeight, utf8_decode('La información presentada en el siguiente informe corresponde a las actividades de seguridad, control y prevención que fueron realizadas por nuestro personal en las instalaciones de nuestro cliente ' . $datos['cliente'] . ' durante el mes de ' . $datos['fecha_reporte'] . ', en los siguientes sitios donde se presta el servicio:'), 0, 'J');        
        // Descargar el PDF
        $this->pdf->SetLeftMargin(20);
       
        // Lista numerada dinámica desde el array $datos['items']
        if (isset($datos['items']) && is_array($datos['items'])) {
        $counter = 1;
        foreach ($datos['items'] as $item) {
            $this->pdf->Ln(2); // Espacio entre los elementos de la lista
            $this->pdf->MultiCell(190, $lineHeight, utf8_decode($counter . '. ' . $item), 0, 'L');
            $counter++;
        }
        }

        $this->pdf->Ln();
        $this->pdf->SetX($margenOriginal); // Utiliza SetX() para una mayor precisión
        $this->pdf->MultiCell(190, $lineHeight, utf8_decode('Este informe tiene como objetivo proporcionar un resumen detallado de las actividades realizadas, incidencias, y mejoras implementadas durante el periodo.'), 0, 'J');        
        $this->pdf->Ln();

        $this->pdf->SetX($margenOriginal);
        $this->pdf->SetFont('Arial', 'B', 11);
        $this->pdf->Cell(190, 10, utf8_decode('2.	RESÚMEN DE ACTIVIDADES'), 0, 1, 'L');
        $this->pdf->SetX($margenOriginal);
        $this->pdf->Cell(190, 10, utf8_decode('2.1.	COBERTURA DEL SERVICIO'), 0, 1, 'L');
        $this->pdf->SetX($margenOriginal);

        $this->pdf->SetFont('Arial', '', 9);
        $this->pdf->MultiCell(190, $lineHeight, utf8_decode('El servicio de seguridad se mantuvo cubierto en todos los sitios durante el periodo, con un total de '. $datos['cliente'].' puestos de servicio para asegurar una vigilancia constante en las áreas asignadas, de acuerdo a la siguiente tabla:'), 0, 'J');        


        #tabla 1

        $this->pdf->Ln();
        $this->pdf->SetX($margenOriginal);
        // Fuente y tamaño
        $this->pdf->SetFont('Arial', 'B', 8);

        // Cabecera de la tabla
        $header = array('SITIO', 'SERVICIO', '24H', '12H', 'TURNO', 'DIAS', 'CIUDAD');
        $w = array(40, 50, 15, 15, 20, 20, 30);

        // Color de fondo de la cabecera (negro)
        $this->pdf->SetFillColor(0, 0, 0);

        // Color del texto (blanco)
        $this->pdf->SetTextColor(255, 255, 255);

        $this->pdf->SetX($margenOriginal);

        // Cabecera
        for($i=0;$i<count($header);$i++)
            $this->pdf->Cell($w[$i],7,$header[$i],1,0,'C',1);
        $this->pdf->Ln();

        // Restaurar color
        $this->pdf->SetFillColor(224, 235, 255);
        $this->pdf->SetTextColor(0, 0, 0);
       

        // Contenido de la tabla
        
        $this->pdf->SetFont('Arial', '', 8);
         // Procesar los datos de la tabla
         if (!empty($datos['tabla']) && is_array($datos['tabla'])) {
            foreach ($datos['tabla'] as $row) {
                if (is_array($row)) {  // Verificar que la fila sea un array
                    $this->pdf->SetX($margenOriginal);
                    foreach ($w as $index => $width) {
                        $value = isset($row[$index]) ? $row[$index] : '';
                        $this->pdf->Cell($width, 6, utf8_decode($value), 1, 0, 'C');
                    }
                    $this->pdf->Ln();
                }
            }
        }


        

        

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
