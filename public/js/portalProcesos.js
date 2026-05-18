$(document).ready(function() {
    cargarProcesos();

    function cargarProcesos() {
        $.ajax({
            url: 'portalProcesos/obtenerProcesos',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    renderizarTarjetas(response.data);
                } else {
                    console.error('Error al cargar procesos');
                }
            },
            error: function() {
                console.error('Error en la petición AJAX');
            }
        });
    }

    function renderizarTarjetas(procesos) {
        const grupos = {
            'AD': { nombre: 'ADJUDICACIÓN DIRECTA', clave: 'AD', procesos: [] },
            'LP': { nombre: 'LICITACIÓN PÚBLICA', clave: 'LP', procesos: [] },
            'IR': { nombre: 'INVITACIÓN RESTRINGIDA', clave: 'IR', procesos: [] }
        };

        procesos.forEach(proceso => {
            if (grupos[proceso.clave]) {
                grupos[proceso.clave].procesos.push(proceso);
            }
        });

        let html = '<div class="procesos-grid">';

        for (const [clave, grupo] of Object.entries(grupos)) {
            const totalProcesos = grupo.procesos.length;
            const primerProceso = grupo.procesos[0] || null;
            const descripcion = primerProceso && primerProceso.descripcion 
                ? primerProceso.descripcion 
                : 'No hay procesos registrados';

            html += `
                <div class="proceso-card" data-clave="${clave}">
                    <div class="card-header">
                        <h3>${grupo.nombre}</h3>
                        <span class="card-clave ${clave.toLowerCase()}">LP: ${clave}</span>
                    </div>
                    <div class="card-body">
                        <div class="proceso-descripcion">
                            ${descripcion}
                        </div>
                        <div class="card-actions">
                            <button class="btn-ver" onclick="verProcesosPorClave('${clave}')">
                                <i class="fas fa-eye "></i> Ver procesos (${totalProcesos})
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }

        html += '</div>';
        $('#contenedorTarjetas').html(html);
    }

   function verProcesos(clave) {
    let url = '';
    let titulo = '';
    
    switch(clave) {
        case 'AD':
            url = '../procesosInternos/adjudicacionDirecta';
            titulo = 'ADJUDICACION DIRECTA';
            break;
        case 'LP':
            url = '../procesosInternos/licitacionPublica';
            titulo = 'LICITACION PUBLICA';
            break;
        case 'IR':
            url = '../procesosInternos/invitacionRestringida';
            titulo = 'INVITACION RESTRINGIDA';
            break;
    }
    
    window.location.href = url;
}
        });
    
