<?php

// Informamos el título
$this->set('title_for_layout', 'Búsqueda de citas');

/**
 * CSS
 */
$this->Html->css(array(
    'datatables-bootstrap',
    'Cita/index'
), null, array('inline' => false));

/**
 * Javascript
 */
$this->Html->script(array(
    'pleaseWaitDialog',
    'Cita/index'
), array('inline' => false));

// Menu
$this->start('menu');
echo $this->element('/menu');
$this->end();
?>

<script type="text/javascript">
<!--
$(document).ready(function() {

   /* INICIO Carga de valores seleccionados de los combos */
   $("#selectOrdenTaxonomico").val("<?php if(isset($valuesSubmited['ordenTaxonomico'])){echo $valuesSubmited['ordenTaxonomico'];}?>");
   $("#selectFamilia").val("<?php if(isset($valuesSubmited['familia'])){echo $valuesSubmited['familia'];}?>");
   $("#selectFiguraProteccion").val("<?php if(isset($valuesSubmited['figuraProteccion'])){echo $valuesSubmited['figuraProteccion'];}?>");
   $("#selectComarca").val("<?php if(isset($valuesSubmited['comarcaId'])){echo $valuesSubmited['comarcaId'];}?>");
   $("#selectMunicipio").val("<?php if(isset($valuesSubmited['municipioId'])){echo $valuesSubmited['municipioId'];}?>");
   $("#selectCuadriculaUtm").val("<?php if(isset($valuesSubmited['cuadriculaUtmId'])){echo $valuesSubmited['cuadriculaUtmId'];}?>");
   $("#selectLugar").val("<?php if(isset($valuesSubmited['lugarId'])){echo $valuesSubmited['lugarId'];}?>");
   $("#selectClaseReproduccion").val("<?php if(isset($valuesSubmited['claseReproduccionId'])){echo $valuesSubmited['claseReproduccionId'];}?>");
   $("#selectObservador").val("<?php if(isset($valuesSubmited['observadorId'])){echo $valuesSubmited['observadorId'];}?>");
   $("#selectColaborador").val("<?php if(isset($valuesSubmited['colaboradorId'])){echo $valuesSubmited['colaboradorId'];}?>");
   /* Fin Carga de valores seleccionados de los combos */
   
   /* INICIO especie */
   $("#especie").autocomplete({
      source: function( request, response ) {
         $.getJSON( "/especie/buscar_especies", {
            term: request.term
         }, 
         response );
      },
      minLength: 3,
      select: function( event, ui ) {
         this.value = ui.item.value;
         $("#especieId").val(ui.item.id);

         $("#selectOrdenTaxonomico option:selected").prop("selected", false);
         $("#selectFamilia option:selected").prop("selected", false);
         $("#selectOrdenTaxonomico").prop('disabled', true);
         $("#selectFamilia").prop('disabled', true);
         
         return false;
      }
   });

   $("#especie").keyup(function() {
         if(this.value == '') {
             $("#selectOrdenTaxonomico").prop('disabled', false);
             $("#selectFamilia").prop('disabled', false);
         }   
   });
   /* FIN especie */
   
   /* INICIO fechas */
   $( "#fechaDesde" ).datepicker({
      yearRange: "<?php echo $anios[count($anios) - 1 ][0]['anio'];?>:<?php echo date("Y");?>",
      changeMonth: true,
      changeYear: true,
      maxDate: 0,
      onClose: function( selectedDate ) {
         $( "#fechaHasta" ).datepicker( "option", "minDate", selectedDate );
      }
   });
   $( "#fechaHasta" ).datepicker({
      yearRange: "<?php echo $anios[count($anios) - 1 ][0]['anio'];?>:<?php echo date("Y");?>",
      changeMonth: true,
      changeYear: true,
      maxDate: 0,
      onClose: function( selectedDate ) {
          $( "#fechaDesde" ).datepicker( "option", "maxDate", selectedDate );
      }
   });
   // Fin fechas
   
   /* INICIO figura proteccion */
   var figuraProteccion = $("#selectFiguraProteccion").find(':selected').val();
   var nivelProteccion = "<?php if(isset($valuesSubmited['nivelProteccion'])){echo $valuesSubmited['nivelProteccion'];}?>";
   cargarNivelesProteccion(figuraProteccion, nivelProteccion);
   
    $("#selectFiguraProteccion").change(function(event){
      figuraProteccion = $("#selectFiguraProteccion").find(':selected').val();
      cargarNivelesProteccion(figuraProteccion);
     });
   /* FIN figura proteccion */

   /* INICIO buscar */
   $("#btnBuscar").click(function(){
      $("#pleaseWaitDialog").modal();
      $("#frmBusqueda").submit();
   });
   /* FIN buscar */
      
   /* INICIO limpiar */
   $("#btnLimpiar").click(function(){
      $("#frmBusqueda").find("input[type=text], input[type=hidden],select").val("");
      $("#selectNivelProteccion").empty();
      $("#selectNivelProteccion").prop("disabled", true);
   });
   /* FIN limpiar */

    $('#especie').blur(function(){
        if ($(this).val() == '') {
            $('#especieId').val('');
        }
    });

});

function cargarNivelesProteccion(figuraProteccion, nivelProteccion) {

   $("#selectNivelProteccion").load('/cita/cargar_niveles_proteccion/figuraProteccion:' + figuraProteccion + '/nivelProteccion:' + nivelProteccion);

    if(figuraProteccion != "") {
      $("#selectNivelProteccion").prop("disabled", false);
   }
   else {
      $("#selectNivelProteccion").prop("disabled", true);
   }
}

//-->
</script>

<!-- Cuerpo -->
<div>
   <fieldset>
      <legend>
      <?php echo __('Búsqueda de citas'); ?>
      </legend>

      <div class="tabbable">
         <ul class="nav nav-tabs">
            <li class="active"><a href="#que" data-toggle="tab"><?php echo __("¿Qué?")?></a></li>
            <li><a href="#donde" data-toggle="tab"><?php echo __("¿Dónde?")?> </a></li>
            <li><a href="#cuando" data-toggle="tab"><?php echo __("¿Cuándo?")?></a></li>
            <li><a href="#quien" data-toggle="tab"><?php echo __("¿Quién?")?></a></li>
         </ul>

         <form method="get" id="frmBusqueda">

            <div class="tab-content">

               <!-- Que -->
               <div class="tab-pane active text-center" id="que">

                  <!-- Especie -->
                  <div class="control-group">
                     <div class="controls form-inline">
                        <label class="control-label" for="especie"> <?php echo __("Especie");?></label>
                        <input id="especie" name="especie" class="input-xxlarge"
                           type="text"
                           value="<?php if(isset($valuesSubmited['especie'])){echo $valuesSubmited['especie'];}?>"
                           placeholder="<?php echo __('Escriba el nombre común o el nombre científico');?>">
                        <input type="hidden" id="especieId" name="especieId"
                           value="<?php if(isset($valuesSubmited['especieId'])){echo $valuesSubmited['especieId'];}?>">
                     </div>
                  </div>

                  <div class="control-group">

                     <div class="controls form-inline">
                        <!-- Orden taxonomico -->
                        <label class="control-label" for="selectOrdenTaxonomico"><?php echo __("Orden taxonómico");?></label>
                        <select id="selectOrdenTaxonomico" name="ordenTaxonomico"
                           class="input-large">
                           <option value=""><?php echo __("-- Seleccione --");?></option>
                           <?php
                           foreach($ordenesTaxonomicos as $ordenTaxonomico) {
                              echo '<option value="'.$ordenTaxonomico["OrdenTaxonomico"]["id"].'">'.$ordenTaxonomico["OrdenTaxonomico"]["nombre"].'</option>';
                           }
                           ?>
                        </select>
                        <!-- Familia -->
                        <label class="control-label" style="width: 80px;"
                           for="selectFamilia"><?php echo __("Familia");?></label> <select
                           id="selectFamilia" name="familia" class="input-large">
                           <option value=""><?php echo __("-- Seleccione --");?></option>
                           <?php
                           foreach($familias as $familia) {
                              echo '<option value="'.$familia["Familia"]["id"].'">'.$familia["Familia"]["nombre"].'</option>';
                           }
                           ?>
                        </select>
                     </div>
                  </div>

                  <!-- Figura protección -->
                  <div class="control-group">
                     <div class="controls form-inline">
                        <label class="control-label" for="selectFiguraProteccion"><?php echo __("Figura de protección");?></label>
                        <select id="selectFiguraProteccion" name="figuraProteccion"
                           class="input-large">
                           <option value=""><?php echo __("-- Seleccione --");?></option>
                           <option value="catalogoRegional"><?php echo __("Catálogo Regional");?></option>
                           <option value="libroRojo"><?php echo __("Libro Rojo de España");?></option>
                           <option value="estatusAlbacete"><?php echo __("Estatus en Albacete");?></option>
                        </select> <select id="selectNivelProteccion"
                           name="nivelProteccion" class="input-xlarge"
                           style="margin-left: 20px; width: 315px;" disabled="disabled">
                        </select>
                     </div>
                  </div>

                  <!-- Clase reproducción -->
                  <div class="control-group">
                     <div class="controls form-inline">
                        <label class="control-label" for="selectClaseReproduccion"><?php echo __("Clase de reproducción");?></label>
                        <select id="selectClaseReproduccion" name="claseReproduccionId"
                           class="input-xxlarge" style="width: 550px;">
                           <option value=""><?php echo __("-- Seleccione --");?></option>
                           <?php
                           $tiposCriaSeleccionados = array();
                           $lastIdTipoCria = 0;
                           foreach ($clasesReproduccion as $claseReproduccion) {
                           
                              $idTipoCria = $claseReproduccion['ClaseReproduccion']['idTipoCria'];
                              if($idTipoCria != $lastIdTipoCria) {
                                 $lastIdTipoCria = $idTipoCria;
                                 echo '</optgroup>';
                              }
                              if(!in_array($idTipoCria, $tiposCriaSeleccionados)) {
                                 echo '<optgroup label="'.$claseReproduccion['ClaseReproduccion']['tipoCria'].'">';
                                 array_push($tiposCriaSeleccionados, $idTipoCria);
                              }
                              echo '<option value="'.$claseReproduccion["ClaseReproduccion"]["id"].'">'.$claseReproduccion["ClaseReproduccion"]["codigo"].' - '.$claseReproduccion["ClaseReproduccion"]["descripcion"].'</option>';
                           }
                           ?>
                        </select>
                     </div>
                  </div>

               </div>
               <!-- Donde -->
               <div class="tab-pane text-center" id="donde">

                  <div class="control-group">

                     <!-- Comarca -->
                     <div class="controls form-inline">
                        <label class="control-label" for="selectComarca"><?php echo __("Comarca");?></label>
                        <select id="selectComarca" name="comarcaId" class="input-large">
                           <option value=""><?php echo __("-- Seleccione --");?></option>
                           <?php
                                    foreach ($comarcas as $comarca)
                                    {
                              echo '<option value="'.$comarca["Comarca"]["id"].'">'.$comarca["Comarca"]["nombre"].'</option>';
                           }
                           ?>
                        </select>
                        <!-- Municipio -->
                        <label class="control-label" style="width: 80px;"
                           for="selectMunicipio"><?php echo __("Municipio");?> </label> <select
                           id="selectMunicipio" name="municipioId" class="input-large">
                           <option value=""><?php echo __("-- Seleccione --");?></option>
                           <?php
                           foreach($municipios as $municipio) {
                              echo '<option value="'.$municipio["Municipio"]["id"].'">'.$municipio["Municipio"]["nombre"].'</option>';
                           }
                           ?>
                        </select>
                     </div>
                  </div>

                  <div class="control-group">

                     <div class="controls  form-inline">

                        <!-- Cuadricula UTM -->
                        <label class="control-label" for="selectCuadriculaUtm"><?php echo __("Cuadrícula UTM");?></label>
                        <select id="selectCuadriculaUtm" name="cuadriculaUtmId"
                           class="input-large">
                           <option value=""><?php echo __("-- Seleccione --");?></option>
                           <?php
                           foreach($cuadriculasUtm as $cuadriculaUtm) {
                              echo '<option value="'.$cuadriculaUtm["CuadriculaUtm"]["id"].'">'.$cuadriculaUtm["CuadriculaUtm"]["codigo"].'</option>';
                           }
                           ?>
                        </select>
                        <!-- Lugar -->
                        <label class="control-label" style="width: 80px;"
                           for="selectLugar"><?php echo __("Lugar");?></label> <select
                           id="selectLugar" name="lugarId" class="input-large">
                           <option value=""><?php echo __("-- Seleccione --");?></option>
                           <?php
                           foreach($lugares as $lugar) {
                              echo '<option value="'.$lugar["Lugar"]["id"].'">'.$lugar["Lugar"]["nombre"].'</option>';
                           }
                           ?>
                        </select>
                     </div>
                  </div>
               </div>
               <!-- Cuándo -->
               <div class="tab-pane text-center" id="cuando">
                  <!-- Intervalo fechas -->
                  <div class="controls form-inline">
                     <label class="control-label" for="fechaDesde"><?php echo __("Fecha desde");?></label>
                     <div class="input-append">
                        <input type="text"
                           value="<?php if(isset($valuesSubmited['fechaDesde'])){echo $valuesSubmited['fechaDesde'];}?>"
                           id="fechaDesde" name="fechaDesde" size="10" class="date-picker"
                           style="width: auto;" placeholder="Desde" /> <label
                           style="width: 0; margin-left: 0;" for="fechaDesde"
                           class="add-on"><i class="icon-calendar"></i></label>
                     </div>
                     <label class="control-label" style="width: 40px;"
                        for="fechaDesde"><?php echo __("hasta");?></label>
                     <div class="input-append">
                        <input type="text"
                           value="<?php if(isset($valuesSubmited['fechaHasta'])){echo $valuesSubmited['fechaHasta'];}?>"
                           id="fechaHasta" name="fechaHasta" size="10" class="date-picker"
                           style="width: auto;" placeholder="Hasta" /> <label
                           style="width: 0; margin: 0;" for="fechaHasta" class="add-on"><i
                           class="icon-calendar"></i></label>
                     </div>
                  </div>
               </div>
               <!-- Quién -->
               <div class="tab-pane text-center" id="quien">
                  <!-- Observador principal -->
                  <div class="control-group">
                     <div class="controls form-inline">
                        <label class="control-label" for="selectObservador"><?php echo __("Observador");?></label>
                        <select id="selectObservador" name="observadorId"
                           class="input-xlarge">
                           <option value=""><?php echo __("-- Seleccione --");?></option>
                           <?php
                           foreach($observadores as $observador) {
                              echo '<option value="'.$observador["ObservadorPrincipal"]["id"].'">'.$observador["ObservadorPrincipal"]["codigo"]." - ".$observador["ObservadorPrincipal"]["nombre"].'</option>';
                           }
                           ?>
                        </select>
                     </div>
                  </div>
                  <!-- Observador secundario -->
                  <div class="control-group">
                     <div class="controls form-inline">
                        <label class="control-label" for="selectColaborador"><?php echo __("Colaborador");?></label>
                        <select id="selectColaborador" name="colaboradorId"
                           class="input-xlarge">
                           <option value=""><?php echo __("-- Seleccione --");?></option>
                           <?php
                           foreach($colaboradores as $colaborador) {
                              echo '<option value="'.$colaborador["ObservadorSecundario"]["id"].'">'.$colaborador["ObservadorSecundario"]["codigo"]." - ".$colaborador["ObservadorSecundario"]["nombre"].'</option>';
                           }
                           ?>
                        </select>
                     </div>
                  </div>
               </div>
            </div>

            <hr>

            <!-- Botones de búsqueda -->
            <div id="divBotonesBusqueda" class="control-group">
               <div class="controls">
                  <input type="button" id="btnLimpiar" class="btn btn-warning"
                     value="<?php echo __("Limpiar");?>" /> <input type="submit"
                     id="btnBuscar" class="btn btn-success btn-large"
                     value="<?php echo __("Buscar");?>" />
               </div>
            </div>
         </form>
      </div>
      
      <?php 
         $this->Paginator->options(array(
            'update'=>'#content',
            'before' => $this->Js->get('#pleaseWaitDialog')->effect(
                 'fadeIn',
                 array('buffer' => false)
             ),
             'complete' => $this->Js->get('#pleaseWaitDialog')->effect(
                 'fadeOut',
                 array('buffer' => false)
             )
      ) );
      ?>
      
      <?php if(isset($citas)) : ?>
      
      <fieldset>

         <div class="modal hide" id="pleaseWaitDialog" data-backdrop="static"
            data-keyboard="false">
            <div class="modal-header">
               <h4>Por favor, espere...</h4>
            </div>
            <div class="modal-body">
               <div class="progress progress-striped active">
                  <div class="bar" style="width: 100%;"></div>
               </div>
            </div>
         </div>

         <legend class="small"><?php echo __("Citas encontradas");?></legend>

         <table id="tabla_citas"
            class="table table-striped table-bordered table-hover table-condensed">
            <thead>
               <tr>
                  <th style="text-align: center;"><?php echo __("Ver más");?></th>
                  <th style="text-align: center;"><?php echo $this->Paginator->sort("Especie.nombreComun", "Especie");?></th>
                  <th style="text-align: center;"><?php echo $this->Paginator->sort("fechaAlta", "Fecha");?></th>
                  <th style="text-align: center;"><?php echo $this->Paginator->sort("Lugar.nombre", "Lugar");?></th>
                  <th style="text-align: center;"><?php echo $this->Paginator->sort("cantidad", "Número de Aves");?></th>
                  <th style="text-align: center;"><?php echo $this->Paginator->sort("ObservadorPrincipal.codigo", "Observador");?></th>
                  <th style="text-align: center;"><?php echo __("Colaboradores");?></th>
                  <th style="text-align: center;"><?php echo $this->Paginator->sort("ClaseReproduccion.codigo","Clase de Reproducción");?></th>
                  <th style="text-align: center;"><?php echo $this->Paginator->sort("ImportanciaCita.codigo", __("Importancia"));?></th>
               </tr>
            </thead>
            <tbody>
               <?php 
                  foreach ($citas as $cita) {
                     echo "<tr>";
                     echo    "<td style='text-align: center;'><a href='/cita/view/id:".$cita['Cita']['id']."' title='".__("Más información")."'><img src='/img/icons/fugue-icons-3.5.6/icons/magnifier-left.png' title='Ver detalle de la cita' alt='Ver detalle'/></a></td>";
                     echo    "<td><a href='/cita/index?especieId=".$cita['Especie']['id']."' title='".$cita['Especie']['genero']." ".$cita['Especie']['especie']." ".$cita['Especie']['subespecie']."'>".$cita['Especie']['nombreComun']." ".$cita['Especie']['subespecie']."</a></td>";
                     echo    "<td style='text-align: center;'><a href='/cita/index?fechaAlta=".date_format(date_create($cita['Cita']['fechaAlta']), "d/m/Y")."'>".date_format(date_create($cita['Cita']['fechaAlta']), "d/m/Y")."</a></td>";
                     
                     if ($cita['Cita']['indPrivacidad'] == 1 || (isset($usuario) && ($usuario['observador_principal_id'] == $cita['Cita']['observador_principal_id'] || $usuario['perfil_id'] == 1))) {
                         $lugarContent = "<a href='/cita/index?lugarId=" . $cita['Lugar']['id'] . "' title='" . $this->Lugar->mostrarDetalleLugar($cita) . "'>" . ucwords($cita['Lugar']['nombre']) . "</a>";
                     } else {
                         $lugarContent = '<span title="' . $this->Lugar->mostrarDetalleLugar($cita) . '"><img width="16" height="16" style="margin-right: 10px;" alt="alert icon" src="/img/icons/fugue-icons-3.5.6/icons/exclamation-red.png"> Lugar confidencial</span>';
                     }
                     echo    "<td>$lugarContent</td>";
                     
                     echo    "<td style='text-align: center;'><span title='".$this->ClaseEdadSexo->mostrar_detalle_clase_edad_sexo($cita['clases_edad_sexo'])."'>".$cita['Cita']['cantidad']."</span></td>";
                     echo    "<td style='text-align: center;'><a href='/cita/index?observadorId=".$cita['ObservadorPrincipal']['id']."' title='".$cita['ObservadorPrincipal']['nombre']."'>".$cita['ObservadorPrincipal']['codigo']."</a></td>";
                     echo    "<td>".$this->ObservadorSecundario->mostrar_codigos_observadores($cita['observadoresSecundarios'])."</td>";
                     echo    "<td style='text-align: center;'><a href='/cita/index?claseReproduccionId=".$cita['ClaseReproduccion']['id']."' title='".$cita['ClaseReproduccion']['descripcion']."'>".$cita['ClaseReproduccion']['codigo']."</a></td>";
                     echo    "<td style='text-align:center;'>".$this->Importancia->getIconoImportancia($cita['ImportanciaCita']['id'], $cita['ImportanciaCita']['descripcion'])."</td>";
                     echo "</tr>";
                  } 
               ?>
               </tbody>
            <tfoot>
               <tr>
                  <th style="text-align: center;"><?php echo __("Ver más");?></th>
                  <th style="text-align: center;"><?php echo $this->Paginator->sort("Especie.nombreComun", "Especie");?></th>
                  <th style="text-align: center;"><?php echo $this->Paginator->sort("fechaAlta", "Fecha");?></th>
                  <th style="text-align: center;"><?php echo $this->Paginator->sort("Lugar.nombre", "Lugar");?></th>
                  <th style="text-align: center;"><?php echo $this->Paginator->sort("cantidad", "Número de Aves");?></th>
                  <th style="text-align: center;"><?php echo $this->Paginator->sort("ObservadorPrincipal.codigo", "Observador");?></th>
                  <th style="text-align: center;"><?php echo __("Colaboradores");?></th>
                  <th style="text-align: center;"><?php echo $this->Paginator->sort("ClaseReproduccion.codigo","Clase de Reproducción");?></th>
                  <th style="text-align: center;"><?php echo $this->Paginator->sort("ImportanciaCita.codigo", __("Importancia"));?></th>
               </tr>
            </tfoot>
         </table>
         
         <?php 
            echo $this->Paginator->counter(
               'Mostrando {:start} de {:end} registros de un total de {:count}'
            );
         ?>

         <div class="pagination pagination-right">
            <?php 
               echo $this->Paginator->first('Primera', null, null, array('class'=>'disable'));
               echo $this->Paginator->prev('← Anterior', null, null, array('class'=>'disable'));
               echo $this->Paginator->numbers(array('separator'=>''));
               echo $this->Paginator->next('Siguiente → ', null, null, array('class'=>'disable'));
               echo $this->Paginator->last('Última', null, null, array('class'=>'disable'));
            ?>
         </div>

      </fieldset>
      
      <?php else :?>
         
         <fieldset>
         <legend><?php echo __("No se han encontado citas.");?></legend>
      </fieldset>
         
      <?php endif;?>

   </fieldset>
</div>

<!-- Pie -->
<?php
   $this->start('pie');
   echo $this->element('/pie');
   $this->end();
?>

<?php echo $this->Js->writeBuffer(); ?>