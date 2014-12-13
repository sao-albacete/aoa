<?php
/* /app/View/Helper/AoaTableHelper.php */

App::uses('AppHelper', 'View/Helper');

class AoaTableHelper extends AppHelper {
    
    /**
     * Retorna la palabra recibida con la primera letra mayúscula
     * 
     * @param string $palabra
     */
    public function obtener_configuracion_datatables($idTabla) {
        
        $out = 
        '$(document).ready(function() {
            $("#'.$idTabla.'").dataTable({
                "iDisplayLength": 25,
                "sDom": "<\'row\'<\'span6\'l><\'span6\'f>r>t<\'row\'<\'span6\'i><\'span6\'p>>",
                "sWrapper": "dataTables_wrapper form-inline",
                "bPaginate": true,
                "sPaginationType": "bootstrap",
                "bLengthChange": true,
                "bFilter": true,
                "bSort": true,
                "bInfo": true,
                "bAutoWidth": false,
                "oLanguage": {
                    "oAria": {
                        "sSortAscending": "'.__(" - haz click o pulsa enter para ordenar ascendentemente").'",
                        "sSortDescending": "'.__(" - haz click o pulsa enter para ordenar descendentemente").'"
                      },
                    "oPaginate": {
                           "sFirst": "'.__("Primera").'",
                           "sLast": "'.__("Última").'",
                           "sNext": "'.__("Siguiente").'",
                           "sPrevious": "'.__("Anterior").'"
                    },
                    "sEmptyTable": "'.__("No hay datos disponibles").'",
                    "sInfo": "'.__("Mostrando (_START_ de _END_) registros de un total de _TOTAL_").'",
                    "sInfoEmpty": "'.__("No hay registros para mostrar").'",
                    "sInfoFiltered": "'.__("- filtrando por _MAX_ registros").'",
                    "sInfoThousands": "\'",
                    "sLengthMenu": "'.__("Mostrar").' <select>"+
                        "<option value=\"10\">10</option>"+
                        "<option value=\"25\">25</option>"+
                        "<option value=\"50\">50</option>"+
                        "<option value=\"-1\">'.__("Todos").'</option>"+
                        "</select> '.__("registros").'",
                    "sLoadingRecords": "'.__("Por favor, espere. Cargando...").'",
                    "sProcessing": "'.__("El servidor está ocupado.").'",
                    "sSearch": "'.__("Buscar").':",
                    "sZeroRecords": "'.__("No hay registros que mostrar.").'"
                }
            });
        });'; 
        
        return $out;
    }
}
?>