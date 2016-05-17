<?php
// Informamos el título
$title = 'Editar lugar: '.$lugar['Lugar']['nombre'];
$this->set('title_for_layout',$title);

/**
 * CSS
 */
$this->Html->css(array('Lugar/edit'), null, array('inline' => false));

/**
 * Javascript
 */
$this->Html->script(array(
    'https://maps.googleapis.com/maps/api/js?key=AIzaSyCvHe5uH6Ogczm4OWoXkq8_NiwspG4oE1I',
    'common/maps/geoxml3/geoxml3.js',
    'common/maps/geoxml3/ProjectedOverlay.js',
    '/plugin/jquery-validation-1.11.1/dist/jquery.validate.min',
    '/plugin/jquery-validation-1.11.1/dist/additional-methods.min',
    '/plugin/jquery-validation-1.11.1/localization/messages_es',
    '/plugin/bootbox/bootbox.min',
    'common/maps/functions',
    'Lugar/edit'
), array('inline' => false));

// Menu
$this->start('menu');
echo $this->element('/menu');
$this->end();
?>

<script type="text/javascript">

function marcarCuadriculaUtmYMunicipio(parserDocs) {
    
    //Marcar cuadrícula UTM
    var cuadriculaUtmAMarcar = {};
    cuadriculaUtmAMarcar.codigo = "<?php echo $lugar['CuadriculaUtm']['codigo'];?>";
    cuadriculaUtmAMarcar.tipo = "cuadriculaUtm";
    
    marcarMapa(parserDocs[0], cuadriculaUtmAMarcar);
    
    $.ajax({
        url: "/municipio/obtenerDatosMunicipio",
        data: {"municipioId":$("#selectMunicipio").val()},
        success: function( data ) {
            
            var datosMunicipio = JSON.parse(data);
            
            var municipioAMarcar = {};
            municipioAMarcar.codigo = datosMunicipio.Municipio.nombre;
            municipioAMarcar.tipo = "municipio";
            
            marcarMapa(parserDocs[1], municipioAMarcar);
        }
    });
}

</script>

<div>
    <fieldset>
        <legend>
            <?php echo __('Editar lugar: ').'<b>'.$lugar['Lugar']['nombre'].'</b>'; ?>
            <button class="btn btn-mini btn-info pull-right help-button"
                data-trigger="click" data-placement="left" data-html="true"
                data-content="<?php echo __('Para editar el lugar, modifique los datos que desee en el formulario y pulse <b>Guardar</b>. <br> Puede consultar las cuadrículas UTM de la provincia de Albacete en el mapa haciendo clic sobre cualqueira de ellas.');?>">
                <i class="icon-info-sign"></i> 
                <?php echo __("Ayuda");?>
            </button>
        </legend>

        <div id="errorMessagesGrafico" class="alert alert-error"
            style="display: none; padding-left: 14px;">
            <h5>Por favor, corrija los errores en el formulario:</h5>
            <ul></ul>
        </div>

        <div class="row-fluid">
            <div class="span6">
                <fieldset>
                    <legend class="small" style="font-size: 16px;"><?php echo __('Datos del lugar'); ?></legend>

                    <div class="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Los campos marcados con un asterisco (*) son obligatorios.
                    </div>

                    <form method="post" id="frmEditarLugar">

                        <input type="hidden" name="lugarId"
                            value="<?php echo $lugar['Lugar']['id'];?>" />

                        <div class="tab-content">

                            <!-- Nombre -->
                            <div class="control-group">
                                <div class="controls form-inline">
                                    <!-- Nombre -->
                                    <label class="control-label" for="txtNombre"> <?php echo __("Nombre");?> (*)</label> 
                                    <input id="txtNombre" name="nombre"
                                        class="input-xlarge required" type="text"
                                        value="<?php echo $lugar['Lugar']['nombre'];?>" maxlength="100">
                                    <span class="badge badge-info" data-trigger="hover"
                                        data-content="<?php echo __('Escriba el nombre del lugar. Debe tener un máximo de 100 caracteres.');?>"><i
                                            class="icon-info-sign icon-white"></i> </span>
                                </div>
                            </div>

                            <!-- Cuadrícula UTM -->
                            <div class="control-group">
                                <div class="controls form-inline">
                                    <!-- Cuadricula UTM -->
                                    <label class="control-label" for="selectCuadriculaUtm"><?php echo __("Cuadrícula UTM");?> (*)</label>
                                    <select id="selectCuadriculaUtm" name="cuadriculaUtmCodigo"
                                        class="input-xlarge required">
                                        <option value=""><?php echo __("-- Seleccione --");?></option>
                                        <?php
                                        foreach($cuadriculasUtm as $cuadriculaUtm) {
                                            if($lugar['CuadriculaUtm']['codigo'] == $cuadriculaUtm['CuadriculaUtm']['codigo']) {
                                                echo "<option value='".$cuadriculaUtm['CuadriculaUtm']['codigo']."' selected='selected'>".$cuadriculaUtm['CuadriculaUtm']['codigo']."</option>";
                                            }
                                            else {
                                                echo "<option value='".$cuadriculaUtm['CuadriculaUtm']['codigo']."'>".$cuadriculaUtm['CuadriculaUtm']['codigo']."</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                    <span class="badge badge-info" data-trigger="hover"
                                        data-content="<?php echo __('Seleccione una cuadrícula UTM. Puede consultar los códigos de cuadrícula en el mapa. Un vez seleccione una cuadrícula, se cargarán los municipios asociados.');?>"><i
                                            class="icon-info-sign icon-white"></i> </span>
                                </div>
                            </div>

                            <!-- Municipio -->
                            <div class="control-group">
                                <div class="controls form-inline">
                                    <!-- Municipio -->
                                    <label class="control-label" for="selectMunicipio"><?php echo __("Municipio");?> (*)</label>
                                    <select id="selectMunicipio" name="municipioId"
                                        class="input-xlarge required">
                                        <option value=""><?php echo __("-- Seleccione --");?></option>
                                            <?php
                                            foreach($municipios as $municipio) {
                                                if($lugar['Municipio']['id'] == $municipio['Municipio']['id']) {
                                                    echo "<option value='".$municipio['Municipio']['id']."' selected='selected'>".$municipio['Municipio']['nombre']."</option>";
                                                }
                                                else {
                                                    echo "<option value='".$municipio['Municipio']['id']."'>".$municipio['Municipio']['nombre']."</option>";
                                                }
                                            }
                                            ?>
                                    </select>
                                    <span class="badge badge-info" data-trigger="hover"
                                        data-content="<?php echo __('Seleccione un municipio.');?>"><i
                                            class="icon-info-sign icon-white"></i> </span>
                                </div>
                            </div>

                            <!-- Coordenadas UTM -->
                            <div class="control-group">
                                <div class="controls form-inline">
                                    <label class="control-label" for="txtCoordenadasUtmX"> <?php echo __("Coordenadas UTM");?></label>
                                    <input id="txtCoordenadasUtmArea" readonly="readonly"
                                        class="input-mini" type="text"
                                        value="<?php echo $lugar['CuadriculaUtm']['area'];?>"> 
                                    <input id="txtCoordenadasUtmX" name="coordenadaX" class="input-mini" type="text" readonly="readonly"
                                        value="<?php echo $lugar['Lugar']['coordenadaX'];?>" maxlength="6">
                                    <input id="txtCoordenadasUtmY" name="coordenadaY" class="input-mini" type="text" readonly="readonly"
                                        value="<?php echo $lugar['Lugar']['coordenadaY'];?>" maxlength="7">
                                    <span class="badge badge-info" data-trigger="hover"
                                        data-content="<?php echo __('Coordenadas UTM x e y del lugar.');?>"><i
                                            class="icon-info-sign icon-white"></i> </span>
                                </div>
                            </div>

                        </div>

                        <!-- Botones de búsqueda -->
                        <div id="divBotonesBusqueda" class="control-group"
                            style="margin-top: 20px;">
                            <div class="controls" style="text-align: center;">
                                <a id="btnLimpiar" class="btn btn-warning" href="#"><i class="icon-trash"></i> <?php echo __("Limpiar");?></a>
                                <a id="btnGuardar" class="btn btn-success btn-large" href="#"><i class="icon-ok"></i> <?php echo __("Guardar");?></a>
                            </div>
                        </div>

                    </form>
                </fieldset>
            </div>

            <div class="span6">
                <fieldset>
                    <legend class="small" style="font-size: 16px;"><?php echo __('Mapa'); ?></legend>
                    <div id="map_canvas" style="height: 400px;"
                        class="span12"></div>
                </fieldset>
            </div>
        </div>

    </fieldset>
</div>

<!-- Pie -->
<?php
$this->start('pie');
echo $this->element('/pie');
$this->end();
?>