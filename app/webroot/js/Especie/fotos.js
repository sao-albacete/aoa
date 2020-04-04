$(document).ready(function () {

	var divFiltrarBusqueda = $('#divFiltrosBusqueda');
	var fotosCargadas = 0;
	var especieId;

	divFiltrarBusqueda.find("#especie").val("");
	divFiltrarBusqueda.find("#especieId").val("");

	// Ocultamos el botón de cargar más fotos al cargar la página
	$(".cargar-mas-fotos").hide()

	// Seleccionar especie
	divFiltrarBusqueda.find("#especie").autocomplete({
		source: function (request, response) {
			$.getJSON("/especie/buscar_especies", {
					term: request.term
				},
				response);
		},
		minLength: 3,
		select: function (event, ui) {
			this.value = ui.item.value;
			especieId = ui.item.id;

			// Si la especie seleccionada es diferente, vaciamos las fotos previamente cargadas
			if (especieId != $("#especieId").val()) {
				$(".yoxview").html("")
				// Ocultamos el botón de cargar más fotos al cargar la página
				$(".cargar-mas-fotos").hide()
				// Reiniciamos las fotos cargadas a cero
				fotosCargadas = 0;
			}

			// Guardamos el id de la especie seleccionada
			$("#especieId").val(especieId);

			// Obtenemos las fotos de la especie seleccionada
			$.getJSON("/especie/obtenerFotosPorEspecie", {
					especieId: especieId,
					offset: fotosCargadas
				},
				function (response) {
				console.log(response)
					// Si la especie seleccionada no tiene fotos, mostramos un mensaje informativo
					if (response.total == 0) {
						$(".yoxview").append(
							'<div class="thumbnail" style="width: 360px; height: 270px;">' +
							'<img src="/img/messages/AAAAAA&text=No+hay+fotos_360x270.gif"/>' +
							'</div>'
						)
					} else {
						$.each(response.fotos, function (i, item) {
							fotosCargadas++;
							insertarFoto(item);
						});
						activarYoxview();

						// Si todavía faltan fotos por cargar, entonces mostramos una opción para cargar más fotos
						if (parseInt(fotosCargadas) < parseInt(response.total)) {
							$(".cargar-mas-fotos").show()
						}
					}
				});
			return false;
		}
	});

	$(".cargar-mas-fotos").click(function () {

		// Obtenemos las fotos de la especie seleccionada
		$.getJSON("/especie/obtenerFotosPorEspecie", {
				especieId: especieId,
				offset: fotosCargadas
			},
			function (response) {

				$.each(response.fotos, function (i, item) {
					fotosCargadas++;
					insertarFoto(item);
				});
				activarYoxview();

				// Si todavía faltan fotos por cargar, entonces mostramos una opción para cargar más fotos
				if (parseInt(fotosCargadas) == parseInt(response.total)) {
					$(".cargar-mas-fotos").hide();
				}
			});
	});
});

function insertarFoto(item) {
	$(".yoxview")
		.append(
			'<li class="span3">' +
			'<div class="thumbnail text-center">' +
			'<a href="' + item.Fichero.ruta + item.Fichero.nombreFisico + '" class="thumbnail">' +
			'<img src="' + item.Fichero.ruta + item.Fichero.nombreFisico + '" alt="' + item.Especie.nombreComun + '" title="' + item.Especie.genero + " " + item.Especie.especie + " " + item.Especie.subespecie + '">' +
			'</a>' +
			'<h3>' + item.Especie.nombreComun + '</h3>' +
			'<p>Foto realizada por ' + item.ObservadorPrincipal.nombre + ' en ' + item.Municipio.nombre + ' el ' + item.Cita.fechaAlta + '</p>' +
			'</div>' +
			'</li>'
		);
}

function activarYoxview() {
	$(".yoxview").yoxview({
		"lang": "es",
		"autoHideMenu": false,
		"autoHideInfo": false,
		"showDescription": true,
		"renderInfoPin": false
	});
}
