<?php 

// Informamos el título
$this->set('title_for_layout','Activación usuario');

/**
 * CSS
 */
$this->Html->css(array(), null, array('inline' => false));

/**
 * Javascript
 */
$this->Html->script(array('User/activate_user'), array('inline' => false));

// Menu
$this->start('menu');
echo $this->element('/menu');
$this->end();
?>

<!-- <fieldset>
	<legend><?php //echo __("Activar usuario");?></legend>
 </fieldset> -->

<!-- Pie -->
<?php
	$this->start('pie');
	echo $this->element('/pie');
	$this->end();
?>