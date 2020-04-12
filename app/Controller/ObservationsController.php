<?php


class ObservationsController extends AppController
{
	public $components = array('RequestHandler');

	/**
	 * Modelos
	 */
	public $uses = [
		'Cita',
		'ClaseEdadSexo',
		'ObservadorSecundario',
		'Municipio',
		'Comarca',
		'CuadriculaUtm',
	];

	public function beforeFilter()
	{
		parent::beforeFilter();

		$this->Auth->allow(
			'index'
		);
	}

	public function index()
	{
		$params = array(
//			'fields' => $this->aFields,
			'conditions' => [],
			'limit' => 10,
			'page' => 0,
			'order' => ['Cita.fechaAlta DESC']
		);
		if (!empty($aJoins)) {
			$params['joins'] = $aJoins;
		}

		$citas = $this->Cita->find('all', $params);

		$observations = [];
		foreach ($citas as $cita) {
			// Clase edad - sexo
			$amountDetails = [];
			foreach ($cita['AsoCitaClaseEdadSexo'] as $citaClaseEdadSexo) {
				$amountDetail = [
					'gender-and-age' => $this->ClaseEdadSexo->obtenerNombrePorId($citaClaseEdadSexo['clase_edad_sexo_id']),
					'total' => $citaClaseEdadSexo['cantidad']
				];
				$amountDetails[] = $amountDetail;
			}
			// Colaboradores
			$collaborators = [];
			foreach ($cita['AsoCitaObservador'] as $citaObservadorSecundario) {
				$collaborator = [
					'name' => $this->ObservadorSecundario->obtenerNombrePorId($citaObservadorSecundario['observador_secundario_id']),
					'code' => $this->ObservadorSecundario->obtenerCodigoPorId($citaObservadorSecundario['observador_secundario_id']),
				];
				$collaborators[] = $collaborator;
			}
			$observation = [
				'observation-date' => $cita['Cita']['fechaAlta'],
				'amount' => [
					'total' => $cita['Cita']['cantidad'],
					'detail' => $amountDetails,
				],
				'species' => [
					'code' => $cita['Especie']['codigo'],
					'euring-code' => $cita['Especie']['codigoEuring'],
					'aerc-code' => $cita['Especie']['codigoAerc'],
					'common-name' => $cita['Especie']['nombreComun'],
					'english-name' => $cita['Especie']['nombreIngles'],
					'scientific-name' => $cita['Especie']['genero'] . ' ' . $cita['Especie']['especie'] . (is_null($cita['Especie']['subespecie']) ? '' : ' ' . $cita['Especie']['subespecie']),
				],
				'location' => [
					'name' => $cita['Lugar']['nombre'],
					'x-axis' => $cita['Lugar']['coordenadaX'],
					'y-axis' => $cita['Lugar']['coordenadaY'],
					'utm-10x10-cell' => $this->CuadriculaUtm->obtenerCodigoPorId($cita['Lugar']['cuadricula_utm_id']),
					'municipality' => $this->Municipio->obtenerNombrePorId($cita['Lugar']['municipio_id']),
					'region' => $this->Comarca->obtenerNombrePorId($cita['Lugar']['comarca_id']),
				],
				'watcher' => [
					'name' => $cita['ObservadorPrincipal']['nombre'],
					'code' => $cita['ObservadorPrincipal']['codigo'],
					'collaborators' => $collaborators,
				],
				'source' => $cita['Fuente']['nombre'],
				'study' => [
					'name' => $cita['Estudio']['nombre'],
					'description' => $cita['Estudio']['descripcion'],
				],
				'in-rare-habitat' => $cita['Cita']['indHabitatRaro'],
				'breeding-in-weird-habitat' => $cita['Cita']['indCriaHabitatRaro'],
				'injured' => $cita['Cita']['indHerido'],
				'rare-behaviour-or-morphology' => $cita['Cita']['indComportamiento'],
				'hasPhoto' => $cita['Cita']['indFoto'],
				'notes' => $cita['Cita']['observaciones'],
			];
			$observations[] = $observation;
		}

		$this->set(array(
			'observations' => $observations,
			'_serialize' => array('observations')
		));
	}

	public function view($id)
	{
//		$recipe = $this->Recipe->findById($id);
//		$this->set(array(
//			'recipe' => $recipe,
//			'_serialize' => array('recipe')
//		));
	}

	public function add()
	{
//		$this->Recipe->create();
//		if ($this->Recipe->save($this->request->data)) {
//			$message = 'Saved';
//		} else {
//			$message = 'Error';
//		}
//		$this->set(array(
//			'message' => $message,
//			'_serialize' => array('message')
//		));
	}

	public function edit($id)
	{
//		$this->Recipe->id = $id;
//		if ($this->Recipe->save($this->request->data)) {
//			$message = 'Saved';
//		} else {
//			$message = 'Error';
//		}
//		$this->set(array(
//			'message' => $message,
//			'_serialize' => array('message')
//		));
	}

	public function delete($id)
	{
//		if ($this->Recipe->delete($id)) {
//			$message = 'Deleted';
//		} else {
//			$message = 'Error';
//		}
//		$this->set(array(
//			'message' => $message,
//			'_serialize' => array('message')
//		));
	}
}
