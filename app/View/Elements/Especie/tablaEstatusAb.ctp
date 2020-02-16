<table class='estatus-ab table table-striped table-bordered'>
    <thead>
    <tr>
        <th><?=__('Código')?></th>
        <th><?=__('Nombre')?></th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($info['EstatusCuantitativoAb'] as $estatusCuantitativoAb):?>
    <tr>
        <td style='text-align: center;'><?=$estatusCuantitativoAb['EstatusCuantitativoAb']['codigo']?></td>
        <td style='text-align: center;'><?=$estatusCuantitativoAb['EstatusCuantitativoAb']['nombre']?></td>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>