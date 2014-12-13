<?php
// Informamos el título
$this->set('title_for_layout','Mis citas');

/**
 * CSS
 */
$this->Html->css(array('datatables-bootstrap', 'Cita/mis_citas'), null, array('inline' => false));

/**
 * Javascript
 */
$this->Html->script(array('/plugin/DataTables-1.9.4/media/js/jquery.dataTables', 'datatables-bootstrap','/plugin/bootbox/bootbox.min','pleaseWaitDialog', 'Cita/mis_citas'), array('inline' => false));

// Menu
$this->start('menu');
echo $this->element('/menu');
$this->end();
?>

<script type="text/javascript">
    $(document).ready(function(){
        
        /* INICIO tabla citas */
        $("#tabla_citas_observador").dataTable({
            "iDisplayLength": 25,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo $this->Html->Url(array('controller' => 'citaAjax', 'action' => 'obtenerCitasObservadorDatatables', time())); ?>",
            "sDom": "<\'row\'<\'span9\'l><\'span3\'f>r>t<\'row\'<\'span8\'i><\'span4\'p>>",
            "sWrapper": "dataTables_wrapper form-inline",
            "bPaginate": true,
            "sPaginationType": "bootstrap",
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ 0,6,8 ] },
                { "sClass": "text-center", "aTargets": [ 0,2,4,5,7,8 ] }
            ],
            "aoColumns": [null,null,{ "sType": "date-uk" },null,null,null,null,null,null],
            "bInfo": true,
            "bAutoWidth": false,
            "oLanguage": {
                "oAria": {
                    "sSortAscending": " - haz click o pulsa enter para ordenar ascendentemente",
                    "sSortDescending": " - haz click o pulsa enter para ordenar descendentemente"
                  },
                "oPaginate": {
                       "sFirst": "Primera",
                       "sLast": "Última",
                       "sNext": "Siguiente",
                       "sPrevious": "Anterior"
                },
                "sEmptyTable": "No hay datos disponibles",
                "sInfo": "Mostrando (_START_ de _END_) registros de un total de _TOTAL_",
                "sInfoEmpty": "No hay registros para mostrar",
                "sInfoFiltered": "- filtrando por _MAX_ registros",
                "sInfoThousands": "\'",
                "sLengthMenu": "Mostrar <select>"+
                    "<option value=\"10\">10</option>"+
                    "<option value=\"25\">25</option>"+
                    "<option value=\"50\">50</option>"+
                    "<option value=\"-1\">Todos</option>"+
                    "</select> registros",
                "sLoadingRecords": "Cargando citas...",
                "sProcessing": "Cargando citas...",
                "sSearch": "Buscar:",
                "sZeroRecords": "No hay registros que mostrar."
            }
        });
        /* FIN tabla citas */

        /* INICIO tabla citas */
        $("#tabla_citas_colaborador").dataTable({
            "iDisplayLength": 25,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo $this->Html->Url(array('controller' => 'citaAjax', 'action' => 'obtenerCitasColaboradorDatatables', time())); ?>",
            "sDom": "<\'row\'<\'span9\'l><\'span3\'f>r>t<\'row\'<\'span8\'i><\'span4\'p>>",
            "sWrapper": "dataTables_wrapper form-inline",
            "bPaginate": true,
            "sPaginationType": "bootstrap",
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ 0,6,8 ] },
                { "sClass": "text-center", "aTargets": [ 0,2,4,5,7,8 ] }
            ],
            "aoColumns": [null,null,{ "sType": "date-uk" },null,null,null,null,null,null],
            "bInfo": true,
            "bAutoWidth": false,
            "oLanguage": {
                "oAria": {
                    "sSortAscending": " - haz click o pulsa enter para ordenar ascendentemente",
                    "sSortDescending": " - haz click o pulsa enter para ordenar descendentemente"
                  },
                "oPaginate": {
                       "sFirst": "Primera",
                       "sLast": "Última",
                       "sNext": "Siguiente",
                       "sPrevious": "Anterior"
                },
                "sEmptyTable": "No hay datos disponibles",
                "sInfo": "Mostrando (_START_ de _END_) registros de un total de _TOTAL_",
                "sInfoEmpty": "No hay registros para mostrar",
                "sInfoFiltered": "- filtrando por _MAX_ registros",
                "sInfoThousands": "\'",
                "sLengthMenu": "Mostrar <select>"+
                    "<option value=\"10\">10</option>"+
                    "<option value=\"25\">25</option>"+
                    "<option value=\"50\">50</option>"+
                    "<option value=\"-1\">Todos</option>"+
                    "</select> registros",
                "sLoadingRecords": "Cargando citas...",
                "sProcessing": "Cargando citas...",
                "sSearch": "Buscar:",
                "sZeroRecords": "No hay registros que mostrar."
            }
        });
        /* FIN tabla citas */
    });
</script>

<!-- Cuerpo -->
<div>
    <fieldset>
        <legend>
        <?php echo __('Mis citas'); ?>
        </legend>
        
        <fieldset>
            <legend class="small"><?php echo __("Mis citas como observador");?></legend>
            <table id="tabla_citas_observador" class="table table-striped table-bordered table-hover table-condensed">    
                <thead>
                    <tr>
                        <th style="text-align: center;"><?php echo __("Acciones");?></th>
                        <th style="text-align: center;"><?php echo __("Especie");?></th>
                        <th style="text-align: center;"><?php echo __("Fecha");?></th>
                        <th style="text-align: center;"><?php echo __("Lugar");?></th>
                        <th style="text-align: center;"><?php echo __("Número de Aves");?></th>
                        <th style="text-align: center;"><?php echo __("Observador");?></th>
                        <th style="text-align: center;"><?php echo __("Colaboradores");?></th>
                        <th style="text-align: center;"><?php echo __("Clase de Reproducción");?></th>
                        <th style="text-align: center;"><?php echo __("Importancia");?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="100%" class="dataTables_empty"><?php echo __("Cargando citas...");?> <img src="/img/gif/cargando_barra_mini.gif"></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th style="text-align: center;"><?php echo __("Acciones");?></th>
                        <th style="text-align: center;"><?php echo __("Especie");?></th>
                        <th style="text-align: center;"><?php echo __("Fecha");?></th>
                        <th style="text-align: center;"><?php echo __("Lugar");?></th>
                        <th style="text-align: center;"><?php echo __("Número de Aves");?></th>
                        <th style="text-align: center;"><?php echo __("Observador");?></th>
                        <th style="text-align: center;"><?php echo __("Colaboradores");?></th>
                        <th style="text-align: center;"><?php echo __("Clase de Reproducción");?></th>
                        <th style="text-align: center;"><?php echo __("Importancia");?></th>
                    </tr>
                </tfoot>
            </table>
        </fieldset>

        <fieldset>
            <legend class="small"><?php echo __("Mis citas como colaborador");?></legend>
        
            <table id="tabla_citas_colaborador" class="table table-striped table-bordered table-hover table-condensed">    
                <thead>
                    <tr>
                        <th style="text-align: center;"><?php echo __("Ver más");?></th>
                        <th style="text-align: center;"><?php echo __("Especie");?></th>
                        <th style="text-align: center;"><?php echo __("Fecha");?></th>
                        <th style="text-align: center;"><?php echo __("Lugar");?></th>
                        <th style="text-align: center;"><?php echo __("Número de Aves");?></th>
                        <th style="text-align: center;"><?php echo __("Observador");?></th>
                        <th style="text-align: center;"><?php echo __("Colaboradores");?></th>
                        <th style="text-align: center;"><?php echo __("Clase de Reproducción");?></th>
                        <th style="text-align: center;"><?php echo __("Importancia");?></th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="100%" class="dataTables_empty"><?php echo __("Cargando citas...");?> <img src="/img/gif/cargando_barra_mini.gif"></td>
                </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th style="text-align: center;"><?php echo __("Ver más");?></th>
                        <th style="text-align: center;"><?php echo __("Especie");?></th>
                        <th style="text-align: center;"><?php echo __("Fecha");?></th>
                        <th style="text-align: center;"><?php echo __("Lugar");?></th>
                        <th style="text-align: center;"><?php echo __("Número de Aves");?></th>
                        <th style="text-align: center;"><?php echo __("Observador");?></th>
                        <th style="text-align: center;"><?php echo __("Colaboradores");?></th>
                        <th style="text-align: center;"><?php echo __("Clase de Reproducción");?></th>
                        <th style="text-align: center;"><?php echo __("Importancia");?></th>
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