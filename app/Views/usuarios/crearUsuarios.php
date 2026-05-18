<!DOCTYPE html> 
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../public/css/styles.css">
    <style>
        .disabled-section {
            opacity: 0.6;
            pointer-events: none;
            position: relative;
        }
        
        .disabled-section::after {
            content: "⚠️ No aplica para este rol";
            position: absolute;
            top: 10px;
            right: 10px;
            background: #f8d7da;
            color: #721c24;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
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
                <a href="<?= site_url('usuarios') ?>">Usuarios</a>
                <span class="breadcrumb-separator">/</span>
                <span>Crear Usuario</span>
            </div>
            <a href="<?= '../portalProcesos/procesos' ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </nav>

        <main class="portal-content">
            <div class="content-container">
                <div class="form-card">
                    <div class="form-header">
                        <h2>Crear Nuevo Usuario</h2>
                    </div>

                    <div class="form-body">
                        <div class="info-message" id="infoMessage">
                            <i class="fas fa-info-circle"></i> Selecciona un rol para mostrar los campos correspondientes
                        </div>

                        <form method="POST" id="form-usuario">
                            <h3 style="color: var(--vino-oscuro); margin-bottom: 20px;">Selecciona primeramente el tipo de Rol</h3>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="id_rol">Rol <span class="required">*</span></label>
                                    <select class="form-control" id="id_rol" name="id_rol" required>
                                        <option value="">SELECCIONA UNA OPCION...</option>
                                        <option value="1">ADMINISTRADOR</option>
                                        <option value="2">USUARIO</option>
                                        <option value="3">PROVEEDOR</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Sección: Datos Personales (SIEMPRE VISIBLE pero con campos condicionales) -->
                            <div id="seccion-datos-personales" class="form-section">
                                <h3 style="color: var(--vino-oscuro);">Datos Personales</h3>
                                <div class="form-row">
                                    <div class="form-group" id="campo-nombre">
                                        <label for="nombre">Nombre <span class="required">*</span></label>
                                        <input type="text" class="form-control" id="nombre" name="nombre"
                                            value="<?= old('nombre') ?>" placeholder="Ingrese el nombre">
                                    </div>

                                    <div class="form-group" id="campo-apellidoP">
                                        <label for="apellidoP">Apellido Paterno <span class="required" id="req-apellidoP">*</span></label>
                                        <input type="text" class="form-control" id="apellidoP" name="apellidoP"
                                            value="<?= old('apellidoP') ?>" placeholder="Ingrese el apellido paterno">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group" id="campo-apellidoM">
                                        <label for="apellidoM">Apellido Materno</label>
                                        <input type="text" class="form-control" id="apellidoM" name="apellidoM"
                                            value="<?= old('apellidoM') ?>" placeholder="Ingrese el apellido materno (opcional)">
                                    </div>

                                    <div class="form-group">
                                        <label for="correo">Correo Electrónico <span class="required">*</span></label>
                                        <input type="email" class="form-control" id="correo" name="correo"
                                            value="<?= old('correo') ?>" placeholder="ejemplo@correo.com">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="password">Contraseña <span class="required">*</span></label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Mínimo 6 caracteres">
                                    </div>

                                    <div class="form-group">
                                        <label for="confirm_password">Confirmar Contraseña <span class="required">*</span></label>
                                        <input type="password" class="form-control" id="confirm_password"
                                            name="confirm_password" placeholder="Repita la contraseña">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        <div class="checkbox-group">
                                            <input type="checkbox" id="active" name="active" value="1"
                                                <?= old('active') ? 'checked' : '' ?>>
                                            <label for="active">Usuario activo</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección: Datos Fiscales (CONDICIONAL) -->
                            <div id="seccion-datos-fiscales" class="form-section">
                                <h3 style="color: var(--vino-oscuro);">Datos Fiscales</h3>
                                
                                <!-- Campos para ADMINISTRADOR y PROVEEDOR (compartidos) -->
                                <div class="form-row">
                                    <div class="form-group" id="campo-rfc">
                                        <label for="rfc">RFC</label>
                                        <input type="text" class="form-control" id="rfc" name="rfc"
                                            value="<?= old('rfc') ?>" placeholder="Ej: XAXX010101000" maxlength="13">
                                    </div>

                                    <div class="form-group" id="campo-telefono-principal">
                                        <label for="telefono_principal">Teléfono Principal</label>
                                        <input type="tel" class="form-control" id="telefono_principal" name="telefono_principal"
                                            value="<?= old('telefono_principal') ?>" placeholder="Ej: 7221234567">
                                    </div>
                                </div>

                                <!-- Campos exclusivos para PROVEEDOR -->
                                <div id="campos-proveedor">
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="curp">CURP</label>
                                            <input type="text" class="form-control" id="curp" name="curp"
                                                value="<?= old('curp') ?>" placeholder="Ej: XAXX010101HXXX" maxlength="18">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="nombre_razon_social">Nombre o Razón Social</label>
                                        <input type="text" class="form-control" id="nombre_razon_social"
                                            name="nombre_razon_social" value="<?= old('nombre_razon_social') ?>"
                                            placeholder="Nombre comercial o razón social">
                                    </div>

                                    <div class="form-group">
                                        <label for="tipo_persona">Tipo de Persona</label>
                                        <select class="form-control" id="tipo_persona" name="tipo_persona">
                                            <option value="">Seleccionar tipo</option>
                                            <option value="1">FISICA</option>
                                            <option value="2">MORAL</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección: Dirección (CONDICIONAL para ADMINISTRADOR y PROVEEDOR) -->
                            <div id="seccion-direccion" class="form-section">
                                <h3 style="color: var(--vino-oscuro);">Dirección</h3>

                                <div class="form-group">
                                    <label for="calle_numero">Calle y Número</label>
                                    <input type="text" class="form-control" id="calle_numero" name="calle_numero"
                                     placeholder="Calle, número exterior, número interior">
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="colonia">Colonia</label>
                                        <input type="text" class="form-control" id="colonia" name="colonia"
                                             placeholder="Colonia">
                                    </div>

                                    <div class="form-group">
                                        <label for="ciudad">Ciudad</label>
                                        <input type="text" class="form-control" id="ciudad" name="ciudad"
                                            placeholder="Ciudad">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="estado">Estado</label>
                                        <input type="text" class="form-control" id="estado" name="estado"
                                            placeholder="Estado">
                                    </div>

                                    <div class="form-group">
                                        <label for="codigo_postal">Código Postal</label>
                                        <input type="text" class="form-control" id="codigo_postal" name="codigo_postal"
                                            placeholder="C.P." maxlength="5">
                                    </div>
                                </div>

                        

                                <div class="form-group">
                                    <label for="pais">País</label>
                                    <input type="text" class="form-control" id="pais" name="pais" 
                                        placeholder="País">
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary" id="btnGuardar">
                                    <i class="fas fa-save"></i> Guardar Usuario
                                </button>
                                <a href="<?= '../portalProcesos/procesos' ?>" class="btn btn-secondary">
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

    <script src="../public/js/CrearUsuario.js"></script>
    <script>
        // Funciones de validación de campos
        document.getElementById('confirm_password').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirm = this.value;
            if (password && confirm) {
                this.style.borderColor = password !== confirm ? '#dc3545' : '#28a745';
            }
        });

        document.getElementById('rfc').addEventListener('input', function() {
            let rfc = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
            if (rfc.length > 13) rfc = rfc.slice(0, 13);
            this.value = rfc;
        });

        document.getElementById('curp').addEventListener('input', function() {
            let curp = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
            if (curp.length > 18) curp = curp.slice(0, 18);
            this.value = curp;
        });

        document.getElementById('telefono_principal').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>

</html>