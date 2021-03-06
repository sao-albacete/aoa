var map;
var parser;




function initialize() {

	var myLatlng = new google.maps.LatLng(38.70, -1.70);

	var mapOptions = {
		zoom:8,
		center: myLatlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("map_canvas"),
        mapOptions);

    // GeoXML para añadir eventos
    parser = new geoXML3.parser({
		map: map,
		singleInfoWindow: false,
		suppressInfoWindows: true,
		zoom: false,
		afterParse: marcarMunicipio
	});

	// Tratamos el archivo
    parser.parse(['/kml/municipios_AB.kml']);


}

google.maps.event.addDomListener(window, 'load', initialize);

$(document).ready(function() {

	/* INICIO cambio de cuadricula UTM */
	$("#selectMunicipio").change(function() {

		if($(this).val() != "") {

			$.ajax({
				url: "/municipio/obtenerDatosMunicipio",
				data: {"municipioId":$(this).val()},
				success: function( data ) {

					var datosMunicipio = JSON.parse(data);

					var municipioAMarcar = new Object();
					municipioAMarcar.codigo = datosMunicipio.Municipio.nombre;
					municipioAMarcar.tipo = "municipio";

					marcarMapa(parser.docs[0], municipioAMarcar);
				}
			});
		}
	});

	/** INICIO Validación de formulario **/

	$('#frmEditarLugar').validate({
		rules: {
			nombre : {
		     	maxlength: 100
	     	},
	     	lat: {
		     	number: true,
		     	maxlength: 11
	     	},
	     	lng: {
	     		number: true,
		     	maxlength: 11
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
	     	lat : {
	     		number: "La coordenada Latitud debe ser un numero.",
		     	maxlength: "La coordenada Latitud no puede tener más de 10 cifras."
	     	},
	     	lng : {
	     		number: "La coordenada Longitud debe ser un numero.",
		     	maxlength: "La coordenada Longitud no puede tener más de 10 cifras."
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

	/* INICIO limpiar */
	$("#btnLimpiar").click(function(){
		limpiar();
	});
	/* FIN limpiar */

	/* INICIO popup ayuda */
	$('.badge-info').popover();
	$('.help-button').popover();
	/* FIN popup ayuda */

	/* INICIO guardar lugar */
	$("#btnGuardar").click(function(){
		if ($('#frmEditarLugar').valid()) {

			var codigoCuadriculaUtm = $('#selectCuadriculaUtm').val();
			var nombreLugar = $('#txtNombre').val();
			var municipioId = $('#selectMunicipio').val();

			$.ajax({
				url: "/lugar/cargarLugaresSimilares",
				data: {"codigoCuadriculaUtm":codigoCuadriculaUtm, "nombreLugar":nombreLugar, "municipioId":municipioId},
				success: function( lugaresSimilares ) {

					//alert(JSON.stringify(lugaresSimilares));

					if(lugaresSimilares.length > 0) {
						var items = [];
						items.push( "<p>Existen lugares dados de alta ya en la aplicación cuya cuadrícula UTM y municipio coinciden con los que ha introducido:</p>" );
						items.push( "<br>" );
						items.push( "<table class='table table-striped table-bordered table-condensed'>" );
						items.push( "<tr><th>Lugar</th><th>Municipio</th><th>Cuadrícula UTM</th></tr>" );
						for (var i = 0 ; i < lugaresSimilares.length ; i++) {
							var lugarSimilar = lugaresSimilares[i];
							items.push( "<tr><td>"+lugarSimilar.Lugar.nombre+"</td><td>"+ lugarSimilar.Municipio.nombre +"</td><td>"+ lugarSimilar.CuadriculaUtm.codigo +"</td></tr>" );
						}
						items.push( "</table>" );
						items.push( "<br>" );
						items.push( "<p>¿Está seguro de que desea actualizar el lugar con estos datos?</p>" );

						bootbox.confirm(items.join( "" ), function(result) {
							if(result) {
								$("#frmEditarLugar").submit();
							}
						});
					}
					else {
						$("#frmEditarLugar").submit();
					}
				},
				dataType: "json"
			});
        }
	});
	/* FIN guardar lugar */
});

/**
 * Limpia el formulario
 */
function limpiar() {

	$("#frmEditarLugar").find("input[type=text], select").val("");
	$("#selectMunicipio").empty();
	$("#selectMunicipio").prop("disabled", true);

	// Descarmacar municipios
	var municipioAMarcar = new Object();
	municipioAMarcar.tipo = "municipio";
	marcarMapa(parser.docs[0], municipioAMarcar);
}



function clickablePolygon(p) {
  google.maps.event.addListener(
    p.polygon,
    "click",
    function (mapsMouseEvent) { clickMunicipioListener(mapsMouseEvent, p); }
  );
}

function clickMunicipioListener(mapsMouseEvent, placemark){
	// Descarmacar municipios
  var nombreLugar = $("#txtNombre").val()
	var content = "<b>Municipio:</b> " + placemark.name + "<br><b>Lugar:</b> " + nombreLugar
	latLng = mapsMouseEvent.latLng;
	placemarker(latLng.lat(), latLng.lng(), content)


	var municipioAMarcar = new Object();
	municipioAMarcar.tipo = "municipio";
	marcarMapa(parser.docs[0], municipioAMarcar);
  $("#selectMunicipio option:contains("+placemark.name+")").attr('selected', 'selected');
  placemark.polygon.setOptions(highlightMunicipio);
	$("#txtCoordenadasLat").val(latLng.lat());
	$("#txtCoordenadasLng").val(latLng.lng());
	// debugger;

  // var municipioAMarcar = {};
  // municipioAMarcar.codigo = placemark.name;
  // municipioAMarcar.tipo = "municipio";
  //
  // marcarMapa(parserDocs[0], municipioAMarcar);
  // debugger;
}
