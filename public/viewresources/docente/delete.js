'use strict';

// CSRF (si ya lo tienes en otro archivo global, puedes quitar esto)
$.ajaxSetup({
  headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

// Función global para eliminar
window.deleteDocente = function(idDocente) {
  swal({
    title: 'Confirmar operación',
    text: '¿Realmente desea eliminar este Docente?',
    icon: 'warning',
    buttons: ['No, cancelar', 'Sí, eliminar'],
    dangerMode: true
  }).then(function(willDelete) {
    if (!willDelete) return;

    const $btn = $(`#docenteRow${idDocente} .btn-danger`);
    $btn.prop('disabled', true);

    $.ajax({
      url: `${_urlBase}/docente/delete/${idDocente}`,
      type: 'POST',
      data: { _method: 'DELETE' }, // Laravel entiende DELETE con override
      success: function(response) {
        const ok = response && (response.status === 'success' || response.success === true);
        if (ok) {
          // Recuperamos la instancia ya inicializada de DataTable
          let tabla = $("#example1").DataTable();

          // 🔹 Aquí estaba el error: debe ser #docenteRow (no #DocenteRow)
          tabla.row($(`#docenteRow${idDocente}`)).remove().draw();

          swal('Eliminado', 'El docente fue eliminado correctamente.', 'success');
        } else {
          swal('Error', 'No se pudo eliminar el registro.', 'error');
        }
      },
      error: function(xhr) {
        swal('Error', 'Hubo un problema al intentar eliminar.', 'error');
        console.error(xhr);
      },
      complete: function() {
        $btn.prop('disabled', false);
      }
    });
  });
};
