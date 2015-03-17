$(document).ready(function(){

    /* INICIO tabla citas */
    $("#tabla_citas_observador").dataTable({
        "iDisplayLength": 25,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/citaAjax/obtenerCitasObservadorDatatables/" + (new Date().getTime()),
        "sDom": "<\'row\'<\'span9\'l><\'span3\'f>r>t<\'row\'<\'span8\'i><\'span4\'p>>",
        "sWrapper": "dataTables_wrapper form-inline",
        "bPaginate": true,
        "sPaginationType": "bootstrap",
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "aoColumnDefs": [
            { 'bSortable': false, 'aTargets': [ 0,1,7 ] },
            { "sClass": "text-center", "aTargets": [ 0,1,4,5,7,8,9 ] }
        ],
        "aoColumns": [null,null,null,{ "sType": "date-uk" },null,null,null,null,null,null],
        "bInfo": true,
        "bAutoWidth": false,
        "oLanguage": {
            "sUrl": "/lang/es/datatables.json"
        }
    });
    /* FIN tabla citas */

    /* INICIO tabla citas */
    $("#tabla_citas_colaborador").dataTable({
        "iDisplayLength": 25,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/citaAjax/obtenerCitasColaboradorDatatables/" + (new Date().getTime()),
        "sDom": "<\'row\'<\'span9\'l><\'span3\'f>r>t<\'row\'<\'span8\'i><\'span4\'p>>",
        "sWrapper": "dataTables_wrapper form-inline",
        "bPaginate": true,
        "sPaginationType": "bootstrap",
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "aoColumnDefs": [
            { 'bSortable': false, 'aTargets': [ 0,1,7 ] },
            { "sClass": "text-center", "aTargets": [ 0,1,4,5,7,8,9 ] }
        ],
        "aoColumns": [null,null,null,{ "sType": "date-uk" },null,null,null,null,null,null],
        "bInfo": true,
        "bAutoWidth": false,
        "oLanguage": {
            "sUrl": "/lang/es/datatables.json"
        }
    });
    /* FIN tabla citas */
});

function eliminarCita(idCita, nombreEspecie) {

    var msg = "¿Está seguro de que desea eliminar la cita de <b>" + nombreEspecie + "</b>?";
    
    bootbox.confirm(msg, "Cancelar", "Aceptar", function(result) {
        if(result == true) {
            myApp.showPleaseWait();
            window.location = "/cita/delete/id:" + idCita;
            return true;
        }
    });
}