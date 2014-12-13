<?php 
// Informamos el título
$this->set('title_for_layout','Entra al anuario');

// Menu
$this->start('menu');
echo $this->element('/menu');
$this->end();
?>

<style>
    #loginFormContent {
        width: 600px ;
        height: 220px;
        margin-left: auto ;
        margin-right: auto ;
        border: 1px solid rgb(204, 204, 204);
        padding: 20px;
        background: #f6f6f6;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
    }
</style>

<div>
    <form id="UserLoginForm" accept-charset="utf-8" method="post" action="/user/login">
        <fieldset>
            <legend><?php echo __('Entra al anuario'); ?></legend>
            <div id="loginFormContent">
                <div class="span6">
                    <div class="input email required">
                        <label for="UserEmail">Correo electrónico</label>
                        <input id="UserEmail" class="input-xlarge" type="email" required="required" maxlength="150" placeholder="Escribe tu correo electrónico" name="data[User][email]" autofocus>
                    </div>
                    <div class="input password required">
                        <label for="UserPassword">Contraseña</label>
                        <input id="UserPassword" class="input-xlarge" type="password" required="required" placeholder="Escribe tu contraseña" name="data[User][password]">
                    </div>
                    <div class="submit" style="text-align: center;">
                        <a href="/User/add" class="btn btn-success"><?php echo __("Registrarse")?>&nbsp;<i class="icon-edit"></i></a>
                        <button class="btn btn-large btn-primary"><?php echo __("Entrar")?>&nbsp;<i class="icon-share-alt"></i></button>
                        <a href="/User/recoverPassword" style="line-height: 40px;"><?php echo __("¿Olvidaste tu contraseña?");?></a>
                    </div>
                </div>
                <div class="span6">
                    <img alt="Morito" src="/img/especie/53.jpg" class="img-polaroid img-rounded">
                </div>
            </div>
        </fieldset>
       </form>
</div>

<!-- Pie -->
<?php
$this->start('pie');
echo $this->element('/pie');
$this->end();
?>