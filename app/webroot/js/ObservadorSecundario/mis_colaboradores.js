$(document).ready(function(){

    /* INICIO tabla resultados */
    $("#tabla_colaboradores").dataTable({
        "aLengthMenu": [[10, 25, 50], [10, 25, 50]],
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