<?php

// Informamos el título
$this->set('title_for_layout','Ficha de '.$especie['Especie']['nombreComun']);

/**
 * CSS
 */
$this->Html->css(array(
    'datatables-bootstrap',
    'Especie/view'
), null, array('inline' => false));

/**
 * Javascript
 */
$this->Html->script(array(
    '/plugin/DataTables-1.9.4/media/js/jquery.dataTables.min',
    'datatables-bootstrap',
    '/plugin/jquery-validation-1.11.1/dist/jquery.validate.min',
    '/plugin/jquery-validation-1.11.1/localization/messages_es',
    '/plugin/yoxview/yoxview-init',
    'https://maps.googleapis.com/maps/api/js?key=AIzaSyCvHe5uH6Ogczm4OWoXkq8_NiwspG4oE1I',
    'common/maps/geoxml3/geoxml3.js',
    'common/maps/geoxml3/ProjectedOverlay.js',
    'common/maps/functions',
    'Especie/view'
), array('inline' => false));
?>

<script type="text/javascript">
    $(document).ready(function() {

        /**
         * Cargar calendarios
         */
        $( "#fechaDesde" ).datepicker({
            yearRange: "<?=$anios[count($anios) - 1 ][0]['anio'];?>:<?=date("Y");?>",
            changeMonth: true,
            changeYear: true,
            onClose: function( selectedDate ) {
                $( "#fechaHasta" ).datepicker( "option", "minDate", selectedDate );
            }
        });
        $( "#fechaHasta" ).datepicker({
            yearRange: "<?=$anios[count($anios) - 1 ][0]['anio'];?>:<?=date("Y");?>",
            changeMonth: true,
            changeYear: true,
            onClose: function( selectedDate ) {
                 $( "#fechaDesde" ).datepicker( "option", "maxDate", selectedDate );
            }
        });
        // Fin cargar calendarios

        /* INICIO tabla citas */
        $("#tabla_citas").dataTable({
            "aLengthMenu": [[10, 25, 50], [10, 25, 50]],
            "iDisplayLength": 25,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "<?=$this->Html->Url(array('controller' => 'citaAjax', 'action' => 'obtenerCitasEspecieDatatables', time(), "?" => array("especieId" => $especie['Especie']['id']))); ?>",
            "sDom": "<\'row\'<\'span9\'l><\'span3\'f>r>t<\'row\'<\'span8\'i><\'span4\'p>>",
            "sWrapper": "dataTables_wrapper form-inline",
            "bPaginate": true,
            "sPaginationType": "bootstrap",
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ 0,1,8 ] },
                { "sClass": "text-center", "aTargets": [ 0,1,2,4,5,7,8,9,10,11 ] }
            ],
            "aoColumns": [null,null,null,null,{ "sType": "date-uk" },null,null,null,null,null,null],
            "bInfo": true,
            "bAutoWidth": false,
            "oLanguage": {
                "sUrl": "/lang/es/datatables.json"
            }
        });
        /* FIN tabla citas */
    });
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
        <legend><?=__('Ficha de la Especie'); ?><span class="pull-right"><?=__("Número de citas: " )."<b>".count($especie['Citas'])."</b>";?></span></legend>

        <input type="hidden" name="especieId" id="especieId" value="<?=$especie['Especie']['id'];?>"/>

        <div class="row-fluid">
            <div class="span12 contenedor_azul">
                <h3 style="line-height: 20px;">
                    <?=$especie['Especie']['nombreComun']."<span style='font-weight: normal;'> (<em>".$especie['Especie']['genero']." ".$especie['Especie']['especie']." ".$especie['Especie']['subespecie']."</em>)</span>"; ?>
                </h3>
                <p><?=__("En inglés").": ".$especie['Especie']['nombreIngles'];?></p>
                <h5><em><?=$especie['Familia']['nombre'];?>, <?=$especie['OrdenTaxonomico']['nombre'];?></em></h5>
            </div>
        </div>
        <br>
        <div class="row-fluid">
            <div class="span4 yoxview">
                <?php if(file_exists("../webroot/img/especie/".$especie['Especie']['id'].".jpg")) : ?>
                    <a href="/img/especie/<?=$especie['Especie']['id'];?>.jpg"><img alt="<?=$especie['Especie']['nombreIngles'];?>" src="/img/especie/<?=$especie['Especie']['id'];?>.jpg" class="img-polaroid" width="360" height="270"></a>
                <?php else : ?>
                    <img src="/img/messages/AAAAAA&text=Sin+imagen_360x270.gif" />
                <?php endif ?>
            </div>
            <div class="span8">
                <?php if(isset($especie['ProteccionLr']['codigo'])) : ?>
                    <p><span class='label <?=$this->Especie->obtener_color_proteccion_lr($especie['ProteccionLr']['codigo'])?>'><?=$especie['ProteccionLr']['nombre']?></span><?=__(" según el ")?><em><b><?=__("Libro Rojo de las Aves de España")?></b></em></p>
                <?php endif ?>
                <?php if(isset($especie['ProteccionClm']['codigo'])) : ?>
                    <p><span class='label <?=$this->Especie->obtenerEtiquetaProteccionClmPorCodigo($especie['ProteccionClm']['codigo'])?>'><?=$especie['ProteccionClm']['nombre']?></span><?=__(" en ")?><b>Castilla - La Mancha</b></p>
                <?php endif ?>
                <?php if(isset($especie['EstatusCuantitativoAb']['nombre'])) : ?>
                    <p><span class='label label-info'><?=$especie['EstatusCuantitativoAb']['nombre']?></span><?=__(" en ")?><b>Albacete</b></p>
                <?php endif ?>
                <?php if(isset($especie['EstatusReproductivoAb']['nombre'])) : ?>
                    <p><span class='label label-info'><?=$especie['EstatusReproductivoAb']['nombre']?></span><?=__(" en ")?><b>Albacete</b></p>
                <?php endif ?>
                <hr>
                <h5>
                  <?=__("En la provincia de Albacete...");?>
                </h5>
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <span class="label label-info">Aviso</span>
                    &nbsp;
                    <?=__('El comentario está siendo actualizando y actualmente se muestra el del Anuario Ornitológico de la Provincia de Albacete 1997-1998.'); ?>
                </div>
                <p><?=$especie['Especie']['comentarioHistorico'];?></p>
            </div>
        </div>

        <br>

        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#mapa_distribucion"><?=__("Mapa de Distribución");?></a></li>
            <li><a data-toggle="tab" href="#citas"><?=__("Citas");?></a></li>
            <li><a data-toggle="tab" href="#estadisticas"><?=__("Estadísticas");?></a></li>
            <li><a data-toggle="tab" href="#fotos"><?=__("Fotos");?></a></li>
        </ul>
        <div id="especie_tab_content" class="tab-content">

            <div id="fotos" class="tab-pane fade">

                <?php if(isset($especie['Fotos']) && count($especie['Fotos']) > 0) : ?>
                    <ul class="thumbnails yoxview">
                    <?php foreach ($especie['Fotos'] as $citaFoto) : ?>
                        <?php foreach ($citaFoto['Fichero'] as $foto) : ?>
                            <li class="span3">
                                <div class="thumbnail">
                                    <a href="<?=$foto['ruta'].$foto['nombreFisico']?>">
                                        <img src="<?=$foto['ruta'].$foto['nombreFisico']?>"
                                             alt="<?=$citaFoto['Especie']['nombreComun']?>"
                                             title="<?=$citaFoto['Especie']['nombreComun']?>">
                                    </a>
                                    <p style="margin-top: 10px">
                                        <?=__('Foto realizada por ')?><?=$citaFoto['ObservadorPrincipal']['nombre']?><?=__(' en ')?><?=$citaFoto['Lugar']['nombre']?><?=__(' el ')?><?=date_format(date_create($citaFoto['Cita']['fechaAlta']), "d/m/Y")?>
                                    </p>
                                </div>
                            </li>
                        <?php endforeach ?>
                    <?php endforeach ?>
                    </ul>
                <?php else : ?>
                    <div class="thumbnail" style="width: 360px; height: 270px;">
                        <img src="/img/messages/AAAAAA&text=No+hay+fotos_360x270.gif" />
                    </div>
                <?php endif ?>
            </div>
            <div id="citas" class="tab-pane fade">

                <table id="tabla_citas" class="table table-striped table-bordered table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><?=__("Ver más");?></th>
                            <th><?=__("Importancia");?></th>
                            <th><?=__("Fotos");?></th>
                            <th><?=__("Especie");?></th>
                            <th><?=__("Fecha");?></th>
							<th><?=__("Hora");?></th>
                            <th><?=__("Lugar");?></th>
                            <th><?=__("Número de Aves");?></th>
                            <th><?=__("Observador");?></th>
                            <th><?=__("Colaboradores");?></th>
                            <th><?=__("Clase de Reproducción");?></th>
                            <th><?=__("Criterio de Selección");?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="100%" class="dataTables_empty"><img src="/img/gif/cargando_barra_mini.gif"></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th><?=__("Ver más");?></th>
                            <th><?=__("Importancia");?></th>
                            <th><?=__("Fotos");?></th>
                            <th><?=__("Especie");?></th>
                            <th><?=__("Fecha");?></th>
							<th><?=__("Hora");?></th>
                            <th><?=__("Lugar");?></th>
                            <th><?=__("Número de Aves");?></th>
                            <th><?=__("Observador");?></th>
                            <th><?=__("Colaboradores");?></th>
                            <th><?=__("Clase de Reproducción");?></th>
                            <th><?=__("Criterio de Selección");?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div id="estadisticas" class="tab-pane fade">
                <div class="row-fluid">
                    <div class="span6">
                         <fieldset>
                            <legend class="small">
                                    <?=__('Opciones de configuración del gráfico'); ?>
                                    <button class="btn btn-mini btn-info pull-right help-button"
                                        data-trigger="click" data-placement="bottom" data-html="true"
                                        data-content="<?=__('Puedes modificar las opciones de abajo para configurar el gráfico a tu gusto. <br> No olvides pulsar el botón <b>Actualizar gráfico</b> para que tus cambios se reflejen en el gráfico.');?>">
                                        <i class="icon-info-sign"></i>
                                        <?=__("Ayuda");?>
                                    </button>
                            </legend>

                            <form id="frm_estadisticas" action="" method="post" class="form-inline">

                                <div id="errorMessagesGrafico" class="alert alert-error" style="display: none; padding-left: 14px;">
                                    <h5><?=__('Por favor, corrija los errores en el formulario')?>:</h5>
                                    <ul></ul>
                                </div>

                                <!-- Numero -->
                                <div class="control-group" style="margin-bottom: 20px">
                                    <label class="control-label label-header" for="numeroDe"><?=__("Número de")?></label>
                                    <div class="controls">
                                        <label class="radio inline"><input name="numeroDe" value="aves" checked="checked" type="radio"> <?=__("Aves")?> </label>
                                        <label class="radio inline"> <input name="numeroDe" value="citas" type="radio"> <?=__("Citas")?> </label>
                                    </div>
                                </div>

                                <!-- Zona geográfica -->
                                <div class="control-group" style="margin-bottom: 20px">
                                    <label class="control-label label-header" for="zonaGeografica"><?=__("Zona geográfica")?></label>
                                    <div>
                                        <select id="zonaGeografica" name="zonaGeografica" style="margin-right: 20px;">
                                            <option value="provincia" selected="selected"><?=__("Provincia")?></option>
											<option value="comarca"><?=__("Comarca")?></option>
                                            <option value="municipio"><?=__("Municipio")?></option>
                                            <option value="lugar"><?=__("Lugar")?></option>
                                            <option value="cuadriculaUtm"><?=__("Cuadricula UTM")?></option>
                                        </select>
										<!-- Comarcas -->
										<select name="comarcas" id="comarcas" style="display: none;">
											<?php foreach ($comarcas as $comarca) : ?>
												<option value='<?=$comarca['Comarca']['id']?>'><?=$comarca['Comarca']['nombre']?></option>
											<?php endforeach ?>
										</select>
                                        <!-- Municipios -->
                                        <select name="municipios" id="municipios" style="display: none;">
                                        <?php foreach ($municipios as $municipio) : ?>
                                            <option value='<?=$municipio['Municipio']['id']?>'><?=$municipio['Municipio']['nombre']?></option>
                                        <?php endforeach ?>
                                        </select>
                                        <!-- Lugares -->
                                        <select name="lugares" id="lugares" style="display: none;">
                                            <?php foreach ($lugares as $lugar) : ?>
                                                <option value ='<?=$lugar['Lugar']['id']?>'><?=$lugar['Lugar']['nombre']?></option>
                                            <?php endforeach ?>
                                        </select>
                                        <!-- Cuadrícula UTM -->
                                        <select name="cuadriculas_utm" id="cuadriculas_utm" style="display: none;">
                                            <?php foreach ($cuadriculas_utm as $cuadricula_utm) : ?>
                                                <option value ='<?=$cuadricula_utm['CuadriculaUtm']['id']?>'><?=$cuadricula_utm['CuadriculaUtm']['codigo']?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Periodo -->
                                <div class="control-group">
                                    <label class="control-label label-header" for="periodo"><?=__("Periodo")?></label>
                                    <div>
                                        <select id="periodo" name="periodo" style="margin-right: 20px;">
                                            <option value="anio" selected="selected"><?=__("Año")?></option>
                                            <option value="anios"><?=__("Intervalo de años")?></option>
                                            <option value="fechas"><?=__("Intervalo de fechas")?></option>
                                        </select>
                                        <!-- Año -->
                                        <select name="anio" id="anio">
                                        <?php foreach ($anios as $anio) : ?>
                                            <option value='<?=$anio[0]['anio']?>'><?=$anio[0]['anio']?></option>
                                        <?php endforeach ?>
                                        </select>
                                        <!-- Intervalo años -->
                                        <div id="intervaloAnios" style="display: none;">
                                            <label class="add-on"  for="anioDesde"><?=__("Desde")?></label>
                                            <select name="anioDesde" id="anioDesde" class="anioDesdeMenorAnioHasta">
                                            <?php foreach ($anios as $anio) : ?>
                                                <option value='<?=$anio[0]['anio']?>'><?=$anio[0]['anio']?></option>
                                            <?php endforeach ?>
                                            </select>
                                            <label class="add-on" for="anioHasta" style="margin-left: 20px;"><?=__("Hasta")?></label>
                                            <select name="anioHasta" id="anioHasta" class="anioHastaMayorAnioDesde">
                                            <?php foreach ($anios as $anio) : ?>
                                                <option value ='<?=$anio[0]['anio']?>'><?=$anio[0]['anio']?></option>
                                            <?php endforeach ?>
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
                                    <input type="submit" id="btn_actualizar_grafico" value="<?=__("Actualizar gráfico");?>" class="btn btn-success"/>
                                </div>
                            </form>
                        </fieldset>
                    </div>
                    <div class="span6">
                        <fieldset>
                            <legend class="small"><?=__('Gráfico'); ?></legend>
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
                                <?=__('Opciones de configuración del mapa'); ?>
                                <button class="btn btn-mini btn-info pull-right help-button"
                                    data-trigger="click" data-placement="bottom" data-html="true"
                                    data-content="<?=__('<p>Puedes modificar las opciones de abajo para configurar el mapa a tu gusto. <br> No olvides pulsar el botón <b>Actualizar mapa</b> para que tus cambios se reflejen en el mapa.</p>');?>">
                                    <i class="icon-info-sign"></i>
                                    <?=__("Ayuda");?>
                                </button>
                            </legend>

                            <form id="frm_mapa_distribucion" action="" method="post">

                                <?=$this->Session->flash('mensajesMapaContainer');?>

                                <!-- División geográfica -->
                                <div class="control-group" style="margin-bottom: 20px">
                                    <label class="control-label label-header" for="divisionGeografica"><?=__("División geográfica")?></label>
                                    <div class="input-append">
                                        <select id="divisionGeografica" name="divisionGeografica">
                                            <option value="porUtm" selected="selected"><?=__("Cuadrículas UTM")?></option>
                                            <option value="porMunicipio"><?=__("Municipios")?></option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Tipo distribución -->
                                <div class="control-group" style="margin-bottom: 20px">
                                    <label class="control-label label-header" for="tipoDistribucion"><?=__("Tipo de distribución")?></label>
                                    <div class="input-append">
                                        <select id="tipoDistribucion" name="tipoDistribucion">
                                            <option value="geografica" selected="selected"><?=__("Geográfica")?></option>
                                            <option value="cuantitativa"><?=__("Cuantitativa")?></option>
                                            <option value="categoriaReproduccion"><?=__("Categoría de reproducción")?></option>
                                        </select>
                                    </div>
                                </div>
                                <div style="padding: 20px; text-align: center;">
                                    <button id="btn_actualizar_mapa" class="btn btn-success" type="button"><?=__("Actualizar mapa");?></button>
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

<?=$this->Js->writeBuffer();?>
