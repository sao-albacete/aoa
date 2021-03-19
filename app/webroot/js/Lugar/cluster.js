
var map_cluster;
var parser;

var marker;
var infoWindow;

function addMarkerClusterIndex(lat, lng, lugarId, lugarNombre, municipioNombre, municipioId, comarcaNombre){
        var marker = new google.maps.Marker({
               position: new google.maps.LatLng(lat, lng),
               map: map,
               // title: lugarNombre,
        });

        google.maps.event.addListener(marker, 'click', function() {
           var iwContent = '<b>Lugar</b>: <a href="/lugar/view/id:'+lugarId+'">'+lugarNombre + '</a> <a href="/cita/index?lugarId='+lugarId+'">(Ver citas)</a>' +
              '<br><b>Municipio</b>:' + municipioNombre +  ' <a href="/cita/index?municipioId='+municipioId+'"> (Ver citas)</a>'+
              '<br><b>Comarca</b>:' + comarcaNombre;

            if (typeof(infoWindow) !== "undefined") {
                //limpiamos el marcador y el infobox actual
                  google.maps.event.clearInstanceListeners(infoWindow);  // just in case handlers continue to stick around
                  infoWindow.close();
                  infoWindow = null;
            }
           infoWindow = new google.maps.InfoWindow({content: iwContent});

           infoWindow.open(map, marker);
           //con esto eliminamos la molesta caja de Close que se queda al pasar el ratón por el x del infobox y cerrarlo.
           setTimeout(function (){ $(".gm-ui-hover-effect").attr('title','') }, 300);

        });
        return marker;
}

function marcarMunicipioCluster(parserDocs, addmarkerFunct) {
    //no marcaremos los municipios, la funcion se llama asi para aprovechar el commons.js,
    // aquí cargarmos los lugares en el cluster
    $.getJSON("/lugar/obtenerTodosLugaresActivos", {},
      function (datosMunicipio) {
            const markers = datosMunicipio.map((location, i) => {
                  return addmarkerFunct(location["lat"], location["lng"], location["id"], location["nombre"], location["municipio"], location["munID"], location["comarca"]);
              });
              // Add a marker clusterer to manage the markers.
              new MarkerClusterer(map_cluster, markers, {
                imagePath:
                  "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m",
              });
        }
    );
}

function selectLugarOnMap(lugarId, lugarNombre, municipioNombre, comarcaNombre){
  if (typeof(infoWindow) !== "undefined") {
      //limpiamos el marcador y el infobox actual
        infoWindow.close();
  }

  var textoLugar = [];
  textoLugar.push(lugarNombre);
  textoLugar.push(municipioNombre);
  textoLugar.push(comarcaNombre);

  $("#lugar").val(textoLugar.join(', '));
  $("#lugarSeleccionadoContenedor").show();
  $("#lugarSeleccionado").text(textoLugar.join(', '));
  $('#lugarId').val(lugarId).trigger("change");

  $('#modalSeleccionarLugarMapa').modal('hide');
}
function addMarkerClusterSeleccionarLugar(lat, lng, lugarId, lugarNombre, municipioNombre, municipioId, comarcaNombre){
        var marker = new google.maps.Marker({
               position: new google.maps.LatLng(lat, lng),
               map: map_cluster,
               // title: lugarNombre,
        });

        google.maps.event.addListener(marker, 'click', function() {
           var iwContent = '<b>Lugar</b>: <a href="/lugar/view/id:'+lugarId+'">'+lugarNombre + '</a> ' +
              '<br><b>Municipio</b>:' + municipioNombre +
              '<br><b>Comarca</b>:' + comarcaNombre +
              '<br><br><a id="btnSelect" class="btn btn-success" onclick="selectLugarOnMap(\''+lugarId+'\',\''+lugarNombre+'\',\''+municipioNombre+'\',\''+comarcaNombre+'\');" aria-hidden="true"><i class="icon-remove"></i>Seleccionar</a>';
              // <a href="/cita/index?lugarId='+lugarId+'">(Ver citas)</a>
            if (typeof(infoWindow) !== "undefined") {
                //limpiamos el marcador y el infobox actual
                  google.maps.event.clearInstanceListeners(infoWindow);  // just in case handlers continue to stick around
                  infoWindow.close();
                  infoWindow = null;
            }
           infoWindow = new google.maps.InfoWindow({content: iwContent});

           infoWindow.open(map_cluster, marker);
           //con esto eliminamos la molesta caja de Close que se queda al pasar el ratón por el x del infobox y cerrarlo.
           setTimeout(function (){ $(".gm-ui-hover-effect").attr('title','') }, 300);

        });
        return marker;
}

function initialize_map_cluster_index(){
  return initialize_map_cluster(addMarkerClusterIndex)
}
function initialize_map_cluster_cita(){
  return initialize_map_cluster(addMarkerClusterSeleccionarLugar)
}

function initialize_map_cluster(clusterFunction) {
	var myLatlng = new google.maps.LatLng(38.70, -1.70);

	var mapOptions = {
  		zoom:8,
  		center: myLatlng,
  		mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map_cluster = new google.maps.Map(document.getElementById("map_canvas_cluster"), mapOptions);
    // GeoXML para añadir eventos
    parser_cluster = new geoXML3.parser({
  		map: map_cluster,
  		singleInfoWindow: true,
  		suppressInfoWindows: false,
  		zoom: false,
  		afterParse: function(parserDocs){ marcarMunicipioCluster(parserDocs, clusterFunction)}
	});

	// Tratamos el archivo
    parser_cluster.parse(['/kml/municipios_AB.kml']);


}
