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
            <div class="text-center"><img src="<?php echo $headerImages[0]['src']?>" alt="<img src="<?php echo $headerImages[0]['alt']?>" height="100"></div>
            <div class="carousel-caption">
                <a id="btn_registrar_usuario" href="/user/add/" class="btn btn-large btn-success pull-right"><?php echo "Registrarte";?></a>
                <h3><?php echo __("Conoce las aves de nuestra provincia");?></h3>
                <p><?php echo __("Aquí encontrarás toda la información de las especies que se ven en la provincia de Albacete.");?> <b><?php echo __("¡Ayúdanos a conocerlas mejor!");?></b></p>
            </div>
        </div>
        <div class="item">
            <div class="text-center"><img src="<?php echo $headerImages[1]['src']?>" alt="<?php echo $headerImages[1]['alt']?>"></div>
            <div class="carousel-caption">
                <a id="btn_registrar_usuario" href="/user/add/" class="btn btn-large btn-success pull-right"><?php echo "Registrarte";?></a>
                <h3><?php echo __("Tu base de datos de citas");?></h3>
                <p><?php echo __("Pordrás registrar todas tus citas de aves en la provincia de Albacete y además podrás colgar tus fotos de aves.");?></p>
            </div>
        </div>
        <div class="item">
            <div class="text-center"><img src="<?php echo $headerImages[2]['src']?>" alt="<?php echo $headerImages[2]['alt']?>"></div>
            <div class="carousel-caption">
                <a id="btn_registrar_usuario" href="/user/add/" class="btn btn-large btn-success pull-right"><?php echo "Registrarte";?></a>
                <h3><?php echo __("Ayudarás a su conservación");?></h3>
                <p><?php echo __("Con tus datos nos ayudarás a conocer mejor y poder conservar las especies amenazadas de la provincia.");?></p>
            </div>
        </div>
        <div class="item">
            <div class="text-center"><img src="<?php echo $headerImages[3]['src']?>" alt="<?php echo $headerImages[3]['alt']?>"></div>
            <div class="carousel-caption">
                <a id="btn_registrar_usuario" href="/user/add/" class="btn btn-large btn-success pull-right"><?php echo "Registrarte";?></a>
                <h3><?php echo __("¿Qué aves viven en mi municipio?");?></h3>
                <p><?php echo __("Conoce que especies viven cerca de tu casa, pueblo o lugar de vacaciones.");?></p>
            </div>
        </div>
        <div class="item">
            <div class="text-center"><img src="<?php echo $headerImages[4]['src']?>" alt="<?php echo $headerImages[4]['alt']?>"></div>
            <div class="carousel-caption">
                <a id="btn_registrar_usuario" href="/user/add/" class="btn btn-large btn-success pull-right"><?php echo "Registrarte";?></a>
                <h3><?php echo __("¿Necesitas información para hacer en estudio?");?></h3>
                <p><?php echo __("Consulta y obtén la información más actualizada y más completa sobre las las aves de Albacete.");?></p>
            </div>
        </div>
        <div class="item">
            <div class="text-center"><img src="<?php echo $headerImages[5]['src']?>" alt="<?php echo $headerImages[5]['alt']?>"></div>
            <div class="carousel-caption">
                <a id="btn_registrar_usuario" href="/user/add/" class="btn btn-large btn-success pull-right"><?php echo "Registrarte";?></a>
                <h3><?php echo __("¿Qué especies se pueden ver en cada momento?");?></h3>
                <p><?php echo __("Podrás encontrar toda la información acerca de cuándo se ven las especies.");?></p>
            </div>
        </div>
        <div class="item">
            <div class="text-center"><img src="<?php echo $headerImages[6]['src']?>" alt="<?php echo $headerImages[6]['alt']?>"></div>
            <div class="carousel-caption">
                <a id="btn_registrar_usuario" href="/user/add/" class="btn btn-large btn-success pull-right"><?php echo "Registrarte";?></a>
                <h3><?php echo __("Ponte al día sobre las aves que se están viendo en Albacete.");?></h3>
                <p><?php echo __("Encontrarás las citas más recientes sobre qué aves se están viendo en la provincia.");?></p>
            </div>
        </div>
        <div class="item">
            <div class="text-center"><img src="<?php echo $headerImages[7]['src']?>" alt="<?php echo $headerImages[7]['alt']?>"></div>
            <div class="carousel-caption">
                <a id="btn_registrar_usuario" href="/user/add/" class="btn btn-large btn-success pull-right"><?php echo "Registrarte";?></a>
                <h3><?php echo __("¿Qué especies se reproducen y qué especies invernan?");?></h3>
                <p><?php echo __("Con tus datos podremos conocer mejor la distribución y población de las aves reproductoras, migradoras e invernantes.");?></p>
            </div>
        </div>
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-cabecera" data-slide="prev">&lsaquo;</a> 
    <a class="right carousel-control" href="#carousel-cabecera" data-slide="next">&rsaquo;</a>
</div>
