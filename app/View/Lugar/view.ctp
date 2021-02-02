<?php
    // Informamos el título
    $title = 'Detalle del lugar: '.$lugar['Lugar']['nombre'];
    $this->set('title_for_layout',$title);

    /**
     * CSS
     */
    $this->Html->css(array('datatables-bootstrap'), null, array('inline' => false));

    /**
     * Javascript
     */
    $this->Html->script(array(
        '/plugin/DataTables-1.9.4/media/js/jquery.dataTables',
        'datatables-bootstrap',
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyCvHe5uH6Ogczm4OWoXkq8_NiwspG4oE1I',
        'common/maps/geoxml3/geoxml3.js',
        'common/maps/geoxml3/ProjectedOverlay.js',
    ), array('inline' => false));

    // Menu
    $this->start('menu');
    echo $this->element('/menu');
    $this->end();
?>

<style>
<!--
    #divDetalleLugar label {
        margin: 0 20px 0 20px;
        width: 160px;
        text-align: right;
    }
-->
</style>

<script type="text/javascript">
<!--
    var map;

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
        geoXmlMunicipios = new geoXML3.parser({
            map: map,
            singleInfoWindow: true,
            zoom: false,
            afterParse: useTheData
        });

        // Tratamos el archivo
        geoXmlMunicipios.parse('/kml/municipios_AB.kml');

        // GeoXML para añadir eventos
        geoXmlUtm = new geoXML3.parser({
            map: map,
            singleInfoWindow: true,
            zoom: false,
            afterParse: useTheData
        });

        // Tratamos el archivo
        geoXmlUtm.parse('/kml/UTM_AB.kml');

        // Eventos
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


        var highlightOptions = {fillColor: "#0000ff", strokeColor: "#000000", fillOpacity: 0.5, strokeWidth: 10};

        // Se obtienen los datos del xml (kml)
        function useTheData(doc){
            var currentBounds = map.getBounds();
            if (!currentBounds) currentBounds=new google.maps.LatLngBounds();

            geoXmlDoc = doc[0];

            for (var i = 0; i < geoXmlDoc.placemarks.length; i++) {

                var placemark = geoXmlDoc.placemarks[i];

                //alert(placemark.name);

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

                    if(placemark.name == '<?php echo $lugar['CuadriculaUtm']['codigo'];?>') {
                        placemark.polygon.setOptions(highlightOptions);
                    }
                }
            }
        };
    }

    google.maps.event.addDomListener(window, 'load', initialize);
//-->
</script>

<div>
    <fieldset>
        <legend><?php echo __('Detalle del lugar: '); echo '<b>'.$lugar['Lugar']['nombre'].'</b>' ?></legend>

        <div class="row-fluid">
            <div id="divDetalleLugar" class="span6">

                <div class="tab-content">

                    <!-- Nombre -->
                    <div class="control-group">
                        <div class="controls form-inline">
                            <!-- Nombre -->
                            <label class="control-label" for="txtNombre"> <?php echo __("Nombre");?></label>
                            <input class="input-xlarge" readonly="readonly" type="text" value="<?php echo $lugar['Lugar']['nombre'];?>">
                        </div>
                    </div>

                    <!-- Cuadrícula UTM -->
                    <div class="control-group">
                        <div class="controls form-inline">
                            <!-- Cuadricula UTM -->
                            <label class="control-label" for="selectCuadriculaUtm"><?php echo __("Cuadrícula UTM");?></label>
                            <input class="input-xlarge" readonly="readonly" type="text" value="<?php echo $lugar['CuadriculaUtm']['codigo'];?>"/>
                        </div>
                    </div>
                </div>

                <!-- Municipio -->
                <div class="control-group">
                    <div class="controls form-inline">
                        <!-- Municipio -->
                        <label class="control-label" for="selectMunicipio"><?php echo __("Municipio");?></label>
                        <input type="text" readonly="readonly" class="input-xlarge" value="<?php echo $lugar['Municipio']['nombre'];?>"/>
                    </div>
                </div>

                <!-- Comarca -->
                <div class="control-group">
                    <div class="controls form-inline">
                        <!-- Municipio -->
                        <label class="control-label" for="selectMunicipio"><?php echo __("Comarca");?></label>
                        <input type="text" readonly="readonly" class="input-xlarge" value="<?php echo $lugar['Comarca']['nombre'];?>"/>
                    </div>
                </div>

                <!-- Coordenadas UTM -->
                <div class="control-group">
                    <div class="controls form-inline">
                        <label class="control-label" for="txtCoordenadasUtm"> <?php echo __("Coordenadas UTM");?></label>
                        <input class="input-mini" readonly="readonly" type="text" value="<?php echo $lugar['Lugar']['lng'];?>">
                        <input class="input-mini" readonly="readonly" type="text" value="<?php echo $lugar['Lugar']['lat'];?>">
                    </div>
                </div>

            </div>

            <div class="span6">
                <div id="map_canvas" style="width:560px; height:400px;" class="contenedor_gris"></div>
            </div>
        </div>

</fieldset>
</div>

<!-- Pie -->
<?php
    $this->start('pie');
    echo $this->element('/pie');
    $this->end();
?>
