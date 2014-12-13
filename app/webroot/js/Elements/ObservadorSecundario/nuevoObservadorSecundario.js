$(document).ready(function () {

    var $divNuevoColaborador = $('#divNuevoColaborador'),
        $formularioNuevoColaborador = $divNuevoColaborador.find('#frmNuevoColaborador');

    $formularioNuevoColaborador.validate({
        messages: {
            nombreColaborador : {
                required: "Por favor, introduzca el nombre completo"
            }
        },
        errorContainer: "#errorMessagesNuevoColaborador",
        errorLabelContainer : "#errorMessagesNuevoColaborador ul",
        wrapper: "li"
    });

    // Guardar nuevo lugar
    $divNuevoColaborador.find('.btnAceptar').click(function () {

        if ($formularioNuevoColaborador.valid()) {

            var nombreColaborador = $formularioNuevoColaborador.find('.nombreColaborador').val();

            $.ajax({
                url: "/observadorSecundario/searchSimilarAjax",
                data: {"nombreColaborador":nombreColaborador},
                success: function( respuesta ) {

                    if(respuesta.status == 0) {

                        var observadoresSecundariosSimilares = respuesta.observadoresSecundariosSimilares;

                        if(observadoresSecundariosSimilares.length > 0) {
                            var items = [];
                            items.push( "<p>Existen colaboradores dados de alta ya en la aplicación cuyo nombre coincide con el que deseas crear:</p>" );
                            items.push( "<br>" );
                            items.push( "<table class='table table-striped table-bordered table-condensed'>" );
                            items.push( "<tr><th>Código</th><th>Nombre</th></tr>" );
                            for (var i = 0 ; i < observadoresSecundariosSimilares.length ; i++) {
                                var observadorSecundarioSimilar = observadoresSecundariosSimilares[i].ObservadorSecundario;
                                items.push( "<tr><td>"+observadorSecundarioSimilar.codigo+"</td><td>"+ observadorSecundarioSimilar.nombre +"</td></tr>" );
                            }
                            items.push( "</table>" );
                            items.push( "<br>" );
                            items.push( "<p>¿Estás seguro de que deseas crear un nuevo colaborador?</p>" );

                            bootbox.confirm(items.join( "" ), "Cancelar", "Aceptar", function(result) {
                                if(result) {
                                    guardarColaborador($divNuevoColaborador);
                                }
                            });
                        }
                        else {
                            guardarColaborador($divNuevoColaborador);
                        }

                    } else {
                        if (respuesta.errores) {
                            $div.find('#errorMessagesNuevoColaborador ul').html('');

                            for (error in respuesta.errores) {
                                $div.find('#errorMessagesNuevoColaborador ul').append('<li>' + error + '</li>');
                            }

                            $('#errorMessagesNuevoColaborador').show();

                        } else {
                            console.log('Ha ocurrido un error inesperado al buscar colaboradores similares');
                        }
                    }
                },
                dataType: "json"
            });
        }
    });

    // Popup ayuda
    $divNuevoColaborador.find('.badge-info').popover();
});

/**
 * Guarda un nuevo colaborador
 *
 * @param $div
 */
function guardarColaborador($div)
{
    var $formularioNuevoColaborador = $div.find('#frmNuevoColaborador'),
        nombreColaborador = $formularioNuevoColaborador.find('.nombreColaborador');

    $.ajax({
        url: "/observadorSecundario/addAjax",
        data: {
            "nombreColaborador":nombreColaborador.val()
        },
        success: function( respuesta ) {

            if(respuesta.status == 0) {

                var codigoYNombre = respuesta.observadorSecunadrio.codigo + ' - ' + respuesta.observadorSecunadrio.nombre;
                insertarColaborador(codigoYNombre, respuesta.observadorSecunadrio.id);

                $div.modal('hide');
            }
            else {
                if (respuesta.errores) {
                    $div.find('#errorMessagesNuevoColaborador ul').html('');

                    for (error in respuesta.errores) {
                        $div.find('#errorMessagesNuevoColaborador ul').append('<li>' + error + '</li>');
                    }

                    $('#errorMessagesNuevoColaborador').show();

                } else {
                    console.log('Ha ocurrido un error inesperado al guardar el colaborador');
                }
            }
        },
        dataType: "json"
    });
}

function limpiarNuevoColaborador()
{
    var $divNuevoColaborador = $('#divNuevoColaborador'),
        $formularioNuevoColaborador = $divNuevoColaborador.find('#frmNuevoColaborador');

    $formularioNuevoColaborador.find('.nombreColaborador').val('');
}
