<div id="carousel-cabecera" class="carousel slide">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#carousel-cabecera" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-cabecera" data-slide-to="1"></li>
        <li data-target="#carousel-cabecera" data-slide-to="2"></li>
        <li data-target="#carousel-cabecera" data-slide-to="3"></li>
        <li data-target="#carousel-cabecera" data-slide-to="4"></li>
        <li data-target="#carousel-cabecera" data-slide-to="5"></li>
        <li data-target="#carousel-cabecera" data-slide-to="6"></li>
        <li data-target="#carousel-cabecera" data-slide-to="7"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" style="background-color: black;">
        <div class="item active">
            <div class="text-center"><img src="<?=$headerImages[0]['src']?>" alt="<?=$headerImages[0]['alt']?>"></div>
            <div class="carousel-caption">
                <a href="/user/add/" class="btn btn-large btn-success pull-right" style="margin-left: 10px"><?="Registrarte";?></a>
                <a href="/especie/especies_objetivo/" class="btn btn-large btn-info pull-right"><?="Leer más...";?></a>
                <h3><?=__("Especies objetivo 2018");?></h3>
                <p><?=__("Ayúdanos a saber más sobre estas especies de las que se tiene muy poca información.");?></p>
            </div>
        </div>
        <div class="item">
            <div class="text-center"><img src="<?=$headerImages[6]['src']?>" alt="<?=$headerImages[6]['alt']?>"></div>
            <div class="carousel-caption">
                <a href="/user/add/" class="btn btn-large btn-success pull-right"><?="Registrarte";?></a>
                <h3><?=__("Ponte al día sobre las aves que se están viendo en Albacete.");?></h3>
                <p><?=__("Encontrarás las citas más recientes sobre qué aves se están viendo en la provincia.");?></p>
            </div>
        </div>
        <div class="item">
            <div class="text-center"><img src="<?=$headerImages[1]['src']?>" alt="<?=$headerImages[1]['alt']?>"></div>
            <div class="carousel-caption">
                <a href="/user/add/" class="btn btn-large btn-success pull-right"><?="Registrarte";?></a>
                <h3><?=__("¿Qué aves viven en mi municipio?");?></h3>
                <p><?=__("Conoce que especies viven cerca de tu casa, pueblo o lugar de vacaciones.");?></p>
            </div>
        </div>
        <div class="item">
            <div class="text-center"><img src="<?=$headerImages[2]['src']?>" alt="<?=$headerImages[2]['alt']?>"></div>
            <div class="carousel-caption">
                <a href="/user/add/" class="btn btn-large btn-success pull-right"><?="Registrarte";?></a>
                <h3><?=__("Tu base de datos de citas");?></h3>
                <p><?=__("Pordrás registrar todas tus citas de aves en la provincia de Albacete y además podrás colgar tus fotos de aves.");?></p>
            </div>
        </div>
        <div class="item">
            <div class="text-center"><img src="<?=$headerImages[3]['src']?>" alt="<?=$headerImages[3]['alt']?>"></div>
            <div class="carousel-caption">
                <a href="/user/add/" class="btn btn-large btn-success pull-right"><?="Registrarte";?></a>
                <h3><?=__("Ayudarás a su conservación");?></h3>
                <p><?=__("Con tus datos nos ayudarás a conocer mejor y poder conservar las especies amenazadas de la provincia.");?></p>
            </div>
        </div>
        <div class="item">
            <div class="text-center"><img src="<?=$headerImages[4]['src']?>" alt="<?=$headerImages[4]['alt']?>"></div>
            <div class="carousel-caption">
                <a href="/user/add/" class="btn btn-large btn-success pull-right"><?="Registrarte";?></a>
                <h3><?=__("¿Necesitas información para hacer en estudio?");?></h3>
                <p><?=__("Consulta y obtén la información más actualizada y más completa sobre las las aves de Albacete.");?></p>
            </div>
        </div>
        <div class="item">
            <div class="text-center"><img src="<?=$headerImages[5]['src']?>" alt="<?=$headerImages[5]['alt']?>"></div>
            <div class="carousel-caption">
                <a href="/user/add/" class="btn btn-large btn-success pull-right"><?="Registrarte";?></a>
                <h3><?=__("¿Qué especies se pueden ver en cada momento?");?></h3>
                <p><?=__("Podrás encontrar toda la información acerca de cuándo se ven las especies.");?></p>
            </div>
        </div>
        <div class="item">
            <div class="text-center"><img src="<?=$headerImages[7]['src']?>" alt="<?=$headerImages[7]['alt']?>"></div>
            <div class="carousel-caption">
                <a href="/user/add/" class="btn btn-large btn-success pull-right"><?="Registrarte";?></a>
                <h3><?=__("¿Qué especies se reproducen y qué especies invernan?");?></h3>
                <p><?=__("Con tus datos podremos conocer mejor la distribución y población de las aves reproductoras, migradoras e invernantes.");?></p>
            </div>
        </div>
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-cabecera" data-slide="prev">&lsaquo;</a>
    <a class="right carousel-control" href="#carousel-cabecera" data-slide="next">&rsaquo;</a>
</div>
