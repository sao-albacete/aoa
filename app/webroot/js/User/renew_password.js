/**
 * 
 */

$(document).ready(function() {

	/** INICIO Validación de formulario **/
	
	$('#renewPasswordForm').validate({
	    rules: {
	      	"data[User][password]": {
	        	required: true,
	        	rangelength: [8, 40]
	      	},
	      	"data[User][password_confirmation]": {
	        	required: true,
	        	equalTo: "#UserPassword"
	      	}
	    },
	    messages: {
	     	"data[User][password]" : {
		     	required: "La contraseña es obligatoria.",
		     	rangelength: "La contraseña debe contener un mínimo de 8 caracteres y un máximo de 40."
	     	},
	     	"data[User][password_confirmation]" : {
		     	required: "Por favor, confirme la contraseña introducida.",
		     	equalTo: "Las contraseñas no coinciden."
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
