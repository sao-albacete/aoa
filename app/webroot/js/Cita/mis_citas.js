
function eliminarCita(idCita, nombreEspecie) {

	var msg = "¿Está seguro de que desea eliminar la cita de <b>" + nombreEspecie + "</b>?";
	
	bootbox.confirm(msg, "Cancelar", "Aceptar", function(result) {
		if(result == true) {
			myApp.showPleaseWait();
			window.location = "/cita/delete/id:" + idCita;
			return true;
		}
	});
}