<?php

/**
 * CSS
 */
$this->Html->css(array(
    'Elements/Lugar/nuevoLugar'
), null, array('inline' => false));

/**
 * Javascript
 */
$this->Html->script(array(
    // 'Elements/Lugar/nuevoLugar',
    'https://maps.googleapis.com/maps/api/js?key=AIzaSyCvHe5uH6Ogczm4OWoXkq8_NiwspG4oE1I',
    'common/maps/geoxml3/geoxml3.js',
    'common/maps/geoxml3/ProjectedOverlay.js',
    '/plugin/jquery-validation-1.11.1/dist/jquery.validate.min',
    '/plugin/jquery-validation-1.11.1/dist/additional-methods.min',
    '/plugin/jquery-validation-1.11.1/localization/messages_es',
    '/plugin/bootbox/bootbox.min',
    'common/maps/functions',
    'Lugar/common',

), array('inline' => false));

?>

<script type="text/javascript">
    function addMarkerCluster(lat, lng, lugarId, lugarNombre, municipioNombre, municipioId){
            var marker = new google.maps.Marker({
          				 position: new google.maps.LatLng(lat, lng),
          				 map: map,
                   // title: lugarNombre,
          	});

            google.maps.event.addListener(marker, 'click', function() {
               var iwContent = '<b>Lugar</b>: <a href="/lugar/view/id:'+lugarId+'">'+lugarNombre + '</a> <a href="/cita/index?lugarId='+lugarId+'">(Ver citas)</a>' +
                  '<br><b>Municipio</b>:' + municipioNombre +  ' <a href="/cita/index?municipioId='+municipioId+'"> (Ver citas)</a>';

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


    function marcarMunicipioCluster(parserDocs) {
        //no marcaremos los municipios, la funcion se llama asi para aprovechar el commons.js,
        // aquí cargarmos los lugares en el cluster
        const locations = [
        <?php   foreach (array_slice($lugares, 0, 3) as $lugar) { ?>
                { lat: '<?php echo $lugar["Lugar"]["lat"] ?>',
                  lng: '<?php echo $lugar["Lugar"]["lng"] ?>',
                  id: '<?php echo $lugar["Lugar"]["id"] ?>',
                  lugarNombre: '<?php echo $lugar["Lugar"]["nombre"] ?>',
                  munNombre: '<?php echo $lugar['Municipio']['nombre'] ?>',
                  munId: '<?php echo $lugar['Municipio']['id'] ?>'
                },
        <?php } ?>
        ];
        const markers = locations.map((location, i) => {
            return addMarkerCluster(location["lat"], location["lng"], location["id"], location["lugarNombre"], location["munNombre"], location["munId"]);
          });
          // Add a marker clusterer to manage the markers.
          new MarkerClusterer(map_cluster, markers, {
            imagePath:
              "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m",
          });
    }

    google.maps.event.addDomListener(window, 'load', initialize_map_cluster);
</script>

<div id="modalSeleccionarLugarMapa" style="overflow:scroll !important; width:500px !important" class="modal hide fade" tabindex="-1"
     role="dialog" aria-labelledby="myModalNuevoLugar" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalNuevoLugar"><?php echo __('Seleccione un lugar en el mapa')?></h3>
    </div>
    <div class="modal-body">
        <div id="errorMessagesNuevoLugar" class="alert alert-error"
             style="display: none; padding-left: 14px;">
            <h5><?php echo __('Por favor, corrija los errores en el formulario')?>:</h5>
            <ul></ul>
        </div>
        <div class="span6" style="width:100% !important;">
            <fieldset>
                <div id="map_canvas" style="height:400px; " class="span12"></div>
            </fieldset>
        </div>
    </div>

    <div class="modal-footer">
        <button id="btnCancelar" class="btnCancelar btn btn-danger" aria-hidden="true"><i class="icon-remove"></i> <?php echo __("Cancelar"); ?></button>
    </div>
</div>
