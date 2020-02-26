<?php 

// Informamos el título
$this->set('title_for_layout','Regístrate en el anuario');

/**
 * CSS
 */
$this->Html->css(array('User/add'), null, array('inline' => false));

/**
 * Javascript
 */
$this->Html->script(array('/plugin/jquery-validation-1.11.1/dist/jquery.validate.min', '/plugin/jquery-validation-1.11.1/dist/additional-methods.min', '/plugin/jquery-validation-1.11.1/localization/messages_es', 'User/add'), array('inline' => false));

// Menu
$this->start('menu');
echo $this->element('/menu');
$this->end();
?>

<fieldset>
    <legend><?php echo __("Regístrate en el anuario");?></legend>
    
    <div class="well well-small">
        <?php echo __("Los campos marcados con un asterisco rojo (*) son obligatorios");?>
    </div>

    <div id="errorMessagesGrafico" class="alert alert-error"
        style="display: none; padding-left: 14px;">
        <h5><?php echo __("Por favor, corrija los errores en el formulario");?>:</h5>
        <ul></ul>
    </div>
    
    <form action="/user/add/" id="UserAddForm" method="post" accept-charset="utf-8">
    
        <div id="addFormContent">

            <div class="row">

                <div class="span6 offset5">
        
            <!-- Nombre completo -->
            <div class="control-group">
                <label class="control-label" for="UserUsername"><?php echo __("Nombre completo");?> (*)</label>
                <div class="controls">
                    <div class="dummy">
                        <input name="data[User][username]" placeholder="Escribe tu nombre completo" class="input-xlarge"
                               maxlength="250" type="text" id="UserUsername" required="required" autofocus/>
                        <span class="badge badge-info" data-trigger="hover"
                            data-content="<?php echo __('Escribe tu nombre completo');?>"><i class="icon-info-sign icon-white"></i> 
                        </span>
                    </div>
                </div>
            </div>
                
            <!-- Email -->
            <div class="control-group">
                <label class="control-label" for="UserEmail"><?php echo __("Correo electrónico");?> (*)</label>
                <div class="controls">
                    <div class="dummy">
                        <input name="data[User][email]" placeholder="Escribe tu correo electrónico" class="input-xlarge" type="email" id="UserEmail" required="required"/>
                        <span class="badge badge-info" data-trigger="hover"
                            data-content="<?php echo __('Escribe tu correo electrónico');?>"><i class="icon-info-sign icon-white"></i> 
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Password -->    
            <div class="control-group">
                <label class="control-label" for="UserPassword"><?php echo __("Contraseña");?> (*)</label>
                <div class="controls">
                    <div class="dummy">
                        <input name="data[User][password]" placeholder="Crea tu contraseña" type="password" id="UserPassword" required="required"/>
                        <span class="badge badge-info" data-trigger="hover"
                            data-content="<?php echo __('Escribe una nueva contraseña para el anuario');?>"><i class="icon-info-sign icon-white"></i> 
                        </span>
                    </div>
                </div>
            </div>
                
            <!-- Confirmar password -->
            <div class="control-group">
                <label class="control-label" for="UserPasswordConfirmation"><?php echo __("Confirmación de contraseña");?> (*)</label>
                <div class="controls">
                    <div class="dummy">
                        <input name="data[User][password_confirmation]" placeholder="Confirma tu contraseña" type="password" id="UserPasswordConfirmation" required="required"/>
                        <span class="badge badge-info" data-trigger="hover"
                            data-content="<?php echo __('Vuelve a escribir la contraseña de arriba para confirmar que es correcta');?>"><i class="icon-info-sign icon-white"></i> 
                        </span>
                    </div>
                </div>
            </div>        
            
            <div class="control-group">
                <!-- La ventana modal de terminos y condiciones de uso esta definida en la vista pie.ctp -->
                <a href="#modalAvisoLegal" data-toggle="modal" style="margin-right: 10px;"><?php echo __("Acepto los términos y condiciones de uso");?></a>
                <input id="chkAceptarTerminos" name="chkAceptarTerminos" value="1" type="checkbox"/>
            </div>    
            
            <hr>

            <div class="controls buttons">
                <button id="btnRegistrar" class="btn btn-large btn-success"><?php echo __("Registrarte");?>&nbsp;<i class="icon-check"></i></button>
            </div>
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