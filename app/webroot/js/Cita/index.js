$(document).ready(function() {

    var divFiltrarBusqueda = $('#divFiltrosBusqueda');

    // Seleccionar especie
    divFiltrarBusqueda.find("#especie").autocomplete({
        source: function( request, response ) {
            $.getJSON( "/especie/buscar_especies", {
                    term: request.term
                },
                response );
        },
        minLength: 3,
        select: function( event, ui ) {
            this.value = ui.item.value;
            $("#especieId").val(ui.item.id);

            $("#selectOrdenTaxonomico option:selected").prop("selected", false);
            $("#selectFamilia option:selected").prop("selected", false);
            $("#selectOrdenTaxonomico").prop('disabled', true);
            $("#selectFamilia").prop('disabled', true);

            return false;
        }
    });

    // Seleccionar observador
    seleccionarObservador(divFiltrarBusqueda);

    // Seleccionar colaborador
    seleccionarColaborador(divFiltrarBusqueda);

    // Seleccionar lugar
    seleccionarLugarPorNombre(divFiltrarBusqueda);

    /**
     * Vacias los hiddens cuando se borre el campo de texto asociado
     */
    divFiltrarBusqueda.find('#especie').blur(function(){
        if ($(this).val() == '') {
            $('#especieId').val('');
            $("#selectOrdenTaxonomico").prop('disabled', false);
            $("#selectFamilia").prop('disabled', false);
        }
    });
    divFiltrarBusqueda.find('#lugar').blur(function(){
        if ($(this).val() == '') {
            $('#lugarId').val('');
        }
    });
    divFiltrarBusqueda.find('#observador').blur(function(){
        if ($(this).val() == '') {
            $('#observadorId').val('');
        }
    });
    divFiltrarBusqueda.find('#colaborador').blur(function(){
        if ($(this).val() == '') {
            $('#colaboradorId').val('');
        }
    });

    // Limpiar formulario
    $("#btnLimpiar").click(function(){
        $("#frmBusqueda").find("input[type=text], input[type=hidden],select").val("");
        divFiltrarBusqueda.find("#selectNivelProteccion").empty();
        divFiltrarBusqueda.find("#selectNivelProteccion").prop("disabled", true);
    });

    // Buscar citas
    $("#btnBuscar").click(function(){
        $("#pleaseWaitDialog").modal();
        $("#frmBusqueda").submit();
    });

    // Buscar citas
    $("#btnExportar").click(function(){
        $("#frmBusqueda").submit();
    });
});

/**
 * Carga los niveles de proteccion en funcion de la figura de proteccion seleccionada
 *
 * @param figuraProteccion
 * @param nivelProteccion
 */
function cargarNivelesProteccion(figuraProteccion, nivelProteccion) {

    var $selectNivelProteccion = $("#selectNivelProteccion");

    $selectNivelProteccion.load('/cita/cargar_niveles_proteccion/figuraProteccion:' + figuraProteccion + '/nivelProteccion:' + nivelProteccion);

    if(figuraProteccion != "") {
        $selectNivelProteccion.prop("disabled", false);
    }
    else {
        $selectNivelProteccion.prop("disabled", true);
    }
}