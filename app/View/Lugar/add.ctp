<?php
// Informamos el título
$this->set('title_for_layout','Nuevo lugar');

/**
 * CSS
 */
$this->Html->css(array(
    'Lugar/add'
), null, array('inline' => false));

/**
 * Javascript
 */
$this->Html->script(array(
    'https://maps.googleapis.com/maps/api/js?sensor=false',
    'https://geoxml3.googlecode.com/svn/branches/polys/geoxml3.js',
    'https://geoxml3.googlecode.com/svn/trunk/ProjectedOverlay.js',
    '/plugin/jquery-validation-1.11.1/dist/jquery.validate.min',
    '/plugin/jquery-validation-1.11.1/dist/additional-methods.min',
    '/plugin/jquery-validation-1.11.1/localization/messages_es',
    '/plugin/bootbox/bootbox.min',
    'common/maps/functions',
    'Lugar/add'
), array('inline' => false));

// Menu
$this->start('menu');
echo $this->element('/menu');
$this->end();
?>

<div>
    <fieldset>
        <legend>
            <?=__('Nuevo lugar'); ?>
            <button class="btn btn-mini btn-info pull-right help-button"
                data-trigger="click" data-placement="left" data-html="true"
                data-content="<?=__('Para crear un nuevo lugar, introduzca los datos en el formulario y pulse <b>Guardar</b>. <br> Puede consultar las cuadrículas UTM de la provincia de Albacete en el mapa haciendo clic sobre cualqueira de ellas.');?>">
                <i class="icon-info-sign"></i> 
                <?=__("Ayuda");?>
            </button>
        </legend>
        
        <div id="errorMessagesGrafico" class="alert alert-error"
            style="display: none; padding-left: 14px;">
            <h5>Por favor, corrija los errores en el formulario:</h5>
            <ul></ul>
        </div>
        
        <div class="row-fluid">
            <div class="span6">
                <fieldset>
                    <legend style="font-size: 16px;" class="small"><?=__('Datos del lugar'); ?></legend>
                    
                    <div class="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Los campos marcados con un asterisco (*) son obligatorios.
                    </div>
                    
                    <form method="post" id="frmNuevoLugar">
                    
                        <input type="hidden" name="controller" value="<?php if(isset($controller)){echo $controller;} ?>"/>
                        <input type="hidden" name="action" value="<?php if(isset($action)){echo $action;} ?>"/>
                        <input type="hidden" name="idOrigen" value="<?php if(isset($idOrigen)){echo $idOrigen;} ?>"/>
            
                        <div class="tab-content">
                        
                            <!-- Nombre -->
                            <div class="control-group">
                                <div class="controls form-inline">
                                    <!-- Nombre -->
                                    <label class="control-label" for="txtNombre"> <?=__("Nombre");?> (*)</label>
                                    <input id="txtNombre" name="nombre" class="input-xlarge required" type="text" maxlength="100"
                                        value="<?php if(isset($valuesSubmited['nombre'])){echo $valuesSubmited['nombre'];}?>">
                                    <span class="badge badge-info" data-trigger="hover"
                                        data-content="<?=__('Escriba el nombre del lugar. Debe tener un máximo de 100 caracteres.');?>"><i
                                            class="icon-info-sign icon-white"></i> </span>
                                </div>
                            </div>
                            
                            <!-- Cuadrícula UTM -->
                            <div class="control-group">
                                <div class="controls form-inline">
                                    <!-- Cuadricula UTM -->
                                    <label class="control-label" for="selectCuadriculaUtm"><?=__("Cuadrícula UTM");?> (*)</label>
                                    <select id="selectCuadriculaUtm" name="cuadriculaUtmCodigo"
                                        class="input-xlarge required">
                                        <option value=""><?=__("-- Seleccione --");?></option>
                                        <?php
                                        foreach($cuadriculasUtm as $cuadriculaUtm) {
                                            echo '<option value="'.$cuadriculaUtm["CuadriculaUtm"]["codigo"].'">'.$cuadriculaUtm["CuadriculaUtm"]["codigo"].'</option>';
                                        }
                                        ?>
                                    </select>
                                    <span class="badge badge-info" data-trigger="hover"
                                        data-content="<?=__('Seleccione una cuadrícula UTM. Puede consultar los códigos de cuadrícula en el mapa. Un vez seleccione una cuadrícula, se cargarán los municipios asociados.');?>"><i
                                            class="icon-info-sign icon-white"></i> </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Municipio -->
                        <div class="control-group">
                            <div class="controls form-inline">
                                <!-- Municipio -->
                                <label class="control-label" for="selectMunicipio"><?=__("Municipio");?> (*)</label>
                                <select id="selectMunicipio" name="municipioId" class="input-xlarge required" disabled="disabled">
                                </select>
                                <span class="badge badge-info" data-trigger="hover"
                                        data-content="<?=__('Seleccione un municipio.');?>"><i
                                            class="icon-info-sign icon-white"></i> </span>
                            </div>
                        </div>
                        
                        <!-- Coordenadas UTM -->
                        <div class="control-group">
                            <div class="controls form-inline">
                                <label class="control-label" for="txtCoordenadasUtmX"> <?=__("Coordenadas UTM");?></label>
                                <input id="txtCoordenadasUtmArea" name="area" readonly="readonly"
                                    class="input-mini" type="text"
                                    value="<?php if(isset($valuesSubmited['area'])){echo $valuesSubmited['area'];}?>"> 
                                <input id="txtCoordenadasUtmX" name="coordenadaX" class="input-mini" type="text" readonly="readonly"
                                    value="<?php if(isset($valuesSubmited['coordenadaX'])){echo $valuesSubmited['coordenadaX'];}?>" maxlength="6">
                                <input id="txtCoordenadasUtmY" name="coordenadaY" class="input-mini" type="text" readonly="readonly"
                                    value="<?php if(isset($valuesSubmited['coordenadaY'])){echo $valuesSubmited['coordenadaY'];}?>" maxlength="7">
                                <span class="badge badge-info" data-trigger="hover"
                                    data-content="<?=__('Coordenadas UTM x e y del lugar.');?>">
                                    <i class="icon-info-sign icon-white"></i> 
                                </span>
                            </div>
                        </div>
                        
                        <!-- Botones de búsqueda -->
                        <div id="divBotonesBusqueda" class="control-group" style="margin-top: 20px;">
                            <div class="controls" style="text-align: center;">
                                <a id="btnLimpiar" class="btn btn-warning" href="#"><i class="icon-trash"></i> <?=__("Limpiar");?></a>
                                <a id="btnGuardar" class="btn btn-success btn-large" href="#"><i class="icon-ok"></i> <?=__("Guardar");?></a>
                            </div>
                        </div>
                        
                    </form>
                </fieldset>
            </div>
            
            <div class="span6">
                <fieldset>
                    <legend class="small" style="font-size: 16px;"><?=__('Mapa'); ?></legend>
                    <div id="map_canvas" style="height:400px;" class="span12"></div>
                </fieldset>
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