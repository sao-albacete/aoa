<?php
App::uses('AppController', 'Controller');
App::uses('Constants', 'Utility');

/**
 * Maneja la información a mostrar el la página de inicio
 *
 * @author vcanizares
 */
class EspecieController extends AppController
{

	/**
	 * Nombre del controlador
	 */
	public $name = 'Especie';

	/**
	 * Constantes
	 */
	const ID_OPCION_MENU = Constants::MENU_ESPECIE_ID;

	/**
	 * Componentes
	 */
	public $components = array();

	/**
	 * Helpers
	 */
	public $helpers = array('Especie', 'ClaseEdadSexo', 'ObservadorSecundario', 'Js');

	/**
	 * Modelos
	 */
	public $uses = array(
		'Especie',
		'OrdenTaxonomico',
		'Cita',
		'CitaCount',
		'CitaMaxTipoCria',
		'CitaCountMes',
		'AsoCitaObservador',
		'AsoCitaClaseEdadSexo',
		'Municipio',
		'Lugar',
		'CuadriculaUtm',
		'Familia',
		'ProteccionLr',
		'ProteccionClm',
		'EstatusCuantitativoAb',
		'DistribucionAb',
	);


	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow(
			'lista_ab',
			'generar_grafico',
			'generar_mapa',
			'buscar_especies',
			'especies_objetivo'
		);
	}

	/**
	 * Función que se ejecuta al carga la página inicial
	 */
	public function index()
	{

		// Generamos la opciones de menu
		$opciones_menu_superior = $this->Menu->generarItemsMenu($this::ID_OPCION_MENU);
		$this->set('opciones_menu_superior', $opciones_menu_superior);
	}

	/**
	 * Función que se ejecuta al carga la página inicial
	 */
	public function view()
	{
		// Opcion seleccionada del menu
		$this->set('id_opcion_seleccionada', $this::ID_OPCION_MENU);

		// Recogemos los parámetros de la request
		$id_especie = $this->request->named['id'];

		/*
		 * Datos generales de la especie
		 */
		$especie = $this->Especie->read(null, $id_especie);

		// Si no existe, lanzamos una excepcion
		if (!isset($especie) || empty($especie)) {
			throw new NotFoundException(sprintf('No existe ninguna especie con id %s', $id_especie));
		}

		/*
		 * Orden taxonomico
		 */
		$orden_taxonomico = $this->OrdenTaxonomico->find(
			'first',
			array(
				'conditions' => array('OrdenTaxonomico.id' => $especie['Familia']['orden_taxonomico_id'])
			)
		);
		$especie['OrdenTaxonomico'] = $orden_taxonomico['OrdenTaxonomico'];

		/*
		 * Citas
		 */
		$citas = $this->Cita->obtenerCitas(
			array('Cita.especie_id' => $especie['Especie']['id'], 'Cita.indActivo' => 1),
			null,
			array('Cita.fechaAlta DESC')
		);
		$counter = 0;
		// Contendra todas las fotos asociadas a las citas de la especie
		$fotos = [];
		for ($index = 0; $index < count($citas); $index++) {

			/*
			 * Observadores
			 */
			$observadores = $this->AsoCitaObservador->obtenerObservadoresPorCita($citas[$index]['Cita']['id']);
			$citas[$index]['observadores'] = $observadores;

			/*
			 * Clases edad sexo
			 */
			$clases_edad_sexo = $this->AsoCitaClaseEdadSexo->obtenerClasesEdadSexoPorCita($citas[$index]['Cita']['id']);
			$citas[$index]['clases_edad_sexo'] = $clases_edad_sexo;

			/*
			 * Fotos
			 */
			if (count($citas[$index]['Fichero']) > 0) {
				$fotos[$counter] = $citas[$index];
				$counter++;
			}
		}
		$especie['Citas'] = $citas;
		$especie['Fotos'] = $fotos;

		$this->set('especie', $especie);

		/**
		 * Ubicaciones
		 */
		/*
		 * Municipios
		 */
		$municipios = $this->Municipio->obtenerMunicipiosActivosOrdenadosPorNombre();
		$this->set('municipios', $municipios);

		/*
		 * Lugares
		 */
		$lugares = $this->Lugar->obtenerLugaresActivosOrdenadosPorNombre();
		$this->set('lugares', $lugares);

		/*
		 * UTM
		 */
		$cuadriculas_utm = $this->CuadriculaUtm->obtenerCuadriculasUtmActivosOrdenadosPorCodigo();
		$this->set('cuadriculas_utm', $cuadriculas_utm);

		/**
		 * Total aves/periodo
		 */
		/*
		 * Años
		 */
		$anios = $this->Cita->obtenerAniosCitas();
		$this->set('anios', $anios);
	}

	/**
	 * Función que se ejecuta al carga la página inicial
	 */
	public function lista_ab()
	{
		// Opcion seleccionada del menu
		$this->set('id_opcion_seleccionada', $this::ID_OPCION_MENU);

		$especiesAb = $this->Especie->find(
			'all',
			[
				'conditions' => ['Especie.indCitadaAlbacete' => 1, 'Especie.codigoEuring IS NOT NULL'],
				'order' => ['Especie.codigoAerc ASC', 'Especie.codigoEuring ASC']
			]
		);
		foreach ($especiesAb as $key => $value) {
			$especiesAb[$key]['Citas'] = $this->Cita->obtenerNumeroCitas(['Cita.especie_id' => $especiesAb[$key]['Especie']['id']]);
		}
		$this->set('especies_ab', $especiesAb);

		$especiesAbCount = count($especiesAb);
		$this->set('especiesAbCount', $especiesAbCount);

		/*
		 * Info (Estatus nacional, nivel proteccion LR, nivel protección CLM, Estatus provincial Ab, Distribucion provincial Ab)
		 */
		$info = [];
		// Proteccion LR
		$info['ProteccionLr'] = $this->ProteccionLr->obtenerActivos();
		// Proteccion CLM
		$info['ProteccionClm'] = $this->ProteccionClm->obtenerActivos();
		// Estatus Cuantitativo AB
		$info['EstatusCuantitativoAb'] = $this->EstatusCuantitativoAb->obtenerActivos();
		// Distribucion AB
		$info['DistribucionAb'] = $this->DistribucionAb->obtenerActivos();
		$this->set('info', $info);
	}

	public function especies_objetivo()
	{
		// Opcion seleccionada del menu
		$this->set('id_opcion_seleccionada', $this::ID_OPCION_MENU);
	}

	/**
	 * Genera un gráfico de barras a partir de los datos recibidos del formulario de la sección de estadísticas
	 * @TODO move to EspecieAjaxController
	 */
	public function generar_grafico()
	{
		$this->layout = 'ajax';

		$citas_grafico = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		$title = "";

		$especie_id = $this->request->params['named']['especie_id'];

		$numeroDe = $this->request->data['numeroDe'];
		$zonaGeografica = $this->request->data['zonaGeografica'];
		$periodo = $this->request->data['periodo'];

		/*
		 * Numero de
		 */
		$selectField = "SUM(Cita.cantidad)";
		$titleY = "Número de aves";
		if ($numeroDe == "citas") {
			$selectField = "COUNT(Cita.id)";
			$titleY = "Número de citas";
		}

		/*
		 * Zona geográfica
		 */
		if (isset($this->request->data['municipios'])) {
			$municipio_id = $this->request->data['municipios'];

			// Obtenemos el nombre del municipio
			$this->Municipio->id = $municipio_id;
			$municipio_nombre = $this->Municipio->field("nombre");
		}
		if (isset($this->request->data['lugares'])) {
			$lugar_id = $this->request->data['lugares'];

			// Obtenemos el nombre del lugar
			$this->Lugar->id = $lugar_id;
			$lugar_nombre = $this->Lugar->field("nombre");
		}
		if (isset($this->request->data['cuadriculas_utm'])) {
			$cuadricula_utm_id = $this->request->data['cuadriculas_utm'];

			// Obtenemos el código de la cuadrícula UTM
			$this->CuadriculaUtm->id = $cuadricula_utm_id;
			$cuadricula_utm_codigo = $this->CuadriculaUtm->field("codigo");
		}

		/*
		 * Periodos
		 */
		if (isset($this->request->data['anio'])) {
			$anio = $this->request->data['anio'];
		}
		if (isset($this->request->data['anioDesde']) && isset($this->request->data['anioHasta'])) {
			$anio_desde = $this->request->data['anioDesde'];
			$anio_hasta = $this->request->data['anioHasta'];
		}
		if (isset($this->request->data['fechaDesde']) && isset($this->request->data['fechaHasta'])) {
			$fecha_desde = $this->request->data['fechaDesde'];
			$fecha_hasta = $this->request->data['fechaHasta'];
		}

		if ($zonaGeografica == 'provincia') {
			if ($periodo == "anio") {
				$title = "Nº de $numeroDe durante el año $anio en la provincia de Albacete";
				if ($numeroDe == "citas") {
					$citas_grafico = $this->CitaCountMes->obtenerCitasProvincialesPorAnio($especie_id, $anio);
				} else {
					$citas_grafico = $this->CitaCountMes->obtenerNumAvesProvincialesPorAnio($especie_id, $anio);
				}
			} else if ($periodo == "fechas") {
				$title = "Nº de $numeroDe desde el $fecha_desde hasta el $fecha_hasta \n en la provincia de Albacete";
				if ($numeroDe == "citas") {
					$citas_grafico = $this->CitaCountMes->obtenerCitasProvincialesPorIntervaloFechas($especie_id, $fecha_desde, $fecha_hasta);
				} else {
					$citas_grafico = $this->CitaCountMes->obtenerNumAvesProvincialesPorIntervaloFechas($especie_id, $fecha_desde, $fecha_hasta);
				}
			} else if ($periodo == "anios") {
				$title = "Nº de $numeroDe desde $anio_desde hasta $anio_hasta en la provincia de Albacete";
				if ($numeroDe == "citas") {
					$citas_grafico = $this->CitaCountMes->obtenerCitasProvincialesPorIntervaloAnios($especie_id, $anio_desde, $anio_hasta);
				} else {
					$citas_grafico = $this->CitaCountMes->obtenerNumAvesProvincialesPorIntervaloAnios($especie_id, $anio_desde, $anio_hasta);
				}
			}
		} else {
			if ($zonaGeografica == 'municipio') {
				if ($periodo == "anio") {
					$title = "Nº de $numeroDe durante el año $anio en el municipio de $municipio_nombre";
					if ($numeroDe == "citas") {
						$citas_grafico = $this->CitaCountMes->obtenerCitasPorMunicipioYAnio($especie_id, $municipio_id, $anio);
					} else {
						$citas_grafico = $this->CitaCountMes->obtenerNumAvesPorMunicipioYAnio($especie_id, $municipio_id, $anio);
					}
				} else if ($periodo == "fechas") {
					$title = "Nº de $numeroDe desde el $fecha_desde hasta el $fecha_hasta \n en el municipio de $municipio_nombre";
					if ($numeroDe == "citas") {
						$citas_grafico = $this->CitaCountMes->obtenerCitasPorMunicipioIntervaloFechas($especie_id, $municipio_id, $fecha_desde, $fecha_hasta);
					} else {
						$citas_grafico = $this->CitaCountMes->obtenerNumAvesPorMunicipioIntervaloFechas($especie_id, $municipio_id, $fecha_desde, $fecha_hasta);
					}
				} else if ($periodo == "anios") {
					$title = "Nº de $numeroDe desde $anio_desde hasta $anio_hasta en el municipio de $municipio_nombre";
					if ($numeroDe == "citas") {
						$citas_grafico = $this->CitaCountMes->obtenerCitasPorMunicipioIntervaloAnios($especie_id, $municipio_id, $anio_desde, $anio_hasta);
					} else {
						$citas_grafico = $this->CitaCountMes->obtenerNumAvesPorMunicipioIntervaloAnios($especie_id, $municipio_id, $anio_desde, $anio_hasta);
					}
				}
			} else if ($zonaGeografica == 'lugar') {
				if ($periodo == "anio") {
					$title = "Nº de $numeroDe durante el año $anio en $lugar_nombre";
					if ($numeroDe == "citas") {
						$citas_grafico = $this->CitaCountMes->obtenerCitasPorLugarYAnio($especie_id, $lugar_id, $anio);
					} else {
						$citas_grafico = $this->CitaCountMes->obtenerNumAvesPorLugarYAnio($especie_id, $lugar_id, $anio);
					}
				} else if ($periodo == "fechas") {
					$title = "Nº de $numeroDe desde el $fecha_desde hasta el $fecha_hasta \n en $lugar_nombre";
					if ($numeroDe == "citas") {
						$citas_grafico = $this->CitaCountMes->obtenerCitasPorLugarIntervaloFechas($especie_id, $lugar_id, $fecha_desde, $fecha_hasta);
					} else {
						$citas_grafico = $this->CitaCountMes->obtenerNumAvesPorLugarIntervaloFechas($especie_id, $lugar_id, $fecha_desde, $fecha_hasta);
					}
				} else if ($periodo == "anios") {
					$title = "Nº de $numeroDe desde $anio_desde hasta $anio_hasta en $lugar_nombre";
					if ($numeroDe == "citas") {
						$citas_grafico = $this->CitaCountMes->obtenerCitasPorLugarIntervaloAnios($especie_id, $lugar_id, $anio_desde, $anio_hasta);
					} else {
						$citas_grafico = $this->CitaCountMes->obtenerNumAvesPorLugarIntervaloAnios($especie_id, $lugar_id, $anio_desde, $anio_hasta);
					}
				}
			} else if ($zonaGeografica == 'cuadriculaUtm') {
				if ($periodo == "anio") {
					$title = "Nº de $numeroDe durante el año $anio en la cuadrícula UTM $cuadricula_utm_codigo";
					if ($numeroDe == "citas") {
						$citas_grafico = $this->CitaCountMes->obtenerCitasPorCuadriculaUtmYAnio($especie_id, $cuadricula_utm_id, $anio);
					} else {
						$citas_grafico = $this->CitaCountMes->obtenerNumAvesPorCuadriculaUtmYAnio($especie_id, $cuadricula_utm_id, $anio);
					}
				} else if ($periodo == "fechas") {
					$title = "Nº de $numeroDe desde el $fecha_desde hasta el $fecha_hasta \n en la cuadrícula UTM $cuadricula_utm_codigo";
					if ($numeroDe == "citas") {
						$citas_grafico = $this->CitaCountMes->obtenerCitasPorCuadriculaUtmIntervaloFechas($especie_id, $cuadricula_utm_id, $fecha_desde, $fecha_hasta);
					} else {
						$citas_grafico = $this->CitaCountMes->obtenerNumAvesPorCuadriculaUtmIntervaloFechas($especie_id, $cuadricula_utm_id, $fecha_desde, $fecha_hasta);
					}
				} else if ($periodo == "anios") {
					$title = "Nº de $numeroDe desde $anio_desde hasta $anio_hasta en la cuadrícula UTM $cuadricula_utm_codigo";
					if ($numeroDe == "citas") {
						$citas_grafico = $this->CitaCountMes->obtenerCitasPorCuadriculaUtmIntervaloAnios($especie_id, $cuadricula_utm_id, $anio_desde, $anio_hasta);
					} else {
						$citas_grafico = $this->CitaCountMes->obtenerNumAvesPorCuadriculaUtmIntervaloAnios($especie_id, $cuadricula_utm_id, $anio_desde, $anio_hasta);
					}
				}
			}
		}

		$this->set('titleX', $title);
		$this->set('titleY', $titleY);
		$this->set('ydata_ajax', $citas_grafico);
	}

	/**
	 * Genera un mapa de distribuciones a partir de los datos recibidos del formulario de la sección de estadísticas
	 * @TODO move to EspecieAjaxController
	 */
	public function generar_mapa()
	{
		$this->layout = 'ajax';

		$especie_id = $this->request->params['named']['especie_id'];

		$divisionGeografica = $this->request->data['divisionGeografica'];
		$tipoDistribucion = $this->request->data['tipoDistribucion'];

		$citas_mapa = array();
		$generarMapaResultados = array();
		$title = "";

		if ($this->request->is('ajax')) {

			$this->autoRender = false;

			if ($divisionGeografica == "porMunicipio") {

				if ($tipoDistribucion == "geografica") {

					$generarMapaResultados['title'] = "Distribución de citas por municipios";
					$citas_mapa = $this->CitaCount->obtenerTotalCitasPorMunicipio($especie_id);

					$generarMapaResultados['elementos'] = array();
					$index = 0;
					foreach ($citas_mapa as $municipioId => $cantidad) {
						$this->Municipio->id = $municipioId;
						$generarMapaResultados['elementos'][$index]['codigo'] = $this->Municipio->field('nombre');
						$index++;
					}

				} else if ($tipoDistribucion == "cuantitativa") {

					$generarMapaResultados['title'] = "Distribución de número de citas por municipios";
					$citas_mapa = $this->CitaCount->obtenerTotalCitasPorMunicipio($especie_id);

					$generarMapaResultados['elementos'] = array();
					$index = 0;
					foreach ($citas_mapa as $municipioId => $cantidad) {

						$this->Municipio->id = $municipioId;
						$generarMapaResultados['elementos'][$index]['codigo'] = $this->Municipio->field('nombre');
						$generarMapaResultados['elementos'][$index]['cantidad'] = $cantidad;
						$index++;
					}
				} else if ($tipoDistribucion == "categoriaReproduccion") {

					$generarMapaResultados['title'] = "Distribución de categorías de reproducción por municipios";
					$citas_mapa = $this->CitaMaxTipoCria->obtenerTipoCriaPorMunicipio($especie_id);

					CakeLog::debug('obtenerTipoCriaPorMunicipio -> ' . print_r($citas_mapa, true));

					$generarMapaResultados['elementos'] = array();
					$index = 0;
					foreach ($citas_mapa as $municipioId => $tipoCria) {

						$this->Municipio->id = $municipioId;
						$generarMapaResultados['elementos'][$index]['codigo'] = $this->Municipio->field('nombre');
						$generarMapaResultados['elementos'][$index]['tipoCria'] = $tipoCria;
						$index++;
					}
				}
			} else if ($divisionGeografica == "porUtm") {

				if ($tipoDistribucion == "geografica") {

					$generarMapaResultados['title'] = "Distribución de citas por cuadrículas UTM";
					$citas_mapa = $this->CitaCount->obtenerTotalCitasPorCuadriculaUtm($especie_id);

					$generarMapaResultados['elementos'] = array();
					$index = 0;
					foreach ($citas_mapa as $cuadriculaUtmId => $cantidad) {

						$this->CuadriculaUtm->id = $cuadriculaUtmId;
						$generarMapaResultados['elementos'][$index]['codigo'] = $this->CuadriculaUtm->field('codigo');
						$index++;
					}
				} else if ($tipoDistribucion == "cuantitativa") {

					$generarMapaResultados['title'] = "Distribución de número de citas por cuadrículas UTM";
					$citas_mapa = $this->CitaCount->obtenerTotalCitasPorCuadriculaUtm($especie_id);

					$generarMapaResultados['elementos'] = array();
					$index = 0;
					foreach ($citas_mapa as $cuadriculaUtmId => $cantidad) {

						$this->CuadriculaUtm->id = $cuadriculaUtmId;
						$generarMapaResultados['elementos'][$index]['codigo'] = $this->CuadriculaUtm->field('codigo');
						$generarMapaResultados['elementos'][$index]['cantidad'] = $cantidad;
						$index++;
					}
				} else if ($tipoDistribucion == "categoriaReproduccion") {

					$generarMapaResultados['title'] = "Distribución de categorías de reproducción por cuadrículas UTM";
					$citas_mapa = $this->CitaMaxTipoCria->obtenerTipoCriaPorCuadriculaUtm($especie_id);

					$generarMapaResultados['elementos'] = array();
					$index = 0;
					foreach ($citas_mapa as $cuadriculaUtmId => $tipoCria) {

						$this->CuadriculaUtm->id = $cuadriculaUtmId;
						$generarMapaResultados['elementos'][$index]['codigo'] = $this->CuadriculaUtm->field('codigo');
						$generarMapaResultados['elementos'][$index]['tipoCria'] = $tipoCria;
						$index++;
					}
				}
			}

			echo json_encode($generarMapaResultados);
		}
	}

	/**
	 * @TODO move to EspecieAjaxController
	 */
	public function sonRarezas()
	{
		if ($this->request->is('ajax')) {

			$esRareza = 0;

			$this->autoRender = false;

			$especies = $this->request->query["especies"];
			$especiesList = explode(",", $especies);

			foreach ($especiesList as $especieId) {

				$this->Especie->id = $especieId;
				$esRareza = $this->Especie->field('indRareza');

				if ($esRareza > 0) {
					break;
				}
			}

			echo $esRareza;
		}
	}

	/**
	 * Retorna si la especie es rareza local (2), nacional (1) o si no es rareza (0).
	 * @TODO move to EspecieAjaxController
	 * @TODO return status
	 */
	public function esRareza()
	{
		if ($this->request->is('ajax')) {

			$this->autoRender = false;

			$this->Especie->id = $this->request->query["especieId"];

			echo $this->Especie->field('indRareza');
		}
	}

	/**
	 * Busca especies por nombre común, género y especie
	 */
	public function buscar_especies()
	{
		$this->Especie->recursive = -1;

		$especiesEncontradas = array();

		if ($this->request->is('ajax')) {

			$this->autoRender = false;
			$results = $this->Especie->find(
				'all',
				array('fields' => array('Especie.id', 'Especie.nombreComun', 'Especie.genero', 'Especie.especie'),
					'conditions' => array('OR' => array('Especie.nombreComun LIKE ' => '%' . $this->request->query['term'] . '%', 'concat(Especie.genero, \' \', Especie.especie, \'\') LIKE ' => '%' . $this->request->query['term'] . '%'), 'Especie.subespecie' => null)
				));
			foreach ($results as $result) {
				$nombreComun = $result['Especie']['nombreComun'];
				array_push($especiesEncontradas, array("id" => $result['Especie']['id'], "value" => ucfirst($nombreComun) . ", " . $result['Especie']['genero'] . " " . $result['Especie']['especie']));
			}

			echo json_encode($especiesEncontradas);
		}
	}

	/**
	 * Busca subespecies por especie
	 */
	public function buscar_subespecies()
	{
		if ($this->request->is('ajax')) {

			$this->autoRender = false;

			$this->Especie->id = $this->request->query["especieId"];
			$genero = $this->Especie->field('genero');
			$especie = $this->Especie->field('especie');

			$results = $this->Especie->find(
				'all',
				array('fields' => array('Especie.subespecie'),
					'conditions' => array('Especie.genero' => $genero, 'Especie.especie' => $especie, array("NOT" => array('Especie.subespecie' => null)))
				));

			$subespeciesEncontradas = [];
			foreach ($results as $result) {
				$subespeciesEncontradas[] = $result['Especie']['subespecie'];
			}
			echo json_encode($subespeciesEncontradas);
		}
	}
}
