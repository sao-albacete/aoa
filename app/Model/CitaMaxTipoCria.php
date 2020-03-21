<?php
App::uses('AppModel', 'Model');
/**
 * Cita Count Model
 */
class CitaMaxTipoCria extends AppModel {

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

	var $virtualFields = array(
		'max_tipo_cria' => 'MAX(ClaseReproduccion.idTipoCria)'
	);

	/**
	 * Obtiene el tipo de cria por municipio
	 *
	 * @param $especie_id
	 * @return array
	 */
	public function obtenerTipoCriaPorMunicipio($especie_id) {

		$citas = $this -> find(
			'list',
			array(
				'joins' => array(
					array(
						'table' => 'lugar',
						'alias' => 'Lugar',
						'type' => 'INNER',
						'conditions' => array(
							'Lugar.id = CitaMaxTipoCria.lugar_id'
						)
					),
					array(
						'table' => 'clase_reproduccion',
						'alias' => 'ClaseReproduccion',
						'type' => 'INNER',
						'conditions' => array(
							'ClaseReproduccion.id = CitaMaxTipoCria.clase_reproduccion_id'
						)
					),
				),
				'conditions'=>array('CitaMaxTipoCria.especie_id'=>$especie_id),
				'fields'=>array('Lugar.municipio_id', 'max_tipo_cria'),
				'group'=>array('Lugar.municipio_id')
			)
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
			'list',
			array(
				'joins' => array(
					array(
						'table' => 'lugar',
						'alias' => 'Lugar',
						'type' => 'INNER',
						'conditions' => array(
							'Lugar.id = CitaMaxTipoCria.lugar_id'
						)
					),
					array(
						'table' => 'clase_reproduccion',
						'alias' => 'ClaseReproduccion',
						'type' => 'INNER',
						'conditions' => array(
							'ClaseReproduccion.id = CitaMaxTipoCria.clase_reproduccion_id'
						)
					),
				),
				'conditions'=>array('CitaMaxTipoCria.especie_id'=>$especie_id),
				'fields'=>array('Lugar.cuadricula_utm_id', 'max_tipo_cria'),
				'group'=>array('Lugar.cuadricula_utm_id')
			)
		);

		return $citas;
	}
}
