/**
 * 
 */

$(document).ready(function() {

	/** INICIO Validación de formulario **/
	
	jQuery.validator.addMethod("validarConfirmacionNuevaPassword", function(value, element) {
		var nuevaPassword = $("#UserNewPassword").val();
		if(nuevaPassword != null && nuevaPassword.length > 0) {
			return nuevaPassword == $("#UserPasswordConfirmation").val();
		}
	    return true;
	}, "Las nuevas contraseñas no coinciden.");
	
	$('#UserEditForm').validate({
	    rules: {
	      	"data[User][username]": {
	        	required: true,
	        	minlength: 10,
	        	maxlength: 250
	      	},
	      	"data[User][email]": {
	        	required: true,
	        	email: true
	      	},
	      	"data[User][password]": {
	        	required: true,
	        	rangelength: [8, 40]
	      	},
	      	"data[User][new_password]": {
	      		rangelength: [8, 40]
	      	},
	      	"data[User][password_confirmation]": {
	      		validarConfirmacionNuevaPassword: true
	      	},
	     	imagen : {
		     	extension: "jpg|jpeg|png"
	     	}
	    },
	    messages: {
	    	"data[User][username]": {
	        	required: "El nombre completo es obligatorio.",
	        	minlength: "Por favor, introduzca su nombre completo.",
	        	maxlength: "El nombre completo no puede ser mayor que 250 caracteres."
	      	},
	      	"data[User][email]" : {
		     	required: "El correo electrónico es obligatorio.",
		     	email: "Por favor, introduzca un correo electrónico con formato correcto."
	     	},
	     	"data[User][password]" : {
		     	required: "La contraseña es obligatoria.",
		     	rangelength: "La contraseña debe contener un mínimo de 8 caracteres y un máximo de 40."
	     	},
	     	"data[User][new_password]" : {
		     	rangelength: "La nueva contraseña debe contener un mínimo de 8 caracteres y un máximo de 40."
	     	},
	     	imagen : {
		     	extension: "La imagen debe tener alguna de las siguientes extensiones: jpg, jpeg, png"
	     	}
	    },
		errorContainer: "#errorMessagesGrafico",
		errorLabelContainer : "#errorMessagesGrafico ul",
		wrapper: "li",
		invalidHandler: function(event, validator) {
			$('html, body').animate({ scrollTop: 0 }, 'slow');
		},
		onfocusout: false
	});
	/** FIN Validación de formulario * */

	/** INICIO popup ayuda * */
	$('.badge-info').popover();
	/** FIN popup ayuda * */
});
