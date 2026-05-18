<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesos Internos | TituloProceso | Sistema de Gestion</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= '../../public/css/procesosInternos.css' ?>">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">

</head>
<body>
    <div class="portal-container">
        <header class="portal-header">
            <div class="portal-title">SISTEMA DE GESTION</div>
        </header>

        <nav class="portal-nav">
            <div class="breadcrumb">
                <a href="<?= '/' ?>">Inicio</a>
                <span class="breadcrumb-separator">/</span>
                <a href="<?= '../../procesosInternos/procesos' ?>">Portal de Procesos</a>
                <span class="breadcrumb-separator">/</span>
                <span></span>
            </div>
           <a href="<?= 'procesosInternos/nuevo' ?>" class="btn btn-success">
    <i class="fas fa-plus"></i> Agregar Nuevo Proceso
</a>
        </nav>

        <main class="portal-content">
            <div class="content-container">
                <div class="form-card">
                    <div class="form-header">
                        <h2><i class="fas fa-folder-open"></i></h2>
                    </div>
                    <div class="form-body">
                        <div class="info-message">
                            <i class="fas fa-info-circle"></i> Gestion de archivos del proceso <strong></strong>
                        </div>

                       
                            <div class="table-container">
                                <table class="tabla-archivos">
                                    <thead>
                                        <tr>
                                            <th>Nombre del Archivo</th>
                                            <th>Tipo</th>
                                            <th>Ultima Modificacion</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary" id="btnGuardar">
                                    <i class="fas fa-save"></i> Guardar Cambios
                                </button>
                                <a href="<?= '../../procesosInternos/procesos' ?>" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="portal-footer">
            <p>Sistema de Gestion de Procesos &copy; <?= date('Y') ?> - Todos los derechos reservados</p>
            <p><a href="http://www.temascalcingo.gob.mx" class="footer-link">www.temascalcingo.gob.mx</a></p>
        </footer>
    </div>
<script>
    const idProceso = <?= $id ?? 'null' ?>;
</script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../public/js/verProcesos.js"></script>
</body>
</html>