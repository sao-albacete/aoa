var map;
var parser;

var marker;
var infoWindow;

var highlightCuadriculaUtm = {fillColor: "#0000ff", strokeColor: "#000000", fillOpacity: 0.5, strokeWidth: 10};
var highlightMunicipio = {fillColor: "#ff0000", strokeColor: "#000000", fillOpacity: 0.5, strokeWidth: 10};
var highlightClearCuadriculaUtm = {fillColor: "#000000", strokeColor: "#002673", fillOpacity: 0, strokeWidth: 10};
var highlightClearMunicipio = {fillColor: "#000000", strokeColor: "#FF0A09", fillOpacity: 0, strokeWidth: 10};

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
function marcarMunicipio(parserDocs) {
    //Marcar municipio en el mapa
    var municipioAMarcar = {};
    municipioAMarcar.codigo = "<?php echo $lugar['Municipio']['nombre'];?>";
    municipioAMarcar.tipo = "municipio";
    marcarMapa(parserDocs[0], municipioAMarcar);
    onClickAnyMunicipio(parserDocs);
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
