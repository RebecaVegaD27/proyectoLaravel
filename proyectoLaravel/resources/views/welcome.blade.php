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
            <input type="text" placeholder="Buscar Cliente..." onkeyup="buscarPorCliente()">
            <input type="date" placeholder="Buscar por Fecha" onchange="buscarPorFecha()">
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Periodo</th> <!-- Nueva columna para el Periodo -->
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

    const url = `/generar-pdf?${new URLSearchParams({
        cliente: cliente,
        id: index,  // Asegúrate de incluir el ID si lo necesitas
        destinatario: group.destinatario || '', // Valida si 'destinatario' existe
        fecha_reporte: group.fecha_reporte || '', // Valida si 'fecha_reporte' existe
        fecha_novedad: asegurarArray(group.fecha_novedad).join(','),
        desc_codigo: asegurarArray(group.desc_codigo).join(','),
        desc_localidad: [...new Set(asegurarArray(group.desc_localidad))].join(','),
        desc_puesto: asegurarArray(group.desc_puesto).join(','),
        desc_agente: asegurarArray(group.desc_agente).join(','),
        desc_tipo_novedad: asegurarArray(group.desc_tipo_novedad).join(','),
        desc_tipo_hallazgo: asegurarArray(group.desc_tipo_hallazgo).join(','),
        desc_tipo_incidente: asegurarArray(group.desc_tipo_incidente).join(','),
        desc_tipo_act_puesto: asegurarArray(group.desc_tipo_act_puesto).join(','),
        desc_tipo_novedad_protemaxi: asegurarArray(group.desc_tipo_novedad_protemaxi).join(','),
        desc_titulo: asegurarArray(group.desc_titulo).join(','),
        desc_detalle: asegurarArray(group.desc_detalle).join(','),
        desc_persona_involucrada: asegurarArray(group.desc_persona_involucrada).join(','),
        desc_lugar_involucrado: asegurarArray(group.desc_lugar_involucrado).join(','),
        desc_comentario: asegurarArray(group.desc_comentario).join(','),
        desc_nombre_central: asegurarArray(group.desc_nombre_central).join(','),
        fecha_envio_novedad: asegurarArray(group.fecha_envio_novedad).join(','),
        desc_estado_novedad: asegurarArray(group.desc_estado_novedad).join(','),
        desc_estado_aprobacion: asegurarArray(group.desc_estado_aprobacion).join(','),
        cobertura_servicio: asegurarArray(group.cobertura_servicio).join(','),
        ronda_vigilancia: asegurarArray(group.ronda_vigilancia).join(','),
        control_acceso: asegurarArray(group.control_acceso).join(','),
        reporte_custodia: asegurarArray(group.reporte_custodia).join(','),
        incidencia_seguridad: asegurarArray(group.incidencia_seguridad).join(','),
        novedades_reportadas: asegurarArray(group.novedades_reportadas).join(','),
        cambio_nomina_personal: asegurarArray(group.cambio_nomina_personal).join(','),
        acciones_correctivas: asegurarArray(group.acciones_correctivas).join(','),
        valores_agregados: asegurarArray(group.valores_agregados).join(','),
        conclusion_recomendaciones: asegurarArray(group.conclusion_recomendaciones).join(','),
        recomendaciones: recomendacionesJSON || '' // Verifica si `recomendacionesJSON` está definido
    }).toString()}`;

    // Redirigir al usuario para generar el PDF
    window.location.href = url;
}

                 

        function handleButtonClick(index, cliente, groupJSON, event) {
            // Llamar a la función con los parámetros correctos
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

                if (data.success) {
                    const fechaCell = event.target.closest('tr').querySelector('td:nth-child(3)');
                    fechaCell.textContent = fechaActual;
                    group.fecha_reporte = fechaActual;

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

        // Fetch para cargar los detalles de los datos
        fetch('/detalles')
            .then(response => response.json())
            .then(data => {
                const groupedData = {};

                // Agrupar los datos
                data.forEach(detalle => {
                    const periodo = obtenerNombreMesYAnio(detalle.fecha_novedad);

                    const key = `${detalle.desc_cliente}-${periodo}-${detalle.fecha_reporte}`;

                    if (!groupedData[key]) {
                        groupedData[key] = {
                            desc_cliente: detalle.desc_cliente,
                            periodo: periodo,
                            fecha_reporte: detalle.fecha_reporte,
                            fecha_novedad: [],
                            // Otros campos...
                        };
                    }

                    // Agregar los valores a los arrays correspondientes
                    Object.keys(groupedData[key]).forEach(field => {
                        if (Array.isArray(groupedData[key][field]) && detalle[field] !== undefined) {
                            groupedData[key][field].push(detalle[field]);
                        }
                    });
                });

                // Llenar la tabla
                const detallesTable = document.getElementById('detallesTable');
                let index = 1;

                Object.keys(groupedData).forEach(key => {
                    const group = groupedData[key];
                    const groupJSON = JSON.stringify(group)
                        .replace(/'/g, "\\'")  
                        .replace(/"/g, '&quot;'); 

                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${index++}</td>
                        <td>${group.desc_cliente}</td>
                        <td>${group.periodo}</td>
                        <td>${group.fecha_reporte}</td>
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
