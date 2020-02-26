<?php 

// Informamos el título
$this->set('title_for_layout','Mis datos de usuario');

/**
 * CSS
 */
$this->Html->css(array('User/view'), null, array('inline' => false));

/**
 * Javascript
 */
$this->Html->script(array('/plugin/jquery-validation-1.11.1/dist/jquery.validate.min', '/plugin/jquery-validation-1.11.1/dist/additional-methods.min', '/plugin/jquery-validation-1.11.1/localization/messages_es','/plugin/bootbox/bootbox.min','User/view'), array('inline' => false));

// Menu
$this->start('menu');
echo $this->element('/menu');
$this->end();
?>

<fieldset>
	<legend><?php __("Mis datos de usuario");?></legend>
	
	<a href="/user/edit/<?php echo $user['User']['id'];?>" role="button"
		class="btn btn-mini btn-warning" data-toggle="modal"
		id="btnEditarUsuario"><i class="icon-edit"></i> <?php echo __("Modificar datos");?></a>
		
	<a href="javascript: bajaUsuario(<?php echo $user['User']['id'];?>)" role="button"
		class="btn btn-mini btn-danger" data-toggle="modal"
		id="btnBorrarUsuario"><i class="icon-trash"></i> <?php echo __("Darse de baja");?></a>
			
	<hr>
	
	<div class="row-fluid">
		
		<div class="span2" style="text-align: center;">
		
			<!-- Adjuntar fotos -->
			<div class="fileupload fileupload-new" data-provides="fileupload">
				<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
					<?php if(isset($urlAvatar) && file_exists($urlAvatar)) :?>
						<img src="<?php echo $user['Fichero']['ruta'].$user['Fichero']['nombreFisico'];?>" />
					<?php else :?>
					   <img src="/img/messages/AAAAAA&text=Sin+imagen_200x150.gif" />
					<?php endif;?>
				</div>
			</div>
		
		</div>
	
		<div class="span10">
	
			<div class="form-horizontal">
			
				<div class="control-group">
			        <label class="control-label" for="UserUsername"><?php echo __("Nombre completo");?></label>
			        <div class="controls">
						<div class="dummy">
			        		<input class="input-xlarge" type="text" readonly="readonly" value="<?php echo $user['User']['username'];?>"/>
						</div>
			        </div>
				</div>
			        
			    <div class="control-group">
			        <label class="control-label" for="UserEmail"><?php echo __("Correo electrónico");?></label>
			        <div class="controls">
						<div class="dummy">
			        		<input class="input-xlarge" type="email" readonly="readonly" value="<?php echo $user['User']['email'];?>"/>
						</div>
			        </div>
				</div>
				
				<div class="control-group">
			        <label class="control-label" for="UserUsername"><?php echo __("Código");?></label>
			        <div class="controls">
						<div class="dummy">
			        		<input class="input-xlarge" type="text" readonly="readonly" value="<?php echo $user['ObservadorPrincipal']['codigo'];?>"/>
						</div>
			        </div>
				</div>
			
			</div>
		</div>
	</div>

</fieldset>

<form id="frmBajaUsuario" method="post" action="/user/delete/<?php echo $user['User']['id'];?>">
	<div id="divBajaUsuario" class="modal hide fade" tabindex="-1"
		role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
		<div class="modal-header">
			<a href="#" class="close" data-dismiss="modal">&times;</a>
			<h4 id="tituloDivBajaUsuario"><?php echo __("Baja de usuario");?></h4>
		</div>
		<div class="modal-body">
			
			<div id="errorMessagesBajaUsuario" class="alert alert-error"
				style="display: none; padding-left: 14px;">
				<ul></ul>
			</div>
		
			<div class="divDialogElements">
				<label for="txtNombreEditarColaborador"><?php echo __("Escriba su contraseña");?></label>
				<input class="input-xxlarge" id="txtBajaUsuarioPassword"
					name="bajaUsuarioPassword" type="password" required="required"
					placeholder="Escriba su contraseña..." />
			</div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo __("Cancelar");?></button>
			<button class="btn btn-primary" type="submit"><?php echo __("Aceptar");?></button>
		</div>
	</div>
</form>

<!-- Pie -->
<?php
	$this->start('pie');
	echo $this->element('/pie');
	$this->end();
?>