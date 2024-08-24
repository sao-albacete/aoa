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

    '/plugin/jquery-validation-1.11.1/dist/jquery.validate.min',
    '/plugin/jquery-validation-1.11.1/dist/additional-methods.min',
    '/plugin/jquery-validation-1.11.1/localization/messages_es',
    '/plugin/bootbox/bootbox.min',
    'common/maps/functions',
    'https://unpkg.com/@google/markerclustererplus@4.0.1/dist/markerclustererplus.min.js',
    'https://maps.googleapis.com/maps/api/js?key=AIzaSyCvHe5uH6Ogczm4OWoXkq8_NiwspG4oE1I',
    'common/maps/geoxml3/geoxml3.js',
    'common/maps/geoxml3/ProjectedOverlay.js',
    'Lugar/cluster',

), array('inline' => false));

?>

<script type="text/javascript">





    google.maps.event.addDomListener(window, 'load', initialize_map_cluster_cita);

</script>

<div id="modalSeleccionarLugarMapa" style="overflow:scroll !important; width:900px !important" class="modal hide fade" tabindex="-1"
     role="dialog" aria-labelledby="myModalNuevoLugar" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalNuevoLugar"><?php echo __('Seleccione un lugar en el mapa')?></h3>
    </div>
    <div class="modal-body">
        <div id="errorMessagesNuevoLugar" class="alert alert-error"
             style="display: none; padding-left: 14px;">
            <h5><?php echo __('Por favor, corrija los errores en el formulario')?>:</h5>
            <ul></ul>
        </div>
        <div class="span6" style="width:100% !important;">
            <fieldset>
                <div id="map_canvas_cluster" style="height:400px; " class="span12"></div>
            </fieldset>
        </div>
    </div>

    <div class="modal-footer">
        <button id="btnCancelarMapa" class="btnCancelar btn btn-danger" aria-hidden="true"><i class="icon-remove"></i> <?php echo __("Cancelar"); ?></button>
    </div>
</div>
