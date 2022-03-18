

function marcarMunicipioClick(parserDocs){
  onClickAnyMunicipio(parserDocs);
}

/**
 * Limpia el formulario
 */
function limpiarFormularioLugar() {

    var $formularioNuevoLugar = $('#frmNuevoLugar');

    $formularioNuevoLugar.find("input[type=text], select").val("");

    $formularioNuevoLugar.find(".selectMunicipio").empty();
    $formularioNuevoLugar.find(".selectMunicipio").prop("disabled", true);
}

$(document).ready(function() {

    var $formularioNuevoLugar = $('#frmNuevoLugar'),
        divNuevoLugar = $('#modalNuevoLugar');
        divSelectLugarMapa = $('#modalSeleccionarLugarMapa');

    /* INICIO cambio de municipio */
    $("#selectMunicipio").change(onChangeMunicipioSelect);
    /* FIN cambio de cuadricula UTM */

    /* INICIO Validación de formulario */
    $('#frmNuevoLugar').validate(validate_rules);
    /* FIN Validación de formulario */

    /* INICIO limpiar formulario */
    $("#btnLimpiar").click(function(){
        limpiarFormularioLugar();
    });
    /* FIN limpiar formulario */

    // Cancelar modal de nuevo lugar
    divNuevoLugar.find('#btnCancelarNuevo').click(function () {
        $('#modalNuevoLugar').modal('hide');
    });
    // Limpiar formulario de nuevo lugar
    divNuevoLugar.find('#btnGuardar').click(function () {
        guardarLugar(divNuevoLugar);
    });
    // Cancelar modal de seleccionar lugar con mapa
    divSelectLugarMapa.find('#btnCancelarMapa').click(function () {
        $('#modalSeleccionarLugarMapa').modal('hide');
    });


    /* FIN limpiar formulario */
    /* INICIO popup ayuda */
    $('.badge-info').popover();
    /* FIN popup ayuda */

    /* INICIO guardar lugar */
    $("#btnGuardar").click(function(){
        if ($('#frmNuevoLugar').valid()) {

            var codigoCuadriculaUtm = $('#selectCuadriculaUtm').val();
            var nombreLugar = $('#txtNombre').val();
            var municipioId = $('#selectMunicipio').val();
            $("#frmNuevoLugar").submit();
        }
    });
    /* FIN guardar lugar */

    /* INICIO popup ayuda */
    $('.help-button').popover();
    /* FIN popup ayuda */
});

/**
 * Limpia el formulario
 */
function limpiar() {
  if (typeof(marker) !== "undefined") {
        marker.setMap(null);
  }
  $("#frmNuevoLugar").find("input[type=text], select").val("");

  // Desmarcar municipios
  var municipioAMarcar = {};
  municipioAMarcar.tipo = "municipio";
  marcarMapa(parser.docs[0], municipioAMarcar);
}
//
// /**
//  * Carga el combo de formularios y lo habilita
//  *
//  * @param codigoCuadriculaUtm
//  */
// function loadMunicipioSelect(codigoCuadriculaUtm) {
//
//     var selectMunicipio = $("#selectMunicipio");
//
//     selectMunicipio.load('/municipio/cargarMunicipios/codigoCuadriculaUtm:' + codigoCuadriculaUtm);
//
//     if(codigoCuadriculaUtm != "") {
//         selectMunicipio.prop("disabled", false);
//     }
//     else {
//         selectMunicipio.prop("disabled", true);
//     }
// }
//
// /**
//  * Carga las coordenadas de la cuadricula UTM seleccionada
//  *
//  * @param codigoCuadriculaUtm
//  */
// function loadCoordenadasUtm(codigoCuadriculaUtm) {
//
//     $.ajax({
//         url: "/cuadriculaUtm/cargarDatosCoordenadaUtm",
//         data: {"codigoCuadriculaUtm":codigoCuadriculaUtm},
//         success: function( dataReturn ) {
//             $("#txtCoordenadasUtmArea").val(dataReturn.CuadriculaUtm.area);
//             $("#txtCoordenadasUtmX").val(dataReturn.CuadriculaUtm.coordenadaX);
//             $("#txtCoordenadasUtmY").val(dataReturn.CuadriculaUtm.coordenadaY);
//         },
//         dataType: "json"
//     });
// }

function guardarLugar($div)
{
    if ($('#frmNuevoLugar').valid()) {
      var $formularioNuevoLugar = $div.find('#frmNuevoLugar'),
          nombreLugar = $formularioNuevoLugar.find('#txtNombre').val(),
          municipioId = $formularioNuevoLugar.find('#selectMunicipio').val(),
          lat = $formularioNuevoLugar.find('#txtCoordenadasLat').val(),
          lng = $formularioNuevoLugar.find('#txtCoordenadasLng').val();

      $.ajax({
          url: "/lugar/guardarLugarAjax",
          data: {
              "nombreLugar":nombreLugar,
              "municipioId":municipioId,
              "lat":lat,
              "lng":lng
          },
          success: function( respuesta ) {

              if(respuesta.status == 0) {

                  var textoLugar = [];
                  textoLugar.push(respuesta.lugar.Lugar.nombre);
                  textoLugar.push(respuesta.lugar.Municipio.nombre);
                  textoLugar.push(respuesta.lugar.Comarca.nombre);

                  $("#lugar").val(textoLugar.join(', '));
                  $("#lugarSeleccionadoContenedor").show();
                  $("#lugarSeleccionado").text(textoLugar.join(', '));
                  $('#lugarId').val(respuesta.lugar.Lugar.id).trigger("change");

                  $('#modalNuevoLugar').modal('hide');
              }
              else {
                  if (respuesta.errores) {
                      $div.find('#errorMessagesNuevoLugar ul').html('');

                      for (error in respuesta.errores) {
                          $div.find('#errorMessagesNuevoLugar ul').append('<li>' + error + '</li>');
                      }

                      $('#errorMessagesNuevoLugar').show();

                  } else {
                      console.log('Ha ocurrido un error inesperado al guardar el lugar');
                  }
              }
          },
          dataType: "json"
      });
    }//end .valid()
}
