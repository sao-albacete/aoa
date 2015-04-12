<?php
/**
 * Anuario Ornitológico de Albacete Online
 */

$anuarioDescription = __('Anuario Ornitológico de Albacete Online');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?=$this->Html->charset(); ?>
    <title>
        <?=$title_for_layout; ?>:
        <?=$anuarioDescription; ?>
    </title>
    <?php
    
        /* meta */
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        
        echo $this->Html->meta('icon', '/favicon.ico');

        /* estilos */
        echo $this->Html->css(array(
            'normalize',
            '/plugin/bootstrap/css/bootstrap.min',
            '/plugin/bootstrap/css/bootstrap-responsive.min',
            '/plugin/jquery-ui-1.10.3/css/redmond/jquery-ui-1.10.3.custom.min',
            'aoa-main'));
        
        /* scripts */
        echo $this->Html->script(array(
            'jquery-1.10.1.min',
            'jquery-migrate-1.1.1.min',
            '/plugin/bootstrap/js/bootstrap.min',
            '/plugin/jquery-ui-1.10.3/js/jquery-ui-1.10.3.custom.min',
            'aoa'
        ));

        /* desde la vista */
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        echo $this->fetch('scriptBlock');
    ?>
    
    <script type="text/javascript">
        $( document ).tooltip();
    </script>
</head>
<body>

    <div class="navbar header">
        <div class="container-fluid">
            <a title="www.sao.albacete.org" href="http://www.sao.albacete.org/" target="_blank" class="pull-left" style="margin-right: 20px;">
                <?=$this->Html->image('/img/logos/logo_sao_43x43.png', array('alt' => 'Logotipo de la Sociedad Albacetense de Ornitología')); ?>
            </a>
            <a class="brand" href="/"><?=__("Anuario Ornitológico de Albacete Online")?></a>
            
            <?php if(!$logged_in): ?>
                <a href="/user/login" class="btn btn-primary pull-right" id="btn_entrar">Entrar&nbsp;<i class="icon-share-alt icon-white"></i></a>
                <a href="/user/add/" class="btn btn-success pull-right" style="margin-right: 10px"><?="Registrarte";?></a>
            <?php endif;?>
        
            <?php if($logged_in): ?>
                <div class="btn-group pull-right">
                    <a class="btn btn-primary" href="#"><i class="icon-user icon-white"></i> <?=$current_user['username']; ?></a>
                    <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <p style="line-height: 20px;padding: 3px 20px;"><?=$current_user['email']; ?></p>
                        <li class="divider"></li>
                        <li><a href="/cita/mis_citas"><i class="icon-eye-open"></i> <?=__('Mis citas')?></a></li>
                        <li><a href="/lugar/mis_lugares"><i class="icon-map-marker"></i> <?=__('Mis lugares')?></a></li>
                        <li><a href="/observadorSecundario/mis_colaboradores"><i class="icon-user"></i> <?=__('Mis colaboradores')?></a></li>
                        <li class="divider"></li>
                        <li><a href="/user/view"><i class="icon-cog"></i> <?=__('Mis datos')?></a></li>
                        <li class="divider"></li>
                        <li><a href="/user/logout"><i class="icon-off"></i> <?=__('Salir')?></a></li>
                    </ul>
                </div>
            <?php endif;?>
        </div>
    </div>

    <div id="container" class="container-fluid">
    
        <!-- Barra de navegación superior -->
        <?=$this->fetch('menu'); ?>
    
        <!-- Cabecera de inicio -->
        <?php if(!$logged_in): ?>
            <?=$this->fetch('cabecera'); ?>
        <?php endif;?>
        
        <!-- Cuerpo central -->
        <div id="content" class="row-fluid">
        
            <div class="span12">
            
                <?=$this->Session->flash(); ?>
                <?=$this->Session->flash('auth', array('element' => 'failure')); ?>
                <?=$this->Session->flash('auth', array('element' => 'success')); ?>
                <?=$this->Session->flash('auth', array('element' => 'warning')); ?>
                
                <?=$this->fetch('content'); ?>
                
            </div>
        </div>
    </div>
    
    <!-- Pie de página -->
    <?=$this->fetch('pie'); ?>
    
</body>
</html>
