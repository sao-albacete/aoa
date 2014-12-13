$(document).ready(function(){

    /* INICIO tabla resultados */
    $("#tabla_colaboradores").dataTable({
        "iDisplayLength": 5,
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
    
    /** INICIO Validación de formulario * */
    
    $('#frmNuevoColaborador').validate({
        messages: {
            nombreColaborador : {
                 required: "Por favor, introduzca el nombre completo"
             }
        },
        errorContainer: "#errorMessagesNuevoColaborador",
        errorLabelContainer : "#errorMessagesNuevoColaborador ul",
        wrapper: "li"
    });

    $('#frmEditarColaborador').validate({
        messages: {
            nombreColaborador : {
                 required: "Por favor, introduzca el nombre completo"
             }
        },
        errorContainer: "#errorMessagesEditarColaborador",
        errorLabelContainer : "#errorMessagesEditarColaborador ul",
        wrapper: "li"
    });
    
    /** FIN Validación de formulario **/
});

function eliminarColaborador(idColaborador, nombreColaborador) {

    var msg = "¿Está segudo de que desea eliminar el colaborador <b>" + nombreColaborador + "</b>?";
    
    bootbox.confirm(msg, "Cancelar", "Aceptar", function(result) {
        if(result == true) {
            myApp.showPleaseWait();
            window.location = "/observadorSecundario/delete/id:" + idColaborador;
            return true;
        }
    });
}

function editarColaborador(idColaborador, nombreColaborador) {

    $("#txtNombreEditarColaborador").val(nombreColaborador);
    $("#hdIdEditarColaborador").val(idColaborador);

    $("#divEditarColaborador").modal("show");
}