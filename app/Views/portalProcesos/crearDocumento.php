<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudio de Mercado</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
    </style>
</head>

<body>

    <div class="container">

        <div class="header">
            <h1>Estudio de Mercado</h1>
            <p>Registro de productos y cotización por proveedor</p>
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
            <h2>Datos Generales</h2>

            <div class="grid">
                <div>
                    <label>Área</label>
                    <select id="area">
                        <option value="">Seleccione área</option>

                    </select>
                </div>

                <div>
                    <label>Nombre del Estudio</label>
                    <input type="text" id="nombre_estudio">
                </div>

                <div>
                    <label>Fecha</label>
                    <input type="date" id="fecha">
                </div>
            </div>
        </div>

        <!-- PRODUCTOS -->
        <div class="card">
            <h2>Agregar Descripción</h2>

            <div class="grid">
                <div>
                    <label>Descripción</label>
                    <input type="text" id="descripcion">
                </div>

                <div>
                    <label>Unidad de Medida</label>
                    <select id="unidades">
                        <option value="">Seleccione una Unidad de Medida</option>
                    </select>
                </div>

                <div>
                    <label>Cantidad</label>
                    <input type="number" id="cantidad">
                </div>
            </div>

            <button class="btn-primary" onclick="agregarProducto()">
                + Agregar Descripción
            </button>

            <table id="tablaProductos">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Descripción</th>
                        <th>Unidad</th>
                        <th>Cantidad</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody id="tbodyProductos"></tbody>
            </table>
        </div>

        <!-- PROVEEDOR -->
        <div class="card">
            <h2>Cotización por Proveedor</h2>

            <div class="grid">
                <div>
                    <label>Proveedor</label>
                    <select id="proveedores">
                        <option value="">Seleccione un proveedor</option>
                    </select>
                </div>
            </div>

            <button class="btn-primary" onclick="generarCotizacionProveedor()">
                Generar Cotización
            </button>

            <div id="contenedorCotizaciones"></div>


            <div style="margin-top: 30px; text-align: right;">
                <button class="btn-primary" onclick="guardarEstudioMercado()">
                    <i class="fas fa-save"></i>
                    Guardar Estudio de Mercado
                </button>

            </div>

        </div>


    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let productos = [];
        let contador = 1;

        function agregarProducto() {
            let descripcion = document.getElementById("descripcion").value;
            let unidad = document.getElementById("unidades").value;
            let cantidad = parseFloat(document.getElementById("cantidad").value);

            if (!descripcion || !unidad || !cantidad) {
                alert("Complete todos los campos");
                return;
            }

            productos.push({
                id: contador,
                descripcion,
                unidad,
                cantidad
            });

            renderProductos();

            document.getElementById("descripcion").value = "";
            document.getElementById("unidades").value = "";
            document.getElementById("cantidad").value = "";

            contador++;
        }

        function renderProductos() {
            let tbody = document.getElementById("tbodyProductos");
            tbody.innerHTML = "";

            productos.forEach((p, index) => {
                tbody.innerHTML += `
            <tr>
                <td>${p.id}</td>
                <td>${p.descripcion}</td>
                <td>${p.unidad}</td>
                <td>${p.cantidad}</td>
                <td>
                    <button class="btn-danger" onclick="eliminarProducto(${index})">
                        X
                    </button>
                </td>
            </tr>
        `;
            });
        }

        function eliminarProducto(index) {
            productos.splice(index, 1);
            renderProductos();
        }

        function generarCotizacionProveedor() {
            let proveedor = document.getElementById("proveedores").value;

            if (!proveedor) {
                alert("Ingrese proveedor");
                return;
            }

            if (productos.length === 0) {
                alert("Primero agregue descripciones");
                return;
            }

            let html = `
        <div class="card">
            <h2 data-proveedor="${proveedor}">
    Proveedor: ${proveedor}
</h2>

            <table>
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Modelo</th>
                        <th>Importe</th>
                    </tr>
                </thead>
                <tbody>
    `;

            productos.forEach((p, i) => {
                html += `
        <tr>
            <td>${p.descripcion}</td>
            <td>${p.cantidad}</td>

            <td>
                <input 
                    type="number"
                    step="0.01"
                    id="precio_${proveedor}_${i}"
                    oninput="calcularTotales('${proveedor}')"
                >
            </td>

            <td>
                <input 
                    type="text"
                    id="modelo_${proveedor}_${i}"
                >
            </td>

            <td id="importe_${proveedor}_${i}">
                $0.00
            </td>
        </tr>
    `;
            });

            html += `
                </tbody>
            </table>

            <div class="resumen">
                <div>
                    <span>Subtotal:</span>
                    <span id="subtotal_${proveedor}">$0.00</span>
                </div>

                <div>
                    <span>IVA (16%):</span>
                    <span id="iva_${proveedor}">$0.00</span>
                </div>

                <div class="total">
                    <span>Total:</span>
                    <span id="total_${proveedor}">$0.00</span>
                </div>
            </div>
        </div>
    `;

            document.getElementById("contenedorCotizaciones").innerHTML += html;
            document.getElementById("proveedores").value = "";
        }

        function cargarProveedores() {

            fetch("../../usuarios/obtenerProveedores")
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
        }

        function cargarAreas() {

            fetch("../../areas/obtenerAreas")
                .then(res => res.json())
                .then(data => {

                    // Tu controlador regresa success, no status
                    if (!data.success) {
                        alert("No se pudo cargar las áreas");
                        return;
                    }

                    let areas = data.data;
                    let selectArea = document.getElementById("area");

                    // limpiar opciones anteriores
                    selectArea.innerHTML = '<option value="">Seleccione área</option>';

                    areas.forEach(area => {
                        let option = document.createElement("option");

                        // ajusta estos campos según tu tabla real
                        option.value = area.id_area;
                        option.textContent = area.area;

                        selectArea.appendChild(option);
                    });

                    console.log(areas);
                })
                .catch(error => {
                    console.error("Error cargando áreas:", error);
                });
        }

        function cargarUnidadesMedida() {

            fetch("../../unidades/obtenerUnidadesMedida")
                .then(res => res.json())
                .then(data => {

                    if (!data.success) {
                        alert("No se pudieron cargar las unidades de medida");
                        return;
                    }

                    let unidades = data.data;
                    let selectUnidad = document.getElementById("unidades");

                    // Limpiar opciones anteriores
                    selectUnidad.innerHTML = '<option value="">Seleccione una Unidad de Medida</option>';

                    unidades.forEach(unidad => {
                        let option = document.createElement("option");

                        // Aquí debes usar "unidad", no "unidades"
                        option.value = unidad.id_unidad;
                        option.textContent = unidad.nombre;

                        selectUnidad.appendChild(option);
                    });

                    console.log(unidades);
                })
                .catch(error => {
                    console.error("Error cargando unidades de medida:", error);
                });
        }



        function guardarEstudioMercado() {

            let area = document.getElementById("area").value;
            let nombreEstudio = document.getElementById("nombre_estudio").value;
            let fecha = document.getElementById("fecha").value;

            // Validar datos generales
            if (!area || !nombreEstudio || !fecha) {
                alert("Complete los datos generales");
                return;
            }

            // Validar productos
            if (productos.length === 0) {
                alert("Debe agregar al menos una descripción");
                return;
            }

            // Objeto principal
            let data = {
                area: area,
                nombre_estudio: nombreEstudio,
                fecha: fecha,
                productos: productos,
                proveedores: []
            };

            // Obtener tarjetas de proveedores
            let tarjetasProveedor = document.querySelectorAll("#contenedorCotizaciones .card");

            tarjetasProveedor.forEach((card) => {
                let proveedor = card.querySelector("h2").dataset.proveedor;

                let detalle = [];

                productos.forEach((producto, i) => {

                    let precioInput = document.getElementById(`precio_${proveedor}_${i}`);
                    let precio = precioInput ? parseFloat(precioInput.value || 0) : 0;
                    let modeloInput = document.getElementById(`modelo_${proveedor}_${i}`);
                    let modelo = modeloInput ? modeloInput.value : "";

                    detalle.push({
                        descripcion: producto.descripcion,
                        cantidad: producto.cantidad,
                        precio_unitario: precio,
                        modelo: modelo,
                        importe: precio * producto.cantidad
                    });
                });

                let subtotal = card.querySelector(`#subtotal_${proveedor}`)?.innerText || "$0.00";
                let iva = card.querySelector(`#iva_${proveedor}`)?.innerText || "$0.00";
                let total = card.querySelector(`#total_${proveedor}`)?.innerText || "$0.00";

                data.proveedores.push({
                    proveedor: proveedor,
                    detalle: detalle,
                    subtotal: subtotal,
                    iva: iva,
                    total: total
                });
            });

            console.log(data);


            // AJAX a CodeIgniter
            $.ajax({
                url: '<?= base_url("portalProcesos/guardarEstudioMercado") ?>',
                type: 'POST',
                data: JSON.stringify(data),
                contentType: 'application/json',
                dataType: 'json',

                success: function (response) {
                    console.log(response);

                    if (response.success) {
                        alert("Guardado correctamente");
                        location.reload();
                    } else {
                        alert(response.message || "Ocurrió un error al guardar");
                    }
                },

                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                    console.log(error);
                    alert("Error al guardar en la base de datos");
                }
            });
        }
        document.addEventListener("DOMContentLoaded", function () {


            cargarAreas();
            cargarUnidadesMedida();
            cargarProveedores();


        });

        function calcularTotales(proveedor) {
            let subtotal = 0;

            productos.forEach((producto, i) => {
                let precioInput = document.getElementById(`precio_${proveedor}_${i}`);
                let precio = precioInput ? parseFloat(precioInput.value || 0) : 0;

                let importe = precio * producto.cantidad;
                subtotal += importe;

                let importeElemento = document.getElementById(`importe_${proveedor}_${i}`);
                if (importeElemento) {
                    importeElemento.innerText = "$" + importe.toFixed(2);
                }
            });

            let iva = subtotal * 0.16;
            let total = subtotal + iva;

            let subtotalElemento = document.getElementById(`subtotal_${proveedor}`);
            let ivaElemento = document.getElementById(`iva_${proveedor}`);
            let totalElemento = document.getElementById(`total_${proveedor}`);

            if (subtotalElemento) {
                subtotalElemento.innerText = "$" + subtotal.toFixed(2);
            }

            if (ivaElemento) {
                ivaElemento.innerText = "$" + iva.toFixed(2);
            }

            if (totalElemento) {
                totalElemento.innerText = "$" + total.toFixed(2);
            }
        }
    </script>

</body>

</html>