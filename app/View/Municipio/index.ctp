<?php 
    // Informamos el título
    $this->set('title_for_layout','Municipios');
    
    /**
     * CSS
     */
    $this->Html->css(array('datatables-bootstrap', 'Municipio/index'), null, array('inline' => false));
    
    /**
     * Javascript
     */
    $this->Html->script(array('/plugin/DataTables-1.9.4/media/js/jquery.dataTables', 'datatables-bootstrap', 'https://maps.googleapis.com/maps/api/js?sensor=false', 'https://geoxml3.googlecode.com/svn/branches/polys/geoxml3.js', 'https://geoxml3.googlecode.com/svn/trunk/ProjectedOverlay.js','common/maps/functions','Municipio/index'), array('inline' => false));
    
    // Menu
    $this->start('menu');        
    echo $this->element('/menu');
    $this->end(); 
?>

<script type="text/javascript">

    $(document).ready(function() {
        $("#selectMunicipio").val("<?php if(isset($valuesSubmited['municipioId'])){echo $valuesSubmited['municipioId'];}?>");
    });

    var highlightOptions = {fillColor: "#ff0000", strokeColor: "#000000", fillOpacity: 0.5, strokeWidth: 10};

    //Se obtienen los datos del xml (kml)
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
    
                if(placemark.name == '<?php if(isset($municipioNombre)){echo $municipioNombre;}?>') {
                    placemark.polygon.setOptions(highlightOptions); 
                }
            }
        }
    }

</script>

<div>
    <fieldset>
        <legend>
            <?php echo __('Municipios'); ?>
            <button class="btn btn-mini btn-info pull-right help-button"
                data-trigger="click" data-placement="left" data-html="true"
                data-content="<?php echo __('Puedes consultar los datos asociados al municpio y su ubicación en el mapa seleccionando una opción del desplegable de abajo');?>">
                <i class="icon-info-sign"></i> 
                <?php echo __("Ayuda");?>
            </button>
        </legend>
        
        <div class="row">
            <div class="span6">
            
                <form method="post" id="frmMunicipio">
                    
                    <div class="control-group">
                        <div class="controls form-inline">
                            <label for="selectMunicipio"><?php echo __("Municipio")?></label>
                            <select id="selectMunicipio" name="municipioId">
                                <option value="">-- Seleccione un municipio... --</option>
                                <?php 
                                    foreach ($municipios as $municipio) {
                                    echo "<option value='".$municipio["Municipio"]["id"]."'>".$municipio["Municipio"]["nombre"]."</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </form>
                
                <fieldset id="fsDatosMunicipio">
                    <legend class="small">Datos del municipio</legend>
                    
                    <?php if (isset($comarca)):?>
                    
                        <b>Comarca: </b>
                        <span><?php echo $comarca; ?></span>
                        
                        <a href="/cita/index?municipioId=<?php echo $valuesSubmited['municipioId'];?>" class="pull-right">Ver citas del municipio <img src='/img/icons/search.png'/></a>
                    
                    <?php endif;?>
                
                    <?php if (isset($lugares)):?>
                    
                    <table id="tablaMunicipios" class="table table-striped table-bordered table-hover table-condensed">
                        <caption>Lugares por municipio</caption>
                        <thead>
                            <tr>
                                <th><?php echo __("Lugar");?></th>
                                <th><?php echo __("Cuadrícula UTM");?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach ($lugares as $lugar) {
                                    echo "<tr>";
                                    echo     "<td style='text-align: center;'><a href='/cita/index?lugarId=".$lugar["Lugar"]["id"]."'>".$lugar["Lugar"]["nombre"]."</a></td>";
                                    echo     "<td style='text-align: center;'><a href='/cita/index?cuadriculaUtmId=".$lugar["CuadriculaUtm"]["id"]."'>".$lugar["CuadriculaUtm"]["codigo"]."</a></td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th><input type="text" name="buscarLugar" value="Buscar lugar..." class="search_init" /></th>
                                <th><input type="text" name="buscarCuadriculaUtm" value="Buscar cuadrícula UTM..." class="search_init" /></th>
                            </tr>
                        </tfoot>
                    </table>
                    <?php endif;?>
                
                </fieldset>
            </div>
            <div class="span6">
                <div id="map_canvas" style="height:400px;" class="span12"></div>
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