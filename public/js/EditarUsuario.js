$(document).ready(function() {

    $('#form-usuario').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        console.log(formData);

        let id = $('input[name="id_usuario"]').val();

        var $btn = $('#btnGuardar');

        $btn.prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin"></i> Actualizando...');

        $.ajax({
            url: "../../usuarios/actualizar/" + id,
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {

                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Actualizado!',
                        text: response.message,
                        confirmButtonColor: '#800020'
                    }).then(function() {
                        window.location.href ="../../usuarios/listar";
                    });

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
                        confirmButtonColor: '#800020'
                    });

                    $btn.prop('disabled', false)
                        .html('<i class="fas fa-save"></i> Actualizar Usuario');
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al procesar la solicitud',
                    confirmButtonColor: '#800020'
                });

                $btn.prop('disabled', false)
                    .html('<i class="fas fa-save"></i> Actualizar Usuario');
            }
        });
    });

});