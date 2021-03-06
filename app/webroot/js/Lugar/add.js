

google.maps.event.addDomListener(window, 'load', initialize_map);
function marcarMunicipio(parserDocs){
onClickAnyMunicipio(parserDocs);

}

$(document).ready(function() {

    /* INICIO cambio de cuadricula UTM */
    $("#selectMunicipio").change(onChangeMunicipioSelect);
    /* FIN cambio de cuadricula UTM */

    /* INICIO Validación de formulario */
    $('#frmNuevoLugar').validate(validate_rules);
    /* FIN Validación de formulario */

    /* INICIO limpiar formulario */
    $("#btnLimpiar").click(function(){
        limpiar();
    });
    /* FIN limpiar formulario */

    /* INICIO popup ayuda */
    $('.badge-info').popover();
    /* FIN popup ayuda */

    /* INICIO guardar lugar */
    $("#btnGuardar").click(function(){
        if ($('#frmNuevoLugar').valid()) {

            var codigoCuadriculaUtm = $('#selectCuadriculaUtm').val();
            var nombreLugar = $('#txtNombre').val();
            var municipioId = $('#selectMunicipio').val();
            $("#frmNuevoLugar").submit();
        }
    });
    /* FIN guardar lugar */

    /* INICIO popup ayuda */
    $('.help-button').popover();
    /* FIN popup ayuda */
});

/**
 * Limpia el formulario
 */
function limpiar() {
  if (typeof(marker) !== "undefined") {
        marker.setMap(null);
  }
  $("#frmNuevoLugar").find("input[type=text], select").val("");

  // Desmarcar municipios
  var municipioAMarcar = {};
  municipioAMarcar.tipo = "municipio";
  marcarMapa(parser.docs[0], municipioAMarcar);
}

/**
 * Carga el combo de formularios y lo habilita
 *
 * @param codigoCuadriculaUtm
 */
function loadMunicipioSelect(codigoCuadriculaUtm) {

    var selectMunicipio = $("#selectMunicipio");

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

    $.ajax({
        url: "/cuadriculaUtm/cargarDatosCoordenadaUtm",
        data: {"codigoCuadriculaUtm":codigoCuadriculaUtm},
        success: function( dataReturn ) {
            $("#txtCoordenadasUtmArea").val(dataReturn.CuadriculaUtm.area);
            $("#txtCoordenadasUtmX").val(dataReturn.CuadriculaUtm.coordenadaX);
            $("#txtCoordenadasUtmY").val(dataReturn.CuadriculaUtm.coordenadaY);
        },
        dataType: "json"
    });
}
