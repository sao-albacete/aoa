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
