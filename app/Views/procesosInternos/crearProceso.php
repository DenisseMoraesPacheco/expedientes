<!DOCTYPE html>
<html lang="es">

<head>
    <title>Crear Proceso</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- W3.CSS -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <style>
        html,
        body,
        h1,
        h2,
        h3,
        h4,
        h5 {
            font-family: "Raleway", sans-serif;
        }

        .input-punto {
            margin-bottom: 10px;
        }
    </style>

    <style>
        .portal-container {
            margin-top: 60px;
            /* para que no se encime con el top bar */
            padding: 10px;
        }

        .portal-header {
            background-color: #800020;
            color: white;
            padding: 15px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }


        .portal-title {
            font-size: 20px;
            font-weight: bold;
        }

        .portal-nav {
            background: white;
            padding: 20px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .breadcrumb a {
            text-decoration: none;
            color: #800020;
            font-weight: 500;
        }

        .breadcrumb-separator {
            margin: 0 5px;
            color: gray;
        }

        .btn-secondary {
            background-color: #800020;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>

</head>

<div class="w3-main" style="margin-top:60px; margin-left:300px;">

    <div class="portal-container">

        <header class="portal-header">
            <div class="portal-title">PORTAL "CREAR NUEVO PROCESO"</div>
        </header>

        <nav class="portal-nav">
            <div class="breadcrumb">
                <a href="<?= '/' ?>">Inicio</a>
                <span class="breadcrumb-separator">/</span>
                <a href="<?= '../procesosInternos/procesos' ?>">Portal Procesos</a>
                <span class="breadcrumb-separator">/</span>
                <span>Portal Crear Nuevo Proceso</span>
            </div>

            <button onclick="document.getElementById('id01').style.display='block'"
                class="w3-button w3-green w3-large">Crear Proveedor Temporal</button>
        </nav>

    </div>

</div>

<body class="w3-light-grey">

    <!-- TOP -->
    <div class="w3-bar w3-top w3-large" style="background-color:#800020; color:white; z-index:4">
        <button class="w3-bar-item w3-button w3-hide-large" onclick="w3_open();">
            <i class="fa fa-bars"></i> Menu
        </button>

        <span class="w3-bar-item w3-right">
            Sistema
        </span>
    </div>

    <!-- SIDEBAR -->
    <nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="
        z-index:3;
        width:300px;
        position:fixed;
        top:60px;
        left:0;
        height:100%;
        overflow:auto;
     " id="mySidebar">

        <br>

        <div class="w3-container w3-row">
            <div class="w3-col s4">
                <img src="https://www.w3schools.com/w3images/avatar2.png" class="w3-circle w3-margin-right"
                    style="width:46px">
            </div>

            <div class="w3-col s8 w3-bar">
                <span>CREAR NUEVO </span><br>
                <a href="#" class="w3-bar-item w3-button">
                    <i class="fa fa-book"></i>
                </a>
            </div>
        </div>

        <hr>

        <div class="w3-container">
            <h5>Menú</h5>
        </div>

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
    <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" id="myOverlay">
    </div>

    <!-- CONTENIDO -->
    <div class="w3-main" style="margin-left:300px;margin-top:43px;">

        <div class="w3-container">

            <div class="w3-card w3-white w3-round-large w3-padding w3-margin-bottom">

                <!-- NOMBRE PARTIDA -->
                <div class="w3-row w3-margin-bottom">

                    <div class="w3-container">
                        <label class="w3-text-black">
                            <b>NOMBRE DEL PROCEDIMIENTO</b>
                        </label>

                        <input type="text" id="nomb_procedimiento" class="w3-input w3-border"
                            placeholder="Escribe el nombre del procedimiento">
                    </div>

                </div>

                <!-- AREAS -->
                <div class="w3-margin-bottom">

                    <label>
                        <b>ESCOGE UN AREA</b>
                    </label>

                    <select id="areas" name="areas" style="width:100%;">

                        <option value="">Selecciona un Area</option>

                    </select>

                </div>

                <!-- PROVEEDOR -->
                <div class="w3-margin-bottom">

                    <label>
                        <b>ESCOGE UN PROVEEDOR</b>
                    </label>

                    <select id="proveedores" name="proveedores[]" class="js-example-basic-multiple" multiple="multiple"
                        style="width:100%;">

                        <option value="">Selecciona un Proveedor</option>

                    </select>

                </div>

                <!-- CATALOGO -->
                <div class="w3-margin-bottom">

                    <label>
                        <b>ESCOGE UNA OPCIÓN DEL CATÁLOGO</b>
                    </label>

                    <select class="w3-select w3-border w3-round" name="catalogo" id="catalogo" style="width:100%;">

                        <option value="">
                            SELECCIONA LO QUE SE DESEA ADQUIRIR
                        </option>

                    </select>

                </div>

                <!-- TABLA 1 -->
                <div class="w3-margin-top">

                    <h4>
                        <b>Productos/Servicios Disponibles</b>
                    </h4>

                    <div class="w3-responsive">

                        <table class="w3-table-all w3-hoverable w3-bordered">

                            <thead>

                                <tr class="w3-blue">

                                    <th class="w3-center">
                                        Seleccionar
                                    </th>

                                    <th>
                                        Producto/Servicio
                                    </th>

                                    <th>
                                        Unidad de Medida
                                    </th>

                                </tr>

                            </thead>

                            <tbody id="tablaProductosDisponibles">

                                <tr>
                                    <td colspan="2" class="w3-center">
                                        Selecciona un catálogo
                                    </td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

                <!-- TABLA 2 -->
                <div class="w3-margin-top">

                    <h3>
                        <b>Costos Unitarios por Proveedor</b>
                    </h3>

                    <div class="w3-responsive">

                        <table class="w3-table-all w3-hoverable w3-bordered">

                            <!-- ENCABEZADOS DINÁMICOS -->
                            <thead id="theadProductosSeleccionados">

                                <tr class="w3-green">

                                    <th style="width:25%;">
                                        Producto / Servicio
                                    </th>

                                    <th style="width:10%;">
                                        Cantidad
                                    </th>

                                    <!-- PROVEEDORES DINÁMICOS -->

                                    <th style="width:10%;">
                                        Acción
                                    </th>

                                </tr>

                            </thead>

                            <!-- FILAS DINÁMICAS -->
                            <tbody id="tablaProductosSeleccionados">

                                <tr id="filaVaciaSeleccionados">

                                    <td colspan="4" class="w3-center w3-padding">
                                        Selecciona productos y proveedores
                                    </td>

                                </tr>

                            </tbody>

                            <!-- TOTALES -->
                            <tfoot id="totalesProveedores">

                                <tr>

                                    <th colspan="2">
                                        Subtotal
                                    </th>

                                    <!-- DINÁMICO -->

                                    <td></td>

                                </tr>

                                <tr>

                                    <th colspan="2">
                                        IVA (16%)
                                    </th>

                                    <!-- DINÁMICO -->

                                    <td></td>

                                </tr>

                                <tr>

                                    <th colspan="2">
                                        Total
                                    </th>

                                    <!-- DINÁMICO -->

                                    <td></td>

                                </tr>

                            </tfoot>

                        </table>

                    </div>

                </div>

                <!-- PUNTOS -->
                <div class="w3-margin-bottom">

                    <label>
                        <b>PUNTOS / ESPECIFICACIONES</b>
                    </label>

                    <div id="contenedorPuntos">

                        <div class="w3-row-padding input-punto">

                            <div class="w3-col l10 m9 s8">
                                <input type="text" name="puntos[]" class="w3-input w3-border w3-round"
                                    placeholder="Escribe un punto">
                            </div>

                            <div class="w3-col l2 m3 s4">
                                <button type="button" class="w3-button w3-green w3-round w3-block"
                                    onclick="agregarPunto()">

                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>

                        </div>


                    </div>

                </div>

                <!-- BOTON -->
                <div class="w3-center">

                    <button class="w3-button w3-blue w3-round-large w3-padding-large" onclick="guardarProceso()">

                        <i class="fa fa-save"></i>
                        Guardar Proceso

                    </button>

                </div>

            </div>
            <div id="id01" class="w3-modal">
                <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">

                    <!-- APARTADO DEL TITULO -->
                    <div class="w3-container" style="background-color: #800020; color: white;">
                        <span onclick="document.getElementById('id01').style.display='none'"
                            class="w3-button w3-display-topright" style="color: white;">&times;</span>
                        <h2>Registro de Proveedor</h2>
                    </div>

                    <form id="formProveedorTemporal">
                        <div class="w3-section" style="padding: 0 16px 16px 16px;">

                            <div style="display: flex; gap: 10px;">

                                <div style="flex:1;">
                                    <label><b>Nombre</b></label>
                                    <input class="w3-input w3-border" type="text" placeholder="Nombre" name="nombre"
                                        required>
                                </div>

                                <div style="flex:1;">
                                    <label><b>Apellido Paterno</b></label>
                                    <input class="w3-input w3-border" type="text" placeholder="Apellido Paterno"
                                        name="apellidoP" required>
                                </div>

                                <div style="flex:1;">
                                    <label><b>Apellido Materno</b></label>
                                    <input class="w3-input w3-border" type="text" placeholder="Apellido Materno"
                                        name="apellidoM" required>
                                </div>

                            </div>

                            <label><b>Correo Electronico</b></label>
                            <input class="w3-input w3-border" type="text" placeholder="Coloca correo electronico"
                                name="correo" required>

                            <div style="display: flex; gap: 10px;">

                                <div style="flex:1;">
                                    <label><b>Colonia</b></label>
                                    <input class="w3-input w3-border" type="text" placeholder="Colonia" name="colonia"
                                        required>
                                </div>

                                <div style="flex:1;">
                                    <label><b>Calle/Num.</b></label>
                                    <input class="w3-input w3-border" type="text" placeholder="Calle/Numero"
                                        name="calle_numero" required>
                                </div>

                                <div style="flex:1;">
                                    <label><b>Ciudad</b></label>
                                    <input class="w3-input w3-border" type="text" placeholder="Ciudad" name="ciudad"
                                        required>
                                </div>

                            </div>

                            <div style="display: flex; gap: 10px;">

                                <div style="flex:1;">
                                    <label><b>Estado</b></label>
                                    <input class="w3-input w3-border" type="text" placeholder="Estado" name="estado"
                                        required>
                                </div>

                                <div style="flex:1;">
                                    <label><b>Codigo Postal</b></label>
                                    <input class="w3-input w3-border" type="text" placeholder="Codigo Postal"
                                        name="codigo_postal" required>
                                </div>

                                <div style="flex:1;">
                                    <label><b>Pais</b></label>
                                    <input class="w3-input w3-border" type="text" placeholder="Pais" name="pais"
                                        required>
                                </div>
                            </div>

                            <div style="display: flex; gap: 10px;">
                                <div style="flex:1;">
                                    <label><b>Num.Telefono</b></label>
                                    <input class="w3-input w3-border" type="text" placeholder="Num.Telefono"
                                        name="telefono_principal" required>
                                </div>

                                <div style="flex:1;">
                                    <label><b>RFC</b></label>
                                    <input class="w3-input w3-border" type="text" placeholder="Coloca RFC" name="rfc"
                                        required>
                                </div>

                                <div style="flex:1;">
                                    <label><b>CURP</b></label>
                                    <input class="w3-input w3-border" type="text" placeholder="Coloca CURP" name="curp"
                                        required>
                                </div>
                            </div>

                            <div style="display: flex; gap: 10px;">
                                <div style="flex:1;">
                                    <label><b>Num.Credencial Votar</b></label>
                                    <input class="w3-input w3-border" type="text" placeholder="Num.Credencial Votar"
                                        name="num_credencial_votar" required>
                                </div>

                                <div style="flex:1;">
                                    <label><b>Nombre Razon Social</b></label>
                                    <input class="w3-input w3-border" type="text" placeholder="Nombre Razon Social"
                                        name="nombre_razon_social" required>
                                </div>

                                <div style="flex:1;">
                                    <label><b>Tipo Persona</b></label>
                                    <input class="w3-input w3-border" type="text" placeholder="Tipo Persona"
                                        name="tipo_persona" required>
                                </div>
                            </div>

                            <!-- FECHA DE ACTIVACIÓN -->
                            <div class="w3-row-padding">

                                <div class="w3-half">
                                    <label><b>Fecha de Activación</b></label>
                                    <input class="w3-input w3-border" type="date" name="fecha_inicio" required>
                                </div>

                                <div class="w3-half">
                                    <label><b>Fecha de Expiración</b></label>
                                    <input class="w3-input w3-border" type="date" name="fecha_final" required>
                                </div>
                            </div>

                            <button class="w3-button w3-block w3-green w3-section w3-padding" type="submit">Guardar
                                Datos Temporal</button>

                        </div>
                    </form>

                    <div class="w3-center w3-border-top w3-padding-16 w3-light-grey">
                        <button onclick="document.getElementById('id01').style.display='none'" type="button"
                            class="w3-button w3-red">Cancel</button>
                    </div>
                </div>

            </div>

        </div>


        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            const urlCrearProveedor = "../usuarios/crearProveedorTemporal";
        </script>

        <script src="../public/js/crearProceso/crearProceso.js"></script>
        <script src="../public/js/crearProceso/crearProveedorTemporal.js"></script>

</body>

</html>