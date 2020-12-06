$(document).ready(function () {

	var $divNuevaCitaMultiple = $('#divNuevaCitaMultiple');

	/**
	 * CRITERIOS GENERALES
	 */

	// Seleccionar fecha
	seleccionarFecha($divNuevaCitaMultiple);

	// Seleccionar hora de alta
	seleccionarHora($divNuevaCitaMultiple);

	// Seleccionar lugar
	seleccionarLugar($divNuevaCitaMultiple);

	// Vaciar lugar
	$divNuevaCitaMultiple.find(".btnVaciarLugar").click(function () {
		vaciarLugarSeleccioando($divNuevaCitaMultiple)
	});

	// Nuevo lugar
	$divNuevaCitaMultiple.find(".btnNuevoLugar").click(function () {
		limpiarFormularioLugar();
		$('#modalNuevoLugar').modal();
	});

	// Seleccionar observador
	seleccionarObservador($divNuevaCitaMultiple);

	// Nuevo colaborador
	$divNuevaCitaMultiple.find(".btnNuevoColaborador").click(function () {
		limpiarNuevoColaborador();
		$('#divNuevoColaborador').modal();
	});

	// Seleccionar colaborador
	seleccionarColaboradores($divNuevaCitaMultiple);

	// Limpiar colaboradores seleccioandos
	$divNuevaCitaMultiple.find("#btnVaciarColaboradores").click(function () {
		limpiarColaboradores($divNuevaCitaMultiple);
	});

	// Popup ayuda
	// $divNuevaCitaMultiple.find('.badge-info').popover();

	// Insertar especie
	$divNuevaCitaMultiple.find("#btnInsertarEspecie").click(function () {
		limpiarFormularioEspecie();
		var horaAltaGeneral = $divNuevaCitaMultiple.find('#horaAltaGeneral') .val();
		var $modalNuevaEspecie = $('#modalNuevaEspecie');
		$modalNuevaEspecie.find('#horaAltaNuevaEspecie') .val(horaAltaGeneral);
		$modalNuevaEspecie.modal();

		$modalNuevaEspecie.on('shown', function () {
			$modalNuevaEspecie.find('.modal-body').scrollTop(0);
		});
	});

	/* INICIO Validación de formulario */
	jQuery.validator.addMethod("isdate", function (value, element) {
		var validDate = /^(\d{2})\/(\d{2})\/(\d{4})?$/;
		return validDate.test(value)
	});
	jQuery.validator.addMethod("validarEspecie", function (value, element) {
		return $divNuevaCitaMultiple.find("input[name$='[especie_id]']").length > 0;
	}, "Debe insertar al menos una especie.");

	jQuery.validator.addMethod("validarLugar", function (value, element) {
		return $("#lugarId").val() != "";
	}, "Debe seleccionar un lugar.");

	jQuery.validator.addMethod("validarObservador", function (value, element) {
		return $("#observadoresSeleccionados").val() != "";
	}, "Debe seleccionar al menos un observador.");

	jQuery.validator.addMethod("dateBeforeOrEqualToday", function (value, element) {

		var fechaAlta = $.datepicker.parseDate("dd/mm/yy", value);
		var now = new Date();

		return (fechaAlta < now || fechaAlta == now);
	}, "Debe introducir una fecha de alta anterior o igual a la fecha de hoy.");

	$divNuevaCitaMultiple.find('#frmNuevaCitaMultiple').validate({
		rules: {
			"data[Cita][fechaAlta]": {
				required: true,
				date: false,
				isdate: true,
				dateBeforeOrEqualToday: true
			},
			"data[Cita][horaAlta]": {
				required: true
			},
			lugar: {
				validarLugar: true
			},
			observadores: {
				validarObservador: true
			},
			hdnEspecies: {
				validarEspecie: true
			}
		},
		messages: {
			"data[Cita][fechaAlta]": {
				required: "Debe seleccionar una fecha de alta.",
				date: "Debe introducir una fecha de alta con formato correcto (dd/mm/aaaa)."
			},
			"data[Cita][horaAlta]": {
				required: "Debe seleccionar una hora de observación."
			},
		},
		ignore: [],
		errorContainer: "#errorMessages",
		errorLabelContainer: "#errorMessages ul",
		wrapper: "li",
		invalidHandler: function (event, validator) {
			$('html, body').animate({scrollTop: 0}, 'slow');
		},
		onfocusout: false
	});
	/* FIN Validación de formulario */

	/* INICIO guardar */
	$divNuevaCitaMultiple.find("#btnGuardar").click(function () {

		if ($divNuevaCitaMultiple.find('#frmNuevaCitaMultiple').valid()) {

			var especies = [],
				lugarId = $("#lugarId").val(),
				fechaAlta = $("#fechaAlta").val(),
				items = [];

			$divNuevaCitaMultiple.find("input[name$='[especie_id]']").each(function () {
				if ($(this).val() !== '') {
					especies.push($(this).val());
				}
			});
			especies = especies.join(',');

			$.ajax({
				url: "/cita/existenCitas",
				data: {"especies": especies, "lugarId": lugarId, "fechaAlta": fechaAlta},
				dataType: "json",
				success: function (response) {

					if (response.status === 0 && response.citasSimilares === false) {
						items = [];
						items.push("<h5>");
						items.push("<img src='/img/icons/fugue-icons-3.5.6/icons/exclamation-red.png' width='34' height='28' alt='alert icon' style='margin-right: 20px;'>");
						items.push("Ya has creado previamente alguna cita para la misma fecha y lugar de alguna de las especies introducidas.");
						items.push("</h5>");

						bootbox.alert(items.join(""), "Aceptar");
					} else if (response.status == 0 && response.citasSimilares.length > 0) {

						items.push("<p>Ya existen citas en <b>" + response.citasSimilares[0].Lugar.nombre + "</b> del día <b>" + response.citasSimilares[0].Cita.fechaAlta + "</b> de:</p>");
						items.push("<br>");
						items.push("<table class='table table-striped table-bordered table-condensed'>");
						items.push("<tr><th>Especie</th><th>Observador</th><th>Número individuos</th></tr>");
						for (var i = 0; i < response.citasSimilares.length; i++) {
							var citaSimilar = response.citasSimilares[i];
							items.push("<tr><td>" + citaSimilar.Especie.nombreComun + "</td><td>" + citaSimilar.ObservadorPrincipal.codigo + ' - ' + citaSimilar.ObservadorPrincipal.nombre + "</td><td>" + citaSimilar.Cita.cantidad + "</td></tr>");
						}
						items.push("</table>");
						items.push("<br>");
						items.push("<p>¿Estás seguro de que deseas crear estas nuevas citas?</p>");

						bootbox.confirm(items.join(""), "Cancelar", "Aceptar", function (result) {
							if (result) {
								validarRarezaCitaMultiple(especies);
							}
						});
					} else {
						validarRarezaCitaMultiple(especies);
					}
				}
			});
		}
	});
	/* FIN guardar */

	var richTextEditorSettings = {
		toolbar: [
			['style', ['style']],
			['font', ['bold', 'underline', 'clear']],
			// ['fontname', ['fontname']],
			['color', ['color']],
			['para', ['ul', 'ol'/*, 'paragraph'*/]],
			// ['table', ['table']],
			['insert', ['link'/*, 'picture'*/]],
			// ['view', ['fullscreen', 'codeview']],
		],
		lang: 'es-ES', // default: 'en-US'
		dialogsInBody: false,
		dialogsFade: true  // Add fade effect on dialogs
	};

	/***********************/
	/* Editar file especie */
	/***********************/
	var $divEditarEspecie = $('#modalEditarEspecie');

	// Seleccionar especie
	seleccionarEspecie($divEditarEspecie);

	// Limpiar especie
	$divEditarEspecie.find(".btnVaciarEspecie").click(function () {
		limpiarEspecie($divEditarEspecie);
	});

	// Seleccionar subespecie
	seleccionarSubespecie($divEditarEspecie);

	// Gestioanr tabla de clases de edad/sexo
	gestionarTablaNumeroAves($divEditarEspecie);

	// Seleccionar hora de alta
	seleccionarHora($divEditarEspecie);

	// Resaltar checks seleccioandos
	marcarChecksSeleccioandos($divEditarEspecie);

	$divEditarEspecie.find('.btn-aceptar-editar-especie').click(function () {
		validarFormularioEspecie($divEditarEspecie, $divEditarEspecie.find('.frmEditarEspecie'),
			'errorMessagesEditarEspecie', $(this).attr('data-fila'));
	});

	// Popup ayuda
	// $divEditarEspecie.find('.badge-info').popover();

	// Rich editor para las observaciones
	$divEditarEspecie.find('.observaciones').summernote(richTextEditorSettings);
	$divEditarEspecie.find('.note-modal').remove();

	/*****************/
	/* Nueva especie */
	/*****************/
	var $divNuevaEspecie = $('#modalNuevaEspecie');

	// Seleccionar especie
	seleccionarEspecie($divNuevaEspecie);

	// Limpiar especie
	$divNuevaEspecie.find(".btnVaciarEspecie").click(function () {
		limpiarEspecie($divNuevaEspecie);
	});

	// Seleccionar subespecie
	seleccionarSubespecie($divNuevaEspecie);

	// Gestioanr tabla de clases de edad/sexo
	gestionarTablaNumeroAves($divNuevaEspecie);

	// Seleccionar hora de alta
	seleccionarHora($divNuevaEspecie);

	// Resaltar checks seleccioandos
	marcarChecksSeleccioandos($divNuevaEspecie);

	$divNuevaEspecie.find('.btn-aceptar-nueva-especie').click(function () {
		validarFormularioEspecie($divNuevaEspecie, $divNuevaEspecie.find('.frmNuevaEspecie'),
			'errorMessagesNuevaEspecie');
	});

	// Popup ayuda
	$divNuevaEspecie.find('.badge-info').popover();

	// Rich editor para las observaciones
	$divNuevaEspecie.find('.observaciones').summernote(richTextEditorSettings);
	$divNuevaEspecie.find('.note-modal').remove()
});

function validarRarezaCitaMultiple(especies) {
	var items = [];

	$.ajax({
		url: "/especie/sonRarezas",
		data: {"especies": especies},
		success: function (indEsRareza) {

			if (indEsRareza == 1) {
				items = [];
				items.push("<h5>");
				items.push("<img src='/img/icons/fugue-icons-3.5.6/icons/exclamation.png' width='34' height='28' alt='alert icon' style='margin-right: 20px;'>");
				items.push("Alguna de las especies que has introducido es una <b>RAREZA NACIONAL</b>.");
				items.push("</h5>");
				items.push("<br>");
				items.push("Para homologar esta cita debes seguir ");
				items.push("<a href='https://www.seo.org/wp-content/uploads/2016/03/Ficha_Rarezas_CRSEO.pdf' target='_blank'>estas instrucciones</a>.");

				bootbox.confirm(items.join(""), "Cancelar", "Continuar", function (result) {
					if (result) {
						$("#frmNuevaCitaMultiple").submit();
					}
				});
			} else if (indEsRareza == 2) {
				items = [];
				items.push("<h5>");
				items.push("<img src='/img/icons/fugue-icons-3.5.6/icons/exclamation.png' width='34' height='28' alt='alert icon' style='margin-right: 20px;'>");
				items.push("Alguna de las especies que has introducido es una <b>RAREZA LOCAL</b>.");
				items.push("</h5>");
				items.push("<br>");
				items.push("Debido a la importancia de la cita, por favor, <b>envíanos un correo electrónico a ");
				items.push("<a href='mailto:anuario@sao.albacete.org' target='_blank'>anuario@sao.albacete.org</a></b>, ");
				items.push("describíendo con detalle el avistamiento y ampliando toda la información posible.");
				items.push("<br>");
				items.push("<b>Es importante que adjuntes fotografías</b> aunque sean de mala calidad para apoyar la identificación de la especie.");

				bootbox.confirm(items.join(""), "Cancelar", "Continuar", function (result) {
					if (result) {
						$("#frmNuevaCitaMultiple").submit();
					}
				});
			} else {
				$("#frmNuevaCitaMultiple").submit();
			}
		}
	});
}

/**
 * Valida los datos introducidos en el formulario de especie y si son correctos,
 * añade una nueva fila, si no, muestra los errores de validación
 */
function validarFormularioEspecie($div, $formulario, errorContainer, numeroFila) {
	jQuery.validator.addMethod("validarEspeciePopup", function (value, element) {
		return $div.find(".especieId").val() != "";
	}, "Debe seleccionar una especie.");

	jQuery.validator.addMethod("validarNumeroAves", function (value, element) {
		var total_numero_aves = 0;
		$div.find(".numero_aves").each(function () {
			total_numero_aves += parseInt($(this).val());
		});
		return total_numero_aves > 0;
	}, "El número de aves debe ser mayor que cero.");

	$formulario.validate({
		rules: {
			especie: {
				validarEspeciePopup: true
			},
			"data[Cita][horaAlta]": {
				required: true
			},
			"data[claseEdadSexo][][4]": {
				validarNumeroAves: true
			},
			"data[Cita][clase_reproduccion_id]": {
				required: true
			}
		},
		messages: {
			"data[Cita][clase_reproduccion_id]": {
				required: "Debe seleccionar un dato de reproducción."
			},
			"data[Cita][horaAlta]": {
				required: "Debe seleccionar una hora de observación."
			},
		},
		errorContainer: "#" + errorContainer,
		errorLabelContainer: "#" + errorContainer + " ul",
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
function insertarFilaEspecie($div, fila) {
	let $tablaEspecies = $('#tablaEspecies'),
		$indHabitatRaro = $div.find(".indHabitatRaro").is(":checked"),
		$indCriaHabitatRaro = $div.find(".indCriaHabitatRaro").is(":checked"),
		$indHerido = $div.find(".indHerido").is(":checked"),
		$indComportamiento = $div.find(".indComportamiento").is(":checked"),
		$dormidero = $div.find(".dormidero").is(":checked"),
		$coloniaDeCria = $div.find(".colonia_de_cria").is(":checked"),
		$migracionActiva = $div.find(".migracion_activa").is(":checked"),
		$sedimentado = $div.find(".sedimentado").is(":checked"),
		$electrocutado = $div.find(".electrocutado").is(":checked"),
		$atropellado = $div.find(".atropellado").is(":checked"),
		numeroFila = fila ? fila : $tablaEspecies.find('tbody tr').length,
		$precision = $div.find('input:radio[name="data[Especie][precision]"]:checked').val(),
		$formulario = $('#frmNuevaCitaMultiple');

	$precisionTexto = "";
	if ($precision == "cantidad_exacta") {
		$precisionTexto = "Número exacto";
	} else if ($precision == "cantidad_precisa") {
		$precisionTexto = "Conteo preciso";
	} else if ($precision == "cantidad_estimada") {
		$precisionTexto = "Estima";
	} else if ($precision == "cantidad_aproximada") {
		$precisionTexto = "Número aproximado";
	}

	// Insertar fila en la tabla de especies
	let content = "";
	content += '<tr id="fila' + numeroFila + '">';
	content += '<td>' + $div.find(".especie").val() + ' ' + $div.find(".subespecie").val() + '</td>';
	content += "<td style=\"text-align: center;\">" + $div.find(".totalNumeroAves").val() + " (" + $precisionTexto + ")" + '</td>';
	content += "<td style=\"text-align: center;\">" + $div.find(".hora-alta").val() + '</td>';
	content += insertarBotonesFila(numeroFila);
	content += '</tr>';
	$tablaEspecies.find('tbody').append(content);

	// Insertar hiddens en el formulario de envio
	$formulario.append('<input type="hidden" value="' + $div.find(".especieId").val() + '" name="data[Especie][' + numeroFila + '][especie_id]">');
	$formulario.append('<input type="hidden" value="' + $div.find(".especie").val() + '" name="data[Especie][' + numeroFila + '][especie]">');
	$formulario.append('<input type="hidden" value="' + $div.find(".subespecie").val() + '" name="data[Especie][' + numeroFila + '][subespecie]">');
	$formulario.append('<input type="hidden" value="' + $div.find(".hora-alta").val() + '" name="data[Especie][' + numeroFila + '][horaAlta]">');
	$formulario.append('<input type="hidden" value="' + $div.find(".datosReproduccion").val() + '" name="data[Especie][' + numeroFila + '][clase_reproduccion_id]">');

	// Numero de aves
	if ($formulario.find("input[name=\"data[Especie][" + numeroFila + "][precision]\"]").length == 0) {
		$formulario.append('<input type="hidden" value="' + $precision + '" name="data[Especie][' + numeroFila + '][precision]">');
	}
	$formulario.find("input[name=\"data[Especie][" + numeroFila + "][precision]\"]").val($div.find('input:radio[name="data[Especie][precision]"]:checked').val())
	$formulario.append('<input type="hidden" value="' + $div.find(".totalNumeroAves").val() + '" name="data[Especie][' + numeroFila + '][cantidad]">');
	$div.find(".numero_aves").each(function () {
		if ($(this).val() != "0" && $(this).val() != "") {
			$formulario.append('<input type="hidden" value="' + $(this).val() + '" name="data[Especie][' + numeroFila + '][claseEdadSexo][][' + $(this).attr('data-id') + ']" data-id="' + $(this).attr('data-id') + '">');
		}
	});

	$formulario.append('<input type="hidden" value="' + ($indHabitatRaro ? 1 : 0) + '" name="data[Especie][' + numeroFila + '][indHabitatRaro]">');
	$formulario.append('<input type="hidden" value="' + ($indCriaHabitatRaro ? 1 : 0) + '" name="data[Especie][' + numeroFila + '][indCriaHabitatRaro]">');
	$formulario.append('<input type="hidden" value="' + ($indHerido ? 1 : 0) + '" name="data[Especie][' + numeroFila + '][indHerido]">');
	$formulario.append('<input type="hidden" value="' + ($indComportamiento ? 1 : 0) + '" name="data[Especie][' + numeroFila + '][indComportamiento]">');
	$formulario.append('<input type="hidden" value="' + ($dormidero ? 1 : 0) + '" name="data[Especie][' + numeroFila + '][dormidero]">');
	$formulario.append('<input type="hidden" value="' + ($coloniaDeCria ? 1 : 0) + '" name="data[Especie][' + numeroFila + '][colonia_de_cria]">');
	$formulario.append('<input type="hidden" value="' + ($migracionActiva ? 1 : 0) + '" name="data[Especie][' + numeroFila + '][migracion_activa]">');
	$formulario.append('<input type="hidden" value="' + ($sedimentado ? 1 : 0) + '" name="data[Especie][' + numeroFila + '][sedimentado]">');
	$formulario.append('<input type="hidden" value="' + ($electrocutado ? 1 : 0) + '" name="data[Especie][' + numeroFila + '][electrocutado]">');
	$formulario.append('<input type="hidden" value="' + ($atropellado ? 1 : 0) + '" name="data[Especie][' + numeroFila + '][atropellado]">');

	// Observaciones
	let $observaciones = "";
	if (!$div.find('.observaciones').summernote('isEmpty')) {
		$observaciones = $div.find(".observaciones").val();
	}

	$formulario.append('<input type="hidden" value="' + $observaciones + '" name="data[Especie][' + numeroFila + '][observaciones]">');
}

/**
 * Elimina la fila indicada por el número recibido por parametro de la tabla de especies
 *
 * @param numeroFila
 */
function eliminarFilaEspecie(numeroFila) {
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
function insertarBotonesFila(numeroFila) {
	var columnaBotones = '';

	columnaBotones += '<td style="text-align: center;">';
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
function ordenarTablaEspecies(tbody, col, asc) {

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
	arr.sort(function (a, b) {
		return (a[col] == b[col]) ? 0 : ((a[col] > b[col]) ? asc : -1 * asc);
	});
	for (i = 0; i < rlen; i++) {
		row = "<tr id='" + arr[i][0] + "'>";
		arr[i].shift();
		row += "<td>" + arr[i].join("</td><td>") + "</td>";
		row += "</tr>";
		arr[i] = row;
	}
	tbody.innerHTML = arr.join(" ");
}

/**
 * Muestra el popup de edición de especie cargando los datos rellenados hasta el momento
 * @param numeroFila
 */
function editarFilaEspecie(numeroFila) {
	$div = $('#modalEditarEspecie');

	$div.find('.especieId').val($('input[name="data[Especie][' + numeroFila + '][especie_id]"]').val());
	$div.find('.especie').val($('input[name="data[Especie][' + numeroFila + '][especie]"]').val());
	$div.find('.hora-alta').val($('input[name="data[Especie][' + numeroFila + '][horaAlta]"]').val());
	$div.find(".especieSeleccionadaContenedor").show();
	$div.find(".especieSeleccionada").text($div.find('.especie').val());

	$div.find('.subespecie').val($('input[name="data[Especie][' + numeroFila + '][subespecie]"]').val());
	$div.find('.subespecie').attr('disabled', false);
	$div.find(".subespecieSeleccionadaContenedor").show();
	$div.find(".subespecieSeleccionada").text($div.find('.subespecie').val());

	$div.find('.datosReproduccion').val($('input[name="data[Especie][' + numeroFila + '][clase_reproduccion_id]"]').val());

	$div.find("input[name='data[Especie][precision]']").val([$('input[name="data[Especie][' + numeroFila + '][precision]"]').val()])

	$div.find('.totalNumeroAves').val($('input[name="data[Especie][' + numeroFila + '][cantidad]"]').val());
	$div.find(".numeroTotalAvesDiv").show();
	$div.find(".numeroTotalAvesTexto").text($div.find('.totalNumeroAves').val());

	$div.find('.numero_aves').each(function () {
		$(this).val(0);
	});
	$('input[name^="data[Especie][' + numeroFila + '][claseEdadSexo]"]').each(function () {
		$div.find('input[data-id="' + $(this).attr('data-id') + '"]').val($(this).val());
	});

	$div.find('.indHabitatRaro').prop('checked', ($('input[name="data[Especie][' + numeroFila + '][indHabitatRaro]"]').val() != "0"));
	$div.find('.indCriaHabitatRaro').prop('checked', $('input[name="data[Especie][' + numeroFila + '][indCriaHabitatRaro]"]').val() != "0");
	$div.find('.indHerido').prop('checked', $('input[name="data[Especie][' + numeroFila + '][indHerido]"]').val() != "0");
	$div.find('.indComportamiento').prop('checked', $('input[name="data[Especie][' + numeroFila + '][indComportamiento]"]').val() != "0");
	$div.find('.dormidero').prop('checked', $('input[name="data[Especie][' + numeroFila + '][dormidero]"]').val() != "0");
	$div.find('.colonia_de_cria').prop('checked', $('input[name="data[Especie][' + numeroFila + '][colonia_de_cria]"]').val() != "0");
	$div.find('.migracion_activa').prop('checked', $('input[name="data[Especie][' + numeroFila + '][migracion_activa]"]').val() != "0");
	$div.find('.sedimentado').prop('checked', $('input[name="data[Especie][' + numeroFila + '][sedimentado]"]').val() != "0");
	$div.find('.electrocutado').prop('checked', $('input[name="data[Especie][' + numeroFila + '][electrocutado]"]').val() != "0");
	$div.find('.atropellado').prop('checked', $('input[name="data[Especie][' + numeroFila + '][atropellado]"]').val() != "0");

	$div.find('.observaciones').val($('input[name="data[Especie][' + numeroFila + '][observaciones]"]').val());
	$div.find('.observaciones').summernote("code", $div.find('.observaciones').val());

	// Resaltar los checks seleccioandos
	$div.find("input[type=checkbox]").each(function () {
		if ($(this).is(":checked")) {
			$(this).parent().addClass("text-success");
			$(this).parent().css("font-weight", "bold");
		} else {
			$(this).parent().removeClass("text-success");
			$(this).parent().css("font-weight", "normal");
		}
	});

	// Añadimos el numero de fila al botón aceptar
	$div.find('.btn-aceptar-editar-especie').attr('data-fila', numeroFila);

	$div.modal();
}

/**
 * Limpia el formulario de especie
 */
function limpiarFormularioEspecie() {
	var $divNuevaEspecie = $('#modalNuevaEspecie');

	limpiarEspecie($divNuevaEspecie);

	$divNuevaEspecie.find("input[type=checkbox]").each(function () {
		$(this).prop('checked', false);
		$(this).parent().removeClass("text-success");
		$(this).parent().css("font-weight", "normal");
	});

	$divNuevaEspecie.find(".numero_aves").each(function () {
		$(this).val(0);
	});

	$divNuevaEspecie.find('.observaciones').val('');
	$divNuevaEspecie.find('.observaciones').summernote('reset');
	$divNuevaEspecie.find('.note-modal').remove();

	$divNuevaEspecie.find('.datosReproduccion').val(11);

	$divNuevaEspecie.find(".totalNumeroAves").val(0);

	$divNuevaEspecie.find(".numeroTotalAvesDiv").hide();
	$divNuevaEspecie.find(".numeroTotalAvesTexto").text(0);
}
