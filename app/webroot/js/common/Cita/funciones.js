$(document).ready(function() {

    jQuery.validator.addMethod("isdate", function (value, element) {
        var validDate = /^(\d{2})\/(\d{2})\/(\d{4})?$/;
        return validDate.test(value)
    });
    jQuery.validator.addMethod("validarEspecie", function (value, element) {
        return $(".especieId").val() != "";
    }, "Debe seleccionar una especie.");

    jQuery.validator.addMethod("validarLugar", function (value, element) {
        return $("#lugarId").val() != "";
    }, "Debe seleccionar un lugar.");

    jQuery.validator.addMethod("validarObservador", function (value, element) {
        return $("#observadoresSeleccionados").val() != "";
    }, "Debe seleccionar al menos un observador.");

    jQuery.validator.addMethod("validarNumeroAves", function (value, element) {
        var total_numero_aves = 0;
        $(".numero_aves").each(function () {
            total_numero_aves += parseInt($(this).val());
        });
        return total_numero_aves > 0;
    }, "El número de aves debe ser mayor que cero.");

    jQuery.validator.addMethod("dateBeforeOrEqualToday", function (value, element) {

        var fechaAlta = $.datepicker.parseDate("dd/mm/yy", value);
        var now = new Date();

        return (fechaAlta < now || fechaAlta == now);
    }, "Debe introducir una fecha de alta anterior o igual a la fecha de hoy.");
});

/**
 * Resalta los check seleccionados
 *
 * @param $div
 */
function marcarChecksSeleccioandos($div)
{
    $div.find("input[type=checkbox]").click(function() {
        if($(this).is(":checked")) {
            $(this).parent().addClass("text-success");
            $(this).parent().css("font-weight", "bold");
        }
        else {
            $(this).parent().removeClass("text-success");
            $(this).parent().css("font-weight", "normal");
        }
    });
}

function seleccionarFecha($div)
{
    $div.find( "#fechaAlta" ).datepicker({
        maxDate: 0,
        onSelect: function(dateText, inst) {
            $(this).focus();
        }
    });
}

/**
 * Configura la validación del formulario cita
 *
 * @param formCita
 * @param divMensajesError
 */
function validarCita(formCita, divMensajesError)
{
    formCita.validate({
        rules: {
            especie: {
                validarEspecie: true
            },
            "data[Cita][fechaAlta]": {
                required: true,
                date: false,
                isdate: true,
                dateBeforeOrEqualToday: true
            },
            lugar: {
                validarLugar: true
            },
            "data[Cita][observador_principal_id]": {
                required: true
            },
            "data[claseEdadSexo][][4]" : {
                validarNumeroAves: true
            },
            "data[Cita][clase_reproduccion_id]" : {
                required: true
            },
            imagen : {
                extension: "jpg|jpeg|png"
            }
        },
        messages: {
            "data[Cita][fechaAlta]": {
                required: "Debe seleccionar una fecha de alta.",
                isDate: "Debe introducir una fecha de alta con formato correcto (dd/mm/aaaa)."
            },
            "data[Cita][clase_reproduccion_id]" : {
                required: "Debe seleccionar un dato de reproducción."
            },
            imagen : {
                extension: "La imagen debe tener alguna de las siguientes extensiones: jpg, jpeg, png"
            }
        },
        errorContainer: "#" + divMensajesError,
        errorLabelContainer : "#" + divMensajesError + " ul",
        wrapper: "li",
        invalidHandler: function(event, validator) {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
        },
        onfocusout: false
    });
}

/**
 * Guarda una cita
 *
 * @param divCita
 * @param formCita
 */
function guardarCitaSimple(divCita, formCita)
{
    var especieId = divCita.find(".especieId").val(),
        lugarId = divCita.find("#lugarId").val(),
        fechaAlta = divCita.find("#fechaAlta").val(),
        items = [];

    $.ajax({
        url: "/cita/existenCitas",
        data: {"especies":especieId,"lugarId":lugarId,"fechaAlta":fechaAlta},
        dataType: "json",
        success: function( response ) {

            if(response.status == 0 && response.existenCitas) {
                items.push("<h5>");
                items.push( "<img src='/img/icons/fugue-icons-3.5.6/icons/exclamation-red.png' width='34' height='28' alt='alert icon' style='margin-right: 20px;'>" );
                items.push( "Ya existe una cita creada para la misma especie, fecha y lugar." );
                items.push( "</h5>" );

                bootbox.alert(items.join( "" ), "Aceptar");
            } else if (response.status == 1) {
                console.log('error comprobando si existen citas iguales');
            } else {
                $.ajax({
                    url: "/especie/esRareza",
                    data: {"especieId":especieId},
                    dataType: "json",
                    success: function( indEsRareza ) {

                        if (indEsRareza == 1) {
                            items.push("<h5>");
                            items.push( "<img src='/img/icons/fugue-icons-3.5.6/icons/exclamation.png' width='34' height='28' alt='alert icon' style='margin-right: 20px;'>" );
                            items.push( "La especie que has seleccionado es una <b>RAREZA NACIONAL</b>." );
                            items.push( "</h5>" );
                            items.push( "<br>" );
                            items.push( "Para homologar esta cita debes seguir " );
                            items.push( "<a href='http://www.seo.org/2012/01/25/%C2%BFque-hacer-si-observamos-una-rareza/' target='_blank'>estas instrucciones</a>." );

                            bootbox.confirm(items.join( "" ), "Cancelar", "Continuar", function(result) {
                                if(result) {
                                    formCita.submit();
                                }
                            });
                        } else if(indEsRareza == 2) {
                            items.push("<h5>");
                            items.push( "<img src='/img/icons/fugue-icons-3.5.6/icons/exclamation.png' width='34' height='28' alt='alert icon' style='margin-right: 20px;'>" );
                            items.push( "La especie que has seleccionado es una <b>RAREZA LOCAL</b>." );
                            items.push( "</h5>" );
                            items.push( "<br>" );
                            items.push( "Debido a la importancia de la cita, por favor, <b>envíanos un correo electrónico a " );
                            items.push( "<a href='mailto:anuario@sao.albacete.org' target='_blank'>anuario@sao.albacete.org</a></b>, " );
                            items.push( "describíendo con detalle el avistamiento y ampliando toda la información posible.");
                            items.push( "<br>" );
                            items.push( "<b>Es importante que adjuntes fotografías</b> aunque sean de mala calidad para apoyar la identificación de la especie.");

                            bootbox.confirm(items.join( "" ), "Cancelar", "Continuar", function(result) {
                                if(result) {
                                    formCita.submit();
                                }
                            });
                        } else {
                            formCita.submit();
                        }
                    }
                });
            }
        }
    });
}