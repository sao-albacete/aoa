<table class='distribucion-ab table table-striped table-bordered'>
    <thead>
    <tr>
        <th><?=__('Código')?></th>
        <th><?=__('Nombre')?></th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($info['DistribucionAb'] as $distribucionAb):?>
    <tr>
        <td><?=$distribucionAb['DistribucionAb']['codigo']?></td>
        <td><?=$distribucionAb['DistribucionAb']['nombre']?></td>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>