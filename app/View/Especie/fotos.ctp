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
		</fieldset>
	</div>

	<!-- Pie -->
<?php
$this->start('pie');
echo $this->element('/pie');
$this->end();
?>
