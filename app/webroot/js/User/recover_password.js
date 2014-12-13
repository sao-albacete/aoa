/**
 * 
 */

$(document).ready(function() {

	/** INICIO Validación de formulario **/
	
	$('#recoverPasswordForm').validate({
	    rules: {
	      	UserEmail: {
	        	required: true,
	        	email: true
	      	}
	    },
	    messages: {
	    	UserEmail: {
		     	required: "El correo electrónico es obligatorio.",
		     	email: "Por favor, introduzca un correo electrónico con formato correcto."
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
});
