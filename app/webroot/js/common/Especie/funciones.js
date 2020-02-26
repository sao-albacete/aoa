/**
 * Limpia los datos de la especie seleccioanda
 *
 * @param $div
 */
function limpiarEspecie($div)
{
    $div.find(".especieId").val("");
    $div.find(".especieSeleccionada").text("");
    $div.find(".especie").val("");
    var $subespecie = $div.find(".subespecie");
    $subespecie.val("");
    $subespecie.prop('disabled', true);
    $div.find('.especieSeleccionadaContenedor').hide();
    $div.find('.subespecieSeleccionadaContenedor').hide();
}

/**
 * Selecciona una especie
 *
 * @param $div
 */
function seleccionarEspecie($div)
{
    $div.find(".especie").autocomplete({
        source: function( request, response ) {
            $.getJSON( "/especie/buscar_especies", {
                    term: request.term
                },
                response );
        },
        minLength: 3,
        select: function( event, ui ) {
            this.value = ui.item.value;
            $div.find(".especieSeleccionadaContenedor").show();
            $div.find(".especieSeleccionada").text(ui.item.value);
            $div.find(".especieId").val(ui.item.id);
            $div.find('.subespecie').prop('disabled', false);
            return false;
        }
    });
}

/**
 * Selecciona una subespecie
 *
 * @param $div
 */
function seleccionarSubespecie($div)
{
    $div.find(".subespecie").autocomplete({
        source: function( request, response ) {
            $.getJSON( "/especie/buscar_subespecies", {
                    especieId: $div.find(".especieId").val()
                },
                response );
        },
        minLength: 0,
        select: function( event, ui ) {
            this.value = ui.item.value;
            $div.find(".subespecieSeleccionadaContenedor").show();
            $div.find(".subespecieSeleccionada").text(ui.item.value);
            return false;
        }
    }).focus(function(){
        $(this).autocomplete("search");
    });
}