<table class='proteccion-lr table table-striped table-bordered'>
    <thead>
    <tr>
        <th><?=__('Código')?></th>
        <th><?=__('Nombre')?></th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($info['ProteccionLr'] as $proteccionLr):?>
    <tr>
        <td style='text-align: center;'><?=$proteccionLr['ProteccionLr']['codigo']?></td>
        <td style='text-align: center;'><?=$proteccionLr['ProteccionLr']['nombre']?></td>
        </tr>
    <?php endforeach;?>

    </tbody>
</table>