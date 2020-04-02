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

			<?php if (count($ultimasFotos) > 0) : ?>
				<ul class="thumbnails yoxview">
					<?php foreach ($ultimasFotos as $foto) : ?>

						<li class="span3">
							<div class="thumbnail text-center">
								<a href="<?= $foto['Fichero']['ruta'] . $foto['Fichero']['nombreFisico'] ?>" class="thumbnail">
									<img src="<?= $foto['Fichero']['ruta'] . $foto['Fichero']['nombreFisico'] ?>"
										 alt="<?= $foto['Especie']['nombreComun'] ?>"
										 title="<?= $foto['Especie']['genero'] . " " . $foto['Especie']['especie'] . " " . $foto['Especie']['subespecie'] ?>">
								</a>
								<h3><?= $foto['Especie']['nombreComun'] ?></h3>
								<p><?= __('Foto realizada por ') . $foto['ObservadorPrincipal']['nombre'] . __(' en ') . $foto['Municipio']['nombre'] . __(' el ') . date_format(date_create($foto['Cita']['fechaAlta']), "d/m/Y") ?></p>
							</div>
						</li>
					<?php endforeach ?>
				</ul>
			<?php else : ?>
				<div class="thumbnail" style="width: 360px; height: 270px;">
					<img src="/img/messages/AAAAAA&text=No+hay+fotos_360x270.gif"/>
				</div>
			<?php endif ?>
		</fieldset>
	</div>

	<!-- Pie -->
<?php
$this->start('pie');
echo $this->element('/pie');
$this->end();
?>
