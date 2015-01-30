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
    public $belongsTo = array(
        'Lugar' => array(
            'className' => 'Lugar',
            'foreignKey' => 'lugar_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'ObservadorPrincipal' => array(
            'className' => 'ObservadorPrincipal',
            'foreignKey' => 'observador_principal_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'ClaseReproduccion' => array(
            'className' => 'ClaseReproduccion',
            'foreignKey' => 'clase_reproduccion_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Fuente' => array(
            'className' => 'Fuente',
            'foreignKey' => 'fuente_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Especie' => array(
            'className' => 'Especie',
            'foreignKey' => 'especie_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'CriterioSeleccionCita' => array(
            'className' => 'CriterioSeleccionCita',
            'foreignKey' => 'criterio_seleccion_cita_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'ImportanciaCita' => array(
            'className' => 'ImportanciaCita',
            'foreignKey' => 'importancia_cita_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Estudio' => array(
            'className' => 'Estudio',
            'foreignKey' => 'estudio_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
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
        'Fichero' => array(
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
        ),
        'AsoCitaObservador' => array(
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
        ),
        'AsoCitaClaseEdadSexo' => array(
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
        )
    );
    
    /**
     * Validaciones
     */
    public $validate = array(
        'fechaAlta' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => 'create',
                'message' => 'Debe seleccionar una fecha de alta.'
            ),
            'date' => array(
                'rule' => array('date', 'ymd'),
                'required' => 'create',
                'message' => 'Debe introducir una fecha de alta con formato correcto (dd/mm/aaaa).'
            ),
            'dateAfterOrEqualToday' => array(
                'rule' => 'dateBeforeOrEqualToday',
                'message' => 'Debe introducir una fecha de alta anterior o igual a la fecha de hoy.'
            )
        ),
        'cantidad' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'El número de aves debe ser mayor que cero.'
            ),
            'moreThanZero' => array(
                'rule' => array('comparison', '>', 0),
                'required' => true,
                'message' => 'El número de aves debe ser mayor que cero'
            )
        ),
        'observaciones' => array(
            'between' => array(
                'rule' => array('between', 0, 1000),
                'required' => true,
                'message' => 'El texto de observaciones no puede ser mayor de 1000 caracteres.'
            )
        ),
        'lugar_id' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'El lugar es obligatorio.'
            ),
            'numeric' => array(
                'rule' => 'naturalNumber',
                'required' => true,
                'message' => 'El id del lugar debe ser un numero.'
            )
        ),
        'observador_principal_id' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'El observador es obligatorio.'
            ),
            'numeric' => array(
                'rule' => 'naturalNumber',
                'required' => true,
                'message' => 'El id del observador debe ser un numero.'
            )
        ),
        'clase_reproduccion_id' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'La clase de reproducción es obligatoria.'
            ),
            'numeric' => array(
                'rule' => 'naturalNumber',
                'required' => true,
                'message' => 'El id de la clase de reproducción debe ser un numero.'
            )
        ),
        'especie_id' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'La especie es obligatoria.'
            ),
            'numeric' => array(
                'rule' => 'naturalNumber',
                'required' => true,
                'message' => 'El id de la especie debe ser un numero.'
            )
        ),
        'criterio_seleccion_cita_id' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'El criterio de selección es obligatorio.'
            ),
            'numeric' => array(
                'rule' => 'naturalNumber',
                'required' => true,
                'message' => 'El id del criterio de selección debe ser un numero.'
            )
        ),
         'indHabitatRaro' => array(
                'rule' => array('boolean'),
                'required' => false,
                'message' => 'El valor del indicador de hábitat raro debe ser un booleano.'
        ),
        'indCriaHabitatRaro' => array(
            'rule' => array('boolean'),
            'required' => false,
            'message' => 'El valor del indicador de cría en hábitat raro debe ser un booleano.'
        ),
        'indHerido' => array(
            'rule' => array('boolean'),
            'required' => false,
            'message' => 'El valor del indicador de herido debe ser un booleano.'
        ),
        'indComportamiento' => array(
            'rule' => array('boolean'),
            'required' => false,
            'message' => 'El valor del indicador de comportamiento debe ser un booleano.'
<<<<<<< Updated upstream
        )
=======
        ),
        'fuente_id' => array(
            'numeric' => array(
                'rule' => 'naturalNumber',
                'required' => true,
                'message' => 'La fuente es obligatoria.'
            )
        ),
        'estudio_id' => array(
            'numeric' => array(
                'rule' => 'naturalNumber',
                'required' => true,
                'allowEmpty' => false,
                'message' => 'El estudio es obligatorio.'
            )
        ),
>>>>>>> Stashed changes
    );
    
    public function dateBeforeOrEqualToday($data) {
        
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
        
        $params = array();
        
        if (! empty($conditions)) {
            $params['conditions'] = $conditions;
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
    public function obtenerNumeroCitas($conditions=null, $joins=null) {

        $params = array();

        if (! empty($conditions)) {
            $params['conditions'] = $conditions;
        }

        if (! empty($joins)) {
            $params['joins'] = $joins;
        }
        
        $numCitas = $this->find('count', $params);
        
        return $numCitas;
    }
    
    /**
     * Obtiene toda la información de la cita por id
     */
    public function obtenerTodoPorId($id_cita) {
        
        $cita = $this -> find(
            'first', 
            array(
                'conditions'=>array('Cita.id'=>$id_cita)
            )
        );
        
        return $cita;
    }
    
    /**
     * Obtiene la información básica de la cita por id
     */
    public function obtenerDatosBasicosPorId($id_cita) {
        
        $cita = $this -> find(
            'first', 
            array(
                'conditions'=>array('Cita.id'=>$id_cita),
                'recursive'=>-1
            )
        );
        
        return $cita;
    }
    
    /**
     * Obtiene los distintos años en los que se han dado citas ordenados descendentemente
     */
    public function obtenerAniosCitas() {
        
        $anios = $this -> find(
            'all', 
            array(
                'fields'=>array('DISTINCT(YEAR(Cita.fechaAlta)) AS anio'),
                'order'=>array('anio DESC'),
                'recursive' => -1
            )
        );
        
        return $anios;
    }
    
    /**
     * Obtiene las citas provinciales por mes
     * 
     * @param number $especie_id
     */
    public function obtenerCitasProvincialesPorIntervaloAnios($especie_id, $anio_desde, $anio_hasta, $selectField) {
        
        $citas = $this -> find(
            'all', 
            array(
                'conditions'=>array('Cita.especie_id'=>$especie_id, 'YEAR(Cita.fechaAlta) >='=>$anio_desde, 'YEAR(Cita.fechaAlta) <='=>$anio_hasta),
                'fields'=>array("$selectField AS cantidad", "MONTH(Cita.fechaAlta) AS mes"),
                'order'=>array('mes ASC'),
                'group'=>array('mes'),
                'recursive'=>-1
            )
        );
        
        // Rellenamos un array con los valores para los 12 meses
        $out = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach ($citas as $cita) {
            $out[$cita[0]['mes'] - 1] = $cita[0]['cantidad'];
        }
        
        return $out;
    }
    
    public function obtenerCitasProvincialesPorAnio($especie_id, $anio, $selectField) {
        
        $citas = $this -> find(
            'all', 
            array(
                'conditions'=>array('Cita.especie_id'=>$especie_id, 'YEAR(Cita.fechaAlta)'=>$anio),
                'fields'=>array("$selectField AS cantidad", "MONTH(Cita.fechaAlta) AS mes"),
                'order'=>array('mes ASC'),
                'group'=>array('mes'),
                'recursive'=>-1
            )
        );
        
        // Rellenamos un array con los valores para los 12 meses
        $out = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach ($citas as $cita) {
            $out[$cita[0]['mes'] - 1] = $cita[0]['cantidad'];
        }
        
        return $out;
    }
    
    public function obtenerCitasProvincialesPorIntervaloFechas($especie_id, $fecha_desde, $fecha_hasta, $selectField) {
        
        $citas = $this -> find(
            'all', 
            array(
                'conditions'=>array('Cita.especie_id'=>$especie_id, "Cita.fechaAlta >= STR_TO_DATE('$fecha_desde','%d/%m/%Y')", "Cita.fechaAlta <= STR_TO_DATE('$fecha_hasta','%d/%m/%Y')"),
                'fields'=>array("$selectField AS cantidad", "MONTH(Cita.fechaAlta) AS mes"),
                'order'=>array('mes ASC'),
                'group'=>array('mes'),
                'recursive'=>-1
            )
        );
        
        // Rellenamos un array con los valores para los 12 meses
        $out = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach ($citas as $cita) {
            $out[$cita[0]['mes'] - 1] = $cita[0]['cantidad'];
        }
        
        return $out;
    }
    
    public function obtenerCitasPorMunicipioIntervaloAnios($especie_id, $municipio, $anio_desde, $anio_hasta, $selectField) {
        
        $citas = $this -> find(
            'all', 
            array(
                'conditions'=>array('Cita.especie_id'=>$especie_id, 'Lugar.municipio_id'=>$municipio, 'YEAR(Cita.fechaAlta) >='=>$anio_desde, 'YEAR(Cita.fechaAlta) <='=>$anio_hasta),
                'fields'=>array("$selectField AS cantidad", "MONTH(Cita.fechaAlta) AS mes"),
                'order'=>array('mes ASC'),
                'group'=>array('mes')
            )
        );
        
        // Rellenamos un array con los valores para los 12 meses
        $out = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach ($citas as $cita) {
            $out[$cita[0]['mes'] - 1] = $cita[0]['cantidad'];
        }
        
        return $out;
    }
    
    public function obtenerCitasPorMunicipioYAnio($especie_id, $municipio, $anio, $selectField) {
        
        $citas = $this -> find(
            'all', 
            array(
                'conditions'=>array('Cita.especie_id'=>$especie_id, 'Lugar.municipio_id'=>$municipio, 'YEAR(Cita.fechaAlta)'=>$anio),
                'fields'=>array("$selectField AS cantidad", "MONTH(Cita.fechaAlta) AS mes"),
                'order'=>array('mes ASC'),
                'group'=>array('mes')
            )
        );
        
        // Rellenamos un array con los valores para los 12 meses
        $out = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach ($citas as $cita) {
            $out[$cita[0]['mes'] - 1] = $cita[0]['cantidad'];
        }
        
        return $out;
    }
    
    public function obtenerCitasPorMunicipioIntervaloFechas($especie_id, $municipio, $fecha_desde, $fecha_hasta, $selectField) {

        $citas = $this -> find(
            'all',
            array(
                'conditions'=>array('Cita.especie_id'=>$especie_id, 'Lugar.municipio_id'=>$municipio, "Cita.fechaAlta >= STR_TO_DATE('$fecha_desde','%d/%m/%Y')", "Cita.fechaAlta <= STR_TO_DATE('$fecha_hasta','%d/%m/%Y')"),
                'fields'=>array("$selectField AS cantidad", "MONTH(Cita.fechaAlta) AS mes"),
                'order'=>array('mes ASC'),
                'group'=>array('mes')
            )
        );

        // Rellenamos un array con los valores para los 12 meses
        $out = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach ($citas as $cita) {
            $out[$cita[0]['mes'] - 1] = $cita[0]['cantidad'];
        }

        return $out;
    }
    
    public function obtenerCitasPorLugarIntervaloAnios($especie_id, $lugar, $anio_desde, $anio_hasta, $selectField) {
        
        $citas = $this -> find(
            'all', 
            array(
                'conditions'=>array('Cita.especie_id'=>$especie_id, 'Cita.lugar_id'=>$lugar, 'YEAR(Cita.fechaAlta) >='=>$anio_desde, 'YEAR(Cita.fechaAlta) <='=>$anio_hasta),
                'fields'=>array("$selectField AS cantidad", "MONTH(Cita.fechaAlta) AS mes"),
                'order'=>array('mes ASC'),
                'group'=>array('mes'),
                'recursive'=>-1
            )
        );
        
        // Rellenamos un array con los valores para los 12 meses
        $out = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach ($citas as $cita) {
            $out[$cita[0]['mes'] - 1] = $cita[0]['cantidad'];
        }
        
        return $out;
    }
    
    public function obtenerCitasPorLugarYAnio($especie_id, $lugar, $anio, $selectField) {
        
        $citas = $this -> find(
            'all', 
            array(
                'conditions'=>array('Cita.especie_id'=>$especie_id, 'Cita.lugar_id'=>$lugar, 'YEAR(Cita.fechaAlta)'=>$anio),
                'fields'=>array("$selectField AS cantidad", "MONTH(Cita.fechaAlta) AS mes"),
                'order'=>array('mes ASC'),
                'group'=>array('mes'),
                'recursive'=>-1
            )
        );
        
        // Rellenamos un array con los valores para los 12 meses
        $out = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach ($citas as $cita) {
            $out[$cita[0]['mes'] - 1] = $cita[0]['cantidad'];
        }
        
        return $out;
    }
    
    public function obtenerCitasPorLugarIntervaloFechas($especie_id, $lugar, $fecha_desde, $fecha_hasta, $selectField) {
        
        $citas = $this -> find(
            'all', 
            array(
                'conditions'=>array('Cita.especie_id'=>$especie_id, 'Cita.lugar_id'=>$lugar, "Cita.fechaAlta >= STR_TO_DATE('$fecha_desde','%d/%m/%Y')", "Cita.fechaAlta <= STR_TO_DATE('$fecha_hasta','%d/%m/%Y')"),
                'fields'=>array("$selectField AS cantidad", "MONTH(Cita.fechaAlta) AS mes"),
                'order'=>array('mes ASC'),
                'group'=>array('mes'),
                'recursive'=>-1
            )
        );
        
        // Rellenamos un array con los valores para los 12 meses
        $out = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach ($citas as $cita) {
            $out[$cita[0]['mes'] - 1] = $cita[0]['cantidad'];
        }
        
        return $out;
    }
    
    
    public function obtenerCitasPorCuadriculaUtmIntervaloAnios($especie_id, $cuadricula_utm, $anio_desde, $anio_hasta, $selectField) {
        
        $citas = $this -> find(
            'all', 
            array(
                'conditions'=>array('Cita.especie_id'=>$especie_id, 'Lugar.cuadricula_utm_id'=>$cuadricula_utm, 'YEAR(Cita.fechaAlta) >='=>$anio_desde, 'YEAR(Cita.fechaAlta) <='=>$anio_hasta),
                'fields'=>array("$selectField AS cantidad", "MONTH(Cita.fechaAlta) AS mes"),
                'order'=>array('mes ASC'),
                'group'=>array('mes')
            )
        );
        
        // Rellenamos un array con los valores para los 12 meses
        $out = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach ($citas as $cita) {
            $out[$cita[0]['mes'] - 1] = $cita[0]['cantidad'];
        }
        
        return $out;
    }
    
    public function obtenerCitasPorCuadriculaUtmYAnio($especie_id, $cuadricula_utm, $anio, $selectField) {
        
        $citas = $this -> find(
            'all', 
            array(
                'conditions'=>array('Cita.especie_id'=>$especie_id, 'Lugar.cuadricula_utm_id'=>$cuadricula_utm, 'YEAR(Cita.fechaAlta)'=>$anio),
                'fields'=>array("$selectField AS cantidad", "MONTH(Cita.fechaAlta) AS mes"),
                'order'=>array('mes ASC'),
                'group'=>array('mes')
            )
        );
        
        // Rellenamos un array con los valores para los 12 meses
        $out = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach ($citas as $cita) {
            $out[$cita[0]['mes'] - 1] = $cita[0]['cantidad'];
        }
        
        return $out;
    }
    
    public function obtenerCitasPorCuadriculaUtmIntervaloFechas($especie_id, $cuadricula_utm, $fecha_desde, $fecha_hasta, $selectField) {
        
        $citas = $this -> find(
            'all', 
            array(
                'conditions'=>array('Cita.especie_id'=>$especie_id, 'Lugar.cuadricula_utm_id'=>$cuadricula_utm, "Cita.fechaAlta >= STR_TO_DATE('$fecha_desde','%d/%m/%Y')", "Cita.fechaAlta <= STR_TO_DATE('$fecha_hasta','%d/%m/%Y')"),
                'fields'=>array("$selectField AS cantidad", "MONTH(Cita.fechaAlta) AS mes"),
                'order'=>array('mes ASC'),
                'group'=>array('mes')
            )
        );
        
        // Rellenamos un array con los valores para los 12 meses
        $out = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach ($citas as $cita) {
            $out[$cita[0]['mes'] - 1] = $cita[0]['cantidad'];
        }
        
        return $out;
    }
    
    public function obtenerTotalCitasPorMunicipio($especie_id) {
        
        $citas = $this -> find(
            'all', 
            array(
                'conditions'=>array('Cita.especie_id'=>$especie_id),
                'fields'=>array('COUNT(Cita.id) as total', 'Lugar.municipio_id as municipio'),
                'group'=>array('municipio')
            )
        );
        
        return $citas;
    }
    
    public function obtenerTotalCitasPorCuadriculaUtm($especie_id) {
        
        $citas = $this -> find(
            'all', 
            array(
                'conditions'=>array('Cita.especie_id'=>$especie_id),
                'fields'=>array('COUNT(Cita.id) as total', 'Lugar.cuadricula_utm_id as cuadriculaUtm'),
                'group'=>array('cuadriculaUtm')
            )
        );
        
        return $citas;
    }
    
    public function obtenerTotalCitasPorLugar($lugar_id) {
        
        $totalCitas = $this -> find(
            'count', 
            array(
                'conditions'=>array('Cita.lugar_id'=>$lugar_id)
            )
        );
        
        return $totalCitas;
    }
    
    public function obtenerTipoCriaPorMunicipio($especie_id) {
        
        $citas = $this -> find(
            'all', 
            array(
                'conditions'=>array('Cita.especie_id'=>$especie_id),
                'fields'=>array('Lugar.municipio_id as municipio', 'MAX(ClaseReproduccion.idTipoCria) as tipoCria'),
                'group'=>array('municipio')
            )
        );
        
        return $citas;
    }
    
    public function obtenerTipoCriaPorCuadriculaUtm($especie_id) {
        
        $citas = $this -> find(
            'all', 
            array(
                'conditions'=>array('Cita.especie_id'=>$especie_id),
                'fields'=>array('Lugar.cuadricula_utm_id as cuadriculaUtm', 'MAX(ClaseReproduccion.idTipoCria) as tipoCria'),
                'group'=>array('cuadriculaUtm')
            )
        );
        
        return $citas;
    }
    
    public function existeCita($especieId, $lugarId, $observadorId, $fechaAlta, $citaId=null) {
        
        try {
            
            $citas = 0;
            
            if($citaId != null) {
                $citas = $this -> find(
                    'count',
                    array(
                        'conditions'=>array('Cita.id <> '=>$citaId,'Cita.especie_id'=>$especieId, 'Cita.lugar_id'=>$lugarId, 'Cita.observador_principal_id'=>$observadorId, "Cita.fechaAlta = STR_TO_DATE('$fechaAlta','%d/%m/%Y')"),
                        'fields'=>array('Cita.id')
                    )
                );
            }
            else {
                $citas = $this -> find(
                    'count',
                    array(
                        'conditions'=>array('Cita.especie_id'=>$especieId, 'Cita.lugar_id'=>$lugarId, 'Cita.observador_principal_id'=>$observadorId, "Cita.fechaAlta = STR_TO_DATE('$fechaAlta','%d/%m/%Y')"),
                        'fields'=>array('Cita.id')
                    )
                );
            }
        
            return $citas;
        }
        catch(Exception $e) {
            $this->Session->setFlash(__('Ha ocurrido el siguiente error en la aplicación: '.$e->getMessage()), "failure");
            CakeLog::write('error', $e->getTrace());
        }
    }
}
