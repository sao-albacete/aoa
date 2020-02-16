<?php 
	// Informamos el título
	$this->set('title_for_layout','Contacto');
	
	// Menu
	$this->start('menu');
	echo $this->element('/menu');
	$this->end();
?>

<style>
<!--
	legend.small {
	  background: none;
	  padding: 0;
	  color: #333333;
	  border: 0;
	  border-bottom: 1px solid #e5e5e5;
	}
-->
</style>

<!-- Cuerpo -->
<div>
	<fieldset>
		<legend><?php echo __('Contacta con nosotr@s'); ?></legend>
		
		<p><?php echo __("Puedes ponerte en contacto con nosotr@s para informarnos sobre errores que hayas visto, sugerencias sobre como mejorar la aplicación, dudas que tengas sobre su uso, solicitarnos información extra sobre alguna cita, etc.");?></p>
		<p><?php echo __("También puedes escribirnos o mandarnos físicamente cualquier documento, libro o publicación que desees.");?></p>
		
		<fieldset>
			<legend class="small"><small><i class="icon-envelope"></i>&nbsp;<?php echo __("Correo electrónico");?></small></legend>
			
			<div style="text-align: center; font-weight: bold;">
				<a href="mailto:anuario@sao.albacete.org">anuario@sao.albacete.org</a>	
			</div>
		</fieldset>
		
		<fieldset>
			<legend class="small"><small><i class="icon-envelope"></i>&nbsp;<?php echo __("Dirección postal");?></small></legend>
			
			<div style="text-align: center; font-weight: bold;">
				<p><?php echo __("Anuario Ornitológico de la provincia de Albacete");?></p>
				<p><?php echo __("Sociedad Albacetense de Ornitología");?></p>
				<p><?php echo __("Apartado de Correos nº 18");?></p>
				<p><?php echo __("02080 Albacete (España)");?></p>
			</div>
		</fieldset>
		
		<fieldset>
			<legend class="small"><small><i class="icon-envelope"></i>&nbsp;<?php echo __("Contacto de la Sociedad Albacetense de Ornitología (SAO)");?></small></legend>
			
			<div style="text-align: center; font-weight: bold;">
				<p><?php echo __("Email: ");?><a href="mailto:sao@albacete.org">sao@albacete.org</a></p>	
				<p><?php echo __("Web: ");?><a href="http://www.sao.albacete.org" target="_blank">www.sao.albacete.org</a></p>
			</div>
		</fieldset>
		
	</fieldset>
</div>

<!-- Pie -->
<?php
$this->start('pie');
echo $this->element('/pie');
$this->end();
?>