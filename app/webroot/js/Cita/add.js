/**
 * Funciones necesarias para el funcionamiento del alta simple de citas
 */
$(document).ready(function () {

	var divNuevaCita = $('#divNuevaCita'),
		formNuevaCita = divNuevaCita.find('#frmNuevaCita');

	// Seleccionar especie
	seleccionarEspecie(divNuevaCita);

	// Limpiar especie
	divNuevaCita.find(".btnVaciarEspecie").click(function () {
		limpiarEspecie(divNuevaCita);
	});

	// Seleccionar subespecie
	seleccionarSubespecie(divNuevaCita);

	// Seleccionar fecha de alta
	seleccionarFecha(divNuevaCita);

	// Seleccionar hora de alta
	seleccionarHora(divNuevaCita);

	// Gestionar tabla de clases de edad/sexo
	gestionarTablaNumeroAves(divNuevaCita);

	// Seleccionar lugar
	seleccionarLugar(divNuevaCita);

  // Seleccionar en mapa
  divNuevaCita.find("#btnSeleccionarLugarMapa").click(function () {
    limpiarFormularioLugar();
    $('#modalSeleccionarLugarMapa').modal();
  });

	// Vaciar lugar
	divNuevaCita.find(".btnVaciarLugar").click(function () {
		vaciarLugarSeleccioando(divNuevaCita)
	});

	// Nuevo lugar
	divNuevaCita.find(".btnNuevoLugar").click(function () {
		limpiarFormularioLugar();
		$('#modalNuevoLugar').modal();
	});



	// Seleccionar observador
	seleccionarObservador(divNuevaCita);

	// Nuevo colaborador
	divNuevaCita.find(".btnNuevoColaborador").click(function () {
		limpiarNuevoColaborador();
		$('#divNuevoColaborador').modal();
	});

	// Seleccionar colaborador
	seleccionarColaboradores(divNuevaCita);

	// Limpiar colaboradores seleccioandos
	divNuevaCita.find("#btnVaciarColaboradores").click(function () {
		limpiarColaboradores(divNuevaCita);
	});

	// Popup ayuda
	divNuevaCita.find('.badge-info').popover();

	// Resaltar checks seleccioandos
	marcarChecksSeleccioandos(divNuevaCita);

	// Configurar validación formulario cita
	validarCita(formNuevaCita, 'errorMessagesGrafico');

	// Rich editor para las observaciones
	divNuevaCita.find('#observaciones').summernote({
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
	});
	divNuevaCita.find('.note-modal').remove();

	// Guardar cita
	divNuevaCita.find("#btnGuardar").click(function () {

		if (formNuevaCita.valid()) {
			guardarCitaSimple(divNuevaCita, formNuevaCita);
		}
	});
});
