$(document).ready(function() {

    /* INICIO Tabla de lugares */
    
    $("#tablaLugares").dataTable({
        "aLengthMenu": [[10, 25, 50], [10, 25, 50]],
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
            "sUrl": "/lang/es/datatables.json"
        }
    });

    /* FIN Tabla de lugares */
});

function eliminarLugar(idLugar, nombreLugar) {

    var msg = "¿Está seguro de que desea eliminar el lugar <b>" + nombreLugar + "</b>?";
    
    bootbox.confirm(msg, "Cancelar", "Aceptar", function(result) {
        if(result == true) {
            myApp.showPleaseWait();
            window.location = "/lugar/delete/id:" + idLugar;
            return true;
        }
    });
}
