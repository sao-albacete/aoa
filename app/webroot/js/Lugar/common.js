var map;
var map_readonly;

var parser;
var parser_readonly;

var marker;
var infoWindow;

var highlightCuadriculaUtm = {fillColor: "#0000ff", strokeColor: "#000000", fillOpacity: 0.5, strokeWidth: 10};
var highlightMunicipio = {fillColor: "#ff0000", strokeColor: "#000000", fillOpacity: 0.5, strokeWidth: 10};
var highlightClearCuadriculaUtm = {fillColor: "#000000", strokeColor: "#002673", fillOpacity: 0, strokeWidth: 10};
var highlightClearMunicipio = {fillColor: "#000000", strokeColor: "#FF0A09", fillOpacity: 0, strokeWidth: 10};

var PNOAWMTS;
var RasterWMTS;

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
	placemarker(latLng.lat(), latLng.lng(), content, map=map)

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

function create_other_WMTS(){
   //Define el WMTS del PNOA como mapa base
   PNOAWMTS = new google.maps.ImageMapType({
           alt: "WMTS del PNOA",
           getTileUrl: function(tile, zoom) {
               var url = "http://www.ign.es/wmts/pnoa-ma?request=getTile&layer=OI.OrthoimageCoverage&TileMatrixSet=GoogleMapsCompatible&TileMatrix=" + zoom + "&TileCol=" + tile.x + "&TileRow=" + tile.y + "&format=image/jpeg";
               return url;
           },
           isPng: false,
           maxZoom: 20,
           minZoom: 1,
           name: "PNOA",
           tileSize: new google.maps.Size(256, 256)
   });

    //Define el WMTS de Mapa Raster como mapa base
    RasterWMTS = new google.maps.ImageMapType({
       alt: "RasterIGN",
       getTileUrl: function(tile, zoom) {
         var url = "http://www.ign.es/wmts/mapa-raster?request=getTile&layer=MTN&TileMatrixSet=GoogleMapsCompatible&TileMatrix=" + zoom
      + "&TileCol=" + tile.x + "&TileRow=" + tile.y + "&format=image/jpeg";
       return url;
       },
       isPng: false,
       maxZoom: 20,
       minZoom: 1,
       name: "RasterIGN",
       tileSize: new google.maps.Size(256, 256)
    });
}

create_other_WMTS();

//con esto eliminamos la molesta cajas de Close o tooltips que se queda al pasar el ratón
//por el x del infobox o en el dropbox de las capas.
//cuidado porque si se activa, entonces el datetime-picker se autocierra y no se muestra
//window.setInterval(function (){ $(".ui-corner-all").remove();  }, 300);

function initialize_map_handler(canvas) {

	var myLatlng = new google.maps.LatLng(38.70, -1.70);

	var mapOptions = {
    		zoom:8,
    		center: myLatlng,
    		//mapTypeId:
        mapTypeId: 'roadmap',
         mapTypeControlOptions: {
           mapTypeIds: ['roadmap', 'satellite', 'PNOA', 'Raster'], //Añade las capas base
           style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
         }
    };
    var active_map;

    if(canvas == 'map_canvas_view'){
      map_readonly = new google.maps.Map(document.getElementById(canvas),
          mapOptions);
      active_map = map_readonly;

      // GeoXML para añadir eventos
      parser_readonly = new geoXML3.parser({
        map: map_readonly, 		singleInfoWindow: true, 		suppressInfoWindows: false,
        zoom: false, 		afterParse: marcarMunicipio
     });
        parser_readonly.parse(['/kml/municipios_AB.kml']);
        //parser_readonly.parse(['/kml/UTM_AB.kml']);
        //

    }else{
      map = new google.maps.Map(document.getElementById(canvas),
          mapOptions);
      active_map = map;
      // GeoXML para añadir eventos
      parser = new geoXML3.parser({
        map: map, 		singleInfoWindow: false, 		suppressInfoWindows: true,
        zoom: false, 		afterParse: marcarMunicipioClick
     });

        parser.parse(['/kml/municipios_AB.kml']);
        // parser.parse(['/kml/UTM_AB.kml']);
    }

    active_map.mapTypes.set('PNOA', PNOAWMTS); //Definición de la capa de fondo
    active_map.mapTypes.set('Raster', RasterWMTS); //Definición de la capa de fondo




}

function initialize_map_view(){
  return initialize_map_handler(canvas="map_canvas_view")
}

function initialize_map(){
  return initialize_map_handler(canvas="map_canvas")
}

function placemarker(lat, lng, content, mapobj=map){
	if (marker && typeof(infoWindow) !== "undefined") {
			//limpiamos el marcador y el infobox actual
				marker.setMap(null);
				google.maps.event.clearInstanceListeners(infoWindow);  // just in case handlers continue to stick around
				infoWindow.close();
				infoWindow = null;
	}
	marker = new google.maps.Marker({
				 position: new google.maps.LatLng(lat, lng),
				 map: mapobj,
				 animation:google.maps.Animation.Drop,
	});

	infoWindow = new google.maps.InfoWindow({content: content});
	infoWindow.open(mapobj, marker);
  //con esto eliminamos la molesta caja de Close que se queda al pasar el ratón por el x del infobox y cerrarlo.
  setTimeout(function (){ $(".gm-ui-hover-effect").attr('title','');  }, 200);

}

function placemarker_lugar_municipio(lat, lng, nombreLugar, nombreMunicipio){
  var content = "<b>Municipio: </b>" + nombreMunicipio + "<br><b>Lugar: </b> " + nombreLugar;

  placemarker(lat, lng, content, mapobj=map_readonly);

}
