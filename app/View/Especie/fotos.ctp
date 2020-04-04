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

			<div id="divFiltrosBusqueda">
				<label class="control-label" for="especie"> <?= __("Selecciona una especie"); ?></label>
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
		</form>

		<ul class="thumbnails yoxview">

		</ul>
		<button class="btn btn-success btn-large cargar-mas-fotos"><?= __('Cargar más fotos') ?>...&nbsp;<i class="icon-repeat icon-white"></i></button>
	</fieldset>
</div>

<!-- Pie -->
<?php
$this->start('pie');
echo $this->element('/pie');
$this->end();
?>
