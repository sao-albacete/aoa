<?php
    // Informamos el título
    $this->set('title_for_layout','Lugares');

    /**
     * CSS
     */
    $this->Html->css(array('datatables-bootstrap'), null, array('inline' => false));

    /**
     * Javascript
     */
    $this->Html->script(array(
      '/plugin/DataTables-1.9.4/media/js/jquery.dataTables',
      'datatables-bootstrap',
      'https://maps.googleapis.com/maps/api/js?key=AIzaSyCvHe5uH6Ogczm4OWoXkq8_NiwspG4oE1I',
      'https://unpkg.com/@google/markerclustererplus@4.0.1/dist/markerclustererplus.min.js',
      'common/maps/geoxml3/geoxml3.js',
      'common/maps/geoxml3/ProjectedOverlay.js',
      'Lugar/common',
      'Lugar/cluster',
    ), array('inline' => false));

    // Menu
    $this->start('menu');
    echo $this->element('/menu');
    $this->end();
?>

<script type="text/javascript">



    google.maps.event.addDomListener(window, 'load', initialize_map_cluster_index);

    $(document).ready(function() {

        /* INICIO Tabla de lugares */
        $("#tablaLugares").dataTable({
            "aLengthMenu": [[10, 25, 50], [10, 25, 50]],
            "iDisplayLength": 25,
            "sDom": "<\'row\'<\'span9\'l><\'span3\'f>r>t<\'row\'<\'span8\'i><\'span4\'p>>",
            "sWrapper": "dataTables_wrapper form-inline",
            "bPaginate": true,
            "sPaginationType": "bootstrap",
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "aoColumnDefs": [
                 { 'bSortable': false, 'aTargets': [ 0 ] }
             ],
            "bInfo": true,
            "bAutoWidth": false,
            "oLanguage": {
                "sUrl": "/lang/es/datatables.json"
            }
        });
        /* FIN Tabla de lugares */

    });

</script>

<div>
    <fieldset>
        <legend><?php echo __('Lugares'); ?></legend>

        <a href="/lugar/add" role="button"
            class="btn btn-mini btn-warning" data-toggle="modal"
            id="btnNuevoLugar"><i class="icon-plus"></i> <?php echo __("Nuevo lugar");?></a>

        <hr>
        <div class="span6" style="width:100% !important;">
            <fieldset>
                <div id="map_canvas_cluster" style="height:400px; " class="span12"></div>
            </fieldset>
        </div>
        <table id="tablaLugares" class="table table-striped table-bordered table-hover table-condensed">
            <thead>
                <tr>
                    <th><?php echo __("Ver");?></th>
                    <th><?php echo __("Lugar");?></th>
                    <th><?php echo __("Municipio");?></th>
                    <th><?php echo __("Comarca");?></th>
                    <th><?php echo __("Cuadrícula UTM");?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($lugares as $lugar) {
                        echo "<tr id='".$lugar["Lugar"]["id"]."'>";
                        echo     "<td style='text-align: center;'><a href='/lugar/view/id:".$lugar['Lugar']['id']."' title='".__("Ver detalle del lugar")."'><img src='/img/icons/search.png' title='Ver detalle del lugar' alt='Ver detalle'/></a></td>";
                        echo     "<td><a href='/cita/index?lugarId=".$lugar["Lugar"]["id"]."'>".$lugar["Lugar"]["nombre"]."</a></td>";
                        echo     "<td><a href='/cita/index?municipioId=".$lugar["Municipio"]["id"]."'>".$lugar["Municipio"]["nombre"]."</a></td>";
                        echo     "<td><a href='/cita/index?comarcaId=".$lugar["Comarca"]["id"]."'>".$lugar["Comarca"]["nombre"]."</a></td>";
                        echo     "<td><a href='/cita/index?cuadriculaUtmId=".$lugar["CuadriculaUtm"]["id"]."'>".$lugar["CuadriculaUtm"]["codigo"]."</a></td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th><?php echo __("Ver");?></th>
                    <th><?php echo __("Lugar");?></th>
                    <th><?php echo __("Municipio");?></th>
                    <th><?php echo __("Comarca");?></th>
                    <th><?php echo __("Cuadrícula UTM");?></th>
                </tr>
            </tfoot>
        </table>
    </fieldset>
</div>

<!-- Pie -->
<?php
    $this->start('pie');
    echo $this->element('/pie');
    $this->end();
?>
