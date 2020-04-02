$(document).ready(function () {

	var divFiltrarBusqueda = $('#divFiltrosBusqueda');

	// Seleccionar especie
	divFiltrarBusqueda.find("#especie").autocomplete({
		source: function( request, response ) {
			$.getJSON( "/especie/buscar_especies", {
					term: request.term
				},
				response );
		},
		minLength: 3,
		select: function( event, ui ) {
			this.value = ui.item.value;
			$("#especieId").val(ui.item.id);
			return false;
		}
	});

	/* INICIO fotos */
	$(".yoxview").yoxview({
		"lang": "es",
		"autoHideMenu": false,
		"autoHideInfo": false,
		"showDescription": true,
		"renderInfoPin": false
	});
	/* FIN fotos */
});
