<?php

App::uses('AppModel', 'Model');

/**
 * Cita Model
 *
 * @property Lugar $Lugar
 * @property User $Usuario
 * @property ClaseReproduccion $ClaseReproduccion
 * @property Fuente $Fuente
 * @property Especie $Especie
 * @property CriterioSeleccionCita $CriterioSeleccionCita
 * @property CitaHistorico $CitaHistorico
 * @property Fichero $Fichero
 */
class Cita extends AppModel {

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
    public $useTable = 'cita';
    
    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = [
        'Lugar' => [
            'className' => 'Lugar',
            'foreignKey' => 'lugar_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'ObservadorPrincipal' => [
            'className' => 'ObservadorPrincipal',
            'foreignKey' => 'observador_principal_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'ClaseReproduccion' => [
            'className' => 'ClaseReproduccion',
            'foreignKey' => 'clase_reproduccion_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'Fuente' => [
            'className' => 'Fuente',
            'foreignKey' => 'fuente_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'Especie' => [
            'className' => 'Especie',
            'foreignKey' => 'especie_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'CriterioSeleccionCita' => [
            'className' => 'CriterioSeleccionCita',
            'foreignKey' => 'criterio_seleccion_cita_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'ImportanciaCita' => [
            'className' => 'ImportanciaCita',
            'foreignKey' => 'importancia_cita_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'Estudio' => [
            'className' => 'Estudio',
            'foreignKey' => 'estudio_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ]
    ];

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = [
//         'CitaHistorico' => array(
//             'className' => 'CitaHistorico',
//             'foreignKey' => 'cita_id',
//             'dependent' => false,
//             'conditions' => '',
//             'fields' => '',
//             'order' => '',
//             'limit' => '',
//             'offset' => '',
//             'exclusive' => '',
//             'finderQuery' => '',
//             'counterQuery' => ''
//         ),
        'Fichero' => [
            'className' => 'Fichero',
            'foreignKey' => 'cita_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ],
        'AsoCitaObservador' => [
            'className' => 'AsoCitaObservador',
            'foreignKey' => 'cita_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ],
        'AsoCitaClaseEdadSexo' => [
            'className' => 'AsoCitaClaseEdadSexo',
            'foreignKey' => 'cita_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ]
    ];
    
    /**
     * Validaciones
     */
    public $validate = [
        'fechaAlta' => [
            'required' => [
                'rule' => 'notEmpty',
                'required' => 'create',
                'message' => 'Debe seleccionar una fecha de alta.'
            ],
            'date' => [
                'rule' => ['date', 'ymd'],
                'required' => 'create',
                'message' => 'Debe introducir una fecha de alta con formato correcto (dd/mm/aaaa).'
            ],
            'dateAfterOrEqualToday' => [
                'rule' => 'dateBeforeOrEqualToday',
                'message' => 'Debe introducir una fecha de alta anterior o igual a la fecha de hoy.'
            ]
        ],
        'cantidad' => [
            'required' => [
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'El número de aves debe ser mayor que cero.'
            ],
            'moreThanZero' => [
                'rule' => ['comparison', '>', 0],
                'required' => true,
                'message' => 'El número de aves debe ser mayor que cero'
            ]
        ],
        'observaciones' => [
            'between' => [
                'rule' => ['between', 0, 1000],
                'required' => true,
                'message' => 'El texto de observaciones no puede ser mayor de 1000 caracteres.'
            ]
        ],
        'lugar_id' => [
            'required' => [
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'El lugar es obligatorio.'
            ],
            'numeric' => [
                'rule' => 'naturalNumber',
                'required' => true,
                'message' => 'El id del lugar debe ser un numero.'
            ]
        ],
        'observador_principal_id' => [
            'required' => [
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'El observador es obligatorio.'
            ],
            'numeric' => [
                'rule' => 'naturalNumber',
                'required' => true,
                'message' => 'El id del observador debe ser un numero.'
            ]
        ],
        'clase_reproduccion_id' => [
            'required' => [
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'La clase de reproducción es obligatoria.'
            ],
            'numeric' => [
                'rule' => 'naturalNumber',
                'required' => true,
                'message' => 'El id de la clase de reproducción debe ser un numero.'
            ]
        ],
        'especie_id' => [
            'required' => [
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'La especie es obligatoria.'
            ],
            'numeric' => [
                'rule' => 'naturalNumber',
                'required' => true,
                'message' => 'El id de la especie debe ser un numero.'
            ]
        ],
        'criterio_seleccion_cita_id' => [
            'required' => [
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'El criterio de selección es obligatorio.'
            ],
            'numeric' => [
                'rule' => 'naturalNumber',
                'required' => true,
                'message' => 'El id del criterio de selección debe ser un numero.'
            ]
        ],
         'indHabitatRaro' => [
                'rule' => ['boolean'],
                'required' => false,
                'message' => 'El valor del indicador de hábitat raro debe ser un booleano.'
         ],
        'indCriaHabitatRaro' => [
            'rule' => ['boolean'],
            'required' => false,
            'message' => 'El valor del indicador de cría en hábitat raro debe ser un booleano.'
        ],
        'indHerido' => [
            'rule' => ['boolean'],
            'required' => false,
            'message' => 'El valor del indicador de herido debe ser un booleano.'
        ],
        'indComportamiento' => [
            'rule' => ['boolean'],
            'required' => false,
            'message' => 'El valor del indicador de comportamiento debe ser un booleano.'
        ],
        'fuente_id' => [
            'numeric' => [
                'rule' => 'naturalNumber',
                'required' => true,
                'message' => 'La fuente es obligatoria.'
            ]
        ],
        'estudio_id' => [
            'numeric' => [
                'rule' => 'naturalNumber',
                'required' => true,
                'allowEmpty' => false,
                'message' => 'El estudio es obligatorio.'
            ]
        ],
        'indFoto' => [
            'rule' => ['boolean'],
            'required' => false,
            'message' => 'El valor del indicador de fotos debe ser un booleano.'
        ],
    ];

    /**
     * Valida si la fecha de alta de la cita es anterior o igual a la fecha de hoy
     *
     * @return bool
     */
    public function dateBeforeOrEqualToday() {
        
        $dtFechaAlta = new DateTime($this->data['Cita']['fechaAlta']);
        $dtNow = new DateTime('now');
        
        if($dtFechaAlta < $dtNow || $dtFechaAlta == $dtNow) {
            return true;
        }
        return false;
    }
    
    /*
     * Funciones
     */

    /**
     * Obtiene toda la información de la cita por id
     *
     * @param $conditions
     * @param null $fields
     * @param null $order
     * @param int $limit
     * @param null $joins
     * @return array
     */
    public function obtenerCitas($conditions, $fields=null, $order=null, $limit = 0, $joins=null) {
        
        $params = [];

        if (! empty($conditions)) {
            $params['conditions'] = $conditions;
            if(! array_key_exists('Cita.indActivo', $params['conditions'])) {
                $params['conditions']['Cita.indActivo'] = 1;
            }
        }
        if (! empty($fields)) {
            $params['fields'] = $fields;
        }
        if (! empty($order)) {
            $params['order'] = $order;
        }
        if (! empty($limit)) {
            $params['limit'] = $limit;
        }
        if (! empty($joins)) {
            $params['joins'] = $joins;
        }
        
        $citas = $this -> find(
            'all',
            $params
        );
    
        return $citas;
    }

    /**
     * Obtiene toda la información de la cita por id
     *
     * @param null $conditions
     * @param null $joins
     * @return array
     */
    public function obtenerNumeroCitas($conditions = null, $joins = null) {

        $params = [];

        if (! empty($conditions)) {
            $params['conditions'] = $conditions;
            if(! array_key_exists('Cita.indActivo', $params['conditions'])) {
                $params['conditions']['Cita.indActivo'] = 1;
            }
        }
        if (! empty($joins)) {
            $params['joins'] = $joins;
        }
        
        $numCitas = $this->find('count', $params);
        
        return $numCitas;
    }

    /**
     * Obtiene toda la información de la cita por id
     * @param $id_cita
     * @return array
     */
    public function obtenerTodoPorId($id_cita) {
        
        $cita = $this -> find(
            'first', 
            [
                'conditions' => ['Cita.id' => $id_cita, 'Cita.indActivo' => 1]
            ]
        );
        
        return $cita;
    }

    /**
     * Obtiene la información básica de la cita por id
     *
     * @param $id_cita
     * @return array
     */
    public function obtenerDatosBasicosPorId($id_cita) {
        
        $cita = $this -> find(
            'first', 
            [
                'conditions'=> ['Cita.id' => $id_cita, 'Cita.indActivo' => 1],
                'recursive'=>-1
            ]
        );
        
        return $cita;
    }
    
    /**
     * Obtiene los distintos años en los que se han dado citas ordenados descendentemente
     */
    public function obtenerAniosCitas() {
        
        $anios = $this -> find(
            'all', 
            [
                'fields'=> ['DISTINCT(YEAR(Cita.fechaAlta)) AS anio'],
                'conditions'=> ['Cita.indActivo' => 1],
                'order'=> ['anio DESC'],
                'recursive' => -1
            ]
        );
        
        return $anios;
    }

    /**
     * Obtiene las citas provinciales por mes
     *
     * @param number $especie_id
     * @param $anio_desde
     * @param $anio_hasta
     * @param $selectField
     * @return array
     */
    public function obtenerCitasProvincialesPorIntervaloAnios($especie_id, $anio_desde, $anio_hasta, $selectField) {
        
        $citas = $this -> find(
            'all', 
            [
                'conditions'=> [
                    'Cita.especie_id'=>$especie_id,
                    'YEAR(Cita.fechaAlta) >='=>$anio_desde,
                    'YEAR(Cita.fechaAlta) <='=>$anio_hasta,
                    'Cita.indActivo' => 1,
                ],
                'fields'=> ["$selectField AS cantidad", "MONTH(Cita.fechaAlta) AS mes"],
                'order'=> ['mes ASC'],
                'group'=> ['mes'],
                'recursive'=>-1
            ]
        );
        
        // Rellenamos un array con los valores para los 12 meses
        $out = [0,0,0,0,0,0,0,0,0,0,0,0];
        foreach ($citas as $cita) {
            $out[$cita[0]['mes'] - 1] = $cita[0]['cantidad'];
        }
        
        return $out;
    }

    /**
     * Obtener citas por provincia y año
     *
     * @param $especie_id
     * @param $anio
     * @param $selectField
     * @return array
     */
    public function obtenerCitasProvincialesPorAnio($especie_id, $anio, $selectField) {
        
        $citas = $this -> find(
            'all', 
            [
                'conditions'=> [
                    'Cita.especie_id'=>$especie_id,
                    'YEAR(Cita.fechaAlta)'=>$anio,
                    'Cita.indActivo' => 1,
                ],
                'fields'=> ["$selectField AS cantidad", "MONTH(Cita.fechaAlta) AS mes"],
                'order'=> ['mes ASC'],
                'group'=> ['mes'],
                'recursive'=>-1
            ]
        );
        
        // Rellenamos un array con los valores para los 12 meses
        $out = [0,0,0,0,0,0,0,0,0,0,0,0];
        foreach ($citas as $cita) {
            $out[$cita[0]['mes'] - 1] = $cita[0]['cantidad'];
        }
        
        return $out;
    }

    /**
     * Obtener citas por provincia y fechas
     *
     * @param $especie_id
     * @param $fecha_desde
     * @param $fecha_hasta
     * @param $selectField
     * @return array
     */
    public function obtenerCitasProvincialesPorIntervaloFechas($especie_id, $fecha_desde, $fecha_hasta, $selectField) {
        
        $citas = $this -> find(
            'all', 
            [
                'conditions'=> [
                    'Cita.especie_id'=>$especie_id,
                    "Cita.fechaAlta >= STR_TO_DATE('$fecha_desde','%d/%m/%Y')",
                    "Cita.fechaAlta <= STR_TO_DATE('$fecha_hasta','%d/%m/%Y')",
                    'Cita.indActivo' => 1,
                ],
                'fields'=> ["$selectField AS cantidad", "MONTH(Cita.fechaAlta) AS mes"],
                'order'=> ['mes ASC'],
                'group'=> ['mes'],
                'recursive'=>-1
            ]
        );
        
        // Rellenamos un array con los valores para los 12 meses
        $out = [0,0,0,0,0,0,0,0,0,0,0,0];
        foreach ($citas as $cita) {
            $out[$cita[0]['mes'] - 1] = $cita[0]['cantidad'];
        }
        
        return $out;
    }

    /**
     * Obtener citas por municipio y años
     *
     * @param $especie_id
     * @param $municipio
     * @param $anio_desde
     * @param $anio_hasta
     * @param $selectField
     * @return array
     */
    public function obtenerCitasPorMunicipioIntervaloAnios($especie_id, $municipio, $anio_desde, $anio_hasta, $selectField) {
        
        $citas = $this -> find(
            'all', 
            [
                'conditions'=> [
                    'Cita.especie_id'=>$especie_id,
                    'Lugar.municipio_id'=>$municipio,
                    'YEAR(Cita.fechaAlta) >='=>$anio_desde,
                    'YEAR(Cita.fechaAlta) <='=>$anio_hasta,
                    'Cita.indActivo' => 1,
                ],
                'fields'=> ["$selectField AS cantidad", "MONTH(Cita.fechaAlta) AS mes"],
                'order'=> ['mes ASC'],
                'group'=> ['mes']
            ]
        );
        
        // Rellenamos un array con los valores para los 12 meses
        $out = [0,0,0,0,0,0,0,0,0,0,0,0];
        foreach ($citas as $cita) {
            $out[$cita[0]['mes'] - 1] = $cita[0]['cantidad'];
        }
        
        return $out;
    }

    /**
     * Obtiene citas por municipio y año
     *
     * @param $especie_id
     * @param $municipio
     * @param $anio
     * @param $selectField
     * @return array
     */
    public function obtenerCitasPorMunicipioYAnio($especie_id, $municipio, $anio, $selectField) {
        
        $citas = $this -> find(
            'all', 
            [
                'conditions'=> [
                    'Cita.especie_id'=>$especie_id,
                    'Lugar.municipio_id'=>$municipio,
                    'YEAR(Cita.fechaAlta)'=>$anio,
                    'Cita.indActivo' => 1,
                ],
                'fields'=> ["$selectField AS cantidad", "MONTH(Cita.fechaAlta) AS mes"],
                'order'=> ['mes ASC'],
                'group'=> ['mes']
            ]
        );
        
        // Rellenamos un array con los valores para los 12 meses
        $out = [0,0,0,0,0,0,0,0,0,0,0,0];
        foreach ($citas as $cita) {
            $out[$cita[0]['mes'] - 1] = $cita[0]['cantidad'];
        }
        
        return $out;
    }

    /**
     * Obtiene citas por municipio y fechas
     *
     * @param $especie_id
     * @param $municipio
     * @param $fecha_desde
     * @param $fecha_hasta
     * @param $selectField
     * @return array
     */
    public function obtenerCitasPorMunicipioIntervaloFechas($especie_id, $municipio, $fecha_desde, $fecha_hasta, $selectField) {

        $citas = $this -> find(
            'all',
            [
                'conditions'=> [
                    'Cita.especie_id'=>$especie_id,
                    'Lugar.municipio_id'=>$municipio,
                    "Cita.fechaAlta >= STR_TO_DATE('$fecha_desde','%d/%m/%Y')",
                    "Cita.fechaAlta <= STR_TO_DATE('$fecha_hasta','%d/%m/%Y')",
                    'Cita.indActivo' => 1,
                ],
                'fields'=> ["$selectField AS cantidad", "MONTH(Cita.fechaAlta) AS mes"],
                'order'=> ['mes ASC'],
                'group'=> ['mes']
            ]
        );

        // Rellenamos un array con los valores para los 12 meses
        $out = [0,0,0,0,0,0,0,0,0,0,0,0];
        foreach ($citas as $cita) {
            $out[$cita[0]['mes'] - 1] = $cita[0]['cantidad'];
        }

        return $out;
    }

    /**
     * Obtiene citas por lugar y años
     *
     * @param $especie_id
     * @param $lugar
     * @param $anio_desde
     * @param $anio_hasta
     * @param $selectField
     * @return array
     */
    public function obtenerCitasPorLugarIntervaloAnios($especie_id, $lugar, $anio_desde, $anio_hasta, $selectField) {
        
        $citas = $this -> find(
            'all', 
            [
                'conditions'=> [
                    'Cita.especie_id'=>$especie_id,
                    'Cita.lugar_id'=>$lugar,
                    'YEAR(Cita.fechaAlta) >='=>$anio_desde,
                    'YEAR(Cita.fechaAlta) <='=>$anio_hasta,
                    'Cita.indActivo' => 1
                ],
                'fields'=> ["$selectField AS cantidad", "MONTH(Cita.fechaAlta) AS mes"],
                'order'=> ['mes ASC'],
                'group'=> ['mes'],
                'recursive'=>-1
            ]
        );
        
        // Rellenamos un array con los valores para los 12 meses
        $out = [0,0,0,0,0,0,0,0,0,0,0,0];
        foreach ($citas as $cita) {
            $out[$cita[0]['mes'] - 1] = $cita[0]['cantidad'];
        }
        
        return $out;
    }

    /**
     * Obtiene citas por lugar y año
     *
     * @param $especie_id
     * @param $lugar
     * @param $anio
     * @param $selectField
     * @return array
     */
    public function obtenerCitasPorLugarYAnio($especie_id, $lugar, $anio, $selectField) {
        
        $citas = $this -> find(
            'all', 
            [
                'conditions'=> [
                    'Cita.especie_id'=>$especie_id,
                    'Cita.lugar_id'=>$lugar,
                    'YEAR(Cita.fechaAlta)'=>$anio,
                    'Cita.indActivo' => 1,
                ],
                'fields'=> ["$selectField AS cantidad", "MONTH(Cita.fechaAlta) AS mes"],
                'order'=> ['mes ASC'],
                'group'=> ['mes'],
                'recursive'=>-1
            ]
        );
        
        // Rellenamos un array con los valores para los 12 meses
        $out = [0,0,0,0,0,0,0,0,0,0,0,0];
        foreach ($citas as $cita) {
            $out[$cita[0]['mes'] - 1] = $cita[0]['cantidad'];
        }
        
        return $out;
    }

    /**
     * Obtiene citas por lugar y fechas
     *
     * @param $especie_id
     * @param $lugar
     * @param $fecha_desde
     * @param $fecha_hasta
     * @param $selectField
     * @return array
     */
    public function obtenerCitasPorLugarIntervaloFechas($especie_id, $lugar, $fecha_desde, $fecha_hasta, $selectField) {
        
        $citas = $this -> find(
            'all', 
            [
                'conditions'=> [
                    'Cita.especie_id'=>$especie_id,
                    'Cita.lugar_id'=>$lugar,
                    "Cita.fechaAlta >= STR_TO_DATE('$fecha_desde','%d/%m/%Y')",
                    "Cita.fechaAlta <= STR_TO_DATE('$fecha_hasta','%d/%m/%Y')",
                    'Cita.indActivo' => 1,
                ],
                'fields'=> ["$selectField AS cantidad", "MONTH(Cita.fechaAlta) AS mes"],
                'order'=> ['mes ASC'],
                'group'=> ['mes'],
                'recursive'=>-1
            ]
        );
        
        // Rellenamos un array con los valores para los 12 meses
        $out = [0,0,0,0,0,0,0,0,0,0,0,0];
        foreach ($citas as $cita) {
            $out[$cita[0]['mes'] - 1] = $cita[0]['cantidad'];
        }
        
        return $out;
    }

    /**
     * Obtiene citas por cuadricula UTM y años
     *
     * @param $especie_id
     * @param $cuadricula_utm
     * @param $anio_desde
     * @param $anio_hasta
     * @param $selectField
     * @return array
     */
    public function obtenerCitasPorCuadriculaUtmIntervaloAnios($especie_id, $cuadricula_utm, $anio_desde, $anio_hasta, $selectField) {
        
        $citas = $this -> find(
            'all', 
            [
                'conditions'=> [
                    'Cita.especie_id'=>$especie_id,
                    'Lugar.cuadricula_utm_id'=>$cuadricula_utm,
                    'YEAR(Cita.fechaAlta) >='=>$anio_desde,
                    'YEAR(Cita.fechaAlta) <='=>$anio_hasta,
                    'Cita.indActivo' => 1,
                ],
                'fields'=> ["$selectField AS cantidad", "MONTH(Cita.fechaAlta) AS mes"],
                'order'=> ['mes ASC'],
                'group'=> ['mes']
            ]
        );
        
        // Rellenamos un array con los valores para los 12 meses
        $out = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach ($citas as $cita) {
            $out[$cita[0]['mes'] - 1] = $cita[0]['cantidad'];
        }
        
        return $out;
    }

    /**
     * Obtener citas por cuadricula UTM y año
     *
     * @param $especie_id
     * @param $cuadricula_utm
     * @param $anio
     * @param $selectField
     * @return array
     */
    public function obtenerCitasPorCuadriculaUtmYAnio($especie_id, $cuadricula_utm, $anio, $selectField) {
        
        $citas = $this -> find(
            'all', 
            [
                'conditions'=> [
                    'Cita.especie_id' => $especie_id,
                    'Lugar.cuadricula_utm_id' => $cuadricula_utm,
                    'YEAR(Cita.fechaAlta)' => $anio,
                    'Cita.indActivo' => 1
                ],
                'fields'=> ["$selectField AS cantidad", "MONTH(Cita.fechaAlta) AS mes"],
                'order'=> ['mes ASC'],
                'group'=> ['mes']
            ]
        );
        
        // Rellenamos un array con los valores para los 12 meses
        $out = [0,0,0,0,0,0,0,0,0,0,0,0];
        foreach ($citas as $cita) {
            $out[$cita[0]['mes'] - 1] = $cita[0]['cantidad'];
        }
        
        return $out;
    }

    /**
     * Obtiene las citas por cuadricula UTM y filtradas por fechas
     *
     * @param $especie_id
     * @param $cuadricula_utm
     * @param $fecha_desde
     * @param $fecha_hasta
     * @param $selectField
     * @return array
     */
    public function obtenerCitasPorCuadriculaUtmIntervaloFechas($especie_id, $cuadricula_utm, $fecha_desde, $fecha_hasta, $selectField) {
        
        $citas = $this -> find(
            'all', 
            [
                'conditions'=> [
                    'Cita.especie_id'=>$especie_id,
                    'Lugar.cuadricula_utm_id'=>$cuadricula_utm,
                    "Cita.fechaAlta >= STR_TO_DATE('$fecha_desde','%d/%m/%Y')",
                    "Cita.fechaAlta <= STR_TO_DATE('$fecha_hasta','%d/%m/%Y')",
                    'Cita.indActivo' => 1
                ],
                'fields'=> ["$selectField AS cantidad", "MONTH(Cita.fechaAlta) AS mes"],
                'order'=> ['mes ASC'],
                'group'=> ['mes']
            ]
        );
        
        // Rellenamos un array con los valores para los 12 meses
        $out = [0,0,0,0,0,0,0,0,0,0,0,0];
        foreach ($citas as $cita) {
            $out[$cita[0]['mes'] - 1] = $cita[0]['cantidad'];
        }
        
        return $out;
    }

    /**
     * Obtiene todas las citas por municipio
     *
     * @param $especie_id
     * @return array
     */
    public function obtenerTotalCitasPorMunicipio($especie_id) {
        
        $citas = $this -> find(
            'all', 
            [
                'conditions'=> ['Cita.especie_id' => $especie_id, 'Cita.indActivo' => 1],
                'fields'=> ['COUNT(Cita.id) as total', 'Lugar.municipio_id as municipio'],
                'group'=> ['municipio']
            ]
        );
        
        return $citas;
    }

    /**
     * Obtiene el total de citas por cuadricula UTM
     *
     * @param $especie_id
     * @return array
     */
    public function obtenerTotalCitasPorCuadriculaUtm($especie_id) {
        
        $citas = $this -> find(
            'all', 
            [
                'conditions'=> ['Cita.especie_id' => $especie_id, 'Cita.indActivo' => 1],
                'fields'=> ['COUNT(Cita.id) as total', 'Lugar.cuadricula_utm_id as cuadriculaUtm'],
                'group'=> ['cuadriculaUtm']
            ]
        );
        
        return $citas;
    }

    /**
     * Obtiene todas las citas por lugar
     *
     * @param $lugar_id
     * @return array
     */
    public function obtenerTotalCitasPorLugar($lugar_id) {
        
        $totalCitas = $this -> find(
            'count', 
            [
                'conditions'=> ['Cita.lugar_id' => $lugar_id, 'Cita.indActivo' => 1]
            ]
        );
        
        return $totalCitas;
    }

    /**
     * Obtiene el tipo de cria por municipio
     *
     * @param $especie_id
     * @return array
     */
    public function obtenerTipoCriaPorMunicipio($especie_id) {
        
        $citas = $this -> find(
            'all', 
            [
                'conditions'=> ['Cita.especie_id' => $especie_id, 'Cita.indActivo' => 1],
                'fields'=> ['Lugar.municipio_id as municipio', 'MAX(ClaseReproduccion.idTipoCria) as tipoCria'],
                'group'=> ['municipio']
            ]
        );
        
        return $citas;
    }

    /**
     * Obtiene el tipo de cría por cuadrícula UTM
     *
     * @param $especie_id
     * @return array
     */
    public function obtenerTipoCriaPorCuadriculaUtm($especie_id) {
        
        $citas = $this -> find(
            'all', 
            [
                'conditions'=> ['Cita.especie_id' => $especie_id, 'Cita.indActivo' => 1],
                'fields'=> ['Lugar.cuadricula_utm_id as cuadriculaUtm', 'MAX(ClaseReproduccion.idTipoCria) as tipoCria'],
                'group'=> ['cuadriculaUtm']
            ]
        );
        
        return $citas;
    }

    /**
     * Comprueba si existe una cita por especie, lugar, observador y fecha de alta
     *
     * @param $especieId
     * @param $lugarId
     * @param $fechaAlta
     * @param $observadorId
     * @return array []
     */
    public function existeCita($especieId, $lugarId, $fechaAlta, $observadorId = null) {

        $conditions = [
            'Cita.especie_id' => $especieId,
            'Cita.lugar_id' => $lugarId,
            "Cita.fechaAlta = STR_TO_DATE('$fechaAlta','%d/%m/%Y')",
            'Cita.indActivo' => 1
        ];

        if (isset($observadorId)) {
            $conditions['Cita.observador_principal_id'] = $observadorId;
        }

        $citas = $this -> find(
            'all',
            [
                'conditions' => $conditions,
            ]
        );

        return $citas;
    }
}
