<?php
App::uses('AppModel', 'Model');
/**
 * AsoCuadriculaUtmMunicipio Model
 *
 * @property Municipio $Municipio
 * @property CuadriculaUtm $CuadriculaUtm
 */
class AsoCuadriculaUtmMunicipio extends AppModel {
	
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
	public $useTable = 'aso_cuadricula_utm_municipio';


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
		)
	);
	
	/*
	 * Funciones
	 */
	
	public function obtenerMunicipiosPorCuadriculaUtm($cuadricula_utm_id) {
		
		$municipios = $this -> find(
			'all', 
			array(
				'conditions'=>array('AsoCuadriculaUtmMunicipio.cuadricula_utm_id'=>$cuadricula_utm_id),
			)
		);
		
		return $municipios;
	}
}
