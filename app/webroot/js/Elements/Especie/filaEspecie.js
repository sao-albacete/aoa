/**
 * Valida los datos introducidos en el formulario de especie y si son correctos,
 * añade una nueva fila, si no, muestra los errores de validación
 *
 * @param $div
 * @param errorContainer
 * @param numeroFila
 */
function validarFormularioEspecie($div, errorContainer, numeroFila)
{
    var $formulario = $div.find('.frmEspecie');

    jQuery.validator.addMethod("validarEspecie", function(value, element) {
        return $div.find(".especieId").val() != "";
    }, "Debe seleccionar una especie.");

    jQuery.validator.addMethod("validarNumeroAves", function(value, element) {
        var total_numero_aves = 0;
        $div.find(".numero_aves").each(function(){
            total_numero_aves += parseInt($(this).val());
        });
        return total_numero_aves > 0;
    }, "El número de aves debe ser mayor que cero.");

    $formulario.validate({
        rules: {
            especie: {
                validarEspecie: true
            },
            "data[claseEdadSexo][][4]": {
                validarNumeroAves: true
            },
            "data[Cita][clase_reproduccion_id]" : {
                required: true
            }
        },
        messages: {
            "data[Cita][clase_reproduccion_id]" : {
                required: "Debe seleccionar un dato de reproducción."
            }
        },
        errorContainer: "#" + errorContainer,
        errorLabelContainer : "#" + errorContainer + " ul",
        wrapper: "li",
        onfocusout: false
    });

    if ($formulario.valid()) {

        if (numeroFila) {
            eliminarFilaEspecie(numeroFila);
        }
        insertarFilaEspecie($div, numeroFila);

        ordenarTablaEspecies(document.getElementById("tablaEspecies").tBodies[0], 0, 1);

        $div.modal('hide');
    }
}

/**
 * Inserta una nueva fila en la tabla de especies y sus hiddens correspondientes
 * @param $div
 * @param fila
 */
function insertarFilaEspecie($div, fila)
{
    var $tablaEspecies = $('#tablaEspecies'),
        $indHabitatRaro = $div.find(".indHabitatRaro").is(":checked"),
        $indCriaHabitatRaro = $div.find(".indCriaHabitatRaro").is(":checked"),
        $indHerido = $div.find(".indHerido").is(":checked"),
        $indComportamiento = $div.find(".indComportamiento").is(":checked"),
        numeroFila = fila ? fila : $tablaEspecies.find('tbody tr').length,
        $formulario = $('#frmNuevaCitaMultiple');

    // Insertar fila en la tabla de especies
    content = [];
    content.push('<tr id="fila' + numeroFila + '">');
    content.push('<td>' + $div.find(".especie").val() +  ' ' + $div.find(".subespecie").val() + '</td>');
    content.push('<td style="text-align: center">' + $div.find(".totalNumeroAves").val() + '</td>');
    content.push('<td>' + $div.find(".datosReproduccion option:selected").text() + '</td>');
    content.push('<td style="text-align: center">' + ($indHabitatRaro ? 'Sí' : 'No') + '</td>');
    content.push('<td style="text-align: center">' + ($indCriaHabitatRaro ? 'Sí' : 'No') + '</td>');
    content.push('<td style="text-align: center">' + ($indHerido ? 'Sí' : 'No') + '</td>');
    content.push('<td style="text-align: center">' + ($indComportamiento ? 'Sí' : 'No') + '</td>');
    // content.push('<td>' + $div.find(".observaciones ").val() + '</td>');
    content.push(insertarBotonesFila(numeroFila));
    content.push('</tr>');
    $tablaEspecies.find('tbody').append(content.join());

    // Insertar hiddens en el formulario de envio
    $formulario.append('<input type="hidden" value="' + $div.find(".especieId").val() + '" name="data[Especie][' + numeroFila + '][especie_id]">');
    $formulario.append('<input type="hidden" value="' + $div.find(".especie").val() + '" name="data[Especie][' + numeroFila + '][especie]">');
    $formulario.append('<input type="hidden" value="' + $div.find(".subespecie").val() + '" name="data[Especie][' + numeroFila + '][subespecie]">');
    $formulario.append('<input type="hidden" value="' + $div.find(".datosReproduccion").val() + '" name="data[Especie][' + numeroFila + '][clase_reproduccion_id]">');

    // Numero de aves
    $formulario.append('<input type="hidden" value="' + $div.find(".totalNumeroAves").val() + '" name="data[Especie][' + numeroFila + '][cantidad]">');
    $div.find(".numero_aves").each(function(){
        if($(this).val() != "0" && $(this).val() != "") {
            $formulario.append('<input type="hidden" value="' + $(this).val() + '" name="data[Especie][' + numeroFila + '][claseEdadSexo][]['+ $(this).attr('data-id') + ']" data-id="'+ $(this).attr('data-id') + '">');
        }
    });

    $formulario.append('<input type="hidden" value="' + ($indHabitatRaro ? 1 : 0) + '" name="data[Especie][' + numeroFila + '][indHabitatRaro]">');
    $formulario.append('<input type="hidden" value="' + ($indCriaHabitatRaro ? 1 : 0) + '" name="data[Especie][' + numeroFila + '][indCriaHabitatRaro]">');
    $formulario.append('<input type="hidden" value="' + ($indHerido ? 1 : 0) + '" name="data[Especie][' + numeroFila + '][indHerido]">');
    $formulario.append('<input type="hidden" value="' + ($indComportamiento ? 1 : 0) + '" name="data[Especie][' + numeroFila + '][indComportamiento]">');
    $formulario.append('<input type="hidden" value="' + $div.find(".observaciones").val() + '" name="data[Especie][' + numeroFila + '][observaciones]">');
}

/**
 * Elimina la fila indicada por el número recibido por parametro de la tabla de especies
 *
 * @param numeroFila
 */
function eliminarFilaEspecie(numeroFila)
{
    // Eliminamos la fila de la tabla
    $("#fila" + numeroFila).remove();

    // Eliminamos los hiddens relacionados
    $('input[name^="data[Especie][' + numeroFila + ']"]').remove();
}

/**
 * Genera los botones de acciones de cada fila de la tabla de especies
 *
 * @param numeroFila
 * @returns {string}
 */
function insertarBotonesFila(numeroFila)
{
    var columnaBotones = '';

    columnaBotones += '<td style="text-align: center">';
    columnaBotones += "<a href='javascript: eliminarFilaEspecie(" + numeroFila + ");' title='Eliminar especie'><img src='/img/icons/delete.png' alt='Eliminar especie'/></a>";
    columnaBotones += '&nbsp;&nbsp;';
    columnaBotones += "<a href='javascript: editarFilaEspecie(" + numeroFila + ");' title='Editar especie'><img src='/img/icons/edit.png' alt='Editar especie'/></a>";
    columnaBotones += '</td>';

    return columnaBotones;
}

/**
 * Ordena las filas de la tabla de especies
 *
 * @param tbody
 * @param col
 * @param asc
 */
function ordenarTablaEspecies(tbody, col, asc){

    var rows = tbody.rows,
        row,
        rlen = rows.length,
        arr = [],
        i,
        j,
        cells,
        clen;

    // fill the array with values from the table
    for (i = 0; i < rlen; i++) {
        cells = rows[i].cells;
        clen = cells.length;
        arr[i] = [];
        arr[i][0] = rows[i].getAttribute('id');
        for (j = 0; j < clen; j++) {
            arr[i][j + 1] = cells[j].innerHTML;
        }
    }

    // sort the array by the specified column number (col) and order (asc)
    col++;
    arr.sort(function(a, b){
        return (a[col] == b[col]) ? 0 : ((a[col] > b[col]) ? asc : -1*asc);
    });
    for(i = 0; i < rlen; i++){
        row = "<tr id='" + arr[i][0] + "'>";
        arr[i].shift();
        row += "<td>"+arr[i].join("</td><td>")+"</td>";
        row += "</tr>";
        arr[i] = row;
    }
    tbody.innerHTML = arr.join(" ");
}
