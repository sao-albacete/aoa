<?php
// Informamos el título
$this->set('title_for_layout', 'Lista de Aves de la Provincia de Albacete');

/**
 * CSS
 */
$this->Html->css(array(
    'Especie/lista_ab'
), null, array(
    'inline' => false
));

/**
 * Javascript
 */
$this->Html->script(array(
    '/plugin/DataTables-1.9.4/media/js/jquery.dataTables.min',
    '/plugin/DataTables-1.9.4/extras/FixedHeader/js/FixedHeader'
), array(
    'inline' => false
));

// Menu
$this->start('menu');
echo $this->element('/menu');
$this->end();
?>

<script type="text/javascript">
<!--
$(document).ready(function(){
    
    var tbListaAvesAb = $('#tbListaAvesAb').DataTable({
        "bPaginate": false,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": false,
        "bInfo": false,
        "bAutoWidth": false,
        "oLanguage": {
            "sSearch": "Buscar:"
        }
    });
    new $.fn.dataTable.FixedHeader(tbListaAvesAb);
});
//-->
</script>

<!-- Cuerpo -->
<div>
    <fieldset>
        <legend>
            <?php echo __('Lista de Aves de la Provincia de Albacete'); ?>
            <a href="#modalMetodologia" role="button" data-toggle="modal"
                class="btn btn-small btn-info pull-right help-button"> <i
                class="icon-info-sign"></i> 
                    <?php echo __("Metodología");?>
            </a>
        </legend>

        <table id="tbListaAvesAb"
            class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="vertical-align: middle;"><?php echo __("Nº Citas");?></th>
                    <th style="vertical-align: middle;"><?php echo __("Ficha");?></th>
                    <th style="vertical-align: middle;"><?php echo __("Nombre Común");?></th>
                    <th style="vertical-align: middle;"><?php echo __("Familia");?></th>
                    <th style="vertical-align: middle;"><?php echo __("Género");?></th>
                    <th style="vertical-align: middle;"><?php echo __("Especie");?></th>
                    <th style="vertical-align: middle;"><?php echo __("Subespecie");?></th>
                    <th style="vertical-align: middle;"><a
                        href="#modalEstatusProvincialAb" data-toggle="modal"><?php echo __("Estatus Provincial Albacete");?></a></th>
                    <th style="text-align: center;"><a
                        href="#modalDistribucionProvincialAb" data-toggle="modal"><?php echo __("Distribución Provincial Albacete");?></a></th>
                    <th><a href="#modalEstatusNacional" data-toggle="modal"><?php echo __("Estatus Nacional");?></a></th>
                    <th><a href="#modalProteccionLr" data-toggle="modal"><?php echo __("Estado de Conservación en España (Libro Rojo)");?></a></th>
                    <th><a href="#modalProteccionClm" data-toggle="modal"><?php echo __("Nivel Protección Castilla-La Mancha");?></a></th>
                </tr>
            </thead>
            <tbody>
<?php
foreach ($especies_ab as $familia) {
    
    // echo "<tr><td style='background-color: #DFF0D8; font-size: 20px; text-transform: uppercase; font-style:italic;' colspan='100%'>".$familia[0]['Familia']['nombre']."</td></tr>";
    
    foreach ($familia as $especie_ab) {
        echo "<tr>";
        echo "<td style='text-align: center;'>" . count($especie_ab['Citas']) . "</td>";
        echo "<td style='text-align: center;'><a href='/especie/view/id:" . $especie_ab['Especie']['id'] . "' title='" . __("Ver ficha de la especie") . "'><img src='/img/icons/fugue-icons-3.5.6/icons/magnifier-left.png' title='Ver ficha de la especie' alt='Ver detalle'/></a></td>";
        echo "<td title='".$especie_ab['Especie']['nombreIngles']."'>" . $especie_ab['Especie']['nombreComun'] . "</td>";
        echo "<td><i>" . $familia[0]['Familia']['nombre'] . "</i></td>";
        echo "<td><i>" . $especie_ab['Especie']['genero'] . "</i></td>";
        echo "<td><i>" . $especie_ab['Especie']['especie'] . "</i></td>";
        echo "<td><i>" . $especie_ab['Especie']['subespecie'] . "</i></td>";
        echo "<td style='text-align: center; background-color: #B3DCB3;' title ='" . $especie_ab['EstatusCuantitativoAb']['nombre'] . "'>" . $especie_ab['EstatusCuantitativoAb']['codigo'] . "</td>";
        echo "<td style='text-align: center; background-color: #B3DCB3;font-size: 28px;' title ='" . $especie_ab['DistribucionAb']['nombre'] . "'>" . $especie_ab['DistribucionAb']['codigo'] . "</td>";
        echo "<td style='text-align: center;'>" . $especie_ab['Especie']['codigoEstatusEsp'] . "</td>";
        echo "<td style='text-align: center;' title ='" . $especie_ab['ProteccionLr']['nombre'] . "'>" . $especie_ab['ProteccionLr']['codigo'] . "</td>";
        echo "<td style='text-align: center;' title ='" . $especie_ab['ProteccionClm']['nombre'] . "'>" . $especie_ab['ProteccionClm']['codigo'] . "</td>";
        echo "</tr>";
    }
}
?>
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
        <h4 id="modalProteccionLrLabel"><?php echo __("Estado de Conservación en España (Libro Rojo)");?></h4>
    </div>
    <div class="modal-body">
        <?php echo $this->element('Especie/tablaProteccionLr'); ?>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo __("Cerrar");?></button>
    </div>
</div>

<!-- Ventana de información de nivel de proteccion CLM -->
<div id="modalProteccionClm" class="modal hide fade" tabindex="-1"
    role="dialog" aria-labelledby="modalProteccionClmLabel"
    aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"
            aria-hidden="true">×</button>
        <h4 id="modalProteccionClmLabel"><?php echo __("Nivel Protección Castilla-La Mancha");?></h4>
    </div>
    <div class="modal-body">
        <?php echo $this->element('Especie/tablaProteccionClm'); ?>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo __("Cerrar");?></button>
    </div>
</div>

<!-- Ventana de información de nivel de estatus cuantitativo AB -->
<div id="modalEstatusProvincialAb" class="modal hide fade" tabindex="-1"
    role="dialog" aria-labelledby="modalEstatusProvincialAbLabel"
    aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"
            aria-hidden="true">×</button>
        <h4 id="modalEstatusProvincialAbLabel"><?php echo __("Estatus Provincial Albacete");?></h4>
    </div>
    <div class="modal-body">
        <?php echo $this->element('Especie/tablaEstatusAb'); ?>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo __("Cerrar");?></button>
    </div>
</div>

<!-- Ventana de información de nivel de distribucion AB -->
<div id="modalDistribucionProvincialAb" class="modal hide fade"
    tabindex="-1" role="dialog"
    aria-labelledby="modalDistribucionProvincialAbLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"
            aria-hidden="true">×</button>
        <h4 id="modalDistribucionProvincialAbLabel"><?php echo __("Distribución Provincial Albacete");?></h4>
    </div>
    <div class="modal-body">
        <?php echo $this->element('Especie/tablaDistribucionAb'); ?>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo __("Cerrar");?></button>
    </div>
</div>

<!-- Ventana de información de estatus nacional -->
<div id="modalEstatusNacional" class="modal hide fade" tabindex="-1"
    role="dialog" aria-labelledby="modalEstatusNacionalLabel"
    aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"
            aria-hidden="true">×</button>
        <h4 id="modalEstatusNacionalLabel"><?php echo __("Estatus Nacional");?></h4>
    </div>
    <div class="modal-body">
        <?php echo $this->element('Especie/tablaEstatusNacional'); ?>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo __("Cerrar");?></button>
    </div>
</div>

<!-- Ventana de información de la metodologia utilizada para elaborar la lista de aves de Albacete -->
<div id="modalMetodologia" class="modal hide fade" tabindex="-1"
    role="dialog" aria-labelledby="modalMetodologiaLabel"
    aria-hidden="true" style="text-align: justify;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"
            aria-hidden="true">×</button>
        <h4 id="modalMetodologiaLabel"><?php echo __("Metodología para elaborar la lista de aves de Albacete");?></h4>
    </div>
    <div class="modal-body">
        <?php echo $this->element('Especie/metodologiaListaAb'); ?>
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