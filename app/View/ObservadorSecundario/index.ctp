<?php 

// Informamos el título
$this->set('title_for_layout','Colaboradores');

/**
 * CSS
 */
$this->Html->css(array('datatables-bootstrap'), null, array('inline' => false));

/**
 * Javascript
 */
$this->Html->script(array('/plugin/DataTables-1.9.4/media/js/jquery.dataTables', 'datatables-bootstrap'), array('inline' => false));

// Menu
$this->start('menu');
echo $this->element('/menu');
$this->end();
?>

<style>
<!--
-->
</style>

<script type="text/javascript">
<!--
$(document).ready(function(){

    /* INICIO tabla resultados */
    var oTable = $("#tabla_colaboradores").dataTable({
        "iDisplayLength": 25,
        "sDom": "<\'row\'<\'span9\'l><\'span3\'f>r>t<\'row\'<\'span8\'i><\'span4\'p>>",
        "sWrapper": "dataTables_wrapper form-inline",
        "bPaginate": true,
        "sPaginationType": "bootstrap",
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "aoColumnDefs": [
             { 'bSortable': false, 'aTargets': [ 0 ] }
         ],
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
            "sLoadingRecords": "Por favor, espere. Cargando...",
            "sProcessing": "El servidor está ocupado.",
            "sSearch": "Buscar:",
            "sZeroRecords": "No hay registros que mostrar."
        }
    });
    /* FIN tabla resultados */
});
    
//-->
</script>

<div>
    <fieldset>
        <legend><?php echo __('Colaboradores'); ?></legend>
        
        <table id="tabla_colaboradores" class="table table-striped table-bordered table-hover table-condensed">    
            <thead>
                <tr>
                    <th style="text-align: center;"><?php echo __("Código");?></th>
                    <th style="text-align: center;"><?php echo __("Nombre");?></th>
                </tr>
            </thead>
            <tbody>
            <?php if(empty($colaboradores)) {
                echo "<tr>";
                echo "<td colspan='100%'>No existen colaboradores dados de alta en la aplicación</td>";
                echo "</tr>";
            }
            else {?>
            <?php 
                foreach ($colaboradores as $colaborador) {
                    echo "<tr>";
                    echo     "<td style='text-align: center;'>".$colaborador['ObservadorSecundario']['codigo']."</td>";
                    echo     "<td><a href='/cita/index?colaboradorId=".$colaborador['ObservadorSecundario']['id']."'>".$colaborador['ObservadorSecundario']['nombre']."</a></td>";
                    echo "</tr>";
                }
            }?>
            </tbody>
            <tfoot>
                <tr>
                    <th style="text-align: center;"><?php echo __("Código");?></th>
                    <th style="text-align: center;"><?php echo __("Nombre");?></th>
                </tr>
            </tfoot>
        </table>
    </fieldset>
</div>

<!-- Pie -->
<?php
    $this->start('pie');
    echo $this->element('/pie');
    $this->end();
?>