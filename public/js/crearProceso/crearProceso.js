document.addEventListener("DOMContentLoaded", function () {
    cargarProveedores();
    cargarAreas();
    cargarCatalogo();
    //obtenerDescripcionCatalogo(idCatalogo);
    activarEventosCheckbox();
    generarTablaCostos();
    agregarProductoSeleccionado(id, nombre);

    // OPCIONAL: limpiar tabla
    document.getElementById("tablaProductosSeleccionados").innerHTML = `
        <tr id="filaVaciaSeleccionados">
            <td class="w3-center">No hay productos seleccionados</td>
        </tr>
    `;

});

// SIDEBAR
var mySidebar = document.getElementById("mySidebar");
var overlayBg = document.getElementById("myOverlay");

function w3_open() {

    if (mySidebar.style.display === 'block') {

        mySidebar.style.display = 'none';
        overlayBg.style.display = "none";

    } else {

        mySidebar.style.display = 'block';
        overlayBg.style.display = "block";

    }
}

function w3_close() {

    mySidebar.style.display = "none";
    overlayBg.style.display = "none";

}

function cargarAreas() {

    fetch("../areas/obtenerAreas")
        .then(res => res.json())
        .then(data => {

            if (!data.success) {
                alert("No se pudieron cargar las áreas");
                return;
            }

            let areas = data.data;
            let selectAreas = document.getElementById("areas");

            selectAreas.innerHTML = '<option value="">Seleccione una Área</option>';

            areas.forEach(area => {
                let option = document.createElement("option");
                option.value = area.id_area;
                option.textContent = area.area;
                selectAreas.appendChild(option);
            });

            console.log(areas);

            $('#areas').trigger('change');

        })
        .catch(error => {
            console.error("Error cargando las áreas:", error);
        });
}

function cargarProveedores() {

    fetch("../usuarios/obtenerProveedores")
        .then(res => res.json())
        .then(data => {

            if (!data.success) {
                alert("No se pudieron cargar los proveedores");
                return;
            }

            let proveedores = data.data;
            let selectProveedores = document.getElementById("proveedores");

            // Limpiar opciones anteriores
            selectProveedores.innerHTML = '<option value="">Seleccione un proveedor</option>';

            proveedores.forEach(proveedor => {
                let option = document.createElement("option");

                // Ajusta estos campos según tu tabla real
                option.value = proveedor.id_usuario;
                option.textContent = proveedor.nombre;

                selectProveedores.appendChild(option);
            });

            console.log(proveedores);
        })
        .catch(error => {
            console.error("Error cargando los proveedores:", error);
        });
    $('#proveedores').select2({

        placeholder: "SELECCIONA UN PROVEEDOR",

        width: '100%'

    });
}
function cargarCatalogo() {

    fetch("../catalogo/obtenerCatalogo")
        .then(res => res.json())
        .then(data => {

            if (!data.success) {
                alert("No se pudieron cargar los datos del catalogo");
                return;
            }

            let catalogo = data.data;
            let selectCatalogo = document.getElementById("catalogo");

            selectCatalogo.innerHTML = `
                <option value="">
                    Seleccione una opcion del catalogo
                </option>
            `;

            catalogo.forEach(item => {

                let option = document.createElement("option");

                option.value = item.id_catalogo;
                option.textContent = item.nombre_catalogo;

                selectCatalogo.appendChild(option);

            });

        })
        .catch(error => {
            console.error("Error cargando catálogo:", error);
        });
}


document.getElementById("catalogo").addEventListener("change", function () {

    let idCatalogo = this.value;

    if (idCatalogo == "") {
        return;
    }

    obtenerDescripcionCatalogo(idCatalogo);

});


function obtenerDescripcionCatalogo(idCatalogo) {

    fetch(`../descripcionCatalogo/obtenerDescripcionCatalogo/${idCatalogo}`)

        .then(res => res.json())

        .then(data => {

            if (!data.success) {

                alert("No se encontraron registros");
                return;

            }

            let tablaDisponibles = document.getElementById("tablaProductosDisponibles");

            tablaDisponibles.innerHTML = "";

            data.data.forEach(item => {

                tablaDisponibles.innerHTML += `

                    <tr>

                        <td class="w3-center">

                            <input
                                type="checkbox"
                                class="w3-check checkProducto"
                                data-id="${item.id_descripcion_catalogo}"
                                data-nombre="${item.producto_servicio}">
                               

                        </td>

                        <td>
                            ${item.producto_servicio}
                        </td>
                        
                        <td>
                            ${item.unidad_medida}
                        </td>

                    </tr>

                `;

            });

            activarEventosCheckbox();

        })

        .catch(error => {
            console.error(error);
        });

}


function activarEventosCheckbox() {

    let checks = document.querySelectorAll(".checkProducto");

    checks.forEach(check => {

        check.addEventListener("change", function () {

            let id = this.dataset.id;
            let nombre = this.dataset.nombre;

            if (this.checked) {

                agregarProductoSeleccionado(id, nombre);

            } else {

                eliminarProductoSeleccionado(id);

            }

        });

    });

}

function generarTablaCostos() {

    let tabla = document.getElementById("tablaProductosSeleccionados");
    let thead = document.getElementById("theadProductosSeleccionados");

    // PRODUCTOS SELECCIONADOS
    let productos = document.querySelectorAll(".checkProducto:checked");

    // PROVEEDORES SELECCIONADOS
    let proveedores = $('#proveedores').select2('data');
    actualizarEncabezados();

    // LIMPIAR
    tabla.innerHTML = "";
    thead.innerHTML = "";

    // VALIDAR
    if (productos.length === 0 || proveedores.length === 0) {

        thead.innerHTML = `
            <tr class="w3-green">
                <th>Producto / Servicio</th>
            </tr>
        `;

        tabla.innerHTML = `
            <tr id="filaVaciaSeleccionados">

                <td class="w3-center">
                    Selecciona productos y proveedores
                </td>

            </tr>
        `;

        return;
    }

    // ====================================
    // ENCABEZADOS
    // ====================================

    let encabezado = `
        <tr class="w3-green">

            <th>Producto / Servicio</th>
    `;

    proveedores.forEach((proveedor, indexProveedor) => {

        encabezado += `
            <th>

                ${proveedor.text}

            </th>
        `;

    });

    encabezado += `
        <th>Eliminar</th>
    `;

    encabezado += `</tr>`;

    thead.innerHTML = encabezado;

    // ====================================
    // FILAS
    // ====================================

    productos.forEach((producto, indexProducto) => {

        let fila = `
<tr id="producto_${id}">

    <td>
        ${nombre}
        <input type="hidden" name="productosSeleccionados[]" value="${id}">
    </td>

    <!-- ✅ CANTIDAD -->
    <td>
        <input
            type="number"
            min="1"
            value="1"
            class="w3-input w3-border w3-round cantidad"
            data-producto="${id}"
            oninput="calcularTotales()"
            name="cantidad_${id}">
    </td>
`;

        proveedores.forEach(proveedor => {

            fila += `
    <td>
        <input
            type="number"
            step="0.01"
            min="0"
            class="w3-input w3-border w3-round precio"
            data-proveedor="${proveedor.id}"
            data-producto="${id}"
            oninput="calcularTotales()"
            name="precio_${id}_${proveedor.id}">
    </td>
    `;
        });

        // BOTON ELIMINAR
        fila += `
            <td class="w3-center">

                <button
                    type="button"
                    class="w3-button w3-red w3-round"
                    onclick="eliminarProductoSeleccionado(${id})">

                    X

                </button>

            </td>
        `;

        fila += `</tr>`;

        tabla.innerHTML += fila;

    });

}

function agregarProductoSeleccionado(id, nombre) {

    let tabla = document.getElementById("tablaProductosSeleccionados");

    if (document.getElementById(`producto_${id}`)) return;

    let filaVacia = document.getElementById("filaVaciaSeleccionados");
    if (filaVacia) filaVacia.remove();

    let proveedores = obtenerProveedoresSeleccionados();
    actualizarEncabezados();
    actualizarTotalesFooter();

    let columnasPrecios = "";

    proveedores.forEach(p => {

        // COSTO UNITARIO
        columnasPrecios += `
        <td>

            <input
                type="number"
                step="0.01"
                min="0"
                class="w3-input w3-border w3-round precio"
                data-proveedor="${p.id}"
                data-producto="${id}"
                oninput="calcularTotales()"
                name="precio_${id}_${p.id}"
                placeholder="0.00">

        </td>
    `;

        // COSTO TOTAL
        columnasPrecios += `
        <td>

            <input
                type="number"
                step="0.01"
                min="0"
                readonly
                class="w3-input w3-border w3-round totalProducto"
                data-proveedor="${p.id}"
                data-producto="${id}"
                name="total_${id}_${p.id}"
                placeholder="0.00">

        </td>
    `;

        // MARCA MODELO
        columnasPrecios += `
        <td>

            <input
                type="text"
                class="w3-input w3-border w3-round"
                data-proveedor="${p.id}"
                data-producto="${id}"
                name="marca_${id}_${p.id}"
                placeholder="Marca / Modelo">

        </td>
    `;
    });

    tabla.insertAdjacentHTML('beforeend', `
        <tr id="producto_${id}">

            <td>
                ${nombre}
                <input type="hidden" name="productosSeleccionados[]" value="${id}">
            </td>

            <!-- ✅ CANTIDAD -->
            <td>
                <input
                    type="number"
                    step="1"
                    min="1"
                    value="1"
                    class="w3-input w3-border w3-round cantidad"
                    data-producto="${id}"
                    oninput="calcularTotales()"
                    name="cantidad_${id}"
                    placeholder="Cantidad">
            </td>

            ${columnasPrecios}

            <td class="w3-center">
                <button type="button"
                    class="w3-button w3-red w3-round"
                    onclick="eliminarProductoSeleccionado(${id})">
                    X
                </button>
            </td>

        </tr>
    `);

    // 🔥 recalcular después de agregar
    calcularTotales();
}


function actualizarTotalesFooter() {

    let proveedores = obtenerProveedoresSeleccionados();
    let tfoot = document.getElementById("totalesProveedores");

    let subtotalRow = `<tr><th colspan="2">Subtotal</th>`;
    let ivaRow = `<tr><th colspan="2">IVA (16%)</th>`;
    let totalRow = `<tr><th colspan="2">Total</th>`;

    proveedores.forEach(p => {
        subtotalRow += `<td id="subtotal_${p.id}">0.00</td>`;
        ivaRow += `<td id="iva_${p.id}">0.00</td>`;
        totalRow += `<td id="total_${p.id}">0.00</td>`;
    });

    subtotalRow += `<td></td></tr>`;
    ivaRow += `<td></td></tr>`;
    totalRow += `<td></td></tr>`;

    tfoot.innerHTML = subtotalRow + ivaRow + totalRow;
}
function calcularTotales() {

    let proveedores = obtenerProveedoresSeleccionados();

    proveedores.forEach(p => {

        let subtotal = 0;

        document.querySelectorAll(`#tablaProductosSeleccionados tr[id^="producto_"]`)
            .forEach(fila => {

                let cantidad = parseFloat(fila.querySelector(".cantidad")?.value) || 0;

                let precioInput = fila.querySelector(`.precio[data-proveedor="${p.id}"]`);
                let precio = parseFloat(precioInput?.value) || 0;

                subtotal += cantidad * precio;
                // TOTAL POR PRODUCTO
                let totalProducto = cantidad * precio;

                let inputTotal = fila.querySelector(
                    `.totalProducto[data-proveedor="${p.id}"]`
                );

                if (inputTotal) {
                    inputTotal.value = totalProducto.toFixed(2);
                }
            });

        let iva = subtotal * 0.16;
        let total = subtotal + iva;

        document.getElementById(`subtotal_${p.id}`).innerText = subtotal.toFixed(2);
        document.getElementById(`iva_${p.id}`).innerText = iva.toFixed(2);
        document.getElementById(`total_${p.id}`).innerText = total.toFixed(2);
    });
}
function obtenerProveedoresSeleccionados() {

    let data = $('#proveedores').select2('data');

    return data.map(p => ({
        id: p.id,
        nombre: p.text
    }));
}
function guardarProceso() {

    let proveedores = obtenerProveedoresSeleccionados();
    let catalogo = document.getElementById('catalogo').value;

    let puntos = [];

    document.querySelectorAll('input[name="puntos[]"]').forEach(input => {
        if (input.value.trim() !== '') {
            puntos.push(input.value);
        }
    });

    // =====================
    // PRODUCTOS
    // =====================

    let productos = [];

    document.querySelectorAll('#tablaProductosSeleccionados tr[id^="producto_"]')
        .forEach(fila => {

            let idProducto = fila.id.replace('producto_', '');
            let cantidad = fila.querySelector('.cantidad')?.value || 0;

            let precios = [];

            fila.querySelectorAll('.precio').forEach(inputPrecio => {

                let proveedorId = inputPrecio.dataset.proveedor;

                // MARCA / MODELO
                let inputMarca = fila.querySelector(
                    `input[name="marca_${idProducto}_${proveedorId}"]`
                );

                // TOTAL PRODUCTO
                let inputTotal = fila.querySelector(
                    `.totalProducto[data-proveedor="${proveedorId}"]`
                );

                precios.push({

                    proveedor: proveedorId,

                    precio: inputPrecio.value,

                    marca_modelo: inputMarca ? inputMarca.value : '',

                    total_producto: inputTotal ? inputTotal.value : '0.00'

                });

            });

            productos.push({
                id_producto: idProducto,
                cantidad: cantidad,
                precios: precios
            });

        });

    // =====================
    // PROVEEDOR (FORM)
    // =====================

    let form = document.getElementById("formProveedorTemporal");
    let formData = new FormData(form);
    let id_area = document.getElementById('areas').value;
    let proveedor = {};
    let nomb_procedimiento = document.getElementById('nomb_procedimiento').value;
    formData.forEach((value, key) => {
        proveedor[key] = value;
    });

    // =====================
    // OBJETO FINAL
    // =====================

let totalesProveedores = [];

proveedores.forEach(p => {

    totalesProveedores.push({

        proveedor: p.id,

        subtotal: document.getElementById(`subtotal_${p.id}`)?.innerText || 0,

        iva: document.getElementById(`iva_${p.id}`)?.innerText || 0,

        total: document.getElementById(`total_${p.id}`)?.innerText || 0

    });

});
    
    let datos = {

          proveedor: proveedor,
    catalogo: catalogo,
    proveedores: proveedores,
    totales: totalesProveedores,
    puntos: puntos,
    productos: productos,
    id_area: id_area,
    nomb_procedimiento: nomb_procedimiento,
    


    };

    console.log(datos);

    fetch("../portalProcesos/guardarEstudioMercado", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(datos)
    })
        .then(res => res.json())
        .then(data => {

    console.log("RESPUESTA:", data);

    if (data.success) {
        alert(data.message);
    } else {
        alert('Error al guardar');
    }

})
        .catch(error => {
            console.error(error);
        });
}
function actualizarEncabezados() {

    let proveedores = obtenerProveedoresSeleccionados();
    let thead = document.getElementById("theadProductosSeleccionados");

    // =========================
    // FILA 1
    // =========================

    let fila1 = `
        <tr class="w3-green">

            <th rowspan="2">
                Producto / Servicio
            </th>

            <th rowspan="2">
                Cantidad
            </th>
    `;

    proveedores.forEach(p => {

        fila1 += `

            <!-- PROVEEDOR -->
            <th colspan="2" class="w3-center">
                ${p.nombre}
            </th>

            <!-- MARCA -->
            <th rowspan="2" class="w3-center">
                Marca / Modelo
            </th>

        `;

    });

    fila1 += `
            <th rowspan="2">
                Acción
            </th>

        </tr>
    `;

    // =========================
    // FILA 2
    // =========================

    let fila2 = `<tr class="w3-green">`;

    proveedores.forEach(p => {

        fila2 += `
            <th>Costo Unitario</th>
            <th>Costo Total</th>
        `;

    });

    fila2 += `</tr>`;

    thead.innerHTML = fila1 + fila2;
}


function eliminarProductoSeleccionado(id) {

    let fila = document.getElementById(`producto_${id}`);

    if (fila) {
        fila.remove();
    }

    // DESMARCAR CHECKBOX
    let checkbox = document.querySelector(`.checkProducto[data-id='${id}']`);

    if (checkbox) {
        checkbox.checked = false;
    }

    // SI YA NO HAY PRODUCTOS
    let tablaSeleccionados = document.getElementById("tablaProductosSeleccionados");

    if (tablaSeleccionados.children.length === 0) {

        tablaSeleccionados.innerHTML = `

            <tr id="filaVaciaSeleccionados">

                <td colspan="3" class="w3-center">
                    No hay productos seleccionados
                </td>

            </tr>

        `;

    }

}

// AGREGAR INPUTS
function agregarPunto() {

    let contenedor = document.getElementById('contenedorPuntos');

    let div = document.createElement('div');

    div.className = 'w3-row-padding input-punto';

    div.innerHTML = `
            
                <div class="w3-col l10 m9 s8">

                    <input
                        type="text"
                        name="puntos[]"
                        class="w3-input w3-border w3-round"
                        placeholder="Escribe un punto">

                </div>

                <div class="w3-col l2 m3 s4">

                    <button
                        type="button"
                        class="w3-button w3-red w3-round w3-block"
                        onclick="eliminarPunto(this)">

                        <i class="fa fa-trash"></i>

                    </button>

                </div>

            `;

    contenedor.appendChild(div);

}


// GUARDAR


// ELIMINAR INPUT
function eliminarPunto(btn) {

    btn.parentElement.parentElement.remove();

}
