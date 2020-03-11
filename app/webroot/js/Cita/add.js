/**
 * Funciones necesarias para el funcionamiento del alta simple de citas
 */
$(document).ready(function() {

    var divNuevaCita = $('#divNuevaCita'),
        formNuevaCita = divNuevaCita.find('#frmNuevaCita');

    // Seleccionar especie
    seleccionarEspecie(divNuevaCita);

    // Limpiar especie
    divNuevaCita.find(".btnVaciarEspecie").click(function() {
        limpiarEspecie(divNuevaCita);
    });

    // Seleccionar subespecie
    seleccionarSubespecie(divNuevaCita);

    // Seleccioanr fecha de alta
    seleccionarFecha(divNuevaCita);

	// Seleccioanr hora de alta
    seleccionarHora(divNuevaCita);

    // Gestionar tabla de clases de edad/sexo
    gestionarTablaNumeroAves(divNuevaCita);

    // Seleccionar lugar
    seleccionarLugar(divNuevaCita);

    // Vaciar lugar
    divNuevaCita.find(".btnVaciarLugar").click(function() {
        vaciarLugarSeleccioando(divNuevaCita)
    });

    // Nuevo lugar
    divNuevaCita.find(".btnNuevoLugar").click(function() {
        limpiarFormularioLugar();
        $('#modalNuevoLugar').modal();
    });

    // Seleccionar observador
    seleccionarObservador(divNuevaCita);

    // Nuevo colaborador
    divNuevaCita.find(".btnNuevoColaborador").click(function() {
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


    // Guardar cita
    divNuevaCita.find("#btnGuardar").click(function(){

        if (formNuevaCita.valid()) {
            guardarCitaSimple(divNuevaCita, formNuevaCita);
        }
    });
});
