<?php 

// Informamos el título
$this->set('title_for_layout','Recuperar contraseña');

/**
 * CSS
 */
$this->Html->css(array('User/recover_password'), null, array('inline' => false));

/**
 * Javascript
 */
$this->Html->script(array('/plugin/jquery-validation-1.11.1/dist/jquery.validate.min','/plugin/jquery-validation-1.11.1/dist/additional-methods.min', 'User/recover_password'), array('inline' => false));

// Menu
$this->start('menu');
echo $this->element('/menu');
$this->end();
?>

<fieldset>
	<legend><?php echo __("Recuperar contraseña");?></legend>
	
    <h5><?php echo __("Introduce tu dirección de correo electrónico y te enviaremos un email con las instrucciones para regenerar tu contraseña");?>.</h5>
    
    <div id="errorMessagesGrafico" class="alert alert-error"
		style="display: none; padding-left: 14px;">
		<h5><?php echo __("Por favor, corrija los errores en el formulario");?>:</h5>
		<ul></ul>
	</div>
    
    <form id="recoverPasswordForm" accept-charset="utf-8" method="post" action="/user/recoverPassword" class="form-inline">
        <div id="recoverPasswordFormContent">
			<div class="input email required">
				<label for="UserEmail" style="margin-right: 10px;"><?php echo __("Correo electrónico");?></label>
				<input id="UserEmail" name="UserEmail" class="input-xlarge" type="email" required="required" maxlength="150" placeholder="<?php echo __('Escribe tu correo electrónico')?>" name="data[User][email]">
			</div>
			<div class="submit" style="text-align: center; margin-top: 20px;">
				<button id="btnEnviar" class="btn btn-large btn-primary"><?php echo __("Enviar")?>&nbsp;<i class="icon-share-alt"></i></button>
			</div>
	    </div>
   	</form>
	
</fieldset>

<!-- Pie -->
<?php
	$this->start('pie');
	echo $this->element('/pie');
	$this->end();
?>