<?php
App::uses('AppModel', 'Model');
/**
 * Lugar Model
 *
 */
class Lugar extends AppModel {

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
	public $useTable = 'lugar';
	
	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'nombre';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Municipio' => array(
			'className' => 'Municipio',
			'foreignKey' => 'municipio_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CuadriculaUtm' => array(
			'className' => 'CuadriculaUtm',
			'foreignKey' => 'cuadricula_utm_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Comarca' => array(
			'className' => 'Comarca',
			'foreignKey' => 'comarca_id',
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
		)
	);
	
	/**
	 * Validaciones
	 */
	public $validate = array(
		'nombre' => array(
            'required' => array(
                'rule' => 'notEmpty',
				'required' => true,
                'message' => 'El nombre es obligatorio.'
            ),
             'between' => array(
                'rule' => array('between', 0, 100),
        		'required' => true,
                'message' => 'El nombre no puede tener más de 100 caracteres.'
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
                'message' => 'El id del usuario debe ser un numero.'
            )
        ),
        'municipio_id' => array(
            'required' => array(
                'rule' => 'notEmpty',
        		'required' => true,
                'message' => 'El municipio es obligatorio.'
            ),
            'numeric' => array(
                'rule' => 'naturalNumber',
        		'required' => true,
                'message' => 'El id del municipio debe ser un numero.'
            )
        ),
        'comarca_id' => array(
            'required' => array(
                'rule' => 'notEmpty',
        		'required' => true,
                'message' => 'La comarca es obligatoria.'
            ),
            'numeric' => array(
                'rule' => 'naturalNumber',
        		'required' => true,
                'message' => 'El id de la comarca debe ser un numero.'
            )
        ),
        'cuadricula_utm_id' => array(
            'required' => array(
                'rule' => 'notEmpty',
        		'required' => true,
                'message' => 'La cuadrícula UTM es obligatoria.'
            ),
            'numeric' => array(
                'rule' => 'naturalNumber',
        		'required' => true,
                'message' => 'El id de la cuadrícula UTM debe ser un numero.'
            )
        ),
        'coordenadaX' => array(
        	'maxLength' => array(
        		'rule' => array('maxLength', 999999),
        		'message' => 'La coordenada X no puede tener más de 6 cifras.',
        		'required' => true,
        	),
            'numeric' => array(
                'rule' => 'naturalNumber',
                'message' => 'La coordenada X debe ser un numero.',
                'required' => true,
            )
        ),
        'coordenadaY' => array(
        	'maxLength' => array(
        		'rule' => array('maxLength', 9999999),
        		'message' => 'La coordenada Y no puede tener más de 7 cifras.',
        		'required' => true,
        	),
            'numeric' => array(
                'rule' => 'naturalNumber',
                'message' => 'La coordenada Y debe ser un numero.',
                'required' => true,
            )
        )
	);
	
	/*
	 * Funciones
	 */
	
	/**
	 * Obtiene toda la información de un lugar
	 */
	public function obtenerTodoPorId($lugar_id) {
		
		$lugar = $this -> find(
			'first', 
			array(
				'conditions'=>array('Lugar.id'=>$lugar_id)
			)
		);
		
		return $lugar;
	}
	
	/**
	 * Obtiene todos los lugares activos ordenados por nombre 
	 */
	public function obtenerLugaresActivosOrdenadosPorNombre($indBasicData=true) {
		
		if($indBasicData == true) {
			$lugares = $this -> find(
				'all',
				array(
					'fields'=>array('Lugar.id', 'Lugar.nombre'),
					'conditions'=>array('Lugar.indActivo'=>1),
					'order'=>array('Lugar.nombre ASC'),
					'recursive'=>-1
				)
			);
		}
		else {
			$lugares = $this->find(
				'all', 
				array(
					'fields' => array('Lugar.id', 'Lugar.nombre', 'Municipio.nombre', 'CuadriculaUtm.codigo', 'Comarca.nombre'),
					'conditions'=>array('Lugar.indActivo'=>1),
					'order'=>array('Lugar.nombre ASC')
				)
			);
		}
		
		return $lugares;
	}
	
	/**
	 * Obtiene toda la información de un lugar
	 */
	public function obtenerLugaresPorMunicipioYCodigoCuadriculaUtm($cuadriculaUtmId, $municipioId) {
	
		$lugares = $this -> find(
			'all',
			array(
				'conditions'=>array('Lugar.cuadricula_utm_id'=>$cuadriculaUtmId, 'Lugar.municipio_id'=>$municipioId)
			)
		);
	
		return $lugares;
	}
}
