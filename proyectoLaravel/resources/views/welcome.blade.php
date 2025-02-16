<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel de Control')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .search-input {
    padding: 0.5rem;
    width: 300px;  /* Aseguramos que todos tengan el mismo ancho */
    border: 1px solid #ccc;
    border-radius: 4px;
    outline: none;
    margin-right: 0.5rem;
}
        .navbar {
            display: flex;
            align-items: center;
            background-color: #00008B;
            padding: 1rem;
            color: #fff;
        }
        .navbar .logo {
            display: flex;
            align-items: center;
            margin-right: auto;
        }
        .navbar .logo img {
            height: 40px;
            margin-right: 10px;
        }
        .content {
            padding: 2rem;
        }
        .search-container {
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
        }
        .search-container input[type="text"],
        .search-container input[type="date"] {
            padding: 0.5rem;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            margin-right: 0.5rem;
        }
        .table-container {
            margin-top: 1.5rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 1rem;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .btn-report {
            padding: 0.25rem 0.5rem;
            font-size: 0.9rem;
            width: 40%;
            background-color: #00008B;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .loading {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }
        .loading-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="loading">
        <div class="loading-content">
            <p>Procesando reporte...</p>
        </div>
    </div>

    <div class="navbar">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </div>
    </div>

    <div class="content">
        <h2>Módulo de Reportería</h2>

        <div class="search-container">
            <input type="text"  class="search-input" placeholder="Buscar Cliente..." onkeyup="buscarPorCliente()">
            <input type="month" class="search-input" placeholder="Buscar por Periodo" onchange="buscarPorPeriodo()">
            <input type="date" class="search-input" placeholder="Buscar por Fecha" onchange="buscarPorFecha()">
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Periodo</th>
                        <th>Fecha de Reporte</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="detallesTable">
                    <!-- Aquí se cargarán los datos con JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
let accionJSON = [];

// Obtener las recomendaciones
fetch('/accion')
    .then(response => response.json())  // Convertir la respuesta en formato JSON
    .then(data => {
        accionJSON = data;
        console.log("accionJSON", data)
    })
    .catch(error => {
        console.error('Error al obtener accionJSON:', error);
    });

let coberturaJSON = [];

// Obtener las recomendaciones
fetch('/cobertura')
    .then(response => response.json())  // Convertir la respuesta en formato JSON
    .then(data => {
        coberturaJSON = data;
        console.log("coberturaJSON", data)
    })
    .catch(error => {
        console.error('Error al obtener coberturaJSON:', error);
    });


    let nominaJSON = [];

// Obtener las recomendaciones
fetch('/nomina')
    .then(response => response.json())  // Convertir la respuesta en formato JSON
    .then(data => {
        nominaJSON = data;
        console.log("nominaJSON", data)
    })
    .catch(error => {
        console.error('Error al obtener nominaJSON:', error);
    });

    let custodiaJSON = [];

// Obtener las recomendaciones
fetch('/custodia')
    .then(response => response.json())  // Convertir la respuesta en formato JSON
    .then(data => {
        custodiaJSON = data;
        console.log("custodiaJSON", data)
    })
    .catch(error => {
        console.error('Error al obtener custodiaJSON:', error);
    });

let valorJSON = [];

// Obtener las recomendaciones
fetch('/valor')
    .then(response => response.json())  // Convertir la respuesta en formato JSON
    .then(data => {
        valorJSON = data;
        console.log("valor", data)
    })
    .catch(error => {
        console.error('Error al obtener rondasJSON:', error);
    });

        let rondasJSON = [];

        // Obtener las recomendaciones
        fetch('/rondas')
            .then(response => response.json())  // Convertir la respuesta en formato JSON
            .then(data => {
                rondasJSON = data;
                console.log("rondas", data)
            })
            .catch(error => {
                console.error('Error al obtener rondasJSON:', error);
            });

        let novedadesJSON = [];

        // Obtener las recomendaciones
        fetch('/novedades')
            .then(response => response.json())  // Convertir la respuesta en formato JSON
            .then(data => {
                novedadesJSON = data;
                console.log("novedades", data)
                
            })
            .catch(error => {
                console.error('Error al obtener novedadesJSON:', error);
            });
    
        let controlJSON = [];

        // Obtener las recomendaciones
        fetch('/control')
            .then(response => response.json())  // Convertir la respuesta en formato JSON
            .then(data => {
                controlJSON = data;
                console.log("control", data)
                
            })
            .catch(error => {
                console.error('Error al obtener control:', error);
            });
        // Variable para almacenar las recomendaciones
        let recomendacionesJSON = [];

        // Obtener las recomendaciones
        fetch('/recomendaciones')
            .then(response => response.json())  // Convertir la respuesta en formato JSON
            .then(data => {
                recomendacionesJSON = data;
                console.log("recomendacions", data)
            })
            .catch(error => {
                console.error('Error al obtener las recomendaciones:', error);
            });

        // Función para obtener el nombre del mes en mayúsculas y el año
        function obtenerNombreMesYAnio(fecha) {
            const opciones = { year: 'numeric', month: 'long' };
            const fechaFormateada = new Date(fecha).toLocaleDateString('es-ES', opciones);
            const [mes, anio] = fechaFormateada.split(' de ');

            return `${mes.toUpperCase()} ${anio}`;
        }

        function buscarPorCliente() {
            const input = document.querySelector('.search-container input[type="text"]');
            const filter = input.value.toLowerCase();
            const table = document.querySelector('table');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                const tdCliente = tr[i].getElementsByTagName('td')[1];
                if (tdCliente) {
                    const textValue = tdCliente.textContent || tdCliente.innerText;
                    tr[i].style.display = textValue.toLowerCase().includes(filter) ? "" : "none";
                }
            }
        }

        function buscarPorPeriodo() {
    const inputPeriodo = document.querySelector('.search-container input[type="month"]');
    const periodoSeleccionado = inputPeriodo.value; // Recoge el valor de mes y año (YYYY-MM)
    const table = document.querySelector('table');
    const tr = table.getElementsByTagName('tr');

    for (let i = 1; i < tr.length; i++) {
        const tdPeriodo = tr[i].getElementsByTagName('td')[2]; // Columna de Periodo
        if (tdPeriodo) {
            const periodoValue = tdPeriodo.textContent || tdPeriodo.innerText;

            // Convertir el texto "ENERO 2024" a formato "2024-01"
            const [mes, anio] = periodoValue.split(' ');
            const mesNumerico = obtenerMesNumerico(mes); // Función que convierte el nombre del mes a número
            const periodoFormateado = `${anio}-${String(mesNumerico).padStart(2, '0')}`;

            // Comparar el periodo en la tabla con el valor seleccionado
            tr[i].style.display = periodoFormateado.includes(periodoSeleccionado) || periodoSeleccionado === "" ? "" : "none";
        }
    }
}

// Función para convertir el nombre del mes a su número correspondiente
function obtenerMesNumerico(mes) {
    const meses = {
        "ENERO": 1,
        "FEBRERO": 2,
        "MARZO": 3,
        "ABRIL": 4,
        "MAYO": 5,
        "JUNIO": 6,
        "JULIO": 7,
        "AGOSTO": 8,
        "SEPTIEMBRE": 9,
        "OCTUBRE": 10,
        "NOVIEMBRE": 11,
        "DICIEMBRE": 12
    };
    return meses[mes.toUpperCase()] || 0; // Devuelve el número del mes, o 0 si no es un mes válido
}

        function buscarPorFecha() {
            const inputFecha = document.querySelector('.search-container input[type="date"]');
            const fechaSeleccionada = inputFecha.value;
            const table = document.querySelector('table');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                const tdFecha = tr[i].getElementsByTagName('td')[2]; // Modificado para la columna de Periodo
                if (tdFecha) {
                    const fechaValue = tdFecha.textContent || tdFecha.innerText;
                    tr[i].style.display = fechaValue === fechaSeleccionada || fechaSeleccionada === "" ? "" : "none";
                }
            }
        }

        function generarPDF(index, cliente, group) {
    // Función para asegurar que las propiedades sean arrays antes de hacer join
    const asegurarArray = (valor) => {
        return Array.isArray(valor) ? valor : [];
    };

    // Función para convertir la fecha en el formato "MES AÑO"
    function obtenerPeriodo(fecha) {
        const meses = [
            'ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'
        ];

        const date = new Date(fecha);  // Convertir el created_at (o cualquier fecha) en un objeto Date
        const mes = meses[date.getMonth()];  // Obtiene el mes (0 - 11)
        const anio = date.getFullYear();    // Obtiene el año

        return `${mes} ${anio}`;
    }

    // Obtener el periodo de created_at en formato "MES AÑO"
    const periodoCreado = obtenerPeriodo(group.fecha_reporte); // Usar 'fecha_reporte' o la que necesites

    // Comparar con el periodo de group
    const ronda_vigilancia = JSON.stringify(rondasJSON.filter(key => {
        const periodoRonda = obtenerPeriodo(key.created_at);  // Formatear 'created_at' de ronda
        return key.tx_cliente === cliente && periodoRonda === group.periodo;  // Comparar periodo
    })) || '';

    // Comparar con el periodo de control_acceso
    const control_acceso = JSON.stringify(controlJSON.filter(key => {
        const periodoControl = obtenerPeriodo(key.fecha);  // Formatear 'created_at' de control_acceso
        return key.tx_cliente === cliente && periodoControl === group.periodo;  // Comparar periodo
    })) || '';

    console.log("desc_localidad", group.desc_localidad);
    console.log("grupo final", group);

    const url = `/generar-pdf?${new URLSearchParams({
        cliente: cliente,  // Nombre genérico del cliente
        id: index,  // Asegúrate de incluir el ID si lo necesitas
        periodo: group.periodo || '',  // Añadir periodo aquí
        destinatario:  '', // Valida si 'destinatario' existe 
        fecha_reporte: group.fecha_reporte || '', // Valida si 'fecha_reporte' existe
        fecha_novedad: asegurarArray(group.fecha_novedad).join(','),
        //desc_codigo: asegurarArray(group.desc_codigo).join(','),
        desc_localidad: group.desc_localidad || '', // Valida si 'desc_localidad' existe
        //desc_puesto: asegurarArray(group.desc_puesto).join(','),
        //desc_agente: asegurarArray(group.id_agente).join(','),
       // desc_tipo_novedad: asegurarArray(group.TIPO_NOVEDAD).join(','),
        // desc_tipo_hallazgo: asegurarArray(group.desc_tipo_hallazgo).join(','),
        // desc_tipo_incidente: asegurarArray(group.desc_tipo_incidente).join(','),
        //desc_tipo_act_puesto: asegurarArray(group.desc_tipo_act_puesto).join(','),
       // desc_tipo_novedad_protemaxi: asegurarArray(group.desc_tipo_novedad_protemaxi).join(','),
        desc_titulo: asegurarArray(group.titulo).join(','),
        desc_detalle: asegurarArray(group.detalle).join(','),
       // desc_persona_involucrada: asegurarArray(group.persona_involucradas).join(','),
        //desc_lugar_involucrado: asegurarArray(group.lugar_involucrado).join(','),
        //desc_comentario: asegurarArray(group.desc_comentario).join(','),
        //desc_nombre_central: asegurarArray(group.centralista).join(','),
        //fecha_envio_novedad: asegurarArray(group.fecha_envio_novedad).join(','),
        //desc_estado_novedad: asegurarArray(group.estado_novedad).join(','),
        //desc_estado_aprobacion: asegurarArray(group.estado).join(','),
        cobertura_servicio: JSON.stringify(coberturaJSON.filter(key => key.cliente === cliente)) || '',
        ronda_vigilancia: ronda_vigilancia,  // Ahora la ronda_vigilancia tiene el filtro con el periodo correcto
       control_acceso: control_acceso,  // Ahora el control_acceso tiene el filtro con el periodo correcto
        reporte_custodia: JSON.stringify(custodiaJSON.filter(key => key.cliente === cliente)) || '',
        incidencia_seguridad: asegurarArray(group.incidencia_seguridad).join(','),
        novedades_reportadas: JSON.stringify([group]) || '',
        cambio_nomina_personal: JSON.stringify(nominaJSON.filter(key => key.cliente === cliente)) || '',
        acciones_correctivas: JSON.stringify(accionJSON.filter(key => key.cliente === cliente)) || '',
        valores_agregados: JSON.stringify(valorJSON.filter(key => key.desc_cliente === cliente)) || '',
        conclusion_recomendaciones: asegurarArray(group.conclusion_recomendaciones).join(','),
        recomendaciones: JSON.stringify(recomendacionesJSON.filter(recomendacion => recomendacion.cliente === cliente)) || '' // Se pasa el JSON de recomendaciones
    }).toString()}`;

    // Redirigir al usuario para generar el PDF
    window.location.href = url;
}


        function handleButtonClick(index, cliente, groupJSON, event) {
            // Llamar a la función con los parámetros correctos
            console.log("groupJSON",JSON.parse(groupJSON));
            actualizarFechaYGenerarPDF(index, cliente, JSON.parse(groupJSON), event);
        }

        async function actualizarFechaYGenerarPDF(index, cliente, group, event) {
            event.preventDefault(); // Esto ahora debería funcionar sin problemas
            const loadingScreen = document.querySelector('.loading');
            loadingScreen.style.display = 'flex';

            try {
                const fechaActual = new Date().toISOString().split('T')[0];
                const fechasNovedad = group.fecha_novedad;

                const response = await fetch('/actualizar-fecha-reporte', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        cliente: cliente,
                        fecha_reporte: fechaActual,
                        fechas_novedad: fechasNovedad
                    })
                });

                if (!response.ok) {
                    throw new Error('Error al actualizar la fecha');
                }

                const data = await response.json();
                console.log("data",data);  // Verifica qué contiene el objeto 'data'


                if (data.success ) {
                    // Solo actualizamos la columna "Fecha de Reporte"
                    const fechaCell = event.target.closest('tr').querySelector('td:nth-child(4)'); // Columna de fecha reporte
                    fechaCell.textContent = fechaActual; // Actualizar solo la fecha

                    // Mantén el valor del "Periodo" sin cambios
                    group.fecha_reporte = fechaActual; // Actualiza el objeto en el cliente

                    // Llamamos a la función para generar el PDF con los datos actualizados
                    generarPDF(index, cliente, group);
                } else {
                    throw new Error('No se pudo actualizar la fecha');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Hubo un error al actualizar la fecha del reporte');
            } finally {
                loadingScreen.style.display = 'none';
            }
        }

        // Función para verificar si la fecha actual es igual o mayor al día 5 del mes actual
function esFechaPosteriorAlDia5() {
    const hoy = new Date();
    const diaHoy = hoy.getDate();
    return diaHoy >= 5;
}

// Fetch para cargar los detalles de los datos
fetch('/novedades')
    .then(response => response.json())
    .then(data => {
        console.log(data); // Verifica que los datos son los esperados
        const groupedData = {};
        const clienteMap = {};
        let clienteCounter = 1;

        const incluirMesAnterior = esFechaPosteriorAlDia5();

        const hoy = new Date();
        const mesActual = hoy.getMonth(); // Mes actual (0 - 11)
        const anioActual = hoy.getFullYear(); // Año actual

        // Agrupar los datos
        data.forEach(detalle => {
            const fechaNovedad = new Date(detalle.fecha_novedad);
            const mesFecha = fechaNovedad.getMonth();
            const anioFecha = fechaNovedad.getFullYear();

            if (incluirMesAnterior) {
                if (anioFecha < anioActual || (anioFecha === anioActual && mesFecha < mesActual)) {
                    const periodo = obtenerNombreMesYAnio(detalle.fecha_novedad);
                    const key = `${detalle.cliente}-${periodo}-${detalle.fecha_reporte}`;

                    if (!groupedData[key]) {
                        groupedData[key] = {
                            desc_cliente: detalle.cliente,
                            periodo: periodo,
                            fecha_reporte: detalle.fecha_reporte,
                            fecha_novedad: [],
                            desc_localidad: detalle.tx_localidad,
                            tipo_novedad: detalle.TIPO_NOVEDAD,
                            detalle: detalle.detalle,
                            tipo_hallazgo: detalle.desc_tipo_hallazgo,
                        };
                    }
                    groupedData[key].fecha_novedad.push(detalle.fecha_novedad);
                }
            } else {
                if (anioFecha < anioActual || (anioFecha === anioActual && mesFecha < mesActual)) {
                    const periodo = obtenerNombreMesYAnio(detalle.fecha_novedad);
                    const key = `${detalle.cliente}-${periodo}-${detalle.fecha_reporte}`;

                    if (!groupedData[key]) {
                        groupedData[key] = {
                            desc_cliente: detalle.cliente,
                            periodo: periodo,
                            fecha_reporte: detalle.fecha_reporte,
                            fecha_novedad: [],
                            desc_localidad: detalle.tx_localidad,
                            tipo_novedad: detalle.TIPO_NOVEDAD,
                            detalle: detalle.detalle,
                            tipo_hallazgo: detalle.desc_tipo_hallazgo,
                        };
                    }
                    groupedData[key].fecha_novedad.push(detalle.fecha_novedad);
                }
            }
        });

        // Llenar la tabla
        const detallesTable = document.getElementById('detallesTable');
        let index = 1;

        Object.keys(groupedData).forEach(key => {
            const group = groupedData[key];

            console.log("group",group);
            const groupJSON = JSON.stringify(group)
                .replace(/'/g, "\\'")  
                .replace(/"/g, '&quot;'); 

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${index++}</td>
                <td>${group.desc_cliente} </td> <!-- Cliente -->
                <td>${group.periodo}</td>  <!-- Periodo -->
                <td>${group.fecha_reporte}</td> <!-- Fecha Reporte -->
                <td>
                    <button onclick="handleButtonClick(${index}, '${group.desc_cliente}', '${groupJSON}', event)" class="btn-report">
                        &#128190; Generar Reporte
                    </button>
                </td>
            `;
            detallesTable.appendChild(row);
        });
    })
    .catch(error => {
        console.error('Error al cargar los detalles:', error);
    });



     

    </script>
</body>
</html>