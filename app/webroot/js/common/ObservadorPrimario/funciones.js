function seleccionarObservador($div)
{
    $div.find("#observador").autocomplete({
        source: function( request, response ) {
            $.getJSON( "/observadorPrincipal/obtenerObservadoresPrincipales", {
                    term: request.term
                },
                response );
        },
        minLength: 3,
        select: function( event, ui ) {
            if(ui.item) {
                this.value = ui.item.value;
                $div.find("#observadorSeleccionadoTexto").text(ui.item.value);
                $div.find("#observadorSeleccionado").val(ui.item.id);
            }
            return false;
        }
    });
}