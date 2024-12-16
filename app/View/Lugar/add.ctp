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
    'https://maps.googleapis.com/maps/api/js?key=AIzaSyCvHe5uH6Ogczm4OWoXkq8_NiwspG4oE1I',
    'common/maps/geoxml3/geoxml3.js',
    'common/maps/geoxml3/ProjectedOverlay.js',
    '/plugin/jquery-validation-1.11.1/dist/jquery.validate.min',
    '/plugin/jquery-validation-1.11.1/dist/additional-methods.min',
    '/plugin/jquery-validation-1.11.1/localization/messages_es',
    '/plugin/bootbox/bootbox.min',
    'common/maps/functions',
    'Lugar/common',
    'Lugar/add',

), array('inline' => false));

// Menu
$this->start('menu');
echo $this->element('/menu');
$this->end();
?>
<script>
google.maps.event.addDomListener(window, 'load', initialize_map);
</script>
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

                    <div class="well well-small">
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

                        </div>

                        <!-- Municipio -->
                        <div class="control-group">
                            <div class="controls form-inline">
                                <!-- Municipio -->
                                <label class="control-label" for="selectMunicipio"><?=__("Municipio");?> (*)</label>
                                <select readonly="readonly" id="selectMunicipio" name="municipioId"
                                    class="input-xlarge required">
                                    <option value=""><?php echo __("-- Seleccione --");?></option>
                                        <?php
                                        foreach($municipios as $municipio) {
                                            echo "<option value='".$municipio['Municipio']['id']."'>".$municipio['Municipio']['nombre']."</option>";
                                        }
                                        ?>
                                </select>
                                <span class="badge badge-info" data-trigger="hover"
                                        data-content="<?=__('Seleccione un municipio.');?>"><i
                                            class="icon-info-sign icon-white"></i> </span>
                            </div>
                        </div>

                        <!-- Coordenadas Lugar Lat,Lng -->
                        <div class="control-group">
                            <div class="controls form-inline">
                                <label class="control-label" for="lat"> <?php echo __("Latitud y Longitud");?></label>
                                <input name="lat" class="input-mini" id="txtCoordenadasLat" readonly="readonly" type="text" value="">
                                <input name="lng" class="input-mini" id="txtCoordenadasLng" readonly="readonly" type="text" value="">

                                <span class="badge badge-info" data-trigger="hover"
                                    data-content="<?php echo __('Coordenadas WGS84 del lugar.');?>"><i
                                        class="icon-info-sign icon-white"></i> </span>
                            </div>
                        </div>

                        <!-- Botones de búsqueda -->
                        <div id="divBotonesBusqueda" class="control-group" style="margin-top: 20px;">
                            <div class="controls" style="text-align: center;">
                                <a id="btnLimpiar" class="btn btn-warning" href="#"><i class="icon-trash"></i> <?=__("Limpiar");?></a>
                                <a id="btnGuardarLugar" class="btn btn-success btn-large" href="#"><i class="icon-ok"></i> <?=__("Guardar");?></a>
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
