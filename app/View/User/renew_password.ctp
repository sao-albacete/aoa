<?php 

// Informamos el título
$this->set('title_for_layout','Regenerar contraseña');

/**
 * CSS
 */
$this->Html->css(array('User/renew_password'), null, array('inline' => false));

/**
 * Javascript
 */
$this->Html->script(array('/plugin/jquery-validation-1.11.1/dist/jquery.validate.min', '/plugin/jquery-validation-1.11.1/dist/additional-methods.min', '/plugin/jquery-validation-1.11.1/localization/messages_es','User/renew_password'), array('inline' => false));

// Menu
$this->start('menu');
echo $this->element('/menu');
$this->end();
?>

<fieldset>
	<legend><?php echo __("Regenerar tu contraseña");?></legend>
	
	<?php if($validToken):?>
	
	<div class="alert">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<?php echo __("Los campos marcados con un asterisco rojo (*) son obligatorios");?>
	</div>

	<div id="errorMessagesGrafico" class="alert alert-error"
		style="display: none; padding-left: 14px;">
		<h5><?php echo __("Por favor, corrija los errores en el formulario");?>:</h5>
		<ul></ul>
	</div>
	
	<form action="<?php echo '/user/renewPassword/'.$keyToCheck; ?>" id="renewPasswordForm" method="post" accept-charset="utf-8" class="form-horizontal">
	
		<div id="addFormContent">
        
		    <!-- Password -->    
			<div class="control-group">
		        <label class="control-label" for="UserPassword"><?php echo __("Nueva contraseña");?> (*)</label>
		        <div class="controls">
					<div class="dummy">
		        		<input name="data[User][password]" placeholder="Crea tu nueva contraseña" type="password" id="UserPassword" required="required"/>
		        		<span class="badge badge-info" data-trigger="hover"
							data-content="<?php echo __('Escribe una nueva contraseña para el anuario');?>"><i class="icon-info-sign icon-white"></i> 
						</span>
					</div>
		        </div>
			</div>
		        
		    <!-- Confirmar password -->
		    <div class="control-group">
		        <label class="control-label" for="UserPasswordConfirmation"><?php echo __("Confirma tu nueva de contraseña");?> (*)</label>
		        <div class="controls">
					<div class="dummy">
		        		<input name="data[User][password_confirmation]" placeholder="Confirma tu nueva contraseña" type="password" id="UserPasswordConfirmation" required="required"/>
		        		<span class="badge badge-info" data-trigger="hover"
							data-content="<?php echo __('Vuelve a escribir tu nueva contraseña para confirmar que es correcta');?>"><i class="icon-info-sign icon-white"></i> 
						</span>
					</div>
		        </div>
			</div>		
			
			<hr>
		        
		    <div class="control-group">
		    	<button type="submit" class="btn btn-large btn-primary"><?php echo __("Guardar nueva contraseña");?>&nbsp;<i class="icon-check"></i></button>
		    </div>
		</div>		   
		
	</form>
	
	<?php endif;?>

</fieldset>

<!-- Pie -->
<?php
	$this->start('pie');
	echo $this->element('/pie');
	$this->end();
?>