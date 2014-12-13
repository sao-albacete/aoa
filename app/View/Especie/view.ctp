<?php 

    // Informamos el título
    $this->set('title_for_layout','Ficha de '.$especie['Especie']['nombreComun']);
    
    /**
     * CSS
     */
    $this->Html->css(array('datatables-bootstrap', 'Especie/view'), null, array('inline' => false));
    
    /**
     * Javascript
     */
    $this->Html->script(array('/plugin/DataTables-1.9.4/media/js/jquery.dataTables.min', 'datatables-bootstrap', '/plugin/jquery-validation-1.11.1/dist/jquery.validate.min', '/plugin/jquery-validation-1.11.1/localization/messages_es', '/plugin/yoxview/yoxview-init', 'https://maps.googleapis.com/maps/api/js?sensor=false', 'https://geoxml3.googlecode.com/svn/branches/polys/geoxml3.js', 'https://geoxml3.googlecode.com/svn/trunk/ProjectedOverlay.js','pleaseWaitDialog', 'common/maps/functions','Especie/view'), array('inline' => false));
?>

<style>
<!--
    .gmnoprint img {
        max-width: none; 
    }
-->
</style>
    
<script type="text/javascript">
<!--
    $(document).ready(function() {

        /**
         * Cargar calendarios
         */
        $( "#fechaDesde" ).datepicker({
            yearRange: "<?php echo $anios[count($anios) - 1 ][0]['anio'];?>:<?php echo date("Y");?>",
            changeMonth: true,
            changeYear: true,
            onClose: function( selectedDate ) {
                $( "#fechaHasta" ).datepicker( "option", "minDate", selectedDate );
            }
        });
        $( "#fechaHasta" ).datepicker({
            yearRange: "<?php echo $anios[count($anios) - 1 ][0]['anio'];?>:<?php echo date("Y");?>",
            changeMonth: true,
            changeYear: true,
            onClose: function( selectedDate ) {
                 $( "#fechaDesde" ).datepicker( "option", "maxDate", selectedDate );
            }
        });
        // Fin cargar calendarios

        /* INICIO tabla citas */
        $("#tabla_citas").dataTable({
            "iDisplayLength": 25,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo $this->Html->Url(array('controller' => 'citaAjax', 'action' => 'obtenerCitasEspecieDatatables', time(), "?" => array("especieId" => $especie['Especie']['id']))); ?>",
            "sDom": "<\'row\'<\'span9\'l><\'span3\'f>r>t<\'row\'<\'span8\'i><\'span4\'p>>",
            "sWrapper": "dataTables_wrapper form-inline",
            "bPaginate": true,
            "sPaginationType": "bootstrap",
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ 0,6,8 ] },
                { "sClass": "text-center", "aTargets": [ 0,2,4,5,7,8 ] }
            ],
            "aoColumns": [null,null,{ "sType": "date-uk" },null,null,null,null,null,null],
            "bInfo": true,
            "bAutoWidth": false,
            "oLanguage": {
                "oAria": {
                    "sSortAscending": " - haz click o pulsa enter para ordenar ascendentemente",
                    "sSortDescending": " - haz click o pulsa enter para ordenar descendentemente"
                  },
                "oPaginate": {
                       "sFirst": "Primera",
                       "sLast": "Última",
                       "sNext": "Siguiente",
                       "sPrevious": "Anterior"
                },
                "sEmptyTable": "No hay datos disponibles",
                "sInfo": "Mostrando (_START_ de _END_) registros de un total de _TOTAL_",
                "sInfoEmpty": "No hay registros para mostrar",
                "sInfoFiltered": "- filtrando por _MAX_ registros",
                "sInfoThousands": "\'",
                "sLengthMenu": "Mostrar <select>"+
                    "<option value=\"10\">10</option>"+
                    "<option value=\"25\">25</option>"+
                    "<option value=\"50\">50</option>"+
                    "<option value=\"-1\">Todos</option>"+
                    "</select> registros",
                "sLoadingRecords": "Cargando citas...",
                "sProcessing": "Cargando citas...",
                "sSearch": "Buscar:",
                "sZeroRecords": "No hay registros que mostrar."
            }
        });
        /* FIN tabla citas */
        
    });
//-->
</script>
    
    <?php 
    
    // Menu
    $this->start('menu');        
    echo $this->element('/menu');
    $this->end(); 
?>


<!-- Cuerpo -->
<div>
    <fieldset>
        <legend><?php echo __('Ficha de la Especie'); ?><span class="pull-right"><?php echo __("Número de citas: " )."<b>".count($especie['Citas'])."</b>";?></span></legend>
        
        <input type="hidden" name="especieId" id="especieId" value="<?php echo $especie['Especie']['id'];?>"/>
        
        <div class="row-fluid">
            <div class="span12 contenedor_azul">
                <h3 style="line-height: 20px;">
                    <?php echo $especie['Especie']['nombreComun']."<span style='font-weight: normal;'> (<em>".$especie['Especie']['genero']." ".$especie['Especie']['especie']." ".$especie['Especie']['subespecie']."</em>)</span>"; ?>
                </h3>
                <p><?php echo __("En inglés").": ".$especie['Especie']['nombreIngles'];?></p>
                <h5><em><?php echo $especie['Familia']['nombre'];?>, <?php echo $especie['OrdenTaxonomico']['nombre'];?></em></h5>
            </div>
        </div>
        <br>
        <div class="row-fluid">
            <div class="span4 yoxview">
                <?php if(file_exists("../webroot/img/especie/".$especie['Especie']['id'].".jpg")) {?>
                    <a href="/img/especie/<?php echo $especie['Especie']['id'];?>.jpg"><img alt="<?php echo $especie['Especie']['nombreIngles'];?>" src="/img/especie/<?php echo $especie['Especie']['id'];?>.jpg" class="img-polaroid" width="360" height="270"></a>
                <?php } else {?>
                    <img src="/img/messages/AAAAAA&text=Sin+imagen_360x270.gif" />
                <?php }?>
            </div>
            <div class="span8">
                <?php 
                    if(isset($especie['ProteccionLr']['codigo'])) {
                        echo "<p><span class='label ".$this->Especie->obtener_color_proteccion_lr($especie['ProteccionLr']['codigo'])."'>".$especie['ProteccionLr']['nombre']."</span>".__(" según el ")."<em><b>".__("Libro Rojo de las Aves de España")."</b></em></p>";
                    }
                    if(isset($especie['ProteccionClm']['codigo'])) {
                        echo "<p><span class='label ".$this->Especie->obtener_color_proteccion_clm($especie['ProteccionClm']['codigo'])."'>".$especie['ProteccionClm']['nombre']."</span>".__(" en ")."<b>".__("Castilla - La Mancha")."</b></p>";
                    }
                    if(isset($especie['EstatusCuantitativoAb']['nombre'])) {
                        echo "<p><span class='label label-info'>".$especie['EstatusCuantitativoAb']['nombre']."</span>".__(" en ")."<b>".__("Albacete")."</b></p>";
                    }
                    if(isset($especie['EstatusReproductivoAb']['nombre'])) {
                        echo "<p><span class='label label-info'>".$especie['EstatusReproductivoAb']['nombre']."</span>".__(" en ")."<b>".__("Albacete")."</b></p>";
                    }
                ?>
                <hr>
                <h5>
                  <?php echo __("En la provincia de Albacete...");?>
                </h5>
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p>
                        <i class="icon-info-sign"></i>
                        &nbsp;
                        <?php echo __('El comentario está siendo actualizando y actualmente se muestra el del Anuario Ornitológico de la Provincia de Albacete 1997-1998.'); ?>
                    </p>
                </div>
                <p><?php echo $especie['Especie']['comentarioHistorico'];?></p>
            </div>
        </div>
        
        <br>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#mapa_distribucion"><?php echo __("Mapa de Distribución");?></a></li>
            <li><a data-toggle="tab" href="#citas"><?php echo __("Citas");?></a></li>
            <li><a data-toggle="tab" href="#estadisticas"><?php echo __("Estadísticas");?></a></li>
            <li><a data-toggle="tab" href="#fotos"><?php echo __("Fotos");?></a></li>
        </ul>
        <div id="especie_tab_content" class="tab-content">
        
            <div id="fotos" class="tab-pane fade">
            
                <?php 
                    if(isset($especie['Fotos']) && count($especie['Fotos']) > 0) {
                        
                        //echo '<div class="thumbnails yoxview">';
                        $i = 0;
                        foreach ($especie['Fotos'] as $citaFoto) {
                            foreach ($citaFoto['Fichero'] as $foto) {
                                
                            if($i % 4 == 0) {
                                echo '<ul class="thumbnails yoxview">';
                            }
                            echo '<li class="span3">';
                            echo    '<div class="thumbnail">';
                            echo        '<a href="'.$foto['ruta'].$foto['nombreFisico'].'"><img src="'.$foto['ruta'].$foto['nombreFisico'].'" alt="'.$citaFoto['Especie']['nombreComun'].'" title="'.$citaFoto['Especie']['nombreComun'].'"></a>';
                            echo        '<p>Foto realizada por '.$citaFoto['ObservadorPrincipal']['nombre'].' en '.$citaFoto['Lugar']['nombre'].' el '.date_format(date_create($citaFoto['Cita']['fechaAlta']), "d/m/Y").'</p>';
                            echo    '</div>';
                            echo '</li>';
                            
                            if($i + 1 % 4 == 0) {
                                echo '</ul>';
                            }
                                
                                //echo     '<a href="'.$foto['ruta'].$foto['nombreFisico'].'" class="thumbnail span3">';
                                //echo         '<img src="'.$foto['ruta'].$foto['nombreFisico'].'" 
                                //                title="'.$foto['descripcion'].'" 
                                //                alt="Foto realizada por '.$citaFoto['Cita']['usuario_id'].' en '.$citaFoto['Cita']['lugar_id'].' el '.date_format(date_create($citaFoto['Cita']['fechaAlta']), "d/m/Y").'"/>';  
                                //echo     '</a>';
                            }
                        } 
                        
                        //echo '</div>';
                    }
                    else {
                        echo '<div class="thumbnail" style="width: 360px; height: 270px;">';
                        echo '<img src="/img/messages/AAAAAA&text=No+hay+fotos_360x270.gif" />';
                        echo '</div>';
                    }
                ?>
                
            </div>
            <div id="citas" class="tab-pane fade">
            
                <table id="tabla_citas" class="table table-striped table-bordered table-hover table-condensed">    
                    <thead>
                        <tr>
                            <th style="text-align: center;"><?php echo __("Ver más");?></th>
                            <th style="text-align: center;"><?php echo __("Especie");?></th>
                            <th style="text-align: center;"><?php echo __("Fecha");?></th>
                            <th style="text-align: center;"><?php echo __("Lugar");?></th>
                            <th style="text-align: center;"><?php echo __("Número de Aves");?></th>
                            <th style="text-align: center;"><?php echo __("Observador");?></th>
                            <th style="text-align: center;"><?php echo __("Colaboradores");?></th>
                            <th style="text-align: center;"><?php echo __("Clase de Reproducción");?></th>
                            <th style="text-align: center;"><?php echo __("Importancia");?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="100%" class="dataTables_empty"><?php echo __("Cargando citas...");?> <img src="/img/gif/cargando_barra_mini.gif"></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="text-align: center;"><?php echo __("Ver más");?></th>
                            <th style="text-align: center;"><?php echo __("Especie");?></th>
                            <th style="text-align: center;"><?php echo __("Fecha");?></th>
                            <th style="text-align: center;"><?php echo __("Lugar");?></th>
                            <th style="text-align: center;"><?php echo __("Número de Aves");?></th>
                            <th style="text-align: center;"><?php echo __("Observador");?></th>
                            <th style="text-align: center;"><?php echo __("Colaboradores");?></th>
                            <th style="text-align: center;"><?php echo __("Clase de Reproducción");?></th>
                            <th style="text-align: center;"><?php echo __("Importancia");?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div id="estadisticas" class="tab-pane fade">
                <div class="row-fluid">
                    <div class="span6">
                         <fieldset>
                            <legend class="small">
                                    <?php echo __('Opciones de configuración del gráfico'); ?>
                                    <button class="btn btn-mini btn-info pull-right help-button"
                                        data-trigger="click" data-placement="bottom" data-html="true"
                                        data-content="<?php echo __('Puedes modificar las opciones de abajo para configurar el gráfico a tu gusto. <br> No olvides pulsar el botón <b>Actualizar gráfico</b> para que tus cambios se reflejen en el gráfico.');?>">
                                        <i class="icon-info-sign"></i> 
                                        <?php echo __("Ayuda");?>
                                    </button>
                            </legend>
                            
                            <form id="frm_estadisticas" action="" method="post" class="form-inline">
                                
                                <div id="errorMessagesGrafico" class="alert alert-error" style="display: none; padding-left: 14px;">
                                    <h5>Por favor, corrija los errores en el formulario:</h5>
                                    <ul></ul>
                                </div>
                                
                                <!-- Numero -->
                                <div class="control-group" style="margin-bottom: 20px">
                                    <label class="control-label label-header" for="numeroDe"><?php echo __("Número de")?></label>
                                    <div class="controls">
                                        <label class="radio inline"><input name="numeroDe" value="aves" checked="checked" type="radio"> <?php echo __("Aves")?> </label> 
                                        <label class="radio inline"> <input name="numeroDe" value="citas" type="radio"> <?php echo __("Citas")?> </label> 
                                    </div>
                                </div>

                                <!-- Zona geográfica -->
                                <div class="control-group" style="margin-bottom: 20px">
                                    <label class="control-label label-header" for="zonaGeografica"><?php echo __("Zona geográfica")?></label>
                                    <div>
                                        <select id="zonaGeografica" name="zonaGeografica" style="margin-right: 20px;">
                                            <option value="provincia" selected="selected"><?php echo __("Provincia")?></option>
                                            <option value="municipio"><?php echo __("Municipio")?></option>
                                            <option value="lugar"><?php echo __("Lugar")?></option>
                                            <option value="cuadriculaUtm"><?php echo __("Cuadricula UTM")?></option>
                                        </select>
                                        <!-- Municipios -->
                                        <select name="municipios" id="municipios" style="display: none;">
                                        <?php 
                                            foreach ($municipios as $municipio) {
                                                echo "<option value ='".$municipio['Municipio']['id']."'>".$municipio['Municipio']['nombre']."</option>";
                                            }
                                        ?>
                                        </select>
                                        <!-- Lugares -->
                                        <select name="lugares" id="lugares" style="display: none;">
                                            <?php 
                                                foreach ($lugares as $lugar) {
                                                    echo "<option value ='".$lugar['Lugar']['id']."'>".$lugar['Lugar']['nombre']."</option>";
                                                }
                                            ?>
                                        </select>
                                        <!-- Cuadrícula UTM -->
                                        <select name="cuadriculas_utm" id="cuadriculas_utm" style="display: none;">
                                            <?php 
                                                foreach ($cuadriculas_utm as $cuadricula_utm) {
                                                    echo "<option value ='".$cuadricula_utm['CuadriculaUtm']['id']."'>".$cuadricula_utm['CuadriculaUtm']['codigo']."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Periodo -->
                                <div class="control-group">
                                    <label class="control-label label-header" for="periodo"><?php echo __("Periodo")?></label>
                                    <div>
                                        <select id="periodo" name="periodo" style="margin-right: 20px;">
                                            <option value="anio" selected="selected"><?php echo __("Año")?></option>
                                            <option value="anios"><?php echo __("Intervalo de años")?></option>
                                            <option value="fechas"><?php echo __("Intervalo de fechas")?></option>
                                        </select>
                                        <!-- Año -->
                                        <select name="anio" id="anio">
                                        <?php 
                                            foreach ($anios as $anio) {
                                                echo "<option value ='".$anio[0]['anio']."'>".$anio[0]['anio']."</option>";
                                            }
                                        ?>
                                        </select>
                                        <!-- Intervalo años -->
                                        <div id="intervaloAnios" style="display: none;">
                                            <label class="add-on"  for="anioDesde"><?php echo __("Desde")?></label>
                                            <select name="anioDesde" id="anioDesde" class="anioDesdeMenorAnioHasta">
                                            <?php 
                                                foreach ($anios as $anio) {
                                                    echo "<option value ='".$anio[0]['anio']."'>".$anio[0]['anio']."</option>";
                                                }
                                            ?>
                                            </select>
                                            <label class="add-on" for="anioHasta" style="margin-left: 20px;"><?php echo __("Hasta")?></label>
                                            <select name="anioHasta" id="anioHasta" class="anioHastaMayorAnioDesde">
                                            <?php 
                                                foreach ($anios as $anio) {
                                                    echo "<option value ='".$anio[0]['anio']."'>".$anio[0]['anio']."</option>";
                                                }
                                            ?>
                                            </select>
                                        </div>
                                        <!-- Intervalo fechas -->
                                        <div id="intervaloFechas" style="display: none;">
                                            <div  class="input-append">
                                                <input type="text" id="fechaDesde" name="fechaDesde" size="10" class="date-picker" style="width: auto;" placeholder="Desde"/>
                                                <label for="fechaDesde" class="add-on" style="margin-right: 20px;"><i class="icon-calendar"></i></label>
                                            </div>
                                            <div  class="input-append">
                                                <input type="text" id="fechaHasta" name="fechaHasta" size="10" class="date-picker" style="width: auto;" placeholder="Hasta"/>
                                                <label for="fechaHasta" class="add-on" style="margin-right: 20px;"><i class="icon-calendar"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="padding: 20px; text-align: center;">
                                    <input type="submit" id="btn_actualizar_grafico" value="<?php echo __("Actualizar gráfico");?>" class="btn btn-success"/>
                                </div>
                            </form>
                        </fieldset>
                    </div>
                    <div class="span6">
                        <fieldset>
                            <legend class="small"><?php echo __('Gráfico'); ?></legend>
                            <div id="div_grafico" class="contenedor_gris">
                                <!-- Aqui va el gráfico generado dinamicamente -->
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
            <div id="mapa_distribucion" class="tab-pane fade active in">
                <div class="row-fluid">
                    <div class="span6">
                         <fieldset>
                            <legend class="small">
                                <?php echo __('Opciones de configuración del mapa'); ?>
                                <button class="btn btn-mini btn-info pull-right help-button"
                                    data-trigger="click" data-placement="bottom" data-html="true"
                                    data-content="<?php echo __('<p>Puedes modificar las opciones de abajo para configurar el mapa a tu gusto. <br> No olvides pulsar el botón <b>Actualizar mapa</b> para que tus cambios se reflejen en el mapa.</p>');?>">
                                    <i class="icon-info-sign"></i> 
                                    <?php echo __("Ayuda");?>
                                </button>
                            </legend>
                            
                            <form id="frm_mapa_distribucion" action="" method="post">
                            
                                <?php echo $this->Session->flash('mensajesMapaContainer');?>
                            
                                <!-- División geográfica -->
                                <div class="control-group" style="margin-bottom: 20px">
                                    <label class="control-label label-header" for="divisionGeografica"><?php echo __("División geográfica")?></label>
                                    <div class="input-append">
                                        <select id="divisionGeografica" name="divisionGeografica">
                                            <option value="porUtm" selected="selected"><?php echo __("Cuadrículas UTM")?></option>
                                            <option value="porMunicipio"><?php echo __("Municipios")?></option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Tipo distribución -->
                                <div class="control-group" style="margin-bottom: 20px">
                                    <label class="control-label label-header" for="tipoDistribucion"><?php echo __("Tipo de distribución")?></label>
                                    <div class="input-append">
                                        <select id="tipoDistribucion" name="tipoDistribucion">
                                            <option value="geografica" selected="selected"><?php echo __("Geográfica")?></option>
                                            <option value="cuantitativa"><?php echo __("Cuantitativa")?></option>
                                            <option value="categoriaReproduccion"><?php echo __("Categoría de reproducción")?></option>
                                        </select>
                                    </div>
                                </div>
                                <div style="padding: 20px; text-align: center;">
                                    <button id="btn_actualizar_mapa" class="btn btn-success" type="button"><?php echo __("Actualizar mapa");?></button>
                                </div>
                            </form>
                        </fieldset>
                    </div>
                    <div class="span6">
                        <fieldset>
                            <legend id="tituloMapa" class="small"></legend>
                            <div id="mapa" style="height:400px;"></div>
                            <div id="leyenda" class="alert alert-block alert-info" style="margin-top: 20px;">
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </fieldset>
</div>

<!-- Pie -->
<?php 
    $this->start('pie');        
    echo $this->element('/pie');
    $this->end(); 
?>      

<?php echo $this->Js->writeBuffer();?>