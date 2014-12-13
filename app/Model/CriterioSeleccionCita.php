<?php
App::uses('AppModel', 'Model');
/**
 * CriteriosSeleccionCitum Model
 *
 */
class CriterioSeleccionCita extends AppModel {

    /**
     * Use database config
     *
     * @var string
     */
    public $useDbConfig = 'default';

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'criterio_seleccion_cita';

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'nombre';

}
