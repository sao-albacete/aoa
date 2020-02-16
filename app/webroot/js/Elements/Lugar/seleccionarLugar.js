$(document).ready(function(){

    var asInitVals = [],
        oTable,
        $divSeleccionarLugar = $('#modalSeleccioanrLugar');

    /* Add a click handler to the rows - this could be used as a callback */
    $divSeleccionarLugar.find(".tablaLugares tbody tr").click( function( e ) {

        // Deseleccionar
        if ( $(this).hasClass('row_selected') ) {
            $(this).removeClass('row_selected');

            $("#lugarId").val("");
            $("#lugar").val("");
        }
        // Seleccionar
        else {
            oTable.$('tr.row_selected').removeClass('row_selected');
            $(this).addClass('row_selected');

            $("#lugarId").val($(this).attr("id"));

            var textoLugar = "";
            $divSeleccionarLugar.find(".tablaLugares tbody tr.row_selected td").each(function(){
                textoLugar = textoLugar + $(this).html() + ", ";
            });

            $("#lugar").val(textoLugar.substring(0, textoLugar.length - 2));
            $("#lugarSeleccionadoContenedor").show();
            $("#lugarSeleccionado").text(textoLugar.substring(0, textoLugar.length - 2));
        }
    });

    oTable = $divSeleccionarLugar.find(".tablaLugares").dataTable({
        "aLengthMenu": [[10, 25, 50], [10, 25, 50]],
        "iDisplayLength": 5,
        "sDom": "<'row'<'span3'l><'span6'f>r>t<'row'<'span3'i><'span6'p>>",
        "sWrapper": "dataTables_wrapper form-inline",
        "bPaginate": true,
        "sPaginationType": "bootstrap",
        "bLengthChange": false,
        "bFilter": true,
        "bSort": true,
        "bInfo": false,
        "bAutoWidth": true,
        "oLanguage": {
            "sUrl": "/lang/es/datatables.json"
        }
    });

    $divSeleccionarLugar.find(".tablaLugares tfoot input").keyup( function () {
        /* Filter on the column (the index) of this element */
        oTable.fnFilter( this.value, $divSeleccionarLugar.find(".tablaLugares tfoot input").index(this) );
    } );

    $divSeleccionarLugar.find(".tablaLugares tfoot input").each( function (i) {
        asInitVals[i] = this.value;
    } );

    $divSeleccionarLugar.find(".tablaLugares tfoot input").focus( function () {
        if ( this.className == "search_init" )
        {
            this.className = "";
            this.value = "";
        }
    } );
    $divSeleccionarLugar.find(".tablaLugares tfoot input").blur( function (i) {
        if ( this.value == "" )
        {
            this.className = "search_init";
            this.value = asInitVals[$divSeleccionarLugar.find(".tablaLugares tfoot input").index(this)];
        }
    } );

    $("#tablaLugares_filter").hide();
});
