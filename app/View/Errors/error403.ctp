<?php
// Título
$this->set('title_for_layout','Acceso denegado');

// Menu
$this->start('menu');
echo $this->element('/menu');
$this->end();

/**
 * CSS
 */
$this->Html->css(array(
    'Errors/error',
), null, array('inline' => false));
?>

<div class="container">
    <div class="row">
        <div class="span12">
            <div class="error-template">
                <h1><?=__('¡Ojo!')?></h1>
                <h2><?=__('Acceso denegado')?></h2>
                <div class="error-details">
                    <?=__('Lo sentimos, pero no tiene permisos para acceder a esta página.')?>
                </div>
                <div class="error-actions">
                    <a href="/" class="btn btn-primary btn-lg"><i class="icon-home"></i> <?=__('Vuelve al inicio')?> </a>
                    <a href="mailto:anuario@sao.albacete.org" class="btn btn-default btn-lg"><i class="icon-envelope"></i> <?=__('Contacta con nosotr@s')?> </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pie -->
<?php
$this->start('pie');
echo $this->element('/pie');
$this->end();
?>