<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de Control')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* Estilos para la página */
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .navbar {
            display: flex;
            align-items: center;
            background-color: #FF6347; /* Cambiado a un tono de rojo */
            padding: 1rem;
            color: #fff;
        }
        .navbar .logo {
            display: flex;
            align-items: center;
            margin-right: auto;
        }
        .navbar .logo img {
            height: 40px; /* Ajusta la altura del logo según sea necesario */
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
            border-radius: 4px; /* Bordes redondeados */
            outline: none;
            margin-right: 0.5rem; /* Espacio entre los inputs */
        }
        .search-container button {
            padding: 0.5rem;
            background-color: #FF6347;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
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
            padding: 0.5rem 1rem;
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
            // Obtiene el valor de búsqueda y lo convierte a minúsculas
            const input = document.querySelector('.search-container input[type="text"]');
            const filter = input.value.toLowerCase();
            const table = document.querySelector('table');
            const tr = table.getElementsByTagName('tr');

            // Recorre todas las filas de la tabla y oculta las que no coinciden con la búsqueda
            for (let i = 1; i < tr.length; i++) { // Empieza desde 1 para evitar el encabezado
                const tdCliente = tr[i].getElementsByTagName('td')[1]; // Columna "Cliente"
                if (tdCliente) {
                    const textValue = tdCliente.textContent || tdCliente.innerText;
                    tr[i].style.display = textValue.toLowerCase().includes(filter) ? "" : "none";
                }
            }
        }

        function buscarPorFecha() {
            // Obtiene la fecha seleccionada
            const inputFecha = document.querySelector('.search-container input[type="date"]');
            const fechaSeleccionada = inputFecha.value;
            const table = document.querySelector('table');
            const tr = table.getElementsByTagName('tr');

            // Recorre todas las filas de la tabla y oculta las que no coinciden con la fecha seleccionada
            for (let i = 1; i < tr.length; i++) { // Empieza desde 1 para evitar el encabezado
                const tdFecha = tr[i].getElementsByTagName('td')[2]; // Columna "Fecha de Reporte"
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
            <img src="{{ asset('images/logo.png') }}" alt="Logo"> <!-- Imagen del logo -->
        </div>
    </div>

    <div class="content">
        <h2>Módulo de Reportería</h2>

        <!-- Contenedor de búsqueda debajo de "Reportería" -->
        <div class="search-container">
            <input type="text" placeholder="Buscar Cliente..." onkeyup="buscarPorCliente()">
            <input type="date" placeholder="Buscar por Fecha" onchange="buscarPorFecha()">
            
        </div>

        <!-- Tabla de datos -->
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
                    <!-- Simulando datos de ejemplo -->
                    <tr>
                        <td>1</td>
                        <td>REYSAC S.A</td>
                        <td>2024-11-02</td>
                        <td>
                            <button class="btn-report">
                                &#128190; Generar Reporte
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>PROTEMAXI</td>
                        <td>2024-11-02</td>
                        <td>
                            <button class="btn-report">
                                &#128190; Generar Reporte
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>MOLINOS CHAMPION</td>
                        <td>2024-11-02</td>
                        <td>
                            <button class="btn-report">
                                &#128190; Generar Reporte
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
