<table class="tabla-rarezas-locales table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th><?=__("Orden taxonómico");?></th>
        <th><?=__("Familia");?></th>
        <th><?=__("Nombre Común");?></th>
        <th><?=__("Género");?></th>
        <th><?=__("Especie");?></th>
        <th><?=__("Subespecie");?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($rarezasLocales as $rarezaLocal): ?>
        <tr>
            <td><i><?=$rarezaLocal['OrdenTaxonomico']['nombre']?></i></td>
            <td><i><?=$rarezaLocal['Familia']['nombre']?></i></td>
            <td><?=$rarezaLocal['Especie']['nombreComun']?></td>
            <td><i><?=$rarezaLocal['Especie']['genero']?></i></td>
            <td><i><?=$rarezaLocal['Especie']['especie']?></i></td>
            <td><i><?=$rarezaLocal['Especie']['subespecie']?></i></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>