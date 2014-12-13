<?php 

// Informamos el título
$this->set('title_for_layout','Mis colaboradores');

/**
 * CSS
 */
$this->Html->css(array('datatables-bootstrap', 'ObservadorSecundario/mis_colaboradores'), null, array('inline' => false));

/**
 * Javascript
 */
$this->Html->script(array('/plugin/DataTables-1.9.4/media/js/jquery.dataTables','datatables-bootstrap','/plugin/bootbox/bootbox.min','pleaseWaitDialog','/plugin/jquery-validation-1.11.1/dist/jquery.validate.min', '/plugin/jquery-validation-1.11.1/dist/additional-methods.min', '/plugin/jquery-validation-1.11.1/localization/messages_es', 'ObservadorSecundario/mis_colaboradores'), array('inline' => false));

// Menu
$this->start('menu');
echo $this->element('/menu');
$this->end();
?>

<div>
    <fieldset>
        <legend><?php echo __('Mis colaboradores'); ?></legend>

        <a href="#divNuevoColaborador" role="button"
            class="btn btn-mini btn-warning" data-toggle="modal"
            id="btnNuevoColaborador"><i class="icon-plus"></i> <?php echo __("Nuevo colaborador");?></a>

        <hr>

        <table id="tabla_colaboradores"
            class="table table-striped table-bordered table-hover table-condensed">
            <thead>
                <tr>
                    <th><?php echo __("Acciones");?></th>
                    <th style="text-align: center;"><?php echo __("Código");?></th>
                    <th style="text-align: center;"><?php echo __("Nombre");?></th>
                </tr>
            </thead>
            <tbody>
            <?php 
                foreach ($colaboradores as $colaborador) {
                    echo "<tr>";
                    echo     "<td style='text-align: center;'>";
                    echo        "<a href='javascript: eliminarColaborador(".$colaborador['ObservadorSecundario']['id'].", \"".$colaborador['ObservadorSecundario']['nombre']."\");' title='".__("Eliminar colaborador")."'><img src='/img/icons/fugue-icons-3.5.6/icons/cross.png' alt='Eliminar colaborador'/></a>&nbsp;&nbsp;";
                    echo        "<a href='javascript: editarColaborador(".$colaborador['ObservadorSecundario']['id'].", \"".$colaborador['ObservadorSecundario']['nombre']."\");' title='".__("Editar colaborador")."'><img src='/img/icons/fugue-icons-3.5.6/icons/pencil.png' alt='Editar colaborador'/></a>&nbsp;&nbsp;";
                    echo    "</td>";
                    echo     "<td style='text-align: center;'>".$colaborador['ObservadorSecundario']['codigo']."</td>";
                    echo     "<td><a href='/cita/index?colaboradorId=".$colaborador['ObservadorSecundario']['id']."'>".$colaborador['ObservadorSecundario']['nombre']."</a></td>";
                    echo "</tr>";
            }?>
            </tbody>
            <tfoot>
                <tr>
                    <th><?php echo __("Acciones");?></th>
                    <th style="text-align: center;"><?php echo __("Código");?></th>
                    <th style="text-align: center;"><?php echo __("Nombre");?></th>
                </tr>
            </tfoot>
        </table>
    </fieldset>
</div>

<form id="frmNuevoColaborador" method="post" action="/observadorSecundario/add">
    <div id="divNuevoColaborador" class="modal hide fade" tabindex="-1"
        role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
        <div class="modal-header">
            <a href="#" class="close" data-dismiss="modal">&times;</a>
            <h4 id="tituloDivNuevoColaborador"><?php echo __("Nuevo colaborador");?></h4>
        </div>
        <div class="modal-body">
            
            <div id="errorMessagesNuevoColaborador" class="alert alert-error"
                style="display: none; padding-left: 14px;">
                <ul></ul>
            </div>
        
            <div class="divDialogElements">
                <label for="txtNombreNuevoColaborador">Nombre</label>
                <input class="input-xxlarge" id="txtNombreNuevoColaborador"
                    name="nombreColaborador" type="text" required="required"
                    placeholder="Escriba el nombre completo..." />
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo __("Cancelar");?></button>
            <button class="btn btn-primary" type="submit"><?php echo __("Aceptar");?></button>
        </div>
    </div>
</form>

<form id="frmEditarColaborador" method="post" action="/observadorSecundario/edit">
    <div id="divEditarColaborador" class="modal hide fade" tabindex="-1"
        role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
        <div class="modal-header">
            <a href="#" class="close" data-dismiss="modal">&times;</a>
            <h4 id="tituloDivEditarColaborador"><?php echo __("Editar colaborador");?></h4>
        </div>
        <div class="modal-body">
            
            <div id="errorMessagesEditarColaborador" class="alert alert-error"
                style="display: none; padding-left: 14px;">
                <ul></ul>
            </div>
        
            <div class="divDialogElements">
                <label for="txtNombreEditarColaborador">Nombre</label>
                <input class="input-xxlarge" id="txtNombreEditarColaborador"
                    name="nombreColaborador" type="text" required="required"
                    placeholder="Escriba el nombre completo..." />
                <input type="hidden" name="idColaborador" id="hdIdEditarColaborador"/>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo __("Cancelar");?></button>
            <button class="btn btn-primary" type="submit"><?php echo __("Aceptar");?></button>
        </div>
    </div>
</form>

<!-- Pie -->
<?php
$this->start ( 'pie' );
echo $this->element ( '/pie' );
$this->end ();
?>