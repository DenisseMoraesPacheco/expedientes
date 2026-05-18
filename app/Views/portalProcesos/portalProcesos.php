<!DOCTYPE html> 
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Procesos | Sistema de Gestión</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/portalProcesos.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">

    <style>
        /* Variables de color */
        :root {
            --vino-oscuro: #4a0b1c;
            --vino-medio: #8b1a3a;
            --vino-palido: #d4a0b0;
            --oro: #d4af37;
            --oro-oscuro: #b8960c;
            --texto-oscuro: #2c2c2c;
            --texto-medio: #666666;
            --texto-claro: #999999;
            --fondo-claro: #f8f9fa;
            --verde-exito: #28a745;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--fondo-claro);
            color: var(--texto-oscuro);
        }

        .portal-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header */
        .portal-header {
            text-align: center;
            padding: 40px 20px;
            background: linear-gradient(135deg, var(--vino-oscuro) 0%, var(--vino-medio) 100%);
            border-radius: 20px;
            margin-bottom: 30px;
            color: white;
        }

        .portal-title {
            font-size: 2.5rem;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
            letter-spacing: 2px;
        }

        /* Navegación */
        .portal-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 15px 0;
            border-bottom: 2px solid var(--vino-palido);
        }

        .breadcrumb {
            font-size: 0.9rem;
            color: var(--texto-medio);
        }

        .breadcrumb a {
            color: var(--vino-medio);
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .breadcrumb-separator {
            margin: 0 8px;
        }

        /* Botones */
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--vino-medio) 0%, var(--vino-oscuro) 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(74, 11, 28, 0.3);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        /* Grid de tarjetas */
        .procesos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }

        /* Tarjeta de proceso */
        .proceso-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid var(--vino-palido);
        }

        .proceso-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .card-header {
            padding: 25px 20px;
            border-bottom: 2px solid var(--vino-palido);
            text-align: center;
        }

        .card-header h3 {
            font-size: 1.3rem;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
            color: var(--vino-oscuro);
            margin-bottom: 10px;
        }

        .card-clave {
            display: inline-block;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 20px;
            margin-top: 5px;
        }

        .card-clave.ad {
            background: linear-gradient(135deg, var(--vino-oscuro) 0%, var(--vino-medio) 100%);
            color: white;
        }

        .card-clave.lp {
            background: linear-gradient(135deg, var(--oro-oscuro) 0%, var(--oro) 100%);
            color: var(--texto-oscuro);
        }

        .card-clave.ir {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
        }

        .card-body {
            padding: 20px;
            text-align: center;
        }

        .proceso-descripcion {
            color: var(--texto-medio);
            font-size: 0.9rem;
            line-height: 1.5;
            min-height: 60px;
            margin-bottom: 20px;
        }

        .card-actions {
            margin-top: 20px;
        }

        .btn-ver {
            background-color: var(--vino-medio);
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-ver:hover {
            background-color: var(--vino-oscuro);
        }

        /* Footer */
        .portal-footer {
            text-align: center;
            padding: 30px;
            margin-top: 50px;
            border-top: 1px solid var(--vino-palido);
            color: var(--texto-medio);
            font-size: 0.8rem;
        }

        .footer-link {
            color: var(--vino-medio);
            text-decoration: none;
        }

        .footer-link:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .procesos-grid {
                grid-template-columns: 1fr;
            }
            
            .portal-title {
                font-size: 1.8rem;
            }
            
            .portal-nav {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>

<body class="w3-light-grey">
    <!-- TOP -->
<div class="w3-bar w3-top w3-large"
    style="background-color:#800020; color:white; z-index:4">

    <button class="w3-bar-item w3-button w3-hide-large"
        onclick="w3_open();">

        <i class="fa fa-bars"></i> Menu
    </button>

    <span class="w3-bar-item w3-right">
        Sistema
    </span>
</div>

<!-- SIDEBAR -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left"
    style="
        z-index:3;
        width:300px;
        position:fixed;
        top:60px;
        left:0;
        height:100%;
        overflow:auto;
    "
    id="mySidebar">

    <br>

    <div class="w3-container w3-row">

        <div class="w3-col s4">
            <img src="https://www.w3schools.com/w3images/avatar2.png"
                class="w3-circle w3-margin-right"
                style="width:46px">
        </div>

        <div class="w3-col s8 w3-bar">
            <span>PORTAL PROCESOS PORTAL</span><br>

            <a href="#" class="w3-bar-item w3-button">
                <i class="fa fa-book"></i>
            </a>
        </div>
    </div>

    <hr>

       <div class="w3-bar-block">

            <a href="../portalProcesos/procesos" class="w3-bar-item w3-button w3-padding w3-blue">
                <i class="fa fa-address-card fa-fw"></i>
                Portal de Procesos
            </a>
            <a href="../procesosInternos/crearProceso" class="w3-bar-item w3-button w3-padding w3-blue">
                <i class="fa fa-address-card fa-fw"></i>
                crear Proceso
            </a>
            <a href="#" class="w3-bar-item w3-button w3-padding w3-blue">
                <i class="fa fa-address-card fa-fw"></i>
                Listado Proveedores
            </a>

            <a href="#" class="w3-bar-item w3-button w3-padding">
                <i class="fa fa-book fa-fw"></i>
                Catalogo de productos
            </a>

            <a href="#" class="w3-bar-item w3-button w3-padding">
                <i class="fa fa-cog fa-fw"></i>
                Configuración
            </a>

        </div>
</nav>

<!-- OVERLAY -->
<div class="w3-overlay w3-hide-large w3-animate-opacity"
    onclick="w3_close()"
    style="cursor:pointer"
    title="close side menu"
    id="myOverlay">
</div>

    <div class="portal-container"
    style="margin-left:300px; margin-top:80px;">
        <header class="portal-header">
            <div class="portal-title">SISTEMA DE GESTIÓN</div>
        </header>

        <nav class="portal-nav">
            <div class="breadcrumb">
                <a href="<?= '/' ?>">Inicio</a>
                <span class="breadcrumb-separator">/</span>
                <a href="<?='../usuarios/crearUsuarios' ?>">crearUsuarios</a>
                <span class="breadcrumb-separator">/</span>
                <span>Portal de Procesos</span>
            </div>
            <a href="<?= '../usuarios/crearUsuarios' ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </nav>

        <main class="portal-content">
            <div class="content-container">
                <div class="form-card">
                    <div class="form-header">
                        <h2><i class="fas fa-tasks"></i> Lista de Procesos</h2>
                    </div>
                    <div class="form-body">
                        <div id="contenedorTarjetas">
                            <!-- Tarjetas est�ticas como en la imagen -->
                            <div class="procesos-grid">
                                <!-- ADJUDICACIÓN DIRECTA -->
                            

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="portal-footer">
            <p>Sistema de Gestión de Procesos &copy; <?= date('Y') ?> - Todos los derechos reservados</p>
            <p><a href="http://www.temascalcingo.gob.mx" class="footer-link">www.temascalcingo.gob.mx</a></p>
        </footer>
    </div>

    <script src="../public/js/procesosInternos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</body>

</html>