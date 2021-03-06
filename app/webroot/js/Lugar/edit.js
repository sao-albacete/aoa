var map;
var parser;

var highlightCuadriculaUtm = {fillColor: "#0000ff", strokeColor: "#000000", fillOpacity: 0.5, strokeWidth: 10};
var highlightMunicipio = {fillColor: "#ff0000", strokeColor: "#000000", fillOpacity: 0.5, strokeWidth: 10};
var highlightClearCuadriculaUtm = {fillColor: "#000000", strokeColor: "#002673", fillOpacity: 0, strokeWidth: 10};
var highlightClearMunicipio = {fillColor: "#000000", strokeColor: "#FF0A09", fillOpacity: 0, strokeWidth: 10};

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
		singleInfoWindow: true,
		zoom: false,
		afterParse: marcarCuadriculaUtmYMunicipio
	});
	
	// Tratamos el archivo
    parser.parse(['/kml/UTM_AB.kml', '/kml/municipios_AB.kml']);
}

google.maps.event.addDomListener(window, 'load', initialize);

$(document).ready(function() {

	$("#selectCuadriculaUtm").change(function() {
		
		// Cargar combo de municipios
		loadMunicipioSelect($(this).val());
		
		// Cargar datos de cuadrícula UTM
		loadCoordenadasUtm($(this).val());
		
		// Marcar cuadrícula UTM
		var cuadriculaUtmAMarcar = new Object();
		cuadriculaUtmAMarcar.codigo = $(this).val();
		cuadriculaUtmAMarcar.tipo = "cuadriculaUtm";
		
		marcarMapa(parser.docs[0], cuadriculaUtmAMarcar);
		
		// Descarmacar municipios
		var municipioAMarcar = new Object();
		municipioAMarcar.tipo = "municipio";
		
		marcarMapa(parser.docs[1], municipioAMarcar);
	});
	
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
					
					marcarMapa(parser.docs[1], municipioAMarcar);
				}
			});
		}
	});
	/* FIN cambio de cuadricula UTM */

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
	var cuadriculaUtmAMarcar = new Object();
	cuadriculaUtmAMarcar.tipo = "cuadriculaUtm";
	marcarMapa(parser.docs[0], cuadriculaUtmAMarcar);
	
	// Descarmacar municipios
	var municipioAMarcar = new Object();
	municipioAMarcar.tipo = "municipio";
	marcarMapa(parser.docs[1], municipioAMarcar);
}

/**
 * Carga el combo de formularios y lo habilita
 * 
 * @param codigoCuadriculaUtm
 */
function loadMunicipioSelect(codigoCuadriculaUtm) {

	$("#selectMunicipio").load('/municipio/cargarMunicipios/codigoCuadriculaUtm:' + codigoCuadriculaUtm);

    if(codigoCuadriculaUtm != "") {
		$("#selectMunicipio").prop("disabled", false);
	}
	else {
		$("#selectMunicipio").prop("disabled", true);
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

/**
 * Marca la cuadricula UTM o municipio seleccionados
 * 
 * @param parserDoc
 * @param elementoAMarcar
 */
function marcarMapa(parserDoc, elementoAMarcar){
	
	for (var i = 0; i < parserDoc.placemarks.length; i++) {
		
		var placemark = parserDoc.placemarks[i];
		
		if (placemark.polygon) {
			
			var kmlStrokeColor = kmlColor(placemark.style.color);
			var kmlFillColor = kmlColor(placemark.style.fillcolor);
			
			var normalStyle = {
				strokeColor: kmlStrokeColor.color,
				strokeWeight: placemark.style.width,
				strokeOpacity: kmlStrokeColor.opacity,
				fillColor: kmlFillColor.color,
				fillOpacity: kmlFillColor.opacity
			};

			placemark.polygon.normalStyle = normalStyle;
			
			if(placemark.name == elementoAMarcar.codigo) {
					
				if(elementoAMarcar.tipo == "cuadriculaUtm") {
					placemark.polygon.setOptions(highlightCuadriculaUtm);
				}
				else if(elementoAMarcar.tipo == "municipio") {
					placemark.polygon.setOptions(highlightMunicipio);
				}
			}
			else {
				if(elementoAMarcar.tipo == "cuadriculaUtm") {
					placemark.polygon.setOptions(highlightClearCuadriculaUtm);
				}
				else if(elementoAMarcar.tipo == "municipio") {
					placemark.polygon.setOptions(highlightClearMunicipio);
				}
			}
		}
	}
}