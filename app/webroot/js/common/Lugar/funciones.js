/**
 * Gestiona el comportamiento de la tabla de número de aves
 *
 * @param $div
 */
function gestionarTablaNumeroAves($div)
{
    var $textoNumeroAves = $div.find(".numero_aves");

    $textoNumeroAves.focus(function() {
        if($(this).val() == 0) {
            $(this).val("");
        }
    });
    $textoNumeroAves.blur(function() {

        if($(this).val() == "" || $(this).val() < 0) {
            $(this).val(0);
        }

        var totalAves = 0;
        $div.find(".numero_aves").each(function(){
            if(parseInt($(this).val()) > 0) {
                totalAves += parseInt($(this).val());
            }
        });

        $div.find(".totalNumeroAves").val(totalAves);

        $div.find(".numeroTotalAvesDiv").show();
        $div.find(".numeroTotalAvesTexto").text(totalAves);
    });

    $('.numero_aves').keydown(function(e) {

        // Admite [0-9], backspace, tab, delete, flechas
        key = e.charCode || e.keyCode || 0;

        if (!(key == 8 ||
            key == 9 ||
            key == 46 ||
            (key >= 37 && key <= 40) ||
            (key >= 48 && key <= 57) ||
            (key >= 96 && key <= 105))) {
            e.preventDefault();
        }
    });
}

function seleccionarLugar($div)
{
    $div.find("#lugar").autocomplete({
        source: function (request, response) {
            $.getJSON("/lugar/buscar_lugares", {
                    term: request.term
                },
                response);
        },
        minLength: 3,
        select: function (event, ui) {
            if (ui.item) {
                this.value = ui.item.value;
                $div.find("#lugarSeleccionadoContenedor").show();
                $div.find("#lugarSeleccionado").text(ui.item.value);
                $div.find("#lugarId").val(ui.item.id);
            }
            return false;
        }
    });
}

function vaciarLugarSeleccioando($div)
{
    $div.find("#lugarId").val("");
    $div.find("#lugarSeleccionado").text("");
    $div.find("#lugar").val("");
    $div.find('#lugarSeleccionadoContenedor').hide();
}