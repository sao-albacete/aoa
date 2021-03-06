var map;
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
				 title: content,
	});

	infoWindow = new google.maps.InfoWindow({content: content});
	infoWindow.open(map, marker);

}
