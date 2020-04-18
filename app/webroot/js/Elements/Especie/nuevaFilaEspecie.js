$(document).ready(function () {

    var $divNuevaEspecie = $('#modalNuevaEspecie');

    // Seleccionar especie
    seleccionarEspecie($divNuevaEspecie);

    // Limpiar especie
    $divNuevaEspecie.find(".btnVaciarEspecie").click(function() {
        limpiarEspecie($divNuevaEspecie);
    });

    // Seleccionar subespecie
    seleccionarSubespecie($divNuevaEspecie);

    // Gestioanr tabla de clases de edad/sexo
    gestionarTablaNumeroAves($divNuevaEspecie);

    // Resaltar checks seleccioandos
    marcarChecksSeleccioandos($divNuevaEspecie);

    $divNuevaEspecie.find('.btnAceptar').click(function() {
        validarFormularioEspecie($divNuevaEspecie, 'errorMessagesNuevaEspecie');
    });

    // Popup ayuda
    $divNuevaEspecie.find('.badge-info').popover();

	// Rich editor para las observaciones
	$divNuevaEspecie.find('.observaciones').summernote({
		toolbar: [
			['style', ['style']],
			['font', ['bold', 'underline', 'clear']],
			// ['fontname', ['fontname']],
			['color', ['color']],
			['para', ['ul', 'ol'/*, 'paragraph'*/]],
			// ['table', ['table']],
			['insert', ['link'/*, 'picture'*/]],
			// ['view', ['fullscreen', 'codeview']],
		],
		lang: 'es-ES', // default: 'en-US'
		dialogsInBody: false,
		dialogsFade: true  // Add fade effect on dialogs
	});
	$divNuevaEspecie.find('.note-modal').remove()
});

/**
 * Limpia el formulario de especie
 */
function limpiarFormularioEspecie()
{
    var $divNuevaEspecie = $('#modalNuevaEspecie');

    limpiarEspecie($divNuevaEspecie);

    $divNuevaEspecie.find("input[type=checkbox]").each(function() {
        $(this).prop('checked', false);
        $(this).parent().removeClass("text-success");
        $(this).parent().css("font-weight", "normal");
    });

    $divNuevaEspecie.find(".numero_aves").each(function() {
        $(this).val(0);
    });

	$divNuevaEspecie.find('.observaciones').val('');
	$divNuevaEspecie.find('.observaciones').summernote('reset');
	$divNuevaEspecie.find('.note-modal').remove();

    $divNuevaEspecie.find('.datosReproduccion').val(11);

    $divNuevaEspecie.find(".totalNumeroAves").val(0);

    $divNuevaEspecie.find(".numeroTotalAvesDiv").hide();
    $divNuevaEspecie.find(".numeroTotalAvesTexto").text(0);
}
