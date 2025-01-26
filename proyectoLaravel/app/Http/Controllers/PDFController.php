<?php

namespace App\Http\Controllers;

use App\Models\Control;
use App\Models\Detalle;
use App\Models\Novedad;
use App\Models\Recomendacion;
use App\Models\Ronda;
use Illuminate\Http\Request;
use FPDF;

class PDFController extends Controller
{
    protected $pdf;

// Asegúrate de tener esto en tu controlador:
public function actualizarFechaReporte(Request $request)
{
    // Validación de los datos recibidos
    $request->validate([
        'cliente' => 'required|string',
        'fecha_reporte' => 'required|date',
        'fechas_novedad' => 'required|array',
        'fechas_novedad.*' => 'date'
    ]);

    // Obtener los datos enviados
    $cliente = $request->input('cliente');
    $fecha_reporte = $request->input('fecha_reporte');
    $fechas_novedad = $request->input('fechas_novedad');

    // Actualizar todos los registros de "fecha_novedad" correspondientes a ese cliente
    try {
        // Si tienes una relación de cliente a detalles, puedes hacer algo como esto:
        Detalle::where('desc_cliente', $cliente)
            ->whereIn('fecha_novedad', $fechas_novedad) // Filtramos por las fechas de novedad
            ->update(['fecha_reporte' => $fecha_reporte]); // Actualizamos la fecha del reporte

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}


    
    public function detalles()
    {
        // Lógica que deseas ejecutar cuando se haga la solicitud GET
         // Obtener todos los registros de la tabla novedades
         $detalles = Detalle::all();

         // Si quieres devolver los datos como JSON (ideal para API)
         return response()->json($detalles); 
    }
    
    public function recomendaciones ()
    {
        // Lógica que deseas ejecutar cuando se haga la solicitud GET
         // Obtener todos los registros de la tabla novedades
         $recomendaciones = Recomendacion::all();

         // Si quieres devolver los datos como JSON (ideal para API)
         return response()->json($recomendaciones); 
    }


    public function control ()
    {
        // Lógica que deseas ejecutar cuando se haga la solicitud GET
         // Obtener todos los registros de la tabla novedades
         $control = Control::all();

         // Si quieres devolver los datos como JSON (ideal para API)
         return response()->json($control); 
    }


    public function novedades ()
    {
        // Lógica que deseas ejecutar cuando se haga la solicitud GET
         // Obtener todos los registros de la tabla novedades
         $novedades = Novedad::all();

         // Si quieres devolver los datos como JSON (ideal para API)
         return response()->json($novedades); 
    }

    public function rondas ()
    {
        // Lógica que deseas ejecutar cuando se haga la solicitud GET
         // Obtener todos los registros de la tabla novedades
         $rondas = Ronda::all();

         // Si quieres devolver los datos como JSON (ideal para API)
         return response()->json($rondas); 
    }
    
    
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

        
       $periodo = $datos['periodo']; // "ENERO 2024"
        $partes = explode(' ', $periodo); // Separa el string por espacio
        $mes = $partes[0]; // El primer elemento es el nombre del mes
    
        
        

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
        $this->pdf->Cell(0, 10, utf8_decode('PROTEMAXI C. LTDA.,  EN EL PROYECTO ' . strtoupper($datos['cliente']) ), 0, 1, 'C');
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
        $this->pdf->Cell(0, $lineHeight, 'DANIEL PINTADO', 1, 1, 'L');
        // utf8_decode($datos['destinatario'])

        $this->pdf->Ln(3);

        $this->pdf->Cell(40, $lineHeight, 'FECHA DE REPORTE:', 0, 0, 'L');
        $this->pdf->SetFont('Arial', 'B', 9);
        $this->pdf->Cell(0, $lineHeight, utf8_decode($datos['fecha_reporte']), 1, 1, 'L');

        $this->pdf->Ln(3);

        $this->pdf->SetFont('Arial', 'B', 9);
        // ... (similarly for other fields)

        $this->pdf->Cell(40, $lineHeight, 'PERIODO:', 0, 0, 'L');
        $this->pdf->Cell(60, $lineHeight, utf8_decode($datos['periodo']), 1, 0, 'L'); // Agregamos borde a la derecha
        
        // Agregar un espacio en blanco entre las celdas
        $this->pdf->Cell(10, $lineHeight, '', 0, 0, 'L');
        
        $this->pdf->Cell(30, $lineHeight, 'NO. DE REPORTE:', 0, 0, 'L');
        $this->pdf->Cell(50, $lineHeight, utf8_decode($datos['id']-1), 1, 1, 'L');

        
        $this->pdf->Ln();


        $this->pdf->SetFont('Arial', 'B', 11);
        $this->pdf->Cell(190, 10, utf8_decode('1.	INTRODUCCIÓN'), 0, 1, 'L');
        $this->pdf->SetFont('Arial', '', 9);
        $this->pdf->MultiCell(190, $lineHeight, utf8_decode('La información presentada en el siguiente informe corresponde a las actividades de seguridad, control y prevención que fueron realizadas por nuestro personal en las instalaciones de nuestro cliente ' . $datos['cliente'] . ' durante el mes de ' .  $mes . ', en los siguientes sitios donde se presta el servicio:'), 0, 'J');        
        // Descargar el PDF
        $this->pdf->SetLeftMargin(20);
       
        // Lista numerada dinámica desde el array $datos['items']


        if (isset($datos['desc_localidad']) && is_string($datos['desc_localidad'])) {
            // Convertir la cadena en un array, separando por coma
            $datos['desc_localidad'] = explode(',', $datos['desc_localidad']);
        }
        
        if (isset($datos['desc_localidad']) && is_array($datos['desc_localidad'])) {
            $counter = 1;
            foreach ($datos['desc_localidad'] as $item) {
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

        $sumaCol3 = 0;
        $sumaCol4 = 0;

        foreach ([$datos['cobertura_servicio']] as $row) {
            if (isset($row[2])) {
                $sumaCol3 += (int)$row[2]; // Columna 3
            }
            if (isset($row[3])) {
                $sumaCol4 += (int)$row[3]; // Columna 4
            }
        }

        $sumaTotal= $sumaCol3 + $sumaCol4;

        $this->pdf->SetX($margenOriginal);

        $this->pdf->SetFont('Arial', '', 9);
        $this->pdf->MultiCell(190, $lineHeight, utf8_decode('El servicio de seguridad se mantuvo cubierto en todos los sitios durante el periodo, con un total de '.$sumaTotal .' puestos de servicio para asegurar una vigilancia constante en las áreas asignadas, de acuerdo a la siguiente tabla:'), 0, 'J');        


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
        

       
        if (!empty($datos['cobertura_servicio']) && is_array($datos['cobertura_servicio'])) {
            foreach ([$datos['cobertura_servicio']] as $row) {
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
       # $this->pdf->Ln(); // Salto de línea para el pie de tabla
        $this->pdf->SetX($margenOriginal);

        // Sumar las columnas 3 y 4
        

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
         // Sumar las columnas 3 y 4

         if (isset($datos['ronda_vigilancia']) && is_string($datos['ronda_vigilancia'])) {
            // Convertir la cadena JSON en un array asociativo
            $ronda_vigilancia = json_decode($datos['ronda_vigilancia'], true);
        }
        
        // Inicializar las variables para la suma de las columnas
        $sumaCol3 = 0; // Suma de 'rondas_generadas'
        $sumaCol4 = 0; // Suma de 'num_marcaciones'
        
        // Verificar si $ronda_vigilancia es un array antes de iterar
        if (isset($ronda_vigilancia) && is_array($ronda_vigilancia)) {
            foreach ($ronda_vigilancia as $row) {
                // Verificar si 'rondas_generadas' está presente en el elemento
                if (isset($row['rondas_generadas'])) {
                    $sumaCol3 += (int)$row['rondas_generadas']; // Sumar 'rondas_generadas'
                }
                // Verificar si 'num_marcaciones' está presente en el elemento
                if (isset($row['num_marcaciones'])) {
                    $sumaCol4 += (int)$row['num_marcaciones']; // Sumar 'num_marcaciones'
                }
        
                
            }
        }
         

         $this->pdf->SetFont('Arial', 'B', 11);
         $this->pdf->Cell(190, 10, utf8_decode('2.2.	RONDAS DE VIGILANCIA:'), 0, 1, 'L');
 
         $this->pdf->SetX($margenOriginal);
         $this->pdf->SetFont('Arial', '', 9);
         $this->pdf->MultiCell(190, $lineHeight, utf8_decode('Se realizaron un total de '. $sumaCol3 . ' rondas de vigilancia y ' . $sumaCol4 . '  marcaciones QR, distribuidas entre los diferentes puntos de servicio. Estas rondas se llevaron a cabo en horarios aleatorios para maximizar la efectividad y minimizar los riesgos de incidentes.'), 0, 'J');        

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

         
    

         // Restaurar color
         $this->pdf->SetFillColor(224, 235, 255);
         $this->pdf->SetTextColor(0, 0, 0);
         $this->pdf->SetFont('Arial', '', 8);

      

        $this->pdf->SetX($margenOriginal); // Salto de línea para el pie de tabla
//SI VALE
// Verificar si $ronda_vigilancia es un array antes de iterar
// if (isset($ronda_vigilancia) && is_array($ronda_vigilancia)) {
//     foreach ($ronda_vigilancia as $row) {
//         $this->pdf->Cell(40, 10, $row['tx_localidad'], 1, 0, 'C');  // Columna Titulo
//         $this->pdf->Cell(30, 10, $row['rondas_generadas'], 1, 0, 'C');  // Columna 'rondas_generadas'
//         $this->pdf->Cell(40, 10, $row['num_marcaciones'], 1, 0, 'C');  // Columna 'num_marcaciones'
//         $this->pdf->Ln(); 
//         $this->pdf->SetX($margenOriginal); // Ajuste de la posición de la celda
//     }
// }

if (isset($ronda_vigilancia) && is_array($ronda_vigilancia)) {
    // Convertir el array a una colección para usar las funciones de Laravel
    $rondas = collect($ronda_vigilancia);

    // Agrupar por id_localidad
    $rondasAgrupadas = $rondas->groupBy('id_localidad');

    // Definir los anchos de las columnas
    $colWidths = [40, 30, 40]; // Ajusta estos valores según el diseño

    // Recorrer los grupos de rondas agrupados por id_localidad
    foreach ($rondasAgrupadas as $idLocalidad => $grupo) {
        // Obtener el valor de txt_localidad del primer elemento del grupo (asumiendo que todos los elementos tienen el mismo valor para txt_localidad)
        $txtLocalidad = $grupo->first()['tx_localidad'];

        // Sumar los valores de num_marcaciones y rondas_generadas
        $sumNumMarcaciones = $grupo->sum('num_marcaciones'); // Sumar num_marcaciones
        $sumRondasGeneradas = $grupo->sum('rondas_generadas'); // Sumar rondas_generadas

        // Crear el array con los datos a mostrar
        $data = [
            $txtLocalidad,  // Mostrar txt_localidad en lugar de id_localidad
            $sumRondasGeneradas,  // Sumar las rondas_generadas para esta localidad
            $sumNumMarcaciones,  // Sumar las num_marcaciones para esta localidad
        ];

        // Calcular la altura máxima de la fila
        $maxHeight = 0;
        foreach ($data as $index => $content) {
            // Estimar el número de líneas necesarias para el contenido
            $lineCount = $this->pdf->GetStringWidth((string)$content) / $colWidths[$index];
            $lineCount = ceil($lineCount); // Redondear hacia arriba
            $cellHeight = $lineCount * 5; // Altura de línea (ajusta 5 según necesidad)
            $maxHeight = max($maxHeight, $cellHeight); 
            $maxHeight = $maxHeight + 1; // Tomar la altura máxima
        }

        // Dibujar las celdas de la fila con la misma altura máxima
        foreach ($data as $index => $content) {
            $x = $this->pdf->GetX(); // Posición X actual
            $y = $this->pdf->GetY(); // Posición Y actual

            // Dibujar un rectángulo para el borde de la celda
            $this->pdf->Rect($x, $y, $colWidths[$index], $maxHeight);

            // Escribir el contenido dentro de la celda con MultiCell
            $this->pdf->MultiCell($colWidths[$index], 5, (string)$content, 0, 'C'); // Cambié a 'C' para centrar el texto

            // Volver a la posición derecha para la siguiente celda
            $this->pdf->SetXY($x + $colWidths[$index], $y);
        }

        // Saltar a la siguiente fila
        $this->pdf->Ln($maxHeight);
        $this->pdf->SetX($margenOriginal);
    }
}



// Después de completar el bucle, imprimimos el total general

$this->pdf->SetX($margenOriginal);
$this->pdf->SetFillColor(200, 200, 200); // Color gris claro para el pie de tabla

// Pie de tabla con los totales
$this->pdf->Cell(40, 5, 'TOTAL GENERAL', 1, 0, 'C', true); // Unificar columnas 1 y 2 con "TOTAL GENERAL"
$this->pdf->Cell(30, 5, $sumaCol3, 1, 0, 'C', true); // Suma de la columna 3 (rondas_generadas)
$this->pdf->Cell(40, 5, $sumaCol4, 1, 0, 'C', true); // Suma de la columna 4 (num_marcaciones)

$this->pdf->Ln();
$this->pdf->SetX($margenOriginal);

        #------------------TABLA 3 -------------------------
        if (isset($datos['control_acceso']) && is_string($datos['control_acceso'])) {
            // Convertir la cadena en un array, separando por coma
            $control_acceso = json_decode($datos['control_acceso'], true);
           
 
        }

        // Contenido
         // Sumar las columnas 3 y 4
         $sumaCol3 = 0;
         $sumaCol4 = 0;
         $sumaCol5 = 0;
         $sumaCol6 = 0;
         $sumaCol7 = 0;

         if (isset($ronda_vigilancia) && is_array($ronda_vigilancia)) {
            foreach ($ronda_vigilancia as $row) {
                // Verificar si 'id_empleado' está presente en el elemento
                if (isset($row['id_empleado'])) {
                    $sumaCol3 += (int)$row['id_empleado']; // Sumar 'id_empleado'
                }
                
                // Verificar si 'id_visitante' está presente en el elemento
                if (isset($row['id_visitante'])) {
                    $sumaCol4 += (int)$row['id_visitante']; // Sumar 'id_visitante'
                }
        
                // Verificar si 'id_cliente' está presente en el elemento (para Columna 5)
                if (isset($row['id_cliente'])) {
                    $sumaCol5 += (int)$row['id_cliente']; // Sumar 'id_cliente' para Columna 5
                }
        
                // Verificar si 'id_cliente' está presente en el elemento (para Columna 6)
                if (isset($row['id_cliente'])) {
                    $sumaCol6 += (int)$row['id_cliente']; // Sumar 'id_cliente' para Columna 6
                }
        
            }

            if (isset($row[5])) {
                $sumaCol7 += $sumaCol6 + $sumaCol5 + $sumaCol4 + $sumaCol3; // Sumar el valor de la columna 7
            }
        }


        //----------------control de acceso
        $totalesGenerales = 0;
        if (isset($control_acceso) && is_array($control_acceso)) {
            // Convertir el array a una colección para usar las funciones de Laravel
            $controlAcceso = collect($control_acceso);
        
            // Agrupar por id_localidad
            $agrupadoPorLocalidad = $controlAcceso->groupBy('id_localidad');
        
            // Inicializar las variables para los totales generales
            $totalEmpleado = 0;
            $totalVisitante = 0;
            $totalCliente = 0;
            $totalEmpresa = 0;
        
            // Recorrer los grupos agrupados por id_localidad
            foreach ($agrupadoPorLocalidad as $idLocalidad => $grupo) {
                // Realizar el count distinct de los campos para cada grupo
                $countEmpleado = $grupo->pluck('id_empleado')->unique()->count();
                $countVisitante = $grupo->pluck('id_visitante')->unique()->count();
                $countCliente = $grupo->pluck('id_cliente')->unique()->count();
                $countEmpresa = $grupo->pluck('empresa')->unique()->count();
        
                // Sumar los totales generales
                $totalEmpleado += $countEmpleado;
                $totalVisitante += $countVisitante;
                $totalCliente += $countCliente;
                $totalEmpresa += $countEmpresa;
            }
        
            // Retornar los totales generales
            $totalesGenerales = $totalEmpleado + $totalVisitante + $totalCliente + $totalEmpresa;
        
            
        }
                
        


        $this->pdf->Ln();
        $this->pdf->SetX($margenOriginal);
        $this->pdf->SetFont('Arial', 'B', 11);
        $this->pdf->Cell(190, 10, utf8_decode('2.3.	CONTROL DE ACCESOS:'), 0, 1, 'L');
        $this->pdf->SetFont('Arial', '', 9);
        $this->pdf->SetX($margenOriginal);
        $this->pdf->MultiCell(190, $lineHeight, utf8_decode('Se gestionaron un total de ' . $totalesGenerales . ' registros de control de accesos de empleados, visitantes, proveedores, y clientes, en las distintas instalaciones ingresados en nuestro sistema PROTEAPP®.  El proceso de control incluyó la verificación de identidades y la inspección de vehículos conforme a los procedimientos establecidos, garantizando el cumplimiento de las políticas de seguridad de ' . $datos['cliente'] . ' .'), 0, 'J');

        $this->pdf->Ln();
        $this->pdf->SetX($margenOriginal);

        $this->pdf->SetFont('Arial', 'B', 8);


        // Cabecera de la tabla
        $header = array('SITIO', 'EMPLEADOS', 'VISITANTES', 'PROVEEDORES', 'CLIENTES', 'TOTAL');
        $w = array(45, 25, 25, 30, 30, 30);

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


        // if (!empty($datos['control_acceso']) && is_array($datos['control_acceso'])) {
        //     foreach ([$datos['control_acceso']] as $row) {
        //         $this->pdf->SetX($margenOriginal);
        
        //         // Calcular alturas de las celdas
        //         $cellHeights = [];
        //         foreach ($w as $index => $width) {
        //             $value = isset($row[$index]) ? $row[$index] : '';
        //             $cellHeights[] = $this->getCellHeight($value, $width);
        //         }
        
        //         // Obtener la altura máxima para la fila
        //         $maxHeight = max($cellHeights);
        
        //         // Dibujar las celdas con la altura máxima
        //         foreach ($w as $index => $width) {
        //             $value = isset($row[$index]) ? $row[$index] : '';
        //             $this->pdf->Cell($width, $maxHeight, utf8_decode($value), 1, 0, 'C');
        //         }
        
        //         // Mover a la siguiente línea
        //         $this->pdf->Ln($maxHeight);
        //     }
        // }

        // Restaurar color
        $this->pdf->SetFillColor(224, 235, 255);
        $this->pdf->SetTextColor(0, 0, 0);
        $this->pdf->SetFont('Arial', '', 8);

        
        

       $this->pdf->SetX($margenOriginal);
        //'SITIO', 'EMPLEADOS', 'VISITANTES', 'PROVEEDORES', 'CLIENTES', 'TOTAL'
  
    //    if (isset($control_acceso) && is_array($control_acceso)) {
    //         foreach ($control_acceso as $row) {
                
    //             $this->pdf->Cell(45, 10, $row['tx_localidad'], 1, 0, 'C');  
    //             $this->pdf->Cell(25, 10, $row['id_empleado'], 1, 0, 'C');  
    //             $this->pdf->Cell(25, 10, $row['id_visitante'], 1, 0, 'C');  
    //             $this->pdf->Cell(30, 10, $row['id_cliente'], 1, 0, 'C');  
    //             $this->pdf->Cell(30, 10, $row['id_cliente'], 1, 0, 'C');  
    //              // Sumar los valores de las celdas (asegurándote de que sean números)
    //     $total = (float)$row['id_empleado'] + (float)$row['id_visitante'] + (float)$row['id_cliente'] + (float)$row['id_cliente']; 

    //     // Imprimir el total en la última columna
    //     $this->pdf->Cell(30, 10, number_format($total, 2), 1, 0, 'C');  // Columna TOTAL con el valor calculado

    //     // Salto de línea para la siguiente fila
    //     $this->pdf->Ln();
    //              $this->pdf->SetX($margenOriginal);
    //         }
    if (isset($control_acceso) && is_array($control_acceso)) {
        // Convertir el array a una colección para usar las funciones de Laravel
        $controlAcceso = collect($control_acceso);
    
        // Agrupar por id_localidad
        $agrupadoPorLocalidad = $controlAcceso->groupBy('id_localidad');
    
        // Definir los anchos de las columnas
        $colWidths = [45, 25, 25, 30, 30, 30]; // Ajusta estos valores según el diseño
    
        // Inicializar las variables para los totales
        $totalEmpleado = 0;
        $totalVisitante = 0;
        $totalCliente = 0;
        $totalEmpresa = 0;
        $totalFila = 0;  // Total por fila para cada grupo
    
        // Recorrer los grupos agrupados por id_localidad
        foreach ($agrupadoPorLocalidad as $idLocalidad => $grupo) {
            // Obtener el valor de txt_localidad del primer elemento del grupo (suponiendo que todos los elementos tienen el mismo valor para txt_localidad)
            $txtLocalidad = $grupo->first()['tx_localidad'];
    
            // Realizar el count distinct de los campos
            $countEmpleado = $grupo->pluck('id_empleado')->unique()->count();
            $countVisitante = $grupo->pluck('id_visitante')->unique()->count();
            $countCliente = $grupo->pluck('id_cliente')->unique()->count();
            $countEmpresa = $grupo->pluck('empresa')->unique()->count();
    
            // Crear el array con los datos a mostrar
            $data = [
                $txtLocalidad,  // Mostrar txt_localidad en lugar de id_localidad
                $countEmpleado,  // Contar distintos id_empleado
                $countVisitante,  // Contar distintos id_visitante
                $countEmpresa,  // Contar distintos empresa
                $countCliente,  // Contar distintos id_cliente
            ];
    
            // Calcular la altura máxima de la fila
            $maxHeight = 0;
            foreach ($data as $index => $content) {
                // Estimar el número de líneas necesarias para el contenido
                $lineCount = $this->pdf->GetStringWidth((string)$content) / $colWidths[$index];
                $lineCount = ceil($lineCount); // Redondear hacia arriba
                $cellHeight = $lineCount * 5; // Altura de línea (ajusta 5 según necesidad)
                $maxHeight = max($maxHeight, $cellHeight); 
                $maxHeight = $maxHeight + 1; // Tomar la altura máxima
            }
    
            // Dibujar las celdas de la fila con la misma altura máxima
            foreach ($data as $index => $content) {
                $x = $this->pdf->GetX(); // Posición X actual
                $y = $this->pdf->GetY(); // Posición Y actual
    
                // Dibujar un rectángulo para el borde de la celda
                $this->pdf->Rect($x, $y, $colWidths[$index], $maxHeight);
    
                // Escribir el contenido dentro de la celda con MultiCell
                $this->pdf->MultiCell($colWidths[$index], 5, (string)$content, 0, 'C'); // Cambié a 'C' para centrar el texto
    
                // Volver a la posición derecha para la siguiente celda
                $this->pdf->SetXY($x + $colWidths[$index], $y);
            }
    
            // Calcular el total de esta fila (sumando todas las columnas)
            $totalFila = $countEmpleado + $countVisitante + $countEmpresa + $countCliente;
    
            // Mostrar el total de la fila en la última columna
            $this->pdf->Cell($colWidths[count($data)], 10, number_format($totalFila, 2), 1, 0, 'C');
    
            // Sumar los totales generales
            $totalEmpleado += $countEmpleado;
            $totalVisitante += $countVisitante;
            $totalCliente += $countCliente;
            $totalEmpresa += $countEmpresa;
    
            // Saltar a la siguiente fila
            $this->pdf->Ln($maxHeight);
            $this->pdf->SetX($margenOriginal);
        }
    
        // Mostrar los totales generales al pie de la tabla
        $this->pdf->SetXY($margenOriginal, $this->pdf->GetY()); // Ajustar la posición para los totales
        $this->pdf->SetFillColor(200, 200, 200); // Color gris claro para el pie de tabla
       
        $this->pdf->Cell($colWidths[0], 10, 'TOTAL GENERAL', 1, 0, 'C', 1); // Agregar 1 al parámetro fill
$this->pdf->Cell($colWidths[1], 10, number_format($totalEmpleado, 0), 1, 0, 'C', 1);
$this->pdf->Cell($colWidths[2], 10, number_format($totalVisitante, 0), 1, 0, 'C', 1);
$this->pdf->Cell($colWidths[3], 10, number_format($totalEmpresa, 0), 1, 0, 'C', 1);
$this->pdf->Cell($colWidths[4], 10, number_format($totalCliente, 0), 1, 0, 'C', 1);
$this->pdf->Cell($colWidths[5], 10, number_format($totalEmpleado + $totalVisitante + $totalCliente + $totalEmpresa, 2), 1, 0, 'C', 1);

        
        // El salto de línea final
        $this->pdf->Ln(10);
    }

     // Restaurar color
     $this->pdf->SetFillColor(224, 235, 255);
     $this->pdf->SetTextColor(0, 0, 0);
     $this->pdf->SetFont('Arial', '', 8);
    


        #-------------Tabla 4 ------------------

        // Contenido
        $sumaTotal = 0;
        if (!empty($datos['reporte_custodia']) && is_array($datos['reporte_custodia'])) {
            $sumaTotal= count($datos['reporte_custodia']);
         }

        $this->pdf->Ln( );
        $this->pdf->SetX($margenOriginal);

        $this->pdf->SetFont('Arial', 'B', 11);
        $this->pdf->Cell(190, 10, utf8_decode('2.4.	REPORTE DE CUSTODIAS '), 0, 1, 'L');
        $this->pdf->SetFont('Arial', '', 9);
        $this->pdf->SetX($margenOriginal);
        $this->pdf->MultiCell(190, $lineHeight, utf8_decode('Durante el mes de '. $mes .' se realizaron un total de ' . $sumaTotal .' custodias de mercaderías en tránsito, asegurando el traslado seguro desde las diferentes granjas. '), 0, 'J');
        
        $this->pdf->Ln( );
        $this->pdf->SetX($margenOriginal);


        $this->pdf->SetFont('Arial', 'B', 8);

        $this->pdf->Ln();  // Salto de línea después de la configuración inicial
$this->pdf->SetX($margenOriginal);

$this->pdf->SetFont('Arial', 'B', 8);  // Fuente de la cabecera

// Cabecera de la tabla
$header = array('NO.', 'FECHA', 'GUIA NO.', 'PUNTO PARTIDA', 'PUNTO DE LLEGADA', 'CUSTODIOS', 'CONTENEDOR', 'PLACAS CAMIONES');
$w = array(15, 15, 15, 35, 35, 20, 25, 35);  // Ancho de las columnas

// Color de fondo de la cabecera (negro)
$this->pdf->SetFillColor(0, 0, 0);

// Color del texto (blanco)
$this->pdf->SetTextColor(255, 255, 255);

$this->pdf->SetX($margenOriginal);

// Cabecera usando Cell
for ($i = 0; $i < count($header); $i++) {
    $headerText = $header[$i];

    // Si el texto es largo, lo ajustamos manualmente para que se ajuste dentro de la celda
    $this->pdf->Cell($w[$i], 7, $headerText, 1, 0, 'C', true);  // Usamos Cell para que todo esté en una fila
}

$this->pdf->Ln();  // Después de la cabecera, agregamos un salto de línea


        // // Cabecera de la tabla
        // $header = array( 'NO.', 'FECHA', 'GUIA NO.', 'PUNTO PARTIDA', 'PUNTO DE LLEGADA', 'CUSTODIOS', 'CONTENEDOR', 'PLACAS CAMIONES');
        // $w = array(15, 20, 20, 30, 20, 40, 20,30);

        // // Color de fondo de la cabecera (negro)
        // $this->pdf->SetFillColor(0, 0, 0);

        // // Color del texto (blanco)
        // $this->pdf->SetTextColor(255, 255, 255);

        // $this->pdf->SetX($margenOriginal);

        // // Cabecera
        // for($i=0;$i<count($header);$i++)
        //     $this->pdf->MultiCell($w[$i],7,$header[$i],1,0,'C',1);
        $this->pdf->Ln();

        // Restaurar color
        $this->pdf->SetFillColor(224, 235, 255);
        $this->pdf->SetTextColor(0, 0, 0);
        $this->pdf->SetFont('Arial', '', 8);

       
        
        if (!empty($datos['reporte_custodia']) && is_array($datos['reporte_custodia'])) {
           

            foreach ([$datos['reporte_custodia']] as $row) {

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
         // Sumar las columnas 3 y 4
         $sumaCol = 0;


        //  foreach ([$datos['incidencia_seguridad']] as $row) {
        //      if (isset($row[4])) {
        //          $sumaCol += (int)$row[4]; // Columna 3
        //      }
        //  }

        if (isset($datos['novedades_reportadas']) && is_string($datos['novedades_reportadas'])) {
            // Convertir la cadena en un array, separando por coma
            $novedades_reportadas = json_decode($datos['novedades_reportadas'], true);
           
 
        }
        

        $totalGeneral = 0;

        if (isset($novedades_reportadas) && is_array($novedades_reportadas)) {
            // Convertir el array a una colección para usar las funciones de Laravel
            $novedades = collect($novedades_reportadas);
            
            // Agrupar por id_localidad
            $novedadesAgrupadas = $novedades->groupBy('id_localidad');
            
            // Inicializar los totales
            $totalTitulo = 0;
            $totalTipoNovedad = 0;
            $totalTipoHallazgo = 0;
            $totalGeneral = 0; // Total general que suma las tres columnas
            
            // Recorrer los grupos de novedades agrupados por id_localidad
            foreach ($novedadesAgrupadas as $idLocalidad => $grupo) {
                // Obtener el valor de txt_localidad del primer elemento del grupo (asumiendo que todos los elementos tienen el mismo valor para txt_localidad)
                $txtLocalidad = $grupo->first()['txt_localidad'];
            
                // Contar los valores no vacíos en cada campo
                $countTitulo = $grupo->whereNotNull('titulo')->count();
                $countTipoNovedad = $grupo->whereNotNull('TIPO_NOVEDAD')->count();
                $countTipoHallazgo = $grupo->whereNotNull('tipo_hallazgo')->count();
            
                // Calcular la suma de los tres conteos
                $totalCount = $countTitulo + $countTipoNovedad + $countTipoHallazgo;
            
                // Sumar los totales
                $totalTitulo += $countTitulo;
                $totalTipoNovedad += $countTipoNovedad;
                $totalTipoHallazgo += $countTipoHallazgo;
                $totalGeneral += $totalCount;
            }
        }

        


        $this->pdf->SetX($margenOriginal);
        $this->pdf->SetFont('Arial', 'B', 11);
        $this->pdf->Cell(190, 10, utf8_decode('3.2.	NOVEDADES REPORTADAS EN PROTEAPP® '), 0, 1, 'L');
        $this->pdf->SetFont('Arial', '', 9);
        $this->pdf->SetX($margenOriginal);
        $this->pdf->MultiCell(190, $lineHeight, utf8_decode('A lo largo de este período, se han identificado y reportado en nuestro sistema PROTEAPP® '. $totalGeneral . ' novedades relevantes en todos los sitios, que destacan la importancia de nuestra gestión de vigilancia y seguridad, las cuales se resumen a continuación:'), 0, 'J');

        
        $this->pdf->Ln( );
        $this->pdf->SetX($margenOriginal);


        $this->pdf->SetFont('Arial', 'B', 8);


        // Cabecera de la tabla
        $header = array('SITIO',
        'INCIDENTES',
        'HALLAZGOS',
        'NOVEDADES DEL SITIO',
        'TOTAL NOVEDADES REPORTADAS EN PROTEAPP');
        $w = array(40, 20, 20, 45, 70);

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


        // if (!empty($datos['incidencia_seguridad']) && is_array($datos['incidencia_seguridad'])) {
        //     foreach ([$datos['incidencia_seguridad']] as $row) {
        //         $this->pdf->SetX($margenOriginal);
        
        //         // Calcular alturas de las celdas
        //         $cellHeights = [];
        //         foreach ($w as $index => $width) {
        //             $value = isset($row[$index]) ? $row[$index] : '';
        //             $cellHeights[] = $this->getCellHeight($value, $width);
        //         }
        
        //         // Obtener la altura máxima para la fila
        //         $maxHeight = max($cellHeights);
        
        //         // Dibujar las celdas con la altura máxima
        //         foreach ($w as $index => $width) {
        //             $value = isset($row[$index]) ? $row[$index] : '';
        //             $this->pdf->Cell($width, $maxHeight, utf8_decode($value), 1, 0, 'C');
        //         }
        
        //         // Mover a la siguiente línea
        //         $this->pdf->Ln($maxHeight);
        //     }
        // }

        // Restaurar color
        $this->pdf->SetFillColor(224, 235, 255);
        $this->pdf->SetTextColor(0, 0, 0);
        $this->pdf->SetFont('Arial', '', 8);

        
       

       //'SITIO','INCIDENTES','HALLAZGOS','NOVEDADES DEL SITIO','TOTAL NOVEDADES REPORTADAS EN PROTEAPP'

    
        $this->pdf->SetX($margenOriginal);

      
  
    //    if (isset($novedades_reportadas) && is_array($novedades_reportadas)) {
    //         foreach ($novedades_reportadas as $row) {
                
    //             $this->pdf->Cell(40, 10, $row['id_localidad'], 1, 0, 'C');  // Columna Titulo
    //             $this->pdf->Cell(20, 10, $row['titulo'], 1, 0, 'C');  // Columna Frecuencia
    //             $this->pdf->Cell(20, 10, $row['titulo'], 1, 'J');  // Columna Recomenda
    //             $this->pdf->Cell(45, 10, $row['titulo'], 1, 'J');  // Columna Recomenda
    //             $this->pdf->Cell(70, 10, $row['tipo_protemaxi'], 1, 'J');  // Columna Recomenda
    //             $this->pdf->SetX($margenOriginal);
    //         }
    //     }


    // if (isset($novedades_reportadas) && is_array($novedades_reportadas)) {
    //     foreach ($novedades_reportadas as $row) {
    //         // Definir los anchos de las columnas
    //         $colWidths = [40, 50, 50, 70];
    //         $maxHeight = 10; // Altura inicial de la celda
    
    //         // Calcular la altura máxima de la fila según el contenido más largo
    //         $maxHeight = max(
    //             $this->pdf->GetStringWidth($row['id_localidad']) / $colWidths[0] * 10,
    //             $this->pdf->GetStringWidth($row['titulo']) / $colWidths[1] * 10,
    //             $this->pdf->GetStringWidth($row['tipo_protemaxi']) / $colWidths[3] * 10,
    //         );
    
    //         // Obtener la altura máxima según el texto ajustado
    //         $height = $maxHeight;
    
    //         // Primera columna (id_localidad)
    //         $this->pdf->MultiCell($colWidths[0], $height, $row['id_localidad']);
    //         $this->pdf->MultiCell($colWidths[0], $height, $row['titulo']);
    //         $this->pdf->MultiCell($colWidths[0], $height, $row['titulo']);
    //         $this->pdf->MultiCell($colWidths[0], $height, $row['titulo']);
    
    //  } }
    
        
    // if (isset($novedades_reportadas) && is_array($novedades_reportadas)) {
    //     // Definir los anchos de las columnas
    //     $colWidths = [40, 50, 50, 70, 30]; // Ajusta estos valores según el diseño
        
    
    //     // Recorrer los datos para mostrar filas
    //     foreach ($novedades_reportadas as $row) {
    //         // Almacenar el contenido de cada columna en un arreglo

    //         $data = [
    //             $row['id_localidad'],
    //             $row['titulo'],
    //             $row['detalle'], 
    //             $row['titulo'],
    //             $row['tipo_protemaxi']
    //         ];
    
    //         // Calcular la altura máxima de la fila basada en el contenido de las celdas
    //         $maxHeight = 0;
    //         foreach ($data as $index => $content) {
    //             // Calcular la altura necesaria para cada celda
    //             $lineCount = $this->pdf->GetStringWidth($content) / $colWidths[$index];
    //             $cellHeight = ceil($lineCount) * 5; // Ajusta 5 según el espaciado deseado
    //             $maxHeight = max($maxHeight, $cellHeight); // Tomar el máximo de todas las celdas
    //         }
    
    //         // Dibujar las celdas de la fila con MultiCell
    //         foreach ($data as $index => $content) {
    //             $x = $this->pdf->GetX(); // Posición X actual
    //             $y = $this->pdf->GetY(); // Posición Y actual
    //             $this->pdf->MultiCell($colWidths[$index], 5, $content, 1, 'L'); // Celda con ajuste de texto
    //             $this->pdf->SetXY($x + $colWidths[$index], $y); // Volver a la posición derecha para la siguiente celda
    //         }
    
    //         $this->pdf->Ln($maxHeight); // Saltar a la siguiente fila
    //         $this->pdf->SetX($margenOriginal);
    //     }
    // }
    

    //este si vale
    // if (isset($novedades_reportadas) && is_array($novedades_reportadas)) {
    //     // Definir los anchos de las columnas
    //     $colWidths = [40, 20, 20, 45, 70]; // Ajusta estos valores según el diseño
       
    //     // Recorrer los datos para mostrar filas
    //     foreach ($novedades_reportadas as $row) {
    //         // Almacenar el contenido de cada columna en un arreglo
    //         $data = [
    //             $row['txt_localidad'],
    //             $row['titulo'],
    //             $row['TIPO_NOVEDAD'],
    //             $row['tipo_hallazgo'],
    //             $row['tipo_protemaxi'],
           
    //         ];
    
    //         // Calcular la altura máxima de la fila
    //         $maxHeight = 0;
    //         foreach ($data as $index => $content) {
    //             // Estimar el número de líneas necesarias para el contenido
    //             $lineCount = $this->pdf->GetStringWidth($content) / $colWidths[$index];
    //             $lineCount = ceil($lineCount); // Redondear hacia arriba
    //             $cellHeight = $lineCount * 5; // Altura de línea (ajusta 5 según necesidad)
    //             $maxHeight = max($maxHeight, $cellHeight); 
    //             $maxHeight= $maxHeight + 1 ;// Tomar la altura máxima
    //         }
    
    //         // Dibujar las celdas de la fila con la misma altura máxima
    //         foreach ($data as $index => $content) {
    //             $x = $this->pdf->GetX(); // Posición X actual
    //             $y = $this->pdf->GetY(); // Posición Y actual
    
    //             // Dibujar un rectángulo para el borde de la celda
    //             $this->pdf->Rect($x, $y, $colWidths[$index], $maxHeight);
    
    //             // Escribir el contenido dentro de la celda con MultiCell
    //             $this->pdf->MultiCell($colWidths[$index], 5, $content, 0, 'L');
    
    //             // Volver a la posición derecha para la siguiente celda
    //             $this->pdf->SetXY($x + $colWidths[$index], $y);
    //         }
    
    //         // Saltar a la siguiente fila
    //         $this->pdf->Ln($maxHeight);
    //         $this->pdf->SetX($margenOriginal);
    //     }
    // }


    // if (isset($novedades_reportadas) && is_array($novedades_reportadas)) {
    //     // Convertir el array a una colección para usar las funciones de Laravel
    //     $novedades = collect($novedades_reportadas);
        
    //     // Agrupar por id_localidad
    //     $novedadesAgrupadas = $novedades->groupBy('id_localidad');
        
    //     // Definir los anchos de las columnas
    //     $colWidths = [40, 20, 20, 45, 70]; // Ajusta estos valores según el diseño
    
    //     // Recorrer los grupos de novedades agrupados por id_localidad
    //     foreach ($novedadesAgrupadas as $idLocalidad => $grupo) {
    //         // Contar los valores no vacíos en cada campo
    //         $countTitulo = $grupo->whereNotNull('titulo')->count();
    //         $countTipoNovedad = $grupo->whereNotNull('TIPO_NOVEDAD')->count();
    //         $countTipoHallazgo = $grupo->whereNotNull('tipo_hallazgo')->count();
    
    //         // Calcular la suma de los tres conteos
    //         $totalCount = $countTitulo + $countTipoNovedad + $countTipoHallazgo;
    
    //         // Crear el array con los datos a mostrar
    //         $data = [
    //             $idLocalidad,  // Mostrar el id_localidad
    //             $countTitulo,  // Contar cuántos títulos existen en esta localidad
    //             $countTipoNovedad,  // Contar cuántos TIPO_NOVEDAD existen en esta localidad
    //             $countTipoHallazgo,  // Contar cuántos tipo_hallazgo existen en esta localidad
    //             $totalCount  // Mostrar la suma total
    //         ];
    
    //         // Calcular la altura máxima de la fila
    //         $maxHeight = 0;
    //         foreach ($data as $index => $content) {
    //             // Estimar el número de líneas necesarias para el contenido
    //             $lineCount = $this->pdf->GetStringWidth((string)$content) / $colWidths[$index];
    //             $lineCount = ceil($lineCount); // Redondear hacia arriba
    //             $cellHeight = $lineCount * 5; // Altura de línea (ajusta 5 según necesidad)
    //             $maxHeight = max($maxHeight, $cellHeight); 
    //             $maxHeight = $maxHeight + 1; // Tomar la altura máxima
    //         }
    
    //         // Dibujar las celdas de la fila con la misma altura máxima
    //         foreach ($data as $index => $content) {
    //             $x = $this->pdf->GetX(); // Posición X actual
    //             $y = $this->pdf->GetY(); // Posición Y actual
    
    //             // Dibujar un rectángulo para el borde de la celda
    //             $this->pdf->Rect($x, $y, $colWidths[$index], $maxHeight);
    
    //             // Escribir el contenido dentro de la celda con MultiCell
    //             $this->pdf->MultiCell($colWidths[$index], 5, (string)$content, 0, 'L');
    
    //             // Volver a la posición derecha para la siguiente celda
    //             $this->pdf->SetXY($x + $colWidths[$index], $y);
    //         }
    
    //         // Saltar a la siguiente fila
    //         $this->pdf->Ln($maxHeight);
    //         $this->pdf->SetX($margenOriginal);
    //     }
    // }
    
    if (isset($novedades_reportadas) && is_array($novedades_reportadas)) {
        // Convertir el array a una colección para usar las funciones de Laravel
        $novedades = collect($novedades_reportadas);
        
        // Agrupar por id_localidad
        $novedadesAgrupadas = $novedades->groupBy('id_localidad');
        
        // Definir los anchos de las columnas
        $colWidths = [40, 20, 20, 45, 70]; // Ajusta estos valores según el diseño
    
        // Inicializar los totales
        $totalTitulo = 0;
        $totalTipoNovedad = 0;
        $totalTipoHallazgo = 0;
        $totalGeneral = 0; // Total general que suma las tres columnas
    
        // Recorrer los grupos de novedades agrupados por id_localidad
        foreach ($novedadesAgrupadas as $idLocalidad => $grupo) {
            // Obtener el valor de txt_localidad del primer elemento del grupo (asumiendo que todos los elementos tienen el mismo valor para txt_localidad)
            $txtLocalidad = $grupo->first()['txt_localidad'];
    
            // Contar los valores no vacíos en cada campo
            $countTitulo = $grupo->whereNotNull('titulo')->count();
            $countTipoNovedad = $grupo->whereNotNull('TIPO_NOVEDAD')->count();
            $countTipoHallazgo = $grupo->whereNotNull('tipo_hallazgo')->count();
    
            // Calcular la suma de los tres conteos
            $totalCount = $countTitulo + $countTipoNovedad + $countTipoHallazgo;
    
            // Crear el array con los datos a mostrar
            $data = [
                $txtLocalidad,  // Mostrar txt_localidad en lugar de id_localidad
                $countTitulo,  // Contar cuántos títulos existen en esta localidad
                $countTipoNovedad,  // Contar cuántos TIPO_NOVEDAD existen en esta localidad
                $countTipoHallazgo,  // Contar cuántos tipo_hallazgo existen en esta localidad
                $totalCount  // Mostrar la suma total
            ];
    
            // Calcular la altura máxima de la fila
            $maxHeight = 0;
            foreach ($data as $index => $content) {
                // Estimar el número de líneas necesarias para el contenido
                $lineCount = $this->pdf->GetStringWidth((string)$content) / $colWidths[$index];
                $lineCount = ceil($lineCount); // Redondear hacia arriba
                $cellHeight = $lineCount * 5; // Altura de línea (ajusta 5 según necesidad)
                $maxHeight = max($maxHeight, $cellHeight); 
                $maxHeight = $maxHeight + 1; // Tomar la altura máxima
            }
    
            // Dibujar las celdas de la fila con la misma altura máxima
            foreach ($data as $index => $content) {
                $x = $this->pdf->GetX(); // Posición X actual
                $y = $this->pdf->GetY(); // Posición Y actual
    
                // Dibujar un rectángulo para el borde de la celda
                $this->pdf->Rect($x, $y, $colWidths[$index], $maxHeight);
    
                // Escribir el contenido dentro de la celda con MultiCell
                $this->pdf->MultiCell($colWidths[$index], 5, (string)$content, 0, 'C');
    
                // Volver a la posición derecha para la siguiente celda
                $this->pdf->SetXY($x + $colWidths[$index], $y);
            }
    
            // Sumar los totales
            $totalTitulo += $countTitulo;
            $totalTipoNovedad += $countTipoNovedad;
            $totalTipoHallazgo += $countTipoHallazgo;
            $totalGeneral += $totalCount;
    
            // Saltar a la siguiente fila
            $this->pdf->Ln($maxHeight);
            $this->pdf->SetX($margenOriginal);
        }
    
        // Mostrar el pie de página con los totales
        $this->pdf->SetXY($margenOriginal, $this->pdf->GetY()); // Ajustar la posición para los totales
        $this->pdf->SetFillColor(200, 200, 200); // Color gris claro para el pie de tabla
        $this->pdf->Cell($colWidths[0], 10, 'TOTAL GENERAL', 1, 0, 'C', 1); // Columna de "Totales"
        $this->pdf->Cell($colWidths[1], 10, number_format($totalTitulo, 0), 1, 0, 'C', 1);
        $this->pdf->Cell($colWidths[2], 10, number_format($totalTipoNovedad, 0), 1, 0, 'C', 1);
        $this->pdf->Cell($colWidths[3], 10, number_format($totalTipoHallazgo, 0), 1, 0, 'C', 1);
        $this->pdf->Cell($colWidths[4], 10, number_format($totalGeneral, 0), 1, 0, 'C', 1); // Total general de todas las columnas
    
        // El salto de línea final
        $this->pdf->Ln(10);
    }
    
       

        

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


        // if (!empty($datos['novedades_reportadas']) && is_array($datos['novedades_reportadas'])) {
        //     foreach ([$datos['novedades_reportadas'] ]as $row) {
        //         $this->pdf->SetX($margenOriginal);
        
        //         // Calcular alturas de las celdas
        //         $cellHeights = [];
        //         foreach ($w as $index => $width) {
        //             $value = isset($row[$index]) ? $row[$index] : '';
        //             $cellHeights[] = $this->getCellHeight($value, $width);
        //         }
        
        //         // Obtener la altura máxima para la fila
        //         $maxHeight = max($cellHeights);
        
        //         // Dibujar las celdas con la altura máxima
        //         foreach ($w as $index => $width) {
        //             $value = isset($row[$index]) ? $row[$index] : '';
        //             $this->pdf->Cell($width, $maxHeight, utf8_decode($value), 1, 0, 'C');
        //         }
        
        //         // Mover a la siguiente línea
        //         $this->pdf->Ln($maxHeight);
        //     }
        // }

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
        $w = array(20,  30, 40, 40, 50);

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


        if (!empty($datos['cambio_nomina_personal']) && is_array($datos['cambio_nomina_personal'])) {
            foreach ([$datos['cambio_nomina_personal'] ]as $row) {
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
        $this->pdf->MultiCell(190, $lineHeight, utf8_decode('Durante el mes de ' . $mes . ' se proporcionaron los siguientes valores agregados solicitados por el departamento de seguridad física de ' . $datos['cliente'] . ' :'), 0, 'J');
        $this->pdf->Ln();
        $this->pdf->SetX($margenOriginal);
        if (isset($datos['acciones_correctivas']) && is_array($datos['acciones_correctivas'])) {
            $counter = 1;
            foreach ([$datos['acciones_correctivas']] as $item) {
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
        $this->pdf->MultiCell(190, $lineHeight, utf8_decode('El servicio de seguridad proporcionado por PROTEMAXI durante ' . $mes . '  cumplió con los requisitos esperados, garantizando la protección de las instalaciones de '. $datos['cliente'] . '  en todos los puntos de servicio. '), 0, 'J');
        $this->pdf->Ln();
        $this->pdf->SetX($margenOriginal);

    
        $this->pdf->SetFont('Arial', 'B', 8);


        // Cabecera de la tabla
        $header = array(
        'INCIDENCIA',
        'FRECUENCIA',
        'RECOMENDACION');
        $w = array(75, 30, 90);

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

         
         if (isset($datos['recomendaciones']) && is_string($datos['recomendaciones'])) {
            // Convertir la cadena en un array, separando por coma
            $recomendaciones = json_decode($datos['recomendaciones'], true);
           

        }

        
        $this->pdf->SetX($margenOriginal);

  
       if (isset($recomendaciones) && is_array($recomendaciones)) {
            foreach ($recomendaciones as $row) {
                
                $this->pdf->Cell(75, 10, $row['titulo'], 1, 0, 'C');  // Columna Titulo
                $this->pdf->Cell(30, 10, $row['frecuencia'], 1, 0, 'C');  // Columna Frecuencia
                $this->pdf->Cell(90, 10, $row['recomendacion'], 1, 'J');  // Columna Recomenda
                 $this->pdf->SetX($margenOriginal);
            }
        }


        
        
        // if (isset($datos['recomendaciones']) && is_array($datos['recomendaciones'])) {
        //     $counter = 1;
        //     foreach ($datos['recomendaciones'] as $item) {
        //         $this->pdf->Ln(2); // Espacio entre los elementos de la lista
        //         $this->pdf->MultiCell(190, $lineHeight, utf8_decode($counter . '. ' . $item), 0, 'L');
        //         $counter++;
        //     }
        // }


        
       # $this->pdf->MultiCell(190, $lineHeight, utf8_decode($datos['recomendaciones']), 0, 'J');
        

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
