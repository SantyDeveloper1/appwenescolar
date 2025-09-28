'use strict';

// Configurar CSRF para todas las peticiones AJAX
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/**
 * Muestra el modal de edición con los datos del alumno.
 * Esta versión toma los valores actuales de la tabla para que siempre estén sincronizados.
 * @param {string} idDocente 
 */

function showEditModal(idDocente) {
    const row = $(`#docenteRow${idDocente}`);
    
    $('#txtNombre').val(row.find('.tdNombre').text().trim());
    $('#txtAppDocente').val(row.find('.tdApp').text().trim());
    $('#txtApmDocente').val(row.find('.tdApm').text().trim());
    $('#txtTele').val(row.find('.tdTel').text().trim());

    $('#editDocenteModal').data('idDocente', idDocente).modal('show');
}


/**
 * Actualiza los datos de un alumno vía AJAX.
 * @param {string} idDocente 
 */
function updateDocente(idDocente) {
    const formData = new FormData();
    formData.append('txtNombre', $('#txtNombre').val().trim());
    formData.append('txtAppDocente', $('#txtAppDocente').val().trim());
    formData.append('txtApmDocente', $('#txtApmDocente').val().trim());
    formData.append('txtTele', $('#txtTele').val().trim());

    // Imagen (solo si se selecciona un archivo nuevo)
    const file = $('#txtImagen')[0].files[0];
    if (file) {
        formData.append('txtImagen', file);
    }

    const $btn = $('#editDocenteModal .btn-primary');
    $btn.prop('disabled', true);

    $.ajax({
        url: `${_urlBase}/docente/update/${idDocente}`,
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.success) {
                new PNotify({
                    title: 'Éxito',
                    text: response.message || 'Docente actualizado correctamente.',
                    type: 'success'
                });

                // Actualizar fila en la tabla
                const row = $(`#docenteRow${idDocente}`);
                row.find('.tdNombre').text($('#txtNombre').val().trim());
                row.find('.tdApp').text($('#txtAppDocente').val().trim());
                row.find('.tdApm').text($('#txtApmDocente').val().trim());
                row.find('.tdTel').text($('#txtTele').val().trim());

                if (response.newImageUrl) {
                    row.find('.tdImg img').attr('src', response.newImageUrl);
                }

                $('#editDocenteModal').modal('hide');
            } else {
                showErrorMessages(response.errors || ['Error desconocido']);
            }
        },
        error: function (xhr) {
            new PNotify({
                title: 'Error',
                text: 'Hubo un problema al procesar la petición.',
                type: 'error'
            });
        },
        complete: function () {
            $btn.prop('disabled', false);
        }
    });
}

/**
 * Muestra errores en formato PNotify.
 * @param {string[]} errors 
 */
function showErrorMessages(errors) {
    new PNotify({
        title: 'Errores de validación',
        text: errors.join('<br>'),
        type: 'error'
    });
}

// Maneja foco al cerrar modal para evitar warning aria-hidden
$('#editDocenteModal').on('hidden.bs.modal', function () {
    $(this).find(':focus').blur();
});