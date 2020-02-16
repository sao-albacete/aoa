<?php 
    // Informamos el título
    $this->set('title_for_layout','Cuadrículas UTM');
    
    /**
     * CSS
     */
    $this->Html->css(array('datatables-bootstrap','CuadriculaUtm/index'), null, array('inline' => false));
    
    /**
     * Javascript
     */
    $this->Html->script(array(
        '/plugin/DataTables-1.9.4/media/js/jquery.dataTables',
        'datatables-bootstrap',
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyCvHe5uH6Ogczm4OWoXkq8_NiwspG4oE1I',
        'common/maps/geoxml3/geoxml3.js',
        'common/maps/geoxml3/ProjectedOverlay.js',
        'common/maps/functions',
        'CuadriculaUtm/index'
    ), array('inline' => false));
    
    // Menu
    $this->start('menu');        
    echo $this->element('/menu');
    $this->end(); 
?>

<script type="text/javascript">
<!--

    $(document).ready(function() {
        $("#selectCuadriculaUtm").val("<?php if(isset($valuesSubmited['cuadriculaUtmId'])){echo $valuesSubmited['cuadriculaUtmId'];}?>");
    });

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

                if(placemark.name == '<?php if(isset($cuadriculaUtmCodigo)){echo $cuadriculaUtmCodigo;}?>') {
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
            <?php echo __('Cuadrículas UTM'); ?>
            <button class="btn btn-mini btn-info pull-right help-button"
                data-trigger="click" data-placement="left" data-html="true"
                data-content="<?php echo __('Puedes consultar los datos asociados a la cuadrícula UTM y su ubicación en el mapa seleccionando una opción del desplegable de abajo');?>">
                <i class="icon-info-sign"></i> 
                <?php echo __("Ayuda");?>
            </button>
        </legend>
        
        <div class="row-fluid">
            <div class="span6">
            
                <form method="post" id="frmCuadriculaUtm">
                    
                    <div class="control-group">
                        <div class="controls form-inline">
                            <label for="selectCuadriculaUtm"><?php echo __("Cuadricula UTM")?></label>
                            <select id="selectCuadriculaUtm" name="cuadriculaUtmId">
                                <option value="">-- Seleccione una cuadrícula UTM... --</option>
                                <?php 
                                    foreach ($cuadriculasUtm as $cuadriculaUtm) {
                                    echo "<option value='".$cuadriculaUtm["CuadriculaUtm"]["id"]."'>".$cuadriculaUtm["CuadriculaUtm"]["codigo"]."</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </form>
                
                <fieldset id="fsDatosCuadriculaUtm">
                    <legend class="small">Datos de la cuadrícula UTM</legend>
                    
                    <?php if (isset($municipios)):?>
                    
                        <div class="span7" style="margin-left: 0;">                    
                            <b>Municipios: </b>
                            <span>
                                <?php
                                $listaMunicipios = ""; 
                                foreach ($municipios as $municipio) { 
                                    $listaMunicipios.= $municipio['Municipio']['nombre'].", "; 
                                }
                                echo substr($listaMunicipios, 0, -2);
                                ?>
                            </span>
                        </div>
                        
                        <div class="span5">
                            <a href="/cita/index?cuadriculaUtmId=<?php echo $valuesSubmited['cuadriculaUtmId'];?>" class="pull-right">Ver citas de la cuadrícula UTM <img src='/img/icons/search.png'/></a>
                        </div>
                    
                    <?php endif;?>
                    
                    <?php if (isset($comarcas)):?>
                    
                        <div class="span7" style="margin-left: 0; margin-top: 20px;">                    
                            <b>Comarcas: </b>
                            <span>
                                <?php
                                $listaComarcas = ""; 
                                foreach ($comarcas as $comarca) { 
                                    $listaComarcas.= $comarca['Comarca']['nombre'].", "; 
                                }
                                echo substr($listaComarcas, 0, -2);
                                ?>
                            </span>
                        </div>
                    
                    <?php endif;?>
                
                    <?php if (isset($lugares)):?>
                    
                    <table id="tablaLugares" class="table table-striped table-bordered table-hover table-condensed">
                        <caption>Lugares por cuadrícula UTM</caption>
                        <thead>
                            <tr>
                                <th><?php echo __("Lugar");?></th>
                                <th><?php echo __("Municipio");?></th>
                                <th><?php echo __("Comarca");?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach ($lugares as $lugar) {
                                    echo "<tr>";
                                    echo     "<td style='text-align: center;'><a href='/cita/index?lugarId=".$lugar["Lugar"]["id"]."'>".$lugar["Lugar"]["nombre"]."</a></td>";
                                    echo     "<td style='text-align: center;'><a href='/cita/index?municipioId=".$lugar["Municipio"]["id"]."'>".$lugar["Municipio"]["nombre"]."</a></td>";
                                    echo     "<td style='text-align: center;'><a href='/cita/index?comarcaId=".$lugar["Comarca"]["id"]."'>".$lugar["Comarca"]["nombre"]."</a></td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th><input type="text" name="buscarLugar" value="Buscar lugar..." class="search_init" /></th>
                                <th><input type="text" name="buscarMunicipio" value="Buscar municipio..." class="search_init" /></th>
                                <th><input type="text" name="buscarComarca" value="Buscar comarca..." class="search_init" /></th>
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