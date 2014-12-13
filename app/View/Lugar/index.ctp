<?php 
    // Informamos el título
    $this->set('title_for_layout','Lugares');
    
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

<script type="text/javascript">
<!--

    $(document).ready(function() {

        /* INICIO Tabla de lugares */
        $("#tablaLugares").dataTable({
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
        /* FIN Tabla de lugares */

    });
//-->
</script>

<div>
    <fieldset>
        <legend><?php echo __('Lugares'); ?></legend>
        
        <a href="/lugar/add" role="button"
            class="btn btn-mini btn-warning" data-toggle="modal"
            id="btnNuevoLugar"><i class="icon-plus"></i> <?php echo __("Nuevo lugar");?></a>
            
        <hr>

        <table id="tablaLugares" class="table table-striped table-bordered table-hover table-condensed">
            <thead>
                <tr>
                    <th><?php echo __("Ver");?></th>
                    <th><?php echo __("Lugar");?></th>
                    <th><?php echo __("Municipio");?></th>
                    <th><?php echo __("Comarca");?></th>
                    <th><?php echo __("Cuadrícula UTM");?></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($lugares as $lugar) {
                        echo "<tr id='".$lugar["Lugar"]["id"]."'>";
                        echo     "<td style='text-align: center;'><a href='/lugar/view/id:".$lugar['Lugar']['id']."' title='".__("Ver detalle del lugar")."'><img src='/img/icons/fugue-icons-3.5.6/icons/magnifier-left.png' title='Ver detalle del lugar' alt='Ver detalle'/></a></td>";
                        echo     "<td><a href='/cita/index?lugarId=".$lugar["Lugar"]["id"]."'>".$lugar["Lugar"]["nombre"]."</a></td>";
                        echo     "<td><a href='/cita/index?municipioId=".$lugar["Municipio"]["id"]."'>".$lugar["Municipio"]["nombre"]."</a></td>";
                        echo     "<td><a href='/cita/index?comarcaId=".$lugar["Comarca"]["id"]."'>".$lugar["Comarca"]["nombre"]."</a></td>";
                        echo     "<td><a href='/cita/index?cuadriculaUtmId=".$lugar["CuadriculaUtm"]["id"]."'>".$lugar["CuadriculaUtm"]["codigo"]."</a></td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th><?php echo __("Ver");?></th>
                    <th><?php echo __("Lugar");?></th>
                    <th><?php echo __("Municipio");?></th>
                    <th><?php echo __("Comarca");?></th>
                    <th><?php echo __("Cuadrícula UTM");?></th>
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