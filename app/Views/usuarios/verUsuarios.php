<!DOCTYPE html> 
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios | Sistema de Gestión</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    
    <link rel="stylesheet" href="../public/css/verUsuarios.css">
    
    <style>
        /* Estilos específicos para DataTables */
        .dataTables_wrapper {
            font-family: 'Montserrat', sans-serif;
        }
        
        .dataTables_length select,
        .dataTables_filter input {
            padding: 8px 12px;
            border: 2px solid #e1d5d8;
            border-radius: 8px;
            font-family: 'Montserrat', sans-serif;
            margin: 0 5px;
        }
        
        .dataTables_filter input:focus {
            outline: none;
            border-color: var(--vino-medio);
        }
        
        .dataTables_paginate .paginate_button {
            padding: 6px 12px;
            margin: 0 3px;
            border-radius: 6px;
        }
        
        .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, var(--vino-medio) 0%, var(--vino-oscuro) 100%);
            color: white !important;
            border: none;
        }
        
        .dataTables_paginate .paginate_button:hover {
            background: var(--vino-palido);
            border-color: var(--vino-medio);
        }
        
        /* Badges para la tabla */
        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-align: center;
            white-space: nowrap;
        }
        
        .badge-success {
            background-color: #28a745;
            color: white;
        }
        
        .badge-danger {
            background-color: #dc3545;
            color: white;
        }
        
        .badge-admin {
            background: linear-gradient(135deg, var(--vino-oscuro) 0%, var(--vino-medio) 100%);
            color: white;
        }
        
        .badge-proveedor {
            background: linear-gradient(135deg, var(--oro-oscuro) 0%, var(--oro) 100%);
            color: var(--texto-oscuro);
        }
        
        .badge-usuario {
            background-color: #6c757d;
            color: white;
        }
        
        /* Botones de acción */
        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
        }
        
        .btn-icon {
            padding: 6px 12px;
            font-size: 0.8rem;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .btn-view {
            background-color: var(--vino-medio);
            color: white;
        }
        
        .btn-view:hover {
            background-color: var(--vino-oscuro);
        }
        
        .btn-edit {
            background-color: #ffc107;
            color: var(--texto-oscuro);
        }
        
        .btn-edit:hover {
            background-color: #e0a800;
        }
        
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        
        .btn-delete:hover {
            background-color: #c82333;
        }
        
        /* Estadísticas */
        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            box-shadow: 0 2px 8px var(--sombra-suave);
            border: 1px solid var(--vino-palido);
        }
        
        .stat-item {
            flex: 1;
            min-width: 120px;
            text-align: center;
            padding: 15px;
            background: linear-gradient(135deg, var(--vino-palido) 0%, #fff 100%);
            border-radius: 12px;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--vino-oscuro);
            font-family: 'Playfair Display', serif;
        }
        
        .stat-label {
            font-size: 0.85rem;
            color: var(--texto-medio);
            margin-top: 8px;
        }
        
        /* Botón de exportar */
        .dt-buttons {
            margin-bottom: 15px;
        }
        
        .dt-button {
            padding: 8px 16px;
            margin-right: 8px;
            background: var(--vino-medio);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        
        .dt-button:hover {
            background: var(--vino-oscuro);
        }
    </style>
</head>

<body>
    <div class="portal-container">
        <header class="portal-header">
            <div class="portal-title">SISTEMA DE GESTIÓN</div>
        </header>

        <nav class="portal-nav">
            <div class="breadcrumb">
                <a href="<?= site_url('/') ?>">Inicio</a>
                <span class="breadcrumb-separator">/</span>
                <a href="<?= '../portalProcesos/procesos' ?>">Portal procesos</a>
                <span class="breadcrumb-separator">/</span>
                <span>Usuarios</span>
            </div>
            <a href="../usuarios/crearUsuarios" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Nuevo Usuario
            </a>
        </nav>

        <main class="portal-content">
            <div class="content-container" style="max-width: 1300px;">
                <div class="form-card">
                    <div class="form-header">
                        <h2><i class="fas fa-users"></i> Lista de Usuarios</h2>
                    </div>
                    <div class="form-body">
                        <!-- Estadísticas -->
                        <div class="stats-card">
                            <div class="stat-item">
                                <div class="stat-number" id="totalUsuarios">0</div>
                                <div class="stat-label">Total Usuarios</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number" id="usuariosActivos">0</div>
                                <div class="stat-label">Usuarios Activos</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number" id="usuariosInactivos">0</div>
                                <div class="stat-label">Usuarios Inactivos</div>
                            </div>
                        </div>

                        <!-- Tabla de usuarios con DataTables -->
                        <div class="table-container">
                            <table id="tablaUsuarios" class="display responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre Completo</th>
                                        <th>Correo Electrónico</th>
                                        <th>Rol</th>
                                        <th>Teléfono</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaUsuariosBody">
                                    <!-- Los datos se cargarán vía AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="portal-footer">
            <p>Sistema de Gestión de Procesos & copy; <?= date('Y') ?> - Todos los derechos reservados</p>
            <p><a href="http://www.temascalcingo.gob.mx" class="footer-link">www.temascalcingo.gob.mx</a></p>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    
    <script src="<?= base_url('../public/js/verUsuarios.js') ?>"></script>
</body>

</html>