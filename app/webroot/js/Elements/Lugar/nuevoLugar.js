$(document).ready(function() {

    var $formularioNuevoLugar = $('#frmNuevoLugar'),
        divNuevoLugar = $('#modalNuevoLugar');

    // Guardar nuevo lugar
    divNuevoLugar.find('.btnAceptar').click(function () {

        if ($formularioNuevoLugar.valid()) {

            var codigoCuadriculaUtm = $formularioNuevoLugar.find('.selectCuadriculaUtm').val(),
                nombreLugar = $formularioNuevoLugar.find('.txtNombre').val(),
                municipioId = $formularioNuevoLugar.find('.selectMunicipio').val(),
                coordenadaX = $formularioNuevoLugar.find('.txtCoordenadasUtmX').val(),
                coordenadaY = $formularioNuevoLugar.find('.txtCoordenadasUtmY').val();

            $.ajax({
                url: "/lugar/cargarLugaresSimilares",
                data: {"codigoCuadriculaUtm":codigoCuadriculaUtm, "nombreLugar":nombreLugar, "municipioId":municipioId},
                success: function( lugaresSimilares ) {

                    if(lugaresSimilares.length > 0) {
                        var items = [];
                        items.push( "<p>Existen lugares dados de alta ya en la aplicación cuya cuadrícula UTM y municipio coinciden con el que desea crear:</p>" );
                        items.push( "<br>" );
                        items.push( "<table class='table table-striped table-bordered table-condensed'>" );
                        items.push( "<tr><th>Lugar</th><th>Municipio</th><th>Cuadrícula UTM</th></tr>" );
                        for (var i = 0 ; i < lugaresSimilares.length ; i++) {
                            var lugarSimilar = lugaresSimilares[i];
                            items.push( "<tr><td>"+lugarSimilar.Lugar.nombre+"</td><td>"+ lugarSimilar.Municipio.nombre +"</td><td>"+ lugarSimilar.CuadriculaUtm.codigo +"</td></tr>" );
                        }
                        items.push( "</table>" );
                        items.push( "<br>" );
                        items.push( "<p>¿Está seguro de que desea crear un nuevo lugar?</p>" );

                        bootbox.confirm(items.join( "" ), "Cancelar", "Aceptar", function(result) {
                            if(result) {
                                guardarLugar(divNuevoLugar);
                            }
                        });
                    }
                    else {
                        guardarLugar(divNuevoLugar);
                    }
                },
                dataType: "json"
            });
        }
    });

    // Cancelar creación de nuevo lugar
    divNuevoLugar.find('.btnCancelar').click(function () {
        $('#modalNuevoLugar').modal('hide');
    });

    // Limpiar formulario de nuevo lugar
    divNuevoLugar.find('.btnLimpiar').click(function () {
        limpiarFormularioLugar(divNuevoLugar);
    });

    // Popup ayuda
    divNuevoLugar.find('.badge-info').popover();

    /* INICIO cambio de cuadricula UTM */
    $formularioNuevoLugar.find(".selectCuadriculaUtm").change(function() {

        // Cargar combo de municipios
        loadMunicipioSelect($(this).val());

        // Cargar datos de cuadrícula UTM
        loadCoordenadasUtm($(this).val());
    });
    /* FIN cambio de cuadricula UTM */

    /* INICIO Validación de formulario */
    $formularioNuevoLugar.validate({
        rules: {
            nombre : {
                maxlength: 100
            },
            coordenadaX: {
                number: true,
                maxlength: 6
            },
            coordenadaY: {
                number: true,
                maxlength: 7
            }
        },
        messages: {
            cuadriculaUtmCodigo: {
                required: "Debe seleccionar una cuadrícula UTM."
            },
            municipioId : {
                required: "Debe seleccionar un municipio."
            },
            nombre : {
                required: "Debe introducir un nombre.",
                maxlength: "El nombre no puede tener más de 100 caracteres."
            },
            coordenadaX : {
                number: "La coordenada X debe ser un numero.",
                maxlength: "La coordenada X no puede tener más de 6 cifras."
            },
            coordenadaY : {
                number: "La coordenada Y debe ser un numero.",
                maxlength: "La coordenada Y no puede tener más de 7 cifras."
            }
        },
        errorContainer: "#errorMessagesNuevoLugar",
        errorLabelContainer : "#errorMessagesNuevoLugar ul",
        wrapper: "li",
        invalidHandler: function(event, validator) {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
        },
        onfocusout: false
    });
    /* FIN Validación de formulario */
});

/**
 * Limpia el formulario
 */
function limpiarFormularioLugar() {

    var $formularioNuevoLugar = $('#frmNuevoLugar');

    $formularioNuevoLugar.find("input[type=text], select").val("");

    $formularioNuevoLugar.find(".selectMunicipio").empty();
    $formularioNuevoLugar.find(".selectMunicipio").prop("disabled", true);
}

/**
 * Carga el combo de formularios y lo habilita
 *
 * @param codigoCuadriculaUtm
 */
function loadMunicipioSelect(codigoCuadriculaUtm) {

    var $formularioNuevoLugar = $('#frmNuevoLugar'),
        selectMunicipio = $formularioNuevoLugar.find(".selectMunicipio");

    selectMunicipio.load('/municipio/cargarMunicipios/codigoCuadriculaUtm:' + codigoCuadriculaUtm);

    if(codigoCuadriculaUtm != "") {
        selectMunicipio.prop("disabled", false);
    }
    else {
        selectMunicipio.prop("disabled", true);
    }
}

/**
 * Carga las coordenadas de la cuadricula UTM seleccionada
 *
 * @param codigoCuadriculaUtm
 */
function loadCoordenadasUtm(codigoCuadriculaUtm) {

    var $formularioNuevoLugar = $('#frmNuevoLugar');

    $.ajax({
        url: "/cuadriculaUtm/cargarDatosCoordenadaUtm",
        data: {"codigoCuadriculaUtm":codigoCuadriculaUtm},
        success: function( dataReturn ) {
            $formularioNuevoLugar.find(".txtCoordenadasUtmArea").val(dataReturn.CuadriculaUtm.area);
            $formularioNuevoLugar.find(".txtCoordenadasUtmX").val(dataReturn.CuadriculaUtm.coordenadaX);
            $formularioNuevoLugar.find(".txtCoordenadasUtmY").val(dataReturn.CuadriculaUtm.coordenadaY);
        },
        dataType: "json"
    });
}

function guardarLugar($div)
{
    var $formularioNuevoLugar = $div.find('#frmNuevoLugar'),
        codigoCuadriculaUtm = $formularioNuevoLugar.find('.selectCuadriculaUtm').val(),
        nombreLugar = $formularioNuevoLugar.find('.txtNombre').val(),
        municipioId = $formularioNuevoLugar.find('.selectMunicipio').val(),
        coordenadaX = $formularioNuevoLugar.find('.txtCoordenadasUtmX').val(),
        coordenadaY = $formularioNuevoLugar.find('.txtCoordenadasUtmY').val();

    $.ajax({
        url: "/lugar/guardarLugarAjax",
        data: {
            "codigoCuadriculaUtm":codigoCuadriculaUtm,
            "nombreLugar":nombreLugar,
            "municipioId":municipioId,
            "coordenadaX":coordenadaX,
            "coordenadaY":coordenadaY
        },
        success: function( respuesta ) {

            if(respuesta.status == 0) {

                var textoLugar = [];
                textoLugar.push(respuesta.lugar.Lugar.nombre);
                textoLugar.push(respuesta.lugar.Municipio.nombre);
                textoLugar.push(respuesta.lugar.Comarca.nombre);
                textoLugar.push(respuesta.lugar.CuadriculaUtm.codigo);

                $("#lugar").val(textoLugar.join(', '));
                $("#lugarSeleccionadoContenedor").show();
                $("#lugarSeleccionado").text(textoLugar.join(', '));
                $('#lugarId').val(respuesta.lugar.Lugar.id);

                $('#modalNuevoLugar').modal('hide');
            }
            else {
                if (respuesta.errores) {
                    $div.find('#errorMessagesNuevoLugar ul').html('');

                    for (error in respuesta.errores) {
                        $div.find('#errorMessagesNuevoLugar ul').append('<li>' + error + '</li>');
                    }

                    $('#errorMessagesNuevoLugar').show();

                } else {
                    console.log('Ha ocurrido un error inesperado al guardar el lugar');
                }
            }
        },
        dataType: "json"
    });
}
