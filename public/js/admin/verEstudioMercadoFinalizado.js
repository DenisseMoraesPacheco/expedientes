$(document).ready(function () {
    const id = obtenerIdDesdeURL();
    cargarEstudio(id);
});

function obtenerIdDesdeURL() {
    const partes = window.location.pathname.split('/');
    return partes[partes.length - 1];
}

function cargarEstudio(id) {

    $.ajax({
        url: "../../portalProcesos/obtenerEstudioMercadoPorId/" + id,
        type: "GET",
        dataType: "json",
        success: function (response) {

            console.log(response);

            if (!response.success) {
                alert("Error al cargar datos");
                return;
            }

            if (response.data.length === 0) return;

            let estudio = response.data[0];

            $("#areaTexto").text(estudio.area);
            $("#nombreEstudioTexto").text(estudio.nombre_estudio);
            $("#fechaTexto").text(estudio.created_at);

            // =========================
            // AGRUPACIÓN
            // =========================

            const agrupado = {};
            const proveedoresSet = new Set();

            response.data.forEach(item => {

                const idDesc = item.id_descripcion;

                const proveedor = item.nombre
                    ? `${item.nombre} ${item.apellidoP} ${item.apellidoM}`.trim().toUpperCase()
                    : null;

                if (proveedor) proveedoresSet.add(proveedor);

                if (!agrupado[idDesc]) {
                    agrupado[idDesc] = {
                        partida: item.partida,
                        descripcion: item.producto_servicio,
                        unidad: item.unidad_medida,
                        cantidad: parseFloat(item.cantidad),
                        proveedores: {}
                    };
                }

                if (proveedor) {
                    let precio = parseFloat(item.precio_unitario || 0);
                    let total = parseFloat(item.total || 0);

                    agrupado[idDesc].proveedores[proveedor] = {
                        precio: precio,
                        total: total
                    };
                }
            });

            // =========================
            // PROVEEDORES
            // =========================

            const proveedores = Array.from(proveedoresSet);

            // 🔥 Inicializar totales correctamente
            let totalesPorProveedor = {};
            proveedores.forEach(p => {
                totalesPorProveedor[p] = 0;
            });

            console.log(totalesPorProveedor);

            // =========================
            // THEAD
            // =========================

            let thead = `
            <tr>
                <th rowspan="3">PARTIDA</th>
                <th rowspan="3">DESCRIPCIÓN</th>
                <th rowspan="3">UNIDAD</th>
                <th rowspan="3">CANTIDAD</th>
            `;

            proveedores.forEach(p => {
                thead += `<th colspan="2">${p}</th>`;
            });

            thead += `<th rowspan="3">TOTAL</th></tr>`;

            thead += `<tr>`;
            proveedores.forEach(() => {
                thead += `<th colspan="2">PRECIOS</th>`;
            });
            thead += `</tr>`;

            thead += `<tr>`;
            proveedores.forEach(() => {
                thead += `<th>UNITARIO</th><th>TOTAL</th>`;
            });
            thead += `</tr>`;

            $("#tablaEstudio thead").html(thead);

            // =========================
            // TBODY
            // =========================

            let html = "";

            Object.values(agrupado).forEach(item => {

                let fila = `
                <tr>
                    <td>${item.partida}</td>
                    <td>${item.descripcion}</td>
                    <td>${item.unidad}</td>
                    <td>${item.cantidad}</td>
                `;

                let suma = 0;
                let count = 0;

                proveedores.forEach(p => {

                    let key = p.toUpperCase().trim();

                    let proveedorData = item.proveedores[key];

                    if (proveedorData) {

                        let precio = Number(proveedorData.precio) || 0;

                        let total = proveedorData.total
                            ? Number(proveedorData.total)
                            : precio * item.cantidad;

                        // 🔥 AHORA SÍ SUMA
                        totalesPorProveedor[key] += total;

                        fila += `
            <td>$${precio.toFixed(2)}</td>
            <td>$${total.toFixed(2)}</td>
        `;
                    } else {
                        fila += `<td>-</td><td>-</td>`;
                    }
                });

                let promedio = count > 0 ? suma / count : 0;

                fila += `<td>$${promedio.toFixed(2)}</td></tr>`;

                html += fila;
            });

            $("#tbodyEstudio").html(html);


            let tfoot = "";

            // =========================
            // SUBTOTAL
            // =========================
            tfoot += `<tr>
    <th></th>
    <th></th>
    <th></th>
    <th>SUBTOTAL</th>
`;

            proveedores.forEach(p => {
                let key = p.toUpperCase().trim();
                let subtotal = totalesPorProveedor[key] || 0;

                tfoot += `
        <td></td> <!-- unitario vacío -->
        <td>$${subtotal.toFixed(2)}</td>
    `;
            });

            tfoot += `<td></td></tr>`;

            // =========================
            // IVA
            // =========================
            tfoot += `<tr>
    <th></th>
    <th></th>
    <th></th>
    <th>IVA</th>
`;

            proveedores.forEach(p => {
                let key = p.toUpperCase().trim();
                let subtotal = totalesPorProveedor[key] || 0;
                let iva = subtotal * 0.16;

                tfoot += `
        <td></td>
        <td>$${iva.toFixed(2)}</td>
    `;
            });

            tfoot += `<td></td></tr>`;

            // =========================
            // TOTAL
            // =========================
            tfoot += `<tr>
    <th></th>
    <th></th>
    <th></th>
    <th>TOTAL</th>
`;

            proveedores.forEach(p => {
                let key = p.toUpperCase().trim();
                let subtotal = totalesPorProveedor[key] || 0;
                let total = subtotal * 1.16;

                tfoot += `
        <td></td>
        <td>$${total.toFixed(2)}</td>
    `;
            });

            tfoot += `<td></td></tr>`;

            // INSERTAR
            $("#totalesProveedores").html(tfoot);
        }
    });
}

