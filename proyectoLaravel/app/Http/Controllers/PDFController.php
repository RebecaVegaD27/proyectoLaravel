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
                'items2' => [
                    'El día 21/08/2024 se realizó 1 prueba poligráfica al señor VINICIO VLADIMIR TUFIÑO TORO, chofer de la empresa RANSECORP.',
                ],
                'tabla' => [
                    ['VIGILANCIA', '3', '24', '1', 'GUAYAQUIL', 'DIURNO', 'GUAYAQUIL'],
                    ['MONITOREO', '2', '12', '2', 'GUAYAQUIL', 'NOCTURNO', 'GUAYAQUIL'],
                ],
                'tabla2' => [  // Nueva clave añadida
                    
                    ['PLANTA GYE', 211, 1476],
                    ['GRANJA BUCAY', 151, 454],
                    ['GRANJA LOMAS', 185, 1482],
                    ['GRANJA SAN CARLOS', 40, 316]
                ],
                'tabla3' => [  // Segunda clave añadida
            ['PLANTA GYE', 176, 448, 1333, 9, 1566],
            ['GRANJA BUCAY', 510, 8, 43, 15, 576],
            ['GRANJA LOMAS', 307, 2, 191, 12, 512],
            ['GRANJA SAN CARLOS', 577, 10, 103, 6, 696]
            
                ],

                'tabla4' => [  // Tercera clave añadida
            [1, '31/7/24', 693, 'LOMAS DE SARGENTILLO', 'SANTO DOMINGO', 'JOFFRE MONCERRATE - JUAN GUZMAN', '2 CONTENEDORES', 'UBA-3340 - UAA-3266'],
            [2, '1/8/24', 696, 'LOMAS DE SARGENTILLO', 'PALLATANGA', 'CARLOS SUAREZ - JUAN CARLOS GONZALEZ', '2 CONTENEDORES', 'UBA-3340 - UAA-3266'],
            [3, '4/8/24', 698, 'SAN CARLOS', 'CAMAL GUAYAQUIL', 'MONCERRATE JOFFRE - JAIME QUIÑONEZ', '2 CONTENEDORES', 'GSD-6924 - UBA-3340'],
            [4, '5/8/24', 699, 'SAN CARLOS', 'CERECITA', 'MONCERRATE JOFFRE - JAIME QUIÑONEZ', '2 CONTENEDORES', 'ADA-6353 - UBA-3340'],
            [5, '5/8/24', 700, 'LOMAS DE SARGENTILLO', 'CUENCA', 'MONCERRATE JOFFRE - JOSE VERA', '2 CONTENEDORES', 'ABA-6343 - UBA-3340'],
            [6, '6/8/24', 705, 'SAN CARLOS', 'CERECITA', 'JEAN GONZALEZ - LUIS ANDRADE', '1 CONTENEDOR', 'UBA-3340'],
            [7, '7/8/24', 701, 'SAN CARLOS', 'CERECITA', 'MONCERRATE JOFFRE - FRANKLIN MACIAS', '2 CONTENEDORES', 'UBA-3340 - UAA-3268'],
            [8, '8/8/24', 702, 'LOMAS DE SARGENTILLO', 'PALLATANGA', 'MONCERRATE JOFFRE - SAAVEDRA ERICK', '2 CONTENEDORES', 'UBA-3340 - BAA-1414'],
            [9, '11/8/24', 707, 'SAN CARLOS', 'CAMAL GUAYAQUIL', 'MONCERRATE JOFFRE - SAAVEDRA ERICK', '2 CONTENEDORES', 'GSO-6924 - UBA-3340'],
            [10, '12/8/24', 708, 'SAN CARLOS', 'CERECITA', 'MONCERRATE JOFFRE - ANTONY SANCHEZ', '2 CONTENEDORES', 'BAA-1414']
        ],
        'tabla5' => [['PLANTA GYE', 1, 1, 2, 2],
        ['GRANJA BUCAY', 1, 1, 0, 2],
        ['GRANJA LOMAS', 1, 1, 7, 9],
        ['GRANJA SAN CARLOS', 1, 1, 4, 5]],

        'tabla6' => [[ 1,'CASTRO SILVA', 'LOMAS', '2023-12-04', '2023-12-05'],
    ],
    'tabla7' => [[ 1, 'LOMAS', '2023-12-04', 'No se proporcionó alimentación a guardia en el sitio, en una hora adecuada.  El supervisor arribó a las 11H40 al sitio cuando el personal ya se disponía a almorzar.', 'Concienciar al personal asignado la prioridad en la  entrega de alimentación, cuando amerite.'],
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

            function Footer()
            {
                // Establece la posición del pie de página a 1.5 cm del borde inferior
                $this->SetY(-15);

                // Agregar una imagen en el pie de página alineada a la izquierda
                $this->Image(public_path('images/footer_imagen.png'), 10, $this->GetY(), 80); // Ajusta el tamaño a 20 de ancho
                 // Ajusta la ruta y tamaño según necesidad

                // Configurar fuente y agregar número de página alineado a la derecha
                $this->SetFont('Arial', 'I', 8);
                $this->Cell(0, 10, utf8_decode('pág. ' . $this->PageNo() . '/{nb}'), 0, 0, 'R');
            }
        };
        $this->pdf->AliasNbPages();
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
        //  if (!empty($datos['tabla']) && is_array($datos['tabla'])) {
        //     foreach ($datos['tabla'] as $row) {
        //         if (is_array($row)) {  // Verificar que la fila sea un array
        //             $this->pdf->SetX($margenOriginal);
        //             foreach ($w as $index => $width) {
        //                 $value = isset($row[$index]) ? $row[$index] : '';
        //                 $this->pdf->Cell($width, 6, utf8_decode($value), 1, 0, 'C');
        //             }
        //             $this->pdf->Ln();
        //         }
        //     }
        // }

       // ... (resto de tu código)

    //    if (!empty($datos['tabla']) && is_array($datos['tabla'])) {
    //     foreach ($datos['tabla'] as $row) {
    //         if (is_array($row)) {
    //             $this->pdf->SetX($margenOriginal);
    
    //             // Array para almacenar la altura requerida por cada celda en la fila
    //             $cellHeights = [];
    
    //             // Primera pasada: determinar la altura máxima de la fila
    //             foreach ($w as $index => $width) {
    //                 $value = isset($row[$index]) ? $row[$index] : '';
    
    //                 // Guardar la posición actual
    //                 $xPos = $this->pdf->GetX();
    //                 $yPos = $this->pdf->GetY();
    
    //                 // Medir el texto con MultiCell y guardar la altura
    //                 $this->pdf->MultiCell($width, 6, utf8_decode($value), 1, 'C');
    //                 $cellHeights[] = $this->pdf->GetY() - $yPos;
    
    //                 // Volver a la posición original para no mover el cursor
    //                 $this->pdf->SetXY($xPos + $width, $yPos);
    //             }
    
    //             // Calcular la altura máxima de la fila
    //             $maxHeight = max($cellHeights);
    
    //             // Segunda pasada: dibujar cada celda con la altura máxima
                
    //             // Mover a la siguiente línea con la altura máxima
    //             $this->pdf->Ln($maxHeight);
    //         }
    //     }
    // }

       
        if (!empty($datos['tabla']) && is_array($datos['tabla'])) {
            foreach ($datos['tabla'] as $row) {
                $this->pdf->SetX($margenOriginal);
        
                // Calcular alturas de las celdas
                $cellHeights = [];
                foreach ($w as $index => $width) {
                    $value = isset($row[$index]) ? $row[$index] : '';
                    $cellHeights[] = $this->getCellHeight($value, $width);
                }
        
                // Obtener la altura máxima para la fila
                $maxHeight = max($cellHeights);
        
                // Dibujar las celdas con la altura máxima
                foreach ($w as $index => $width) {
                    $value = isset($row[$index]) ? $row[$index] : '';
                    $this->pdf->Cell($width, $maxHeight, utf8_decode($value), 1, 0, 'C');
                }
        
                // Mover a la siguiente línea
                $this->pdf->Ln($maxHeight);
            }
        }
        
        // Antes de retornar el PDF, después de generar el contenido de la tabla
        $this->pdf->Ln(); // Salto de línea para el pie de tabla
        $this->pdf->SetX($margenOriginal);

        // Sumar las columnas 3 y 4
        $sumaCol3 = 0;
        $sumaCol4 = 0;

        foreach ($datos['tabla'] as $row) {
            if (isset($row[2])) {
                $sumaCol3 += (int)$row[2]; // Columna 3
            }
            if (isset($row[3])) {
                $sumaCol4 += (int)$row[3]; // Columna 4
            }
        }

        $this->pdf->SetFillColor(200, 200, 200); // Color gris claro

        // Pie de tabla
        $this->pdf->Cell(90, 5, 'TOTAL', 1, 0, 'C', true); // Unificar columnas 1 y 2 con "TOTALES"
        $this->pdf->Cell(15, 5, $sumaCol3, 1, 0, 'C', true); // Suma de la columna 3
        $this->pdf->Cell(15, 5, $sumaCol4, 1, 0, 'C', true); // Suma de la columna 4
        $this->pdf->Cell(20, 5, '', 1, 0, 'C', true); // Celda vacía para la columna 5
        $this->pdf->Cell(20, 5, '', 1, 0, 'C', true); // Celda vacía para la columna 6
        $this->pdf->Cell(30, 5, '', 1, 0, 'C', true); // Celda vacía para la columna 7
        

        $this->pdf->SetFillColor(224, 235, 255);
        $this->pdf->Ln(); // Salto de línea para el pie de tabla
        $this->pdf->SetX($margenOriginal);


         // Contenido
         $this->pdf->SetFont('Arial', 'B', 11);
         $this->pdf->Cell(190, 10, utf8_decode('2.2.	RONDAS DE VIGILANCIA:'), 0, 1, 'L');
 
         $this->pdf->SetX($margenOriginal);
         $this->pdf->SetFont('Arial', '', 9);
         $this->pdf->MultiCell(190, $lineHeight, utf8_decode('Se realizaron un total de '. $datos['cliente'] . ' rondas de vigilancia y ' . $datos['cliente'] . '  marcaciones QR, distribuidas entre los diferentes puntos de servicio. Estas rondas se llevaron a cabo en horarios aleatorios para maximizar la efectividad y minimizar los riesgos de incidentes.'), 0, 'J');        

         $this->pdf->Ln();

        $this->pdf->SetFont('Arial', 'B', 8);


        // Cabecera de la tabla
        $header = array('SITIO', 'NO. DE RONDAS', 'NO. DE MARCACIONES');
        $w = array(40, 30, 40);

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
        $this->pdf->SetFont('Arial', '', 8);


        if (!empty($datos['tabla2']) && is_array($datos['tabla2'])) {
            foreach ($datos['tabla2'] as $row) {
                $this->pdf->SetX($margenOriginal);
        
                // Calcular alturas de las celdas
                $cellHeights = [];
                foreach ($w as $index => $width) {
                    $value = isset($row[$index]) ? $row[$index] : '';
                    $cellHeights[] = $this->getCellHeight($value, $width);
                }
        
                // Obtener la altura máxima para la fila
                $maxHeight = max($cellHeights);
        
                // Dibujar las celdas con la altura máxima
                foreach ($w as $index => $width) {
                    $value = isset($row[$index]) ? $row[$index] : '';
                    $this->pdf->Cell($width, $maxHeight, utf8_decode($value), 1, 0, 'C');
                }
        
                // Mover a la siguiente línea
                $this->pdf->Ln($maxHeight);
            }
        }

      
        $this->pdf->SetX($margenOriginal);

        // Sumar las columnas 3 y 4
        $sumaCol3 = 0;
        $sumaCol4 = 0;

        foreach ($datos['tabla2'] as $row) {
            if (isset($row[1])) {
                $sumaCol3 += (int)$row[1]; // Columna 3
            }
            if (isset($row[2])) {
                $sumaCol4 += (int)$row[2]; // Columna 4
            }
        }

        $this->pdf->SetFillColor(200, 200, 200); // Color gris claro

        // Pie de tabla
        $this->pdf->Cell(40, 5, 'TOTAL GENERAL', 1, 0, 'C', true); // Unificar columnas 1 y 2 con "TOTALES"
        $this->pdf->Cell(30, 5, $sumaCol3, 1, 0, 'C', true); // Suma de la columna 3
        $this->pdf->Cell(40, 5, $sumaCol4, 1, 0, 'C', true); // Suma de la columna 4


        #------------------TABLA 3 -------------------------


        // Contenido
        $this->pdf->Ln();
        $this->pdf->SetX($margenOriginal);
        $this->pdf->SetFont('Arial', 'B', 11);
        $this->pdf->Cell(190, 10, utf8_decode('2.3.	CONTROL DE ACCESOS:'), 0, 1, 'L');
        $this->pdf->SetFont('Arial', '', 9);
        $this->pdf->SetX($margenOriginal);
        $this->pdf->MultiCell(190, $lineHeight, utf8_decode('Se gestionaron un total de ' . $datos['cliente'] . ' registros de control de accesos de empleados, visitantes, proveedores, y clientes, en las distintas instalaciones ingresados en nuestro sistema PROTEAPP®.  El proceso de control incluyó la verificación de identidades y la inspección de vehículos conforme a los procedimientos establecidos, garantizando el cumplimiento de las políticas de seguridad de ' . $datos['cliente'] . ' .'), 0, 'J');

        $this->pdf->Ln();
        $this->pdf->SetX($margenOriginal);

        $this->pdf->SetFont('Arial', 'B', 8);


        // Cabecera de la tabla
        $header = array('SITIO', 'EMPLEADOS', 'VISITANTES', 'PROVEEDORES', 'CLIENTES', 'TOTAL');
        $w = array(40, 30, 30, 30, 30, 30);

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
        $this->pdf->SetFont('Arial', '', 8);


        if (!empty($datos['tabla3']) && is_array($datos['tabla3'])) {
            foreach ($datos['tabla3'] as $row) {
                $this->pdf->SetX($margenOriginal);
        
                // Calcular alturas de las celdas
                $cellHeights = [];
                foreach ($w as $index => $width) {
                    $value = isset($row[$index]) ? $row[$index] : '';
                    $cellHeights[] = $this->getCellHeight($value, $width);
                }
        
                // Obtener la altura máxima para la fila
                $maxHeight = max($cellHeights);
        
                // Dibujar las celdas con la altura máxima
                foreach ($w as $index => $width) {
                    $value = isset($row[$index]) ? $row[$index] : '';
                    $this->pdf->Cell($width, $maxHeight, utf8_decode($value), 1, 0, 'C');
                }
        
                // Mover a la siguiente línea
                $this->pdf->Ln($maxHeight);
            }
        }

      
        $this->pdf->SetX($margenOriginal);

        // Sumar las columnas 3 y 4
        $sumaCol3 = 0;
        $sumaCol4 = 0;
        $sumaCol5 = 0;
        $sumaCol6 = 0;
        $sumaCol7 = 0;

        foreach ($datos['tabla3'] as $row) {
            if (isset($row[1])) {
                $sumaCol3 += (int)$row[1]; // Columna 3
            }
            if (isset($row[2])) {
                $sumaCol4 += (int)$row[2]; // Columna 4
            }
            if (isset($row[3])) {
                $sumaCol5 += (int)$row[3]; // Columna 4
            }
            if (isset($row[4])) {
                $sumaCol6 += (int)$row[4]; // Columna 4
            }

            if (isset($row[5])) {
                $sumaCol7 += (int)$row[5]; // Columna 4
            }

            
        }

        $this->pdf->SetFillColor(200, 200, 200); // Color gris claro

        // Pie de tabla
        $this->pdf->Cell(40, 5, 'TOTAL GENERAL', 1, 0, 'C', true); // Unificar columnas 1 y 2 con "TOTALES"
        $this->pdf->Cell(30, 5, $sumaCol3, 1, 0, 'C', true); // Suma de la columna 3
        $this->pdf->Cell(30, 5, $sumaCol4, 1, 0, 'C', true); // Suma de la columna 4
        $this->pdf->Cell(30, 5, $sumaCol5, 1, 0, 'C', true); // Suma de la columna 4
        $this->pdf->Cell(30, 5, $sumaCol6, 1, 0, 'C', true); // Suma de la columna 4
        $this->pdf->Cell(30, 5, $sumaCol7, 1, 0, 'C', true); // Suma de la columna 4


        #-------------Tabla 4 ------------------

        // Contenido
        $this->pdf->Ln( );
        $this->pdf->SetX($margenOriginal);

        $this->pdf->SetFont('Arial', 'B', 11);
        $this->pdf->Cell(190, 10, utf8_decode('2.4.	REPORTE DE CUSTODIAS '), 0, 1, 'L');
        $this->pdf->SetFont('Arial', '', 9);
        $this->pdf->SetX($margenOriginal);
        $this->pdf->MultiCell(190, $lineHeight, utf8_decode('Durante el mes de agosto se realizaron un total de ' . $datos['cliente'] .' custodias de mercaderías en tránsito, asegurando el traslado seguro desde las diferentes granjas. '), 0, 'J');
        
        $this->pdf->Ln( );
        $this->pdf->SetX($margenOriginal);


        $this->pdf->SetFont('Arial', 'B', 8);


        // Cabecera de la tabla
        $header = array( 'NO.', 'FECHA', 'GUIA NO.', 'PUNTO PARTIDA', 'PUNTO DE LLEGADA', 'CUSTODIOS', 'CONTENEDOR', 'PLACAS CAMIONES');
        $w = array(15, 20, 20, 30, 20, 40, 20,30);

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
        $this->pdf->SetFont('Arial', '', 8);


        if (!empty($datos['tabla4']) && is_array($datos['tabla4'])) {
            foreach ($datos['tabla4'] as $row) {
                $this->pdf->SetX($margenOriginal);
        
                // Calcular alturas de las celdas
                $cellHeights = [];
                foreach ($w as $index => $width) {
                    $value = isset($row[$index]) ? $row[$index] : '';
                    $cellHeights[] = $this->getCellHeight($value, $width);
                }
        
                // Obtener la altura máxima para la fila
                $maxHeight = max($cellHeights);
        
                // Dibujar las celdas con la altura máxima
                foreach ($w as $index => $width) {
                    $value = isset($row[$index]) ? $row[$index] : '';
                    $this->pdf->Cell($width, $maxHeight, utf8_decode($value), 1, 0, 'C');
                }
        
                // Mover a la siguiente línea
                $this->pdf->Ln($maxHeight);
            }
        }

      
        $this->pdf->SetX($margenOriginal);

        // Contenido
        $this->pdf->SetFont('Arial', 'B', 11);
        $this->pdf->Cell(190, 10, utf8_decode('3.	NOVEDADES E INCIDENTES DURANTE EL PERIODO'), 0, 1, 'L');
        $this->pdf->SetX($margenOriginal);
        $this->pdf->Cell(190, 10, utf8_decode('3.1.	INCIDENTES DE SEGURIDAD'), 0, 1, 'L');
        $this->pdf->SetFont('Arial', '', 9);
        $this->pdf->SetX($margenOriginal);
        $this->pdf->MultiCell(190, $lineHeight, utf8_decode('A continuación, se detallan las incidencias de seguridad reportadas en el presente periodo:'), 0, 'J');
      
        

        // Recorrer los sitios y sus incidentes
        #----------- Tabla 5 --------------------------


        // Contenido
        $this->pdf->SetX($margenOriginal);
        $this->pdf->SetFont('Arial', 'B', 11);
        $this->pdf->Cell(190, 10, utf8_decode('3.2.	NOVEDADES REPORTADAS EN PROTEAPP® '), 0, 1, 'L');
        $this->pdf->SetFont('Arial', '', 9);
        $this->pdf->SetX($margenOriginal);
        $this->pdf->MultiCell(190, $lineHeight, utf8_decode('A lo largo de este período, se han identificado y reportado en nuestro sistema PROTEAPP® '. $datos['cliente'] . ' novedades relevantes en todos los sitios, que destacan la importancia de nuestra gestión de vigilancia y seguridad, las cuales se resumen a continuación:'), 0, 'J');

        
        $this->pdf->Ln( );
        $this->pdf->SetX($margenOriginal);


        $this->pdf->SetFont('Arial', 'B', 8);


        // Cabecera de la tabla
        $header = array('SITIO',
        'INCIDENTES',
        'HALLAZGOS',
        'NOVEDADES DEL SITIO',
        'TOTAL NOVEDADES REPORTADAS EN PROTEAPP');
        $w = array(40, 20, 20, 50, 50);

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
        $this->pdf->SetFont('Arial', '', 8);


        if (!empty($datos['tabla5']) && is_array($datos['tabla5'])) {
            foreach ($datos['tabla5'] as $row) {
                $this->pdf->SetX($margenOriginal);
        
                // Calcular alturas de las celdas
                $cellHeights = [];
                foreach ($w as $index => $width) {
                    $value = isset($row[$index]) ? $row[$index] : '';
                    $cellHeights[] = $this->getCellHeight($value, $width);
                }
        
                // Obtener la altura máxima para la fila
                $maxHeight = max($cellHeights);
        
                // Dibujar las celdas con la altura máxima
                foreach ($w as $index => $width) {
                    $value = isset($row[$index]) ? $row[$index] : '';
                    $this->pdf->Cell($width, $maxHeight, utf8_decode($value), 1, 0, 'C');
                }
        
                // Mover a la siguiente línea
                $this->pdf->Ln($maxHeight);
            }
        }

    
        $this->pdf->SetX($margenOriginal);

        // Sumar las columnas 3 y 4
        $sumaCol = 0;


        foreach ($datos['tabla5'] as $row) {
            if (isset($row[4])) {
                $sumaCol += (int)$row[4]; // Columna 3
            }
        }

        $this->pdf->SetFillColor(200, 200, 200); // Color gris claro

        // Pie de tabla
        $this->pdf->Cell(40, 5, 'TOTAL', 1, 0, 'C', true); // Unificar columnas 1 y 2 con "TOTALES"
        $this->pdf->Cell(20, 5, '', 1, 0, 'C', true); // Celda vacía para la columna 5
        $this->pdf->Cell(20, 5, '', 1, 0, 'C', true); // Celda vacía para la columna 6
        $this->pdf->Cell(50, 5, '', 1, 0, 'C', true); // Celda vacía para la columna 7
        $this->pdf->Cell(50, 5, $sumaCol, 1, 0, 'C', true); // Celda vacía para la columna 7
        

        $this->pdf->SetFillColor(224, 235, 255);
        $this->pdf->Ln(); // Salto de línea para el pie de tabla
        $this->pdf->SetX($margenOriginal);

        #----------- Tabla 6 --------------------------
        // Contenido
        $this->pdf->SetFont('Arial', 'B', 11);
        $this->pdf->Cell(190, 10, utf8_decode('3.3.	CAMBIOS EN LA NOMINA DEL PERSONAL'), 0, 1, 'L');
        $this->pdf->SetFont('Arial', '', 9);
        $this->pdf->SetX($margenOriginal);
        $this->pdf->MultiCell(190, $lineHeight, utf8_decode('En el siguiente cuadro se presenta el listado del personal que salió del proyecto en el periodo:'), 0, 'J');
       
        $this->pdf->Ln( );
        $this->pdf->SetX($margenOriginal);


        $this->pdf->SetFont('Arial', 'B', 8);


        // Cabecera de la tabla
        $header = array(
        'NO.',
        'APELLIDOS NOMBRES',
        'PUESTO',
        'FECHA DE INGRESO',
        'FECHA DE  SALIDA');
        $w = array(20,  60, 40, 30, 30);

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
        $this->pdf->SetFont('Arial', '', 8);


        if (!empty($datos['tabla6']) && is_array($datos['tabla6'])) {
            foreach ($datos['tabla6'] as $row) {
                $this->pdf->SetX($margenOriginal);
        
                // Calcular alturas de las celdas
                $cellHeights = [];
                foreach ($w as $index => $width) {
                    $value = isset($row[$index]) ? $row[$index] : '';
                    $cellHeights[] = $this->getCellHeight($value, $width);
                }
        
                // Obtener la altura máxima para la fila
                $maxHeight = max($cellHeights);
        
                // Dibujar las celdas con la altura máxima
                foreach ($w as $index => $width) {
                    $value = isset($row[$index]) ? $row[$index] : '';
                    $this->pdf->Cell($width, $maxHeight, utf8_decode($value), 1, 0, 'C');
                }
        
                // Mover a la siguiente línea
                $this->pdf->Ln($maxHeight);
            }
        }

        $this->pdf->Ln();
        $this->pdf->SetX($margenOriginal);

        // Contenido
        $this->pdf->SetFont('Arial', 'B', 11);
        $this->pdf->Cell(190, 10, utf8_decode('4.	ACCIONES CORRECTIVAS REPORTADAS POR EL CLIENTE'), 0, 1, 'L');
        $this->pdf->SetFont('Arial', '', 9);
        $this->pdf->SetX($margenOriginal);
        $this->pdf->MultiCell(190, $lineHeight, utf8_decode('En este punto se detallan las solicitudes de acción correctiva (SAC´s) reportadas por el cliente:'), 0, 'J');
       
        $this->pdf->Ln( );
        $this->pdf->SetX($margenOriginal);


        $this->pdf->SetFont('Arial', 'B', 8);


        // Cabecera de la tabla
        $header = array(
        'NO.',
        'SITIO',
        'FECHA DEL INCIDENTE',
        'INCIDENTE',
        'MEDIDA DE CONTROL');
        $w = array(20,  30, 30, 50, 50);

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
        $this->pdf->SetFont('Arial', '', 8);


        if (!empty($datos['tabla7']) && is_array($datos['tabla7'])) {
            foreach ($datos['tabla7'] as $row) {
                $this->pdf->SetX($margenOriginal);
        
                // Calcular alturas de las celdas
                $cellHeights = [];
                foreach ($w as $index => $width) {
                    $value = isset($row[$index]) ? $row[$index] : '';
                    $cellHeights[] = $this->getCellHeight($value, $width);
                }
        
                // Obtener la altura máxima para la fila
                $maxHeight = max($cellHeights);
        
                // Dibujar las celdas con la altura máxima
                foreach ($w as $index => $width) {
                    $value = isset($row[$index]) ? $row[$index] : '';
                    $this->pdf->Cell($width, $maxHeight, utf8_decode($value), 1, 0, 'C');
                }
        
                // Mover a la siguiente línea
                $this->pdf->Ln($maxHeight);
            }
        }

        $this->pdf->Ln();
        $this->pdf->SetX($margenOriginal);

        // Contenido
        $this->pdf->SetFont('Arial', 'B', 11);
        $this->pdf->Cell(190, 10, utf8_decode('5.	VALORES AGREGADOS'), 0, 1, 'L');
        $this->pdf->SetFont('Arial', '', 9);
        $this->pdf->SetX($margenOriginal);
        $this->pdf->MultiCell(190, $lineHeight, utf8_decode('Durante el mes de ' . $datos['cliente'] . ' se proporcionaron los siguientes valores agregados solicitados por el departamento de seguridad física de ' . $datos['cliente'] . ' :'), 0, 'J');
        $this->pdf->Ln();
        $this->pdf->SetX($margenOriginal);
        if (isset($datos['items2']) && is_array($datos['items2'])) {
            $counter = 1;
            foreach ($datos['items2'] as $item) {
                $this->pdf->Ln(2); // Espacio entre los elementos de la lista
                $this->pdf->MultiCell(190, $lineHeight, utf8_decode($counter . ') ' . $item), 0, 'L');
                $counter++;
            }
            }

        $this->pdf->Ln();
        $this->pdf->SetX($margenOriginal);

        // Contenido
        $this->pdf->SetFont('Arial', 'B', 11);
        $this->pdf->Cell(190, 10, utf8_decode('6.	CONCLUSIONES Y RECOMENDACIONES'), 0, 1, 'L');
        $this->pdf->SetFont('Arial', '', 9);
        $this->pdf->SetX($margenOriginal);
        $this->pdf->MultiCell(190, $lineHeight, utf8_decode('El servicio de seguridad proporcionado por PROTEMAXI durante ' . $datos['cliente'] . '  cumplió con los requisitos esperados, garantizando la protección de las instalaciones de '. $datos['cliente'] . '  en todos los puntos de servicio. '), 0, 'J');


        $this->pdf->Ln( );
        $this->pdf->SetX($margenOriginal);


        $this->pdf->SetFont('Arial', 'B', 8);


        // Cabecera de la tabla
        $header = array(
        'ELABORADO POR:',
        'REVISADO POR:',
        'REPORTADO A:');
        $w = array(63,  63, 63);

        // Color de fondo de la cabecera (negro)
        $this->pdf->SetFillColor(200, 200, 200); // Color gris claro

     

        $this->pdf->SetX($margenOriginal);

        // Cabecera
        for($i=0;$i<count($header);$i++)
            $this->pdf->Cell($w[$i],7,$header[$i],1,0,'C',1);
        $this->pdf->Ln();

        // Restaurar color
     
        $this->pdf->SetFont('Arial', '', 8);
                // Restaurar color
        $this->pdf->SetFillColor(255, 255, 255);

        $this->pdf->SetX($margenOriginal);

         // Pie de tabla
         $this->pdf->Cell(63, 10, '', 1, 0, 'C', true); // Unificar columnas 1 y 2 con "TOTALES"
         $this->pdf->Cell(63, 10, '', 1, 0, 'C', true); // Celda vacía para la columna 5
         $this->pdf->Cell(63, 10, '', 1, 0, 'C', true); // Celda vacía para la columna 6
 

         $this->pdf->Ln();
        $this->pdf->SetX($margenOriginal);

        // Pie de tabla
        $this->pdf->Cell(63, 5, 'Jefe de Operaciones', 1, 0, 'C', true); // Unificar columnas 1 y 2 con "TOTALES"
        $this->pdf->Cell(63, 5, 'Administrador del Contrato', 1, 0, 'C', true); // Celda vacía para la columna 5
        $this->pdf->Cell(63, 5, utf8_decode('Jefe de Seguridad Física'), 1, 0, 'C', true); // Celda vacía para la columna 6

        

        $this->pdf->Ln(); // Salto de línea para el pie de tabla
        $this->pdf->SetX($margenOriginal);

         // Pie de tabla
         $this->pdf->Cell(63, 5, 'PROTEMAXI C. LTDA', 1, 0, 'C', true); // Unificar columnas 1 y 2 con "TOTALES"
         $this->pdf->Cell(63, 5, 'PROTEMAXI C. LTDA', 1, 0, 'C', true); // Celda vacía para la columna 5
         $this->pdf->Cell(63, 5, 'MOCHASA S.A.', 1, 0, 'C', true); // Celda vacía para la columna 6
        $this->pdf->SetX($margenOriginal);


        return response($this->pdf->Output('S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="mi_reporte.pdf"');

        

    }



  
function getCellHeight($text, $width) {
    // Ajusta estos valores según tus necesidades
    $fontSize = 8; // Tamaño de fuente en puntos
    $lineHeight = $fontSize * 1.2; // Altura de línea aproximada

    $textWidth = $this->pdf->GetStringWidth($text);
    $numLines = ceil($textWidth / $width);

    return $numLines * $lineHeight;
}

  
}
