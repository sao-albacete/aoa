<?php

/**
 * CSS
 */
$this->Html->css(array(
    'Elements/Lugar/seleccionarLugar'
), null, array('inline' => false));

/**
 * Javascript
 */
$this->Html->script(array(
    'Elements/Lugar/seleccionarLugar'
), array('inline' => false));

?>

<div id="modalSeleccioanrLugar" class="modal hide fade" tabindex="-1"
     role="dialog" aria-labelledby="myModalSeleccioanrLugar" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"
                aria-hidden="true">×
        </button>
        <h3 id="myModalSeleccioanrLugar"><?php echo __("Seleccione un lugar"); ?></h3>
    </div>
    <div class="modal-body">
        <table id="tablaLugares" class="tablaLugares table table-striped table-bordered table-condensed table-hover">
            <thead>
            <tr>
                <th class="span1"><?php echo __("Lugar"); ?></th>
                <th class="span1"><?php echo __("Municipio"); ?></th>
                <th class="span1"><?php echo __("Comarca"); ?></th>
                <th class="span1"><?php echo __("Cuadrícula UTM"); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($lugares as $lugar) {
                echo "<tr id='" . $lugar["Lugar"]["id"] . "'>";
                echo "<td class='span1'>" . $lugar["Lugar"]["nombre"] . "</td>";
                echo "<td class='span1'>" . $lugar["Municipio"]["nombre"] . "</td>";
                echo "<td class='span1'>" . $lugar["Comarca"]["nombre"] . "</td>";
                echo "<td class='span1'>" . $lugar["CuadriculaUtm"]["codigo"] . "</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
            <tfoot>
            <tr>
                <th class="span1"><input type="text" name="buscarLugar"
                                         value="Buscar lugar..." class="search_init"/></th>
                <th class="span1"><input type="text" name="buscarMunicipio"
                                         value="Buscar municipio..." class="search_init"/></th>
                <th class="span1"><input type="text" name="buscarComarca"
                                         value="Buscar comarca..." class="search_init"/></th>
                <th class="span1"><input type="text" name="buscarCuadriculaUtm"
                                         value="Buscar cuadrícula UTM..." class="search_init"/></th>
            </tr>
            </tfoot>
        </table>
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger" aria-hidden="true" data-dismiss="modal"><i class="icon-remove"></i> <?php echo __("Cancelar"); ?></button>
        <button class="btnAceptar btn btn-success" aria-hidden="true" data-dismiss="modal"><i class="icon-ok"></i> <?php echo __("Aceptar"); ?></button>
    </div>
</div>