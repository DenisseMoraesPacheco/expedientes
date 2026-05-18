$(document).ready(function () {
    cargarTablaEstudiosFinalizados();
});

function cargarTablaEstudiosFinalizados() {

    $('.tabla-finalizados').DataTable({
        destroy: true,
        processing: true,
        serverSide: false,
        ajax: {
            url: "../../portalProcesos/obtenerEstudiosFinalizados",
            type: "GET",
            dataSrc: function (response) {

                if (!response.success) {
                    alert("No se pudieron cargar los estudios finalizados");
                    return [];
                }

                return response.data;
            }
        },

        columns: [
            {
                data: "nombre_estudio"
            },
            {
                data: "area"
            },
            {
                data: "created_at"
            },
            {
                data: null,
                render: function (data, type, row) {
                    return `
                        <button class="w3-btn w3-purple w3-round w3-block" onclick="verDocumento(${row.id_estudio})">
                            <i class="fas fa-external-link"></i> Ver
                        </button>

                        <button class="w3-btn w3-green w3-round w3-block" onclick="descargarDocumento(${row.id_estudio})">
                        <i class="fas fa-download"></i> Descargar
                        </button>
                    `;
                }
            }
        ],

       
    });
}

function verDocumento(id) {
    window.location.href = "../../portalProcesos/verEstudioMercado/" + id;
}

function descargarDocumento(id) {
    window.location.href = "<?= base_url('portalProcesos/descargarDocumento/') ?>" + id;
}