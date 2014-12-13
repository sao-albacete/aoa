<?php
// Título
$this->set('title_for_layout','Error inesperado');

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
                <h1><?=__('¡Ups!')?></h1>
                <h2><?=__('Hubo un error en la aplicación')?></h2>
                <div class="error-details">
                    <p><?=__('Lo sentimos, pero ha habido un error en la aplicación, por favor, vuelva a intentarlo más tarde.')?></p>
                    <p><?=__('Si el problema persiste, por favor, contacte con nosotr@s para reportar el problema.')?></p>
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
