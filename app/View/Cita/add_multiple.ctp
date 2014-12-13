<?php
// Informamos el título
$this->set('title_for_layout', 'Nueva cita múltiple');

/**
 * CSS
 */
$this->Html->css(array(
    'datatables-bootstrap',
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
    'datatables-bootstrap',
    '/plugin/bootbox/bootbox.min',
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

        <div class="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
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
                        <span class="badge badge-info" data-trigger="hover"
                              data-content="<?php echo __('Seleccione un día pulsando el calendario o escriba una fecha con formato ') . date('d/m/Y') ?>"><i
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
                        <span class="badge badge-info" data-trigger="hover"
                              data-content='<?php echo __("Escriba tres letras y seleccione un lugar del listado. También puede seleccionarlo a través de la tabla. Si no lo encuentra, puede crear uno nuevo."); ?>'><i
                                class="icon-info-sign icon-white"></i> </span>

                        <div id="lugarSeleccionadoContenedor" style="margin-top: 5px; display: none;">
                            <?php echo __("Lugar seleccionado"); ?>:
                            <span id="lugarSeleccionado" class="text-success" style="font-weight: bold;"></span>
                        </div>
                    </div>
                    <div style="margin-top: 5px;">
                        <button class="btn btn-warning btn-mini btnVaciarLugar" type="button"><i class="icon-trash" style="margin-right: 10px;"></i><?php echo __("Limpiar"); ?></button>
                        <a href="#modalSeleccioanrLugar" role="button"
                           class="btn btn-mini btn-warning" data-toggle="modal"
                           id="btnSeleccionarLugar"><i class="icon-zoom-in"></i> <?php echo __("Seleccionar desde tabla"); ?>
                        </a>
                        <button class="btn btn-mini btn-warning btnNuevoLugar" type="button"><i class="icon-plus"></i> <?php echo __("Nuevo lugar"); ?></button>
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
                        <span class="badge badge-info" data-trigger="hover"
                              data-content='<?php echo __("Escriba al menos tres letras y seleccione de la lista los observadores que quiera incluir en la cita."); ?>'><i
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
                        <span class="badge badge-info" data-trigger="hover"
                              data-content='<?php echo __("Escriba al menos tres letras y seleccione de la lista los colaboradores que quiera incluir en la cita."); ?>'><i
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
                            <button class="btn btn-mini btn-warning btnNuevoColaborador" type="button"><i class="icon-plus"></i> <?php echo __("Nuevo colaborador"); ?></button>
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
                    <span class="badge badge-info" data-trigger="hover"
                          data-content='<?php echo __("Seleccione la fuente de la que proviene la cita."); ?>'><i
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
                    <span class="badge badge-info" data-trigger="hover"
                          data-content='<?php echo __("Seleccione el tipo de estudio asociado a la cita."); ?>'><i
                            class="icon-info-sign icon-white"></i> </span>
                </div>
            </div>

            <input type="hidden" id="hdnEspecies" name="hdnEspecies"/>
            <table id="tablaEspecies" class="table table-bordred table-striped table-hover table-condensed">
                <caption><?php echo __('Especies'); ?></caption>
                <thead>
                    <tr>
                        <th><?php echo __('Especie'); ?></th>
                        <th><?php echo __('Nº de aves'); ?></th>
                        <th><?php echo __('Datos reproducción'); ?></th>
                        <th><?php echo __('Vista en hábitat atípico'); ?></th>
                        <th><?php echo __('Reproducción en hábitat atípico'); ?></th>
                        <th><?php echo __('Herido, accidentado o muerto'); ?></th>
                        <th><?php echo __('Comportamiento o morfología curiosa'); ?></th>
                        <th><?php echo __('Observaciones'); ?></th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="100%">
                            <a role="button" class="btn btn-small btn-warning" id="btnInsertarEspecie">
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
<?php echo $this->element('Especie/nuevaFilaEspecie'); ?>

<!-- EDITAR FILA ESPECIE -->
<?php echo $this->element('Especie/editarFilaEspecie'); ?>

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
