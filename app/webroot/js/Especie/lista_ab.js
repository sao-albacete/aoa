$(document).ready(function(){

    var tbListaAvesAb = $('#tbListaAvesAb').DataTable({
        "bPaginate": false,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": false,
        "bInfo": false,
        "bAutoWidth": false,
        "oLanguage": {
            "sUrl": "/lang/es/datatables.json"
        }
    });
    new $.fn.dataTable.FixedHeader(tbListaAvesAb);
});