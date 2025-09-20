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
 * @param {string} idAlumno 
 */
function showEditModal(idAlumno) {
    const row = $(`#alumnoRow${idAlumno}`);
    
    // Tomar los valores actualizados de la tabla
    const nombre = row.find('.tdNombre').text().trim();
    const app = row.find('.tdApp').text().trim();
    const apm = row.find('.tdApm').text().trim();
    const tele = row.find('.tdTel').text().trim();

    $('#txtNombre').val(nombre);
    $('#txtAppAlumno').val(app);
    $('#txtApmAlumno').val(apm);
    $('#txtTele').val(tele);

    $('#editAlumnoModal').data('idAlumno', idAlumno).modal('show');
}

/**
 * Actualiza los datos de un alumno vía AJAX.
 * @param {string} idAlumno 
 */
function updateAlumno(idAlumno) {
    const data = {
        txtNombre: $('#txtNombre').val().trim(),
        txtAppAlumno: $('#txtAppAlumno').val().trim(),
        txtApmAlumno: $('#txtApmAlumno').val().trim(),
        txtTele: $('#txtTele').val().trim()
    };

    // Validación simple antes de enviar
    const missing = Object.entries(data).filter(([k, v]) => !v).map(([k]) => k);
    if (missing.length) {
        showErrorMessages(['Todos los campos son obligatorios']);
        return;
    }

    const $btn = $('#editAlumnoModal .btn-primary');
    $btn.prop('disabled', true);

    $.ajax({
        url: `${_urlBase}/alumno/update/${idAlumno}`,
        method: 'POST',
        data: data,
        success: function (response) {
            if (response.success) {
                new PNotify({
                    title: 'Éxito',
                    text: response.message || 'Alumno actualizado correctamente.',
                    type: 'success'
                });

                // Actualiza los datos en la tabla sin recargar
                const row = $(`#alumnoRow${idAlumno}`);
                row.find('.tdNombre').text(data.txtNombre);
                row.find('.tdApp').text(data.txtAppAlumno);
                row.find('.tdApm').text(data.txtApmAlumno);
                row.find('.tdTel').text(data.txtTele);

                // Solo oculta modal, no resetea formulario
                $('#editAlumnoModal').modal('hide');
            } else {
                showErrorMessages(response.errors || ['Error desconocido']);
            }
        },
        error: function (xhr) {
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                showErrorMessages(xhr.responseJSON.errors);
            } else {
                new PNotify({
                    title: 'Error',
                    text: 'Hubo un problema al procesar la petición.',
                    type: 'error'
                });
            }
        },
        complete: function() {
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
$('#editAlumnoModal').on('hidden.bs.modal', function () {
    $(this).find(':focus').blur();
});