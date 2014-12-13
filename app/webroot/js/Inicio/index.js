jQuery.fn.dataTableExt.oSort['date-uk-pre']  = function(a,b) {
	var dateString = a.substr(a.length-14, 10);
	var ukDatea = dateString.split('/');
    return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
};

jQuery.fn.dataTableExt.oSort['date-uk-asc']  = function(a,b) {
	return ((a < b) ? -1 : ((a > b) ? 1 : 0));
};

jQuery.fn.dataTableExt.oSort['date-uk-desc'] = function(a,b) {
	return ((a < b) ? 1 : ((a > b) ? -1 : 0));
};

$(document).ready(function(){
	
	/* INICIO fotos */
	$(".yoxview").yoxview({
		"lang" : "es",
		"autoHideMenu" : false,
		"autoHideInfo" : false,
		"showDescription" : true,
		"renderInfoPin" : false
	});
	/* FIN fotos */

});