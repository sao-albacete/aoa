<?php
// Informamos el título
$title = 'Editar cita ' . $cita['Cita']['id'];
$this->set('title_for_layout', $title);

/**
 * CSS
 */
$this->Html->css(array(
	'datatables-bootstrap',
	'Cita/edit',
	'/plugin/jquery-timepicker-1.3.5/jquery.timepicker.min.css',
	'/plugin/summernote-0.8.16-dist/summernote.min.css',
), null, array('inline' => false));

/**
 * Javascript
 */
$this->Html->script(array(
	'/plugin/jquery-validation-1.11.1/dist/jquery.validate.min',
	'/plugin/jquery-validation-1.11.1/dist/additional-methods.min',
	'/plugin/jquery-validation-1.11.1/localization/messages_es',
	'/plugin/jquery-timepicker-1.3.5/jquery.timepicker.min.js',
	'/plugin/yoxview/yoxview-init',
	'https://maps.googleapis.com/maps/api/js?key=AIzaSyCvHe5uH6Ogczm4OWoXkq8_NiwspG4oE1I',
	'common/maps/geoxml3/geoxml3.js',
	'common/maps/geoxml3/ProjectedOverlay.js',
	'/plugin/DataTables-1.9.4/media/js/jquery.dataTables',
	'datatables-bootstrap',
	'/plugin/bootbox/bootbox.min',
	'/plugin/summernote-0.8.16-dist/summernote.min.js',
	'/plugin/summernote-0.8.16-dist/lang/summernote-es-ES.min.js',
	'common/maps/functions',
	'common/Especie/funciones',
	'common/Lugar/funciones',
	'common/Cita/funciones',
	'common/ObservadorPrimario/funciones',
	'common/ObservadorSecundario/funciones',
  'Lugar/common',
  'Cita/add',
	'Cita/edit'
), array('inline' => false));

// Menu
$this->start('menu');
echo $this->element('/menu');
$this->end();
?>

<script type="text/javascript">
google.maps.event.addDomListener(window, 'load', initialize_map_view);

$(document).ready(function(){
  function onChangeLugar() {
      if($(this).val() != "") {
        var id = $(this).val()
        $.getJSON("/lugar/obtenerLugar", {
                id: id
            },
            function( data ) {
                if (data.length){
                  var lugar = data[0];
                  placemarker_lugar_municipio(lugar.lat, lugar.lng, lugar.nombre, lugar.municipio)
                  var municipioAMarcar = {};
                  municipioAMarcar.codigo = lugar.municipio;
                  municipioAMarcar.tipo = "municipio";

                  marcarMapa(parser_readonly.docs[0], municipioAMarcar);
                }
            } );
      }

  }
  $("#lugarId").change(onChangeLugar);

});

function marcarMunicipio(parserDocs) {
    // Marcar municipio en el mapa
    var municipioAMarcar = {};
    municipioAMarcar.codigo = "<?php echo $cita['Lugar']['Municipio']['nombre'];?>";
    municipioAMarcar.tipo = "municipio";
    marcarMapa(parserDocs[0], municipioAMarcar);
    add_init_lugar_marker();
}

function add_init_lugar_marker(){
  var nombreLugar = "<?php echo $cita['Lugar']['Lugar']['nombre'];?>";
  var nombreMunicipio = "<?php echo $cita['Lugar']['Municipio']['nombre']; ?>";
  placemarker_lugar_municipio(<?php echo $cita['Lugar']['Lugar']['lat'];?>,
              <?php echo $cita['Lugar']['Lugar']['lng'];?>,
              nombreLugar, nombreMunicipio);

  //con esto eliminamos la molesta caja de Close que se queda al pasar el ratón por el x del infobox y cerrarlo.
  setTimeout(function (){ $(".gm-ui-hover-effect").attr('title','');  }, 2000);
}

</script>

<?php if (isset($warnings)): ?>
	<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<p><?= __('Hubo algún problema al guardar la cita:') ?></p>
		<ul>
			<?php foreach ($warnings as $warning) : ?>
				<li><?= $warning ?></li>
			<?php endforeach ?>
		</ul>
	</div>
<?php endif ?>

<!-- Cuerpo -->
<div id="divEditarCita">

	<fieldset>
		<legend>
			<?= __('Editar cita: ') . $cita['Cita']['id']; ?>
			&nbsp;&nbsp;
			<?php
			echo $this->Importancia->getIconoImportancia($cita['ImportanciaCita']['id'], $cita['ImportanciaCita']['descripcion']);
			if ($cita['Especie']['Especie']['indRareza'] == 1) {
				if ($cita['Cita']['indRarezaHomologada'] == 3) {
					echo '<span class="label label-success text-info rareza-message">Rareza homologada</span>';
				} else {
					echo '<span class="label label-warning text-info rareza-message">Rareza pendiente de homologar</span>';
				}
			}
			?>
		</legend>

		<div class="well well-small">
			Los campos marcados con un asterisco (*) son obligatorios
		</div>

		<div id="errorMessagesGrafico" class="alert alert-error"
			 style="display: none; padding-left: 14px;">
			<h5>Por favor, corrija los errores en el formulario:</h5>
			<ul></ul>
		</div>

		<form id="frmEditarCita" class="form-horizontal" method="post"
			  enctype="multipart/form-data">

			<input type="hidden" id="citaId" name="citaId" value="<?= $cita['Cita']['id']; ?>"/>

			<div class="row">

				<div class="span6">

					<!-- Especie-->
					<div class="control-group">
						<label class="control-label" style="width: 100px;" for="especie"> <?= __("Especie"); ?>&nbsp;(*)
							<br/>
							<span class="badge badge-info" data-trigger="hover"
								  data-content="<?= __('Escribe tres letras del nombre común, género o especie y selecciona una especie de la lista. Además, una vez seleccionada una especie, podrás seleccioanr su subespecie escribiendo su primera letra y seleccioando una del listado.'); ?>"><i
									class="icon-info-sign icon-white"></i> </span>
						</label>
						<div class="controls" style="margin-left: 120px;">
							<div class="dummy">
								<input class="especie input-xxlarge" name="especie"
									   type="text"
									   value="<?= $cita['Especie']['Especie']['nombreComun'] . ", " . $cita['Especie']['Especie']['genero'] . " " . $cita['Especie']['Especie']['especie']; ?>"
									   placeholder="<?= __('Escriba el nombre común o el nombre científico'); ?>">
								<input name="subespecie" class="subespecie input-large" type="text"
									   placeholder="<?= __('Escriba la subespecie'); ?>"
									   value="<?= $cita['Especie']['Especie']['subespecie']; ?>">
								<div class="especieSeleccionadaContenedor"
									 style="margin-top: 5px;">
									<?= __("Especie seleccionada"); ?>:
									<span class="especieSeleccionada text-success" style="font-weight: bold;">
                                        <?= $cita['Especie']['Especie']['nombreComun'] . ", " . $cita['Especie']['Especie']['genero'] . " " . $cita['Especie']['Especie']['especie']; ?>
                                    </span>
								</div>
								<div class="subespecieSeleccionadaContenedor" style="margin-top: 5px;">
									<?= __("Subespecie seleccionada"); ?>:
									<span class="subespecieSeleccionada text-success"
										  style="font-weight: bold;"><?= $cita['Especie']['Especie']['subespecie']; ?></span>
								</div>
								<div style="margin-top: 5px;">
									<button class="btnVaciarEspecie btn btn-warning btn-mini" type="button">
										<i class="icon-trash" style="margin-right: 10px;"></i><?= __("Limpiar"); ?>
									</button>
								</div>
								<input type="hidden" class="especieId" name="data[Cita][especie_id]"
									   value="<?= $cita['Especie']['Especie']['id']; ?>">
							</div>
						</div>
					</div>

					<!-- Fecha alta-->
					<div class="control-group">
						<label class="control-label" style="width: 100px;" for="fechaAlta"> <?= __("Fecha"); ?>&nbsp;(*)
							<br/>
							<span class="badge badge-info" data-trigger="hover"
								  data-content="<?= __('Seleccione un día pulsando el calendario o escriba una fecha con formato ') . date('d/m/Y') ?>"><i
									class="icon-info-sign icon-white"></i> </span>
						</label>
						<div class="controls" style="margin-left: 120px;">
							<div class="input-prepend">
								<label for="fechaAlta" class="add-on"><i class="icon-calendar"></i></label>
								<input type="text" id="fechaAlta"
									   value="<?= date_format(date_create($cita['Cita']['fechaAlta']), "d/m/Y"); ?>"
									   name="data[Cita][fechaAlta]" size="10" class="date-picker"
									   data-mask="99/99/9999" style="width: auto;"
									   placeholder="dd/mm/aaaa"/>
							</div>
						</div>
					</div>

					<!-- Hora alta-->
					<div class="control-group">
						<label class="control-label" style="width: 100px;" for="horaAlta"> <?= __("Hora"); ?>&nbsp;(*)
							<br/>
							<span class="badge badge-info" data-trigger="hover"
								  data-content="<?= __('Seleccione una hora pulsando el selector o escriba una hora con formato hh:mm') ?>"><i
									class="icon-info-sign icon-white"></i> </span>
						</label>
						<div class="controls" style="margin-left: 120px;">
							<div class="input-prepend">
								<label for="horaAlta" class="add-on"><i class="icon-time"></i></label>
								<input type="text" id="horaAlta"
									   value="<?= date("H:i", strtotime($cita['Cita']['fechaAlta'])); ?>"
									   name="data[Cita][horaAlta]" size="10" class="time-picker hora-alta"
									   data-mask="99:99" style="width: auto;"
									   placeholder="hh:mm"/>
							</div>
						</div>
					</div>
				</div>
				<!-- Figuras de protección -->
				<div class="span6">
					<p>
						<?= "<span class='label " . $this->Especie->obtener_color_proteccion_lr($cita['Especie']['ProteccionLr']['codigo']) . "'>" . $cita['Especie']['ProteccionLr']['nombre'] . "</span>" . __(" según el ") . "<em><b>" . __("Libro Rojo de las Aves de España") . "</b></em>"; ?>
					</p>
					<p>
						<?= "<span class='label " . $this->Especie->obtenerEtiquetaProteccionClmPorCodigo($cita['Especie']['ProteccionClm']['codigo']) . "'>" . $cita['Especie']['ProteccionClm']['nombre'] . "</span>" . __(" en ") . "<b>" . __("Castilla - La Mancha") . "</b>"; ?>
					</p>
					<p>
						<?= "<span class='label label-info'>" . $cita['Especie']['EstatusCuantitativoAb']['nombre'] . "</span>" . __(" en ") . "<b>" . __("Albacete") . "</b>"; ?>
					</p>
					<p>
						<?= "<span class='label label-info'>" . $cita['Especie']['EstatusReproductivoAb']['nombre'] . "</span>" . __(" en ") . "<b>" . __("Albacete") . "</b>"; ?>
					</p>
				</div>
			</div>
			<br>
			<div class="row">

				<!-- Datos cita -->
				<div class="span6">

					<label class="control-label" for="indeterminado"> <?php echo __("Número de aves"); ?> (*)
						<br>
						<span class="badge badge-info" data-trigger="hover" style="font-weight: normal; margin-top: 5px;"
							  data-content='<?php echo __("Rellene los cuadros con el número de individuos observados en función de la edad y el sexo."); ?>'><i
									class="icon-info-sign icon-white"></i> </span>
					</label>

					<!-- Número de aves-->
					<div class="dummy" style="display: inline; text-align: center;">

						<div class="opcionesCantidad" style="margin-bottom: 10px;">
							<label class="radio inline" for="cantidad_exacta">
								<input type="radio" name="data[Cita][precision]" id="cantidad_exacta" value="cantidad_exacta" <?php if ($cita['Cita']['cantidad_exacta'] == true) {
									echo "checked='checked'";
								} ?>/>
								<?php echo __("Número exacto"); ?>
							</label>

							<label class="radio inline" for="cantidad_precisa">
								<input type="radio" name="data[Cita][precision]" id="cantidad_precisa" value="cantidad_precisa" <?php if ($cita['Cita']['cantidad_precisa'] == true) {
									echo "checked='checked'";
								} ?>/>
								<?php echo __("Conteo preciso"); ?>
							</label>

							<label class="radio inline" for="cantidad_estimada">
								<input type="radio" name="data[Cita][precision]" id="cantidad_estimada" value="cantidad_estimada" <?php if ($cita['Cita']['cantidad_estimada'] == true) {
									echo "checked='checked'";
								} ?>/>
								<?php echo __("Estima"); ?>
							</label>

							<label class="radio inline" for="cantidad_aproximada">
								<input type="radio" name="data[Cita][precision]" id="cantidad_aproximada" value="cantidad_aproximada" <?php if ($cita['Cita']['cantidad_aproximada'] == true) {
									echo "checked='checked'";
								} ?>/>
								<?php echo __("Número aproximado"); ?>
							</label>
						</div>

						<?= $this->element('Cita/tablaNumeroAves'); ?>

						<div class="numeroTotalAvesDiv" style="margin-top: 5px; text-align: left; margin-bottom: 20px;">
							<?= __("Número total aves"); ?>:
							<span class="numeroTotalAvesTexto text-success"
								  style="font-weight: bold;"><?= $cita['Cita']['cantidad']; ?></span>
						</div>
						<input type="hidden" class="totalNumeroAves"
							   name="data[Cita][cantidad]" value="<?= $cita['Cita']['cantidad']; ?>"/>
					</div>

					<fieldset class="fsCustom">
						<legend>Datos de los observadores</legend>
						<!-- Observador -->
						<div class="control-group">
							<label class="control-label" for="observador"> <?= __("Observador"); ?>&nbsp;(*)</label>
							<div class="controls">
								<div class="dummy">
									<input id="observador" name="observador" class="input-xlarge"
										   type="text"
										   value="<?= $usuario['ObservadorPrincipal']['codigo'] . " - " . $usuario['ObservadorPrincipal']['nombre']; ?>"
										   placeholder="Escriba el código o el nombre del observador">
									<span class="badge badge-info" data-trigger="hover"
										  data-content='<?= __("Escriba al menos tres letras y seleccione de la lista los observadores que quiera incluir en la cita."); ?>'><i
											class="icon-info-sign icon-white"></i> </span>
									<br/>
									<div id="observadorSeleccionadoDiv"
										 style="margin-top: 5px;">
										Observador seleccionado: <span
											id="observadorSeleccionadoTexto" class="text-success"
											style="font-weight: bold;"><?= $usuario['ObservadorPrincipal']['codigo'] . " - " . $usuario['ObservadorPrincipal']['nombre']; ?></span>
									</div>
									<input type="hidden" id="observadorSeleccionado"
										   value="<?= $usuario['ObservadorPrincipal']['id']; ?>"
										   name="data[Cita][observador_principal_id]"/>
								</div>
							</div>
						</div>

						<!-- Colaboradores -->
						<div class="control-group">
							<label class="control-label" for="colaboradores"> <?= __("Colaboradores"); ?></label>
							<div class="controls">
								<div class="dummy">
									<input id="colaboradores" name="colaboradores" class="input-xlarge"
										   type="text"
										   placeholder="Escriba el código o el nombre del colaborador">
									<span class="badge badge-info" data-trigger="hover"
										  data-content='<?= __("Escriba al menos tres letras y seleccione de la lista los colaboradores que quiera incluir en la cita."); ?>'><i
											class="icon-info-sign icon-white"></i> </span>
									<br/>
									<div id="colaboradoresSeleccionadosDiv"
										 style="margin-top: 5px;">
										Colaboradores seleccionados: <span
											id="colaboradoresSeleccionadosTexto" class="text-success"
											style="font-weight: bold;"><?= $this->ObservadorSecundario->mostrar_nombres_observadores($cita['observadores']); ?></span>
									</div>
									<input type="hidden" id="colaboradoresSeleccionados"
										   name="colaboradoresSeleccionados"
										   value="<?= $this->ObservadorSecundario->mostrar_ids_observadores($cita['observadores']); ?>"/>
									<div style="margin-top: 5px;">
										<button class="btn btn-warning btn-mini" type="button"
												id="btnVaciarColaboradores">
											<i class="icon-trash" style="margin-right: 10px;"></i><?= __("Limpiar"); ?>
										</button>
										<button class="btn btn-mini btn-primary btnNuevoColaborador" type="button">
											<i class="icon-plus"></i> <?= __("Nuevo colaborador"); ?>
										</button>
									</div>
								</div>
							</div>
						</div>

						<!-- Fuente -->
						<div class="control-group">
							<label class="control-label" for="fuenteId"> <?= __("Fuente"); ?></label>
							<div class="controls">
								<select id="fuenteId" name="data[Cita][fuente_id]"
										class="input-xlarge">
									<?php
									foreach ($fuentes as $fuente) {
										if ($fuente["Fuente"]["id"] == $cita['Fuente']['id']) {
											echo "<option value='" . $fuente["Fuente"]["id"] . "' selected='selected'>" . $fuente["Fuente"]["nombre"] . "</option>";
										} else {
											echo "<option value='" . $fuente["Fuente"]["id"] . "'>" . $fuente["Fuente"]["nombre"] . "</option>";
										}
									}
									?>
								</select>
								<span class="badge badge-info" data-trigger="hover"
									  data-content='<?= __("Seleccione la fuente de la que proviene la cita."); ?>'><i
										class="icon-info-sign icon-white"></i> </span>
							</div>
						</div>

						<!-- Estudio -->
						<div class="control-group">
							<label class="control-label" for="estudio"> <?= __("Estudio"); ?></label>
							<div class="controls">
								<select id="estudioId" name="data[Cita][estudio_id]" class="input-xlarge">
									<?php
									foreach ($estudios as $estudio) {
										if ($estudio["Estudio"]["id"] == $cita['Estudio']['id']) {
											echo "<option value='" . $estudio["Estudio"]["id"] . "' selected='selected'>" . $estudio["Estudio"]["descripcion"] . "</option>";
										} else {
											echo "<option value='" . $estudio["Estudio"]["id"] . "'>" . $estudio["Estudio"]["descripcion"] . "</option>";
										}
									}
									?>
								</select>
								<span class="badge badge-info" data-trigger="hover"
									  data-content='<?= __("Seleccione el tipo de estudio asociado a la cita."); ?>'><i
										class="icon-info-sign icon-white"></i> </span>
							</div>
						</div>

					</fieldset>

					<fieldset class="fsCustom" style="margin-top: 20px;">
						<legend>Indicadores de la cita</legend>

						<div class="span5">
							<label class="checkbox">
								<input name="data[Cita][indHabitatRaro]" value="1"
									   type="checkbox" <?php if ($cita['Cita']['indHabitatRaro'] == true) {
									echo "checked='checked'";
								} ?>> <?php echo __("Especie vista en habitat atípico"); ?>
							</label>
							<label class="checkbox">
								<input name="data[Cita][indCriaHabitatRaro]" value="1"
									   type="checkbox" <?php if ($cita['Cita']['indCriaHabitatRaro'] == true) {
									echo "checked='checked'";
								} ?>> <?php echo __("Reproducción en un hábitat atípico"); ?>
							</label>
							<label class="checkbox">
								<input name="data[Cita][dormidero]" value="1"
									   type="checkbox" <?php if ($cita['Cita']['dormidero'] == true) {
									echo "checked='checked'";
								} ?>> <?php echo __("En dormidero"); ?>
							</label>
							<label class="checkbox">
								<input name="data[Cita][colonia_de_cria]" value="1"
									   type="checkbox" <?php if ($cita['Cita']['colonia_de_cria'] == true) {
									echo "checked='checked'";
								} ?>> <?php echo __("Colonia de cría"); ?>
							</label>
							<label class="checkbox">
								<input name="data[Cita][migracion_activa]" value="1"
									   type="checkbox" <?php if ($cita['Cita']['migracion_activa'] == true) {
									echo "checked='checked'";
								} ?>> <?php echo __("Migración activa"); ?>
							</label>
							<label class="checkbox" title="<?php echo __("Grupo de aves en migración que permanecen descansando en un mismo sitio un tiempo."); ?>">
								<input name="data[Cita][sedimentado]" value="1"
									   type="checkbox" <?php if ($cita['Cita']['sedimentado'] == true) {
									echo "checked='checked'";
								} ?>> <?php echo __("Sedimentado"); ?>
							</label>
						</div>
						<div class="span5">
							<label class="checkbox">
								<input name="data[Cita][indHerido]" value="1"
									   type="checkbox" <?php if ($cita['Cita']['indHerido'] == true) {
									echo "checked='checked'";
								} ?>> <?php echo __("Cita de individuo herido, accidentado o muerto"); ?>
							</label>
							<label class="checkbox">
								<input name="data[Cita][indComportamiento]" value="1"
									   type="checkbox" <?php if ($cita['Cita']['indComportamiento'] == true) {
									echo "checked='checked'";
								} ?>> <?php echo __("Comportamiento o morfología curiosa"); ?>
							</label>
							<label class="checkbox">
								<input name="data[Cita][electrocutado]" value="1"
									   type="checkbox" <?php if ($cita['Cita']['electrocutado'] == true) {
									echo "checked='checked'";
								} ?>> <?php echo __("Electrocutado"); ?>
							</label>
							<label class="checkbox">
								<input name="data[Cita][atropellado]" value="1"
									   type="checkbox" <?php if ($cita['Cita']['atropellado'] == true) {
									echo "checked='checked'";
								} ?>> <?php echo __("Atropellado"); ?>
							</label>
						</div>
					</fieldset>

				</div>

				<!-- Ubicacion -->
				<div class="span6">
					<div class="contenedor_gris row-fluid">

						<!-- Lugar-->
						<div class="control-group">
							<label class="control-label" style="width: 60px;" for="lugar"> <?= __("Lugar"); ?>
								&nbsp;(*)</label>
							<div class="controls" style="margin-left: 80px; text-align: left;">
								<div class="dummy">
									<input type="text" id="lugar" name="lugar" style="width: 440px;"
										   value="<?= $cita['Lugar']['Lugar']['nombre'] . ", " . $cita['Lugar']['Municipio']['nombre'] . ", " . $cita['Lugar']['Comarca']['nombre'] . ", " . $cita['Lugar']['CuadriculaUtm']['codigo']; ?>"
										   placeholder="Escriba el nombre del lugar, municipio, comarca o cuadrícula UTM"/>
									<span class="badge badge-info" data-trigger="hover" data-placement="left"
										  data-content='<?= __("Escriba tres letras y seleccione un lugar del listado. También puede seleccionarlo a través de la tabla. Si no lo encuentra, puede crear uno nuevo."); ?>'><i
											class="icon-info-sign icon-white"></i> </span>
									<br>
									<div id="lugarSeleccionadoContenedor"
										 style="margin-top: 5px;">
										Lugar seleccionado:
										<span id="lugarSeleccionado" class="text-success" style="font-weight: bold;">
                                        <?= $cita['Lugar']['Lugar']['nombre'] . ", " . $cita['Lugar']['Municipio']['nombre'] . ", " . $cita['Lugar']['Comarca']['nombre'] . ", " . $cita['Lugar']['CuadriculaUtm']['codigo']; ?>
                                    </span>
									</div>
								</div>
								<div style="margin-top: 5px;">
									<button class="btnVaciarLugar btn btn-warning btn-mini" type="button">
										<i class="icon-trash" style="margin-right: 10px;"></i><?= __("Limpiar"); ?>
									</button>
                  <button id="btnSeleccionarLugarMapa" class="btn btn-mini btn-primary btnSeleccionarLugarMapa" type="button"><i class="icon-map-marker"></i> <?php echo __("Seleccionar desde mapa"); ?></button>

									<a href="#modalSeleccioanrLugar" role="button"
									   class="btn btn-mini btn-info" data-toggle="modal"
									   id="btnSeleccionarLugar"><i
											class="icon-zoom-in"></i> <?= __("Seleccionar desde tabla"); ?>
									</a>
									<button class="btn btn-mini btn-primary btnNuevoLugar" type="button">
										<i class="icon-plus"></i> <?= __("Nuevo lugar"); ?>
									</button>
								</div>
								<input type="hidden" id="lugarId" name="data[Cita][lugar_id]"
									   value="<?= $cita['Lugar']['Lugar']['id'] ?>">
							</div>
						</div>
						<div id="map_canvas_view" class="span12" style="height: 400px"></div>
					</div>
					<fieldset class="fsCustom" style="margin-top: 20px;">
						<legend>Observaciones</legend>
						<textarea id="observaciones" name="data[Cita][observaciones]"
								  rows="2" style="width: 100%;"><?= $cita['Cita']['observaciones']; ?></textarea>
					</fieldset>
				</div>

			</div>

			<fieldset class="fsCustom" style="margin-top: 20px;">
				<legend>Criterios de selección de la cita</legend>

				<div class="control-group">
					<label class="control-label width240 marginRight20"
						   for="cbxindSeleccionada"> <?= __("Cita seleccionada para el anuario"); ?></label>
					<div class="controls">
						<div class="dummy">
							<input name="data[Cita][indSeleccionada]" id="cbxindSeleccionada" value="1" type="checkbox"
								   disabled="disabled" <?php if ($cita['Cita']['indSeleccionada'] == "1") {
								echo "checked='checked'";
							} ?>>
						</div>
					</div>
				</div>
				<!-- Datos de reproducción -->
				<div class="control-group">
					<label class="control-label width240 marginRight20"
						   for="selectDatosReproduccion"> <?= __("Datos de reproducción"); ?>&nbsp;(*)</label>
					<div class="controls">
						<div class="dummy">
							<?php
							echo '<select name="data[Cita][clase_reproduccion_id]" id="selectDatosReproduccion">';
							$tiposCriaSeleccionados = array();
							$lastIdTipoCria = 0;
							foreach ($clasesReproduccion as $claseReproduccion) {

								$idTipoCria = $claseReproduccion['ClaseReproduccion']['idTipoCria'];
								if ($idTipoCria != $lastIdTipoCria) {
									$lastIdTipoCria = $idTipoCria;
									echo '</optgroup>';
								}
								if (!in_array($idTipoCria, $tiposCriaSeleccionados)) {
									echo '<optgroup label="' . $claseReproduccion['ClaseReproduccion']['tipoCria'] . '">';
									array_push($tiposCriaSeleccionados, $idTipoCria);
								}
								if ($claseReproduccion['ClaseReproduccion']['id'] == $cita['ClaseReproduccion']['id']) {
									echo '<option value="' . $claseReproduccion["ClaseReproduccion"]["id"] . '" selected="selected">' . $claseReproduccion["ClaseReproduccion"]["codigo"] . ' - ' . $claseReproduccion["ClaseReproduccion"]["descripcion"] . '</option>';
								} else {
									echo '<option value="' . $claseReproduccion["ClaseReproduccion"]["id"] . '">' . $claseReproduccion["ClaseReproduccion"]["codigo"] . ' - ' . $claseReproduccion["ClaseReproduccion"]["descripcion"] . '</option>';
								}
							}
							echo '</select>';
							?>
							<span class="badge badge-info" data-trigger="hover" data-placement="left"
								  data-content='<?= __("Seleccione el tipo de reproducción observado."); ?>'><i
									class="icon-info-sign icon-white"></i> </span>
						</div>
					</div>
				</div>
				<div class="control-group">
					<label
						class="control-label width240 marginRight20"> <?= __("Criterio de selección de la cita"); ?></label>
					<div class="controls">
						<div class="dummy">
							<span><?= $cita['CriterioSeleccionCita']['nombre']; ?></span>
						</div>
					</div>
				</div>

			</fieldset>

			<!-- Fotos -->
			<fieldset class="fsCustom" style="margin-top: 20px;">
				<legend>Fotos</legend>
				<div class="row">
					<div class="span3" style="border-right: 1px solid #E4E4E4;">
						<div>
							<p><?= __('Puedes añadir cuantas fotos quieras a la cita (de 6 en 6) seleccionándolas con los botones de abajo y pulsando <b>Guardar</b>.') ?></p>
							<p><?= __('Las fotos deben tener formato jpg, jpeg, png o gif y no pueden ocupar más de 2 megas') ?></p>
						</div>
						<br/>
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="fileupload-new thumbnail" style="width: 100px; height: 100px;">
							</div>
							<div class="fileupload-preview fileupload-exists thumbnail"
								 style="width: 100px; height: 100px;"></div>
							<span class="btn btn-file">
                            <span class="fileupload-new"><?= __('Seleccionar nueva foto') ?></span>
                            <span class="fileupload-exists"><?= __('Cambiar') ?></span>
                            <input type="file" name="fotos[]"/>
                        </span>
							<a href="#" class="btn fileupload-exists" data-dismiss="fileupload"><?= __('Quitar') ?></a>
						</div>
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="fileupload-new thumbnail" style="width: 100px; height: 100px;">
							</div>
							<div class="fileupload-preview fileupload-exists thumbnail"
								 style="width: 100px; height: 100px;"></div>
							<span class="btn btn-file">
                            <span class="fileupload-new"><?= __('Seleccionar nueva foto') ?></span>
                            <span class="fileupload-exists"><?= __('Cambiar') ?></span>
                            <input type="file" name="fotos[]"/>
                        </span>
							<a href="#" class="btn fileupload-exists" data-dismiss="fileupload"><?= __('Quitar') ?></a>
						</div>
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="fileupload-new thumbnail" style="width: 100px; height: 100px;">
							</div>
							<div class="fileupload-preview fileupload-exists thumbnail"
								 style="width: 100px; height: 100px;"></div>
							<span class="btn btn-file">
                            <span class="fileupload-new"><?= __('Seleccionar nueva foto') ?></span>
                            <span class="fileupload-exists"><?= __('Cambiar') ?></span>
                            <input type="file" name="fotos[]"/>
                        </span>
							<a href="#" class="btn fileupload-exists" data-dismiss="fileupload"><?= __('Quitar') ?></a>
						</div>
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="fileupload-new thumbnail" style="width: 100px; height: 100px;">
							</div>
							<div class="fileupload-preview fileupload-exists thumbnail"
								 style="width: 100px; height: 100px;"></div>
							<span class="btn btn-file">
                            <span class="fileupload-new"><?= __('Seleccionar nueva foto') ?></span>
                            <span class="fileupload-exists"><?= __('Cambiar') ?></span>
                            <input type="file" name="fotos[]"/>
                        </span>
							<a href="#" class="btn fileupload-exists" data-dismiss="fileupload"><?= __('Quitar') ?></a>
						</div>
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="fileupload-new thumbnail" style="width: 100px; height: 100px;">
							</div>
							<div class="fileupload-preview fileupload-exists thumbnail"
								 style="width: 100px; height: 100px;"></div>
							<span class="btn btn-file">
                            <span class="fileupload-new"><?= __('Seleccionar nueva foto') ?></span>
                            <span class="fileupload-exists"><?= __('Cambiar') ?></span>
                            <input type="file" name="fotos[]"/>
                        </span>
							<a href="#" class="btn fileupload-exists" data-dismiss="fileupload"><?= __('Quitar') ?></a>
						</div>
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="fileupload-new thumbnail" style="width: 100px; height: 100px;">
							</div>
							<div class="fileupload-preview fileupload-exists thumbnail"
								 style="width: 100px; height: 100px;"></div>
							<span class="btn btn-file">
                            <span class="fileupload-new"><?= __('Seleccionar nueva foto') ?></span>
                            <span class="fileupload-exists"><?= __('Cambiar') ?></span>
                            <input type="file" name="fotos[]"/>
                        </span>
							<a href="#" class="btn fileupload-exists" data-dismiss="fileupload"><?= __('Quitar') ?></a>
						</div>
					</div>
					<div class="span9">
						<ul class="thumbnails">
							<?php if (isset($cita['Fichero']) && count($cita['Fichero']) > 0): ?>

								<div>
									<p><?= __('Puedes eliminar fotos de la cita seleccionándolas con el botón <b>Quitar</b> y pulsando <b>Guardar</b>') ?></p>
								</div>
								<br/>

								<?php foreach ($cita['Fichero'] as $foto): ?>
									<li class="span2">
										<div class="thumbnail">
											<img src="<?= $foto['ruta'] . $foto['nombreFisico'] ?>"
												 alt="<?= $foto['descripcion'] ?>"/>
											<div class="caption text-center">
												<input type="hidden" class="foto-eliminar-<?= $foto['id'] ?>"
													   name="fotosEliminar[]" value="<?= $foto['id'] ?>"
													   disabled="disabled">
												<button type="button" class="btn btn-danger quitar-foto"
														data-id="<?= $foto['id'] ?>">
													<i class="icon-trash"
													   style="margin-right: 10px;"></i><?= __('Quitar') ?>
												</button>
											</div>
										</div>
									</li>
								<?php endforeach ?>
							<?php else: ?>
								<div class="thumbnail" style="width: 360px; height: 270px;">
									<img src="/img/messages/AAAAAA&text=No+hay+fotos_360x270.gif"/>
								</div>
							<?php endif ?>
						</ul>
					</div>
				</div>
			</fieldset>

			<br>

			<!-- Button (Double) -->
			<div class="text-center">
				<a id="btnGuardar" class="btn btn-success btn-large"><i class="icon-ok"></i> <?= __("Guardar"); ?></a>
			</div>

		</form>
	</fieldset>
</div>

<!-- SELECCIONAR LUGAR -->
<?= $this->element('Lugar/seleccionarLugar'); ?>
<?php echo $this->element('Lugar/seleccionarLugarMapa'); ?>

<!-- NUEVO LUGAR -->
<?= $this->element('Lugar/nuevoLugar'); ?>

<!-- NUEVO COLABORADOR -->
<?= $this->element('ObservadorSecundario/nuevoObservadorSecundario'); ?>

<!-- Pie -->
<?php
$this->start('pie');
echo $this->element('/pie');
$this->end();
?>
