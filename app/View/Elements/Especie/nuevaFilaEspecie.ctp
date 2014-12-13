<?php

/**
 * CSS
 */
$this->Html->css(array(
    'Elements/Especie/filaEspecie'
), null, array('inline' => false));

/**
 * Javascript
 */
$this->Html->script(array(
    'Elements/Especie/filaEspecie',
    'Elements/Especie/nuevaFilaEspecie'
), array('inline' => false));

?>

<div id="modalNuevaEspecie" class="modal hide fade" tabindex="-1"
     role="dialog" aria-labelledby="myModalNuevaEspecie" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalNuevaEspecie"><?php echo __('Introduzca los datos de la nueva especie')?></h3>
    </div>
    <div class="modal-body">

        <div id="errorMessagesNuevaEspecie" class="alert alert-error"
             style="display: none; padding-left: 14px;">
            <h5><?php echo __('Por favor, corrija los errores en el formulario')?>:</h5>
            <ul></ul>
        </div>

        <form class="frmEspecie">

            <!-- Especie-->
            <div class="control-group">
                <label class="control-label" for="especie"> <?php echo __("Especie"); ?> (*)
                    <span class="badge badge-info" data-trigger="hover"
                          data-content="<?php echo __('Escribe tres letras del nombre común, género o especie y selecciona una especie de la lista. Además, una vez seleccionada una especie, podrás seleccioanr su subespecie escribiendo su primera letra y seleccioando una del listado.'); ?>">
                            <i class="icon-info-sign icon-white"></i>
                    </span>
                </label>

                <div class="controls">
                    <div class="dummy">
                        <input name="especie" class="especie input-xlarge" type="text" placeholder="<?php echo __('Escriba el nombre de la especie'); ?>">
                        <input name="subespecie" disabled="disabled" class="subespecie input-large" type="text" placeholder="<?php echo __('Escriba la subespecie'); ?>">
                        <div class="especieSeleccionadaContenedor" style="margin-top: 5px; display: none;">
                            <?php echo __("Especie seleccionada"); ?>: <span class="especieSeleccionada text-success" style="font-weight: bold;"></span>
                        </div>
                        <div class="subespecieSeleccionadaContenedor" style="margin-top: 5px; display: none;">
                            <?php echo __("Subespecie seleccionada"); ?>: <span class="subespecieSeleccionada text-success" style="font-weight: bold;"></span>
                        </div>
                        <div style="margin-top: 5px;">
                            <button class="btnVaciarEspecie btn btn-warning btn-mini" type="button">
                                <i class="icon-trash" style="margin-right: 10px;"></i><?php echo __("Limpiar"); ?>
                            </button>
                        </div>
                        <input type="hidden" class="especieId" name="data[Cita][especie_id]">
                    </div>
                </div>
            </div>

            <!-- Número de aves-->
            <div class="control-group">
                <label class="control-label" for="indeterminado"> <?php echo __("Número de aves"); ?> (*)
                    <span class="badge badge-info" data-trigger="hover" style="font-weight: normal; margin-top: 5px;"
                          data-content='<?php echo __("Rellene los cuadros con el número de individuos observados en función de la edad y el sexo."); ?>'><i
                            class="icon-info-sign icon-white"></i> </span>
                </label>

                <div class="controls">
                    <div class="dummy" style="display: inline;">

                        <?php echo $this->element('Cita/tablaNumeroAves'); ?>

                        <div class="numeroTotalAvesDiv" style="margin-top: 5px; display: none;">
                            <?php echo __("Número total aves"); ?>:
                            <span class="numeroTotalAvesTexto text-success" style="font-weight: bold;"></span>
                        </div>
                        <input type="hidden" class="totalNumeroAves" name="data[Cita][cantidad]" value="0"/>
                    </div>
                </div>
            </div>

            <!-- Datos de reproducción -->
            <div class="control-group">
                <label class="control-label"> <?php echo __("Datos reproducción"); ?> (*)
                    <span class="badge badge-info" data-trigger="hover"
                          data-content='<?php echo __("Seleccione el tipo de reproducción observado."); ?>'>
                                <i class="icon-info-sign icon-white"></i> </span>
                </label>

                <div class="controls">
                    <div class="dummy">
                        <?php
                        echo '<select name="data[Cita][clase_reproduccion_id]" class="datosReproduccion input-xxlarge">';
                        $tiposCriaSeleccionados = array();
                        $lastIdTipoCria = 0;
                        foreach ($clasesReproduccion as $claseReproduccion) {

                            $idTipoCria = $claseReproduccion['ClaseReproduccion']['idTipoCria'];
                            if ($idTipoCria != $lastIdTipoCria) {
                                $lastIdTipoCria = $idTipoCria;
                                echo '</optgroup>';
                            }
                            if (!in_array($idTipoCria, $tiposCriaSeleccionados)) {
                                echo '<optgroup label="' . $claseReproduccion['ClaseReproduccion']['tipoCria'] . '">';
                                array_push($tiposCriaSeleccionados, $idTipoCria);
                            }
                            echo '<option value="' . $claseReproduccion["ClaseReproduccion"]["id"] . '">' . $claseReproduccion["ClaseReproduccion"]["codigo"] . ' - ' . $claseReproduccion["ClaseReproduccion"]["descripcion"] . '</option>';
                        }
                        echo '</select>';
                        ?>
                    </div>
                </div>
            </div>

            <!-- Otros datos -->
            <div class="control-group">
                <label class="control-label"> <?php echo __("Otros datos"); ?>
                    <span class="badge badge-info" data-trigger="hover" style="font-weight: normal;"
                          data-content='<?php echo __("Seleccione alguna de estas opciones si coinciden con lo observado."); ?>'><i
                            class="icon-info-sign icon-white"></i> </span>
                </label>

                <div class="controls">
                    <label class="checkbox">
                        <input class="indHabitatRaro" name="data[Cita][indHabitatRaro]" value="1"
                               type="checkbox"> <?php echo __("Especie vista en habitat atípico"); ?>
                    </label>
                    <label class="checkbox">
                        <input class="indCriaHabitatRaro" name="data[Cita][indCriaHabitatRaro]" value="1"
                               type="checkbox"> <?php echo __("Reproducción en un hábitat atípico"); ?>
                    </label>
                    <label class="checkbox">
                        <input class="indHerido" name="data[Cita][indHerido]" value="1"
                               type="checkbox"> <?php echo __("Cita de individuo herido, accidentado o muerto"); ?>
                    </label>
                    <label class="checkbox">
                        <input class="indComportamiento" name="data[Cita][indComportamiento]" value="1"
                               type="checkbox"> <?php echo __("Comportamiento o morfología curiosa"); ?>
                    </label>
                </div>
            </div>

            <!-- Observaciones -->
            <div class="control-group">
                <label class="control-label" for="observaciones"> <?php echo __("Observaciones"); ?></label>
                <div class="controls">
                    <textarea name="data[Cita][observaciones]" rows="2" class="observaciones span4"></textarea>
                </div>
            </div>

        </form>

    </div>

    <div class="modal-footer">
        <button class="btn btn-danger" aria-hidden="true" data-dismiss="modal"><i class="icon-remove"></i> <?php echo __("Cancelar"); ?></button>
        <button class="btnAceptar btn btn-success" aria-hidden="true"><i class="icon-ok"></i> <?php echo __("Aceptar"); ?></button>
    </div>
</div>

<script type="text/javascript">

    // Centrar popup nueva especie
//    var popupNuevaEspecie = $('#modalNuevaEspecie');
//    popupNuevaEspecie.css({
//        'left': ($(window).width() / 2 - $(popupNuevaEspecie).width() / 2) + 'px',
//        'top': ($(window).height() / 2 - $(popupNuevaEspecie).height() / 2) + 'px',
//        'margin-left': 0 + 'px'
//    });

</script>