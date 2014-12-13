/**
 *
 */

$(document).ready(function () {

    var $divNuevaCitaMultiple = $('#divNuevaCitaMultiple');

    /**
     * CRITERIOS GENERALES
     */

    // Seleccionar fecha
    seleccionarFecha($divNuevaCitaMultiple);

    // Seleccionar lugar
    seleccionarLugar($divNuevaCitaMultiple);

    // Vaciar lugar
    $divNuevaCitaMultiple.find(".btnVaciarLugar").click(function () {
        vaciarLugarSeleccioando($divNuevaCitaMultiple)
    });

    // Nuevo lugar
    $divNuevaCitaMultiple.find(".btnNuevoLugar").click(function() {
        limpiarFormularioLugar();
        $('#modalNuevoLugar').modal();
    });

    // Seleccionar observador
    seleccionarObservador($divNuevaCitaMultiple);

    // Nuevo colaborador
    $divNuevaCitaMultiple.find(".btnNuevoColaborador").click(function() {
        limpiarNuevoColaborador();
        $('#divNuevoColaborador').modal();
    });

    // Seleccionar colaborador
    seleccionarColaborador($divNuevaCitaMultiple);

    // Limpiar colaboradores seleccioandos
    $divNuevaCitaMultiple.find("#btnVaciarColaboradores").click(function () {
        limpiarColaboradores($divNuevaCitaMultiple);
    });

    // Popup ayuda
    $divNuevaCitaMultiple.find('.badge-info').popover();

    // Insertar especie
    $divNuevaCitaMultiple.find("#btnInsertarEspecie").click(function() {
        limpiarFormularioEspecie();
        $('#modalNuevaEspecie').modal();
    });


    /* INICIO Validación de formulario */
    jQuery.validator.addMethod("isdate", function (value, element) {
        var validDate = /^(\d{2})\/(\d{2})\/(\d{4})?$/;
        return validDate.test(value)
    });
    jQuery.validator.addMethod("validarEspecie", function (value, element) {
        return $divNuevaCitaMultiple.find("input[name$='[especie_id]']").length > 0;
    }, "Debe insertar al menos una especie.");

    jQuery.validator.addMethod("validarLugar", function (value, element) {
        return $("#lugarId").val() != "";
    }, "Debe seleccionar un lugar.");

    jQuery.validator.addMethod("validarObservador", function (value, element) {
        return $("#observadoresSeleccionados").val() != "";
    }, "Debe seleccionar al menos un observador.");

    jQuery.validator.addMethod("dateBeforeOrEqualToday", function (value, element) {

        var fechaAlta = $.datepicker.parseDate("dd/mm/yy", value);
        var now = new Date();

        return (fechaAlta < now || fechaAlta == now);
    }, "Debe introducir una fecha de alta anterior o igual a la fecha de hoy.");

    $divNuevaCitaMultiple.find('#frmNuevaCitaMultiple').validate({
        rules: {
            "data[Cita][fechaAlta]": {
                required: true,
                date: false,
                isdate: true,
                dateBeforeOrEqualToday: true
            },
            lugar: {
                validarLugar: true
            },
            observadores: {
                validarObservador: true
            },
            hdnEspecies: {
                validarEspecie: true
            }
        },
        messages: {
            "data[Cita][fechaAlta]": {
                required: "Debe seleccionar una fecha de alta.",
                date: "Debe introducir una fecha de alta con formato correcto (dd/mm/aaaa)."
            }
        },
        ignore: [],
        errorContainer: "#errorMessages",
        errorLabelContainer: "#errorMessages ul",
        wrapper: "li",
        invalidHandler: function (event, validator) {
            $('html, body').animate({scrollTop: 0}, 'slow');
        },
        onfocusout: false
    });
    /* FIN Validación de formulario */

    /* INICIO guardar */
    $divNuevaCitaMultiple.find("#btnGuardar").click(function () {

        if ($divNuevaCitaMultiple.find('#frmNuevaCitaMultiple').valid()) {

            var especies = "",
                lugarId = $("#lugarId").val(),
                fechaAlta = $("#fechaAlta").val(),
                items = [];


            $("input[name$='[especie_id]']").each(function () {
                especies = especies + $(this).val() + ",";
            });

            $.ajax({
                url: "/cita/existenCitas",
                data: {"especies": especies, "lugarId": lugarId, "fechaAlta": fechaAlta},
                success: function (indExisteCita) {

                    if (indExisteCita == 1) {
                        items = [];
                        items.push("<h5>");
                        items.push("<img src='/img/icons/fugue-icons-3.5.6/icons/exclamation-red.png' width='34' height='28' alt='alert icon' style='margin-right: 20px;'>");
                        items.push("Ya existe una cita creada para la misma fecha, lugar y alguna de las especies introducidas.");
                        items.push("</h5>");

                        bootbox.alert(items.join(""), "Aceptar");
                    }
                    else {
                        $.ajax({
                            url: "/especie/sonRarezas",
                            data: {"especies": especies},
                            success: function (indEsRareza) {

                                if (indEsRareza == 1) {
                                    items = [];
                                    items.push("<h5>");
                                    items.push("<img src='/img/icons/fugue-icons-3.5.6/icons/exclamation.png' width='34' height='28' alt='alert icon' style='margin-right: 20px;'>");
                                    items.push("Alguna de las especies que has introducido es una <b>RAREZA NACIONAL</b>.");
                                    items.push("</h5>");
                                    items.push("<br>");
                                    items.push("Para homologar esta cita debes seguir ");
                                    items.push("<a href='http://www.seo.org/2012/01/25/%C2%BFque-hacer-si-observamos-una-rareza/' target='_blank'>estas instrucciones</a>.");

                                    bootbox.confirm(items.join(""), "Cancelar", "Continuar", function (result) {
                                        if (result) {
                                            $("#frmNuevaCitaMultiple").submit();
                                        }
                                    });
                                } else if (indEsRareza == 2) {
                                    items = [];
                                    items.push("<h5>");
                                    items.push("<img src='/img/icons/fugue-icons-3.5.6/icons/exclamation.png' width='34' height='28' alt='alert icon' style='margin-right: 20px;'>");
                                    items.push("Alguna de las especies que has introducido es una <b>RAREZA LOCAL</b>.");
                                    items.push("</h5>");
                                    items.push("<br>");
                                    items.push("Debido a la importancia de la cita, por favor, <b>envíanos un correo electrónico a ");
                                    items.push("<a href='mailto:anuario@sao.albacete.org' target='_blank'>anuario@sao.albacete.org</a></b>, ");
                                    items.push("describíendo con detalle el avistamiento y ampliando toda la información posible.");
                                    items.push("<br>");
                                    items.push("<b>Es importante que adjuntes fotografías</b> aunque sean de mala calidad para apoyar la identificación de la especie.");

                                    bootbox.confirm(items.join(""), "Cancelar", "Continuar", function (result) {
                                        if (result) {
                                            $("#frmNuevaCitaMultiple").submit();
                                        }
                                    });
                                } else {
                                    $("#frmNuevaCitaMultiple").submit();
                                }
                            }
                        });
                    }
                }
            });
        }
    });
    /* FIN guardar */
});
