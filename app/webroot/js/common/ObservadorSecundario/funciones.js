function seleccionarColaborador($div)
{
    $div.find("#colaboradores").autocomplete({
        source: function( request, response ) {
            $.getJSON( "/observadorSecundario/buscar_observadores_secundarios", {
                    term: request.term,
                    data: $("#colaboradoresSeleccionados").val()
                },
                response );
        },
        minLength: 3,
        select: function( event, ui ) {
            if(ui.item) {
                insertarColaborador( ui.item.value, ui.item.id);
            }
            return false;
        }
    });
}

/**
 * Limpia la lista de colaboradores selecciandos
 *
 * @param $div
 */
function limpiarColaboradores($div)
{
    $div.find("#colaboradoresSeleccionadosTexto").text("");
    $div.find("#colaboradoresSeleccionados").val("");
    $div.find("#colaboradores").val("");
    $div.find('#colaboradoresSeleccionadosDiv').hide();
}

/**
 * Inserta un nuevo colaborador en el listado
 * @param nombre
 * @param id
 */
function insertarColaborador(nombre, id) {

    var $nombreColaboradoresSeleccioandos = $("#colaboradoresSeleccionadosTexto"),
        $idColaboradoresSeleccioandos = $("#colaboradoresSeleccionados"),
        obsSelTxt = $nombreColaboradoresSeleccioandos.text();

    // Insertamos el nuevo nombre
    $("#colaboradoresSeleccionadosDiv").show();
    if(obsSelTxt == null || obsSelTxt == "" || obsSelTxt == "-") {
        obsSelTxt = nombre;
    }
    else {
        obsSelTxt += ", " + nombre;
    }
    $("#colaboradores").val("");
    $nombreColaboradoresSeleccioandos.text(obsSelTxt);

    // Insertamos el nuevo id
    var obsSel = $idColaboradoresSeleccioandos.val();
    if(obsSel == "") {
        obsSel = id;
    }
    else {
        obsSel = obsSel + "," + id;
    }
    $idColaboradoresSeleccioandos.val(obsSel);
}