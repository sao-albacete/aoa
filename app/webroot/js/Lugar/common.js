var map;
var map_cluster;
var parser;

var marker;
var infoWindow;

var highlightCuadriculaUtm = {fillColor: "#0000ff", strokeColor: "#000000", fillOpacity: 0.5, strokeWidth: 10};
var highlightMunicipio = {fillColor: "#ff0000", strokeColor: "#000000", fillOpacity: 0.5, strokeWidth: 10};
var highlightClearCuadriculaUtm = {fillColor: "#000000", strokeColor: "#002673", fillOpacity: 0, strokeWidth: 10};
var highlightClearMunicipio = {fillColor: "#000000", strokeColor: "#FF0A09", fillOpacity: 0, strokeWidth: 10};



function kmlColor (kmlIn) {
    var kmlColor = {};
    if (kmlIn) {
        aa = kmlIn.substr(0,2);
        bb = kmlIn.substr(2,2);
        gg = kmlIn.substr(4,2);
        rr = kmlIn.substr(6,2);
        kmlColor.color = "#" + rr + gg + bb;
        kmlColor.opacity = parseInt(aa,16)/256;
    } else {
        // defaults
        kmlColor.color = randomColor();
        kmlColor.opacity = 0.45;
    }
        return kmlColor;
}

function randomColor(){
    var color="#";
    var colorNum = Math.random()*8388607.0;  // 8388607 = Math.pow(2,23)-1
    var colorStr = colorNum.toString(16);
    color += colorStr.substring(0,colorStr.indexOf('.'));
    return color;
};

function clickablePolygon(p) {
  google.maps.event.addListener(
    p.polygon,
    "click",
    function (mapsMouseEvent) { clickMunicipioListener(mapsMouseEvent, p); }
  );
}

function onChangeMunicipioSelect() {

    if($(this).val() != "") {

        $.ajax({
            url: "/municipio/obtenerDatosMunicipio",
            data: {"municipioId":$(this).val()},
            success: function( data ) {

                var datosMunicipio = JSON.parse(data);

                var municipioAMarcar = {};
                municipioAMarcar.codigo = datosMunicipio.Municipio.nombre;
                municipioAMarcar.tipo = "municipio";

                marcarMapa(parser.docs[0], municipioAMarcar);
            }
        });
    }
}



validate_rules = {
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
}

function clickMunicipioListener(mapsMouseEvent, placemark){
	// Descarmacar municipios
  var nombreLugar = ($("#txtNombre").val() != "") ? $("#txtNombre").val() : "[a rellenar]"
	var content = "<b>Municipio:</b> " + placemark.name + "<br><b>Nombre Lugar:</b> " + nombreLugar
	latLng = mapsMouseEvent.latLng;
	placemarker(latLng.lat(), latLng.lng(), content)

	var municipioAMarcar = new Object();
	municipioAMarcar.tipo = "municipio";
	marcarMapa(parser.docs[0], municipioAMarcar);
  $("#selectMunicipio option:contains("+placemark.name+")").attr('selected', 'selected');
  placemark.polygon.setOptions(highlightMunicipio);
	$("#txtCoordenadasLat").val(latLng.lat().toFixed(8));
	$("#txtCoordenadasLng").val(latLng.lng().toFixed(8));
}

/**
 * Marca el municipio seleccionado
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

function onClickAnyMunicipio(parserDocs) {
  for (var i = 0; i < parserDocs[0].placemarks.length; i++) {
            var p = parserDocs[0].placemarks[i];
            clickablePolygon(p);

    }
}

function initialize_map_cluster() {

	var myLatlng = new google.maps.LatLng(38.70, -1.70);

	var mapOptions = {
		zoom:8,
		center: myLatlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map_cluster = new google.maps.Map(document.getElementById("map_canvas"),
        mapOptions);
    // GeoXML para añadir eventos
    parser = new geoXML3.parser({
		map: map,
		singleInfoWindow: false,
		suppressInfoWindows: true,
		zoom: false,
		afterParse: marcarMunicipioCluster
	});

	// Tratamos el archivo
    parser.parse(['/kml/municipios_AB.kml']);


}

function initialize_map() {

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


function placemarker(lat, lng, content){
	if (typeof(infoWindow) !== "undefined") {
			//limpiamos el marcador y el infobox actual
				marker.setMap(null);
				google.maps.event.clearInstanceListeners(infoWindow);  // just in case handlers continue to stick around
				infoWindow.close();
				infoWindow = null;
	}
	marker = new google.maps.Marker({
				 position: new google.maps.LatLng(lat, lng),
				 map: map,
				 animation:google.maps.Animation.Drop,
	});

	infoWindow = new google.maps.InfoWindow({content: content});
	infoWindow.open(map, marker);
  //con esto eliminamos la molesta caja de Close que se queda al pasar el ratón por el x del infobox y cerrarlo.
  setTimeout(function (){ $(".gm-ui-hover-effect").attr('title','');  }, 200);

}

function placemarker_lugar_municipio(lat, lng, nombreLugar, nombreMunicipio){
  var content = "<b>Municipio: </b>" + nombreMunicipio + "<br><b>Lugar: </b> " + nombreLugar;

  placemarker(lat, lng, content);

}
