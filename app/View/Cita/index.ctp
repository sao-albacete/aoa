<?php

// Informamos el título
$this->set('title_for_layout', 'Búsqueda de citas');

/**
 * CSS
 */
$this->Html->css([
	'datatables-bootstrap',
	'Cita/index'
], null, ['inline' => false]);

/**
 * Javascript
 */
$this->Html->script([
	'pleaseWaitDialog',
	'common/Lugar/funciones',
	'common/ObservadorPrimario/funciones',
	'common/ObservadorSecundario/funciones',
	'Cita/index'
], ['inline' => false]);

// Menu
$this->start('menu');
echo $this->element('/menu');
$this->end();
?>

<script type="text/javascript">
	$(document).ready(function () {

		var $selectFiguraProteccion = $('#selectFiguraProteccion');

		/* INICIO Carga de valores seleccionados de los combos */
		$("#selectOrdenTaxonomico").val("<?php if (isset($valuesSubmited['ordenTaxonomico'])) {
			echo $valuesSubmited['ordenTaxonomico'];
		}?>");
		$("#selectFamilia").val("<?php if (isset($valuesSubmited['familia'])) {
			echo $valuesSubmited['familia'];
		}?>");
		$selectFiguraProteccion.val("<?php if (isset($valuesSubmited['figuraProteccion'])) {
			echo $valuesSubmited['figuraProteccion'];
		}?>");
		$("#selectComarca").val("<?php if (isset($valuesSubmited['comarcaId'])) {
			echo $valuesSubmited['comarcaId'];
		}?>");
		$("#selectMunicipio").val("<?php if (isset($valuesSubmited['municipioId'])) {
			echo $valuesSubmited['municipioId'];
		}?>");
		$("#selectCuadriculaUtm").val("<?php if (isset($valuesSubmited['cuadriculaUtmId'])) {
			echo $valuesSubmited['cuadriculaUtmId'];
		}?>");
		$("#lugar").val("<?php if (isset($valuesSubmited['lugar'])) {
			echo $valuesSubmited['lugar'];
		}?>");
		$("#lugarId").val("<?php if (isset($valuesSubmited['lugarId'])) {
			echo $valuesSubmited['lugarId'];
		}?>");
		$("#selectClaseReproduccion").val("<?php if (isset($valuesSubmited['claseReproduccionId'])) {
			echo $valuesSubmited['claseReproduccionId'];
		}?>");
		$("#observador").val("<?php if (isset($valuesSubmited['observador'])) {
			echo $valuesSubmited['observador'];
		}?>");
		$("#observadorSeleccionado").val("<?php if (isset($valuesSubmited['observadorId'])) {
			echo $valuesSubmited['observadorId'];
		}?>");
		$("#colaborador").val("<?php if (isset($valuesSubmited['colaborador'])) {
			echo $valuesSubmited['colaborador'];
		}?>");
		$("#colaboradorSeleccionado").val("<?php if (isset($valuesSubmited['colaboradorId'])) {
			echo $valuesSubmited['colaboradorId'];
		}?>");
		$("#selectEstudio").val("<?php if (isset($valuesSubmited['estudioId'])) {
			echo $valuesSubmited['estudioId'];
		}?>");
		/* Fin Carga de valores seleccionados de los combos */

		// Fecha desde
		$("#fechaDesde").datepicker({
			yearRange: "<?=$anios[count($anios) - 1][0]['anio'];?>:<?=date("Y");?>",
			changeMonth: true,
			changeYear: true,
			maxDate: 0,
			onClose: function (selectedDate) {
				$("#fechaHasta").datepicker("option", "minDate", selectedDate);
			}
		});
		// Fecha fin
		$("#fechaHasta").datepicker({
			yearRange: "<?=$anios[count($anios) - 1][0]['anio'];?>:<?=date("Y");?>",
			changeMonth: true,
			changeYear: true,
			maxDate: 0,
			onClose: function (selectedDate) {
				$("#fechaDesde").datepicker("option", "maxDate", selectedDate);
			}
		});

		// Figura proteccion
		var figuraProteccion = $selectFiguraProteccion.find(':selected').val();
		var nivelProteccion = "<?php if (isset($valuesSubmited['nivelProteccion'])) {
			echo $valuesSubmited['nivelProteccion'];
		}?>";
		cargarNivelesProteccion(figuraProteccion, nivelProteccion);

		$selectFiguraProteccion.change(function (event) {
			figuraProteccion = $("#selectFiguraProteccion").find(':selected').val();
			cargarNivelesProteccion(figuraProteccion);
		});
	});

</script>

<!-- Cuerpo -->
<div>
	<fieldset>
		<legend>
			<?= __('Búsqueda de citas'); ?>
		</legend>

		<div class="tabbable">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#que" data-toggle="tab"><?= __("¿Qué?") ?></a></li>
				<li><a href="#donde" data-toggle="tab"><?= __("¿Dónde?") ?> </a></li>
				<li><a href="#cuando" data-toggle="tab"><?= __("¿Cuándo?") ?></a></li>
				<li><a href="#quien" data-toggle="tab"><?= __("¿Quién?") ?></a></li>
				<li><a href="#indicadores" data-toggle="tab"><?= __("Indicadores") ?></a></li>
			</ul>

			<form method="get" id="frmBusqueda">

				<div id="divFiltrosBusqueda" class="tab-content">

					<!-- Que -->
					<div class="tab-pane active" id="que">

						<!-- Especie -->
						<div class="row">
							<div class="span12">
								<label class="control-label" for="especie"> <?= __("Especie"); ?></label>
								<input id="especie" name="especie" class="input-xxlarge"
									   type="text"
									   value="<?php if (isset($valuesSubmited['especie'])) {
										   echo $valuesSubmited['especie'];
									   } ?>"
									   placeholder="<?= __('Escriba el nombre común o el nombre científico'); ?>">
								<input type="hidden" id="especieId" name="especieId"
									   value="<?php if (isset($valuesSubmited['especieId'])) {
										   echo $valuesSubmited['especieId'];
									   } ?>">
							</div>
						</div>


						<div class="row">
							<div class="span2" style="min-width: 250px;">
								<!-- Orden taxonomico -->
								<label class="control-label"
									   for="selectOrdenTaxonomico"><?= __("Orden taxonómico"); ?></label>
								<select id="selectOrdenTaxonomico" name="ordenTaxonomico"
										class="input-large">
									<option value=""><?= __("-- Seleccione --"); ?></option>
									<?php foreach ($ordenesTaxonomicos as $ordenTaxonomico) : ?>
										<option
											value="<?= $ordenTaxonomico["OrdenTaxonomico"]["id"] ?>"><?= $ordenTaxonomico["OrdenTaxonomico"]["nombre"] ?></option>
									<?php endforeach ?>
								</select>
							</div>
							<div class="span10" style="margin-left: 0;">
								<!-- Familia -->
								<label class="control-label" for="selectFamilia"><?= __("Familia"); ?></label>
								<select id="selectFamilia" name="familia" class="input-large">
									<option value=""><?= __("-- Seleccione --"); ?></option>
									<?php foreach ($familias as $familia) : ?>
										<option
											value="<?= $familia["Familia"]["id"] ?>"><?= $familia["Familia"]["nombre"] ?></option>;
									<?php endforeach ?>
								</select>
							</div>
						</div>

						<div class="row">
							<div class="span2" style="min-width: 250px;">
								<!-- Figura protección -->
								<label class="control-label"
									   for="selectFiguraProteccion"><?= __("Figura de protección"); ?></label>
								<select id="selectFiguraProteccion" name="figuraProteccion"
										class="input-large">
									<option value=""><?= __("-- Seleccione --"); ?></option>
									<option value="catalogoRegional"><?= __("Catálogo Regional"); ?></option>
									<option value="libroRojo"><?= __("Libro Rojo de España"); ?></option>
									<option value="estatusAlbacete"><?= __("Estatus en Albacete"); ?></option>
								</select>
							</div>
							<div class="span10" style="margin-left: 0; margin-top: 20px;">
								<select id="selectNivelProteccion"
										name="nivelProteccion" class="input-xlarge" disabled="disabled">
								</select>
							</div>
						</div>

						<!-- Clase reproducción -->
						<div class="row">
							<div class="span12">
								<label class="control-label"
									   for="selectClaseReproduccion"><?= __("Clase de reproducción"); ?></label>
								<select id="selectClaseReproduccion" name="claseReproduccionId"
										class="input-xxlarge">
									<option value=""><?= __("-- Seleccione --"); ?></option>
									<?php
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
										echo '<option value="' . $claseReproduccion["ClaseReproduccion"]["id"] . '">' . $claseReproduccion["ClaseReproduccion"]["codigo"] . ' - ' . $claseReproduccion["ClaseReproduccion"]["descripcion"] . '</option>';
									}
									?>
								</select>
							</div>
						</div>
						<!-- Estudio -->
						<div class="row">
							<div class="span12">
								<label class="control-label" for="estudioId"> <?php echo __("Estudio"); ?></label>
								<select id="selectEstudio" name="estudioId" class="input-xxlarge">
									<option value=""><?= __("-- Seleccione --"); ?></option>
									<?php foreach ($estudios as $estudio) : ?>
										<option
											value='<?= $estudio["Estudio"]["id"] ?>'><?= $estudio["Estudio"]["descripcion"] ?></option>
									<?php endforeach ?>
								</select>
							</div>
						</div>

					</div>
					<!-- Donde -->
					<div class="tab-pane" id="donde">

						<div class="row">
							<div class="span2" style="min-width: 265px;">
								<!-- Comarca -->
								<label class="control-label" for="selectComarca"><?= __("Comarca"); ?></label>
								<select id="selectComarca" name="comarcaId" class="input-xlarge">
									<option value=""><?= __("-- Seleccione --"); ?></option>
									<?php
									foreach ($comarcas as $comarca) {
										echo '<option value="' . $comarca["Comarca"]["id"] . '">' . $comarca["Comarca"]["nombre"] . '</option>';
									}
									?>
								</select>
							</div>
							<div class="span2" style="min-width: 265px;">
								<!-- Municipio -->
								<label class="control-label" for="selectMunicipio"><?= __("Municipio"); ?> </label>
								<select id="selectMunicipio" name="municipioId" class="input-xlarge">
									<option value=""><?= __("-- Seleccione --"); ?></option>
									<?php
									foreach ($municipios as $municipio) {
										echo '<option value="' . $municipio["Municipio"]["id"] . '">' . $municipio["Municipio"]["nombre"] . '</option>';
									}
									?>
								</select>
							</div>
							<div class="span2" style="min-width: 265px;">
								<!-- Cuadricula UTM -->
								<label class="control-label"
									   for="selectCuadriculaUtm"><?= __("Cuadrícula UTM"); ?></label>
								<select id="selectCuadriculaUtm" name="cuadriculaUtmId"
										class="input-large">
									<option value=""><?= __("-- Seleccione --"); ?></option>
									<?php
									foreach ($cuadriculasUtm as $cuadriculaUtm) {
										echo '<option value="' . $cuadriculaUtm["CuadriculaUtm"]["id"] . '">' . $cuadriculaUtm["CuadriculaUtm"]["codigo"] . '</option>';
									}
									?>
								</select>
							</div>
						</div>

						<div class="row">
							<div class="span12">
								<!-- Lugar -->
								<label class="control-label" for="lugar"><?= __("Lugar"); ?></label>
								<input type="text" id="lugar" name="lugar" class="input-xxlarge"
									   placeholder="Escriba el nombre del lugar"/>
								<input type="hidden" id="lugarId" name="lugarId">
							</div>
						</div>
					</div>
					<!-- Cuándo -->
					<div class="tab-pane" id="cuando">
						<!-- Intervalo fechas -->
						<div class="controls">
							<label class="control-label" for="fechaDesde"><?= __("Fecha desde"); ?></label>
							<div class="input-append">
								<input type="text"
									   value="<?php if (isset($valuesSubmited['fechaDesde'])) {
										   echo $valuesSubmited['fechaDesde'];
									   } ?>"
									   id="fechaDesde" name="fechaDesde" size="10" class="date-picker"
									   style="width: auto;" placeholder="Desde"/> <label
									style="width: 0; margin-left: 0;" for="fechaDesde"
									class="add-on"><i class="icon-calendar"></i></label>
							</div>
							<label class="control-label" style="width: 40px;"
								   for="fechaDesde"><?= __("hasta"); ?></label>
							<div class="input-append">
								<input type="text"
									   value="<?php if (isset($valuesSubmited['fechaHasta'])) {
										   echo $valuesSubmited['fechaHasta'];
									   } ?>"
									   id="fechaHasta" name="fechaHasta" size="10" class="date-picker"
									   style="width: auto;" placeholder="Hasta"/> <label
									style="width: 0; margin: 0;" for="fechaHasta" class="add-on"><i
										class="icon-calendar"></i></label>
							</div>
						</div>
					</div>
					<!-- Quién -->
					<div class="tab-pane" id="quien">
						<!-- Observador -->
						<div class="control-group">
							<div class="controls">
								<label class="control-label" for="observador"><?= __("Observador"); ?></label>
								<input id="observador" name="observador" class="input-xxlarge"
									   type="text"
									   placeholder="Escriba el código o el nombre del observador">
								<input type="hidden" id="observadorSeleccionado"
									   name="observadorId"/>
							</div>
						</div>
						<!-- Colaborador -->
						<div class="control-group">
							<div class="controls">
								<label class="control-label" for="colaborador"><?= __("Colaborador"); ?></label>
								<input id="colaborador" name="colaborador" class="input-xxlarge"
									   type="text"
									   placeholder="Escriba el código o el nombre del colaborador">
								<input type="hidden" id="colaboradorSeleccionado" name="colaboradorId"/>
							</div>
						</div>
					</div>
					<!-- Indicadores -->
					<div class="tab-pane" id="indicadores">
						<div class="control-group">
							<div class="controls row-fluid">
								<div class="span2">
									<label class="checkbox">
										<input id="indHabitatRaro" name="indHabitatRaro" value="1"
											   type="checkbox" <?php if ($valuesSubmited['indHabitatRaro'] == true) {
											echo "checked='checked'";
										} ?>> <?php echo __("Especie vista en habitat atípico"); ?>
									</label>
									<label class="checkbox">
										<input id="indCriaHabitatRaro" name="indCriaHabitatRaro" value="1"
											   type="checkbox" <?php if ($valuesSubmited['indCriaHabitatRaro'] == true) {
											echo "checked='checked'";
										} ?>> <?php echo __("Reproducción en un hábitat atípico"); ?>
									</label>
									<label class="checkbox">
										<input id="dormidero" name="dormidero" value="1"
											   type="checkbox" <?php if ($valuesSubmited['dormidero'] == true) {
											echo "checked='checked'";
										} ?>> <?php echo __("En dormidero"); ?>
									</label>
									<label class="checkbox">
										<input id="colonia_de_cria" name="colonia_de_cria" value="1"
											   type="checkbox" <?php if ($valuesSubmited['colonia_de_cria'] == true) {
											echo "checked='checked'";
										} ?>> <?php echo __("Colonia de cría"); ?>
									</label>
									<label class="checkbox">
										<input id="migracion_activa" name="migracion_activa" value="1"
											   type="checkbox" <?php if ($valuesSubmited['migracion_activa'] == true) {
											echo "checked='checked'";
										} ?>> <?php echo __("Migración activa"); ?>
									</label>
									<label class="checkbox" title="<?php echo __("Grupo de aves en migración que permanecen descansando en un mismo sitio un tiempo."); ?>">
										<input id="sedimentado" name="sedimentado" value="1"
											   type="checkbox" <?php if ($valuesSubmited['sedimentado'] == true) {
											echo "checked='checked'";
										} ?>> <?php echo __("Sedimentado"); ?>
									</label>
								</div>
								<div class="span3">
									<label class="checkbox">
										<input id="indHerido" name="indHerido" value="1"
											   type="checkbox" <?php if ($valuesSubmited['indHerido'] == true) {
											echo "checked='checked'";
										} ?>> <?php echo __("Cita de individuo herido, accidentado o muerto"); ?>
									</label>
									<label class="checkbox">
										<input id="indComportamiento" name="indComportamiento" value="1"
											   type="checkbox" <?php if ($valuesSubmited['indComportamiento'] == true) {
											echo "checked='checked'";
										} ?>> <?php echo __("Comportamiento o morfología curiosa"); ?>
									</label>
									<label class="checkbox">
										<input id="electrocutado" name="electrocutado" value="1"
											   type="checkbox" <?php if ($valuesSubmited['electrocutado'] == true) {
											echo "checked='checked'";
										} ?>> <?php echo __("Electrocutado"); ?>
									</label>
									<label class="checkbox">
										<input id="atropellado" name="atropellado" value="1"
											   type="checkbox" <?php if ($valuesSubmited['atropellado'] == true) {
											echo "checked='checked'";
										} ?>> <?php echo __("Atropellado"); ?>
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>

				<hr>

				<!-- Botones de búsqueda -->
				<div id="divBotonesBusqueda" class="control-group">
					<div class="controls">
						<button id="btnLimpiar" class="btn btn-warning"><?php echo __("Limpiar") ?>&nbsp;<i
								class="icon-trash icon-white"></i></button>
						<button id="btnBuscar" class="btn btn-success btn-large"><?php echo __("Buscar") ?>&nbsp;<i
								class="icon-search icon-white"></i></button>
						<!--                    <button id="btnExportar" class="btn btn-success btn-info">-->
						<?php //echo __("Exportar")?><!--&nbsp;<i class="icon-download-alt icon-white"></i></button>-->
						<input type="submit" id="btnExportar" class="btn btn-info" name="exportarAExcel"
							   value="<?= __("Exportar"); ?>"/>
					</div>
				</div>
			</form>
		</div>

		<?php
		$this->Paginator->options([
			'update' => '#content',
			'before' => $this->Js->get('#pleaseWaitDialog')->effect(
				'fadeIn',
				['buffer' => false]
			),
			'complete' => $this->Js->get('#pleaseWaitDialog')->effect(
				'fadeOut',
				['buffer' => false]
			)
		]);
		?>

		<?php if (isset($citas)) : ?>

			<fieldset>

				<div class="modal hide" id="pleaseWaitDialog" data-backdrop="static"
					 data-keyboard="false">
					<div class="modal-header">
						<h4><?= __("Por favor, espere..."); ?></h4>
					</div>
					<div class="modal-body">
						<div class="progress progress-striped active">
							<div class="bar" style="width: 100%;"></div>
						</div>
					</div>
				</div>

				<legend class="small"><?= __("Citas encontradas"); ?></legend>

				<table id="tabla_citas"
					   class="table table-striped table-bordered table-hover table-condensed">
					<thead>
					<tr>
						<th><?= __("Ver más"); ?></th>
						<th><?= $this->Paginator->sort("ImportanciaCita.codigo", __("Importancia")); ?></th>
						<th><?= $this->Paginator->sort("Cita.indFoto", "Fotos"); ?></th>
						<th><?= $this->Paginator->sort("Especie.nombreComun", "Especie"); ?></th>
						<th><?= $this->Paginator->sort("fechaAlta", "Fecha"); ?></th>
						<th><?= __("Hora"); ?></th>
						<th><?= $this->Paginator->sort("Lugar.nombre", "Lugar"); ?></th>
						<th><?= $this->Paginator->sort("cantidad", "Número de Aves"); ?></th>
						<th><?= $this->Paginator->sort("ObservadorPrincipal.codigo", "Observador"); ?></th>
						<th><?= __("Colaboradores"); ?></th>
						<th><?= $this->Paginator->sort("ClaseReproduccion.codigo", "Clase de Reproducción"); ?></th>
						<th><?= $this->Paginator->sort("CriterioSeleccionCita.codigo", "Criterio de Selección"); ?></th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($citas as $cita): ?>
						<tr>
							<td style="text-align: center;"><a href="/cita/view/id:<?= $cita['Cita']['id'] ?>"
															   title="<?= __("Más información") ?>"><img
										src="/img/icons/search.png" title="Ver detalle de la cita"
										alt="Ver detalle"/></a></td>
							<td style="text-align:center;"><?= $this->Importancia->getIconoImportancia($cita['ImportanciaCita']['id'], $cita['ImportanciaCita']['descripcion']) ?></td>
							<td style="text-align:center;"><?= ($cita['Cita']['indFoto'] ? '<img src="/img/icons/camera.png" alt="Tiene fotos" title="Tiene fotos"/>' : '') ?></td>
							<td><a href="/cita/index?especieId=<?= $cita['Especie']['id'] ?>"
								   title="<?= $cita['Especie']['genero'] . ' ' . $cita['Especie']['especie'] . ' ' . $cita['Especie']['subespecie'] ?>"><?= $cita['Especie']['nombreComun'] . ' ' . $cita['Especie']['subespecie'] ?></a>
							</td>
							<td style="text-align: center;"><a
									href="/cita/index?fechaAlta=<?= date_format(date_create($cita['Cita']['fechaAlta']), "d/m/Y") ?>"><?= date_format(date_create($cita['Cita']['fechaAlta']), "d/m/Y") ?></a>
							</td>
							<td style="text-align: center;"><?= date("H:i", strtotime($cita['Cita']['fechaAlta'])) ?></td>

							<?php if ($cita['Cita']['indPrivacidad'] == 1 || (isset($usuario) && ($usuario['observador_principal_id'] == $cita['Cita']['observador_principal_id'] || $usuario['perfil_id'] == 1))) : ?>
							<td><a href="/cita/index?lugarId=<?= $cita['Lugar']['id'] ?>"
								   title="<?= $this->Lugar->mostrarDetalleLugar($cita) ?>"><?= ucwords($cita['Lugar']['nombre']) ?></a>
								<?php else : ?>
							<td><span title="<?= $this->Lugar->mostrarDetalleLugar($cita) ?>"><img width="16"
																								   height="16"
																								   style="margin-right: 10px;"
																								   alt="alert icon"
																								   src="/img/icons/fugue-icons-3.5.6/icons/exclamation-red.png"> Lugar confidencial</span>
								<?php endif ?>

							<td style="text-align: center;"><span
									title="<?= $this->ClaseEdadSexo->mostrar_detalle_clase_edad_sexo($cita['clases_edad_sexo']) ?>"><?= $cita['Cita']['cantidad'] ?></span>
							</td>
							<td style="text-align: center;"><a
									href="/cita/index?observadorId=<?= $cita['ObservadorPrincipal']['id'] ?>"
									title="<?= $cita['ObservadorPrincipal']['nombre'] ?>"><?= $cita['ObservadorPrincipal']['codigo'] ?></a>
							</td>
							<td><?= $this->ObservadorSecundario->mostrar_codigos_observadores($cita['observadoresSecundarios']) ?></td>
							<td style="text-align: center;"><a
									href="/cita/index?claseReproduccionId=<?= $cita['ClaseReproduccion']['id'] ?>"
									title="<?= $cita['ClaseReproduccion']['descripcion'] ?>"><?= $cita['ClaseReproduccion']['codigo'] ?></a>
							</td>
							<td style="text-align: center;"><span
									title="<?= $cita['CriterioSeleccionCita']['nombre'] ?>"><?= $cita['CriterioSeleccionCita']['codigo'] ?></span>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
					<tfoot>
					<tr>
						<th><?= __("Ver más"); ?></th>
						<th><?= $this->Paginator->sort("ImportanciaCita.codigo", __("Importancia")); ?></th>
						<th><?= $this->Paginator->sort("Cita.indFoto", "Fotos"); ?></th>
						<th><?= $this->Paginator->sort("Especie.nombreComun", "Especie"); ?></th>
						<th><?= $this->Paginator->sort("fechaAlta", "Fecha"); ?></th>
						<th><?= __("Hora"); ?></th>
						<th><?= $this->Paginator->sort("Lugar.nombre", "Lugar"); ?></th>
						<th><?= $this->Paginator->sort("cantidad", "Número de Aves"); ?></th>
						<th><?= $this->Paginator->sort("ObservadorPrincipal.codigo", "Observador"); ?></th>
						<th><?= __("Colaboradores"); ?></th>
						<th><?= $this->Paginator->sort("ClaseReproduccion.codigo", "Clase de Reproducción"); ?></th>
						<th><?= $this->Paginator->sort("CriterioSeleccionCita.codigo", "Criterio de Selección"); ?></th>
					</tr>
					</tfoot>
				</table>

				<?= $this->Paginator->counter('Mostrando {:start} de {:end} registros de un total de {:count}'); ?>

				<div class="pagination pagination-right">
					<?= $this->Paginator->first('Primera', null, null, array('class' => 'disable')); ?>
					<?= $this->Paginator->prev('← Anterior', null, null, array('class' => 'disable')); ?>
					<?= $this->Paginator->numbers(array('separator' => '')); ?>
					<?= $this->Paginator->next('Siguiente → ', null, null, array('class' => 'disable')); ?>
					<?= $this->Paginator->last('Última', null, null, array('class' => 'disable')); ?>
				</div>

			</fieldset>

		<?php else : ?>

			<fieldset>
				<legend><?= __("No se han encontrado citas."); ?></legend>
			</fieldset>

		<?php endif; ?>

	</fieldset>
</div>

<!-- Pie -->
<?php
$this->start('pie');
echo $this->element('/pie');
$this->end();
?>

<?= $this->Js->writeBuffer(); ?>
