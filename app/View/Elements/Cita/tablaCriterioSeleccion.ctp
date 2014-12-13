<table class='criterio-seleccion table table-striped table-bordered'>
    <thead>
    <tr>
        <th><?=__('Código')?></th>
        <th><?=__('Tipo de cita')?></th>
        <th><?=__('Descripción')?></th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($criteriosSeleccion as $criterioSeleccion):?>
        <tr>
            <td><?=$criterioSeleccion['CriterioSeleccionCita']['codigo']?></td>
            <td><?=$criterioSeleccion['CriterioSeleccionCita']['tipoCita']?></td>
            <td><?=$criterioSeleccion['CriterioSeleccionCita']['nombre']?></td>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>
