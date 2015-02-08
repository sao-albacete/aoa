<?php 

    /**
     * CSS
     */
    $this->Html->css(array(
        'datatables-bootstrap',
        "Inicio/index"
    ), null, array('inline' => false));
    
    /**
     * Javascript
     */
    $this->Html->script(array(
        '/plugin/DataTables-1.9.4/media/js/jquery.dataTables.min',
        'datatables-bootstrap',
        '/plugin/yoxview/yoxview-init',
        'Inicio/index'
    ), array('inline' => false));
?>

<!-- Cabecera -->
<?php 
    $this->start('cabecera');        
    echo $this->element('/cabecera');
    $this->end(); 
?>

<!-- Menu -->
<?php 
    $this->start('menu');        
    echo $this->element('/menu');
    $this->end(); 
?>

<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <span class="label label-info">Aviso</span>
    &nbsp;
    <?=__('Las citas registradas en el anuario antes del año 1999 y durante el periodo 2009-2013 serán introducidas a lo largo de los próximos meses.'); ?>
</div>

<fieldset>
    <legend><span><?=__("Últimas 100 citas");?></span></legend>
        
    <table id="tabla_citas" class="table table-striped table-bordered table-hover table-condensed">
        <thead>
            <tr>
                <th><?=__("Ver detalle");?></th>
                <th><?=__("Importancia");?></th>
                <th><?=__("Especie");?></th>
                <th><?=__("Fecha");?></th>
                <th><?=__("Lugar");?></th>
                <th><?=__("Número de Aves");?></th>
                <th><?=__("Observador");?></th>
                <th><?=__("Colaboradores");?></th>
                <th><?=__("Clase de Reproducción");?></th>
                <th><?=__("Criterio de Selección");?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="100%" class="dataTables_empty"><?=__("Cargando citas...");?> <img src="/img/gif/cargando_barra_mini.gif"></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th><?=__("Ver detalle");?></th>
                <th><?=__("Importancia");?></th>
                <th><?=__("Especie");?></th>
                <th><?=__("Fecha");?></th>
                <th><?=__("Lugar");?></th>
                <th><?=__("Número de Aves");?></th>
                <th><?=__("Observador");?></th>
                <th><?=__("Colaboradores");?></th>
                <th><?=__("Clase de Reproducción");?></th>
                <th><?=__("Criterio de Selección");?></th>
            </tr>
        </tfoot>
    </table>
    
    <br>
</fieldset>

<fieldset>
    <legend><span><?=__("Últimas fotos");?></span></legend>
    
    <?php if(count($ultimasFotos) > 0) : ?>
        <ul class="thumbnails yoxview">
            <?php foreach ($ultimasFotos as $foto) : ?>

                <li class="span3">
                    <div class="thumbnail text-center">
                        <a href="<?=$foto['Fichero']['ruta'].$foto['Fichero']['nombreFisico']?>" class="thumbnail">
                            <img src="<?=$foto['Fichero']['ruta'].$foto['Fichero']['nombreFisico']?>"
                                 alt="<?=$foto['Especie']['nombreComun']?>"
                                 title="<?=$foto['Especie']['genero']." ".$foto['Especie']['especie']." ".$foto['Especie']['subespecie']?>">
                        </a>
                        <h3><?=$foto['Especie']['nombreComun']?></h3>
                        <p><?=__('Foto realizada por ') . $foto['ObservadorPrincipal']['nombre']. __(' en ') . $foto['Municipio']['nombre'] . __(' el ') . date_format(date_create($foto['Cita']['fechaAlta']), "d/m/Y") ?></p>
                    </div>
                </li>
            <?php endforeach ?>
        </ul>
    <?php else : ?>
        <div class="thumbnail" style="width: 360px; height: 270px;">
        <img src="/img/messages/AAAAAA&text=No+hay+fotos_360x270.gif" />
        </div>
    <?php endif ?>
    <br>
    
</fieldset>

<!-- Pie -->
<?php 
    $this->start('pie');        
    echo $this->element('/pie');
    $this->end(); 
?>