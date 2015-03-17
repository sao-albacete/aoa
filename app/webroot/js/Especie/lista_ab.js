$(document).ready(function(){

    var tbListaAvesAb = $('#tbListaAvesAb').DataTable({
        "bPaginate": false,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": false,
        "bInfo": false,
        "bAutoWidth": false,
        "oLanguage": {
            "sSearch": "Buscar:"
        }
    });
    new $.fn.dataTable.FixedHeader(tbListaAvesAb);
});