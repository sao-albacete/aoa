$(document).ready(function() {

    var divFiltrarBusqueda = $('#divFiltrosBusqueda');

    // Seleccionar observador
    seleccionarObservador(divFiltrarBusqueda);

    // Seleccionar colaborador
    seleccionarColaborador(divFiltrarBusqueda);

    // Seleccionar lugar
    seleccionarLugarPorNombre(divFiltrarBusqueda);
});