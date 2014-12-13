<?php
// Informamos el título
$this->set ( 'title_for_layout', 'El Anuario' );

// Menu
$this->start ( 'menu' );
echo $this->element ( '/menu' );
$this->end ();
?>

<style>
<!--
    p {
        text-align: justify;
    }
-->
</style>

<!-- Cuerpo -->
<fieldset>
    <legend><?=__("El Anuario Ornitológico de Albacete");?></legend>

    <p><?=__("Anuario, según la primera acepción del diccionario de la Real Academia de la Lengua Española, “libro que se publica cada año como guía para determinadas profesiones, con información, direcciones y otros datos de utilidad”. Así pues, un anuario ornitológico debería ser una publicación con información de utilidad para aficionados a la observación de aves o profesionales de su estudio, circunscrito a un área geográfica determinada y relativo a un periodo de tiempo (idealmente anual para justificar el origen de la palabra). Y, efectivamente, esto son los anuarios ornitológicos que han proliferado en los últimos años en diferentes provincias o regiones españolas. La base de estas publicaciones es una lista de especies, ordenada sistemáticamente, donde se reflejan las observaciones de interés que aporten información relevante sobre distribución, fenología, comportamiento, o cualquier otro aspecto de la biología de las aves. El periodo temporal que abarcan suele ser de un año, aunque no pocos anuarios traicionan a su denominación y se publican con periodicidad  mayor. Hay que decir que todos los anuarios ornitológicos publicados en España surgen de la actividad de asociaciones o grupos de aficionados, de carácter vocacional y siempre de forma altruista, por lo que la capacidad para llevar a cabo estos trabajos es muy heterogénea. En cualquier caso siempre suponen una fuente de información para conocer mejor el estado de las poblaciones de aves y los procesos ecológicos que les afectan. Son por tanto una importante herramienta en diferentes aspectos:");?></p>
    
    <ul>
        <li><?=__("Aficionados que visitan zonas que no conocen pueden encontrar en los anuarios información práctica para sus viajes ornitológicos. También las empresas que organizan estos viajes.");?></li>
        <li><?=__("Científicos que planifican sesudos trabajos de investigación encontrarán en los anuarios un volumen de información que difícilmente podría pagarse a través de las escasas y mal dotadas instituciones científicas de nuestro país.");?></li>
        <li><?=__("Consultores que realizan estudios de impacto ambiental para cualquier proyecto que vaya a desarrollarse en el medio natural.");?></li>
        <li><?=__("Gestores que deben tomar decisiones importantes para la conservación de especies y ecosistemas.");?></li>
    </ul>
    
    <p><?=__("En cualquier caso, los anuarios ornitológicos son una buena manera de que los aficionados a la observación de aves compartan, viendo publicados y útiles, los datos obtenidos en muchas horas disfrutando (a veces también sufriendo) su afición.");?></p>
    
    <p>
        <?=__("Se puede considerar como precursor de los anuarios ornitológicos en España al Noticiario Ornitológico que publica la revista");?> 
        <a href="http://www.ardeola.org/" target="_blank">Ardeola</a>, 
        <?=__("de la Sociedad Española de Ornitología");?> 
        (<a href="https://www.seo.org/" target="_blank">SEO/BirdLife</a>). 
        <?=__("De la misma manera, el precursor del anuario ornitológico de Albacete es el Noticiario Ornitológico publicado en el boletín");?> 
        <a href="http://sao.albacete.org/joom/index.php?option=com_content&task=blogsection&id=5&Itemid=46" target="_blank">La Calandria</a>, 
        <?=__("de la Sociedad Albacetense de Ornitología");?>
        (<a href="http://www.sao.albacete.org/" target="_blank">SAO</a>), 
        <?=__("que, durante muchos años recopiló meticulosamente José Manuel Reolid. Un considerable esfuerzo de los socios de la SAO, y especialmente de Antonio José González como coordinador, supuso la publicación, gracias al Instituto de Estudios Albacetenses Don Juan Manuel");?> 
        (<a href="http://www.iealbacetenses.com/" target="_blank">IEA</a>), 
        <?=__("de un primer anuario ornitológico de Albacete, que recogía datos de los años 1997 y 98, aunque también recopilaba información anterior. Desde entonces no ha sido posible la publicación de un nuevo anuario que actualizase la información ornitológica de nuestra provincia, a pesar de que es mucho lo que se ha avanzado en el conocimiento de la avifauna de Albacete. Esta carencia ha sido suplida, en parte, por el Prontuario de la Naturaleza Albacetense, coordinado por Juan Picazo y publicado en la revista ");?>
        <a href="http://www.iealbacetenses.com/index.php?menu=79&ruta=&id=0&tipomenu=" target="_blank">Sabuco</a> 
        <?=__("del IEA, y la sección ");?>
        <a href="http://sao.albacete.org/joom/index.php?option=com_content&task=category&sectionid=13&id=63&Itemid=115" target="_blank">El Observatorio</a>, 
        <?=__("dentro de la página web de la SAO.");?>
    </p>
    
    <p><?=__("Desde el año 2010 los hermanos Cañizares (José Antonio, David y Víctor) vienen trabajando en la puesta a punto de un anuario ornitológico de Albacete on line. Se trata de una base de datos de observaciones de aves en la que todos aquellos que dispongan de citas con algún interés puedan incorporarlas de forma fácil y dinámica. Igualmente cualquier interesado en las aves de Albacete puede tener instantáneamente informes actualizados por especies, localidades, fechas, etc. Aquí se pretende recopilar toda la información anterior, publicada o inédita, e ir incorporando de forma continua la que se vaya generando con la actividad de todos aquellos colaboradores dispuestos a participar.");?></p>
    
    <p><?=__("Este trabajo no tendría sentido sin la colaboración de todos los observadores que ya han aportado sus citas y los que a partir de ahora, gracias a esta nueva herramienta, se animen a compartir sus anotaciones. A todos ellos nuestro agradecimiento. También hay que dar las gracias a todos los miembros de la SAO que colaboran de una u otra manera en impulsar este trabajo: aportando información, demandando la necesidad del anuario y animando a que se lleve a cabo, y también soportando con sus cuotas los gastos que pueda ocasionar. Gracias a Antonio José González por impulsar y empeñarse en la publicación de aquel primer anuario. También Juan Picazo aportó su experiencia y trabajo para conseguir este nuevo anuario. Al final, el trabajo menos agradable de poner todo esto junto, quebrarse la sesera con campos, tablas y algoritmos, pasar datos mecánica y tediosamente, en definitiva conseguir que todo esto sirva para algo, ha recaído (voluntariamente) en los hermanos José Antonio, David y Víctor Cañizares.");?></p>
    
    <p><?=__("Un agradecimiento especial para José Manuel Reolid, que con su meticulosidad para no dejar nunca de anotar todo lo que ve en el campo, disfrutando siempre con ello, ha sido un ejemplo a seguir para todos.");?></p>
    <p style="text-align: right"><b>Domingo Blanco Sidera</b></p>
    <p style="text-align: right"><?=__("Presidente de la Sociedad Albacetense de Ornitología");?></p>

</fieldset>

<!-- Pie -->
<?php
$this->start('pie');
echo $this->element('/pie');
$this->end();
?>