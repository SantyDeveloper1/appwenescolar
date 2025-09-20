'use strict';

// CSRF (si ya lo tienes en otro archivo, puedes quitar esto)
$.ajaxSetup({
  headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

// Hacemos global la función para el onclick inline
window.deleteAlumno = function(idAlumno) {
  swal({
    title: 'Confirmar operación',
    text: '¿Realmente desea eliminar este alumno?',
    icon: 'warning',
    buttons: ['No, cancelar', 'Sí, eliminar'],
    dangerMode: true
  }).then(function(willDelete) {
    if (!willDelete) return;

    const $btn = $(`#alumnoRow${idAlumno} .btn-danger`);
    $btn.prop('disabled', true);

    $.ajax({
      url: `${_urlBase}/alumno/delete/${idAlumno}`,
      type: 'POST',
      data: { _method: 'DELETE' }, // Laravel requiere este override
      success: function(response) {
        const ok = response && (response.status === 'success' || response.success === true);
        if (ok) {
          // Recuperamos la instancia ya inicializada de DataTable
          let tabla = $("#example1").DataTable();

          // Eliminamos la fila desde DataTables
          tabla.row($(`#alumnoRow${idAlumno}`)).remove().draw();

          swal('Eliminado', 'El alumno fue eliminado correctamente.', 'success');
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