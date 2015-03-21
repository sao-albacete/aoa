<?php
// Informamos el título
$this->set('title_for_layout','Agradecimientos');

// Menu
$this->start('menu');
echo $this->element('/menu');
$this->end();
?>

<style>
    p {
        text-align: justify;
    }
</style>

<!-- Cuerpo -->
<div>
    <fieldset>
        <legend><?=__("Agradecimientos");?></legend>

        <p><?=__('Queremos dedicar este espacio para agradecer a todas las personas que han hecho posible que este anuario ornitológico exista, de forma directa, indirecta, ofreciendo afectuosamente sus ánimos, con críticas constructivas o simplemente sabiendo esperar. Resulta difícil citar a todas las personas, que de una u otra forma han colaborado, así que queremos pedir disculpas a las personas que no aparezcan y se nos haya olvidado mencionar a continuación.')?></p>
        <p><?=__('Agradecemos especialmente a nuestros familiares el apoyo recibido para seguir adelante y perseverar en este proyecto.')?></p>
        <p><?=__('Agradecer también de forma especial a todos los socios y socias de la SAO que han contribuido y contribuyen con sus citas ya que sin éstas este anuario no tendría sentido.')?></p>
        <p><?=__('También a las personas que aunque no sean socias de la SAO contribuyen con sus citas y nos ayudan a conocer mejor las aves de Albacete.')?></p>
        <p><?=__('A los fotógrafos y fotógrafas de la SAO que han cedido desinteresadamente sus bonitas instantáneas para que formaran parte de esta web: Antonia Zamora, José Manuel Reolid, Jose Luis Jara, Jesús Arribas, Irene Belmonte, Antonio José González, Vicente Moreno, Raúl Galindo, Ester López, José María García, Fernando Camuñas, Francisco Tornero, Juan Camacho, Julia Jiménez y Antonio Manglano.')?></p>
        <p><?=__('Asimismo agradecemos a varios fotógrafos que no son socios de la SAO y que han querido compartir sus bonitas fotografías: Antonio Sanz, Richard Howard y Carmelo Andújar.')?></p>
        <p><?=__('A Juan Picazo, por animarnos a realizar este proyecto, por ayudarnos en la metodología que forma parte de él, así como en la realización de comentarios de varias especies.')?></p>
        <p><?=__('A José Manuel Reolid, Jesús Arribas y Miguel Arroyo, socios fundadores de la SAO y que todavía siguen activos, así como a Juan Picazo y Domingo Blanco, socios que siguen saliendo a pajarear, y que, gracias a ellos, conocimos la SAO, conocimos las aves y han contribuido de esta manera a realizar este anuario ornitológico.')?></p>
        <p><?=__('A Domingo Blanco, por realizar algunas secciones de esta web, por ser el presidente de SAO tantos años y por confiar y apoyarnos para que este proyecto viera la luz.')?></p>
        <p><?=__('A Antonio José González, porque fue el pionero en el anuario ornitológico de Albacete, y gracias a él, pudo salir adelante el primer y único anuario impreso a papel, y que con ello nos animó a realizar este proyecto.')?></p>
        <p><?=__('A José Manuel Reolid, Sergio Ovidio Pinedo, Julián Picazo y Miguel Vélaz, por realizar los comentarios de algunas especies de la lista de aves de Albacete.')?></p>
        <p><?=__('No queremos dejar de agradecer también a los anuarios ornitológicos online de otras provincias y regiones españolas como el Noticiario Ornitoxeográfico Galego/SGO, el Institut Català d\'Ornitologia/ICO, Anuario Ornitológico de la Región de Murcia, Anuario del Grupo Ornitológico Oscense/GOO, y muy en particular, al Anuario Ornitológico de Castellón, ahora también Anuario Ornitológico de la Comunidad Valenciana, pues gracias a ellos, comenzamos a pensar en desarrollar este anuario.')?></p>

        <br/>

        <h3><?=__('Dedicatoria')?></h3>
        <p><?=__('Este proyecto, que es para tod@s está dedicado a Victoria, Julián, Marcos, Lucas, Clemen, Carolina, María, Diana, ...')?></p>
        <p><?=__('... y especialmente, en memoria de nuestro padre Julián, quien nos sacó al campo desde niños, nos enseñó a disfrutar la naturaleza y a respetarla.')?></p>
        <div class="text-center">
            <img src="/img/Pages/agradecimientos.jpg" alt="José, David y Víctor Cañizares junto a su padre Julián" title="José, David y Víctor Cañizares junto a su padre Julián"
                 class="img-polaroid" style="margin: 20px 0; width: 700px">
        </div>


    </fieldset>
</div>

<!-- Pie -->
<?php
$this->start('pie');
echo $this->element('/pie');
$this->end();
?>