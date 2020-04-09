<?php
// Informamos el título
$this->set('title_for_layout', 'Fotos por Especie');

/**
 * CSS
 */
$this->Html->css(array(
	'Especie/fotos',
), null, array(
	'inline' => false
));

/**
 * Javascript
 */
$this->Html->script(array(
	'Especie/fotos',
	'/plugin/yoxview/yoxview-init',
), array(
	'inline' => false
));

// Menu
$this->start('menu');
echo $this->element('/menu');
$this->end();
?>

<!-- Cuerpo -->
<div>
	<fieldset>
		<legend>
			<?= __('Fotos por Especie') ?>
		</legend>

		<form method="get" id="frmBusqueda">

			<div id="divFiltrosBusqueda" class="well">
				<label class="control-label" for="especie"> <?= __("Selecciona una especie"); ?></label>
				<input id="especie" name="especie" class="input-xxlarge"
					   type="text"
					   value="<?php if (isset($valuesSubmited['especie'])) {
						   echo $valuesSubmited['especie'];
					   } ?>"
					   placeholder="<?= __('Escribe el nombre común o el nombre científico'); ?>">
				<span class="help-block">Escribe el nombre común o el nombre científico de la especie que quieras buscar y seleccionala.<br>Si quieres ver todas las fotos sin filtrar por especie, borra el contenido de este campo de texto y pulsa la tecla <i>Enter</i>.</span>
				<input type="hidden" id="especieId" name="especieId"
					   value="<?php if (isset($valuesSubmited['especieId'])) {
						   echo $valuesSubmited['especieId'];
					   } ?>">
				&nbsp;&nbsp;&nbsp;&nbsp;
				<span class="cargando-fotos">Cargando fotos... <img src="/plugin/jqplot/examples/ajax-loader.gif"/></span>
			</div>
		</form>

		<hr>

		<ul class="thumbnails yoxview">

		</ul>
		<button class="btn btn-success btn-large cargar-mas-fotos"><?= __('Cargar más fotos') ?>...&nbsp;<i
				class="icon-repeat icon-white"></i></button>
	</fieldset>
</div>

<!-- Pie -->
<?php
$this->start('pie');
echo $this->element('/pie');
$this->end();
?>
