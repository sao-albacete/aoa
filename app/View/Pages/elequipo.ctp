<?php
// Informamos el título
$this->set('title_for_layout', '¿Quiénes somos?');

/**
 * CSS
 */
$this->Html->css(array(
    'Pages/elequipo'
), null, array(
    'inline' => false
));

// Menu
$this->start('menu');
echo $this->element('/menu');
$this->end();
?>

<!-- Cuerpo -->
<div>
    <fieldset>
        <legend><?php echo __("El Equipo");?></legend>

        <div class="bio span5">
             <img src="/img/Pages/quienessomos/jose.jpg" class="picture">
            <div>
                <h5>José Antonio Cañizares Mata</h5>
                <h6 class="text-info"><?php echo __('Ornitólogo');?></h6>
            </div>
            <div>
                <p><?php echo __('Amante de la naturaleza desde pequeño, muy motivado por mi padre, mi madre y mis hermanos pues salíamos mucho al campo.');?></p>
                <p><?php echo __('En 1991 descubrí la SAO, y gracias a ella me hice ornitólogo. Desde entonces no he parado de colaborar activamente con ella. En 1995 me hice socio de SEO/BirdLife, con la que también colaboro activamente como voluntario o coordinador provincial de algunos de los programas que esta asociación tiene en marcha a nivel estatal (Sacre, Noctua, Sacín, Paser, Atlas de reproductoras o censos de especies específicos).');?></p>
                <p><?php echo __('También en 1995 obtuve el título de anillador científico de aves, entrando a ser miembro del Grupo Manchego de Anillamiento (GMA), el cuál pasé a coordinar en el año 2000. He colaborado en muchas campañas de anillamiento local, nacional e internacional, destacando las de Annsjon (Suecia), Kvismaren (Suecia), Treswell (Inglaterra), Salburúa (País Vasco), Laguna de la Nava (Palencia), Chico Mendes (Ciudad Real) o las de Nerpio (Castilla- La Mancha).');?></p>
                <p><?php echo __('Junto a otros socios de SAO colaboré en la publicación del primer Anuario Ornitológico de la provincia de Albacete, en el año 2001. Desde entonces me encargué de la coordinación para trabajar en la elaboración del presente Anuario Ornitológico de Albacete online.');?></p>
                <p>
                    <?php echo __('He publicado junto a otros autores, varios artículos en diversos medios como la');?>
                    <a href="http://www.iealbacetenses.com/index.php?menu=79&ruta&id=0&tipomenu" target="_blank">Revista Sabúco</a>, la
                    <a href="http://www.seo.org/2012/04/25/revista-de-anillamiento-2/" target="_blank">Revista de Anillamiento</a>, el
                    <a href="http://www.uclm.es/ceclm/librosnuevos/2005febrero/ornitologico.htm" target="_blank">Anuario Ornitológico de Ciudad Real</a> o los
                    <a href="https://es-es.facebook.com/www.coscoja.org" target="_blank">Cuadernos de Barrax</a>.
                </p>
                <p><?php echo __('Me gusta la informática, en especial las bases de datos, el diseño web y los SIG.');?></p>
            </div>
            <div style="text-align: center;">
                <a href="mailto:terekab@gmail.com" style="margin-right: 20px;" target="_blank">
                    <img src="/img/icons/social/Email.png" alt="email">
                </a>
            </div>
        </div>
        <div class="bio span5">
            <img alt="Víctor Cañizares" src="/img/Pages/quienessomos/victor.jpeg" class="picture">
            <div>
                <h5>Víctor Cañizares Mata</h5>
                <h6 class="text-info"><?php echo __('Ingeniero de Software y especialista en Desarrollo Web');?></h6>
            </div>
            <div class="content">
                <p><?php echo __('Comencé mi carrera profesional como ingeniero de software desde el año 2006, especializado en Desarrollo Web, back-end, bases de datos y sistema operativo GNU/Linux. He desarrollado mi carrera profesional en grandes empresas como Everis e Indra trabajando para clientes como la Agencia Espacial Europea, la Generalitat de Cataluña o Gas Natural Fenosa entre otros. ');?>.</p>
                <p>
                    <?php echo __('Actualmente formo parte del equipo técnico de');?>
                    <a href="http://www.wonnova.com/" target="_blank">Wonnova</a>,
                    <?php echo __('una compañía startup especializada en innovación tecnológica');?>.
                </p>
                <p><?php echo __('Soy firme defensor y divulgador del software y el conocimiento libre');?>.</p>
                <p><?php echo __('Amante y defensor de la naturaleza participo activamente desde hace años en ONGs como');?>
                    <a href="http://www.seo.org/" target="_blank">SEO/Birdlife</a>,
                    <a href="http://www.ecologistasenaccion.org/" target="_blank">Ecologistas en Acción</a>
                    <?php echo __('y por supuesto la');?>
                    <a href="http://www.sao.albacete.org" target="_blank">SAO</a>.
                </p>
            </div>
            <div style="text-align: center;">
                <a href="mailto:victor.canizares.mata@gmail.com" style="margin-right: 20px;" target="_blank">
                    <img src="/img/icons/social/Email.png" alt="email">
                </a>
                <a href="https://twitter.com/viktor_khan" style="margin-right: 20px;" target="_blank">
                    <img src="/img/icons/social/Twitter-2.png" alt="email">
                </a>
                <a href="https://www.linkedin.com/pub/v%C3%ADctor-ca%C3%B1izares-mata/96/b1a/622" style="margin-right: 20px;" target="_blank">
                    <img src="/img/icons/social/Linkedin.png" alt="email">
                </a>
            </div>
        </div>
        
        <div class="bio span5">
             <img alt="David Cañizares" src="/img/Pages/quienessomos/david.jpg" class="picture">
            <div>
                <h5>David Cañizares Mata</h5>
                <h6 class="text-info"><?php echo __('Ornitólogo');?></h6>
            </div>
            <div>
                <p><?php echo __('He trabajado durante 10 años en consultoras ambientales realizando diferentes seguimientos y estudios relacionados con la fauna y en especial con las aves');?>.</p>
                <p><?php echo __('Soy anillador científico de aves y pertenezco al Grupo Manchego de Anillamiento desde el año 2000. Como tal he trabajado en dos campañas llevadas a cabo en el Parque Nacional del Archipiélago de Cabrera (Islas Baleares) y colaborado en otras. Destaco las de Annsjon (Suecia), Treswell (Inglaterra), Salburúa (Álava), Chico Mendes (Ciudad Real) o las llevadas a cabo en Nerpio (Albacete) por Alas para Nerpio')?>.</p>
                <p><?php echo __('He publicado algunos artículos en diversos medios escritos como la Revista Sabúco, II Jornadas del Medio Natural Albacetense, Revista de Anillamiento, el Anuario de Ciudad Real y el Cuaderno de Barrax (Asociación Cultural La Coscoja)');?>.</p>
                <p><?php echo __('Pertenezco a la SAO desde 1996 y colaboro activamente en sus actividades. También soy socio de SEO/Birdlife desde hace más de 15 años, colaborando como voluntario en diversos censos y seguimientos y como coordinador provincial de algunos de los programas que esta asociación tiene en marcha a nivel estatal (Sacre, Sacín, Paser o Atlas de reproductoras)');?>.</p>
            </div>
            <div style="text-align: center;">
                <a href="mailto:david@sao.albacete.org" style="margin-right: 20px;" target="_blank">
                    <img src="/img/icons/social/Email.png" alt="email">
                </a>
            </div>
        </div>

    </fieldset>
</div>

<!-- Pie -->
<?php
$this->start('pie');
echo $this->element('/pie');
$this->end();
?>