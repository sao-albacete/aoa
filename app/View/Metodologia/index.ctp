<?php
// Informamos el título
$this->set('title_for_layout','Metodología');

/**
 * CSS
 */
$this->Html->css(array(
    'Metodologia/index'
), null, array(
    'inline' => false
));

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
        <legend><?=__("Metodología utilizada para la elaboración de este Anuario");?></legend>

        <br/>
        <p><?=__("En este documento se indica la metodología que se ha utilizado para realizar el anuario ornitológico de Albacete online");?>.</p>
        <br/>

        <div class="page-header">
            <h4><?=__("Criterios de selección de las citas");?></h4>
        </div>

        <p><?=__("Las citas son seleccionadas automáticamente por la aplicación. Se han utilizado unos criterios para esta selección clasificados en: citas de presencia, de distribución, hábitat, fenología, abundancia, reproducción, comportamiento y conservación. En el caso de que una cita cumpla alguno de estos criterios, será seleccionada para el anuario y se le asignará el código de mayor importancia. Estos criterios de selección  serán los que compongan los posteriores anuarios ornitológicos");?>.</p>

        <br/>
        <?=$this->element('Cita/tablaCriterioSeleccion'); ?>
        <br/>

        <div class="page-header">
            <h4><?=__("Especies consideradas rarezas");?></h4>
        </div>

        <p><?=__("En la aplicación se pueden distinguir dos clases de aves consideradas rarezas, las rarezas locales y las rarezas nacionales.");?></p>
        <ul>
            <li>
                <?=__("Las <b>rarezas nacionales</b> son las que oficialmente son incluidas como tales por el ");?>
                <a href="http://www.seo.org/2012/01/25/%C2%BFque-es-y-como-trabaja-el-comite-de-rarezas/" target="_blank"><?=__("comité de rarezas de SEO/BirdLife")?></a>.
                <?=__("En el siguiente enlace se puede ver esta lista actual de las aves consideradas rarezas nacionales:")?>
                <a href="http://www.rarebirdspain.net/homolog_2006.pdf" target="_blank">http://www.rarebirdspain.net/homolog_2006.pdf</a>.
            </li>
            <li>
                <p><?=__("Las <b>rarezas locales</b> son todas aquellas especies que no son rarezas nacionales pero con reducidas citas en la provincia de Albacete")?>. <a href="#modalRarezasLocales" data-toggle="modal"><?=__("En este enlace")?></a> <?=__("se puede ver el listado de las especies consideradas rarezas locales:")?></p>
            </li>
        </ul>
        <p><?=__("¿Qué pasa al introducir una rareza?. Al introducir una especie considerada rareza local o nacional, la aplicación avisa de que la especie considerada es rareza. En el caso de rareza nacional, se le indica la dirección web del comité de rarezas de SEO/BirdLife para que rellene un formulario de registro. En el caso de ser un ave considerada rareza local, se indica que la cita está sujeta a revisión y que deberá aportar toda la información adicional de la que se disponga al correo electrónico del anuario con el fin de confirmar o rechazar la rareza.")?></p>
        <br/>

        <div class="page-header">
            <h4><?=__("Citas de especies Vulnerables y En Peligro y rarezas")?></h4>
        </div>
        <p><?=__("Para las especies consideradas más sensibles, escasas o raras, se ocultan determinados datos con la intención de protegerlas. Con ese fin, se oculta la información de los apartados \"Localidad\" y \"Observaciones\" relativas a esa cita. La coordenada UTM 10x10 km es la localización más precisa que se ofrecería en estos casos. Se ha estudiado cada especie minuciosamente, y se ha desarrollado una serie de criterios para valorar si se debe mostrar o no esta información de la observación,  dependiendo de su grado de amenaza, su rareza o el riesgo de que cierta información sea mal usada. Principalmente se ha filtrado esta información en todas las especies catalogadas \"En peligro de extinción\" y \"Vulnerables\" en el catálogo regional y nacional, de las consideradas rarezas en España y, asimismo, otras que por sus peculiaridades se ha estimado que eran especialmente sensibles.")?></p>
        <p><?=__("En la siguiente tabla se muestran estas especies. Ésta irá modificándose en función de las citas y de la información que se vaya actualizando.")?></p>
        <br/>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th><?=__("Especie")?></th>
            </tr>
            </thead>
            <tbody>
            <tr><td>Botaurus stellaris</td></tr>
            <tr><td>Ardeola ralloides</td></tr>
            <tr><td>Ciconia nigra</td></tr>
            <tr><td>Tadorna ferruginea</td></tr>
            <tr><td>Marmaronetta angustirostris</td></tr>
            <tr><td>Aythya nyroca</td></tr>
            <tr><td>Oxyura leucocephala</td></tr>
            <tr><td>Milvus milvus</td></tr>
            <tr><td>Gypaetus barbatus</td></tr>
            <tr><td>Neophron percnopterus</td></tr>
            <tr><td>Accipiter gentilis</td></tr>
            <tr><td>Accipiter nisus</td></tr>
            <tr><td>Aquila adalberti</td></tr>
            <tr><td>Aquila chrysaetos</td></tr>
            <tr><td>Aquila fasciata</td></tr>
            <tr><td>Pandion haliaetus</td></tr>
            <tr><td>Falco peregrinus</td></tr>
            <tr><td>Fulica cristata</td></tr>
            <tr><td>Cursorius cursor</td></tr>
            <tr><td>Charadrius morinellus</td></tr>
            <tr><td>Gallinago gallinago</td></tr>
            <tr><td>Numerius arquata</td></tr>
            <tr><td>Childonias niger</td></tr>
            <tr><td>Bubo bubo</td></tr>
            <tr><td>Chersophilus duponti</td></tr>
            <tr><td>Cercotrichas galactotes</td></tr>
            </tbody>
        </table>
        <br/>

        <div class="page-header">
            <h4><?=__("Citas destacadas")?></h4>
        </div>
        <p><?=__("Se han enfatizado algunas citas para resaltar su importancia. La selección de la importancia de la cita atiende a la escasez de la especie y de su categoría de reproducción.")?></p>
        <br/>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th><?=__("Icono")?></th>
                <th><?=__("Descripción")?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text-center"><img alt="" src="/img/icons/importancia/rareza_nacional.png"></td>
                <td><?=__("Rareza nacional")?></td>
            </tr>
            <tr>
                <td class="text-center"><img alt="" src="/img/icons/importancia/rareza_local.png"></td>
                <td><?=__("Rareza local")?></td>
            </tr>
            <tr>
                <td class="text-center"><img alt="" src="/img/icons/importancia/especie_protegida.png"></td>
                <td><?=__("Especie protegida EN o VU")?></td>
            </tr>
            <tr>
                <td class="text-center"><img alt="" src="/img/icons/importancia/especie_escasa.png"></td>
                <td><?=__("Especie muy escasa")?></td>
            </tr>
            <tr>
                <td class="text-center"><img alt="" src="/img/icons/importancia/rareza_cria_probable.png"></td>
                <td><?=__("Rareza nacional con cría probable")?></td>
            </tr>
            <tr>
                <td class="text-center"><img alt="" src="/img/icons/importancia/rareza_local_cria_probable.png"></td>
                <td><?=__("Rareza local con cría probable")?></td>
            </tr>
            <tr>
                <td class="text-center"><img alt="" src="/img/icons/importancia/protegida_cria_probable.png"></td>
                <td><?=__("Especie Protegida con cría probable")?></td>
            </tr>
            <tr>
                <td class="text-center"><img alt="" src="/img/icons/importancia/escasa_cria_probable.png"></td>
                <td><?=__("Especie escasa con cría probable")?></td>
            </tr>
            <tr>
                <td class="text-center"><img alt="" src="/img/icons/importancia/rareza_cria.png"></td>
                <td><?=__("Rareza nacional con cría segura")?></td>
            </tr>
            <tr>
                <td class="text-center"><img alt="" src="/img/icons/importancia/rareza_local_cria.png"></td>
                <td><?=__("Rareza local con cría segura")?></td>
            </tr>
            <tr>
                <td class="text-center"><img alt="" src="/img/icons/importancia/protegida_cria.png"></td>
                <td><?=__("Especie Protegida con cría segura")?></td>
            </tr>
            <tr>
                <td class="text-center"><img alt="" src="/img/icons/importancia/escasa_cria.png"></td>
                <td><?=__("Especie escasa con cría segura")?></td>
            </tr>
            </tbody>
        </table>
        <br/>

        <div class="page-header">
            <h4><?=__("La lista de aves")?></h4>
        </div>
        <p>
            <?=__("La Lista de Aves de Albacete que figura en el AOA es la que realizó y actualizó la SAO en el año 2011. En ella figura con detalle la metodología utilizada. Se puede descargar en el siguiente enlace:")?>
            <a href="http://sao.albacete.org/joom/images/pdfs/lista_aves_ab_v2_2011.pdf" target="_blank">http://sao.albacete.org/joom/images/pdfs/lista_aves_ab_v2_2011.pdf</a>
            <?=__("También, en el mismo anuario, esta metodología se puede consultar accediendo al menú Especies-> Lista de Aves de Albacete, donde se halla un botón informativo de Metodología.")?>
        </p>
        <p><?=__("Se ha mejorado esta lista de aves asignando a cada especie un criterio que será utilizado por la aplicación para establecer si la cita es destacada o no. Esta clasificación de criterios se ha elaborado en función del carácter migratorio, la escasez o la protección de cada especie:")?></p>
        <br/>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><?=__("Nombre")?></th>
                    <th><?=__("Descripción")?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=__("Escasas")?></td>
                    <td><?=__("Rarezas en Albacete")?></td>
                </tr>
                <tr>
                    <td><?=__("Escasas")?></td>
                    <td><?=__("Vulnerables o En Peligro")?></td>
                </tr>
                <tr>
                    <td><?=__("Escasas")?></td>
                    <td><?=__("Aves escasas en Albacete. Distribución \"*\"")?></td>
                </tr>
                <tr>
                    <td><?=__("Escasas")?></td>
                    <td><?=__("Aves escasas en Albacete. Estima poblacional \"1\" y distribución \"*\"")?></td>
                </tr>
                <tr>
                    <td><?=__("Escasas")?></td>
                    <td><?=__("Aves que alguna vez se han reproducido en Albacete")?></td>
                </tr>
                <tr>
                    <td><?=__("Escasas")?></td>
                    <td><?=__("Especies migradoras")?></td>
                </tr>
                <tr>
                    <td><?=__("Migradoras")?></td>
                    <td><?=__("Especies estivales")?></td>
                </tr>
                <tr>
                    <td><?=__("Migradoras")?></td>
                    <td><?=__("Especies invernantes")?></td>
                </tr>
                <tr>
                    <td><?=__("Destacables")?></td>
                    <td><?=__('Especies más abundantes pero con menos de 10 citas, distribución "**" y "***", abundancia "2" y catalogadas en LR como "NT" o "LC"')?></td>
                </tr>
                <tr>
                    <td><?=__("Abundantes")?></td>
                    <td><?=__('Especies consideradas abundantes: abundancia "3-5", distribución "****" y como NC en el CR')?></td>
                </tr>
            </tbody>
        </table>
        <p><?=__('Asimismo, se ha completado la lista de aves añadiendo la información del estatus reproductor de cada especie en la provincia de Albacete y que puede consultarse en su correspondiente ficha y también en cada cita.')?></p>
        <br/>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><?=__("Nombre")?></th>
                    <th><?=__("Descripción")?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=__("No reproductor")?></td>
                    <td><?=__("Nunca se ha reproducido en la provincia")?></td>
                </tr>
                <tr>
                    <td><?=__("Reproductor histórico")?></td>
                    <td><?=__("No se reproduce pero se conocen datos antiguos de nidificaciones")?></td>
                </tr>
                <tr>
                    <td><?=__("Reproductor extinguido")?></td>
                    <td><?=__("No se reproduce pero lo hacía con regularidad hasta hace menos de 10 años")?></td>
                </tr>
                <tr>
                    <td><?=__("Reproductor ocasional")?></td>
                    <td><?=__("Se ha reproducido alguna vez y generalmente muy pocas parejas")?></td>
                </tr>
                <tr>
                    <td><?=__("Reproducción incierta")?></td>
                    <td><?=__("Se ha reproducido alguna vez pero no se conocen datos en los últimos años sobre su reproducción en la provincia")?></td>
                </tr>
                <tr>
                    <td><?=__("Reproductor escaso")?></td>
                    <td><?=__("Se reproduce con cierta regularidad pero en números muy bajos")?></td>
                </tr>
                <tr>
                    <td><?=__("Reproductor frecuente")?></td>
                    <td><?=__("Se reproduce con regularidad aunque puede que algunos años no lo haga")?></td>
                </tr>
                <tr>
                    <td><?=__("Reproductor habitual")?></td>
                    <td><?=__("Se reproduce todos los años")?></td>
                </tr>
                <tr>
                    <td><?=__("Reproductor posible")?></td>
                    <td><?=__("No se reproduce ni lo ha hecho pero se tienen indicios de que lo pueda estar haciendo o lo haya hecho alguna vez")?></td>
                </tr>
                <tr>
                    <td><?=__("Reproductor desconocido")?></td>
                    <td><?=__("Se desconoce su estatus reproductivo")?></td>
                </tr>
            </tbody>
        </table>
        <br/>

        <div class="page-header">
            <h4><?=__("Elaboración los comentarios de las especies")?></h4>
        </div>
        <p><?=__("El comentario que aparece en la ficha de cada especie es el que figura en el Anuario Ornitológico de Albacete de los 1997 y 1998 en su versión impresa cuya referencia bibliográfica es la siguiente:")?></p>
        <div class="well" style="margin-top: 20px">
            <blockquote style="margin-bottom: 0">
                <p><b><?=__("SAO (2001). Anuario Ornitológico de Albacete (1997 y 1998). Instituto de Estudios Albacetenses. Albacete.")?></b></p>
            </blockquote>
        </div>
        <p>
            <?=__("Estos comentarios se irán actualizando en los próximos meses. Para su elaboración se recogerá la información más actualizada hasta el momento. Se extraerá de los datos que SAO tiene archivados así como del propio AOA. Se revisarán principalmente los Atlas de aves y las monografías publicadas por")?>
            <a href="http://www.seo.org" target="_blank">SEO/BirdLife</a>
        </p>
        <p><?=__('En la elaboración del apartado de migración, los datos proceden fundamentalmente del "Banco de datos de anillamiento del remite ICONA - Ministerio de Medio Ambiente, año. Datos de anillamiento y recuperaciones en España. Ministerio de Agricultura, Alimentación y Medio Ambiente, SEO/BirdLife, ICO, EBD-CSIC y GOB. Madrid"')?></p>
        <br/>

        <div class="page-header">
            <h4><?=__('Localización provincial')?></h4>
        </div>
        <p><?=__('En la aplicación se han demarcado cuatro formas de localización espacial de la provincia: por localidades, por municipios, por comarcas y por cuadrículas UTM 10x10')?></p>
        <ul>
            <li><p><?=__('<b>Localidades o lugares</b>. En esta demarcación se indica el lugar, que normalmente suele coincidir con el topónimo de los mapas geográficos, o con los nombres locales  por los que son conocidos. Además, se especifica el término municipal y comarca al que pertenece y su cuadrícula UTM 10x10.')?></p></li>
            <li><p><?=__('<b>Municipios</b>. Se muestran los 87 municipios de la provincia de Albacete. También se especifica la comarca a la que pertenece.')?></p></li>
            <li><p><?=__('<b>Comarcas</b>. Para la delimitación de las comarcas, se sigue la demarcación administrativa actual, es decir, las mancomunidades de Albacete que incluye 7 comarcas. Figura también la comarca de Ruidera, en la provincia de Ciudad Real, y que se incluye debido a que el Parque Natural de las Lagunas de Ruidera se considera como un ecosistema conjunto, y se incluyen algunas citas de lagunas que administrativamente corresponden a la provincia de Ciudad Real.')?></p></li>
            <li>
                <p>
                    <?=__('<b>Cuadrículas UTM 10x10</b>.  Se muestran las 189 cuadrículas en las que se incluye la provincia de Albacete. Para cada cuadrícula se proporciona información de la/s comarcas y el/los municipio/s a los que pertenece/n. En')?>
                    <a href="http://es.wikipedia.org/wiki/Sistema_de_coordenadas_universal_transversal_de_Mercator" target="_blank"><?=__('este enlace')?></a>.
                </p>
            </li>
        </ul>
        <br/>

        <div class="page-header">
            <h4><?=__('Estadísticas de las citas')?></h4>
        </div>
        <p><?=__('Se pueden obtener gráficos de abundancia absoluta para cada especie. Además, el gráfico representado se puede guardar para su posterior consulta. Es posible definir unos parámetros de búsqueda y obtener multitud de gráficos. Las opciones de búsqueda son:')?></p>
        <ul>
            <li>
                <p><?=__('<b>Tipo de abundancia</b>, por número de aves o por número de citas.')?></p>
            </li>
            <li>
                <p><?=__('<b>Zona geográfica</b>, limitando el gráfico a una división por localidad,  cuadrícula UTM, municipio o provincial.')?></p>
            </li>
            <li>
                <p><?=__('<b>Escala temporal</b>, pudiendo buscar por años calendarios, intervalos de fechas e intervalos de años.')?></p>
            </li>
        </ul>
        <br/>

        <div class="page-header">
            <h4><?=__('Mapas de distribución')?></h4>
        </div>
        <p><?=__('ara cada especie se representa un mapa provincial dividido en cuadrículas UTM o  municipios. Este mapa sirve para conocer la distribución y abundancia de cada especie. Se representan tres tipos de mapas:')?></p>
        <ul>
            <li>
                <p><?=__('<b>Mapa de distribución geográfica</b>. Se colorea en gris los municipios o cuadrículas UTM con presencia de la especie.')?>/p>
            </li>
            <li>
                <p><?=__('<b>Mapa de distribución cuantitativa</b>. Se representa el total de aves acumulado de las observaciones registradas en AOA. Así,  se colorea la abundancia según la división geográfica elegida siguiendo la siguiente escala:')?>/p>
                <ol>
                    <li><p><?=__('Rojo, escasa, hasta 10 aves.')?></p></li>
                    <li><p><?=__('Amarillo, común, entre 11 y 100 aves.')?></p></li>
                    <li><p><?=__('Verde, muy común, más de 100 aves.')?></p></li>
                </ol>
            </li>
            <li>
                <p><?=__('<b>Mapa de reproducción</b>. Se representa la categoría de reproducción de mayor exactitud  teniendo en cuenta las citas registradas y según la división geográfica elegida. Se representan hasta cinco colores:')?>/p>
                <ol>
                    <li><p><?=__('Gris, sin información.')?></p></li>
                    <li><p><?=__('Negro, se conoce con seguridad que la especie no cría en esa zona (según los datos de AOA).')?></p></li>
                    <li><p><?=__('Rojo, cuando la reproducción es posible.')?></p></li>
                    <li><p><?=__('Amarillo, la reproducción es probable.')?></p></li>
                    <li><p><?=__('Verde, la reproducción ha sido confirmada.')?></p></li>
                </ol>
            </li>
        </ul>
        <br/>

        <div class="page-header">
            <h4><?=__('Fuentes de las citas')?></h4>
        </div>
        <p>
            <?=__('Para cada cita, se informa de cual es su origen. Para citas obtenidas por el propio observador se citará como “Observaciones personales”. Si la cita proveniese de otra fuente ésta es indicaría. Ejemplos de fuentes son: el archivo de la SAO, Prontuario de la revista Sabuco del IEA, revista Quercus, foros de aves como Avesforum o Anillaforum, páginas web como Reservoir Birds, Rare Birds in Spain,… Si el usuario necesita una nueva fuente, sólo deberá comunicarlo a los administradores a través del correo electrónico')?>
            <a href="mailto:anuario@sao.albacete.org">anuario@sao.albacete.org</a>
            <?=__('y será creada')?>
        </p>
        <br/>

        <div class="page-header">
            <h4><?=__('Estudios')?></h4>
        </div>
        <p><?=__('En este apartado se indicará si la cita forma parte de algún estudio o censo llevado a cabo por SAO, SEO/Birdlife, Universidad, etc. De no formar parte de ningún estudio, figurará como "Observación personal, no forma parte de ningún estudio". Se irán creando categorías nuevas conforme se vayan necesitando.')?></p>
        <br/>

        <div class="page-header">
            <h4><?=__('Datos de reproducción')?></h4>
        </div>
        <p>
            <?=__('En todas las citas es posible añadir el dato de reproducción que se ha observado en la observación.  Es posible asignar hasta cinco categorías de cría, para lo cual se han seguido las evidencias de cría que considera la')?>
            <a href="http://www.ebcc.info/trim.html" target="_blank"><?=__('EBCC (Comité Europeo de Censos de Aves)')?></a>
        </p>
        <ol>
            <li><p><?=__('Desconocido o no  anotado')?></p></li>
            <li><p><?=__('No cría')?></p></li>
            <li>
                <p><?=__('Reproducción posible')?></p>
                <ul>
                    <li><p><?=__('Especie vista en época adecuada y hábitat de cría apropiado')?></p></li>
                </ul>
            </li>
            <li>
                <p><?=__('Reproducción probable')?></p>
                <ul>
                    <li><p><?=__('Macho con cantos territoriales')?></p></li>
                    <li><p><?=__('Ave o pareja con territorio establecido (peleas de machos, persecuciones, acosos a otras especies…)')?></p></li>
                    <li><p><?=__('Cortejo, parada nupcial, comportamiento de disuasión ante depredadores...')?></p></li>
                    <li><p><?=__('Construcción de nido, aporte de material, entradas en agujeros, presencia de placa incubatriz o de protuberancia cloacal...')?></p></li>
                </ul>
            </li>
            <li>
                <p><?=__('Reproducción comprobada')?></p>
                <ul>
                    <li><p><?=__('Comportamiento de distracción o fingimiento de heridas por parte de adultos.')?></p></li>
                    <li><p><?=__('Nido usado en el año, o cáscaras de huevo que puedan asignarse a una especie.')?></p></li>
                    <li><p><?=__('Nido usado en el año, o cáscaras de huevo que puedan asignarse a una especie.')?></p></li>
                    <li><p><?=__('Adultos con cebo o saco fecal en pico.')?></p></li>
                    <li><p><?=__('Nido ocupado, con ave incubando, huevos o pollos.')?></p></li>
                </ul>
            </li>
        </ol>

    </fieldset>
</div>

<!-- RAREZAS LOCALES -->
<div id="modalRarezasLocales" class="modal hide fade" tabindex="-1"
     role="dialog" aria-labelledby="modalRarezasLocalesLabel"
     aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"
                aria-hidden="true">×</button>
        <h4 id="modalRarezasLocalesLabel"><?php echo __("Lista de rarezas locales");?></h4>
    </div>
    <div class="modal-body">
        <?php echo $this->element('Especie/tablaRarezasLocales'); ?>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo __("Cerrar");?></button>
    </div>
</div>

<!-- Pie -->
<?php
$this->start('pie');
echo $this->element('/pie');
$this->end();
?>
