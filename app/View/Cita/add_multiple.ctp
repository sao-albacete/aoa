<?php
// Informamos el título
$this->set('title_for_layout', 'Nueva cita múltiple');

/**
 * CSS
 */
$this->Html->css(array(
    'datatables-bootstrap',
	'/plugin/jquery-timepicker-1.3.5/jquery.timepicker.min.css',
	'/plugin/summernote-0.8.16-dist/summernote.min.css',
    'Cita/add_multiple'
), null, array('inline' => false));

/**
 * Javascript
 */
$this->Html->script(array(
    '/plugin/jquery-validation-1.11.1/dist/jquery.validate.min',
    '/plugin/jquery-validation-1.11.1/dist/additional-methods.min',
    '/plugin/jquery-validation-1.11.1/localization/messages_es',
    '/plugin/DataTables-1.9.4/media/js/jquery.dataTables',
	'/plugin/jquery-timepicker-1.3.5/jquery.timepicker.min.js',
    'datatables-bootstrap',
    '/plugin/bootbox/bootbox.min',
	'/plugin/summernote-0.8.16-dist/summernote.min.js',
	'/plugin/summernote-0.8.16-dist/lang/summernote-es-ES.min.js',
    'common/Especie/funciones',
    'common/Lugar/funciones',
    'common/Cita/funciones',
    'common/ObservadorPrimario/funciones',
    'common/ObservadorSecundario/funciones',
    'Cita/add_multiple'
), array('inline' => false));

// Menu
$this->start('menu');
echo $this->element('/menu');
$this->end();
?>

<!-- Cuerpo -->
<div id="divNuevaCitaMultiple">
    <fieldset>
        <legend><?php echo __('Nueva cita múltiple'); ?></legend>

        <div class="well well-small">
            Los campos marcados con un asterisco (*) son obligatorios.
        </div>

        <div id="errorMessages" class="alert alert-error" style="display: none; padding-left: 14px;">
            <h5>Por favor, corrija los errores en el formulario:</h5>
            <ul></ul>
        </div>

        <form id="frmNuevaCitaMultiple" class="form-horizontal" method="post">

            <!-- Fecha alta-->
            <div class="control-group">
                <label class="control-label" for="fechaAlta"> <?php echo __("Fecha"); ?> (*)</label>

                <div class="controls">
                    <div class="input-prepend">
                        <label for="fechaAlta" class="add-on"><i class="icon-calendar"></i>
                        </label> <input type="text" id="fechaAlta"
                                        name="data[Cita][fechaAlta]" size="10" class="date-picker"
                                        data-mask="99/99/9999" style="width: auto;"
                                        placeholder="dd/mm/aaaa"/>
                        <span class="badge badge-info"
                              title="<?php echo __('Seleccione un día pulsando el calendario o escriba una fecha con formato ') . date('d/m/Y') ?>"><i
                                class="icon-info-sign icon-white"></i> </span>
                    </div>
                </div>
            </div>

			<!-- Hora alta -->
			<div class="control-group">
				<label class="control-label" for="horaAltaGeneral"> <?php echo __("Hora"); ?> (*)</label>

				<div class="controls">
					<div class="input-prepend">
						<label for="horaAltaGeneral" class="add-on"><i class="icon-time"></i></label>
						<input type="text" id="horaAltaGeneral"
							   name="data[Cita][horaAlta]" size="10" class="time-picker hora-alta"
							   data-mask="99:99" style="width: auto;"
							   placeholder="hh:mm"/>
						<span class="badge badge-info"
							  title="<?php echo __('Seleccione la hora desde el desplegable o escriba una hora con formato hh:mm') ?>"><i
								class="icon-info-sign icon-white"></i> </span>
					</div>
				</div>
			</div>

            <!-- Lugar-->
            <div class="control-group">
                <label class="control-label" for="lugar"> <?php echo __("Lugar"); ?> (*)</label>

                <div class="controls">
                    <div class="dummy">
                        <input type="text" id="lugar" name="lugar" class="input-xxlarge"
                               placeholder="Escriba el nombre del lugar, municipio, comarca o cuadrícula UTM"/>
                        <span class="badge badge-info"
                              title='<?php echo __("Escriba tres letras y seleccione un lugar del listado. También puede seleccionarlo a través de la tabla. Si no lo encuentra, puede crear uno nuevo."); ?>'><i
                                class="icon-info-sign icon-white"></i> </span>

                        <div id="lugarSeleccionadoContenedor" style="margin-top: 5px; display: none;">
                            <?php echo __("Lugar seleccionado"); ?>:
                            <span id="lugarSeleccionado" class="text-success" style="font-weight: bold;"></span>
                        </div>
                    </div>
                    <div style="margin-top: 5px;">
                        <button class="btn btn-warning btn-mini btnVaciarLugar" type="button"><i class="icon-trash" style="margin-right: 10px;"></i><?php echo __("Limpiar"); ?></button>
                        <a href="#modalSeleccioanrLugar" role="button"
                           class="btn btn-mini btn-info" data-toggle="modal"
                           id="btnSeleccionarLugar"><i class="icon-zoom-in"></i> <?php echo __("Seleccionar desde tabla"); ?>
                        </a>
                        <button class="btn btn-mini btn-primary btnNuevoLugar" type="button"><i class="icon-plus"></i> <?php echo __("Nuevo lugar"); ?></button>
                    </div>
                    <input type="hidden" id="lugarId" name="data[Cita][lugar_id]">
                </div>
            </div>

            <!-- Observadores -->
            <div class="control-group">
                <label class="control-label" for="observadores"> <?php echo __("Observadores"); ?> (*)</label>

                <div class="controls">
                    <div class="dummy">
                        <input id="observador" name="observador" class="input-xxlarge" type="text"
                               placeholder="Escriba el código o el nombre del observador">
                        <span class="badge badge-info"
                              title='<?php echo __("Escriba al menos tres letras y seleccione de la lista los observadores que quiera incluir en la cita."); ?>'><i
                                class="icon-info-sign icon-white"></i> </span>

                        <div id="observadorSeleccionadoDiv" style="margin-top: 5px;">
                            <?php echo __("Observador seleccionado"); ?>:
                            <span id="observadorSeleccionadoTexto" class="text-success"
                                  style="font-weight: bold;"><?php echo $usuario['ObservadorPrincipal']['codigo'] . " - " . $usuario['ObservadorPrincipal']['nombre']; ?></span>
                        </div>
                        <input type="hidden" id="observadorSeleccionado"
                               value="<?php echo $usuario['ObservadorPrincipal']['id']; ?>"
                               name="data[Cita][observador_principal_id]"/>
                    </div>
                </div>
            </div>

            <!-- Colaboradores -->
            <div class="control-group">
                <label class="control-label" for="colaboradores"> <?php echo __("Colaboradores"); ?></label>

                <div class="controls">
                    <div class="dummy">
                        <input id="colaboradores" name="colaboradores" class="input-xxlarge"
                               type="text"
                               placeholder="Escriba el código o el nombre del colaborador">
                        <span class="badge badge-info"
                              title='<?php echo __("Escriba al menos tres letras y seleccione de la lista los colaboradores que quiera incluir en la cita."); ?>'><i
                                class="icon-info-sign icon-white"></i> </span>

                        <div id="colaboradoresSeleccionadosDiv"
                             style="margin-top: 5px; display: none;">
                            <?php echo __("Colaboradores seleccionados"); ?>:
                            <span id="colaboradoresSeleccionadosTexto" class="text-success"
                                  style="font-weight: bold;"></span>
                        </div>
                        <input type="hidden" id="colaboradoresSeleccionados" name="colaboradoresSeleccionados"/>

                        <div style="margin-top: 5px;">
                            <button class="btn btn-warning btn-mini" type="button" id="btnVaciarColaboradores">
                                <i class="icon-trash" style="margin-right: 10px;"></i><?php echo __("Limpiar"); ?>
                            </button>
                            <button class="btn btn-mini btn-primary btnNuevoColaborador" type="button"><i class="icon-plus"></i> <?php echo __("Nuevo colaborador"); ?></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fuente -->
            <div class="control-group">
                <label class="control-label" for="fuente"> <?php echo __("Fuente"); ?></label>

                <div class="controls">
                    <select id="fuenteId" name="data[Cita][fuente_id]" class="input-xlarge">
                        <option value=""></option>
                        <?php
                        foreach ($fuentes as $fuente) {
                            if ($fuente["Fuente"]["id"] == 1) {
                                echo "<option value='" . $fuente["Fuente"]["id"] . "' selected='selected'>" . $fuente["Fuente"]["nombre"] . "</option>";
                            } else {
                                echo "<option value='" . $fuente["Fuente"]["id"] . "'>" . $fuente["Fuente"]["nombre"] . "</option>";
                            }
                        }
                        ?>
                    </select>
                    <span class="badge badge-info"
                          title='<?php echo __("Seleccione la fuente de la que proviene la cita."); ?>'><i
                            class="icon-info-sign icon-white"></i> </span>
                </div>
            </div>

            <!-- Estudio -->
            <div class="control-group">
                <label class="control-label" for="estudio"> <?php echo __("Estudio"); ?></label>

                <div class="controls">
                    <select id="estudioId" name="data[Cita][estudio_id]" class="input-xxlarge">
                        <option value=""></option>
                        <?php
                        foreach ($estudios as $estudio) {
                            if ($estudio["Estudio"]["id"] == 1) {
                                echo "<option value='" . $estudio["Estudio"]["id"] . "' selected='selected'>" . $estudio["Estudio"]["descripcion"] . "</option>";
                            } else {
                                echo "<option value='" . $estudio["Estudio"]["id"] . "'>" . $estudio["Estudio"]["descripcion"] . "</option>";
                            }
                        }
                        ?>
                    </select>
                    <span class="badge badge-info"
                          title='<?php echo __("Seleccione el tipo de estudio asociado a la cita."); ?>'><i
                            class="icon-info-sign icon-white"></i> </span>
                </div>
            </div>

            <input type="hidden" id="hdnEspecies" name="hdnEspecies"/>
            <table id="tablaEspecies" class="table table-bordred table-striped table-hover table-condensed">
                <caption><?php echo __('Especies'); ?></caption>
                <thead>
                    <tr>
                        <th style="text-align: left"><?php echo __('Especie'); ?></th>
                        <th style="text-align: left"><?php echo __('Nº de aves'); ?></th>
						<th style="text-align: left"><?php echo __('Hora'); ?></th>
                        <th style="text-align: left"><?php echo __('Acciones'); ?></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="100%">
                            <a role="button" class="btn btn-small btn-primary" id="btnInsertarEspecie">
                                <i class="icon-plus"></i> <?php echo __("Añadir especie"); ?>
                            </a>
                        </th>
                    </tr>
                </tfoot>
            </table>

            <br/>

            <!-- Button (Double) -->
            <div class="control-group">
                <div class="controls text-center">
                    <a id="btnGuardar" class="btn btn-success btn-large"><i class="icon-ok"></i> <?php echo __("Guardar"); ?></a>
                </div>
            </div>

        </form>

    </fieldset>
</div>

<!-- NUEVA FILA ESPECIE -->
<div id="modalNuevaEspecie" class="modal hide fade" tabindex="-1"
	 role="dialog" aria-labelledby="myModalNuevaEspecie" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalNuevaEspecie"><?php echo __('Introduzca los datos de la nueva especie')?></h3>
	</div>
	<div class="modal-body">

		<div id="errorMessagesNuevaEspecie" class="alert alert-error"
			 style="display: none; padding-left: 14px;">
			<h5><?php echo __('Por favor, corrija los errores en el formulario')?>:</h5>
			<ul></ul>
		</div>

		<form class="frmNuevaEspecie">

			<!-- Especie-->
			<div class="control-group">
				<label class="control-label" for="especie"> <?php echo __("Especie"); ?> (*)
					<span class="badge badge-info"
						  title="<?php echo __('Escribe tres letras del nombre común, género o especie y selecciona una especie de la lista. Además, una vez seleccionada una especie, podrás seleccioanr su subespecie escribiendo su primera letra y seleccioando una del listado.'); ?>">
                            <i class="icon-info-sign icon-white"></i>
                    </span>
				</label>

				<div class="controls">
					<div class="dummy">
						<input name="especie" class="especie input-xlarge" type="text" placeholder="<?php echo __('Escriba el nombre de la especie'); ?>">
						<input name="subespecie" disabled="disabled" class="subespecie input-large" type="text" placeholder="<?php echo __('Escriba la subespecie'); ?>">
						<div class="especieSeleccionadaContenedor" style="margin-top: 5px; display: none;">
							<?php echo __("Especie seleccionada"); ?>: <span class="especieSeleccionada text-success" style="font-weight: bold;"></span>
						</div>
						<div class="subespecieSeleccionadaContenedor" style="margin-top: 5px; display: none;">
							<?php echo __("Subespecie seleccionada"); ?>: <span class="subespecieSeleccionada text-success" style="font-weight: bold;"></span>
						</div>
						<div style="margin-top: 5px;">
							<button class="btnVaciarEspecie btn btn-warning btn-mini" type="button">
								<i class="icon-trash" style="margin-right: 10px;"></i><?php echo __("Limpiar"); ?>
							</button>
						</div>
						<input type="hidden" class="especieId" name="data[Cita][especie_id]">
					</div>
				</div>
			</div>

			<!-- Hora alta -->
			<div class="control-group">
				<label class="control-label" for="horaAltaNuevaEspecie"> <?php echo __("Hora"); ?> (*)</label>

				<div class="controls">
					<div class="input-prepend">
						<label for="horaAltaNuevaEspecie" class="add-on"><i class="icon-time"></i></label>
						<input type="text" id="horaAltaNuevaEspecie"
							   name="data[Cita][horaAlta]" size="10" class="time-picker hora-alta"
							   data-mask="99:99" style="width: auto;"
							   placeholder="hh:mm"/>
						<span class="badge badge-info"
							  title="<?php echo __('Seleccione la hora desde el desplegable o escriba una hora con formato hh:mm') ?>"><i
								class="icon-info-sign icon-white"></i> </span>
					</div>
				</div>
			</div>

			<!-- Número de aves-->
			<div class="control-group">
				<label class="control-label" for="indeterminado"> <?php echo __("Número de aves"); ?> (*)
					<span class="badge badge-info" style="font-weight: normal; margin-top: 5px;"
						  title='<?php echo __("Rellene los cuadros con el número de individuos observados en función de la edad y el sexo."); ?>'><i
							class="icon-info-sign icon-white"></i> </span>
				</label>

				<div class="controls">
					<div class="dummy" style="display: inline;">

						<?php echo $this->element('Cita/tablaNumeroAves'); ?>

						<div class="numeroTotalAvesDiv" style="margin-top: 5px; display: none;">
							<?php echo __("Número total aves"); ?>:
							<span class="numeroTotalAvesTexto text-success" style="font-weight: bold;"></span>
						</div>
						<input type="hidden" class="totalNumeroAves" name="data[Cita][cantidad]" value="0"/>
					</div>
				</div>
			</div>

			<!-- Datos de reproducción -->
			<div class="control-group">
				<label class="control-label"> <?php echo __("Datos reproducción"); ?> (*)
					<span class="badge badge-info"
						  title='<?php echo __("Seleccione el tipo de reproducción observado."); ?>'>
                                <i class="icon-info-sign icon-white"></i> </span>
				</label>

				<div class="controls">
					<div class="dummy">
						<?php
						echo '<select name="data[Cita][clase_reproduccion_id]" class="datosReproduccion input-xxlarge">';
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
						echo '</select>';
						?>
					</div>
				</div>
			</div>

			<!-- Otros datos -->
			<div class="control-group">
				<label class="control-label"> <?php echo __("Otros datos"); ?>
					<span class="badge badge-info" style="font-weight: normal;"
						  title='<?php echo __("Seleccione alguna de estas opciones si coinciden con lo observado."); ?>'><i
								class="icon-info-sign icon-white"></i> </span>
				</label>

				<div class="controls row-fluid">
					<div class="span6">
						<label class="checkbox">
							<input class="indHabitatRaro" name="data[Cita][indHabitatRaro]" value="1"
								   type="checkbox"> <?php echo __("Especie vista en habitat atípico"); ?>
						</label>
						<label class="checkbox">
							<input class="indCriaHabitatRaro" name="data[Cita][indCriaHabitatRaro]" value="1"
								   type="checkbox"> <?php echo __("Reproducción en un hábitat atípico"); ?>
						</label>
						<label class="checkbox">
							<input class="dormidero" name="data[Cita][dormidero]" value="1"
								   type="checkbox"> <?php echo __("En dormidero"); ?>
						</label>
						<label class="checkbox">
							<input class="colonia_de_cria" name="data[Cita][colonia_de_cria]" value="1"
								   type="checkbox"> <?php echo __("Colonia de cría"); ?>
						</label>
						<label class="checkbox">
							<input class="migracion_activa" name="data[Cita][migracion_activa]" value="1"
								   type="checkbox"> <?php echo __("Migración activa"); ?>
						</label>
						<label class="checkbox" title="<?php echo __("Grupo de aves en migración que permanecen descansando en un mismo sitio un tiempo."); ?>">
							<input class="sedimentado" name="data[Cita][sedimentado]" value="1"
								   type="checkbox"> <?php echo __("Sedimentado"); ?>
						</label>
					</div>
					<div class="span6">
						<label class="checkbox">
							<input class="indHerido" name="data[Cita][indHerido]" value="1"
								   type="checkbox"> <?php echo __("Cita de individuo herido, accidentado o muerto"); ?>
						</label>
						<label class="checkbox">
							<input class="indComportamiento" name="data[Cita][indComportamiento]" value="1"
								   type="checkbox"> <?php echo __("Comportamiento o morfología curiosa"); ?>
						</label>
						<label class="checkbox">
							<input class="electrocutado" name="data[Cita][electrocutado]" value="1"
								   type="checkbox"> <?php echo __("Electrocutado"); ?>
						</label>
						<label class="checkbox">
							<input class="atropellado" name="data[Cita][atropellado]" value="1"
								   type="checkbox"> <?php echo __("Atropellado"); ?>
						</label>
					</div>
				</div>
			</div>

			<!-- Observaciones -->
			<div class="control-group">
				<label class="control-label" for="observaciones"> <?php echo __("Observaciones"); ?></label>
				<div class="controls">
					<textarea name="data[Cita][observaciones]" rows="2" class="observaciones span4"></textarea>
				</div>
			</div>

		</form>

	</div>

	<div class="modal-footer">
		<button class="btn btn-danger" aria-hidden="true" data-dismiss="modal"><i class="icon-remove"></i> <?php echo __("Cancelar"); ?></button>
		<button class="btn-aceptar-nueva-especie btn btn-success" aria-hidden="true"><i class="icon-ok"></i> <?php echo __("Aceptar"); ?></button>
	</div>
</div>

<!-- EDITAR FILA ESPECIE -->
<div id="modalEditarEspecie" class="modal hide fade" tabindex="-1"
	 role="dialog" aria-labelledby="myModalEditarEspecie" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalEditarEspecie"><?php echo __('Editar los datos de la nueva especie')?></h3>
	</div>
	<div class="modal-body">

		<div id="errorMessagesEditarEspecie" class="alert alert-error"
			 style="display: none; padding-left: 14px;">
			<h5><?php echo __('Por favor, corrija los errores en el formulario')?>:</h5>
			<ul></ul>
		</div>

		<form class="frmEditarEspecie">

			<!-- Especie-->
			<div class="control-group">
				<label class="control-label" for="especie"> <?php echo __("Especie"); ?> (*)
					<span class="badge badge-info"
						  title="<?php echo __('Escribe tres letras del nombre común, género o especie y selecciona una especie de la lista. Además, una vez seleccionada una especie, podrás seleccioanr su subespecie escribiendo su primera letra y seleccioando una del listado.'); ?>">
                            <i class="icon-info-sign icon-white"></i>
                    </span>
				</label>

				<div class="controls">
					<div class="dummy">
						<input name="especie" class="especie input-xlarge" type="text" placeholder="<?php echo __('Escriba el nombre de la especie'); ?>">
						<input name="subespecie" disabled="disabled" class="subespecie input-large" type="text" placeholder="<?php echo __('Escriba la subespecie'); ?>">
						<div class="especieSeleccionadaContenedor" style="margin-top: 5px; display: none;">
							<?php echo __("Especie seleccionada"); ?>: <span class="especieSeleccionada text-success" style="font-weight: bold;"></span>
						</div>
						<div class="subespecieSeleccionadaContenedor" style="margin-top: 5px; display: none;">
							<?php echo __("Subespecie seleccionada"); ?>: <span class="subespecieSeleccionada text-success" style="font-weight: bold;"></span>
						</div>
						<div style="margin-top: 5px;">
							<button class="btnVaciarEspecie btn btn-warning btn-mini" type="button">
								<i class="icon-trash" style="margin-right: 10px;"></i><?php echo __("Limpiar"); ?>
							</button>
						</div>
						<input type="hidden" class="especieId" name="data[Cita][especie_id]">
					</div>
				</div>
			</div>

			<!-- Hora alta -->
			<div class="control-group">
				<label class="control-label" for="horaAltaEditar"> <?php echo __("Hora"); ?> (*)</label>

				<div class="controls">
					<div class="input-prepend">
						<label for="horaAltaEditar" class="add-on"><i class="icon-time"></i></label>
						<input type="text" id="horaAltaEditarEspecie"
							   name="data[Cita][horaAlta]" size="10" class="time-picker hora-alta"
							   data-mask="99:99" style="width: auto;"
							   placeholder="hh:mm"/>
						<span class="badge badge-info"
							  title="<?php echo __('Seleccione la hora desde el desplegable o escriba una hora con formato hh:mm') ?>"><i
								class="icon-info-sign icon-white"></i> </span>
					</div>
				</div>
			</div>

			<!-- Número de aves-->
			<div class="control-group">
				<label class="control-label" for="indeterminado"> <?php echo __("Número de aves"); ?> (*)
					<span class="badge badge-info" style="font-weight: normal; margin-top: 5px;"
						  title='<?php echo __("Rellene los cuadros con el número de individuos observados en función de la edad y el sexo."); ?>'><i
							class="icon-info-sign icon-white"></i> </span>
				</label>

				<div class="controls">
					<div class="dummy" style="display: inline;">

						<?php echo $this->element('Cita/tablaNumeroAves'); ?>

						<div class="numeroTotalAvesDiv" style="margin-top: 5px; display: none;">
							<?php echo __("Número total aves"); ?>:
							<span class="numeroTotalAvesTexto text-success" style="font-weight: bold;"></span>
						</div>
						<input type="hidden" class="totalNumeroAves" name="data[Cita][cantidad]" value="0"/>
					</div>
				</div>
			</div>

			<!-- Datos de reproducción -->
			<div class="control-group">
				<label class="control-label"> <?php echo __("Datos reproducción"); ?> (*)
					<span class="badge badge-info"
						  title='<?php echo __("Seleccione el tipo de reproducción observado."); ?>'>
                                <i class="icon-info-sign icon-white"></i> </span>
				</label>

				<div class="controls">
					<div class="dummy">
						<?php
						echo '<select name="data[Cita][clase_reproduccion_id]" class="datosReproduccion input-xxlarge">';
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
						echo '</select>';
						?>
					</div>
				</div>
			</div>

			<!-- Otros datos -->
			<div class="control-group">
				<label class="control-label"> <?php echo __("Otros datos"); ?>
					<span class="badge badge-info" style="font-weight: normal;"
						  title='<?php echo __("Seleccione alguna de estas opciones si coinciden con lo observado."); ?>'><i
								class="icon-info-sign icon-white"></i> </span>
				</label>

				<div class="controls row-fluid">
					<div class="span6">
						<label class="checkbox">
							<input class="indHabitatRaro" name="data[Cita][indHabitatRaro]" value="1"
								   type="checkbox"> <?php echo __("Especie vista en habitat atípico"); ?>
						</label>
						<label class="checkbox">
							<input class="indCriaHabitatRaro" name="data[Cita][indCriaHabitatRaro]" value="1"
								   type="checkbox"> <?php echo __("Reproducción en un hábitat atípico"); ?>
						</label>
						<label class="checkbox">
							<input class="dormidero" name="data[Cita][dormidero]" value="1"
								   type="checkbox"> <?php echo __("En dormidero"); ?>
						</label>
						<label class="checkbox">
							<input class="colonia_de_cria" name="data[Cita][colonia_de_cria]" value="1"
								   type="checkbox"> <?php echo __("Colonia de cría"); ?>
						</label>
						<label class="checkbox">
							<input class="migracion_activa" name="data[Cita][migracion_activa]" value="1"
								   type="checkbox"> <?php echo __("Migración activa"); ?>
						</label>
						<label class="checkbox" title="<?php echo __("Grupo de aves en migración que permanecen descansando en un mismo sitio un tiempo."); ?>">
							<input class="sedimentado" name="data[Cita][sedimentado]" value="1"
								   type="checkbox"> <?php echo __("Sedimentado"); ?>
						</label>
					</div>
					<div class="span6">
						<label class="checkbox">
							<input class="indHerido" name="data[Cita][indHerido]" value="1"
								   type="checkbox"> <?php echo __("Cita de individuo herido, accidentado o muerto"); ?>
						</label>
						<label class="checkbox">
							<input class="indComportamiento" name="data[Cita][indComportamiento]" value="1"
								   type="checkbox"> <?php echo __("Comportamiento o morfología curiosa"); ?>
						</label>
						<label class="checkbox">
							<input class="electrocutado" name="data[Cita][electrocutado]" value="1"
								   type="checkbox"> <?php echo __("Electrocutado"); ?>
						</label>
						<label class="checkbox">
							<input class="atropellado" name="data[Cita][atropellado]" value="1"
								   type="checkbox"> <?php echo __("Atropellado"); ?>
						</label>
					</div>
				</div>
			</div>

			<!-- Observaciones -->
			<div class="control-group">
				<label class="control-label" for="observaciones"> <?php echo __("Observaciones"); ?></label>
				<div class="controls">
					<textarea name="data[Cita][observaciones]" rows="2" class="observaciones span4"></textarea>
				</div>
			</div>
		</form>

	</div>

	<div class="modal-footer">
		<button class="btn btn-danger" aria-hidden="true" data-dismiss="modal"><i class="icon-remove"></i> <?php echo __("Cancelar"); ?></button>
		<button class="btn-aceptar-editar-especie btn btn-success" aria-hidden="true"><i class="icon-ok"></i> <?php echo __("Aceptar"); ?></button>
	</div>
</div>

<!-- SELECCIONAR LUGAR -->
<?php echo $this->element('Lugar/seleccionarLugar'); ?>

<!-- NUEVO LUGAR -->
<?php echo $this->element('Lugar/nuevoLugar'); ?>

<!-- CREAR COLABORADOR -->
<?php echo $this->element('ObservadorSecundario/nuevoObservadorSecundario'); ?>

<!-- Pie -->
<?php
    $this->start('pie');
    echo $this->element('/pie');
    $this->end();
?>
