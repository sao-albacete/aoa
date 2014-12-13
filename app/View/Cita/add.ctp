<?php
// Informamos el título
$this->set('title_for_layout', 'Nueva cita');

/**
 * CSS
 */
$this->Html->css(array(
    'datatables-bootstrap',
    'Cita/add'
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
    'Cita/add'
), array('inline' => false));

// Menu
$this->start('menu');
echo $this->element('/menu');
$this->end();
?>

    <!-- Cuerpo -->
    <div id="divNuevaCita">
    <fieldset>
    <legend>
        <?php echo __('Nueva cita'); ?>
    </legend>

    <div class="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        Los campos marcados con un asterisco (*) son obligatorios
    </div>

    <div id="errorMessagesGrafico" class="alert alert-error"
         style="display: none; padding-left: 14px;">
        <h5>Por favor, corrija los errores en el formulario:</h5>
        <ul></ul>
    </div>

    <form id="frmNuevaCita" class="form-horizontal" method="post"
          enctype="multipart/form-data">

    <!-- Especie-->
    <div class="control-group">
        <label class="control-label" for="especie"> <?php echo __("Especie"); ?> (*)</label>

        <div class="controls">
            <div class="dummy">
                <input name="especie" id="especie" class="especie input-xxlarge" type="text"
                       placeholder="<?php echo __('Escriba el nombre común o el nombre científico'); ?>">
                <input name="subespecie" disabled="disabled" class="subespecie input-large" type="text"
                       placeholder="<?php echo __('Escriba la subespecie'); ?>">
                <span class="badge badge-info" data-trigger="hover"
                      data-content="<?php echo __('Escribe tres letras del nombre común, género o especie y selecciona una especie de la lista. Además, una vez seleccionada una especie, podrás seleccioanr su subespecie escribiendo su primera letra y seleccioando una del listado.'); ?>"><i
                        class="icon-info-sign icon-white"></i> </span>
                <br>

                <div class="especieSeleccionadaContenedor" style="margin-top: 5px; display: none;">
                    <?php echo __('Especie seleccionada');?>:
                    <span class="especieSeleccionada text-success" style="font-weight: bold;"></span>
                </div>
                <div class="subespecieSeleccionadaContenedor" style="margin-top: 5px; display: none;">
                    <?php echo __('Subespecie seleccionada');?>:
                    <span class="subespecieSeleccionada text-success" style="font-weight: bold;"></span>
                </div>
                <div style="margin-top: 5px;">
                    <button class="btnVaciarEspecie btn btn-warning btn-mini" type="button">
                        <i class="icon-trash" style="margin-right: 10px;"></i><?php echo __('Limpiar');?>
                    </button>
                </div>
                <input type="hidden" class="especieId" name="data[Cita][especie_id]">
            </div>
        </div>
    </div>

    <!-- Fecha alta-->
    <div class="control-group">
        <label class="control-label" for="fechaAlta"> <?php echo __("Fecha"); ?> (*)</label>

        <div class="controls">
            <div class="input-prepend">
                <label for="fechaAlta" class="add-on"><i class="icon-calendar"></i></label>
                <input type="text" id="fechaAlta"
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
                <br>

                <div id="lugarSeleccionadoContenedor"
                     style="margin-top: 5px; display: none;">
                    Lugar seleccionado: <span id="lugarSeleccionado"
                                              class="text-success" style="font-weight: bold;"></span>
                </div>
            </div>
            <div style="margin-top: 5px;">
                <button class="btnVaciarLugar btn btn-warning btn-mini" type="button">
                    <i class="icon-trash" style="margin-right: 10px;"></i><?php echo __("Limpiar"); ?>
                </button>
                <a href="#modalSeleccioanrLugar" role="button"
                   class="btn btn-mini btn-warning" data-toggle="modal"
                   id="btnSeleccionarLugar"><i class="icon-zoom-in"></i> <?php echo __("Seleccionar desde tabla"); ?>
                </a>
                <button class="btn btn-mini btn-warning btnNuevoLugar" type="button">
                    <i class="icon-plus"></i> <?php echo __("Nuevo lugar"); ?>
                </button>
            </div>
            <input type="hidden" id="lugarId" name="data[Cita][lugar_id]">
        </div>
    </div>

    <!-- Número de aves-->
    <div class="control-group">
        <label class="control-label" for="indeterminado"> <?php echo __("Número de aves"); ?> (*)
            <br>
            <span class="badge badge-info" data-trigger="hover" style="font-weight: normal; margin-top: 5px;"
                  data-content='<?php echo __("Rellene los cuadros con el número de individuos observados en función de la edad y el sexo."); ?>'><i
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
        <label class="control-label" for="datosReproduccion"> <?php echo __("Datos reproducción"); ?> (*) </label>

        <div class="controls">
            <div class="dummy">
                <?php
                echo '<select name="data[Cita][clase_reproduccion_id]" id="datosReproduccion" class="input-xxlarge">';
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
                <span class="badge badge-info" data-trigger="hover"
                      data-content='<?php echo __("Seleccione el tipo de reproducción observado."); ?>'>
                        <i class="icon-info-sign icon-white"></i> </span>
            </div>
        </div>
    </div>

    <!-- Otros datos -->
    <div class="control-group">
        <label class="control-label"> <?php echo __("Otros datos"); ?> <br>
                    <span class="badge badge-info" data-trigger="hover" style="font-weight: normal;"
                          data-content='<?php echo __("Seleccione alguna de estas opciones si coinciden con lo observado."); ?>'><i
                            class="icon-info-sign icon-white"></i> </span>
        </label>

        <div class="controls row-fluid">
            <div class="span2">
                <label class="checkbox">
                    <input name="data[Cita][indHabitatRaro]" value="1"
                           type="checkbox"> <?php echo __("Especie vista en habitat atípico"); ?>
                </label>
                <label class="checkbox">
                    <input name="data[Cita][indCriaHabitatRaro]" value="1"
                           type="checkbox"> <?php echo __("Reproducción en un hábitat atípico"); ?>
                </label>
            </div>
            <div class="span3">
                <label class="checkbox">
                    <input name="data[Cita][indHerido]" value="1"
                           type="checkbox"> <?php echo __("Cita de individuo herido, accidentado o muerto"); ?>
                </label>
                <label class="checkbox">
                    <input name="data[Cita][indComportamiento]" value="1"
                           type="checkbox"> <?php echo __("Comportamiento o morfología curiosa"); ?>
                </label>
            </div>
        </div>
    </div>

    <!-- Observador -->
    <div class="control-group">
        <label class="control-label" for="observador"> <?php echo __("Observador"); ?> (*) </label>

        <div class="controls">
            <div class="dummy">
                <input id="observador" name="observador" class="input-xxlarge"
                       type="text"
                       value="<?php echo $usuario['ObservadorPrincipal']['codigo'] . " - " . $usuario['ObservadorPrincipal']['nombre']; ?>"
                       placeholder="Escriba el código o el nombre del observador">
                        <span class="badge badge-info" data-trigger="hover"
                              data-content='<?php echo __("Escriba al menos tres letras y seleccione de la lista los observadores que quiera incluir en la cita."); ?>'><i
                                class="icon-info-sign icon-white"></i> </span>

                <div id="observadorSeleccionadoDiv" style="margin-top: 5px;">
                    Observador seleccionado:
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
                    <span id="colaboradoresSeleccionadosTexto" class="text-success" style="font-weight: bold;"></span>
                </div>
                <input type="hidden" id="colaboradoresSeleccionados" name="colaboradoresSeleccionados"/>

                <div style="margin-top: 5px;">
                    <button class="btn btn-warning btn-mini" type="button" id="btnVaciarColaboradores">
                        <i class="icon-trash" style="margin-right: 10px;"></i><?php echo __("Limpiar"); ?>
                    </button>
                    <button class="btn btn-mini btn-warning btnNuevoColaborador" type="button">
                        <i class="icon-plus"></i> <?php echo __("Nuevo colaborador"); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Fuente -->
    <div class="control-group">
        <label class="control-label" for="fuenteId"> <?php echo __("Fuente"); ?></label>

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
        <label class="control-label" for="estudioId"> <?php echo __("Estudio"); ?></label>

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

    <!-- Adjuntar fotos -->
    <div class="control-group">
        <label class="control-label" for="imagen"> <?php echo __("Adjuntar foto principal"); ?>
            <br> <span class="badge badge-info" data-trigger="hover" style="font-weight: normal;"
                       data-content='<?php echo __("Seleccione la imagen principal de la cita. Una vez creada la cita podrá adjuntar más imágenes"); ?>'><i
                    class="icon-info-sign icon-white"></i> </span> </label>

        <div class="controls">
            <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                    <img src="/img/messages/AAAAAA&text=Sin+imagen_200x150.gif"/>
                </div>
                <div class="fileupload-preview fileupload-exists thumbnail"
                     style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                <div>
                    <span class="btn btn-file">
                        <span class="fileupload-new"><?php echo __("Seleccione una imagen"); ?></span>
                        <span class="fileupload-exists"><?php echo __("Cambiar"); ?></span>
                        <input type="file" id="imagen" name="imagen"/>
                    </span>
                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload"><?php echo __("Borrar"); ?></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Observaciones -->
    <div class="control-group">
        <label class="control-label" for="observaciones"> <?php echo __("Observaciones"); ?></label>

        <div class="controls">
            <textarea id="observaciones" name="data[Cita][observaciones]" rows="2" class="span4"></textarea>
        </div>
    </div>

    <!-- Button (Double) -->
    <div class="control-group">
        <div class="controls text-center">
            <a id="btnGuardar" class="btn btn-success btn-large"><i class="icon-ok"></i> <?php echo __("Guardar"); ?></a>
        </div>
    </div>
    </form>

    </fieldset>
    </div>

<!-- SELECCIONAR LUGAR -->
<?php echo $this->element('Lugar/seleccionarLugar'); ?>

<!-- NUEVO LUGAR -->
<?php echo $this->element('Lugar/nuevoLugar'); ?>

<!-- NUEVO COLABORADOR -->
<?php echo $this->element('ObservadorSecundario/nuevoObservadorSecundario'); ?>

<!-- Pie -->
<?php
    $this->start('pie');
    echo $this->element('/pie');
    $this->end();
?>