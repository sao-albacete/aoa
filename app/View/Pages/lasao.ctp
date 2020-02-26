<?php 
    // Informamos el título
    $this->set('title_for_layout','La SAO');
    
    // Menu
    $this->start('menu');
    echo $this->element('/menu');
    $this->end();
?>

<style>
<!--
    p {
        text-align: justify;
    }
-->
</style>

<!-- Cuerpo -->
<div>
<fieldset>
    <legend><?=__("¿Qué es la Sociedad Albacetense de Ornitología?");?></legend>
    
    <div class="row-fluid">
        <p><?=__("La Sociedad Albacetense de Ornitología es una asociación sin ánimo de lucro fundada en 1988, que lleva más de 25 años dedicada al estudio y defensa de las aves y sus hábitats. ");?></p>
        <p><?=__("Pretendemos conocer mejor a nuestras aves, sus relaciones con el entorno en el que viven y las alteraciones que en él se producen. Queremos divulgar este conocimiento como una forma más de acercamiento a la naturaleza. Con ello esperamos contribuir a una mejor preservación de nuestros ecosistemas. Conocer es conservar. Las aves pueden ser una buena escusa para acercarse un poco más a la naturaleza, pasear, escuchar y, en definitiva, sentirse un poco más parte de ella.");?></p>
        <div class="span3 pull-right text-center">
            <?=$this->Html->image('/img/logos/logo_sao_180x179.png', array('alt'=>'Logotipo de la Sociedad Albacetense de Ornitología','title'=>'Logotipo de la Sociedad Albacetense de Ornitología')); ?>
        </div>
        <p><?=__("Desde hace años, está creciendo el interés de la población por la conservación del medio ambiente. El estado de conservación de nuestro medio natural se ha venido deteriorando de forma continuada debido a actividades humanas de todo tipo: cambios agrícolas, usos del agua, construcción de grandes obras públicas, contaminación, etc.");?></p>
        <p><?=__("Las aves, por su gran movilidad, se encuentran presentes en casi cualquier tipo de ambiente: desde las regiones árticas hasta el centro de las ciudades o la alta mar. Esto las hace valiosos indicadores de la salud ambiental de nuestro planeta. ");?></p>
    
        <div class="span3 pull-left" style="margin-left: 0; margin-right: 2.5%">
            <img src="/img/Pages/fundadores.jpg" alt="Fundadores de la SAO" title="Socios fundadores de la SAO"
                class="img-polaroid" style="margin-bottom: 20px;">
        </div>
        <p><?=__("En estos 25 años se ha avanzado en materia de conservación, se han declarado las Zonas de Especial Protección para la Aves ZEPA, se han aprobado planes de recuperación de especies en peligro de extinción. Pero a los problemas de entonces: caza de acuáticas, venenos, tendidos eléctricos peligrosos, aún sin solucionar, hemos de añadirle otros nuevos: proliferación descontrolada de parques eólicos y fotovoltaicos sin la adecuada evaluación ambiental, apertura de nuevas canteras, legislación más permisiva en materia medioambiental, etc. ");?></p>
        <p><?=__("Por otra parte, el gran número de especies de aves que habitan en España, casi 400, su presencia en todos los medios y su facilidad de observación, son algunas de las razones que hacen de las aves objeto de estudio y observación de gran número de aficionados a la naturaleza.");?></p>
        <div class="span4 pull-right">
            <img src="/img/Pages/grupo_teles.jpg" alt="Socios durante una salida naturalista" title="Socios durante una salida naturalista"
                 class="img-polaroid" style="margin-bottom: 20px;">
        </div>
        <p><?=__("La SAO, desde su fundación en el año 1988, realiza campañas, proyectos, estudios o actividades, entre otros:");?></p>
        <ul>
            <li><p><?=__("Realización de estudios sobre la distribución y ecología de las aves de Albacete, con la organización y participación en censos de aves provinciales y censos nacionales.");?></p></li>
            <li><p><?=__("Jornadas y Campañas de anillamiento científico de aves a nivel local y nacional, a través de los anilladores de la SAO, pertenecientes al Grupo Manchego de Anillamiento.");?></p></li>
            <li><p><?=__("Divulgación del conocimiento de las aves con actividades educativas celebrando el día mundial de las aves o de los humedales,  realizando exposiciones, etc.");?></p></li>
            <li><p><?=__("Recopilación de datos sobre aves poco frecuentes, accidentadas, nidos, mortandad de aves, etc.");?></p></li>
            <li><p><?=__("Publicación de un boletín de contacto entre los socios, de la revista “La Calandria” y de anuarios ornitológicos de la provincia de Albacete.");?></p></li>
            <li><p><?=__("Denuncia de atentados contra las aves y sus hábitats.");?></p></li>
            <li><p><?=__("Participación activa  en los procesos de evaluación de impacto ambiental. ");?></p></li>
            <li><p><?=__("Organización de excursiones, proyectos, proyección de diapositivas, charlas ornitológicas, cursos de ornitología, identificación de aves y anillamiento, etc.");?></p></li>
        </ul>
        <p><?=__("Y seguiremos en defensa de nuestras queridas aves y sus hábitats que en definitiva es la defensa del medio ambiente que es nuestra casa.")?></p>
        <p>
            <?=__("Para más información visita la página web de la");?>
            <a href="http://www.sao.albacete.org/">Sociedad Albacetense de Ornitología</a>
        </p>
    </div>
</fieldset>
</div>

<!-- Pie -->
<?php
$this->start('pie');
echo $this->element('/pie');
$this->end();
?>