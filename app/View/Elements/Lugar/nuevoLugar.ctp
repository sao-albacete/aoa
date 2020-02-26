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
    'Elements/Lugar/nuevoLugar'
), array('inline' => false));

?>

<div id="modalNuevoLugar" class="modal hide fade" tabindex="-1"
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
                    <input name="nombre" class="txtNombre input-xxlarge required" type="text" maxlength="100"
                           value="<?php if(isset($valuesSubmited['nombre'])){echo $valuesSubmited['nombre'];}?>">
                </div>

                <!-- Cuadrícula UTM -->
                <div class="control-group">

                    <label class="control-label"><?php echo __("Cuadrícula UTM");?> (*)
                        <span class="badge badge-info" data-trigger="hover" data-toggle="popover"
                              data-content="<?php echo __('Seleccione una cuadrícula UTM. Puede consultar los códigos de cuadrícula en el mapa. Un vez seleccione una cuadrícula, se cargarán los municipios asociados.');?>"><i
                                class="icon-info-sign icon-white"></i>
                        </span>
                    </label>
                    <select name="cuadriculaUtmCodigo"
                            class="selectCuadriculaUtm input-xxlarge required">
                        <option value=""><?php echo __("-- Seleccione --");?></option>
                        <?php
                        foreach($cuadriculasUtm as $cuadriculaUtm) {
                            echo '<option value="'.$cuadriculaUtm["CuadriculaUtm"]["codigo"].'">'.$cuadriculaUtm["CuadriculaUtm"]["codigo"].'</option>';
                        }
                        ?>
                    </select>
                </div>

                <!-- Municipio -->
                <div class="control-group">

                    <label class="control-label"><?php echo __("Municipio");?> (*)
                        <span class="badge badge-info" data-trigger="hover" data-toggle="popover"
                              data-content="<?php echo __('Seleccione un municipio.');?>"><i
                                class="icon-info-sign icon-white"></i>
                        </span>
                    </label>
                    <select name="municipioId" class="selectMunicipio input-xxlarge required" disabled="disabled">
                    </select>
                </div>

                <!-- Coordenadas UTM -->
                <div class="control-group">

                    <label class="control-label"> <?php echo __("Coordenadas UTM");?>
                        <span class="badge badge-info" data-trigger="hover" data-toggle="popover"
                              data-content="<?php echo __('Coordenadas UTM x e y del lugar.');?>">
                            <i class="icon-info-sign icon-white"></i>
                        </span>
                    </label>
                    <input name="area" readonly="readonly"
                           class="txtCoordenadasUtmArea input-mini" type="text"
                           value="<?php if(isset($valuesSubmited['area'])){echo $valuesSubmited['area'];}?>">
                    <input name="coordenadaX" class="txtCoordenadasUtmX input-small" type="text" readonly="readonly"
                           value="<?php if(isset($valuesSubmited['coordenadaX'])){echo $valuesSubmited['coordenadaX'];}?>" maxlength="6">
                    <input name="coordenadaY" class="txtCoordenadasUtmY input-small" type="text" readonly="readonly"
                           value="<?php if(isset($valuesSubmited['coordenadaY'])){echo $valuesSubmited['coordenadaY'];}?>" maxlength="7">
                </div>

            </div>

        </form>
    </div>

    <div class="modal-footer">
        <button class="btnLimpiar btn btn-warning"><i class="icon-trash"></i> <?php echo __("Limpiar");?></button>
        <button class="btnCancelar btn btn-danger" aria-hidden="true"><i class="icon-remove"></i> <?php echo __("Cancelar"); ?></button>
        <button class="btnAceptar btn btn-success" aria-hidden="true"><i class="icon-ok"></i> <?php echo __("Aceptar"); ?></button>
    </div>
</div>

<script type="text/javascript">

    // Centrar popup nuevo lugar
//    var popupNuevoLugar = $('#modalNuevoLugar');
//    popupNuevoLugar.css({
//        'left': ($(window).width() / 2 - $(popupNuevoLugar).width() / 2) + 'px',
//        'top': ($(window).height() / 2 - $(popupNuevoLugar).height() / 2) + 'px',
//        'margin-left': 0 + 'px'
//    });

</script>