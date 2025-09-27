'use strict';

// Abrir modal para cambiar estado
window.toggleEstadoCurso = function(idCurso, nombreCompleto) {
    const row = $(`#cursoRow${idCurso}`);
    const activo = row.find('.fa-toggle-on').length > 0;

    $('#radioActivo').prop('checked', activo);
    $('#radioInactivo').prop('checked', !activo);

    // Mostrar nombre del curso en modal
    $('#nombreCursoEstado').text(nombreCompleto);

    // Guardar idCurso en el modal
    $('#estadoCursoModal').data('idCurso', idCurso).modal('show');
};

// Guardar estado vía AJAX
$('#btnGuardarEstado').on('click', function() {
    const idCurso = $('#estadoCursoModal').data('idCurso');
    const nuevoEstado = $('input[name="estadoCurso"]:checked').val();

    if (nuevoEstado === undefined) {
        swal('Atención', 'Debe seleccionar un estado.', 'warning');
        return;
    }

    $.ajax({
        url: `${_urlBase}/curso/estado/${idCurso}`,
        method: 'POST',
        data: { estado: nuevoEstado, _method: 'PUT' },
        success: function(response) {
            if (response.success) {
                const row = $(`#cursoRow${idCurso}`);
                const tdEstado = row.find('td:eq(1)').next(); // Columna Estado
                const btnEditar   = row.find('.btn-warning');
                const btnEliminar = row.find('.btn-danger');
                const btnToggle   = row.find('.btn-success i');

                if (nuevoEstado == "1") {
                    tdEstado.html('<span class="badge badge-success">Activo</span>');
                    btnEditar.prop('disabled', false).removeClass('disabled').attr('title', 'Editar');
                    btnEliminar.prop('disabled', false).removeClass('disabled').attr('title', 'Eliminar');
                    btnToggle.removeClass('fa-toggle-off').addClass('fa-toggle-on');
                } else {
                    tdEstado.html('<span class="badge badge-danger">Inactivo</span>');
                    btnEditar.prop('disabled', true).addClass('disabled').attr('title', 'Inactivo: no se puede editar');
                    btnEliminar.prop('disabled', true).addClass('disabled').attr('title', 'Inactivo: no se puede eliminar');
                    btnToggle.removeClass('fa-toggle-on').addClass('fa-toggle-off');
                }

                swal('Éxito', 'El estado fue actualizado correctamente.', 'success');
                $('#estadoCursoModal').modal('hide');

                // Actualizar mensaje dinámico si el modal sigue abierto
                actualizarMensajeEstado();
            } else {
                swal('Error', response.message || 'No se pudo actualizar el estado.', 'error');
            }
        },
        error: function(xhr) {
            console.error(xhr);
            swal('Error', 'Hubo un problema al intentar cambiar el estado.', 'error');
        }
    });
});

// Función para actualizar mensaje dinámico en modal
function actualizarMensajeEstado() {
    const estado = $('input[name="estadoCurso"]:checked').val();
    const msgBox = $('#estadoMensaje');

    if (estado == "1") {
        msgBox.text("✅ Los cursos activos pueden acceder a todos los recursos del sistema.")
              .removeClass('text-danger').addClass('text-success');
    } else if (estado == "0") {
        msgBox.text("⚠️ Los cursos inactivos no pueden acceder a los recursos del sistema.")
              .removeClass('text-success').addClass('text-danger');
    } else {
        msgBox.text("").removeClass('text-success text-danger');
    }
}

// Detectar cambios en los radios
$('input[name="estadoCurso"]').on('change', actualizarMensajeEstado);

// Refrescar mensaje cuando se abre el modal
$('#estadoCursoModal').on('shown.bs.modal', actualizarMensajeEstado);