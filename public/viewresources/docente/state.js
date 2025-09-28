'use strict';

window.toggleEstadoDocente = function(idDocente, nombreCompleto) {
  const row = $(`#docenteRow${idDocente}`);
  const activo = row.find('.badge-success').length > 0;

  $('#radioActivo').prop('checked', activo);
  $('#radioInactivo').prop('checked', !activo);

  // 🔹 Mostrar el nombre completo en el modal
  $('#nombreDocenteEstado').text(nombreCompleto);

  $('#estadoDocenteModal').data('idDocente', idDocente).modal('show');
};

// Guardar estado vía AJAX
$('#btnGuardarEstado').on('click', function() {
  const idDocente = $('#estadoDocenteModal').data('idDocente');
  const nuevoEstado = $('input[name="estadoDocente"]:checked').val();

  if (nuevoEstado === undefined) {
    swal('Atención', 'Debe seleccionar un estado.', 'warning');
    return;
  }

  $.ajax({
    url: `${_urlBase}/docente/estado/${idDocente}`,
    method: 'PUT',   // ✅ usamos PUT
    data: { 
      estado: nuevoEstado, 
      _token: $('meta[name="csrf-token"]').attr('content')
    },
    success: function(response) {
      if (response.success) {
        const row        = $(`#docenteRow${idDocente}`);
        const btnEditar  = row.find('.btn-warning');
        const btnEliminar= row.find('.btn-danger');
        const iconEstado = $(`#iconEstado${idDocente}`);

        // 🔹 Actualizar badge de estado
        if (nuevoEstado == "1") {
          row.find('td:nth-child(14)').html('<span class="badge badge-success">Activo</span>');

          // Habilitar botones
          btnEditar.prop('disabled', false).attr('title', 'Editar');
          btnEliminar.prop('disabled', false).attr('title', 'Eliminar');

          // Cambiar ícono toggle → ON
          iconEstado.removeClass('fa-toggle-off').addClass('fa-toggle-on');
        } else {
          row.find('td:nth-child(14)').html('<span class="badge badge-danger">Inactivo</span>');

          // Deshabilitar botones
          btnEditar.prop('disabled', true).attr('title', 'Inactivo: no se puede editar');
          btnEliminar.prop('disabled', true).attr('title', 'Inactivo: no se puede eliminar');

          // Cambiar ícono toggle → OFF
          iconEstado.removeClass('fa-toggle-on').addClass('fa-toggle-off');
        }

        swal('Éxito', 'El estado fue actualizado correctamente.', 'success');
        $('#estadoDocenteModal').modal('hide');
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
function actualizarMensajeEstadoDocente() {
    const estado = $('input[name="estadoDocente"]:checked').val();
    const msgBox = $('#estadoMensaje');

    if (estado == "1") {
        msgBox
          .text("✅ Los docentes activos pueden acceder a todos los recursos del sistema.")
          .removeClass('danger')
          .addClass('success');
    } else if (estado == "0") {
        msgBox
          .text("⚠️ Los docentes inactivos no pueden acceder a los recursos del sistema.")
          .removeClass('success')
          .addClass('danger');
    } else {
        msgBox.text("").removeClass('success danger');
    }
}

// Detectar cambios en los radios
$('input[name="estadoDocente"]').on('change', actualizarMensajeEstadoDocente);

// Cuando se abre el modal, refrescar mensaje según estado actual
$('#estadoDocenteModal').on('shown.bs.modal', actualizarMensajeEstadoDocente);
