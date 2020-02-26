<?php
// Informamos el título
$this->set('title_for_layout','Mis citas');

/**
 * CSS
 */
$this->Html->css(array(
    'datatables-bootstrap',
    'Cita/mis_citas'
), null, array('inline' => false));

/**
 * Javascript
 */
$this->Html->script(array(
    '/plugin/DataTables-1.9.4/media/js/jquery.dataTables',
    'datatables-bootstrap',
    '/plugin/bootbox/bootbox.min',
    'pleaseWaitDialog',
    'Cita/mis_citas'
), array('inline' => false));

// Menu
$this->start('menu');
echo $this->element('/menu');
$this->end();
?>

<!-- Cuerpo -->
<div>
    <fieldset>
        <legend><?=__('Mis citas'); ?></legend>
        
        <fieldset>
            <legend class="small"><?=__("Mis citas como observador");?></legend>
            <table id="tabla_citas_observador" class="table table-striped table-bordered table-hover table-condensed">    
                <thead>
                    <tr>
                        <th><?=__("Acciones");?></th>
                        <th><?=__("Importancia");?></th>
                        <th><?=__("Fotos");?></th>
                        <th><?=__("Especie");?></th>
                        <th><?=__("Fecha");?></th>
                        <th><?=__("Lugar");?></th>
                        <th><?=__("Número de Aves");?></th>
                        <th><?=__("Observador");?></th>
                        <th><?=__("Colaboradores");?></th>
                        <th><?=__("Clase de Reproducción");?></th>
                        <th><?=__("Criterio de Selección");?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="100%" class="dataTables_empty"><img src="/img/gif/cargando_barra_mini.gif"></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th><?=__("Acciones");?></th>
                        <th><?=__("Importancia");?></th>
                        <th><?=__("Fotos");?></th>
                        <th><?=__("Especie");?></th>
                        <th><?=__("Fecha");?></th>
                        <th><?=__("Lugar");?></th>
                        <th><?=__("Número de Aves");?></th>
                        <th><?=__("Observador");?></th>
                        <th><?=__("Colaboradores");?></th>
                        <th><?=__("Clase de Reproducción");?></th>
                        <th><?=__("Criterio de Selección");?></th>
                    </tr>
                </tfoot>
            </table>
        </fieldset>

        <fieldset>
            <legend class="small"><?=__("Mis citas como colaborador");?></legend>
        
            <table id="tabla_citas_colaborador" class="table table-striped table-bordered table-hover table-condensed">    
                <thead>
                    <tr>
                        <th><?=__("Ver más");?></th>
                        <th><?=__("Importancia");?></th>
                        <th><?=__("Fotos");?></th>
                        <th><?=__("Especie");?></th>
                        <th><?=__("Fecha");?></th>
                        <th><?=__("Lugar");?></th>
                        <th><?=__("Número de Aves");?></th>
                        <th><?=__("Observador");?></th>
                        <th><?=__("Colaboradores");?></th>
                        <th><?=__("Clase de Reproducción");?></th>
                        <th><?=__("Criterio de Selección");?></th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="100%" class="dataTables_empty"><?=__("Cargando citas...");?> <img src="/img/gif/cargando_barra_mini.gif"></td>
                </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th><?=__("Ver más");?></th>
                        <th><?=__("Importancia");?></th>
                        <th><?=__("Fotos");?></th>
                        <th><?=__("Especie");?></th>
                        <th><?=__("Fecha");?></th>
                        <th><?=__("Lugar");?></th>
                        <th><?=__("Número de Aves");?></th>
                        <th><?=__("Observador");?></th>
                        <th><?=__("Colaboradores");?></th>
                        <th><?=__("Clase de Reproducción");?></th>
                        <th><?=__("Criterio de Selección");?></th>
                    </tr>
                </tfoot>
            </table>
        
        </fieldset>
    </fieldset>
</div>

<!-- Pie -->
<?php
$this->start('pie');
echo $this->element('/pie');
$this->end();
?>