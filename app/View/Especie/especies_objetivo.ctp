<?php
// Informamos el título
$this->set('title_for_layout','Especies objetivo');

// Menu
$this->start('menu');
echo $this->element('/menu');
$this->end();

/**
 * Javascript
 */
$this->Html->script(array(
    '/plugin/yoxview/yoxview-init',
), array('inline' => false));
?>

<style>
    p {
        text-align: justify;;
    }

</style>

<script>
    $(document).ready(function() {
        /* INICIO fotos */
        $(".yoxview").yoxview({
            "lang": "es",
            "autoHideMenu": false,
            "autoHideInfo": false,
            "showDescription": true,
            "renderInfoPin": false
        });
        /* FIN fotos */
    });
</script>

<!-- Cuerpo -->
<div>
    <fieldset>
        <legend><?php echo __("Especies objetivo");?></legend>

        <ul class="nav nav-pills">
            <li><a href="#2020">2020</a></li>
            <li><a href="#2019">2019</a></li>
            <li><a href="#2018">2018</a></li>
            <li><a href="#2017">2017</a></li>
            <li><a href="#2016">2016</a></li>
            <li><a href="#2015">2015</a></li>
        </ul>

        <div class="row-fluid">

            <div class="thumbnail span2 text-center pull-right" style="margin-left: 2.5%">
                <img src="/img/Pages/especies-objetivo/alcaudon-real.jpg" alt="Alcaudón real">
                <div class="caption">
                    <h4>Alcaudón real</h4>
                </div>
            </div>

            <p><?=__('El principal objetivo de este anuario ornitológico, es ampliar el conocimiento de la avifauna de la provincia de Albacete. Conocer su fenología, su estatus, la distribución, su origen, qué especies crían y dónde, etc. Para alcanzar este objetivo, es necesario obtener información de todas las especies, independientemente de su escasez o abundancia.')?></p>

            <div class="thumbnail span2 text-center" style="margin-right: 2.5%; margin-left: 0;">
                <img src="/img/Pages/especies-objetivo/gorrion-molinero.jpg" alt="Gorrión molinero">
                <div class="caption">
                    <h4>Gorrión molinero</h4>
                </div>
            </div>

            <p><?=__('En muchas ocasiones, cuando salimos al campo y recogemos las observaciones, solemos anotar básicamente las especies más raras, escasas o llamativas, olvidándonos la mayoría de las veces a las más comunes. Algunas como el gorrión molinero, el verderón común o el pico picapinos no llegan a 10 citas las que se recogen actualmente en el anuario. ')?></p>
            <p><?=__('Pero, ¿cuáles son las más comunes? Para Albacete, bastaría con ir al menú de “Lista de aves de la provincia de Albacete”, y observar por ejemplo la columna de distribución provincial, aquellas especies con tres o cuatro estrellas serán las consideradas más comunes en la provincia.')?></p>
            <p><?=__('SEO/BirdLife lleva avisando desde hace unos años acerca del debilitamiento de las poblaciones de las especies comunes. Para algunas de ellas, este descenso es alarmante como es el caso del alcaudón real, cuyas poblaciones han llegado a disminuir hasta un 65% en el año 2013 respecto a 1998. También es preocupante el caso de otras especies como la codorniz común, la golondrina común o la grajilla occidental con declives de entorno al 30% respecto a aquel año (SEO/BirdLife, 2014). Este hecho hace que sea necesario obtener mayor información sobre estas especies. Este motivo nos ha animado a poner en marcha esta iniciativa y así intentar ayudar a conocer un poco más sobre qué les está pasando a todas estas especies, tanto a nivel provincial como a nivel más global. Para más información, visitad este enlace de la página de <a href="http://www.seo.org/boletin/seguimiento/boletin/2013" target="_blank">SEO/BirdLife</a>.')?></p>
            <p><?=__('Por todo ello, hemos creado esta sección, para intentar llamar la atención sobre estas otras especies, que paradójicamente, son de las que menos datos disponemos. Os animamos a todos/as los/as que colaboráis con este anuario ornitológico a que subáis también las citas de todas estas especies comunes, pues así podremos conocer un poco mejor la situación de las aves de Albacete, ayudando con ello a protegerlas y conservarlas.')?></p>
            <p><?=__('Cada año se elegirán 4 o 5 especies para motivar que se introduzcan las observaciones que se recojan de éstas.')?></p>
            <br/>
            <center><span class="label label-success"><h3> <?=__('¡Muchas gracias por colaborar!')?> </h3></span></center>


        </div>

        <div class="row-fluid">
            <div class="page-header">
                <h3 id="2020"><?=__('Especies objetivo 2020')?></h3>
            </div>

            <!-- 2020 -->
            <p><?=__('En 2020, el grupo de especies objetivo al que queremos llamar la atención ha sido el de los <strong>CÓRVIDOS</strong>: ')?></p>
            <div style="margin-left: 2.5%">
            <ul>
                <li>
                   <p><?=__('Arrendajo euroasiático (<i>Garrulus glandarius</i>)')?></p>
                </li>
                <li>
                   <p><?=__('Rabilargo ibérico (<i>Cyanopica cyanus</i>)')?></p>
                </li>
                <li>
                   <p><?=__('Urraca común (<i>Pica pica</i>)')?></p>
                </li>
                <li>
                   <p><?=__('Chova piquirroja (<i>Pyrrhocorax pyrrhocorax</i>)')?></p>
                </li>
                <li>
                   <p><?=__('Grajilla (<i>Corvus monedula</i>)')?></p>
                </li>
                <li>
                   <p><?=__('Corneja negra (<i>Corvus corone</i>)')?></p>
                </li>
                <li>
                   <p><?=__('Cuervo grande (<i>Corvus corax</i>)')?></p>
                </li>

            </ul>
            </div>
            <p><?=__('En Europa, durante el periodo de estudio 2007-2016, la tendencia general de los córvidos es de estabilidad, con ligeros aumentos de la chova piquirroja de un porcentaje de cambio de 34, y de pequeñas tendencias negativas del arrendajo euroasiático y de la corneja negra PECBMS, 2019; EBCC, 2019).')?></p>
            <p><?=__('En España, la tendencia es muy similar. En primavera, los resultados del programa SACRE de SEO/BirdLife (Escandell, 2019) que analizan la tendencia de las aves comunes en el periodo 1998-2018, salvo el arrendajo euroasiático, la chova piquirroja y el rabilargo ibérico, las otras cuatro especies mostraban tendencias de moderado declive. Este declive sigue produciéndose a corto plazo (2008-2018) para la corneja negra y el cuervo grande, mientras que para el resto de especies, la tendencia es incierta o estable. En invierno, los datos del programa SACIN de SEO/BirdLife (Escandell , 2019) indican que la mayoría de las especies presentan una tendencia incierta o de estabilidad, salvo el cuervo grande y la grajilla occidental, además del arrendajo euroasiático (para la Región mediterránea sur) que presentan moderadas tendencias positivas. ')?></p>
            <p><?=__('En Albacete, hasta fin de 2015, fecha en la que nace el anuario ornitológico de Albacete (AOA), los córvidos prácticamente no se citaban. Posteriormente a esa fecha el número de citas ha ido aumentando. Del rabilargo ibérico sólo se disponían de 10 citas en el periodo anterior al anuario, pero tras su creación, ya se disponen de 38 citas (hasta fin de 2019). Más llamativo es el caso de la urraca común y la corneja negra, que pasaron de 57 y 38 citas antes al AOA a 216 y 228 citas respectivamente desde su creación.')?></p>

            <ul class="thumbnails yoxview">
                <li class="offset1"></li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/arrendajo.jpg">
                            <img src="/img/Pages/especies-objetivo/arrendajo.jpg" alt="Arrendajo Euroasiático" title="Arrendajo Euroasiático">
                        </a>
                        <h4>Arrendajo euroasiático</h4>
                    </div>
                </li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/urraca.jpg">
                            <img src="/img/Pages/especies-objetivo/urraca.jpg" alt="Urraca común" title="Urraca común">
                        </a>
                        <h4>Urraca Común</h4>
                    </div>
                </li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/rabilargo.jpg">
                            <img src="/img/Pages/especies-objetivo/rabilargo.jpg" alt="Rabilargo ibérico" title="Rabilargo ibérico">
                        </a>
                        <h4>Rabilargo Ibérico</h4>
                    </div>
                </li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/grajilla.jpg">
                            <img src="/img/Pages/especies-objetivo/grajilla.jpg" alt="Grajilla occidental" title="Grajilla occidental">
                        </a>
                        <h4>Grajilla occidental</h4>
                    </div>
                </li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/chova_piquirroja.jpg">
                            <img src="/img/Pages/especies-objetivo/chova_piquirroja.jpg" alt="Chova piquirroja" title="Chova piquirroja">
                        </a>
                        <h4>Chova piquirroja</h4>
                    </div>
                </li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/corneja.jpg">
                            <img src="/img/Pages/especies-objetivo/corneja.jpg" alt="Corneja negra" title="Corneja negra">
                        </a>
                        <h4>Corneja negra</h4>
                    </div>
                </li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/cuervo.jpg">
                            <img src="/img/Pages/especies-objetivo/cuervo.jpg" alt="Cuervo grande" title="Cuervo grande">
                        </a>
                        <h4>Cuervo grande</h4>
                    </div>
                </li>
            </ul>

        </div>

        <div class="row-fluid">

            <div class="page-header">
                <h3 id="2019"><?=__('Especies objetivo 2019')?></h3>
            </div>

            <!-- 2019 -->
            <p><?=__('Para 2019 hemos decidido llamar la atención sobre otro grupo de paseriformes que cada año sus poblaciones españolas disminuyen, las especies de la familia hirundínidos.')?></p>
            <p><?=__('Cinco son las especies presentes en nuestro país: <strong> la golondrina común (<i>Hirundo rustica</i>) </strong>, <strong>la golondrina dáurica (<i>Hirundo daurica</i>)</strong>, <strong>el avión común (<i>Delichon urbicum</i>)</strong>, <strong>el avión zapador (<i>Riparia riparia</i>) </strong> y <strong>el avión roquero (<i>Ptyonoprogne rupestris</i>)</strong>.')?></p>
             <p><?=__('Según datos de SEO/BirdLife (2013a, 2013b), para golondrina dáurica, avión común y avión zapador, las poblaciones parecen tener cierta estabilidad o ser inciertas. El avión roquero presenta unas poblaciones reproductoras también estables, aunque sus poblaciones invernales han sufrido fuerte declive de casi el 50% respecto a 2008/9.')?></p>
             <p><?=__('Aunque la que peor situación presenta es la golondrina común. Los datos de SACRE de los últimos 20 años reflejan, por ejemplo, que las poblaciones de golondrina común han caído más de un 44%. Se calcula que la especie  ha perdido unos <strong>13 millones de ejemplares</strong>, con lo que podría entrar a formar parte de la lista de aves calificadas como "Vulnerables" en España (SEO/BirdLife, 2016)')?></p>

            <ul class="thumbnails yoxview">
                <li class="offset1"></li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/golondrina_comun.jpg">
                            <img src="/img/Pages/especies-objetivo/golondrina_comun.jpg" alt="Golondrina común" title="Golondrina común">
                        </a>
                        <h4>Golondrina común</h4>
                    </div>
                </li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/golondrina_daurica.jpg">
                            <img src="/img/Pages/especies-objetivo/golondrina_daurica.jpg" alt="Golondrina daúrica" title="Golondrina daúrica">
                        </a>
                        <h4>Golondrina daúrica</h4>
                    </div>
                </li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/avion_comun.jpg">
                            <img src="/img/Pages/especies-objetivo/avion_comun.jpg" alt="Avión común" title="Avión común">
                        </a>
                        <h4>Avión común</h4>
                    </div>
                </li>
                 <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/avion_zapador.jpg">
                            <img src="/img/Pages/especies-objetivo/avion_zapador.jpg" alt="Avión zapador" title="Avión zapador">
                        </a>
                        <h4>Avión zapador</h4>
                    </div>
                </li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/avion_roquero.jpg">
                            <img src="/img/Pages/especies-objetivo/avion_roquero.jpg" alt="Avión roquero" title="Avión roquero">
                        </a>
                        <h4>Avión roquero</h4>
                    </div>
                </li>
            </ul>
            <center><a href="/files/especies_objetivo/estadisticas_especies_objetivo_2019.pdf" class="btn btn-large btn-primary" target="_blank"><i class="icon-download-alt icon-white"></i>&nbsp;<?=__('Descargar estadísticas 2019')?></a></center>
        </div>

        <div class="row-fluid">
            <div class="page-header">
                <h3 id="2018"><?=__('Especies objetivo 2018')?></h3>
            </div>

            <!-- 2018 -->
            <p><?=__('Para este año 2018, la SAO ha elegido como especies objetivo a los gorriones: el <strong>Gorrión común (<i>Passer domesticus</i>)</strong>, el <strong>Gorrión moruno (<i>Passer hispaniolensis</i>)</strong>, el <strong>Gorrión molinero (<i>Passer montanus</i>)</strong> y el <strong>Gorrión chillón (<i>Petronia petronia</i>)</strong>.')?></p>
            <p><?=__('Desde hace unos años, SEO/BirdLife viene informando sobre el grave declive de las poblaciones españolas de dos especies, el gorrión común y el gorrión molinero. Desde 1998 han descendido un 15% y un 6% respectivamente. Las otras dos especies, sin embargo, parece que han aumentado, incluso están expandiendose por la península sobre todo por su menor dependencia al ser humano (SEO/BirdLife, 2017).')?></p>
            <p><?=__('En la provincia de Albacete parece que el descenso poblacional de las dos especies en declive también puede estar produciéndose. Pero para ello necesitamos tu colaboración. Con tus citas podremos conocer un poco más la situación de los gorriones en nuestra provincia.')?></p>
             <p><?=__('Por ello, los gorriones son las especies objetivo de 2018.')?></p>

            <ul class="thumbnails yoxview">
                <li class="offset1"></li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/gorrion-comun.png">
                            <img src="/img/Pages/especies-objetivo/gorrion-comun.png" alt="Gorrión común" title="Gorrión común">
                        </a>
                        <h4>Gorrion común</h4>
                    </div>
                </li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/gorrion-molinero.png">
                            <img src="/img/Pages/especies-objetivo/gorrion-molinero.png" alt="Gorrion molinero" title="Gorrión molinero">
                        </a>
                        <h4>Gorrión molinero</h4>
                    </div>
                </li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/gorrion-moruno.jpg">
                            <img src="/img/Pages/especies-objetivo/gorrion-moruno.jpg" alt="Gorrión moruno" title="Gorrión moruno">
                        </a>
                        <h4>Gorrión moruno</h4>
                    </div>
                </li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/gorrion-chillon.png">
                            <img src="/img/Pages/especies-objetivo/gorrion-chillon.png" alt="Gorrión chillón" title="Gorrión chillón">
                        </a>
                        <h4>Gorrión chillón</h4>
                    </div>
                </li>
            </ul>
            <center><a href="/files/especies_objetivo/estadisticas_especies_objetivo_2018.pdf" class="btn btn-large btn-primary" target="_blank"><i class="icon-download-alt icon-white"></i>&nbsp;<?=__('Descargar estadísticas 2018')?></a></center>
        </div>

        <div class="row-fluid">

            <div class="page-header">
                <h3 id="2017"><?=__('Especies objetivo 2017')?></h3>
            </div>

            <!-- 2017 -->
            <p><?=__('En el año 2017, las especies objetivo que se han elegido son: el <strong>Alcaudón real (<i>Lanius meridionalis</i>)</strong>, el <strong>Alcaudón común (<i>Lanius excubitor</i>)</strong>, el <strong>Roquero solitario (<i>Monticola solitarius</i>)</strong> y el <strong>Roquero rojo (<i>Monticola saxatilis</i>)</strong>.')?></p>

            <ul class="thumbnails yoxview">
                <li class="offset1"></li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/lanius_meridionalis.jpg">
                            <img src="/img/Pages/especies-objetivo/lanius_meridionalis.jpg" alt="Alcaudón real" title="Alcaudón real">
                        </a>
                        <h4>Alcaudón real</h4>
                    </div>
                </li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/lanius_senator.jpg">
                            <img src="/img/Pages/especies-objetivo/lanius_senator.jpg" alt="Alcaudón común" title="Alcaudón común">
                        </a>
                        <h4>Alcaudón común</h4>
                    </div>
                </li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/monticola_solitarius.jpg">
                            <img src="/img/Pages/especies-objetivo/monticola_solitarius.jpg" alt="Roquero solitario" title="Roquero solitario">
                        </a>
                        <h4>Roquero solitario</h4>
                    </div>
                </li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/monticola_saxatilis.jpg">
                            <img src="/img/Pages/especies-objetivo/monticola_saxatilis.jpg" alt="Roquero rojo" title="Roquero rojo">
                        </a>
                        <h4>Roquero rojo</h4>
                    </div>
                </li>
            </ul>
            <center><a href="/files/especies_objetivo/estadisticas_especies_objetivo_2017.pdf" class="btn btn-large btn-primary" target="_blank"><i class="icon-download-alt icon-white"></i>&nbsp;<?=__('Descargar estadísticas 2017')?></a></center>
        </div>

        <div class="row-fluid">

            <div class="page-header">
                <h3 id="2016"><?=__('Especies objetivo 2016')?></h3>
            </div>

            <!-- 2016 -->
            <p><?=__('En el año 2016, las especies objetivo que se han elegido son: la <strong>Perdiz roja (<i>Alectoris rufa</i>)</strong>, la <strong>Codorniz común (<i>Coturnix coturnix</i>)</strong>, el <strong>Alcaraván común (<i>Burhinus oedicnemus</i>)</strong>, la <strong>Lechuza común(<i>Tyto alba</i>)</strong> y el <strong>Mochuelo común (<i>Athene noctua</i>)</strong>.')?></p>

            <ul class="thumbnails yoxview">
                <li class="offset1"></li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/codorniz_comun.jpg">
                            <img src="/img/Pages/especies-objetivo/codorniz_comun.jpg" alt="Codorniz común" title="Codorniz común">
                        </a>
                        <h4>Codorniz común</h4>
                    </div>
                </li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/perdiz_roja.jpg">
                            <img src="/img/Pages/especies-objetivo/perdiz_roja.jpg" alt="Perdiz roja" title="Perdiz roja">
                        </a>
                        <h4>Perdiz roja</h4>
                    </div>
                </li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/alcaravan_comun.jpg">
                            <img src="/img/Pages/especies-objetivo/alcaravan_comun.jpg" alt="Alcaraván común" title="Alcaraván común">
                        </a>
                        <h4>Alcaraván común</h4>
                    </div>
                </li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/lechuza_comun.jpg">
                            <img src="/img/Pages/especies-objetivo/lechuza_comun.jpg" alt="Lechuza común" title="Lechuza común">
                        </a>
                        <h4>Lechuza común</h4>
                    </div>
                </li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/mochuelo_comun.jpg">
                            <img src="/img/Pages/especies-objetivo/mochuelo_comun.jpg" alt="Mochuelo común" title="Mochuelo común">
                        </a>
                        <h4>Mochuelo común</h4>
                    </div>
                </li>
            </ul>
            <center><a href="/files/especies_objetivo/estadisticas_especies_objetivo_2016.pdf" class="btn btn-large btn-primary" target="_blank"><i class="icon-download-alt icon-white"></i>&nbsp;<?=__('Descargar estadísticas 2016')?></a></center>
        </div>

        <div class="row-fluid">

			<div class="page-header">
                <h3 id="2015"><?=__('Especies objetivo 2015')?></h3>
            </div>

            <!-- 2015 -->
            <p><?=__('En el año 2015, las especies objetivo que se eligieron fueron: la <strong>collalba gris</strong>, la <strong>collalba rubia</strong>, la <strong>collalba negra</strong>, la <strong>paloma zurita</strong> y la <strong>tórtola europea</strong>.')?></p>

            <ul class="thumbnails yoxview">
                <li class="offset1"></li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/collalba-gris.jpg">
                            <img src="/img/Pages/especies-objetivo/collalba-gris.jpg" alt="Collalba gris" title="Collalba gris">
                        </a>
                        <h4>Collalba gris</h4>
                    </div>
                </li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/collalba-rubia.jpg">
                            <img src="/img/Pages/especies-objetivo/collalba-rubia.jpg" alt="Collalba rubia" title="Collalba rubia">
                        </a>
                        <h4>Collalba rubia</h4>
                    </div>
                </li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/collalba-negra.jpg">
                            <img src="/img/Pages/especies-objetivo/collalba-negra.jpg" alt="Collalba negra" title="Collalba negra">
                        </a>
                        <h4>Collalba negra</h4>
                    </div>
                </li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/paloma-zurita.jpg">
                            <img src="/img/Pages/especies-objetivo/paloma-zurita.jpg" alt="Paloma zurita" title="Paloma zurita">
                        </a>
                        <h4>Paloma zurita</h4>
                    </div>
                </li>
                <li class="span2">
                    <div class="thumbnail text-center">
                        <a href="/img/Pages/especies-objetivo/tortola-europea.jpg">
                            <img src="/img/Pages/especies-objetivo/tortola-europea.jpg" alt="Tórtola europea" title="Tórtola europea">
                        </a>
                        <h4>Tórtola europea</h4>
                    </div>
                </li>
            </ul>
            <center><a href="/files/especies_objetivo/estadisticas_especies_objetivo_2015.pdf" class="btn btn-large btn-primary" target="_blank"><i class="icon-download-alt icon-white"></i>&nbsp;<?=__('Descargar estadísticas 2015')?></a></center>
        </div>

        <hr/>

        <p><?=__('<strong>Referencias:</strong>')?></p>
        <ul>
            <li><p><?=__('SEO/BirdLife, 2013a. <i>Resultados del programa Sacin 2008-2013.</i> SEO/BirdLife. Madrid.')?></p></li>
        </ul>
        <ul>
            <li><p><?=__('SEO/BirdLife, 2013b. <i>Resultados del programa Sacre de SEO/BirdLife.</i> SEO/BirdLife. Madrid.')?></p></li>
        </ul>
        <ul>
            <li><p><?=__('SEO/BirdLife, 2014. <i>Programas de seguimiento de SEO/BirdLife en 2013. 60 años de ciencia ciudadana de SEO/BirdLife</i> [en línea] [Madrid, España]. SEO/BirdLife. [fecha de consulta: 10 de febrero de 2015]. Disponible en Web: <a href="http://www.seo.org/boletin/seguimiento/boletin/2013/" target="_blank">http://www.seo.org/boletin/seguimiento/boletin/2013</a>')?></p></li>
        </ul>
        <ul>
            <li><p><?=__('SEO/BirdLife, 2016. <i>El drama de los pájaros comunes.</i> [en línea] [Madrid, España]. SEO/BirdLife. [fecha de consulta: 10 de enero de 2019]. Disponible en Web: <a href="https://www.seo.org/2016/06/02/drama-los-pajaros-comunes/" target="_blank">https://www.seo.org/2016/06/02/drama-los-pajaros-comunes/</a>')?></p></li>
        </ul>
        <ul>
            <li><p><?=__('SEO/BirdLife, 2017. <i>La lenta desaparición del gorrión, otra consecuencia de la despoblación rural</i> [en línea] [Madrid, España]. SEO/BirdLife. [fecha de consulta: 20 de enero de 2018]. Disponible en Web: <a href="https://www.seo.org/2017/03/20/la-lenta-desparicion-del-gorrion-otra-consecuencia-de-la-despoblacion-rural/" target="_blank">https://www.seo.org/2017/03/20/la-lenta-desparicion-del-gorrion-otra-consecuencia-de-la-despoblacion-rural/</a>')?></p></li>
        </ul>
        <ul>
            <li><p><?=__('SEO/BirdLife, 2019. <i>Documentos seguimiento de aves SEO/BirdLife</i>. [en línea] [Madrid, España]. SEO/BirdLife. [fecha de consulta: 1 de febrero de 2020]. Disponible en Web:
                <a href="https://www.seguimientodeaves.org/seg_doc/tplEspecies.php" target="_blank">https://www.seguimientodeaves.org/seg_doc/tplEspecies.php</a>')?></p></li>
        </ul>
        <ul>
            <li><p><?=__('Escandell, V. 2019. <i>Programa Sacre.</i> En, SEO/BirdLife. Programas de seguimiento y grupos de trabajo de SEO/BirdLife 2018, pp. 4-10. [en línea] [Madrid, España]. SEO/BirdLife. [fecha de consulta: 1 de febrero de 2020].  Disponible en Web: <a href="https://doi.org/10.31170/0073" target="_blank">https://doi.org/10.31170/0073</a>')?></p></li>
        </ul>
         <ul>
            <li><p><?=__('Escandell, V. 2019. <i>Programa Sacin.</i> En, SEO/BirdLife. Programas de seguimiento y grupos de trabajo de SEO/BirdLife 2018, pp. 4-10. [en línea] [Madrid, España]. SEO/BirdLife. [fecha de consulta: 1 de febrero de 2020].  Disponible en Web: <a href="https://doi.org/10.31170/0073" target="_blank">https://doi.org/10.31170/0073</a>')?></p></li>
        </ul>
         <ul>
            <li><p><?=__('PECBMS, 2020. <i>Species trends | PECBMS - PECBMS.</i> [en línea][Praha, Czech Republic]. Pan-European Common Bird Monitoring Scheme. Czech Society for Ornithology. [fecha de consulta: 1 de febrero de 2020]. Disponible en Web: <a href="https://pecbms.info/trends-and-indicators/species-trends/sort/taxonomy/" target="_blank">https://pecbms.info/trends-and-indicators/species-trends/sort/taxonomy/</a>')?></p></li>
        </ul>
        <ul>
            <li><p><?=__('EBCC, 2020. <i>European Bird Census Council.</i> [en línea][Sandy, United Kingdom]. European Bird Census Council. [fecha de consulta: 1 de febrero de 2020]. Disponible en Web: <a href="https://www.ebcc.info/" target="_blank">https://www.ebcc.info/</a>')?></p></li>
        </ul>

    </fieldset>
</div>

    <!-- Pie -->
<?php
$this->start('pie');
echo $this->element('/pie');
$this->end();
?>
