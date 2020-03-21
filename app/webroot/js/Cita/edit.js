$(document).ready(function() {

    var $divEditarCita = $('#divEditarCita');

    // Visualizar fotografías
    $divEditarCita.find(".yoxview").yoxview({
        lang : "es",
        autoHideMenu : false,
        autoHideInfo : false,
        showDescription : true,
        renderInfoPin : false
    });

    // Seleccionar especie
    seleccionarEspecie($divEditarCita);

    // Limpiar especie
    $divEditarCita.find(".btnVaciarEspecie").click(function() {
        limpiarEspecie($divEditarCita);
    });

    // Seleccionar subespecie
    seleccionarSubespecie($divEditarCita);

    // Seleccioanr fecha de alta
    seleccionarFecha($divEditarCita);

	// Seleccionar hora de alta
	seleccionarHora($divEditarCita);

    // Gestionar tabla de clases de edad/sexo
    gestionarTablaNumeroAves($divEditarCita);

    // Seleccionar lugar
    seleccionarLugar($divEditarCita);

    // Vaciar lugar
    $divEditarCita.find(".btnVaciarLugar").click(function() {
        vaciarLugarSeleccioando($divEditarCita)
    });

    // Nuevo lugar
    $divEditarCita.find(".btnNuevoLugar").click(function() {
        limpiarFormularioLugar();
        $('#modalNuevoLugar').modal();
    });

    // Seleccionar observador
    seleccionarObservador($divEditarCita);

    // Nuevo colaborador
    $divEditarCita.find(".btnNuevoColaborador").click(function() {
        limpiarNuevoColaborador();
        $('#divNuevoColaborador').modal();
    });

    // Seleccionar colaborador
    seleccionarColaboradores($divEditarCita);

    // Limpiar colaboradores seleccioandos
    $divEditarCita.find("#btnVaciarColaboradores").click(function () {
        limpiarColaboradores($divEditarCita);
    });

    // Popup ayuda
    $divEditarCita.find('.badge-info').popover();

    // Resaltar checks seleccioandos
    marcarChecksSeleccioandos($divEditarCita);

    // Eliminar fotos
    $divEditarCita.find('.quitar-foto').each(function() {
        $(this).click(function() {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                $(this).parent().parent().removeClass('error');
                $divEditarCita.find('.foto-eliminar-' + $(this).attr('data-id')).prop('disabled', true);
            } else {
                $(this).addClass('active');
                $(this).parent().parent().addClass('error');
                $divEditarCita.find('.foto-eliminar-' + $(this).attr('data-id')).prop('disabled', false);
            }
        });
    });


    /** INICIO Validación de formulario * */
    jQuery.validator.addMethod("isdate", function (value, element) {
        var validDate = /^(\d{2})\/(\d{2})\/(\d{4})?$/;
        return validDate.test(value)
    });
    jQuery.validator.addMethod("validarEspecie", function(value, element) {
        return $divEditarCita.find(".especieId").val() != "";
    }, "Debe seleccionar una especie.");

    jQuery.validator.addMethod("validarLugar", function(value, element) {
        return $divEditarCita.find("#lugarId").val() != "";
    }, "Debe seleccionar un lugar.");

    jQuery.validator.addMethod("validarObservador", function(value, element) {
        return $divEditarCita.find("#observadoresSeleccionados").val() != "";
    }, "Debe seleccionar al menos un observador.");

    jQuery.validator.addMethod("validarNumeroAves", function(value, element) {
        var total_numero_aves = 0;
        $divEditarCita.find(".numero_aves").each(function(){
            total_numero_aves += parseInt($(this).val());
        });
        return total_numero_aves > 0;
    }, "El número de aves debe ser mayor que cero.");

    jQuery.validator.addMethod("dateBeforeOrEqualToday", function(value, element) {

        var fechaAlta = $.datepicker.parseDate("dd/mm/yy", value);
        var now = new Date();

        return (fechaAlta < now || fechaAlta == now);
    }, "Debe introducir una fecha de alta anterior o igual a la fecha de hoy.");

    $divEditarCita.find('#frmEditarCita').validate({
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
                date: "Debe introducir una fecha de alta con formato correcto (dd/mm/aaaa)."
              },
              "data[Cita][clase_reproduccion_id]" : {
                 required: "Debe seleccionar un dato de reproducción."
             },
             imagen : {
                 extension: "La imagen debe tener alguna de las siguientes extensiones: jpg, jpeg, png"
             }
        },
        errorContainer: "#errorMessagesGrafico",
        errorLabelContainer : "#errorMessagesGrafico ul",
        wrapper: "li",
        invalidHandler: function(event, validator) {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
        },
        onfocusout: false
    });
    /** FIN Validación de formulario * */


    /* INICIO guardar */
    $divEditarCita.find("#btnGuardar").click(function(){

        if ($divEditarCita.find('#frmEditarCita').valid()) {

            var especieId = $divEditarCita.find(".especieId").val();
            var lugarId = $divEditarCita.find("#lugarId").val();
            var fechaAlta = $divEditarCita.find("#fechaAlta").val();
            var citaId = $divEditarCita.find("#citaId").val();

            $.ajax({
                url: "/cita/existenCitas",
                data: {"especies":especieId,"lugarId":lugarId,"fechaAlta":fechaAlta,"citaId":citaId},
                success: function( indExisteCita ) {

                    if(indExisteCita == 1) {
                        var items = [];
                        items.push("<h5>");
                        items.push( "<img src='/img/icons/fugue-icons-3.5.6/icons/exclamation-red.png' width='34' height='28' alt='alert icon' style='margin-right: 20px;'>" );
                        items.push( "Ya existe una cita creada para la misma especie, fecha y lugar." );
                        items.push( "</h5>" );

                        bootbox.alert(items.join( "" ), "Aceptar");
                    }
                    else {
                        $.ajax({
                            url: "/especie/esRareza",
                            data: {"especieId":especieId},
                            success: function( indEsRareza ) {

                                //alert(indEsRareza);

                                if (indEsRareza == 1) {
                                    var items = [];
                                    items.push("<h5>");
                                    items.push( "<img src='/img/icons/fugue-icons-3.5.6/icons/exclamation.png' width='34' height='28' alt='alert icon' style='margin-right: 20px;'>" );
                                    items.push( "La especie que has seleccionado es una <b>RAREZA NACIONAL</b>." );
                                    items.push( "</h5>" );
                                    items.push( "<br>" );
                                    items.push( "Para homologar esta cita debes seguir " );
                                    items.push( "<a href='http://www.seo.org/2012/01/25/%C2%BFque-hacer-si-observamos-una-rareza/' target='_blank'>estas instrucciones</a>." );

                                    bootbox.confirm(items.join( "" ), "Cancelar", "Continuar", function(result) {
                                        if(result) {
                                            $divEditarCita.find("#frmEditarCita").submit();
                                        }
                                    });
                                } else if(indEsRareza == 2) {
                                    var items = [];
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
                                            $divEditarCita.find("#frmEditarCita").submit();
                                        }
                                    });
                                } else {
                                    $divEditarCita.find("#frmEditarCita").submit();
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
