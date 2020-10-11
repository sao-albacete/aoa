<?php
    if(! isset($cantidades)) {
        $cantidades = [
            '10' => 0,
            '11' => 0,
            '12' => 0,
            '20' => 0,
            '21' => 0,
            '22' => 0,
            '30' => 0,
            '31' => 0,
            '32' => 0,
            '50' => 0,
            '51' => 0,
            '52' => 0,
            '70' => 0,
            '71' => 0,
            '72' => 0,
            '80' => 0,
            '81' => 0,
            '82' => 0,
            '90' => 0,
            '91' => 0,
            '92' => 0
        ];
    }

/**
 * CSS
 */
$this->Html->css([
    'Elements/Cita/tablaNumeroAves'
], null, array('inline' => false));

/**
 * Javascript
 */
$this->Html->script(array(
    'Elements/Cita/tablaNumeroAves',
), array('inline' => false));
?>

<table class="tablaNumeroAves table table-striped table-bordered table-condensed">
    <thead>
    <tr>
        <td colspan="2" rowspan="2" class="caption"></td>
        <td colspan="100%" class="caption">Edad</td>
    </tr>
    <tr>
        <th class="info-clase-edad"
            title="<?=__('Ave que ha adquirido el plumaje definitivo tras diferentes plumajes de transición previos. ');?>">
            <a><?=__("Adulto"); ?></a>
        </th>
        <th class="info-clase-edad"
            title="<?=__('Ave de edad incierta que presenta alguno de los plumajes de transición que transcurren entre la primera muda tras abandonar el nido y la adquisición del plumaje final de adulto.');?>">
            <a><?=__("Inmaduro / Subadulto"); ?></a>
        </th>
        <th class="info-clase-edad"
            title="<?=__('Ave en su tercer año calendario de vida.');?>">
            <a><?=__("3º año"); ?></a>
        </th>
        <th class="info-clase-edad"
            title="<?=__('Ave en su segundo año calendario de vida.');?>">
            <a><?=__("2º año"); ?></a>
        </th>
        <th class="info-clase-edad"
            title="<?=__('Ave desde que abandona el nido hasta 31 de diciembre de ese año. A partir del 1 de enero del siguiente se trata de un ave de 2º año (segundo año calendario).');?>">
            <a><?=__("Joven"); ?></a>
        </th>
        <th class="info-clase-edad"
            title="<?=__('Ave que está creciendo en un nido (nidícola) o fuera de él (nidífugo) y que todavía es incapaz de volar o sólo realiza vuelos cortos.');?>">
            <a><?=__("Pollo"); ?></a>
        </th>
        <th class="info-clase-edad"
            title="<?=__('Ave de la que no se conoce con certeza su edad ni su sexo.');?>">
            <a><?=__("Indeter."); ?></a>
        </th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td rowspan="3" class="caption" style="vertical-align: middle; text-align: center;">Sexo</td>
        <th><?=__("Macho"); ?></th>
        <td><input name="data[claseEdadSexo][][20]" maxlength="5" class="input-mini numero_aves" type="text" data-id="20" value="<?=$cantidades['91'];?>"/></td>
        <td><input name="data[claseEdadSexo][][17]" maxlength="5" class="input-mini numero_aves" type="text" data-id="17" value="<?=$cantidades['81'];?>"/></td>
        <td><input name="data[claseEdadSexo][][14]" maxlength="5" class="input-mini numero_aves" type="text" data-id="14" value="<?=$cantidades['71'];?>"/></td>
        <td><input name="data[claseEdadSexo][][11]" maxlength="5" class="input-mini numero_aves" type="text" data-id="11" value="<?=$cantidades['51'];?>"/></td>
        <td><input name="data[claseEdadSexo][][8]" maxlength="5" class="input-mini numero_aves" type="text" data-id="8" value="<?=$cantidades['31'];?>"/></td>
        <td><input name="data[claseEdadSexo][][1]" maxlength="5" class="input-mini numero_aves" type="text" data-id="1" value="<?=$cantidades['11'];?>"/></td>
        <td><input name="data[claseEdadSexo][][5]" maxlength="5" class="input-mini numero_aves" type="text" data-id="5" value="<?=$cantidades['21'];?>"/></td>
    </tr>
    <tr>
        <th><?=__("Hembra"); ?></th>
        <td><input name="data[claseEdadSexo][][21]" maxlength="5" class="input-mini numero_aves" type="text" data-id="21" value="<?=$cantidades['92'];?>"/></td>
        <td><input name="data[claseEdadSexo][][18]" maxlength="5" class="input-mini numero_aves" type="text" data-id="18" value="<?=$cantidades['82'];?>"/></td>
        <td><input name="data[claseEdadSexo][][15]" maxlength="5" class="input-mini numero_aves" type="text" data-id="15" value="<?=$cantidades['72'];?>"/></td>
        <td><input name="data[claseEdadSexo][][12]" maxlength="5" class="input-mini numero_aves" type="text" data-id="12" value="<?=$cantidades['52'];?>"/></td>
        <td><input name="data[claseEdadSexo][][9]" maxlength="5" class="input-mini numero_aves" type="text" data-id="9" value="<?=$cantidades['32'];?>"/></td>
        <td><input name="data[claseEdadSexo][][2]" maxlength="5" class="input-mini numero_aves" type="text" data-id="2" value="<?=$cantidades['12'];?>"/></td>
        <td><input name="data[claseEdadSexo][][6]" maxlength="5" class="input-mini numero_aves" type="text" data-id="6" value="<?=$cantidades['22'];?>"/></td>
    </tr>
    <tr>
        <th title="<?=__("Indeterminado"); ?>"><?=__("Indeter."); ?></th>
        <td><input name="data[claseEdadSexo][][19]" maxlength="5" class="input-mini numero_aves" type="text" data-id="19" value="<?=$cantidades['90'];?>"/></td>
        <td><input name="data[claseEdadSexo][][16]" maxlength="5" class="input-mini numero_aves" type="text" data-id="16" value="<?=$cantidades['80'];?>"/></td>
        <td><input name="data[claseEdadSexo][][13]" maxlength="5" class="input-mini numero_aves" type="text" data-id="13" value="<?=$cantidades['70'];?>"/></td>
        <td><input name="data[claseEdadSexo][][10]" maxlength="5" class="input-mini numero_aves" type="text" data-id="10" value="<?=$cantidades['50'];?>"/></td>
        <td><input name="data[claseEdadSexo][][7]" maxlength="5" class="input-mini numero_aves" type="text" data-id="7" value="<?=$cantidades['30'];?>"/></td>
        <td><input name="data[claseEdadSexo][][3]" maxlength="5" class="input-mini numero_aves" type="text" data-id="3" value="<?=$cantidades['10'];?>"/></td>
        <td><input name="data[claseEdadSexo][][4]" maxlength="5" class="input-mini numero_aves" type="text" data-id="4" value="<?=$cantidades['20'];?>"/></td>
    </tr>
    </tbody>
</table>
