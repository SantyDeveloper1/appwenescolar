'use strict';

window.toggleEstadoAlumno = function(idAlumno, nombreCompleto) {
  const row = $(`#alumnoRow${idAlumno}`);
  const activo = row.find('.badge-success').length > 0;

  $('#radioActivo').prop('checked', activo);
  $('#radioInactivo').prop('checked', !activo);

  // 🔹 Mostrar el nombre completo en el modal
  $('#nombreAlumnoEstado').text(nombreCompleto);

  $('#estadoAlumnoModal').data('idAlumno', idAlumno).modal('show');
};

// Guardar estado vía AJAX
$('#btnGuardarEstado').on('click', function() {
  const idAlumno = $('#estadoAlumnoModal').data('idAlumno');
  const nuevoEstado = $('input[name="estadoAlumno"]:checked').val();

  if (nuevoEstado === undefined) {
    swal('Atención', 'Debe seleccionar un estado.', 'warning');
    return;
  }

  $.ajax({
    url: `${_urlBase}/alumno/estado/${idAlumno}`,
    method: 'POST',
    data: { estado: nuevoEstado, _method: 'PUT' }, // usamos PUT
    success: function(response) {
      if (response.success) {
        const row = $(`#alumnoRow${idAlumno}`);
        const btnEditar   = row.find('.btn-warning');
        const btnEliminar = row.find('.btn-danger');
        const btnEstado   = row.find('.btn-success i'); // el ícono del botón Estado

        // 🔹 Actualizar badge de estado
        if (nuevoEstado == "1") {
          row.find('td:nth-child(12)').html('<span class="badge badge-success">Activo</span>');

          // Habilitar botones
          btnEditar.prop('disabled', false).removeClass('disabled').attr('title', 'Editar');
          btnEliminar.prop('disabled', false).removeClass('disabled').attr('title', 'Eliminar');

          // Cambiar ícono toggle → ON
          btnEstado.removeClass('fa-toggle-off').addClass('fa-toggle-on');
        } else {
          row.find('td:nth-child(12)').html('<span class="badge badge-danger">Inactivo</span>');

          // Deshabilitar botones
          btnEditar.prop('disabled', true).addClass('disabled').attr('title', 'Inactivo: no se puede editar');
          btnEliminar.prop('disabled', true).addClass('disabled').attr('title', 'Inactivo: no se puede eliminar');

          // Cambiar ícono toggle → OFF
          btnEstado.removeClass('fa-toggle-on').addClass('fa-toggle-off');
        }

        swal('Éxito', 'El estado fue actualizado correctamente.', 'success');
        $('#estadoAlumnoModal').modal('hide');
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

// Función para actualizar mensaje dinámico
function actualizarMensajeEstado() {
    const estado = $('input[name="estadoAlumno"]:checked').val();
    const msgBox = $('#estadoMensaje');

    if (estado == "1") {
        msgBox
          .text("✅ Los alumnos activos pueden acceder a todos los recursos del sistema.")
          .removeClass('danger')
          .addClass('success');
    } else if (estado == "0") {
        msgBox
          .text("⚠️ Los alumnos inactivos no pueden acceder a los recursos del sistema.")
          .removeClass('success')
          .addClass('danger');
    } else {
        msgBox.text("").removeClass('success danger');
    }
}

// Detectar cambios en los radios
$('input[name="estadoAlumno"]').on('change', actualizarMensajeEstado);

// Cuando se abre el modal, refrescar mensaje según estado actual
$('#estadoAlumnoModal').on('shown.bs.modal', actualizarMensajeEstado);