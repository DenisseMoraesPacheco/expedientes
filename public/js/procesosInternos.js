document.addEventListener("DOMContentLoaded", function () {
    cargarProcesos();
});

function escapeHtml(text) {
    if (text === null || text === undefined) return '';

    return text
        .toString()
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function cargarProcesos() {

    fetch('../procesosInternos/getProcesos')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {

            if (data.status === 'success' && Array.isArray(data.data)) {

                const procesos = data.data;

                let html = '<div class="procesos-grid">';

                procesos.forEach(proceso => {

                    html += `
                        <div class="proceso-card">
                            <div class="card-header">
                                <h3>${escapeHtml(proceso.tipo_proceso)}</h3>
                                <span class="card-clave ${escapeHtml(proceso.alias)}">
                                    ${escapeHtml(proceso.created_at)}
                                </span>
                            </div>
                            <div class="card-body ">
                                <div class="proceso-descripcion">
                                    ${escapeHtml(proceso.descripcion ?? 'Sin descripción')}
                                </div>
                                <div class="card-actions">
                                    <button class="w3-btn w3-blue w3-round" onclick="crearProcesos(${proceso.id_proceso})">
                                        <i class=" fas fa-eye"></i> Crear proceso
                                    </button>
                                    <button class="w3-btn w3-green w3-round" onclick="abrirProceso(${proceso.id_proceso})">
                                        <i class=" fa fa-book"></i> Ver procesos
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                });

                html += '</div>';

                document.getElementById('contenedorTarjetas').innerHTML = html;

                Swal.close();

            } else {
                throw new Error('Formato de datos inválido');
            }
        })
        .catch(error => {
            console.error("Error:", error);

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudieron cargar los procesos: ' + error.message,
                confirmButtonText: 'Entendido'
            });

            document.getElementById('contenedorTarjetas').innerHTML = `
                <div class="empty-table">
                    <i class="fas fa-exclamation-triangle"></i> Error al cargar los procesos
                </div>
            `;
        });
}

// ✅ FUERA de la función
function abrirProceso(id){
    window.location.href = "../procesosInternos/verProcesosFinalizados/" + id;
}
function crearProcesos(id){
    window.location.href = "../procesosInternos/crearProcesos/" + id;
}