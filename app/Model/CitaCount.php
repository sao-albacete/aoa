<?php
App::uses('AppModel', 'Model');
/**
 * Cita Count Model
 */
class CitaCount extends AppModel {

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
		'citas_count' => 'COUNT(CitaCount.id)'
	);

    public function obtenerTotalCitasPorCuadriculaUtm($especie_id) {

        $citas = $this -> find(
            'list',
            array(
				'joins' => array(
					array(
						'table' => 'lugar',
						'alias' => 'Lugar',
						'type' => 'INNER',
						'conditions' => array(
							'Lugar.id = CitaCount.lugar_id'
						)
					)
				),
                'conditions'=>array('CitaCount.especie_id'=>$especie_id),
                'fields'=>array('Lugar.cuadricula_utm_id', 'citas_count'),
                'group'=>array('Lugar.cuadricula_utm_id')
            )
        );

        return $citas;
    }

	public function obtenerTotalCitasPorMunicipio($especie_id) {

		$citas = $this -> find(
			'list',
			array(
				'joins' => array(
					array(
						'table' => 'lugar',
						'alias' => 'Lugar',
						'type' => 'INNER',
						'conditions' => array(
							'Lugar.id = CitaCount.lugar_id'
						)
					)
				),
				'conditions'=>array('CitaCount.especie_id'=>$especie_id),
				'fields'=>array('Lugar.municipio_id', 'citas_count'),
				'group'=>array('Lugar.municipio_id')
			)
		);

		return $citas;
	}
}
