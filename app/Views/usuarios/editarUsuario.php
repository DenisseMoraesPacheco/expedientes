<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario | Sistema de Gestión</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('../../public/css/editarUsuario.css') ?>">
    <style>
        
        .form-section {
            transition: all 0.3s ease;
            margin-bottom: 30px;
            padding: 20px;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            position: relative;
        }
        .form-section h3 {
            margin-top: 0;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--vino-palido);
        }
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }
        .form-group {
            flex: 1;
            min-width: 200px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: var(--texto-oscuro);
        }
        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: 'Montserrat', sans-serif;
            transition: border-color 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--vino-medio);
            box-shadow: 0 0 0 2px rgba(128, 0, 32, 0.1);
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 8px;
        }
        .checkbox-group input {
            width: 18px;
            height: 18px;
        }
        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--vino-palido);
        }
        .btn {
            padding: 10px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Montserrat', sans-serif;
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
            box-shadow: 0 4px 12px rgba(128, 0, 32, 0.3);
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        .required {
            color: red;
        }
        .info-message {
            background: #e7f3ff;
            border-left: 4px solid var(--vino-medio);
            padding: 12px 16px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 14px;
            color: var(--texto-medio);
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
                <a href="<?= site_url('usuarios/listar') ?>">Usuarios</a>
                <span class="breadcrumb-separator">/</span>
                <span>Editar Usuario</span>
            </div>
            <a href="<?= site_url('usuarios/listar') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </nav>

        <main class="portal-content">
            <div class="content-container">
                <div class="form-card">
                    <div class="form-header">
                        <h2>Editar Usuario: <?= esc($usuario['nombre'] . ' ' . $usuario['apellidoP']) ?></h2>
                    </div>

                    <div class="form-body">
                        <div class="info-message" id="infoMessage">
                            <i class="fas fa-info-circle"></i> Rol actual: <strong><?= esc($usuario['nombre_rol']) ?></strong>
                        </div>

                        <form method="POST" id="form-usuario" action="<?= site_url('usuarios/actualizar/' . $usuario['id_usuario']) ?>">
                            <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario'] ?>">
                            
                            <!-- Selección de Rol -->
                            <div class="form-section">
                                <h3>Rol del Usuario</h3>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="id_rol">Rol <span class="required">*</span></label>
                                        <select class="form-control" id="id_rol" name="id_rol" required>
                                            <option value="1" <?= $usuario['id_rol'] == 1 ? 'selected' : '' ?>>ADMINISTRADOR</option>
                                            <option value="2" <?= $usuario['id_rol'] == 2 ? 'selected' : '' ?>>USUARIO</option>
                                            <option value="3" <?= $usuario['id_rol'] == 3 ? 'selected' : '' ?>>PROVEEDOR</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Datos Personales -->
                            <div id="seccion-datos-personales" class="form-section">
                                <h3>Datos Personales</h3>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="nombre">Nombre <span class="required">*</span></label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" 
                                               value="<?= esc($usuario['nombre']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="apellidoP">Apellido Paterno <span class="required">*</span></label>
                                        <input type="text" class="form-control" id="apellidoP" name="apellidoP" 
                                               value="<?= esc($usuario['apellidoP']) ?>" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="apellidoM">Apellido Materno</label>
                                        <input type="text" class="form-control" id="apellidoM" name="apellidoM" 
                                               value="<?= esc($usuario['apellidoM']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="correo">Correo Electrónico <span class="required">*</span></label>
                                        <input type="email" class="form-control" id="correo" name="correo" 
                                               value="<?= esc($usuario['correo']) ?>" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        <div class="checkbox-group">
                                            <input type="checkbox" id="active" name="active" value="1" 
                                                   <?= $usuario['active'] == 1 ? 'checked' : '' ?>>
                                            <label for="active">Usuario activo</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Datos Fiscales (visible para ADMIN y PROVEEDOR) -->
                            <div id="seccion-datos-fiscales" class="form-section">
                                <h3>Datos Fiscales</h3>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="rfc">RFC</label>
                                        <input type="text" class="form-control" id="rfc" name="rfc" 
                                               value="<?= esc($usuario['rfc']) ?>" maxlength="13">
                                    </div>
                                    <div class="form-group">
                                        <label for="telefono_principal">Teléfono Principal</label>
                                        <input type="tel" class="form-control" id="telefono_principal" name="telefono_principal" 
                                               value="<?= esc($usuario['telefono_principal']) ?>">
                                    </div>
                                </div>

                                <!-- Campos exclusivos para PROVEEDOR -->
                                <div id="campos-proveedor">
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="curp">CURP</label>
                                            <input type="text" class="form-control" id="curp" name="curp" 
                                                   value="<?= esc($usuario['curp']) ?>" maxlength="18">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre_razon_social">Nombre o Razón Social</label>
                                        <input type="text" class="form-control" id="nombre_razon_social" name="nombre_razon_social" 
                                               value="<?= esc($usuario['nombre_razon_social']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="tipo_persona">Tipo de Persona</label>
                                        <select class="form-control" id="tipo_persona" name="tipo_persona">
                                            <option value="">Seleccionar tipo</option>
                                            <option value="1" <?= $usuario['tipo_persona'] == 1 ? 'selected' : '' ?>>FISICA</option>
                                            <option value="2" <?= $usuario['tipo_persona'] == 2 ? 'selected' : '' ?>>MORAL</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Dirección (visible para ADMIN y PROVEEDOR) -->
                            <div id="seccion-direccion" class="form-section">
                                <h3>Dirección</h3>
                                <div class="form-group">
                                    <label for="calle_numero">Calle y Número</label>
                                    <input type="text" class="form-control" id="calle_numero" name="calle_numero" 
                                           value="<?= esc($usuario['calle_numero']) ?>">
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="colonia">Colonia</label>
                                        <input type="text" class="form-control" id="colonia" name="colonia" 
                                               value="<?= esc($usuario['colonia']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="ciudad">Ciudad</label>
                                        <input type="text" class="form-control" id="ciudad" name="ciudad" 
                                               value="<?= esc($usuario['ciudad']) ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="estado">Estado</label>
                                        <input type="text" class="form-control" id="estado" name="estado" 
                                               value="<?= esc($usuario['estado']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="codigo_postal">Código Postal</label>
                                        <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" 
                                               value="<?= esc($usuario['codigo_postal']) ?>" maxlength="5">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pais">País</label>
                                    <input type="text" class="form-control" id="pais" name="pais" 
                                           value="<?= esc($usuario['pais']) ?>">
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary" id="btnGuardar">
                                    <i class="fas fa-save"></i> Actualizar Usuario
                                </button>
                                <a href="<?= site_url('/usuarios/listar') ?>" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <footer class="portal-footer">
            <p>Sistema de Gestión de Procesos &copy; <?= date('Y') ?> - Todos los derechos reservados</p>
            <p><a href="http://www.temascalcingo.gob.mx" class="footer-link">www.temascalcingo.gob.mx</a></p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../public/js/EditarUsuario.js">    </script>
</body>
</html>