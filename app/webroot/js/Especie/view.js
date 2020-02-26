/**
 * Logica relacionada con la vista de detalle de una especie
 */

function actualizarZonaGeografica() {
    
    if($('#zonaGeografica').val() == "provincia") {
        $('#municipios').hide();
        $('#lugares').hide();
        $('#cuadriculas_utm').hide();
    }
    else if($('#zonaGeografica').val() == "municipio") {
        $('#municipios').show();
        $('#lugares').hide();
        $('#cuadriculas_utm').hide();
    }
    else if($('#zonaGeografica').val() == "lugar") {
        $('#municipios').hide();
        $('#lugares').show();
        $('#cuadriculas_utm').hide();
    }
    else if($('#zonaGeografica').val() == "cuadriculaUtm") {
        $('#municipios').hide();
        $('#lugares').hide();
        $('#cuadriculas_utm').show();
    }
}

function actualizarPeriodo() {
    
    if($('#periodo').val() == "anio") {
        $('#anio').show();
        $('#intervaloAnios').hide();
        $('#intervaloFechas').hide();
    }
    else if($('#periodo').val() == "anios") {
        $('#anio').hide();
        $('#intervaloAnios').css("display", "inline");
        $('#intervaloFechas').hide();
    }
    else if($('#periodo').val() == "fechas") {
        $('#anio').hide();
        $('#intervaloAnios').hide();
        $('#intervaloFechas').css("display", "inline");
    }
}

/* INICIO Ordenaciones especiales */
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
/* FIN Ordenaciones especiales */

/* INICIO mapa  */
var map;
var parser;
var parserDocumentUtm;
var parserDocumentMunicipios;

function initialize() {

    var myLatlng = new google.maps.LatLng(38.70, -1.80);

    var mapOptions = {
        zoom:8,
        center: myLatlng,
        overviewMapControl: false,
        panControl: true,
        rotateControl: false,
        scaleControl: true,
        scrollwheel: true,
        streetViewControl: false,
        zoomControl: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("mapa"),
        mapOptions);
    
    // GeoXML para añadir eventos
    parser = new geoXML3.parser({
        map: map,
        singleInfoWindow: true,
        zoom: false,
        afterParse: hideDocuments
    });
    
    // Tratamos el archivo
    parser.parse(['/kml/UTM_AB.kml', '/kml/municipios_AB.kml']);
}

google.maps.event.addDomListener(window, 'load', initialize);

var highlightTransparent = {fillColor: "#ffffff", strokeColor: "#000000", fillOpacity: 0, strokeWidth: 0};

var highlightDefault = {fillColor: "#424242", strokeColor: "#000000", fillOpacity: 0.5, strokeWidth: 10};

var highlightEscasa = {fillColor: "#E64545", strokeColor: "#000000", fillOpacity: 0.5, strokeWidth: 10};
var highlightComun = {fillColor: "#FFDB4D", strokeColor: "#000000", fillOpacity: 0.7, strokeWidth: 10};
var highlightMuyComun = {fillColor: "#338533", strokeColor: "#000000", fillOpacity: 0.9, strokeWidth: 10};

var highlightDesconocido = {fillColor: "#999999", strokeColor: "#000000", fillOpacity: 0.9, strokeWidth: 10};
var highlightNoCria = {fillColor: "#424242", strokeColor: "#000000", fillOpacity: 0.9, strokeWidth: 10};
var highlightReprodPosible = {fillColor: "#E64545", strokeColor: "#000000", fillOpacity: 0.9, strokeWidth: 10};
var highlightReprodProbable = {fillColor: "#FFDB4D", strokeColor: "#000000", fillOpacity: 0.9, strokeWidth: 10};
var highlightReprodSegura = {fillColor: "#338533", strokeColor: "#000000", fillOpacity: 0.9, strokeWidth: 10};


// Se obtienen los datos del xml (kml)
function marcarMapa(parserDoc, elementosAMarcar){
    
    for (var i = 0; i < parserDoc.placemarks.length; i++) {
        
        var placemark = parserDoc.placemarks[i];
        
        if (placemark.polygon) {
            
            var kmlStrokeColor = kmlColor(placemark.style.color);
            var kmlFillColor = kmlColor(placemark.style.fillcolor);
            
            var normalStyle = {
                strokeColor: kmlStrokeColor.color,
                strokeWeight: placemark.style.width,
                strokeOpacity: kmlStrokeColor.opacity,
                fillColor: kmlFillColor.color,
                fillOpacity: kmlFillColor.opacity
            };

            placemark.polygon.normalStyle = normalStyle;
            
            for(var j = 0 ; j < elementosAMarcar.length ; j++) {
                
                if(placemark.name == elementosAMarcar[j].codigo) {
                    
                    if(elementosAMarcar[j].cantidad) {
                        // Escasa: hasta 10 aves
                        if(elementosAMarcar[j].cantidad < 10) {
                            placemark.polygon.setOptions(highlightEscasa);
                        }
                        // Común: entre 10 y 100 aves.
                        else if(elementosAMarcar[j].cantidad >= 10 && elementosAMarcar[j].cantidad <= 100) {
                            placemark.polygon.setOptions(highlightComun);
                        }
                        // Muy común: más de 100 aves.
                        else if(elementosAMarcar[j].cantidad > 100) {
                            placemark.polygon.setOptions(highlightMuyComun);
                        }
                        else {
                            placemark.polygon.setOptions(normalStyle);
                        }
                    }
                    else if(elementosAMarcar[j].tipoCria) {
                        // Gris. Desconocido
                        if (elementosAMarcar[j].tipoCria == 0){
                            placemark.polygon.setOptions(highlightDesconocido);
                        }
                        // Negro. No cría
                        else if (elementosAMarcar[j].tipoCria == 1){
                            placemark.polygon.setOptions(highlightNoCria);
                        }
                        // Rojo. Reproducción posible
                        else if(elementosAMarcar[j].tipoCria == 2) {
                            placemark.polygon.setOptions(highlightReprodPosible);
                        }
                        // Amarillo. Reproducción probable
                        else if(elementosAMarcar[j].tipoCria == 3) {
                            placemark.polygon.setOptions(highlightReprodProbable);
                        }
                        // Verde. Reproducción segura
                        else if (elementosAMarcar[j].tipoCria == 4){
                            placemark.polygon.setOptions(highlightReprodSegura);
                        }
                        else {
                            placemark.polygon.setOptions(normalStyle);
                        }
                    }
                    else {
                        placemark.polygon.setOptions(highlightDefault);
                    }
                }
            }

        }
    }
}

function generarLeyenda() {
    
    if($("#tipoDistribucion").val() == "geografica") {
        
        var htmlLeyenda = "";
        htmlLeyenda = htmlLeyenda + '<div class="content-box-gray"></div>';
        htmlLeyenda = htmlLeyenda + '<div style="display:inline-block; vertical-align: middle;">';
        htmlLeyenda = htmlLeyenda + '<p>Áreas donde se ha registrado citas de estas especie.</p>';
        htmlLeyenda = htmlLeyenda + '</div>';
        
        $("#leyenda").html(htmlLeyenda);
    }
    else if($("#tipoDistribucion").val() == "cuantitativa") {
        
        var htmlLeyenda = "";
        htmlLeyenda = htmlLeyenda + '<div>';
        htmlLeyenda = htmlLeyenda + '<div class="content-box-red"></div>';
        htmlLeyenda = htmlLeyenda + '<div style="display:inline-block; vertical-align: middle;">';
        htmlLeyenda = htmlLeyenda + '<p>Escasa: hasta 10 aves.</p>';
        htmlLeyenda = htmlLeyenda + '</div></div>';
        
        htmlLeyenda = htmlLeyenda + '<div>';
        htmlLeyenda = htmlLeyenda + '<div class="content-box-yellow"></div>';
        htmlLeyenda = htmlLeyenda + '<div style="display:inline-block; vertical-align: middle;">';
        htmlLeyenda = htmlLeyenda + '<p>Común: entre 10 y 100 aves.</p>';
        htmlLeyenda = htmlLeyenda + '</div></div>';
        
        htmlLeyenda = htmlLeyenda + '<div>';
        htmlLeyenda = htmlLeyenda + '<div class="content-box-green"></div>';
        htmlLeyenda = htmlLeyenda + '<div style="display:inline-block; vertical-align: middle;">';
        htmlLeyenda = htmlLeyenda + '<p>Muy común: más de 100 aves.</p>';
        htmlLeyenda = htmlLeyenda + '</div></div>';
        
        $("#leyenda").html(htmlLeyenda);
    }
    else if($("#tipoDistribucion").val() == "categoriaReproduccion") {
        
        var htmlLeyenda = "";
        htmlLeyenda = htmlLeyenda + '<div>';
        htmlLeyenda = htmlLeyenda + '<div class="content-box-light-gray"></div>';
        htmlLeyenda = htmlLeyenda + '<div style="display:inline-block; vertical-align: middle;">';
        htmlLeyenda = htmlLeyenda + '<p>Desconocido.</p>';
        htmlLeyenda = htmlLeyenda + '</div></div>';

        htmlLeyenda = htmlLeyenda + '<div>';
        htmlLeyenda = htmlLeyenda + '<div class="content-box-gray"></div>';
        htmlLeyenda = htmlLeyenda + '<div style="display:inline-block; vertical-align: middle;">';
        htmlLeyenda = htmlLeyenda + '<p>No cría.</p>';
        htmlLeyenda = htmlLeyenda + '</div></div>';
        
        htmlLeyenda = htmlLeyenda + '<div>';
        htmlLeyenda = htmlLeyenda + '<div class="content-box-red"></div>';
        htmlLeyenda = htmlLeyenda + '<div style="display:inline-block; vertical-align: middle;">';
        htmlLeyenda = htmlLeyenda + '<p>Reproducción posible.</p>';
        htmlLeyenda = htmlLeyenda + '</div></div>';
        
        htmlLeyenda = htmlLeyenda + '<div>';
        htmlLeyenda = htmlLeyenda + '<div class="content-box-yellow"></div>';
        htmlLeyenda = htmlLeyenda + '<div style="display:inline-block; vertical-align: middle;">';
        htmlLeyenda = htmlLeyenda + '<p>Reproducción probable.</p>';
        htmlLeyenda = htmlLeyenda + '</div></div>';
        
        htmlLeyenda = htmlLeyenda + '<div>';
        htmlLeyenda = htmlLeyenda + '<div class="content-box-green"></div>';
        htmlLeyenda = htmlLeyenda + '<div style="display:inline-block; vertical-align: middle;">';
        htmlLeyenda = htmlLeyenda + '<p>Reproducción segura.</p>';
        htmlLeyenda = htmlLeyenda + '</div></div>';
        
        $("#leyenda").html(htmlLeyenda);
    }
}

function actualizarAreasMapa(data) {
    
    $("#tituloMapa").text(data.title);
    
    if($("#divisionGeografica").val() == "porUtm") {
        parser.showDocument(parser.docs[0]);
        parser.hideDocument(parser.docs[1]);
        marcarMapa(parser.docs[0], data.elementos);
    }
    else if ($("#divisionGeografica").val() == "porMunicipio") {
        parser.showDocument(parser.docs[1]);
        parser.hideDocument(parser.docs[0]);
        marcarMapa(parser.docs[1], data.elementos);
    }
    
    generarLeyenda();
    
    myApp.hidePleaseWait();
}

function generarAreasMapa() {
    $.ajax({
        type: "POST",
        url: "/especie/generar_mapa/especie_id:"+$("#especieId").val(),
        data: $("#frm_mapa_distribucion").serialize(),
        beforeSend: function() {
            myApp.showPleaseWait();
        },
          success: function(data){
              actualizarAreasMapa(JSON.parse(data));
          }
    });
}

function hideDocuments(parserDocs) {
    parser.hideDocument(parserDocs[0]);
    parser.hideDocument(parserDocs[1]);
    
    generarAreasMapa();
}

/* FIN mapa  */

$(document).ready(function() {
    
    var especieId = $("#especieId").val();
    
    actualizarZonaGeografica();
    actualizarPeriodo();
    
    // Mostramos/ocultamos en funcion de las opciones que el usuario va seleccionando
    $('#zonaGeografica').change(function() {
        actualizarZonaGeografica();
    });
    $('#periodo').change(function() {
        actualizarPeriodo();
    });
    
    // Ocultamos el div de info una vez el usuario pulsa "Actualizar gráfico"
    $("#btn_actualizar_grafico").click(function() {
        $("#infoMessagesGrafico").hide();
    });
    
    /* INICIO generar mapa */
    
    $("#btn_actualizar_mapa").click(function(){
        generarAreasMapa();
    });
    /* FIN generar mapa */
    
    /**
     * Generar gráfico
     */
    $.ajax({
        type: "POST",
        url: "/especie/generar_grafico/especie_id:"+especieId,
        data: $("#frm_estadisticas").serialize(),
        beforeSend: function() {
            $('#div_grafico').html('<div class="rating-flash" id="cargando_div">Cargando  <img src="/img/gif/cargando_barra_mini.gif"></div>');
        },
          success: function(msg){
              $('#div_grafico').html(msg);
          }
    });
    
    /* INICIO validar formulario estadisticas */
    
    $.validator.addMethod("anioDesdeMenorAnioHasta", function(value, element) {
          //If false, the validation fails and the message below is displayed
          var anioDesde = value;
          return anioDesde < $('#anioHasta').val();
          }, "El año desde debe ser menor que el año hasta");
        
    $.validator.addMethod("anioHastaMayorAnioDesde", function(value, element) {
          //If false, the validation fails and the message below is displayed
          var anioHasta = value;
          return anioHasta > $('#anioDesde').val();
          }, "El año hasta debe ser mayor que el año desde");
    
    $("#frm_estadisticas").validate({
        rules : {
            fechaDesde : {
                date : true,
                required : true
            },
            fechaHasta : {
                date : true,
                required : true
            }
        },
        messages : {
            fechaDesde : {
                date : "Por favor, escriba una fecha desde válida",
                required : "La fecha desde es obligatoria"
            },
            fechaHasta : {
                date : "Por favor, escriba una fecha hasta válida",
                required : "La fecha hasta es obligatoria"
            }
        },
        errorContainer: "#errorMessagesGrafico",
        errorLabelContainer : "#errorMessagesGrafico ul",
        wrapper: "li",
        submitHandler: function(form) {
            $.ajax({
                type: "POST",
                url: "/especie/generar_grafico/especie_id:"+especieId,
                data: $("#frm_estadisticas").serialize(),
                beforeSend: function() {
                    $('#div_grafico').html('<div class="rating-flash" id="cargando_div">Cargando  <img src="/img/gif/cargando_barra_mini.gif"></div>');
                },
                  success: function(msg){
                      $('#div_grafico').html(msg);
                  }
            });
        }
    });
    /* FIN validar formulario estadisticas */
    
    /* INICIO Galeria de fotos */
    $(".yoxview").yoxview({
        "lang" : "es",
        "autoHideMenu" : false,
        "autoHideInfo" : false,
        "showDescription" : true,
        "renderInfoPin" : false
    });
    /* FIN Galeria de fotos */
    
    /* INICIO popup ayuda */
    $('.help-button').popover();
    /* FIN popup ayuda */
    
});
