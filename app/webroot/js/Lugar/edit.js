var map;
var parser;

google.maps.event.addDomListener(window, 'load', initialize_map);

$(document).ready(function() {

	/* INICIO cambio de municipio */
	$("#selectMunicipio").change(onChangeMunicipioSelect);

	/** INICIO Validación de formulario **/

	$('#frmEditarLugar').validate(validate_rules);
	/** FIN Validación de formulario * */

	/* INICIO limpiar */
	$("#btnLimpiar").click(function(){
    if (typeof(marker) !== "undefined") {
          marker.setMap(null);
    }
    $("#frmNuevoLugar").find("input[type=text], select").val("");

    // Desmarcar municipios
    var municipioAMarcar = {};
    municipioAMarcar.tipo = "municipio";
    marcarMapa(parser.docs[0], municipioAMarcar);

	});
	/* FIN limpiar */

	/* INICIO popup ayuda */
	$('.badge-info').popover();
	$('.help-button').popover();
	/* FIN popup ayuda */

	/* INICIO guardar lugar */
	$("#btnGuardar").click(function(){
		if ($('#frmEditarLugar').valid()) {

			// var codigoCuadriculaUtm = $('#selectCuadriculaUtm').val();
			var nombreLugar = $('#txtNombre').val();
			var municipioId = $('#selectMunicipio').val();

    	$("#frmEditarLugar").submit();
    }
  });
});
