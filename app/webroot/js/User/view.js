function bajaUsuario(idUsuario) {

	var msg = "¿Está seguro de que desea darse de baja del anuario?";
	
	bootbox.confirm(msg, "Cancelar", "Aceptar", function(result) {
		if(result == true) {
			$("#divBajaUsuario").modal("show");
		}
	});
}