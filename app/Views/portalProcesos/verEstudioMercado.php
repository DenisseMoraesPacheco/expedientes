<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudio de Mercado</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">



    <style>
        :root {
            --vino-oscuro: #4a0b1c;
            --vino-medio: #8b1a3a;
            --vino-palido: #d4a0b0;
            --fondo: #f8f9fa;
            --texto: #2c2c2c;
            --gris: #e5e5e5;
            --success: #198754;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--fondo);
            color: var(--texto);
        }

        .container {
            max-width: 1300px;
            margin: auto;
            padding: 30px;
        }

        .header {
            background: linear-gradient(135deg, var(--vino-oscuro), var(--vino-medio));
            color: white;
            padding: 35px;
            border-radius: 18px;
            margin-bottom: 30px;
            text-align: center;
        }

        .header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
        }

        .card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .05);
            margin-bottom: 30px;
        }

        h2 {
            color: var(--vino-oscuro);
            margin-bottom: 20px;
            font-family: 'Playfair Display', serif;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
        }

        input,
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }

        button {
            border: none;
            cursor: pointer;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--vino-medio), var(--vino-oscuro));
            color: white;
            padding: 12px 22px;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
            padding: 10px 18px;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
            padding: 8px 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background: var(--vino-medio);
            color: white;
            padding: 12px;
            border: 1px solid #ddd;
            font-size: 13px;
        }

        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            background: white;
        }

        .resumen {
            margin-top: 20px;
            width: 350px;
            margin-left: auto;
        }

        .resumen div {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .total {
            font-weight: 700;
            font-size: 18px;
            color: var(--vino-oscuro);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 13px;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 8px;
            text-align: center;
        }

        thead th {
            background: #8b1a3a;
            color: white;
        }

        tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        tbody tr:hover {
            background: #ffeeba;
        }

        td:first-child {
            font-weight: bold;
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="header">
            <h1>Estudio de Mercado</h1>
        </div>

        <nav class="portal-nav" style="margin-bottom: 30px;">
            <div class="breadcrumb">
                <a href="<?= '/' ?>">Inicio</a>
                <span class="breadcrumb-separator">/</span>
                <a href="<?= '../../procesosInternos/procesos' ?>">Portal Procesos</a>
                <span class="breadcrumb-separator">/</span>

                <span>Estudio de Mercado</span>
            </div>
        </nav>
        <!-- DATOS GENERALES -->
        <div class="card">

            <!-- ENCABEZADO SUPERIOR -->
            <table>
                <tr>
                    <td><strong>ÁREA USUARIA / SOLICITANTE</strong></td>
                    <td colspan="10" id="areaTexto"></td>                </tr>
                <tr>
                    <td><strong>FECHA</strong></td>
                    <td colspan="10" id="fechaTexto"></td>
                </tr>
                <tr>
                    <td><strong>PARTIDA PRESUPUESTAL</strong></td>
                   <td colspan="10" id="nombreEstudioTexto"></td>
                </tr>
            </table>

            <!-- TABLA PRINCIPAL -->
            <table id="tablaEstudio">
                <thead>
                    <tr>
                        <th rowspan="3">PARTIDA</th>
                        <th rowspan="3">DESCRIPCIÓN</th>
                        <th rowspan="3">UNIDAD</th>
                        <th rowspan="3">CANTIDAD</th>

                        <th colspan="2">PROVEEDOR 1</th>
                        <th colspan="2">PROVEEDOR 2</th>
                        <th colspan="2">PROVEEDOR 3</th>

                        <th rowspan="3">TOTAL</th>
                    </tr>

                    <tr>
                        <th colspan="2">PRECIOS</th>
                        <th colspan="2">PRECIOS</th>
                        <th colspan="2">PRECIOS</th>
                    </tr>

                    <tr>
                        <th>UNITARIO</th>
                        <th>TOTAL</th>

                        <th>UNITARIO</th>
                        <th>TOTAL</th>

                        <th>UNITARIO</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>

                <tbody id="tbodyEstudio">
                    <!-- JS insertará datos aquí -->
                </tbody>
            </table>
            <!-- RESUMEN -->
          <div class="resumen" id="resumenProveedores"></div>

        </div>


    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script
        src="http://localhost/expedientesGrandes.temascalcingo.gob.mx/public/js/admin/verEstudioMercadoFinalizado.js"></script>


</body>

</html>