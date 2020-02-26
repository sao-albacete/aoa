jQuery.fn.dataTableExt.oSort['date-uk-pre']  = function(a,b) {
    var dateString = a.substr(a.length-14, 10);
    var ukDatea = dateString.split('/');
    return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
};

jQuery.fn.dataTableExt.oSort['date-uk-asc']  = function(a,b) {
    return ((a < b) ? -1 : ((a > b) ? 1 : 0));
};

jQuery.fn.dataTableExt.oSort['date-uk-desc'] = function(a,b) {
    return ((a < b) ? 1 : ((a > b) ? -1 : 0));
};

$(document).ready(function(){

    /* INICIO tabla citas */
    $("#tabla_citas").dataTable({
        "aLengthMenu": [[10, 25, 50], [10, 25, 50]],
        "iDisplayLength": 25,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/citaAjax/obtenerCitasDatatables/" + (new Date().getTime()) + "?iTotal=100",
        "bPaginate": true,
        "sPaginationType": "bootstrap",
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "aoColumnDefs": [
            { 'bSortable': false, 'aTargets': [ 0,1,2,8 ] },
            { "sClass": "text-center", "aTargets": [ 0,1,2,4,6,7,8,9,10 ] }
        ],
        "aoColumns": [null,null,null,{ "sType": "date-uk" },null,null,null,null,null,null,null],
        "bInfo": true,
        "bAutoWidth": false,
        "oLanguage": {
            "sUrl": "/lang/es/datatables.json"
        }
    });
    /* FIN tabla citas */
    
    /* INICIO fotos */
    $(".yoxview").yoxview({
        "lang" : "es",
        "autoHideMenu" : false,
        "autoHideInfo" : false,
        "showDescription" : true,
        "renderInfoPin" : false
    });
    /* FIN fotos */

});