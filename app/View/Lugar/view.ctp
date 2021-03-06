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
        'Lugar/common',
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

    function marcarMunicipio(parserDocs) {
        // Marcar municipio en el mapa
        var municipioAMarcar = {};
        municipioAMarcar.codigo = "<?php echo $lugar['Municipio']['nombre'];?>";
        municipioAMarcar.tipo = "municipio";
        marcarMapa(parserDocs[0], municipioAMarcar);
        onClickAnyMunicipio(parserDocs);
    }

    function add_init_lugar_marker(){
      var nombreLugar = "<?php echo $lugar['Lugar']['nombre'];?>";
      var nombreMunicipio = "<?php echo $lugar['Municipio']['nombre']; ?>";
      var content = "<b>Municipio:</b>" + nombreMunicipio + "<br><b>Lugar:</b> " + nombreLugar;

      placemarker(<?php echo $lugar['Lugar']['lat'];?>,
                  <?php echo $lugar['Lugar']['lng'];?>,
                  content);
    }

    $(document).ready(function() {
      google.maps.event.addDomListener(window, 'load', add_init_lugar_marker);

    });

    google.maps.event.addDomListener(window, 'load', initialize_map);

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
                        <label class="control-label" for="txtCoordenadasUtm"> <?php echo __("Latitud y Longitud"); ?></label>
                        <input class="input-mini" readonly="readonly" type="text" value="<?php echo $lugar['Lugar']['lat'];?>">
                        <input class="input-mini" readonly="readonly" type="text" value="<?php echo $lugar['Lugar']['lng'];?>">
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
