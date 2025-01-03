<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            background-color: #FF6347;
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
            background-color: #FF6347;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }
    </style>
    <script>


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
                const tdFecha = tr[i].getElementsByTagName('td')[2];
                if (tdFecha) {
                    const fechaValue = tdFecha.textContent || tdFecha.innerText;
                    tr[i].style.display = fechaValue === fechaSeleccionada || fechaSeleccionada === "" ? "" : "none";
                }
            }
        }


    </script>
</head>
<body>
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
                        <th>Fecha de Reporte</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                <tbody id="detallesTable">
            <!-- Aquí se cargarán los datos con JavaScript -->
     
                </tbody>
                <script>
            var recomendaciones;

            fetch('/recomendaciones')
            .then(response => response.json())  // Convertir la respuesta en formato JSON
            .then(data => {
                console.log("recomendaciones", data);
                recomendaciones= data;
                })
            .catch(error => {
                console.error('Error al cargar los detalles:', error);
            });
            fetch('/detalles')
            .then(response => response.json())  // Convertir la respuesta en formato JSON
            .then(data => {
            console.log(data);

        // Agrupar los datos por 'desc_cliente' y 'fecha_reporte'
        const groupedData = {};

        // Agrupar los detalles por cliente y fecha de reporte
        data.forEach(detalle => {
            const key = `${detalle.desc_cliente}-${detalle.fecha_reporte}-${detalle.destinatario}`;

            // Si no existe la clave, la creamos
            if (!groupedData[key]) {
                groupedData[key] = {
                    desc_cliente: detalle.desc_cliente,
                    fecha_reporte: detalle.fecha_reporte,
                    destinatario: detalle.destinatario,
                    fecha_novedad: [],
                    desc_codigo: [],
                    desc_localidad: [],
                    desc_puesto: [],
                    desc_agente: [],
                    desc_tipo_novedad: [],
                    desc_tipo_hallazgo: [],
                    desc_tipo_incidente: [],
                    desc_tipo_act_puesto: [],
                    desc_tipo_novedad_protemaxi: [],
                    desc_titulo: [],
                    desc_detalle: [],
                    desc_persona_involucrada: [],
                    desc_lugar_involucrado: [],
                    desc_comentario: [],
                    desc_nombre_central: [],
                    fecha_envio_novedad: [],
                    desc_estado_novedad: [],
                    desc_estado_aprobacion: [],
                    cobertura_servicio: [],
                    ronda_vigilancia: [],
                    control_acceso: [],
                    reporte_custodia: [],
                    incidencia_seguridad: [],
                    novedades_reportadas: [],
                    cambio_nomina_personal: [],
                    acciones_correctivas: [],
                    valores_agregados: [],
                    conclusion_recomendaciones: []
                };
            }

            // Agregar los valores de cada campo a los arrays correspondientes
            groupedData[key].fecha_novedad.push(detalle.fecha_novedad);
            groupedData[key].desc_codigo.push(detalle.desc_codigo);
            groupedData[key].desc_localidad.push(detalle.desc_localidad);
            groupedData[key].desc_puesto.push(detalle.desc_puesto);
            groupedData[key].desc_agente.push(detalle.desc_agente);
            groupedData[key].desc_tipo_novedad.push(detalle.desc_tipo_novedad);
            groupedData[key].desc_tipo_hallazgo.push(detalle.desc_tipo_hallazgo);
            groupedData[key].desc_tipo_incidente.push(detalle.desc_tipo_incidente);
            groupedData[key].desc_tipo_act_puesto.push(detalle.desc_tipo_act_puesto);
            groupedData[key].desc_tipo_novedad_protemaxi.push(detalle.desc_tipo_novedad_protemaxi);
            groupedData[key].desc_titulo.push(detalle.desc_titulo);
            groupedData[key].desc_detalle.push(detalle.desc_detalle);
            groupedData[key].desc_persona_involucrada.push(detalle.desc_persona_involucrada);
            groupedData[key].desc_lugar_involucrado.push(detalle.desc_lugar_involucrado);
            groupedData[key].desc_comentario.push(detalle.desc_comentario);
            groupedData[key].desc_nombre_central.push(detalle.desc_nombre_central);
            groupedData[key].fecha_envio_novedad.push(detalle.fecha_envio_novedad);
            groupedData[key].desc_estado_novedad.push(detalle.desc_estado_novedad);
            groupedData[key].desc_estado_aprobacion.push(detalle.desc_estado_aprobacion);

            // Agregar los nuevos campos a la agrupación
            groupedData[key].cobertura_servicio.push(detalle.cobertura_servicio);
            groupedData[key].ronda_vigilancia.push(detalle.ronda_vigilancia);
            groupedData[key].control_acceso.push(detalle.control_acceso);
            groupedData[key].reporte_custodia.push(detalle.reporte_custodia);
            groupedData[key].incidencia_seguridad.push(detalle.incidencia_seguridad);
            groupedData[key].novedades_reportadas.push(detalle.novedades_reportadas);
            groupedData[key].cambio_nomina_personal.push(detalle.cambio_nomina_personal);
            groupedData[key].acciones_correctivas.push(detalle.acciones_correctivas);
            groupedData[key].valores_agregados.push(detalle.valores_agregados);
            groupedData[key].conclusion_recomendaciones.push(detalle.conclusion_recomendaciones);

        });

        // Obtener la tabla donde se mostrará la información
        const detallesTable = document.getElementById('detallesTable');
        let index = 1;

        // Iterar sobre los grupos de datos
        Object.keys(groupedData).forEach(groupKey => {
            const group = groupedData[groupKey];
            console.log("group",group)
            console.log("localidad", [[... new Set(group.desc_localidad)].join(',')])

            const clienteRecomendaciones = recomendaciones.filter(recomendacion => recomendacion.cliente === group.desc_cliente);

            // Crear una fila por cada grupo
            const recomendacionesJSON = JSON.stringify(clienteRecomendaciones);
            console.log("json",recomendacionesJSON)

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${index++}</td>
                <td>${group.desc_cliente}</td>
                <td>${group.fecha_reporte}</td>
        
                <td>
                    <a href="/generar-pdf?cliente=${encodeURIComponent(group.desc_cliente)}&id=${encodeURIComponent(index++)}&destinatario=${encodeURIComponent(group.destinatario)}&fecha_reporte=${encodeURIComponent(group.fecha_reporte)}&fecha_novedad=${encodeURIComponent(group.fecha_novedad.join(','))}&desc_codigo=${encodeURIComponent(group.desc_codigo.join(','))}&desc_localidad=${encodeURIComponent([[... new Set(group.desc_localidad)].join(',')])}&desc_puesto=${encodeURIComponent(group.desc_puesto.join(','))}&desc_agente=${encodeURIComponent(group.desc_agente.join(','))}&desc_tipo_novedad=${encodeURIComponent(group.desc_tipo_novedad.join(','))}&desc_tipo_hallazgo=${encodeURIComponent(group.desc_tipo_hallazgo.join(','))}&desc_tipo_incidente=${encodeURIComponent(group.desc_tipo_incidente.join(','))}&desc_tipo_act_puesto=${encodeURIComponent(group.desc_tipo_act_puesto.join(','))}&desc_tipo_novedad_protemaxi=${encodeURIComponent(group.desc_tipo_novedad_protemaxi.join(','))}&desc_titulo=${encodeURIComponent(group.desc_titulo.join(','))}&desc_detalle=${encodeURIComponent(group.desc_detalle.join(','))}&desc_persona_involucrada=${encodeURIComponent(group.desc_persona_involucrada.join(','))}&desc_lugar_involucrado=${encodeURIComponent(group.desc_lugar_involucrado.join(','))}&desc_comentario=${encodeURIComponent(group.desc_comentario.join(','))}&desc_nombre_central=${encodeURIComponent(group.desc_nombre_central.join(','))}&fecha_envio_novedad=${encodeURIComponent(group.fecha_envio_novedad.join(','))}&desc_estado_novedad=${encodeURIComponent(group.desc_estado_novedad.join(','))}&desc_estado_aprobacion=${encodeURIComponent(group.desc_estado_aprobacion.join(','))}&cobertura_servicio=${encodeURIComponent(group.cobertura_servicio.join(','))}&ronda_vigilancia=${encodeURIComponent(group.ronda_vigilancia.join(','))}&control_acceso=${encodeURIComponent(group.control_acceso.join(','))}&reporte_custodia=${encodeURIComponent(group.reporte_custodia.join(','))}&incidencia_seguridad=${encodeURIComponent(group.incidencia_seguridad.join(','))}&novedades_reportadas=${encodeURIComponent(group.novedades_reportadas.join(','))}&cambio_nomina_personal=${encodeURIComponent(group.cambio_nomina_personal.join(','))}&acciones_correctivas=${encodeURIComponent(group.acciones_correctivas.join(','))}&valores_agregados=${encodeURIComponent(group.valores_agregados.join(','))}&conclusion_recomendaciones=${encodeURIComponent(group.conclusion_recomendaciones.join(','))}&recomendaciones=${encodeURIComponent(recomendacionesJSON)}" class="btn-report">
                        &#128190; Generar Reporte
                    </a> 
                </td>
            `;
            detallesTable.appendChild(row);
        });
    })
    .catch(error => {
        console.error('Error al cargar los detalles:', error);
    });



    

       
    </script>
            </table>
        </div>
    </div>
</body>
</html>
