<table class='proteccion-clm table table-striped table-bordered'>
    <thead>
    <tr>
        <th><?=__('Código')?></th>
        <th><?=__('Nombre')?></th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($info['ProteccionClm'] as $proteccionClm):?>
    <tr>
        <td style='text-align: center;'><?=$proteccionClm['ProteccionClm']['codigo']?></td>
        <td style='text-align: center;'><?=$proteccionClm['ProteccionClm']['nombre']?></td>
    </tr>
    <?php endforeach;?>

    </tbody>
</table>