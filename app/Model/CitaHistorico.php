<?php
App::uses('AppModel', 'Model');
/**
 * CitaHistorico Model
 *
 * @property Cita $Cita
 * @property Lugar $Lugar
 * @property Usuario $Usuario
 * @property ClaseReproduccion $ClaseReproduccion
 * @property Fuente $Fuente
 * @property Especie $Especie
 * @property CriterioSeleccionCita $CriterioSeleccionCita
 */
class CitaHistorico extends AppModel {

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
	public $useTable = 'cita_historico';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Cita' => array(
			'className' => 'Cita',
			'foreignKey' => 'cita_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
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
		)
	);

	/**
	 * Validaciones
	 */
	public $validate = array(
		'usuarioHistorico' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'El usuario histórico es obligatorio.'
			),
			'numeric' => array(
				'rule' => 'naturalNumber',
				'required' => true,
				'message' => 'El identificador del usuario histórico ser un numero.'
			)
		),
		'fechaHistorico' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'required' => 'create',
				'message' => 'La fecha de histórico es obligatoria.'
			),
			'date' => array(
				'rule' => array('date', 'ymd'),
				'required' => 'create',
				'message' => 'La fecha de histórico tiene un formato incorrecto.'
			)
		),
		'fechaAlta' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'required' => 'create',
				'message' => 'La fecha de alta es obligatoria.'
			),
			'date' => array(
				'rule' => array('datetime', 'ymd'),
				'required' => 'create',
				'message' => 'La fecha de observación tiene un formato incorrecto.'
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
                'rule' => array('between', 0, 256),
        		'required' => true,
                'message' => 'El texto de observaciones no puede ser mayor de 256 caracteres.'
            )
        ),
        'cita_id' => array(
        	'required' => array(
        		'rule' => 'notEmpty',
        		'required' => true,
        		'message' => 'El identificador de la cita es obligatorio.'
        	),
        	'numeric' => array(
        		'rule' => 'naturalNumber',
        		'required' => true,
        		'message' => 'El identificador de la cita debe ser un numero.'
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
                'message' => 'El valor debe ser un booleano.'
        ),
        'indCriaHabitatRaro' => array(
            'rule' => array('boolean'),
        	'required' => false,
            'message' => 'El valor debe ser un booleano.'
        ),
        'indHerido' => array(
            'rule' => array('boolean'),
        	'required' => false,
            'message' => 'El valor debe ser un booleano.'
        ),
        'indComportamiento' => array(
            'rule' => array('boolean'),
        	'required' => false,
            'message' => 'El valor debe ser un booleano.'
        )
	);

	public function guardarHistorico($cita, $usuarioId) {

		try {

			$citaHistorico = $this->pasarCitaACitaHistorico($cita);
			$citaHistorico['CitaHistorico']['fechaHistorico'] = date("Y-m-d");
			$citaHistorico['CitaHistorico']['usuarioHistorico'] = $usuarioId;

			$this->create();

			$this->set($citaHistorico);

			if ($this->validates()) {
				$this->save($citaHistorico);
			}
			else {
				$errors = $this->validationErrors;

				$errorsMessages = "";
				foreach ($errors as $validationError) {
					$errorsMessages .= $validationError[0]."\n";
				}

				return $errorsMessages;
			}
		}
		catch(Exception $e) {
			throw $e;
		}
	}

	private function pasarCitaACitaHistorico($cita) {

		$citaHistorico['CitaHistorico']['cita_id'] = $cita['Cita']['id'];
		$citaHistorico['CitaHistorico']['fechaAlta'] = $cita['Cita']['fechaAlta'];
		$citaHistorico['CitaHistorico']['cantidad'] = $cita['Cita']['cantidad'];
		$citaHistorico['CitaHistorico']['observaciones'] = $cita['Cita']['observaciones'];
		$citaHistorico['CitaHistorico']['indSeleccionada'] = $cita['Cita']['indSeleccionada'];
		$citaHistorico['CitaHistorico']['lugar_id'] = $cita['Cita']['lugar_id'];
		$citaHistorico['CitaHistorico']['indRarezaHomologada'] = $cita['Cita']['indRarezaHomologada'];
		$citaHistorico['CitaHistorico']['observador_principal_id'] = $cita['Cita']['observador_principal_id'];
		$citaHistorico['CitaHistorico']['clase_reproduccion_id'] = $cita['Cita']['clase_reproduccion_id'];
		$citaHistorico['CitaHistorico']['fuente_id'] = $cita['Cita']['fuente_id'];
		$citaHistorico['CitaHistorico']['indHabitatRaro'] = $cita['Cita']['indHabitatRaro'];
		$citaHistorico['CitaHistorico']['indCriaHabitatRaro'] = $cita['Cita']['indCriaHabitatRaro'];
		$citaHistorico['CitaHistorico']['indHerido'] = $cita['Cita']['indHerido'];
		$citaHistorico['CitaHistorico']['indComportamiento'] = $cita['Cita']['indComportamiento'];
		$citaHistorico['CitaHistorico']['especie_id'] = $cita['Cita']['especie_id'];
		$citaHistorico['CitaHistorico']['criterio_seleccion_cita_id'] = $cita['Cita']['criterio_seleccion_cita_id'];
		$citaHistorico['CitaHistorico']['importancia_cita_id'] = $cita['Cita']['importancia_cita_id'];

		return $citaHistorico;
	}
}
