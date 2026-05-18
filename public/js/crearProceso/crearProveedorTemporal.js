document.getElementById("formProveedorTemporal").addEventListener("submit", function(e) {
    e.preventDefault();
    
    let formData = new FormData(this);
 
    fetch(urlCrearProveedor, {
    method: "POST",
    body: formData
})


    .then(response => response.json())  
    .then(data => {
        if(data.success) {
            alert(data.message);
            document.getElementById('id01').style.display = 'none';
            this.reset();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error(error);
        alert("Error al guardar");
    });
});