<?php 
    // Informamos el título
    $this->set('title_for_layout','Mis lugares');
    
    /**
     * CSS
     */
    $this->Html->css(array('datatables-bootstrap', 'Lugar/mis_lugares'), null, array('inline' => false));
    
    /**
     * Javascript
     */
    $this->Html->script(array('/plugin/DataTables-1.9.4/media/js/jquery.dataTables', 'datatables-bootstrap','/plugin/bootbox/bootbox.min','pleaseWaitDialog', 'Lugar/mis_lugares'), array('inline' => false));
    
    // Menu
    $this->start('menu');        
    echo $this->element('/menu');
    $this->end(); 
?>

<div>
    <fieldset>
        <legend><?=__('Mis lugares'); ?></legend>
        
        <a href="/lugar/add" role="button"
            class="btn btn-small btn-primary" data-toggle="modal"
            id="btnNuevoLugar"><i class="icon-plus"></i> <?=__("Nuevo lugar");?></a>
            
        <hr>

        <table id="tablaLugares" class="table table-striped table-bordered table-hover table-condensed">
            <thead>
                <tr>
                    <th><?=__("Acciones");?></th>
                    <th><?=__("Lugar");?></th>
                    <th><?=__("Municipio");?></th>
                    <th><?=__("Comarca");?></th>
                    <th><?=__("Cuadrícula UTM");?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lugares as $lugar) : ?>
                        <tr id='<?=$lugar["Lugar"]["id"]?>'>
                            <td style='text-align: center;'>
                            <a href='javascript: eliminarLugar(<?=$lugar['Lugar']['id']?>, "<?=$lugar['Lugar']['nombre']?>");' title='<?=__("Eliminar lugar")?>'><img src='/img/icons/delete.png' title='Eliminar el lugar' alt='Eliminar lugar'/></a>&nbsp;&nbsp;
                            <a href='/lugar/edit/id:<?=$lugar['Lugar']['id']?>' title='<?=__("Editar lugar")?>'><img src='/img/icons/edit.png' title='Editar lugar' alt='Editar lugar'/></a>&nbsp;&nbsp;
                            <a href='/lugar/view/id:<?=$lugar['Lugar']['id']?>' title='<?=__("Ver detalle del lugar")?>'><img src='/img/icons/search.png' title='Ver detalle del lugar' alt='Detalle lugar'/></a>
                            </td>
                            <td><a href='/cita/index?lugarId=<?=$lugar["Lugar"]["id"]?>'><?=$lugar["Lugar"]["nombre"]?></a></td>
                            <td><a href='/cita/index?municipioId=<?=$lugar["Municipio"]["id"]?>'><?=$lugar["Municipio"]["nombre"]?></a></td>
                            <td><a href='/cita/index?comarcaId=<?=$lugar["Comarca"]["id"]?>'><?=$lugar["Comarca"]["nombre"]?></a></td>
                            <td style='text-align: center;'><a href='/cita/index?cuadriculaUtmId=<?=$lugar["CuadriculaUtm"]["id"]?>'><?=$lugar["CuadriculaUtm"]["codigo"]?></a></td>
                        </tr>
                <?php endforeach ?>
            </tbody>
            <tfoot>
                <tr>
                    <th><?=__("Acciones");?></th>
                    <th><?=__("Lugar");?></th>
                    <th><?=__("Municipio");?></th>
                    <th><?=__("Comarca");?></th>
                    <th><?=__("Cuadrícula UTM");?></th>
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