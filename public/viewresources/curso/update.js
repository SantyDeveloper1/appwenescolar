'use strict';

// CSRF para AJAX
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/**
 * Muestra el modal de edición con los datos del curso.
 * Similar a alumno, pero aquí solo necesitamos el nombre.
 * @param {string} idCurso
 */
function showEditModalCurso(idCurso) {
    const row = $(`#cursoRow${idCurso}`);
    const nombre = row.find('.tdNombre').text().trim();

    $('#txtNombre').val(nombre);
    $('#editCursoModal').data('idCurso', idCurso).modal('show');
}

/**
 * Actualiza los datos de un curso vía AJAX.
 * Igual que alumno, actualiza la tabla sin recargar.
 */
function updateCurso() {
    const idCurso = $('#editCursoModal').data('idCurso');
    const data = {
        txtNombre: $('#txtNombre').val().trim()
    };

    if (!data.txtNombre) {
        showErrorMessages(['El campo "Nombre" es obligatorio.']);
        return;
    }

    const $btn = $('#editCursoModal .btn-primary');
    $btn.prop('disabled', true);

    $.ajax({
        url: `${_urlBase}/curso/update/${idCurso}`,
        method: 'POST',
        data: data,
        success: function (response) {
            if (response.success) {
                new PNotify({
                    title: 'Éxito',
                    text: response.message || 'Curso actualizado correctamente.',
                    type: 'success'
                });

                // Actualiza el nombre en la tabla directamente
                const row = $(`#cursoRow${idCurso}`);
                row.find('.tdNombre').text(data.txtNombre);

                $('#editCursoModal').modal('hide');
            } else {
                showErrorMessages(response.errors || ['Error desconocido']);
            }
        },
        error: function (xhr) {
            if (xhr.status === 422 && xhr.responseJSON?.errors) {
                showErrorMessages(xhr.responseJSON.errors);
            } else {
                new PNotify({
                    title: 'Error',
                    text: 'Hubo un problema al procesar la petición.',
                    type: 'error'
                });
            }
        },
        complete: function () {
            $btn.prop('disabled', false);
        }
    });
}

/**
 * Muestra errores en PNotify.
 */
function showErrorMessages(errors) {
    new PNotify({
        title: 'Errores de validación',
        text: errors.join('<br>'),
        type: 'error'
    });
}

// Limpia foco al cerrar modal
$('#editCursoModal').on('hidden.bs.modal', function () {
    $(this).find(':focus').blur();
});