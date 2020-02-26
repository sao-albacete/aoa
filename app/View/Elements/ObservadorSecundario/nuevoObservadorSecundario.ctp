<?php

/**
 * CSS
 */
$this->Html->css(array(
), null, array('inline' => false));

/**
 * Javascript
 */
$this->Html->script(array(
    'Elements/ObservadorSecundario/nuevoObservadorSecundario'
), array('inline' => false));

?>


<div id="divNuevoColaborador" class="modal hide fade" tabindex="-1"
     role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">

    <div class="modal-header">
        <a href="#" class="close" data-dismiss="modal">&times;</a>
        <h4 id="tituloDivNuevoColaborador"><?php echo __("Nuevo colaborador"); ?></h4>
    </div>

    <div class="modal-body">

        <div id="errorMessagesNuevoColaborador" class="alert alert-error"
             style="display: none; padding-left: 14px;">
            <ul></ul>
        </div>

        <form id="frmNuevoColaborador" method="post">

            <div class="control-group">

                <label class="control-label"> <?php echo __("Nombre completo"); ?> (*)
                    <span class="badge badge-info" data-trigger="hover"
                          data-content="<?php echo __('Escribe el nombre completo del nuevo colaborador.'); ?>">
                            <i class="icon-info-sign icon-white"></i>
                    </span>
                </label>

                <div class="controls">
                    <div class="dummy">
                        <input class="nombreColaborador input-xxlarge" name="nombreColaborador" type="text" required="required"
                               placeholder="<?php echo __('Escriba el nombre completo...'); ?>"/>
                    </div>
                </div>

            </div>

        </form>
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> <?php echo __("Cancelar"); ?></button>
        <button class="btn btn-success btnAceptar" data-loading-text="Guardando..."><i class="icon-ok"></i> <?php echo __("Aceptar"); ?></button>
    </div>
</div>