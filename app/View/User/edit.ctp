<?php 

// Informamos el título
$this->set('title_for_layout','Editar usuario');

/**
 * CSS
 */
$this->Html->css(array('User/edit'), null, array('inline' => false));

/**
 * Javascript
 */
$this->Html->script(array('/plugin/jquery-validation-1.11.1/dist/jquery.validate.min', '/plugin/jquery-validation-1.11.1/dist/additional-methods.min', '/plugin/jquery-validation-1.11.1/localization/messages_es', 'User/edit'), array('inline' => false));

// Menu
$this->start('menu');
echo $this->element('/menu');
$this->end();
?>

<fieldset>
	<legend><?php __("Editar tus datos de usuario");?></legend>
	
	<div class="well well-small">
		<?php echo __("Los campos marcados con un asterisco (*) son obligatorios");?>
	</div>

	<div id="errorMessagesGrafico" class="alert alert-error"
		style="display: none; padding-left: 14px;">
		<h5><?php echo __("Por favor, corrija los errores en el formulario");?>:</h5>
		<ul></ul>
	</div>
	
	<form action="/user/edit/<?php echo $user['User']['id'];?>" id="UserEditForm" method="post" accept-charset="utf-8" 
			class="form-horizontal" enctype="multipart/form-data">
	
		<div class="row-fluid">
		
			<div class="span3" style="text-align: center;">
			
				<!-- Adjuntar fotos -->
				<div class="fileupload fileupload-new" data-provides="fileupload">
					<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
						<?php if(isset($urlAvatar) && file_exists($urlAvatar)) :?>
							<img src="<?php echo $user['Fichero']['ruta'].$user['Fichero']['nombreFisico'];?>" />
						<?php else :?>
                            <img src="/img/messages/AAAAAA&text=Sin+imagen_200x150.gif" />
						<?php endif;?>
					</div>
					<div class="fileupload-preview fileupload-exists thumbnail"
						style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
					<div>
						<span class="btn btn-file"> <span class="fileupload-new"><?php echo __("Seleccione una imagen");?>
						</span> <span class="fileupload-exists"><?php echo __("Cambiar");?>
						</span> <input type="file" id="imagen" name="imagen" /> </span> <a
							href="#" class="btn fileupload-exists" data-dismiss="fileupload"><?php echo __("Borrar");?>
						</a>
					</div>
				</div>
			
			</div>
		
			<div class="span9">
			
				<div class="control-group">
			        <label class="control-label" for="UserUsername"><?php echo __("Nombre completo");?> (*)</label>
			        <div class="controls">
						<div class="dummy">
			        		<input name="data[User][username]" placeholder="Escribe tu nombre completo" class="input-xxlarge" 
			        			maxlength="250" type="text" id="UserUsername" required="required" value="<?php echo $user['User']['username'];?>"/>
			        		<span class="badge badge-info" data-trigger="hover"
								data-content="<?php echo __('Escribe tu nombre completo');?>"><i class="icon-info-sign icon-white"></i> 
							</span>
						</div>
			        </div>
				</div>
			        
			    <div class="control-group">
			        <label class="control-label" for="UserEmail"><?php echo __("Correo electrónico");?> (*)</label>
			        <div class="controls">
						<div class="dummy">
			        		<input name="data[User][email]" placeholder="Escribe tu correo electrónico" class="input-xxlarge" 
			        			type="email" id="UserEmail" required="required" value="<?php echo $user['User']['email'];?>"/>
			        		<span class="badge badge-info" data-trigger="hover"
								data-content="<?php echo __('Escribe tu correo electrónico');?>"><i class="icon-info-sign icon-white"></i> 
							</span>
						</div>
			        </div>
				</div>
			        
				<div class="control-group">
			        <label class="control-label" for="UserPassword"><?php echo __("Contraseña actual");?> (*)</label>
			        <div class="controls">
						<div class="dummy">
			        		<input name="data[User][password]" placeholder="Escribe tu contraseña actual" type="password" 
			        			id="UserPassword" required="required"/>
			        		<span class="badge badge-info" data-trigger="hover"
								data-content="<?php echo __('Para confirmar la modificación de tus datos debes escribir tu contraseña');?>"><i class="icon-info-sign icon-white"></i> 
							</span>
						</div>
			        </div>
				</div>
				
				<div class="control-group">
			        <label class="control-label" for="UserNewPassword"><?php echo __("Nueva contraseña");?></label>
			        <div class="controls">
						<div class="dummy">
			        		<input name="data[User][new_password]" placeholder="Escribe tu nueva contraseña" type="password" 
			        			id="UserNewPassword"/>
			        		<span class="badge badge-info" data-trigger="hover"
								data-content="<?php echo __('Si deseas modificar tu contraseña, escribela aquí');?>"><i class="icon-info-sign icon-white"></i> 
							</span>
						</div>
			        </div>
				</div>
			        
			    <div class="control-group">
			        <label class="control-label" for="UserPasswordConfirmation"><?php echo __("Confirmación de nueva contraseña");?></label>
			        <div class="controls">
						<div class="dummy">
			        		<input name="data[User][password_confirmation]" placeholder="Confirma tu nueva contraseña" type="password" id="UserPasswordConfirmation"/>
			        		<span class="badge badge-info" data-trigger="hover"
								data-content="<?php echo __('Vuelve a escribir tu nueva contraseña para confirmar que es correcta');?>"><i class="icon-info-sign icon-white"></i> 
							</span>
						</div>
			        </div>
				</div>		    
			
			</div>
			
			<div class="control-group">
				<div class="controls text-center">
					<a href="/user/view/<?php echo $user['User']['id'];?>" class="btn btn-warning"><?php echo __("Cancelar");?></a>
		    		<input  class="btn btn-large btn-success" type="submit" value="<?php echo __("Guardar");?>"/>
		    	</div>
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