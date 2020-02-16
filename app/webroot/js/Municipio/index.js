$(document).ready(function() {

    $("#selectMunicipio").change(function(){
         $( "#frmMunicipio" ).submit();
    });

    /* INICIO Tabla de lugares */
    var asInitVals = [];
    var oTable;

    oTable = $("#tablaMunicipios").dataTable({
        "aLengthMenu": [[10, 25, 50], [10, 25, 50]],
        "sDom": "<'row'<'span2'l><'span8'f>r>t<'row'<'span2'i><'span8'p>>",
        "sWrapper": "dataTables_wrapper form-inline",
        "bPaginate": true,
        "sPaginationType": "bootstrap",
        "iDisplayLength": 5,
        "bLengthChange": false,
        "bFilter": true,
        "bSort": true,
        "bInfo": false,
        "bAutoWidth": true,
        "oLanguage": {
            "sUrl": "/lang/es/datatables.json"
        }
    });

    $("tfoot input").keyup( function () {
        /* Filter on the column (the index) of this element */
        oTable.fnFilter( this.value, $("tfoot input").index(this) );
    } );

    $("tfoot input").each( function (i) {
        asInitVals[i] = this.value;
    } );
    
    $("tfoot input").focus( function () {
        if ( this.className == "search_init" )
        {
            this.className = "";
            this.value = "";
        }
    } );
    $("tfoot input").blur( function (i) {
        if ( this.value == "" )
        {
            this.className = "search_init";
            this.value = asInitVals[$("tfoot input").index(this)];
        }
    } );

    $("#tablaMunicipios_filter").hide();
    /* FIN Tabla de lugares */

    /* INICIO popup ayuda */
    $('.help-button').popover();
    /* FIN popup ayuda */

});

var map;

function initialize() {

    var myLatlng = new google.maps.LatLng(38.70, -1.70);

    var mapOptions = {
        zoom:8,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("map_canvas"),
        mapOptions);
    
    // GeoXML para añadir eventos
    geoXml = new geoXML3.parser({
        map: map,
        singleInfoWindow: true,
        zoom: false,
        afterParse: useTheData
    });
    
    // Tratamos el archivo
    geoXml.parse('/kml/municipios_AB.kml');
}

google.maps.event.addDomListener(window, 'load', initialize);