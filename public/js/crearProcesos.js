document.addEventListener("DOMContentLoaded", function () {
    cargarProcesos();

});

function cargarProcesos() {

    if (!idProceso) {
        console.error("No hay ID de proceso");
        return;
    }

    fetch("../../procesosInternos/getProcesosById/" + idProceso)
        .then(res => res.json())
        .then(data => {

            if (data.status !== "success") {
                alert("Error al obtener datos");
                return;
            }

            let documentos = data.data;

            let tbody = document.querySelector(".tabla-archivos tbody");
            tbody.innerHTML = "";

            documentos.forEach(doc => {

                let fila = `
        <tr>
            <td>${doc.nombre_proceso ?? 'Sin nombre'}</td>
            <td>${doc.tipo_proceso ?? 'Sin tipo'}</td>
            <td>${doc.created_at ?? 'Sin fecha'}</td>
            <td>
                <button class="btn-ver" onclick="verDocumento(${doc.id_documento})">
                    <i class="fas fa-eye"></i>
                </button>

                <button class="btn-descargar" onclick="descargarDocumento(${doc.id_documento})">
                    <i class="fas fa-download"></i>
                </button>
            </td>
        </tr>
    `;

                tbody.innerHTML += fila;
            });

            // 🔥 Mostrar nombre del proceso arriba
            document.getElementById("nombreProceso").innerText =
                documentos[0]?.tipo_proceso ?? "Proceso";

        })
        .catch(error => {
            console.error("Error:", error);
        });
        

}
            
function verDocumento(id){
    window.location.href = "../../procesosInternos/crearDocumento/" + id;
}

function descargarDocumento(id){
    window.location.href = "../../portalProcesos/descargarDocumento/" + id;
}
