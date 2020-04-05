<?php
App::uses('AppModel', 'Model');

/**
 * Cita Count Model
 */
class CitaCountMes extends AppModel
{

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
		'citas_count' => 'COUNT(CitaCountMes.id)',
		'mes' => 'MONTH(CitaCountMes.fechaAlta)',
		'num_aves' => 'SUM(CitaCountMes.cantidad)',
	);

	public function obtenerCitasProvincialesPorAnio($especie_id, $anio)
	{

		$citas = $this->find(
			'list',
			array(
				'conditions' => array('CitaCountMes.especie_id' => $especie_id, 'YEAR(CitaCountMes.fechaAlta)' => $anio),
				'fields' => array("mes", "CitaCountMes.citas_count"),
				'order' => array('mes ASC'),
				'group' => array('mes'),
				'recursive' => -1
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}

	public function obtenerNumAvesProvincialesPorAnio($especie_id, $anio)
	{

		$citas = $this->find(
			'list',
			array(
				'conditions' => array('CitaCountMes.especie_id' => $especie_id, 'YEAR(CitaCountMes.fechaAlta)' => $anio),
				'fields' => array("mes", "CitaCountMes.num_aves"),
				'order' => array('mes ASC'),
				'group' => array('mes'),
				'recursive' => -1
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}

	public function obtenerCitasPorMunicipioYAnio($especie_id, $municipio, $anio)
	{

		$citas = $this->find(
			'list',
			array(
				'joins' => array(
					array(
						'table' => 'lugar',
						'alias' => 'Lugar',
						'type' => 'INNER',
						'conditions' => array(
							'Lugar.id = CitaCountMes.lugar_id'
						)
					)
				),
				'conditions' => array('CitaCountMes.especie_id' => $especie_id, 'Lugar.municipio_id' => $municipio, 'YEAR(CitaCountMes.fechaAlta)' => $anio),
				'fields' => array("mes", "CitaCountMes.citas_count"),
				'order' => array('mes ASC'),
				'group' => array('mes')
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}

	public function obtenerNumAvesPorMunicipioYAnio($especie_id, $municipio, $anio)
	{

		$citas = $this->find(
			'list',
			array(
				'joins' => array(
					array(
						'table' => 'lugar',
						'alias' => 'Lugar',
						'type' => 'INNER',
						'conditions' => array(
							'Lugar.id = CitaCountMes.lugar_id'
						)
					)
				),
				'conditions' => array('CitaCountMes.especie_id' => $especie_id, 'Lugar.municipio_id' => $municipio, 'YEAR(CitaCountMes.fechaAlta)' => $anio),
				'fields' => array("mes", "CitaCountMes.num_aves"),
				'order' => array('mes ASC'),
				'group' => array('mes')
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}

	public function obtenerCitasPorComarcaYAnio($especie_id, $comarca_id, $anio)
	{

		$citas = $this->find(
			'list',
			array(
				'joins' => array(
					array(
						'table' => 'lugar',
						'alias' => 'Lugar',
						'type' => 'INNER',
						'conditions' => array(
							'Lugar.id = CitaCountMes.lugar_id'
						)
					)
				),
				'conditions' => array('CitaCountMes.especie_id' => $especie_id, 'Lugar.comarca_id' => $comarca_id, 'YEAR(CitaCountMes.fechaAlta)' => $anio),
				'fields' => array("mes", "CitaCountMes.citas_count"),
				'order' => array('mes ASC'),
				'group' => array('mes')
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}

	public function obtenerNumAvesPorComarcaYAnio($especie_id, $comarca_id, $anio)
	{

		$citas = $this->find(
			'list',
			array(
				'joins' => array(
					array(
						'table' => 'lugar',
						'alias' => 'Lugar',
						'type' => 'INNER',
						'conditions' => array(
							'Lugar.id = CitaCountMes.lugar_id'
						)
					)
				),
				'conditions' => array('CitaCountMes.especie_id' => $especie_id, 'Lugar.comarca_id' => $comarca_id, 'YEAR(CitaCountMes.fechaAlta)' => $anio),
				'fields' => array("mes", "CitaCountMes.num_aves"),
				'order' => array('mes ASC'),
				'group' => array('mes')
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}

	public function obtenerCitasPorLugarYAnio($especie_id, $lugar_id, $anio)
	{

		$citas = $this->find(
			'list',
			array(
				'joins' => array(
					array(
						'table' => 'lugar',
						'alias' => 'Lugar',
						'type' => 'INNER',
						'conditions' => array(
							'Lugar.id = CitaCountMes.lugar_id'
						)
					)
				),
				'conditions' => array('CitaCountMes.especie_id' => $especie_id, 'Lugar.id' => $lugar_id, 'YEAR(CitaCountMes.fechaAlta)' => $anio),
				'fields' => array("mes", "CitaCountMes.citas_count"),
				'order' => array('mes ASC'),
				'group' => array('mes')
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}

	public function obtenerNumAvesPorLugarYAnio($especie_id, $lugar_id, $anio)
	{

		$citas = $this->find(
			'list',
			array(
				'joins' => array(
					array(
						'table' => 'lugar',
						'alias' => 'Lugar',
						'type' => 'INNER',
						'conditions' => array(
							'Lugar.id = CitaCountMes.lugar_id'
						)
					)
				),
				'conditions' => array('CitaCountMes.especie_id' => $especie_id, 'Lugar.id' => $lugar_id, 'YEAR(CitaCountMes.fechaAlta)' => $anio),
				'fields' => array("mes", "CitaCountMes.num_aves"),
				'order' => array('mes ASC'),
				'group' => array('mes')
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}

	public function obtenerCitasPorCuadriculaUtmYAnio($especie_id, $cuadricula_utm_id, $anio)
	{

		$citas = $this->find(
			'list',
			array(
				'joins' => array(
					array(
						'table' => 'lugar',
						'alias' => 'Lugar',
						'type' => 'INNER',
						'conditions' => array(
							'Lugar.id = CitaCountMes.lugar_id'
						)
					)
				),
				'conditions' => array('CitaCountMes.especie_id' => $especie_id, 'Lugar.cuadricula_utm_id' => $cuadricula_utm_id, 'YEAR(CitaCountMes.fechaAlta)' => $anio),
				'fields' => array("mes", "CitaCountMes.citas_count"),
				'order' => array('mes ASC'),
				'group' => array('mes')
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}

	public function obtenerNumAvesPorCuadriculaUtmYAnio($especie_id, $cuadricula_utm_id, $anio)
	{

		$citas = $this->find(
			'list',
			array(
				'joins' => array(
					array(
						'table' => 'lugar',
						'alias' => 'Lugar',
						'type' => 'INNER',
						'conditions' => array(
							'Lugar.id = CitaCountMes.lugar_id'
						)
					)
				),
				'conditions' => array('CitaCountMes.especie_id' => $especie_id, 'Lugar.cuadricula_utm_id' => $cuadricula_utm_id, 'YEAR(CitaCountMes.fechaAlta)' => $anio),
				'fields' => array("mes", "CitaCountMes.num_aves"),
				'order' => array('mes ASC'),
				'group' => array('mes')
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}

	public function obtenerCitasProvincialesPorIntervaloFechas($especie_id, $fecha_desde, $fecha_hasta)
	{

		$citas = $this->find(
			'list',
			array(
				'conditions' => array(
					'CitaCountMes.especie_id' => $especie_id,
					"CitaCountMes.fechaAlta >= STR_TO_DATE('$fecha_desde','%d/%m/%Y')",
					"CitaCountMes.fechaAlta <= STR_TO_DATE('$fecha_hasta','%d/%m/%Y')"
				),
				'fields' => array("mes", "CitaCountMes.citas_count"),
				'order' => array('mes ASC'),
				'group' => array('mes'),
				'recursive' => -1
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}

	public function obtenerNumAvesProvincialesPorIntervaloFechas($especie_id, $fecha_desde, $fecha_hasta)
	{

		$citas = $this->find(
			'list',
			array(
				'conditions' => array(
					'CitaCountMes.especie_id' => $especie_id,
					"CitaCountMes.fechaAlta >= STR_TO_DATE('$fecha_desde','%d/%m/%Y')",
					"CitaCountMes.fechaAlta <= STR_TO_DATE('$fecha_hasta','%d/%m/%Y')"
				),
				'fields' => array("mes", "CitaCountMes.num_aves"),
				'order' => array('mes ASC'),
				'group' => array('mes'),
				'recursive' => -1
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}

	/**
	 * Obtiene las citas provinciales por mes
	 *
	 * @param number $especie_id
	 * @return array
	 */
	public function obtenerCitasProvincialesPorIntervaloAnios($especie_id, $anio_desde, $anio_hasta)
	{

		$citas = $this->find(
			'list',
			array(
				'conditions' => array(
					'CitaCountMes.especie_id' => $especie_id,
					'YEAR(CitaCountMes.fechaAlta) >=' => $anio_desde,
					'YEAR(CitaCountMes.fechaAlta) <=' => $anio_hasta
				),
				'fields' => array("mes", "CitaCountMes.citas_count"),
				'order' => array('mes ASC'),
				'group' => array('mes'),
				'recursive' => -1
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}

	/**
	 * Obtiene las citas provinciales por mes
	 *
	 * @param number $especie_id
	 * @return array
	 */
	public function obtenerNumAvesProvincialesPorIntervaloAnios($especie_id, $anio_desde, $anio_hasta)
	{

		$citas = $this->find(
			'list',
			array(
				'conditions' => array(
					'CitaCountMes.especie_id' => $especie_id,
					'YEAR(CitaCountMes.fechaAlta) >=' => $anio_desde,
					'YEAR(CitaCountMes.fechaAlta) <=' => $anio_hasta
				),
				'fields' => array("mes", "CitaCountMes.num_aves"),
				'order' => array('mes ASC'),
				'group' => array('mes'),
				'recursive' => -1
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}

	public function obtenerCitasPorMunicipioIntervaloFechas($especie_id, $municipio, $fecha_desde, $fecha_hasta)
	{

		$citas = $this->find(
			'list',
			array(
				'joins' => array(
					array(
						'table' => 'lugar',
						'alias' => 'Lugar',
						'type' => 'INNER',
						'conditions' => array(
							'Lugar.id = CitaCountMes.lugar_id'
						)
					)
				),
				'conditions' => array(
					'CitaCountMes.especie_id' => $especie_id,
					'Lugar.municipio_id' => $municipio,
					"CitaCountMes.fechaAlta >= STR_TO_DATE('$fecha_desde','%d/%m/%Y')",
					"CitaCountMes.fechaAlta <= STR_TO_DATE('$fecha_hasta','%d/%m/%Y')"
				),
				'fields' => array("mes", "CitaCountMes.citas_count"),
				'order' => array('mes ASC'),
				'group' => array('mes')
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}

	public function obtenerNumAvesPorMunicipioIntervaloFechas($especie_id, $municipio, $fecha_desde, $fecha_hasta)
	{

		$citas = $this->find(
			'list',
			array(
				'joins' => array(
					array(
						'table' => 'lugar',
						'alias' => 'Lugar',
						'type' => 'INNER',
						'conditions' => array(
							'Lugar.id = CitaCountMes.lugar_id'
						)
					)
				),
				'conditions' => array(
					'CitaCountMes.especie_id' => $especie_id,
					'Lugar.municipio_id' => $municipio,
					"CitaCountMes.fechaAlta >= STR_TO_DATE('$fecha_desde','%d/%m/%Y')",
					"CitaCountMes.fechaAlta <= STR_TO_DATE('$fecha_hasta','%d/%m/%Y')"
				),
				'fields' => array("mes", "CitaCountMes.num_aves"),
				'order' => array('mes ASC'),
				'group' => array('mes')
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}

	public function obtenerCitasPorMunicipioIntervaloAnios($especie_id, $municipio, $anio_desde, $anio_hasta)
	{

		$citas = $this->find(
			'list',
			array(
				'joins' => array(
					array(
						'table' => 'lugar',
						'alias' => 'Lugar',
						'type' => 'INNER',
						'conditions' => array(
							'Lugar.id = CitaCountMes.lugar_id'
						)
					)
				),
				'conditions' => array(
					'CitaCountMes.especie_id' => $especie_id,
					'Lugar.municipio_id' => $municipio,
					'YEAR(CitaCountMes.fechaAlta) >=' => $anio_desde,
					'YEAR(CitaCountMes.fechaAlta) <=' => $anio_hasta
				),
				'fields' => array("mes", "CitaCountMes.citas_count"),
				'order' => array('mes ASC'),
				'group' => array('mes')
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}

	public function obtenerNumAvesPorMunicipioIntervaloAnios($especie_id, $municipio, $anio_desde, $anio_hasta)
	{

		$citas = $this->find(
			'list',
			array(
				'joins' => array(
					array(
						'table' => 'lugar',
						'alias' => 'Lugar',
						'type' => 'INNER',
						'conditions' => array(
							'Lugar.id = CitaCountMes.lugar_id'
						)
					)
				),
				'conditions' => array(
					'CitaCountMes.especie_id' => $especie_id,
					'Lugar.municipio_id' => $municipio,
					'YEAR(CitaCountMes.fechaAlta) >=' => $anio_desde,
					'YEAR(CitaCountMes.fechaAlta) <=' => $anio_hasta
				),
				'fields' => array("mes", "CitaCountMes.num_aves"),
				'order' => array('mes ASC'),
				'group' => array('mes')
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}

	public function obtenerCitasPorComarcaIntervaloFechas($especie_id, $comarca_id, $fecha_desde, $fecha_hasta)
	{
		$citas = $this->find(
			'list',
			array(
				'joins' => array(
					array(
						'table' => 'lugar',
						'alias' => 'Lugar',
						'type' => 'INNER',
						'conditions' => array(
							'Lugar.id = CitaCountMes.lugar_id'
						)
					)
				),
				'conditions' => array(
					'CitaCountMes.especie_id' => $especie_id,
					'Lugar.comarca_id' => $comarca_id,
					"CitaCountMes.fechaAlta >= STR_TO_DATE('$fecha_desde','%d/%m/%Y')",
					"CitaCountMes.fechaAlta <= STR_TO_DATE('$fecha_hasta','%d/%m/%Y')"
				),
				'fields' => array("mes", "CitaCountMes.citas_count"),
				'order' => array('mes ASC'),
				'group' => array('mes')
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}

	public function obtenerNumAvesPorComarcaIntervaloFechas($especie_id, $comarca_id, $fecha_desde, $fecha_hasta)
	{
		$citas = $this->find(
			'list',
			array(
				'joins' => array(
					array(
						'table' => 'lugar',
						'alias' => 'Lugar',
						'type' => 'INNER',
						'conditions' => array(
							'Lugar.id = CitaCountMes.lugar_id'
						)
					)
				),
				'conditions' => array(
					'CitaCountMes.especie_id' => $especie_id,
					'Lugar.comarca_id' => $comarca_id,
					"CitaCountMes.fechaAlta >= STR_TO_DATE('$fecha_desde','%d/%m/%Y')",
					"CitaCountMes.fechaAlta <= STR_TO_DATE('$fecha_hasta','%d/%m/%Y')"
				),
				'fields' => array("mes", "CitaCountMes.num_aves"),
				'order' => array('mes ASC'),
				'group' => array('mes')
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}

	public function obtenerCitasPorComarcaIntervaloAnios($especie_id, $comarca_id, $anio_desde, $anio_hasta)
	{

		$citas = $this->find(
			'list',
			array(
				'joins' => array(
					array(
						'table' => 'lugar',
						'alias' => 'Lugar',
						'type' => 'INNER',
						'conditions' => array(
							'Lugar.id = CitaCountMes.lugar_id'
						)
					)
				),
				'conditions' => array(
					'CitaCountMes.especie_id' => $especie_id,
					'Lugar.comarca_id' => $comarca_id,
					'YEAR(CitaCountMes.fechaAlta) >=' => $anio_desde,
					'YEAR(CitaCountMes.fechaAlta) <=' => $anio_hasta
				),
				'fields' => array("mes", "CitaCountMes.citas_count"),
				'order' => array('mes ASC'),
				'group' => array('mes')
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}

	public function obtenerNumAvesPorComarcaIntervaloAnios($especie_id, $comarca_id, $anio_desde, $anio_hasta)
	{

		$citas = $this->find(
			'list',
			array(
				'joins' => array(
					array(
						'table' => 'lugar',
						'alias' => 'Lugar',
						'type' => 'INNER',
						'conditions' => array(
							'Lugar.id = CitaCountMes.lugar_id'
						)
					)
				),
				'conditions' => array(
					'CitaCountMes.especie_id' => $especie_id,
					'Lugar.comarca_id' => $comarca_id,
					'YEAR(CitaCountMes.fechaAlta) >=' => $anio_desde,
					'YEAR(CitaCountMes.fechaAlta) <=' => $anio_hasta
				),
				'fields' => array("mes", "CitaCountMes.num_aves"),
				'order' => array('mes ASC'),
				'group' => array('mes')
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}

	public function obtenerCitasPorLugarIntervaloFechas($especie_id, $lugar, $fecha_desde, $fecha_hasta)
	{
		$citas = $this->find(
			'list',
			array(
				'conditions' => array(
					'CitaCountMes.especie_id' => $especie_id,
					'CitaCountMes.lugar_id' => $lugar,
					"CitaCountMes.fechaAlta >= STR_TO_DATE('$fecha_desde','%d/%m/%Y')",
					"CitaCountMes.fechaAlta <= STR_TO_DATE('$fecha_hasta','%d/%m/%Y')"
				),
				'fields' => array("mes", "CitaCountMes.citas_count"),
				'order' => array('mes ASC'),
				'group' => array('mes'),
				'recursive' => -1
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}

	public function obtenerNumAvesPorLugarIntervaloFechas($especie_id, $lugar, $fecha_desde, $fecha_hasta)
	{
		$citas = $this->find(
			'list',
			array(
				'conditions' => array(
					'CitaCountMes.especie_id' => $especie_id,
					'CitaCountMes.lugar_id' => $lugar,
					"CitaCountMes.fechaAlta >= STR_TO_DATE('$fecha_desde','%d/%m/%Y')",
					"CitaCountMes.fechaAlta <= STR_TO_DATE('$fecha_hasta','%d/%m/%Y')"
				),
				'fields' => array("mes", "CitaCountMes.num_aves"),
				'order' => array('mes ASC'),
				'group' => array('mes'),
				'recursive' => -1
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}

	public function obtenerCitasPorLugarIntervaloAnios($especie_id, $lugar, $anio_desde, $anio_hasta)
	{
		$citas = $this->find(
			'list',
			array(
				'conditions' => array(
					'CitaCountMes.especie_id' => $especie_id,
					'CitaCountMes.lugar_id' => $lugar,
					'YEAR(CitaCountMes.fechaAlta) >=' => $anio_desde,
					'YEAR(CitaCountMes.fechaAlta) <=' => $anio_hasta
				),
				'fields' => array("mes", "CitaCountMes.citas_count"),
				'order' => array('mes ASC'),
				'group' => array('mes'),
				'recursive' => -1
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}

	public function obtenerNumAvesPorLugarIntervaloAnios($especie_id, $lugar, $anio_desde, $anio_hasta)
	{
		$citas = $this->find(
			'list',
			array(
				'conditions' => array(
					'CitaCountMes.especie_id' => $especie_id,
					'CitaCountMes.lugar_id' => $lugar,
					'YEAR(CitaCountMes.fechaAlta) >=' => $anio_desde,
					'YEAR(CitaCountMes.fechaAlta) <=' => $anio_hasta
				),
				'fields' => array("mes", "CitaCountMes.num_aves"),
				'order' => array('mes ASC'),
				'group' => array('mes'),
				'recursive' => -1
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}

	public function obtenerCitasPorCuadriculaUtmIntervaloFechas($especie_id, $cuadricula_utm, $fecha_desde, $fecha_hasta)
	{

		$citas = $this->find(
			'list',
			array(
				'joins' => array(
					array(
						'table' => 'lugar',
						'alias' => 'Lugar',
						'type' => 'INNER',
						'conditions' => array(
							'Lugar.id = CitaCountMes.lugar_id'
						)
					)
				),
				'conditions' => array(
					'CitaCountMes.especie_id' => $especie_id,
					'Lugar.cuadricula_utm_id' => $cuadricula_utm,
					"CitaCountMes.fechaAlta >= STR_TO_DATE('$fecha_desde','%d/%m/%Y')",
					"CitaCountMes.fechaAlta <= STR_TO_DATE('$fecha_hasta','%d/%m/%Y')"
				),
				'fields' => array("mes", "CitaCountMes.citas_count"),
				'order' => array('mes ASC'),
				'group' => array('mes')
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $cantidad) {
			$out[$mes - 1] = $cantidad;
		}

		return $out;
	}

	public function obtenerNumAvesPorCuadriculaUtmIntervaloFechas($especie_id, $cuadricula_utm, $fecha_desde, $fecha_hasta)
	{

		$citas = $this->find(
			'list',
			array(
				'joins' => array(
					array(
						'table' => 'lugar',
						'alias' => 'Lugar',
						'type' => 'INNER',
						'conditions' => array(
							'Lugar.id = CitaCountMes.lugar_id'
						)
					)
				),
				'conditions' => array(
					'CitaCountMes.especie_id' => $especie_id,
					'Lugar.cuadricula_utm_id' => $cuadricula_utm,
					"CitaCountMes.fechaAlta >= STR_TO_DATE('$fecha_desde','%d/%m/%Y')",
					"CitaCountMes.fechaAlta <= STR_TO_DATE('$fecha_hasta','%d/%m/%Y')"
				),
				'fields' => array("mes", "CitaCountMes.num_aves"),
				'order' => array('mes ASC'),
				'group' => array('mes')
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $cantidad) {
			$out[$mes - 1] = $cantidad;
		}

		return $out;
	}

	public function obtenerCitasPorCuadriculaUtmIntervaloAnios($especie_id, $cuadricula_utm, $anio_desde, $anio_hasta)
	{

		$citas = $this->find(
			'list',
			array(
				'joins' => array(
					array(
						'table' => 'lugar',
						'alias' => 'Lugar',
						'type' => 'INNER',
						'conditions' => array(
							'Lugar.id = CitaCountMes.lugar_id'
						)
					)
				),
				'conditions' => array(
					'CitaCountMes.especie_id' => $especie_id,
					'Lugar.cuadricula_utm_id' => $cuadricula_utm,
					'YEAR(CitaCountMes.fechaAlta) >=' => $anio_desde,
					'YEAR(CitaCountMes.fechaAlta) <=' => $anio_hasta
				),
				'fields' => array("mes", "CitaCountMes.citas_count"),
				'order' => array('mes ASC'),
				'group' => array('mes')
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}

	public function obtenerNumAvesPorCuadriculaUtmIntervaloAnios($especie_id, $cuadricula_utm, $anio_desde, $anio_hasta)
	{

		$citas = $this->find(
			'list',
			array(
				'joins' => array(
					array(
						'table' => 'lugar',
						'alias' => 'Lugar',
						'type' => 'INNER',
						'conditions' => array(
							'Lugar.id = CitaCountMes.lugar_id'
						)
					)
				),
				'conditions' => array(
					'CitaCountMes.especie_id' => $especie_id,
					'Lugar.cuadricula_utm_id' => $cuadricula_utm,
					'YEAR(CitaCountMes.fechaAlta) >=' => $anio_desde,
					'YEAR(CitaCountMes.fechaAlta) <=' => $anio_hasta
				),
				'fields' => array("mes", "CitaCountMes.num_aves"),
				'order' => array('mes ASC'),
				'group' => array('mes')
			)
		);

		// Rellenamos un array con los valores para los 12 meses
		$out = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		foreach ($citas as $mes => $citasCount) {
			$out[$mes - 1] = $citasCount;
		}

		return $out;
	}
}
