$(document).ready(function () {

	/* INICIO fotos */
	$(".yoxview").yoxview({
		"lang": "es",
		"autoHideMenu": false,
		"autoHideInfo": false,
		"showDescription": true,
		"renderInfoPin": false
	});
	/* FIN fotos */

	var divFiltrarBusqueda = $('#divFiltrosBusqueda');
	var fotosCargadas = 0;

	divFiltrarBusqueda.find("#especie").val("");
	divFiltrarBusqueda.find("#especieId").val("");

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
			var especieId = ui.item.id
			$("#especieId").val(especieId);
			$.getJSON("/especie/obtenerFotosPorEspecie", {
					especieId: especieId,
					offset: fotosCargadas
				},
				function (response) {
					$.each(response, function (i, item) {
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

						fotosCargadas++;
					});
				});
			return false;
		}
	});
});
