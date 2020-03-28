<?php
// Informamos el título
$this->set('title_for_layout', 'Lista de Aves de la Provincia de Albacete');

/**
 * CSS
 */
$this->Html->css(array(
    'Especie/lista_ab',
), null, array(
    'inline' => false
));

/**
 * Javascript
 */
$this->Html->script(array(
    '/plugin/DataTables-1.9.4/media/js/jquery.dataTables.min',
    '/plugin/DataTables-1.9.4/extras/FixedHeader/js/FixedHeader',
    'Especie/lista_ab',
), array(
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
        <legend>
            <?=__('Lista de Aves de la Provincia de Albacete')?>
            <a href="#modalMetodologia" role="button" data-toggle="modal" class="btn btn-small btn-info pull-right help-button">
                <i class="icon-info-sign"></i>&nbsp;&nbsp;<?=__("Metodología");?>
            </a>
        </legend>

        <div class="well text-center">
            <h4><?=__('Número de especies vistas en la provincia')?> <span style="margin-left: 20px">&#10140;</span> <span class="badge badge-success especies-ab-count"><?=$especiesAbCount?></span></h4>
        </div>

        <table id="tbListaAvesAb" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="vertical-align: middle"><?=__("Nº Citas");?></th>
                    <th style="vertical-align: middle"><?=__("Ficha");?></th>
                    <th style="vertical-align: middle"><?=__("Nombre Común");?></th>
                    <th style="vertical-align: middle"><?=__("Familia");?></th>
                    <th style="vertical-align: middle"><?=__("Especie");?></th>
                    <th style="vertical-align: middle"><?=__("Subespecie");?></th>
                    <th title ='<?=__("Estatus Provincial Albacete");?>'><a href="#modalEstatusProvincialAb" data-toggle="modal"><?=__("EP");?></a></th>
                    <th title ='<?=__("Distribución Provincial Albacete");?>'><a href="#modalDistribucionProvincialAb" data-toggle="modal"><?=__("DP");?></a></th>
                    <th title ='<?=__("Estatus Nacional");?>'><a href="#modalEstatusNacional" data-toggle="modal"><?=__("EN");?></a></th>
                    <th title ='<?=__("Estado de Conservación en España (Libro Rojo)");?>'><a href="#modalProteccionLr" data-toggle="modal"><?=__("LR");?></a></th>
                    <th title ='<?=__("Nivel Protección Castilla-La Mancha");?>'><a href="#modalProteccionClm" data-toggle="modal"><?=__("CR");?></a></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($especies_ab as $especie_ab) : ?>
                    <tr>
                        <td style='text-align: center;'><?=$especie_ab['Citas']?></td>
                        <td style='text-align: center;'><a href='/especie/view/id:<?=$especie_ab['Especie']['id']?>' title='<?=__("Ver ficha de la especie")?>'><img src='/img/icons/search.png' title='Ver ficha de la especie' alt='Ver detalle'/></a></td>
                        <td title='<?=$especie_ab['Especie']['nombreIngles']?>'><?=$especie_ab['Especie']['nombreComun']?></td>
                        <td><i><?=$especie_ab['Familia']['nombre']?></i></td>
                        <td><i><?=$especie_ab['Especie']['genero'] . ' ' . $especie_ab['Especie']['especie']?></i></td>
                        <td><i><?=$especie_ab['Especie']['subespecie']?></i></td>
                        <td style='text-align: center; background-color: #B3DCB3;' title ='<?=$especie_ab['EstatusCuantitativoAb']['nombre']?>'><?=$especie_ab['EstatusCuantitativoAb']['codigo']?></td>
                        <td style='text-align: center; background-color: #B3DCB3;font-size: 28px;' title ='<?=$especie_ab['DistribucionAb']['nombre']?>'><?=$especie_ab['DistribucionAb']['codigo']?></td>
                        <td style='text-align: center;'><?=$especie_ab['Especie']['codigoEstatusEsp']?></td>
                        <td style='text-align: center;' title ='<?=$especie_ab['ProteccionLr']['nombre']?>'><?=$especie_ab['ProteccionLr']['codigo']?></td>
                        <td style='text-align: center;' title ='<?=$especie_ab['ProteccionClm']['nombre']?>'><?=$especie_ab['ProteccionClm']['codigo']?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </fieldset>
</div>

<!-- Ventana de información de nivel de proteccion LR -->
<div id="modalProteccionLr" class="modal hide fade" tabindex="-1"
    role="dialog" aria-labelledby="modalProteccionLrLabel"
    aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"
            aria-hidden="true">×</button>
        <h4 id="modalProteccionLrLabel"><?=__("Estado de Conservación en España (Libro Rojo)");?></h4>
    </div>
    <div class="modal-body">
        <?=$this->element('Especie/tablaProteccionLr'); ?>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?=__("Cerrar");?></button>
    </div>
</div>

<!-- Ventana de información de nivel de proteccion CLM -->
<div id="modalProteccionClm" class="modal hide fade" tabindex="-1"
    role="dialog" aria-labelledby="modalProteccionClmLabel"
    aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"
            aria-hidden="true">×</button>
        <h4 id="modalProteccionClmLabel"><?=__("Nivel Protección Castilla-La Mancha");?></h4>
    </div>
    <div class="modal-body">
        <?=$this->element('Especie/tablaProteccionClm'); ?>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?=__("Cerrar");?></button>
    </div>
</div>

<!-- Ventana de información de nivel de estatus cuantitativo AB -->
<div id="modalEstatusProvincialAb" class="modal hide fade" tabindex="-1"
    role="dialog" aria-labelledby="modalEstatusProvincialAbLabel"
    aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"
            aria-hidden="true">×</button>
        <h4 id="modalEstatusProvincialAbLabel"><?=__("Estatus Provincial Albacete");?></h4>
    </div>
    <div class="modal-body">
        <?=$this->element('Especie/tablaEstatusAb'); ?>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?=__("Cerrar");?></button>
    </div>
</div>

<!-- Ventana de información de nivel de distribucion AB -->
<div id="modalDistribucionProvincialAb" class="modal hide fade"
    tabindex="-1" role="dialog"
    aria-labelledby="modalDistribucionProvincialAbLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"
            aria-hidden="true">×</button>
        <h4 id="modalDistribucionProvincialAbLabel"><?=__("Distribución Provincial Albacete");?></h4>
    </div>
    <div class="modal-body">
        <?=$this->element('Especie/tablaDistribucionAb'); ?>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?=__("Cerrar");?></button>
    </div>
</div>

<!-- Ventana de información de estatus nacional -->
<div id="modalEstatusNacional" class="modal hide fade" tabindex="-1"
    role="dialog" aria-labelledby="modalEstatusNacionalLabel"
    aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"
            aria-hidden="true">×</button>
        <h4 id="modalEstatusNacionalLabel"><?=__("Estatus Nacional");?></h4>
    </div>
    <div class="modal-body">
        <?=$this->element('Especie/tablaEstatusNacional'); ?>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?=__("Cerrar");?></button>
    </div>
</div>

<!-- Ventana de información de la metodologia utilizada para elaborar la lista de aves de Albacete -->
<div id="modalMetodologia" class="modal hide fade" tabindex="-1"
    role="dialog" aria-labelledby="modalMetodologiaLabel"
    aria-hidden="true" style="text-align: justify;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"
            aria-hidden="true">×</button>
        <h4 id="modalMetodologiaLabel"><?=__("Metodología para elaborar la lista de aves de Albacete");?></h4>
    </div>
    <div class="modal-body">
        <?=$this->element('Especie/metodologiaListaAb'); ?>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?=__("Cerrar");?></button>
    </div>
</div>

<!-- Pie -->
<?php
    $this->start('pie');
    echo $this->element('/pie');
    $this->end();
?>
