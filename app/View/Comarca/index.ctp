<?php 
    // Informamos el título
    $this->set('title_for_layout','Comarcas');
    
    /**
     * CSS
     */
    $this->Html->css(array('datatables-bootstrap','Comarca/index'), null, array('inline' => false));
    
    /**
     * Javascript
     */
    $this->Html->script(array('/plugin/DataTables-1.9.4/media/js/jquery.dataTables', 'datatables-bootstrap', 'https://maps.googleapis.com/maps/api/js?sensor=false', 'https://geoxml3.googlecode.com/svn/branches/polys/geoxml3.js', 'https://geoxml3.googlecode.com/svn/trunk/ProjectedOverlay.js','common/maps/functions','Comarca/index'), array('inline' => false));
    
    // Menu
    $this->start('menu');        
    echo $this->element('/menu');
    $this->end(); 
?>

<script type="text/javascript">
<!--

    $(document).ready(function() {
        $("#selectComarca").val("<?php if(isset($valuesSubmited['comarcaId'])){echo $valuesSubmited['comarcaId'];}?>");
    });

    var highlightOptions = {fillColor: "#00ff00", strokeColor: "#000000", fillOpacity: 0.5, strokeWidth: 10};

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

                if(placemark.name == '<?php if(isset($comarcaNombre)){echo $comarcaNombre;}?>') {
                    placemark.polygon.setOptions(highlightOptions); 
                }
            }
        }
    }
//-->
</script>

<div>
    <fieldset>
        <legend>
            <?php echo __('Comarcas'); ?>
            <button class="btn btn-mini btn-info pull-right help-button"
                data-trigger="click" data-placement="left" data-html="true"
                data-content="<?php echo __('Puedes consultar los datos asociados a la comarca y su ubicación en el mapa seleccionando una opción del desplegable de abajo');?>">
                <i class="icon-info-sign"></i> 
                <?php echo __("Ayuda");?>
            </button>
        </legend>
        
        <div class="row-fluid">
            <div class="span6">
            
                <form method="post" id="frmComarca">
                    
                    <div class="control-group">
                        <div class="controls form-inline">
                            <label for="selectComarca"><?php echo __("Comarca")?></label>
                            <select id="selectComarca" name="comarcaId">
                                <option value="">-- Seleccione una comarca... --</option>
                                <?php 
                                    foreach ($comarcas as $comarca) {
                                    echo "<option value='".$comarca["Comarca"]["id"]."'>".$comarca["Comarca"]["nombre"]."</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </form>
                
                <fieldset id="fsDatosComarca">
                    <legend class="small">Datos de la comarca</legend>
                    
                    <?php if (isset($municipios)):?>

                        <div class="span8" style="margin-left: 0;">                    
                            <b>Municipios: </b>
                            <span>
                                <?php
                                $listaMunicipios = ""; 
                                foreach ($municipios as $municipio) { 
                                    $listaMunicipios.= $municipio['Municipio']['nombre'].", "; 
                                }
                                echo substr($listaMunicipios, 0, -1);
                                ?>
                            </span>
                        </div>
                        
                        <div class="span4">
                            <a href="/cita/index?comarcaId=<?php echo $valuesSubmited['comarcaId'];?>" class="pull-right">Ver citas de la comarca <img src='/img/icons/search.png'/></a>
                        </div>
                    
                    <?php endif;?>
                
                    <?php if (isset($lugares)):?>
                    
                    <table id="tablaLugares" class="table table-striped table-bordered table-hover table-condensed">
                        <caption>Lugares por comarca</caption>
                        <thead>
                            <tr>
                                <th><?php echo __("Lugar");?></th>
                                <th><?php echo __("Cuadrícula UTM");?></th>
                                <th><?php echo __("Municipio");?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach ($lugares as $lugar) {
                                    echo "<tr>";
                                    echo     "<td style='text-align: center;'><a href='/cita/index?lugarId=".$lugar["Lugar"]["id"]."'>".$lugar["Lugar"]["nombre"]."</a></td>";
                                    echo     "<td style='text-align: center;'><a href='/cita/index?cuadriculaUtmId=".$lugar["CuadriculaUtm"]["id"]."'>".$lugar["CuadriculaUtm"]["codigo"]."</a></td>";
                                    echo     "<td style='text-align: center;'><a href='/cita/index?municipioId=".$lugar["Municipio"]["id"]."'>".$lugar["Municipio"]["nombre"]."</a></td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th><input type="text" name="buscarLugar" value="Lugar..." class="search_init" /></th>
                                <th><input type="text" name="buscarCuadriculaUtm" value="Cuadrícula UTM..." class="search_init" /></th>
                                <th><input type="text" name="buscarMunicipio" value="Municipio..." class="search_init" /></th>
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