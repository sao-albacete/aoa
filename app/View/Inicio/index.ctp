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

<script type="text/javascript">

    $(document).ready(function(){
        /* INICIO tabla citas */
        $("#tabla_citas").dataTable({
            "iDisplayLength": 25,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "<?=$this->Html->Url(array('controller' => 'citaAjax', 'action' => 'obtenerCitasDatatables', time(), "?" => array("iTotal" => 100))); ?>",
            "bPaginate": true,
            "sPaginationType": "bootstrap",
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ 0,6,8 ] },
                { "sClass": "text-center", "aTargets": [ 0,2,4,5,7,8 ] }
            ],
            "aoColumns": [null,null,{ "sType": "date-uk" },null,null,null,null,null,null],
            "bInfo": true,
            "bAutoWidth": false,
            "oLanguage": {
                "oAria": {
                    "sSortAscending": " - haz click o pulsa enter para ordenar ascendentemente",
                    "sSortDescending": " - haz click o pulsa enter para ordenar descendentemente"
                  },
                "oPaginate": {
                       "sFirst": "Primera",
                       "sLast": "Última",
                       "sNext": "Siguiente",
                       "sPrevious": "Anterior"
                },
                "sEmptyTable": "No hay datos disponibles",
                "sInfo": "Mostrando (_START_ de _END_) registros de un total de _TOTAL_",
                "sInfoEmpty": "No hay registros para mostrar",
                "sInfoFiltered": "- filtrando por _MAX_ registros",
                "sInfoThousands": "\'",
                "sLengthMenu": "Mostrar <select>"+
                    "<option value=\"10\">10</option>"+
                    "<option value=\"25\">25</option>"+
                    "<option value=\"50\">50</option>"+
                    "<option value=\"-1\">Todos</option>"+
                    "</select> registros",
                "sLoadingRecords": "Cargando citas...",
                "sProcessing": "Cargando citas...",
                "sSearch": "Buscar:",
                "sZeroRecords": "No hay registros que mostrar."
            }
        });
        /* FIN tabla citas */
    });

</script>

<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <p>
        <i class="icon-info-sign"></i>
        &nbsp;
        <?=__('Las citas registradas en el anuario antes del año 1999 y durante el periodo 2009-2013 serán introducidas a lo largo de los próximos meses.'); ?>
    </p>
</div>

<fieldset>
    <legend><span><?=__("Últimas 100 citas");?></span></legend>
        
    <table id="tabla_citas" class="table table-striped table-bordered table-hover table-condensed">
        <thead>
            <tr>
                <th><?=__("Ver detalle");?></th>
                <th><?=__("Especie");?></th>
                <th><?=__("Fecha");?></th>
                <th><?=__("Lugar");?></th>
                <th><?=__("Número de Aves");?></th>
                <th><?=__("Observador");?></th>
                <th><?=__("Colaboradores");?></th>
                <th><?=__("Clase de Reproducción");?></th>
                <th><?=__("Importancia");?></th>
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
                <th><?=__("Especie");?></th>
                <th><?=__("Fecha");?></th>
                <th><?=__("Lugar");?></th>
                <th><?=__("Número de Aves");?></th>
                <th><?=__("Observador");?></th>
                <th><?=__("Colaboradores");?></th>
                <th><?=__("Clase de Reproducción");?></th>
                <th><?=__("Importancia");?></th>
            </tr>
        </tfoot>
    </table>
    
    <br>
</fieldset>

<fieldset>
    <legend><span><?=__("Últimas fotos");?></span></legend>
    
    <!-- <ul class="thumbnails yoxview">-->
            <?php 
            if(count($ultimasFotos) > 0) {
                $i = 0;
                foreach ($ultimasFotos as $foto) {
                    
                    if($i % 4 == 0) {
                        echo '<ul class="thumbnails yoxview">';
                    }
                    echo '<li class="span3">';
                    echo    '<div class="thumbnail" style="text-align: center;">';
                    echo $this->Html->image($foto['Fichero']['ruta'].$foto['Fichero']['nombreFisico'], array(
                            "alt"=>$foto['Especie']['nombreComun'],
                            "url"=>$foto['Fichero']['ruta'].$foto['Fichero']['nombreFisico'],
                            "title"=>$foto['Especie']['genero']." ".$foto['Especie']['especie']." ".$foto['Especie']['subespecie']
                            )
                        );
                    echo        '<h3>'.$foto['Especie']['nombreComun'].'</h3>';
                    echo        '<p>Foto realizada por '.$foto['ObservadorPrincipal']['nombre'].' en '.$foto['Municipio']['nombre'].' el '.date_format(date_create($foto['Cita']['fechaAlta']), "d/m/Y").'</p>';
                    echo    '</div>';
                    echo '</li>';
                    
                    if(($i + 1) % 4 == 0) {
                        echo '</ul>';
                    }
                    
                    $i++;
                } 
            }
            else {
                echo '<div class="thumbnail" style="width: 360px; height: 270px;">';
                echo '<img src="/img/messages/AAAAAA&text=No+hay+fotos_360x270.gif" />';
                echo '</div>';
            }
            ?>
    <!-- </ul> -->
    
    <br>
    
</fieldset>

<!-- Pie -->
<?php 
    $this->start('pie');        
    echo $this->element('/pie');
    $this->end(); 
?>