'use strict';

$(() =>
{
	$('#frmCursoInsert').formValidation(
	{
		framework: 'bootstrap',
		excluded: [':disabled', ':hidden', ':not(:visible)', '[class*="notValidate"]'],
		live: 'enabled',
		message: '<b style="color: #9d9d9d;">Asegúrese que realmente no necesita este valor.</b>',
		trigger: null,
		fields:
		{
			txtNombre:
			{
				validators:
				{
					notEmpty:
					{
						message: '<b style="color: red;">Este campo es requerido.</b>'
					}
				}
			}
		}
	});
});

function sendFrmCursoInsert() {
	var isValid = null;

	$('#frmCursoInsert').data('formValidation').resetForm();
	$('#frmCursoInsert').data('formValidation').validate();

	isValid = $('#frmCursoInsert').data('formValidation').isValid();

	if(!isValid) {
		new PNotify(
		{
			title : 'No se pudo proceder',
			text : 'Complete y corrija toda la infirmación del formulario.',
			type : 'error'
		});

		return;
	}

	swal(
	{
		title : 'Confirmar operación',
		text : '¿Realmente desea proceder?',
		icon : 'warning',
		buttons : ['No, cancelar.', 'Si, proceder.']
	})
	.then((proceed) =>
	{
		if(proceed)
		{
			//Llamar aquí a la función para mostrar el loader.

			$('#frmCursoInsert')[0].submit();
		}
	});
}