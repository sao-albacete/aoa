<?php
App::uses('Component', 'Controller');

/**
 * Component for working with PHPExcel class.
 *
 * @package PhpExcel
 * @author segy
 */
class ObservadorSecundarioComponent extends Component {

    public function mostrarCodigosObservadores($observadores) {
        return empty($observadores) ?
            "" :
            join(array_column(array_column($observadores, 'ObservadorSecundario'), 'codigo'), ' | ');
    }

    public function mostrarNombresObservadores($observadores) {

        return empty($observadores) ?
            "" :
            join(array_column(array_column($observadores, 'ObservadorSecundario'), 'nombre'), ' | ');
    }
}