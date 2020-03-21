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

	public function obtenerCitasProvincialesPorAnio($especie_id, $anio) {

		$citas = $this -> find(
			'list',
			array(
				'conditions'=>array('CitaCount.especie_id'=>$especie_id, 'YEAR(CitaCount.fechaAlta)'=>$anio),
				'fields'=>array("MONTH(CitaCount.fechaAlta) AS mes", "CitaCount.citas_count"),
				'order'=>array('mes ASC'),
				'group'=>array('mes'),
				'recursive'=>-1
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0,0,0,0,0,0,0,0,0,0,0,0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}
}
