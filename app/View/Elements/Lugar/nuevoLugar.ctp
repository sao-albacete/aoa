<?php

/**
 * CSS
 */
$this->Html->css(array(
    'Elements/Lugar/nuevoLugar'
), null, array('inline' => false));

/**
 * Javascript
 */
$this->Html->script(array(
    // 'Elements/Lugar/nuevoLugar',
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

?>

<div id="modalNuevoLugar" style="overflow:scroll !important; height:500px !important" class="modal hide fade" tabindex="-1"
     role="dialog" aria-labelledby="myModalNuevoLugar" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalNuevoLugar"><?php echo __('Introduce los datos del nuevo lugar')?></h3>
    </div>
    <div class="modal-body">

        <div id="errorMessagesNuevoLugar" class="alert alert-error"
             style="display: none; padding-left: 14px;">
            <h5><?php echo __('Por favor, corrija los errores en el formulario')?>:</h5>
            <ul></ul>
        </div>

        <div class="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Los campos marcados con un asterisco (*) son obligatorios.
        </div>

        <form method="post" id="frmNuevoLugar">
            <div>

                <!-- Nombre -->
                <div class="control-group">

                    <label class="control-label"> <?php echo __("Nombre");?> (*)
                        <span class="badge badge-info" data-trigger="hover" data-toggle="popover"
                              data-content="<?php echo __('Escriba el nombre del lugar. Debe tener un máximo de 100 caracteres.');?>"><i
                                class="icon-info-sign icon-white"></i>
                        </span>
                    </label>
                    <input id="txtNombre" name="nombre" class="txtNombre input-xxlarge required" type="text" maxlength="100"
                           value="<?php if(isset($valuesSubmited['nombre'])){echo $valuesSubmited['nombre'];}?>">
                </div>


                <!-- Municipio -->
                <div class="control-group">

                    <label class="control-label"><?php echo __("Municipio");?> (*)
                        <span class="badge badge-info" data-trigger="hover" data-toggle="popover"
                              data-content="<?php echo __('Seleccione un municipio.');?>"><i
                                class="icon-info-sign icon-white"></i>
                        </span>
                    </label>
                    <select name="municipioId" id="selectMunicipio" class=" input-xxlarge required" disabled="disabled">
                      <option value=""><?php echo __("-- Seleccione --"); ?></option>

                          <?php
                              foreach($municipios as $municipio) {
                                  echo "<option value='".$municipio['Municipio']['id']."'>".$municipio['Municipio']['nombre']."</option>";
                              }
                          ?>
                    </select>
                </div>

                <!-- Coordenadas Lugar Lat,Lng -->
                <div class="control-group">
                    <div class="controls form-inline">
                        <label class="control-label" for="lat"> <?php echo __("Latitud y Longitud");?></label>
                        <input name="lat" class="input-mini" id="txtCoordenadasLat" readonly="readonly" type="text" value="">
                        <input name="lng" class="input-mini" id="txtCoordenadasLng" readonly="readonly" type="text" value="">

                        <span class="badge badge-info" data-trigger="hover"
                            data-content="<?php echo __('Coordenadas EPSG 3857 del lugar.');?>"><i
                                class="icon-info-sign icon-white"></i> </span>
                    </div>
                </div>

            </div>
            <div class="span6" style="width:100% !important;">
                <fieldset>
                    <legend class="small" style="font-size: 16px;"><?=__('Mapa'); ?></legend>
                    <div id="map_canvas" style="height:200px;" class="span12"></div>
                </fieldset>
            </div>

        </form>
    </div>

    <div class="modal-footer">
        <button id="btnLimpiar" class="btnLimpiar btn btn-warning"><i class="icon-trash"></i> <?php echo __("Limpiar");?></button>
        <button id="btnCancelarNuevo" class="btnCancelar btn btn-danger" aria-hidden="true"><i class="icon-remove"></i> <?php echo __("Cancelar"); ?></button>
        <button id="btnGuardar" class="btnAceptar btn btn-success" aria-hidden="true"><i class="icon-ok"></i> <?php echo __("Aceptar"); ?></button>
    </div>
</div>

<script type="text/javascript">
// Cancelar creación de nuevo lugar


    // Centrar popup nuevo lugar
//    var popupNuevoLugar = $('#modalNuevoLugar');
//    popupNuevoLugar.css({
//        'left': ($(window).width() / 2 - $(popupNuevoLugar).width() / 2) + 'px',
//        'top': ($(window).height() / 2 - $(popupNuevoLugar).height() / 2) + 'px',
//        'margin-left': 0 + 'px'
//    });

</script>
