<?php 
	// Informamos el título
	$this->set('title_for_layout','Ayuda');
	
	// Menu
	$this->start('menu');
	echo $this->element('/menu');
	$this->end();
?>

<!-- Cuerpo -->
<div>
	<fieldset>
		<legend><?php echo __('Ayuda'); ?></legend>
		
	</fieldset>
</div>

<!-- Pie -->
<?php
$this->start('pie');
echo $this->element('/pie');
$this->end();
?>