/**
 * 
 */

$(document).ready(function() {

	/** INICIO Validación de formulario **/
	
	$('#UserAddForm').validate({
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
	      	"data[User][password_confirmation]": {
	        	required: true,
	        	equalTo: "#UserPassword"
	      	},
	      	chkAceptarTerminos: {
	      		required: true
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
	     	"data[User][password_confirmation]" : {
		     	required: "Por favor, confirme la contraseña introducida.",
		     	equalTo: "Las contraseñas no coinciden."
	     	},
	      	chkAceptarTerminos: {
	      		required: "Debe aceptar los términos y condiciones de uso para poder registrarse en el anuario."
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
	
	/* INICIO guardar */
	$("#btnRegistrar").click(function(){
		if ($('#UserAddForm').valid()) {
			$("#UserAddForm").submit();
        } 
	});
	/* FIN guardar */

	/** INICIO popup ayuda * */
	$('.badge-info').popover();
	/** FIN popup ayuda * */
});
