$(document).ready(function () {

    var $divEditarEspecie = $('#modalEditarEspecie');

    // Seleccionar especie
    seleccionarEspecie($divEditarEspecie);

    // Limpiar especie
    $divEditarEspecie.find(".btnVaciarEspecie").click(function() {
        limpiarEspecie($divEditarEspecie);
    });

    // Seleccionar subespecie
    seleccionarSubespecie($divEditarEspecie);

    // Gestioanr tabla de clases de edad/sexo */
    gestionarTablaNumeroAves($divEditarEspecie);

    // Resaltar checks seleccioandos
    marcarChecksSeleccioandos($divEditarEspecie);

    $divEditarEspecie.find('.btnAceptar').click(function() {
        validarFormularioEspecie($divEditarEspecie, 'errorMessagesEditarEspecie', $(this).attr('data-fila'));
    });

    // Popup ayuda
    $divEditarEspecie.find('.badge-info').popover();
});

/**
 * Muestra el popup de edición de especie cargando los datos rellenados hasta el momento
 * @param numeroFila
 */
function editarFilaEspecie(numeroFila)
{
    $div = $('#modalEditarEspecie');

    $div.find('.especieId').val($('input[name="data[Especie][' + numeroFila + '][especie_id]"]').val());
    $div.find('.especie').val($('input[name="data[Especie][' + numeroFila + '][especie]"]').val());
    $div.find(".especieSeleccionadaContenedor").show();
    $div.find(".especieSeleccionada").text($div.find('.especie').val());

    $div.find('.subespecie').val($('input[name="data[Especie][' + numeroFila + '][subespecie]"]').val());
    $div.find('.subespecie').attr('disabled', false);
    $div.find(".subespecieSeleccionadaContenedor").show();
    $div.find(".subespecieSeleccionada").text($div.find('.subespecie').val());

    $div.find('.datosReproduccion').val($('input[name="data[Especie][' + numeroFila + '][clase_reproduccion_id]"]').val());
    $div.find('.totalNumeroAves').val($('input[name="data[Especie][' + numeroFila + '][cantidad]"]').val());
    $div.find(".numeroTotalAvesDiv").show();
    $div.find(".numeroTotalAvesTexto").text($div.find('.totalNumeroAves').val());

    $div.find('.numero_aves').each(function(){
        $(this).val(0);
    });
    $('input[name^="data[Especie][' + numeroFila + '][claseEdadSexo]"]').each(function(){
        $div.find('input[data-id="' + $(this).attr('data-id') + '"]').val($(this).val());
    });

    $div.find('.indHabitatRaro').prop('checked', ($('input[name="data[Especie][' + numeroFila + '][indHabitatRaro]"]').val() != "0"));
    $div.find('.indCriaHabitatRaro').prop('checked', $('input[name="data[Especie][' + numeroFila + '][indCriaHabitatRaro]"]').val() != "0");
    $div.find('.indHerido').prop('checked', $('input[name="data[Especie][' + numeroFila + '][indHerido]"]').val() != "0");
    $div.find('.indComportamiento').prop('checked', $('input[name="data[Especie][' + numeroFila + '][indComportamiento]"]').val() != "0");

    $div.find('.observaciones').val($('input[name="data[Especie][' + numeroFila + '][observaciones]"]').val());

    // Resaltar los checks seleccioandos
    $div.find("input[type=checkbox]").each(function() {
        if($(this).is(":checked")) {
            $(this).parent().addClass("text-success");
            $(this).parent().css("font-weight", "bold");
        }
        else {
            $(this).parent().removeClass("text-success");
            $(this).parent().css("font-weight", "normal");
        }
    });

    // Añadimos el numero de fila al botón aceptar
    $div.find('.btnAceptar').attr('data-fila', numeroFila);

    $div.modal();
}
