<?php
// Informamos el título
$title = 'Editar cita '.$cita['Cita']['id'];
$this->set('title_for_layout',$title);

/**
 * CSS
 */
$this->Html->css(array('datatables-bootstrap', 'Cita/edit'), null, array('inline' => false));

/**
 * Javascript
 */
$this->Html->script(array(
    '/plugin/jquery-validation-1.11.1/dist/jquery.validate.min',
    '/plugin/jquery-validation-1.11.1/dist/additional-methods.min',
    '/plugin/jquery-validation-1.11.1/localization/messages_es',
    '/plugin/yoxview/yoxview-init',
    'https://maps.googleapis.com/maps/api/js?key=AIzaSyCvHe5uH6Ogczm4OWoXkq8_NiwspG4oE1I',
    'common/maps/geoxml3/geoxml3.js',
    'common/maps/geoxml3/ProjectedOverlay.js',
    '/plugin/DataTables-1.9.4/media/js/jquery.dataTables',
    'datatables-bootstrap',
    '/plugin/bootbox/bootbox.min',
    'common/maps/functions',
    'common/Especie/funciones',
    'common/Lugar/funciones',
    'common/Cita/funciones',
    'common/ObservadorPrimario/funciones',
    'common/ObservadorSecundario/funciones',
    'Cita/edit'
), array('inline' => false));

// Menu
$this->start('menu');
echo $this->element('/menu');
$this->end();
?>

<script type="text/javascript">

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
    geoXmlUtm = new geoXML3.parser({
        map: map,
        singleInfoWindow: true,
        zoom: false,
        afterParse: useTheData
    });
    
    // Tratamos el archivo
    geoXmlUtm.parse('/kml/UTM_AB.kml');
    
     // GeoXML para añadir eventos
    geoXmlMunicipios = new geoXML3.parser({
        map: map,
        singleInfoWindow: true,
        zoom: false,
        afterParse: useTheData
    });
    
    // Tratamos el archivo
    geoXmlMunicipios.parse('/kml/municipios_AB.kml');
    
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

                if(placemark.name == '<?=$cita['Lugar']['CuadriculaUtm']['codigo'];?>') {
                    placemark.polygon.setOptions(highlightOptions); 
                }
            }
        }
    }
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>

<?php if (isset($warnings)): ?>
    <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <p><?=__('Hubo algún problema al guardar la cita:') ?></p>
        <ul>
            <?php foreach ($warnings as $warning) : ?>
                <li><?=$warning?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>

<!-- Cuerpo -->
<div id="divEditarCita">

    <fieldset>
        <legend>
        <?=__('Editar cita: ').$cita['Cita']['id']; ?>
        &nbsp;&nbsp;
        <?php
            echo $this->Importancia->getIconoImportancia($cita['ImportanciaCita']['id'], $cita['ImportanciaCita']['descripcion']);
        if ($cita['Especie']['Especie']['indRareza'] == 1) {
            if ($cita['Cita']['indRarezaHomologada'] == 3) {
                echo '<span class="label label-success text-info rareza-message">Rareza homologada</span>';
            } else {
                echo '<span class="label label-warning text-info rareza-message">Rareza pendiente de homologar</span>';
            }
        }
        ?>
        </legend>
        
        <div class="well well-small">
            Los campos marcados con un asterisco (*) son obligatorios
        </div>

        <div id="errorMessagesGrafico" class="alert alert-error"
            style="display: none; padding-left: 14px;">
            <h5>Por favor, corrija los errores en el formulario:</h5>
            <ul></ul>
        </div>

        <form id="frmEditarCita" class="form-horizontal" method="post"
            enctype="multipart/form-data">
            
            <input type="hidden" id="citaId" name="citaId" value="<?=$cita['Cita']['id'];?>"/>

            <div class="row">
            
                <div class="span6">
                
                    <!-- Especie-->
                    <div class="control-group">
                        <label class="control-label" style="width: 100px;" for="especie"> <?=__("Especie");?>&nbsp;(*)
                            <br/>
                            <span class="badge badge-info" data-trigger="hover"
                                  data-content="<?=__('Escribe tres letras del nombre común, género o especie y selecciona una especie de la lista. Además, una vez seleccionada una especie, podrás seleccioanr su subespecie escribiendo su primera letra y seleccioando una del listado.');?>"><i
                                    class="icon-info-sign icon-white"></i> </span>
                        </label>
                        <div class="controls" style="margin-left: 120px;">
                            <div class="dummy">
                                <input class="especie input-xxlarge" name="especie"
                                    type="text"
                                    value="<?=$cita['Especie']['Especie']['nombreComun'].", ".$cita['Especie']['Especie']['genero']." ".$cita['Especie']['Especie']['especie'];?>"
                                    placeholder="<?=__('Escriba el nombre común o el nombre científico');?>">
                                <input name="subespecie" class="subespecie input-large" type="text" placeholder="<?=__('Escriba la subespecie'); ?>"
                                       value="<?=$cita['Especie']['Especie']['subespecie'];?>">
                                <div class="especieSeleccionadaContenedor"
                                    style="margin-top: 5px;">
                                    <?=__("Especie seleccionada");?>:
                                    <span class="especieSeleccionada text-success" style="font-weight: bold;">
                                        <?=$cita['Especie']['Especie']['nombreComun'].", ".$cita['Especie']['Especie']['genero']." ".$cita['Especie']['Especie']['especie'];?>
                                    </span>
                                </div>
                                <div class="subespecieSeleccionadaContenedor" style="margin-top: 5px;">
                                    <?=__("Subespecie seleccionada");?>:
                                    <span class="subespecieSeleccionada text-success" style="font-weight: bold;"><?=$cita['Especie']['Especie']['subespecie'];?></span>
                                </div>
                                <div style="margin-top: 5px;">
                                    <button class="btnVaciarEspecie btn btn-warning btn-mini" type="button">
                                        <i class="icon-trash" style="margin-right: 10px;"></i><?=__("Limpiar");?>
                                    </button>
                                </div>
                                <input type="hidden" class="especieId" name="data[Cita][especie_id]" value="<?=$cita['Especie']['Especie']['id'];?>">
                            </div>
                        </div>
                    </div>
        
                    <!-- Fecha alta-->
                    <div class="control-group">
                        <label class="control-label" style="width: 100px;" for="fechaAlta"> <?=__("Fecha");?>&nbsp;(*)
                            <br/>
                            <span class="badge badge-info" data-trigger="hover"
                                  data-content="<?=__('Seleccione un día pulsando el calendario o escriba una fecha con formato ').date('d/m/Y')?>"><i
                                    class="icon-info-sign icon-white"></i> </span>
                        </label>
                        <div class="controls" style="margin-left: 120px;">
                            <div class="input-prepend">
                                <label for="fechaAlta" class="add-on"><i class="icon-calendar"></i></label> 
                                <input type="text" id="fechaAlta"
                                    value="<?=date_format(date_create($cita['Cita']['fechaAlta']), "d/m/Y");?>"
                                    name="data[Cita][fechaAlta]" size="10" class="date-picker"
                                    data-mask="99/99/9999" style="width: auto;"
                                    placeholder="dd/mm/aaaa" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Figuras de protección -->
                <div class="span6">
                    <p>
                       <?="<span class='label ".$this->Especie->obtener_color_proteccion_lr($cita['Especie']['ProteccionLr']['codigo'])."'>".$cita['Especie']['ProteccionLr']['nombre']."</span>".__(" según el ")."<em><b>".__("Libro Rojo de las Aves de España")."</b></em>";?>
                    </p>
                    <p>
                       <?="<span class='label ".$this->Especie->obtener_color_proteccion_clm($cita['Especie']['ProteccionClm']['codigo'])."'>".$cita['Especie']['ProteccionClm']['nombre']."</span>".__(" en ")."<b>".__("Castilla - La Mancha")."</b>";?>
                    </p>
                    <p>
                       <?="<span class='label label-info'>".$cita['Especie']['EstatusCuantitativoAb']['nombre']."</span>".__(" en ")."<b>".__("Albacete")."</b>";?>
                    </p>
                    <p>
                        <?="<span class='label label-info'>".$cita['Especie']['EstatusReproductivoAb']['nombre']."</span>".__(" en ")."<b>".__("Albacete")."</b>";?>
                    </p>
                </div>
            </div>
            <br>
            <div class="row">
    
                <!-- Datos cita -->
                <div class="span6">
                    
                <!-- Número de aves-->
                <div class="dummy" style="display: inline; text-align: center;">

                    <?=$this->element('Cita/tablaNumeroAves'); ?>

                    <div class="numeroTotalAvesDiv" style="margin-top: 5px; text-align: left; margin-bottom: 20px;">
                        <?=__("Número total aves");?>:
                        <span class="numeroTotalAvesTexto text-success" style="font-weight: bold;"><?=$cita['Cita']['cantidad'];?></span>
                    </div>
                    <input type="hidden" class="totalNumeroAves"
                        name="data[Cita][cantidad]" value="<?=$cita['Cita']['cantidad'];?>" />
                </div>
                
                <fieldset class="fsCustom">
                    <legend >Datos de los observadores</legend>
                        <!-- Observador -->
                        <div class="control-group">
                            <label class="control-label" for="observador"> <?=__("Observador");?>&nbsp;(*)</label>
                            <div class="controls">
                                <div class="dummy">
                                    <input id="observador" name="observador" class="input-xlarge"
                                        type="text" value="<?=$usuario['ObservadorPrincipal']['codigo']." - ".$usuario['ObservadorPrincipal']['nombre'];?>"
                                        placeholder="Escriba el código o el nombre del observador"> 
                                    <span class="badge badge-info" data-trigger="hover"
                                    data-content='<?=__("Escriba al menos tres letras y seleccione de la lista los observadores que quiera incluir en la cita.");?>'><i
                                        class="icon-info-sign icon-white"></i> </span>
                                    <br />
                                    <div id="observadorSeleccionadoDiv"
                                        style="margin-top: 5px;">
                                        Observador seleccionado: <span
                                            id="observadorSeleccionadoTexto" class="text-success"
                                            style="font-weight: bold;"><?=$usuario['ObservadorPrincipal']['codigo']." - ".$usuario['ObservadorPrincipal']['nombre'];?></span>
                                    </div>
                                    <input type="hidden" id="observadorSeleccionado" value="<?=$usuario['ObservadorPrincipal']['id'];?>"
                                        name="data[Cita][observador_principal_id]" />
                                </div>
                            </div>
                        </div>
            
                        <!-- Colaboradores -->
                        <div class="control-group">
                            <label class="control-label" for="colaboradores"> <?=__("Colaboradores");?></label>
                            <div class="controls">
                                <div class="dummy">
                                    <input id="colaboradores" name="colaboradores" class="input-xlarge"
                                        type="text"
                                        placeholder="Escriba el código o el nombre del colaborador">
                                    <span class="badge badge-info" data-trigger="hover"
                                    data-content='<?=__("Escriba al menos tres letras y seleccione de la lista los colaboradores que quiera incluir en la cita.");?>'><i
                                        class="icon-info-sign icon-white"></i> </span> 
                                    <br />
                                    <div id="colaboradoresSeleccionadosDiv"
                                        style="margin-top: 5px;">
                                        Colaboradores seleccionados: <span
                                            id="colaboradoresSeleccionadosTexto" class="text-success"
                                            style="font-weight: bold;"><?=$this->ObservadorSecundario->mostrar_nombres_observadores($cita['observadores']);?></span>
                                    </div>
                                    <input type="hidden" id="colaboradoresSeleccionados"
                                        name="colaboradoresSeleccionados" value="<?=$this->ObservadorSecundario->mostrar_ids_observadores($cita['observadores']);?>"/>
                                    <div style="margin-top: 5px;">
                                        <button class="btn btn-warning btn-mini" type="button" id="btnVaciarColaboradores">
                                            <i class="icon-trash" style="margin-right: 10px;"></i><?=__("Limpiar"); ?>
                                        </button>
                                        <button class="btn btn-mini btn-primary btnNuevoColaborador" type="button">
                                            <i class="icon-plus"></i> <?=__("Nuevo colaborador"); ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Fuente -->
                        <div class="control-group">
                            <label class="control-label" for="fuenteId"> <?=__("Fuente");?></label>
                            <div class="controls">
                                <select id="fuenteId" name="data[Cita][fuente_id]"
                                    class="input-xlarge">
                                    <?php
                                    foreach ($fuentes as $fuente) {
                                        if($fuente["Fuente"]["id"] == $cita['Fuente']['id']) {
                                            echo "<option value='".$fuente["Fuente"]["id"]."' selected='selected'>".$fuente["Fuente"]["nombre"]."</option>";
                                        }
                                        else {
                                            echo "<option value='".$fuente["Fuente"]["id"]."'>".$fuente["Fuente"]["nombre"]."</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <span class="badge badge-info" data-trigger="hover"
                                data-content='<?=__("Seleccione la fuente de la que proviene la cita.");?>'><i
                                    class="icon-info-sign icon-white"></i> </span>
                            </div>
                        </div>
                        
                        <!-- Estudio -->
                        <div class="control-group">
                            <label class="control-label" for="estudio"> <?=__("Estudio");?></label>
                            <div class="controls">
                                <select id="estudioId" name="data[Cita][estudio_id]" class="input-xlarge">
                                    <?php
                                    foreach ($estudios as $estudio) {
                                        if($estudio["Estudio"]["id"] == $cita['Estudio']['id']) {
                                            echo "<option value='".$estudio["Estudio"]["id"]."' selected='selected'>".$estudio["Estudio"]["descripcion"]."</option>";
                                        }
                                        else {
                                            echo "<option value='".$estudio["Estudio"]["id"]."'>".$estudio["Estudio"]["descripcion"]."</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <span class="badge badge-info" data-trigger="hover"
                                    data-content='<?=__("Seleccione el tipo de estudio asociado a la cita.");?>'><i
                                        class="icon-info-sign icon-white"></i> </span>
                            </div>
                        </div>
                    
                </fieldset>        
                
                <fieldset class="fsCustom" style="margin-top: 20px;">
                    <legend>Indicadores de la cita</legend>
                    
                    <div class="control-group">
                        <label class="control-label width300 marginRight20" for="cbxIndHabitatRaro" title="<?=__("Individuo/s visto en habitat raro");?>"> <?=__("Habitat raro");?></label>
                        <div class="controls">
                            <div class="dummy">
                                <input name="data[Cita][indHabitatRaro]" id="cbxIndHabitatRaro" value="1" type="checkbox" <?php if($cita['Cita']['indHabitatRaro'] == true){echo "checked='checked'";}?>>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label width300 marginRight20" for="cbxIndCriaHabitatRaro" title="<?=__("Individuo/s visto criando en habitat raro");?>"> <?=__("Criando en habitat raro");?></label>
                        <div class="controls">
                            <div class="dummy">
                                <input name="data[Cita][indCriaHabitatRaro]" id="cbxIndCriaHabitatRaro" value="1" type="checkbox" <?php if($cita['Cita']['indCriaHabitatRaro'] == true){echo "checked='checked'";}?>>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label width300 marginRight20" for="cbxIndHerido" title="<?=__("Individuo/s herido, accidentado o muerto");?>"> <?=__("Herido, accidentado o muerto");?></label>
                        <div class="controls">
                            <div class="dummy">
                                <input name="data[Cita][indHerido]" id="cbxIndHerido" value="1" type="checkbox" <?php if($cita['Cita']['indHerido'] == true){echo "checked='checked'";}?>>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label width300 marginRight20" for="cbxIndComportamiento" title="<?=__("Indivudo/s con comportamiento o morfología curiosa");?>"> <?=__("Comportamiento o morfología curiosa");?></label>
                        <div class="controls">
                            <div class="dummy">
                                <input name="data[Cita][indComportamiento]" id="cbxIndComportamiento" value="1" type="checkbox" <?php if($cita['Cita']['indComportamiento'] == true){echo "checked='checked'";}?>>
                            </div>
                        </div>
                    </div>
                </fieldset>        
                
            </div>

            <!-- Ubicacion -->
            <div class="span6">
                <div class="contenedor_gris row-fluid">
                
                    <!-- Lugar-->
                    <div class="control-group">
                        <label class="control-label" style="width: 60px;" for="lugar"> <?=__("Lugar");?>&nbsp;(*)</label>
                        <div class="controls" style="margin-left: 80px; text-align: left;">
                            <div class="dummy">
                                <input type="text" id="lugar" name="lugar" style="width: 440px;"
                                    value="<?=$cita['Lugar']['Lugar']['nombre'].", ".$cita['Lugar']['Municipio']['nombre'].", ".$cita['Lugar']['Comarca']['nombre'].", ".$cita['Lugar']['CuadriculaUtm']['codigo'];?>"
                                    placeholder="Escriba el nombre del lugar, municipio, comarca o cuadrícula UTM" />
                                <span class="badge badge-info" data-trigger="hover" data-placement="left"
                                    data-content='<?=__("Escriba tres letras y seleccione un lugar del listado. También puede seleccionarlo a través de la tabla. Si no lo encuentra, puede crear uno nuevo.");?>'><i
                                        class="icon-info-sign icon-white"></i> </span>
                                <br>
                                <div id="lugarSeleccionadoContenedor"
                                    style="margin-top: 5px;">
                                    Lugar seleccionado: 
                                    <span id="lugarSeleccionado" class="text-success" style="font-weight: bold;">
                                        <?=$cita['Lugar']['Lugar']['nombre'].", ".$cita['Lugar']['Municipio']['nombre'].", ".$cita['Lugar']['Comarca']['nombre'].", ".$cita['Lugar']['CuadriculaUtm']['codigo'];?>
                                    </span>
                                </div>
                            </div>
                            <div style="margin-top: 5px;">
                                <button class="btnVaciarLugar btn btn-warning btn-mini" type="button">
                                    <i class="icon-trash" style="margin-right: 10px;"></i><?=__("Limpiar"); ?>
                                </button>
                                <a href="#modalSeleccioanrLugar" role="button"
                                   class="btn btn-mini btn-info" data-toggle="modal"
                                   id="btnSeleccionarLugar"><i class="icon-zoom-in"></i> <?=__("Seleccionar desde tabla"); ?>
                                </a>
                                <button class="btn btn-mini btn-primary btnNuevoLugar" type="button">
                                    <i class="icon-plus"></i> <?=__("Nuevo lugar"); ?>
                                </button>
                            </div>
                            <input type="hidden" id="lugarId" name="data[Cita][lugar_id]" value="<?=$cita['Lugar']['Lugar']['id']?>">
                        </div>
                    </div>
                    <div id="map_canvas" class="span12" style="height: 400px"></div>
                </div>
                <fieldset class="fsCustom" style="margin-top: 20px;">    
                    <legend>Observaciones</legend>
                    <textarea id="observaciones" name="data[Cita][observaciones]"
                        rows="2" style="width: 100%;"><?=$cita['Cita']['observaciones'];?></textarea>
                </fieldset>
            </div>
            
        </div>
        
        <fieldset class="fsCustom" style="margin-top: 20px;">
            <legend>Criterios de selección de la cita</legend>
                    
            <div class="control-group">
                <label class="control-label width240 marginRight20" for="cbxindSeleccionada"> <?=__("Cita seleccionada para el anuario");?></label>
                <div class="controls">
                    <div class="dummy">
                        <input name="data[Cita][indSeleccionada]" id="cbxindSeleccionada" value="1" type="checkbox" disabled="disabled" <?php if($cita['Cita']['indSeleccionada'] == "1"){echo "checked='checked'";}?>>
                    </div>
                </div>
            </div>
            <!-- Datos de reproducción -->
            <div class="control-group">
                <label class="control-label width240 marginRight20" for="selectDatosReproduccion"> <?=__("Datos de reproducción");?>&nbsp;(*)</label>
                <div class="controls">
                    <div class="dummy">
                    <?php
                    echo '<select name="data[Cita][clase_reproduccion_id]" id="selectDatosReproduccion">';
                    $tiposCriaSeleccionados = array();
                    $lastIdTipoCria = 0;
                    foreach ($clasesReproduccion as $claseReproduccion) {
                        
                        $idTipoCria = $claseReproduccion['ClaseReproduccion']['idTipoCria'];
                        if($idTipoCria != $lastIdTipoCria) {
                            $lastIdTipoCria = $idTipoCria;
                            echo '</optgroup>';
                        }
                        if(!in_array($idTipoCria, $tiposCriaSeleccionados)) {
                            echo '<optgroup label="'.$claseReproduccion['ClaseReproduccion']['tipoCria'].'">';
                            array_push($tiposCriaSeleccionados, $idTipoCria);
                        }
                        if($claseReproduccion['ClaseReproduccion']['id'] == $cita['ClaseReproduccion']['id']) {
                            echo '<option value="'.$claseReproduccion["ClaseReproduccion"]["id"].'" selected="selected">'.$claseReproduccion["ClaseReproduccion"]["codigo"].' - '.$claseReproduccion["ClaseReproduccion"]["descripcion"].'</option>';
                        }
                        else {
                            echo '<option value="'.$claseReproduccion["ClaseReproduccion"]["id"].'">'.$claseReproduccion["ClaseReproduccion"]["codigo"].' - '.$claseReproduccion["ClaseReproduccion"]["descripcion"].'</option>';
                        }
                    }
                    echo '</select>';
                    ?>
                    <span class="badge badge-info" data-trigger="hover" data-placement="left"
                    data-content='<?=__("Seleccione el tipo de reproducción observado.");?>'><i
                        class="icon-info-sign icon-white"></i> </span>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label width240 marginRight20"> <?=__("Criterio de selección de la cita");?></label>
                <div class="controls">
                    <div class="dummy">
                        <span><?=$cita['CriterioSeleccionCita']['nombre'];?></span>
                    </div>
                </div>
            </div>

        </fieldset>
        
        <!-- Fotos -->
        <fieldset class="fsCustom" style="margin-top: 20px;">
            <legend>Fotos</legend>
            <div class="row">
                <div class="span3" style="border-right: 1px solid #E4E4E4;">
                    <div>
                        <p><?=__('Puedes añadir cuantas fotos quieras a la cita (de 3 en 3) seleccionandolas con los botones de abajo y pulsando <b>Guardar</b>.')?></p>
                        <p><?=__('Las fotos deben tener formato jpg, jpeg, png o gif y no pueden ocupar más de 2 megas')?></p>
                    </div>
                    <br/>
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new thumbnail" style="width: 100px; height: 100px;">
                        </div>
                        <div class="fileupload-preview fileupload-exists thumbnail" style="width: 100px; height: 100px;"></div>
                        <span class="btn btn-file">
                            <span class="fileupload-new"><?=__('Seleccionar nueva foto')?></span>
                            <span class="fileupload-exists"><?=__('Cambiar')?></span>
                            <input type="file" name="fotos[]"/>
                        </span>
                        <a href="#" class="btn fileupload-exists" data-dismiss="fileupload"><?=__('Quitar')?></a>
                    </div>
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new thumbnail" style="width: 100px; height: 100px;">
                        </div>
                        <div class="fileupload-preview fileupload-exists thumbnail" style="width: 100px; height: 100px;"></div>
                        <span class="btn btn-file">
                            <span class="fileupload-new"><?=__('Seleccionar nueva foto')?></span>
                            <span class="fileupload-exists"><?=__('Cambiar')?></span>
                            <input type="file" name="fotos[]"/>
                        </span>
                        <a href="#" class="btn fileupload-exists" data-dismiss="fileupload"><?=__('Quitar')?></a>
                    </div>
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new thumbnail" style="width: 100px; height: 100px;">
                        </div>
                        <div class="fileupload-preview fileupload-exists thumbnail" style="width: 100px; height: 100px;"></div>
                        <span class="btn btn-file">
                            <span class="fileupload-new"><?=__('Seleccionar nueva foto')?></span>
                            <span class="fileupload-exists"><?=__('Cambiar')?></span>
                            <input type="file" name="fotos[]"/>
                        </span>
                        <a href="#" class="btn fileupload-exists" data-dismiss="fileupload"><?=__('Quitar')?></a>
                    </div>
                </div>
                <div class="span9">
                    <ul class="thumbnails">
                        <?php if(isset($cita['Fichero']) && count($cita['Fichero']) > 0): ?>

                            <div><p><?=__('Puedes eliminar fotos de la cita seleccionándolas con el botón <b>Quitar</b> y pulsando <b>Guardar</b>')?></p></div>
                            <br/>

                            <?php foreach ($cita['Fichero'] as $foto): ?>
                                <li class="span2">
                                    <div class="thumbnail">
                                        <img src="<?=$foto['ruta'].$foto['nombreFisico']?>" alt="<?=$foto['descripcion']?>"/>
                                        <div class="caption text-center">
                                            <input type="hidden" class="foto-eliminar-<?=$foto['id']?>" name="fotosEliminar[]" value="<?=$foto['id']?>" disabled="disabled">
                                            <button type="button" class="btn btn-danger quitar-foto" data-id="<?=$foto['id']?>">
                                                <i class="icon-trash" style="margin-right: 10px;"></i><?=__('Quitar')?>
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach ?>
                        <?php else: ?>
                            <div class="thumbnail" style="width: 360px; height: 270px;">
                                <img src="/img/messages/AAAAAA&text=No+hay+fotos_360x270.gif"/>
                            </div>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
        </fieldset>

        <br>

        <!-- Button (Double) -->
        <div class="text-center">
            <a id="btnGuardar" class="btn btn-success btn-large"><i class="icon-ok"></i> <?=__("Guardar");?></a>
        </div>

        </form>
    </fieldset>
</div>

<!-- SELECCIONAR LUGAR -->
<?=$this->element('Lugar/seleccionarLugar'); ?>

<!-- NUEVO LUGAR -->
<?=$this->element('Lugar/nuevoLugar'); ?>

<!-- NUEVO COLABORADOR -->
<?=$this->element('ObservadorSecundario/nuevoObservadorSecundario'); ?>

<!-- Pie -->
<?php
    $this->start('pie');
    echo $this->element('/pie');
    $this->end();
?>