<?php
/* /app/View/Helper/AoaTableHelper.php */

App::uses('AppHelper', 'View/Helper');

class AoaTableHelper extends AppHelper {

    /**
     * Retorna la palabra recibida con la primera letra mayúscula
     *
     * @param $idTabla
     * @return string
     * @internal param string $palabra
     */
    public function obtener_configuracion_datatables($idTabla) {
        
        $out = 
        '$(document).ready(function() {
            $("#'.$idTabla.'").dataTable({
                "aLengthMenu": [[10, 25, 50], [10, 25, 50]],
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
                    "sUrl": "/lang/es/datatables.json"
                }
            });
        });'; 
        
        return $out;
    }
}