// Archivo: js/CrearUsuario.js

/**
 * Configuración de campos por rol
 */
const configuracionRoles = {
    1: { // ADMINISTRADOR
        nombre: 'ADMINISTRADOR',
        camposPersonales: {
            nombre: { required: true, visible: true },
            apellidoP: { required: true, visible: true },
            apellidoM: { required: true, visible: true },
            correo: { required: true, visible: true },
            password: { required: true, visible: true },
            confirm_password: { required: true, visible: true },
            active: { required: true, visible: true }
        },
        datosFiscales: {
            visible: true,
            campos: {
                rfc: { required: false, visible: true },
                telefono_principal: { required: false, visible: true },
                curp: { required: false, visible: false },
                nombre_razon_social: { required: false, visible: false },
                tipo_persona: { required: false, visible: false }
            }
        },
        direccion: {
            visible: true
        }
    },
    2: { // USUARIO
        nombre: 'USUARIO',
        camposPersonales: {
            nombre: { required: true, visible: true },
            apellidoP: { required: true, visible: true },
            apellidoM: { required: true, visible: true },
            correo: { required: true, visible: true },
            password: { required: true, visible: true },
            confirm_password: { required: true, visible: true },
            active: { required: true, visible: true }
        },
        datosFiscales: {
            visible: false,
            campos: {
                rfc: { required: false, visible: false },
                telefono_principal: { required: false, visible: false },
                curp: { required: false, visible: false },
                nombre_razon_social: { required: false, visible: false },
                tipo_persona: { required: false, visible: false }
            }
        },
        direccion: {
            visible: false
        }
    },
    3: { // PROVEEDOR
        nombre: 'PROVEEDOR',
        camposPersonales: {
            nombre: { required: true, visible: true },
            apellidoP: { required: true, visible: true },
            apellidoM: { required: true, visible: true },
            correo: { required: true, visible: true },
            password: { required: true, visible: true },
            confirm_password: { required: true, visible: true },
            active: { required: true, visible: true }
        },
        datosFiscales: {
            visible: true,
            campos: {
                rfc: { required: true, visible: true },
                telefono_principal: { required: true, visible: true },
                curp: { required: true, visible: true },
                nombre_razon_social: { required: true, visible: true },
                tipo_persona: { required: true, visible: true }
            }
        },
        direccion: {
            visible: true
        }
    }
};

/**
 * Función principal para habilitar/deshabilitar campos según el rol seleccionado
 */
function actualizarCamposPorRol() {
    const rolSelect = document.getElementById('id_rol');
    const rolSeleccionado = rolSelect ? parseInt(rolSelect.value) : null;
    
    if (!rolSeleccionado || !configuracionRoles[rolSeleccionado]) {
        // Si no hay rol seleccionado, deshabilitar todo excepto el selector de rol
        deshabilitarTodasSecciones();
        mostrarMensajeInfo('Selecciona un rol para continuar');
        return;
    }
    
    const config = configuracionRoles[rolSeleccionado];
    mostrarMensajeInfo(`Configurando formulario para: ${config.nombre}`);
    
    // 1. Configurar campos de datos personales
    configurarCamposPersonales(config.camposPersonales);
    
    // 2. Configurar sección de datos fiscales
    configurarDatosFiscales(config.datosFiscales);
    
    // 3. Configurar sección de dirección
    configurarDireccion(config.direccion);
    
    // 4. Actualizar mensaje de ayuda
    actualizarMensajeAyuda(rolSeleccionado);
}

/**
 * Configurar campos de datos personales
 */
function configurarCamposPersonales(campos) {
    // Campo Nombre
    const campoNombre = document.getElementById('campo-nombre');
    const inputNombre = document.getElementById('nombre');
    if (campoNombre && inputNombre) {
        if (campos.nombre.visible) {
            campoNombre.style.display = 'block';
            inputNombre.required = campos.nombre.required;
            actualizarRequerido(inputNombre, campos.nombre.required);
        } else {
            campoNombre.style.display = 'none';
            inputNombre.required = false;
        }
    }
    
    // Campo Apellido Paterno
    const campoApellidoP = document.getElementById('campo-apellidoP');
    const inputApellidoP = document.getElementById('apellidoP');
    const reqApellidoP = document.getElementById('req-apellidoP');
    if (campoApellidoP && inputApellidoP) {
        if (campos.apellidoP.visible) {
            campoApellidoP.style.display = 'block';
            inputApellidoP.required = campos.apellidoP.required;
            if (reqApellidoP) {
                reqApellidoP.style.display = campos.apellidoP.required ? 'inline' : 'none';
            }
        } else {
            campoApellidoP.style.display = 'none';
            inputApellidoP.required = false;
            if (reqApellidoP) reqApellidoP.style.display = 'none';
        }
    }
    
    // Campo Apellido Materno
    const campoApellidoM = document.getElementById('campo-apellidoM');
    const inputApellidoM = document.getElementById('apellidoM');
    if (campoApellidoM && inputApellidoM) {
        if (campos.apellidoM.visible) {
            campoApellidoM.style.display = 'block';
            inputApellidoM.required = campos.apellidoM.required;
        } else {
            campoApellidoM.style.display = 'none';
            inputApellidoM.required = false;
        }
    }
    
    // Campo Correo (siempre visible)
    const inputCorreo = document.getElementById('correo');
    if (inputCorreo) {
        inputCorreo.required = campos.correo.required;
        actualizarRequerido(inputCorreo, campos.correo.required);
    }
    
    // Campo Contraseña
    const inputPassword = document.getElementById('password');
    if (inputPassword) {
        inputPassword.required = campos.password.required;
        actualizarRequerido(inputPassword, campos.password.required);
    }
    
    // Campo Confirmar Contraseña
    const inputConfirm = document.getElementById('confirm_password');
    if (inputConfirm) {
        inputConfirm.required = campos.confirm_password.required;
        actualizarRequerido(inputConfirm, campos.confirm_password.required);
    }
}

/**
 * Configurar sección de datos fiscales
 */
function configurarDatosFiscales(config) {
    const seccionFiscales = document.getElementById('seccion-datos-fiscales');
    
    if (!seccionFiscales) return;
    
    if (config.visible) {
        seccionFiscales.style.display = 'block';
        seccionFiscales.classList.remove('disabled-section');
        
        // Configurar cada campo fiscal
        const campos = config.campos;
        
        // Campo RFC
        const campoRfc = document.getElementById('campo-rfc');
        const inputRfc = document.getElementById('rfc');
        if (campoRfc && inputRfc) {
            campoRfc.style.display = campos.rfc.visible ? 'block' : 'none';
            inputRfc.required = campos.rfc.required;
            actualizarRequerido(inputRfc, campos.rfc.required);
        }
        
        // Campo Teléfono Principal
        const campoTelefono = document.getElementById('campo-telefono-principal');
        const inputTelefono = document.getElementById('telefono_principal');
        if (campoTelefono && inputTelefono) {
            campoTelefono.style.display = campos.telefono_principal.visible ? 'block' : 'none';
            inputTelefono.required = campos.telefono_principal.required;
            actualizarRequerido(inputTelefono, campos.telefono_principal.required);
        }
        
        // Campos exclusivos de proveedor
        const camposProveedor = document.getElementById('campos-proveedor');
        if (camposProveedor) {
            const tieneCamposProveedor = campos.curp.visible || 
                                         campos.nombre_razon_social.visible || 
                                         campos.tipo_persona.visible;
            
            if (tieneCamposProveedor) {
                camposProveedor.style.display = 'block';
                
                // CURP
                const inputCurp = document.getElementById('curp');
                if (inputCurp) {
                    inputCurp.required = campos.curp.required;
                    actualizarRequerido(inputCurp, campos.curp.required);
                    inputCurp.parentElement.parentElement.style.display = campos.curp.visible ? 'block' : 'none';
                }
                
                // Nombre o Razón Social
                const inputRazonSocial = document.getElementById('nombre_razon_social');
                if (inputRazonSocial) {
                    inputRazonSocial.required = campos.nombre_razon_social.required;
                    actualizarRequerido(inputRazonSocial, campos.nombre_razon_social.required);
                    inputRazonSocial.parentElement.style.display = campos.nombre_razon_social.visible ? 'block' : 'none';
                }
                
                // Tipo de Persona
                const selectTipoPersona = document.getElementById('tipo_persona');
                if (selectTipoPersona) {
                    selectTipoPersona.required = campos.tipo_persona.required;
                    actualizarRequerido(selectTipoPersona, campos.tipo_persona.required);
                    selectTipoPersona.parentElement.style.display = campos.tipo_persona.visible ? 'block' : 'none';
                }
            } else {
                camposProveedor.style.display = 'none';
            }
        }
    } else {
        seccionFiscales.style.display = 'none';
    }
}

/**
 * Configurar sección de dirección
 */
function configurarDireccion(config) {
    const seccionDireccion = document.getElementById('seccion-direccion');
    
    if (!seccionDireccion) return;
    
    if (config.visible) {
        seccionDireccion.style.display = 'block';
        seccionDireccion.classList.remove('disabled-section');
        
        // Limpiar requeridos de dirección (ninguno es obligatorio en ningún rol)
        const inputsDireccion = seccionDireccion.querySelectorAll('input, select');
        inputsDireccion.forEach(input => {
            input.required = false;
            actualizarRequerido(input, false);
        });
    } else {
        seccionDireccion.style.display = 'none';
    }
}

/**
 * Deshabilitar todas las secciones (estado inicial)
 */
function deshabilitarTodasSecciones() {
    // Sección datos fiscales
    const seccionFiscales = document.getElementById('seccion-datos-fiscales');
    if (seccionFiscales) {
        seccionFiscales.style.display = 'none';
    }
    
    // Sección dirección
    const seccionDireccion = document.getElementById('seccion-direccion');
    if (seccionDireccion) {
        seccionDireccion.style.display = 'none';
    }
    
    // Limpiar requeridos de todos los campos
    const todosLosInputs = document.querySelectorAll('#form-usuario input, #form-usuario select');
    todosLosInputs.forEach(input => {
        if (input.id !== 'id_rol') {
            input.required = false;
        }
    });
}

/**
 * Mostrar mensaje de información
 */
function mostrarMensajeInfo(mensaje) {
    const infoMessage = document.getElementById('infoMessage');
    if (infoMessage) {
        infoMessage.innerHTML = `<i class="fas fa-info-circle"></i> ${mensaje}`;
        infoMessage.style.display = 'block';
    }
}

/**
 * Actualizar mensaje de ayuda según el rol
 */
function actualizarMensajeAyuda(rolId) {
    const ayudaContainer = document.getElementById('infoMessage');
    if (!ayudaContainer) return;
    
    let mensajeAyuda = '';
    switch(rolId) {
        case 1: // ADMINISTRADOR
            mensajeAyuda = '📋 <strong>ADMINISTRADOR:</strong> Campos requeridos: Nombre, Apellidos, Correo, Contraseña. Datos fiscales (RFC y Teléfono) y dirección son opcionales.';
            break;
        case 2: // USUARIO
            mensajeAyuda = '👤 <strong>USUARIO:</strong> Solo necesita: Nombre, Correo y Contraseña. Los campos de apellidos, datos fiscales y dirección no están disponibles.';
            break;
        case 3: // PROVEEDOR
            mensajeAyuda = '🏢 <strong>PROVEEDOR:</strong> Campos requeridos: Nombre completo, Correo, Contraseña, RFC, Teléfono, Razón Social, Tipo de Persona y dirección completa.';
            break;
        default:
            mensajeAyuda = 'ℹ️ Selecciona un rol para mostrar los campos correspondientes';
    }
    
    ayudaContainer.innerHTML = `<i class="fas fa-info-circle"></i> ${mensajeAyuda}`;
}

/**
 * Actualizar indicador visual de campo requerido
 */
function actualizarRequerido(input, esRequerido) {
    if (!input) return;
    
    const label = input.parentElement.querySelector('label');
    if (label) {
        let requiredSpan = label.querySelector('.required');
        
        if (esRequerido) {
            if (!requiredSpan) {
                requiredSpan = document.createElement('span');
                requiredSpan.className = 'required';
                requiredSpan.textContent = ' *';
                label.appendChild(requiredSpan);
            }
        } else {
            if (requiredSpan) {
                requiredSpan.remove();
            }
        }
    }
}

/**
 * Validación antes de enviar el formulario
 */
function validarFormularioPorRol() {
    const rolSelect = document.getElementById('id_rol');
    const rolSeleccionado = parseInt(rolSelect.value);
    const config = configuracionRoles[rolSeleccionado];
    
    if (!config) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Debes seleccionar un rol'
        });
        return false;
    }
    
    // Validar campos requeridos
    const camposRequeridos = [];
    
    // Validar datos personales
    const camposPersonales = config.camposPersonales;
    if (camposPersonales.nombre.visible && camposPersonales.nombre.required) {
        const nombre = document.getElementById('nombre')?.value.trim();
        if (!nombre) camposRequeridos.push('Nombre');
    }
    
    if (camposPersonales.apellidoP.visible && camposPersonales.apellidoP.required) {
        const apellidoP = document.getElementById('apellidoP')?.value.trim();
        if (!apellidoP) camposRequeridos.push('Apellido Paterno');
    }
    
    if (camposPersonales.correo.visible && camposPersonales.correo.required) {
        const correo = document.getElementById('correo')?.value.trim();
        if (!correo) camposRequeridos.push('Correo Electrónico');
    }
    
    if (camposPersonales.password.visible && camposPersonales.password.required) {
        const password = document.getElementById('password')?.value;
        if (!password) camposRequeridos.push('Contraseña');
    }
    
    if (camposPersonales.confirm_password.visible && camposPersonales.confirm_password.required) {
        const confirm = document.getElementById('confirm_password')?.value;
        if (!confirm) camposRequeridos.push('Confirmar Contraseña');
    }
    
    // Validar datos fiscales
    if (config.datosFiscales.visible) {
        const camposFiscales = config.datosFiscales.campos;
        
        if (camposFiscales.rfc.visible && camposFiscales.rfc.required) {
            const rfc = document.getElementById('rfc')?.value.trim();
            if (!rfc) camposRequeridos.push('RFC');
        }
        
        if (camposFiscales.telefono_principal.visible && camposFiscales.telefono_principal.required) {
            const telefono = document.getElementById('telefono_principal')?.value.trim();
            if (!telefono) camposRequeridos.push('Teléfono Principal');
        }
        
        if (camposFiscales.nombre_razon_social.visible && camposFiscales.nombre_razon_social.required) {
            const razonSocial = document.getElementById('nombre_razon_social')?.value.trim();
            if (!razonSocial) camposRequeridos.push('Nombre o Razón Social');
        }
        
        if (camposFiscales.tipo_persona.visible && camposFiscales.tipo_persona.required) {
            const tipoPersona = document.getElementById('tipo_persona')?.value;
            if (!tipoPersona) camposRequeridos.push('Tipo de Persona');
        }
    }
    
    if (camposRequeridos.length > 0) {
        Swal.fire({
            icon: 'error',
            title: 'Campos requeridos',
            html: `Por favor completa los siguientes campos:<br><strong>${camposRequeridos.join(', ')}</strong>`,
            confirmButtonText: 'Entendido'
        });
        return false;
    }
    
    // Validar contraseñas
    const password = document.getElementById('password')?.value;
    const confirmPassword = document.getElementById('confirm_password')?.value;
    
    if (password && confirmPassword && password !== confirmPassword) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Las contraseñas no coinciden'
        });
        return false;
    }
    
    if (password && password.length < 6) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'La contraseña debe tener al menos 6 caracteres'
        });
        return false;
    }
    
    return true;
}

/**
 * Evento principal cuando el DOM está listo
 */
document.addEventListener('DOMContentLoaded', function() {
    const formUsuario = document.getElementById('form-usuario');
    const rolSelect = document.getElementById('id_rol');
    
    // Configurar evento de cambio de rol
    if (rolSelect) {
        rolSelect.addEventListener('change', function() {
            actualizarCamposPorRol();
        });
        
        // Ejecutar una vez al inicio si ya hay un valor seleccionado
        if (rolSelect.value) {
            actualizarCamposPorRol();
        } else {
            deshabilitarTodasSecciones();
        }
    }
    
    // Configurar envío del formulario
    if (formUsuario) {
        formUsuario.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!validarFormularioPorRol()) {
                return;
            }
            
            const formData = new FormData(this);
            
            const csrfToken = document.querySelector('input[name="csrf_test_name"]')?.value || 
                             document.querySelector('input[name="ci_csrf_token"]')?.value;
            
            if (csrfToken) {
                formData.append('csrf_token', csrfToken);
            }
            
            Swal.fire({
                title: 'Guardando...',
                text: 'Por favor espere',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // CORRECCIÓN IMPORTANTE: Usar la variable global definida en la vista
            fetch('../admin/guardar', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message,
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            formUsuario.reset();
                            if (rolSelect) rolSelect.value = '';
                            deshabilitarTodasSecciones();
                        }
                    });
                } else {
                    let errorMessage = data.message;
                    if (data.errors && typeof data.errors === 'object') {
                        errorMessage = Object.values(data.errors).join('<br>');
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: errorMessage,
                        confirmButtonText: 'Entendido'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al guardar el usuario',
                    confirmButtonText: 'Entendido'
                });
            });
        });
    }
});

// Exportar funciones para uso global (si es necesario)
window.actualizarCamposPorRol = actualizarCamposPorRol;
window.validarFormularioPorRol = validarFormularioPorRol;