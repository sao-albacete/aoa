<?php
App::uses('AppController', 'Controller');
App::uses('CitaUtil', 'Utility');
App::uses('DateUtil', 'Utility');
App::uses('Constants', 'Utility');
App::uses('EmailUtil', 'Utility');
App::uses('MessageUtil', 'Utility');

/**
 * Maneja la información a mostrar el la página de inicio
 *
 * @author vcanizares
 */
class CitaController extends AppController
{

	/**
	 * Nombre del controlador
	 */
	public $name = 'Cita';

	/**
	 * Constantes
	 */
	const ID_OPCION_MENU = Constants::MENU_CITAS_ID;

	/**
	 * Componentes
	 */
	public $components = [
		'RequestHandler',
	];

	/**
	 * Helpers
	 */
	public $helpers = [
		'ObservadorSecundario',
		'Especie',
		'ClaseEdadSexo',
		'Importancia',
		'Js',
		'HtmlPurify',
	];

	/**
	 * Modelos
	 */
	public $uses = [
		'Cita',
		'AsoCitaObservador',
		'Especie',
		'OrdenTaxonomico',
		'Lugar',
		'ClaseEdadSexo',
		'ClaseReproduccion',
		'ObservadorPrincipal',
		'ObservadorSecundario',
		'Fuente',
		'Familia',
		'Municipio',
		'Comarca',
		'CuadriculaUtm',
		'ProteccionClm',
		'ProteccionLr',
		'EstatusCuantitativoAb',
		'AsoCitaClaseEdadSexo',
		'CitaHistorico',
		'Fichero',
		'AsoEspeciePrivacidad',
		'Estudio'
	];

	public function beforeFilter()
	{
		parent::beforeFilter();

		$this->Auth->allow(
			'lista_ab',
			'generar_grafico',
			'generar_mapa',
			'cargar_niveles_proteccion',
			'buscar_observadores',
			'buscar_especies',
			'obtenerCitasDatatables'
		);
	}

	/**
	 * Función que se ejecuta al carga la página inicial
	 */
	public function index()
	{
		// Opcion seleccionada del menu
		$this->set('id_opcion_seleccionada', $this::ID_OPCION_MENU);

		$valuesSubmited = [];
		$filtraCitasPrivadas = false;

		/*
		 * Usuario
		*/
		$usuario = $this->Auth->user();
		$this->set('usuario', $usuario);
		/*
		 * Orden taxonómico
		 */
		$ordenesTaxonomicos = $this->OrdenTaxonomico->getAllOrdenesTaxonomicosBasic();
		$this->set('ordenesTaxonomicos', $ordenesTaxonomicos);

		/*
		 * Clase reproduccion
		 */
		$clasesReproduccion = $this->ClaseReproduccion->getAllClasesReproduccionBasic();
		$this->set('clasesReproduccion', $clasesReproduccion);

		/*
		 * Familia
		 */
		$familias = $this->Familia->getAllFamiliasBasic();
		$this->set('familias', $familias);

		/*
		 * Comarca
		 */
		$comarcas = $this->Comarca->getAllComarcasBasic();
		$this->set('comarcas', $comarcas);

		/*
		 * Municipios
		 */
		$municipios = $this->Municipio->obtenerMunicipiosActivosOrdenadosPorNombre();
		$this->set('municipios', $municipios);

		/*
		 * Cuadricula UTM
		 */
		$cuadriculasUtm = $this->CuadriculaUtm->obtenerCuadriculasUtmActivosOrdenadosPorCodigo();
		$this->set('cuadriculasUtm', $cuadriculasUtm);

		/*
		 * Años
		 */
		$anios = $this->Cita->obtenerAniosCitas();
		$this->set('anios', $anios);

		/* Estudios */
		$estudios = $this->Estudio->obtenerEstudios(null, null, array(
			'Estudio.descripcion'
		));
		$this->set('estudios', $estudios);


		$conditions = [
			'Cita.indActivo' => 1
		];
		$joins = [];

		if ($this->request->is('get')) {

			// Especie
			if (isset($this->request->query["especieId"]) && !empty($this->request->query["especieId"])) {
				$conditions["Cita.especie_id"] = $this->request->query["especieId"];
				$valuesSubmited["especieId"] = $this->request->query["especieId"];

				if (isset($this->request->query["especie"]) && !empty($this->request->query["especie"])) {
					$valuesSubmited["especie"] = $this->request->query["especie"];
				} else {
					$this->Especie->id = $this->request->query["especieId"];
					$valuesSubmited["especie"] = $this->Especie->field('nombreComun') . ", " . $this->Especie->field('genero') . " " . $this->Especie->field('especie');
				}
			}

			// Familia
			if (isset($this->request->query["familia"]) && !empty($this->request->query["familia"])) {
				$conditions["Especie.familia_id"] = $this->request->query["familia"];
				$valuesSubmited["familia"] = $this->request->query["familia"];

				if (isset($this->request->query["ordenTaxonomico"]) && !empty($this->request->query["ordenTaxonomico"])) {
					$valuesSubmited["ordenTaxonomico"] = $this->request->query["ordenTaxonomico"];
				}
				// Orden taxonomico
			} elseif (isset($this->request->query["ordenTaxonomico"]) && !empty($this->request->query["ordenTaxonomico"])) {
				$familias = $this->Familia->find('list', array(
					'fields' => array(
						'Familia.id'
					),
					'conditions' => array(
						'Familia.indActivo' => 1,
						'Familia.orden_taxonomico_id' => $this->request->query["ordenTaxonomico"]
					),
					'recursive' => -1
				));
				$conditions["Especie.familia_id"] = $familias;
				$valuesSubmited["ordenTaxonomico"] = $this->request->query["ordenTaxonomico"];
			}

			// Figura de proteccion
			if (isset($this->request->query["figuraProteccion"]) && !empty($this->request->query["figuraProteccion"]) && isset($this->request->query["nivelProteccion"]) && !empty($this->request->query["nivelProteccion"])) {

				$valuesSubmited["nivelProteccion"] = $this->request->query["nivelProteccion"];
				$figuraProteccion = $this->request->query["figuraProteccion"];
				$valuesSubmited["figuraProteccion"] = $figuraProteccion;

				if ($figuraProteccion == "catalogoRegional") {
					$conditions["Especie.proteccion_clm_id"] = $this->request->query["nivelProteccion"];
				} elseif ($figuraProteccion == "libroRojo") {
					$conditions["Especie.proteccion_lr_id"] = $this->request->query["nivelProteccion"];
				} elseif ($figuraProteccion == "estatusAlbacete") {
					$conditions["Especie.estatus_cuantitativo_ab_id"] = $this->request->query["nivelProteccion"];
				}
			}

			// Estudio
			if (isset($this->request->query["estudioId"]) && !empty($this->request->query["estudioId"])) {
				$conditions["Cita.estudio_id"] = $this->request->query["estudioId"];
				$valuesSubmited["estudioId"] = $this->request->query["estudioId"];
			}

			// Comarca
			if (isset($this->request->query["comarcaId"]) && !empty($this->request->query["comarcaId"])) {
				$conditions["Lugar.comarca_id"] = $this->request->query["comarcaId"];
				$valuesSubmited["comarcaId"] = $this->request->query["comarcaId"];
			}

			// Municipio
			if (isset($this->request->query["municipioId"]) && !empty($this->request->query["municipioId"])) {
				$conditions["Lugar.municipio_id"] = $this->request->query["municipioId"];
				$valuesSubmited["municipioId"] = $this->request->query["municipioId"];
			}

			// Cuadricula UTM
			if (isset($this->request->query["cuadriculaUtmId"]) && !empty($this->request->query["cuadriculaUtmId"])) {
				$conditions["Lugar.cuadricula_utm_id"] = $this->request->query["cuadriculaUtmId"];
				$valuesSubmited["cuadriculaUtmId"] = $this->request->query["cuadriculaUtmId"];
			}

			// Lugar
			if (isset($this->request->query["lugarId"]) && !empty($this->request->query["lugarId"])) {
				$conditions["Cita.lugar_id"] = $this->request->query["lugarId"];
				$valuesSubmited["lugarId"] = $this->request->query["lugarId"];
//				$valuesSubmited["lugar"] = $this->request->query["lugar"];

				// Filtramos las citas privadas salvo las que pertenezcan al usuario
				if (!isset($usuario)) {
					$filtraCitasPrivadas = true;
					$conditions["Cita.indPrivacidad"] = 1;
				} elseif ($usuario['perfil_id'] > 1) {
					$filtraCitasPrivadas = true;
					$conditions['OR'] = [
						'Cita.indPrivacidad' => 1,
						'AND' => [
							"Cita.indPrivacidad" => 0,
							"Cita.observador_principal_id" => $usuario['observador_principal_id']
						]
					];
				}
			}

			// Fecha alta
			if (isset($this->request->query["fechaDesde"]) && !empty($this->request->query["fechaDesde"])) {
				$fecha_desde = $this->request->query["fechaDesde"];
				$valuesSubmited["fechaDesde"] = $fecha_desde;
				$conditions[] = "Cita.fechaAlta >= STR_TO_DATE('$fecha_desde','%d/%m/%Y')";
			}
			if (isset($this->request->query["fechaHasta"]) && !empty($this->request->query["fechaHasta"])) {
				$fecha_hasta = $this->request->query["fechaHasta"];
				$valuesSubmited["fechaHasta"] = $fecha_hasta;
				$conditions[] = "Cita.fechaAlta <= STR_TO_DATE('$fecha_hasta','%d/%m/%Y')";
			}
			if (isset($this->request->query["fechaAlta"]) && !empty($this->request->query["fechaAlta"]) && !(isset($valuesSubmited["fechaHasta"]) && !empty($valuesSubmited["fechaHasta"]))) {
				$fecha_alta = $this->request->query["fechaAlta"];
				$conditions[] = "Cita.fechaAlta = STR_TO_DATE('$fecha_alta','%d/%m/%Y')";
				$valuesSubmited["fechaDesde"] = $this->request->query["fechaAlta"];
				$valuesSubmited["fechaHasta"] = $this->request->query["fechaAlta"];
			}

			// Clase reproduccion
			if (isset($this->request->query["claseReproduccionId"]) && !empty($this->request->query["claseReproduccionId"])) {
				$conditions["Cita.clase_reproduccion_id"] = $this->request->query["claseReproduccionId"];
				$valuesSubmited["claseReproduccionId"] = $this->request->query["claseReproduccionId"];
			}

			// Observador
			if (isset($this->request->query["observadorId"]) && !empty($this->request->query["observadorId"])) {
				$conditions["Cita.observador_principal_id"] = $this->request->query["observadorId"];
				$valuesSubmited["observadorId"] = $this->request->query["observadorId"];
				$valuesSubmited["observador"] = $this->request->query["observador"];
			}

			// Colaborador
			if (isset($this->request->query["colaboradorId"]) && !empty($this->request->query["colaboradorId"])) {
				$conditions["AsoCitaObservador.observador_secundario_id"] = $this->request->query["colaboradorId"];
				$joins[] = array(
					'table' => 'aso_cita_observador',
					'alias' => 'AsoCitaObservador',
					'type' => 'LEFT',
					'conditions' => array(
						'Cita.id = AsoCitaObservador.cita_id'
					)
				);
				$valuesSubmited["colaboradorId"] = $this->request->query["colaboradorId"];
				$valuesSubmited["colaborador"] = $this->request->query["colaborador"];
			}

			// Indicadores
			if (isset($this->request->query["indHabitatRaro"]) && !empty($this->request->query["indHabitatRaro"])) {
				$conditions["Cita.indHabitatRaro"] = $this->request->query["indHabitatRaro"];
				$valuesSubmited["indHabitatRaro"] = $this->request->query["indHabitatRaro"];
			}
			if (isset($this->request->query["indCriaHabitatRaro"]) && !empty($this->request->query["indCriaHabitatRaro"])) {
				$conditions["Cita.indCriaHabitatRaro"] = $this->request->query["indCriaHabitatRaro"];
				$valuesSubmited["indCriaHabitatRaro"] = $this->request->query["indCriaHabitatRaro"];
			}
			if (isset($this->request->query["dormidero"]) && !empty($this->request->query["dormidero"])) {
				$conditions["Cita.dormidero"] = $this->request->query["dormidero"];
				$valuesSubmited["dormidero"] = $this->request->query["dormidero"];
			}
			if (isset($this->request->query["colonia_de_cria"]) && !empty($this->request->query["colonia_de_cria"])) {
				$conditions["Cita.colonia_de_cria"] = $this->request->query["colonia_de_cria"];
				$valuesSubmited["colonia_de_cria"] = $this->request->query["colonia_de_cria"];
			}
			if (isset($this->request->query["migracion_activa"]) && !empty($this->request->query["migracion_activa"])) {
				$conditions["Cita.migracion_activa"] = $this->request->query["migracion_activa"];
				$valuesSubmited["migracion_activa"] = $this->request->query["migracion_activa"];
			}
			if (isset($this->request->query["sedimentado"]) && !empty($this->request->query["sedimentado"])) {
				$conditions["Cita.sedimentado"] = $this->request->query["sedimentado"];
				$valuesSubmited["sedimentado"] = $this->request->query["sedimentado"];
			}
			if (isset($this->request->query["indHerido"]) && !empty($this->request->query["indHerido"])) {
				$conditions["Cita.indHerido"] = $this->request->query["indHerido"];
				$valuesSubmited["indHerido"] = $this->request->query["indHerido"];
			}
			if (isset($this->request->query["indComportamiento"]) && !empty($this->request->query["indComportamiento"])) {
				$conditions["Cita.indComportamiento"] = $this->request->query["indComportamiento"];
				$valuesSubmited["indComportamiento"] = $this->request->query["indComportamiento"];
			}
			if (isset($this->request->query["electrocutado"]) && !empty($this->request->query["electrocutado"])) {
				$conditions["Cita.electrocutado"] = $this->request->query["electrocutado"];
				$valuesSubmited["electrocutado"] = $this->request->query["electrocutado"];
			}
			if (isset($this->request->query["atropellado"]) && !empty($this->request->query["atropellado"])) {
				$conditions["Cita.atropellado"] = $this->request->query["atropellado"];
				$valuesSubmited["atropellado"] = $this->request->query["atropellado"];
			}
		}

		if (count($conditions) > 0) {

			$params = [];
			$params['joins'] = $joins;
			$params['conditions'] = $conditions;
			$params['order'] = [
				'Cita.fechaAlta' => 'desc',
			];
			$params['limit'] = 25;

			// Mostramos aviso si se han filtrado las citas privadas pero existe alguna
			if ($filtraCitasPrivadas) {

				if (!isset($usuario)) {
					$conditions["Cita.indPrivacidad"] = 0;
				} elseif ($usuario['perfil_id'] > 1) {

					unset($conditions['OR']);

					$conditions['AND'] = [
						"Cita.indPrivacidad = 0",
						"Cita.observador_principal_id <>" . $usuario['observador_principal_id']
					];
				}

				$options = [
					'joins' => $joins,
					'conditions' => $conditions,
					'fields' => 'Cita.id'
				];

				$citasPrivadas = $this->Cita->find('count', $options);

				if ($citasPrivadas > 0) {
					$this->Session->setFlash('Por razones de seguridad, no se han mostrado algunas citas sensibles. No obstante, puede solicitar más datos enviándonos un email a anuario@sao.albacete.org', 'warning');
				}
			}

			if ($this->request->query('exportarAExcel')) {

				$limit = $this->Cita->find('count', $params);
				if ($limit > 1000) {
					$this->Session->setFlash('El número de citas a exportar no puede ser superior a 1.000 registros. Por favor, utilice filtros para acotar más la búsqueda.', 'warning');
				} else {
					$params['limit'] = $limit;
					$citas = $this->Cita->find('all', $params);

					$this->ObservadorSecundario = $this->Components->load('ObservadorSecundario');
					$this->PhpExcel = $this->Components->load('PhpExcel');
					$this->PhpExcel->createWorksheet()->setDefaultFont('Calibri', 12);

					// define table cells
					$table = [
						['label' => __('Importancia (codigo)')],
						['label' => __('Importancia (descripción)')],
						['label' => __('Especie (nombre común)')],
						['label' => __('Especie (nombre científico)')],
						['label' => __('Fecha y hora')],
						['label' => __('Lugar')],
						['label' => __('Municipio')],
						['label' => __('Comarca')],
						['label' => __('Cuadrícula UTM')],
						['label' => __('Número de Aves')],
						['label' => __('Observador (código)')],
						['label' => __('Observador (nombre)')],
						['label' => __('Colaboradores (códigos)')],
						['label' => __('Colaboradores (nombres)')],
						['label' => __('Clase de Reproducción (codigo)')],
						['label' => __('Clase de Reproducción (descripción)')],
						['label' => __('Criterio de Selección (código)')],
						['label' => __('Criterio de Selección (descripción)')],
						['label' => __('Especie vista en habitat atípico')],
						['label' => __('Reproducción en un hábitat atípico')],
						['label' => __('En dormidero')],
						['label' => __('Colonia de cría')],
						['label' => __('Migración activa')],
						['label' => __('Sedimentado')],
						['label' => __('Cita de individuo herido, accidentado o muerto')],
						['label' => __('Comportamiento o morfología curiosa')],
						['label' => __('Electrocutado')],
						['label' => __('Atropellado')],
						['label' => __('Observaciones')],
					];

					// add heading with different font and bold text
					$this->PhpExcel->addTableHeader($table, ['name' => 'Cambria', 'bold' => true]);

					// add data
					$row = 2;
					foreach ($citas as $cita) {

						/*
						 * Observadores
						 */
						$observadores = $this->AsoCitaObservador->obtenerObservadoresPorCita($cita['Cita']['id']);
						$cita['observadoresSecundarios'] = $observadores;

						/*
						 * Clases edad sexo
						 */
						$cita['clases_edad_sexo'] = $this->AsoCitaClaseEdadSexo->obtenerClasesEdadSexoPorCita($cita['Cita']['id']);

						/*
						 * Lugar
						 */
						$lugar = $this->Lugar->obtenerTodoPorId($cita['Lugar']['id']);
						$cita['Comarca'] = $lugar['Comarca'];
						$cita['Municipio'] = $lugar['Municipio'];
						$cita['CuadriculaUtm'] = $lugar['CuadriculaUtm'];

						// Si la cita NO es confidencial o es confidencial y es una cita del usuario o el usuario es administrador, mostramos el texto del lugar
						if ($cita['Cita']['indPrivacidad'] == 1 ||
							($cita['Cita']['indPrivacidad'] == 0 && (isset($usuario) && ($usuario['observador_principal_id'] == $cita['Cita']['observador_principal_id'] || $usuario['perfil_id'] == 1)))) {
							$lugar = $cita['Lugar']['nombre'];
							$observaciones = $cita['Cita']['observaciones'];
						} else {
							$lugar = __('Lugar confidencial');
							$observaciones = __('Lugar confidencial');
						}

						$minutos = date_format(date_create($cita['Cita']['fechaAlta']), "i");
						$hora = date_format(date_create($cita['Cita']['fechaAlta']), "H");
						$dia = date_format(date_create($cita['Cita']['fechaAlta']), "d");
						$mes = date_format(date_create($cita['Cita']['fechaAlta']), "m");
						$anyo = date_format(date_create($cita['Cita']['fechaAlta']), "Y");
						$fechaYHora = PHPExcel_Shared_Date::FormattedPHPToExcel($anyo, $mes, $dia, $hora, $minutos);

						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $cita['ImportanciaCita']['codigo']);
						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $cita['ImportanciaCita']['descripcion']);
						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $cita['Especie']['nombreComun']);
						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $cita['Especie']['genero'] . ' ' . $cita['Especie']['especie'] . ' ' . $cita['Especie']['subespecie']);

						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $fechaYHora);
						// Más formatos aquí \PHPExcel_Style_NumberFormat
						$this->PhpExcel->getActiveSheet()
							->getStyleByColumnAndRow(4, $row)
							->getNumberFormat()->setFormatCode('dd/mm/yyyy hh:mm');

						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $lugar);
						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $cita['Municipio']['nombre']);
						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $cita['Comarca']['nombre']);
						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $cita['CuadriculaUtm']['codigo']);
						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $cita['Cita']['cantidad']);
						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $cita['ObservadorPrincipal']['codigo']);
						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $cita['ObservadorPrincipal']['nombre']);
						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $this->ObservadorSecundario->mostrarCodigosObservadores($cita['observadoresSecundarios']));
						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $this->ObservadorSecundario->mostrarNombresObservadores($cita['observadoresSecundarios']));
						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, $cita['ClaseReproduccion']['codigo']);
						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, $cita['ClaseReproduccion']['descripcion']);
						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $cita['CriterioSeleccionCita']['codigo']);
						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $cita['CriterioSeleccionCita']['nombre']);

						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, $cita['Cita']['indHabitatRaro'] == "1" ? "Sí" : "");
						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, $cita['Cita']['indCriaHabitatRaro'] == "1" ? "Sí" : "");
						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $row, $cita['Cita']['dormidero'] == "1" ? "Sí" : "");
						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $row, $cita['Cita']['colonia_de_cria'] == "1" ? "Sí" : "");
						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $row, $cita['Cita']['migracion_activa'] == "1" ? "Sí" : "");
						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(23, $row, $cita['Cita']['sedimentado'] == "1" ? "Sí" : "");
						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(24, $row, $cita['Cita']['indHerido'] == "1" ? "Sí" : "");
						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(25, $row, $cita['Cita']['indComportamiento'] == "1" ? "Sí" : "");
						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(26, $row, $cita['Cita']['electrocutado'] == "1" ? "Sí" : "");
						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(27, $row, $cita['Cita']['atropellado'] == "1" ? "Sí" : "");

						$this->PhpExcel->getActiveSheet()->setCellValueByColumnAndRow(28, $row, strip_tags($observaciones));

						$row++;
					}

					// close table and output
					$this->PhpExcel->addTableFooter()->output('citas.xlsx', 'Excel2007');
				}
			}
			$this->paginate['Cita'] = $params;
			$citas = $this->paginate();

			for ($index = 0; $index < count($citas); $index++) {

				/*
				 * Observadores
				 */
				$observadores = $this->AsoCitaObservador->obtenerObservadoresPorCita($citas[$index]['Cita']['id']);
				$citas[$index]['observadoresSecundarios'] = $observadores;

				/*
				 * Clases edad sexo
				 */
				$citas[$index]['clases_edad_sexo'] = $this->AsoCitaClaseEdadSexo->obtenerClasesEdadSexoPorCita($citas[$index]['Cita']['id']);

				/*
				 * Lugar
				*/
				$lugar = $this->Lugar->obtenerTodoPorId($citas[$index]['Lugar']['id']);
				$citas[$index]['Comarca'] = $lugar['Comarca'];
				$citas[$index]['Municipio'] = $lugar['Municipio'];
				$citas[$index]['CuadriculaUtm'] = $lugar['CuadriculaUtm'];
			}

			$this->set('citas', $citas);

			$this->set('valuesSubmited', $valuesSubmited);
		}
	}

	/**
	 * Guarda los cambios realizados en una cita
	 */
	public function edit()
	{
		// Marca la opcion seleccionada del menu
		$this->set('id_opcion_seleccionada', $this::ID_OPCION_MENU);

		// Recogemos los parámetros de la request
		$citaId = $this->request->named['id'];

		// Usuario
		$current_user = $this->Auth->user();

		// Datos del detalle de la cita
		$cita = $this->obtenerDetalleCita($citaId);

		//Comprobamos si el usuario que ejecuta la acción tiene permisos para editar la cita
		if (!$this->esCitaEditable($cita, $current_user)) {
			throw new ForbiddenException(sprintf('El usuario con email %s no tiene permisos editar la cita con id %s', $current_user['email'], $citaId));
		}

		// Pasamos los datos de la cita y el usuario registrado a la vista
		$this->set('cita', $cita);
		$this->set('usuario', $current_user);

		// Carga los datos de los combos a mostrar en la vista
		$this->cargarCombosCita();

		// Clase edad sexo
		$clasesEdadSexo = $this->ClaseEdadSexo->obtenerActivos();
		$cantidades = [];
		for ($i = 0; $i < count($clasesEdadSexo); $i++) {
			$cantidades[$clasesEdadSexo[$i]['ClaseEdadSexo']['codigo']]
				= $this->AsoCitaClaseEdadSexo->obtenerCantidadPorClaseEdadSexoYCita(
				$citaId,
				$clasesEdadSexo[$i]['ClaseEdadSexo']['id']
			);
		}
		$this->set('cantidades', $cantidades);

		if ($this->request->is('post')) {

			if (empty($_POST)) {
				$this->Session->setFlash(__('Alguno de los datos de la cita no son correctos, por favor corríjalos y vuelva a intentarlo'), 'failure');
				return;
			}

			try {

				// Comanzamos la transaccion
				$dataSource = $this->Cita->getDataSource();
				$dataSource->begin();

				$errorsMessagesList = [];
				$warningMessagesList = [];

				// Obtenemos la cita de BD y la rellenamos a partir de los datos editables
				// TODO validar y sanear
				$cita = $this->Cita->obtenerTodoPorId($citaId);
				$cita["Cita"]["lugar_id"] = $this->request->data["Cita"]["lugar_id"];
				$cita["Cita"]["observador_principal_id"] = $this->request->data["Cita"]["observador_principal_id"];
				$cita["Cita"]["fuente_id"] = $this->request->data["Cita"]["fuente_id"];
				$cita["Cita"]["estudio_id"] = $this->request->data["Cita"]["estudio_id"];
				$cita["Cita"]["observaciones"] = $this->request->data["Cita"]["observaciones"];
				$cita["Cita"]["cantidad"] = $this->request->data["Cita"]["cantidad"];
				$cita["Cita"]["clase_reproduccion_id"] = $this->request->data["Cita"]["clase_reproduccion_id"];

				// Fecha de alta
				$fechaAlta = $this->request->data["Cita"]["fechaAlta"];
				$fechaAltaFormateada = DateUtil::europeanFormatToAmericanFormat($fechaAlta);
				if ($fechaAltaFormateada == false) {
					$this->Session->setFlash('El formato de la fecha de observación no es correcto, debe indicar una fecha con formato dd/mm/aaaa', 'failure');
					return;
				}
				// Hora de alta
				$horaAlta = $this->request->data["Cita"]["horaAlta"];
				if ($horaAlta) {
					$horaAltaFormateada = DateUtil::formatTime($horaAlta);
					if ($horaAltaFormateada == false) {
						$this->Session->setFlash('El formato de la hora de observación no es correcto, debe indicar una hora con formato hh:mm', 'failure');
						return;
					}
					$cita["Cita"]["fechaAlta"] = $fechaAltaFormateada . " " . $horaAltaFormateada;
				} else {
					$cita["Cita"]["fechaAlta"] = $fechaAltaFormateada . " 00:00";
				}

				// Especie
				$especieId = $this->request->data["Cita"]["especie_id"];
				$cita["Cita"]["especie_id"] = $especieId;
				$especie = $this->Especie->obtenerTodoPorId($especieId, array(
					'Especie.estatus_reproductivo_ab_id',
					'Especie.clasificacion_criterio_esp_id',
					'Especie.indRareza',
					'Especie.genero',
					'Especie.especie'
				));
				// Subespecie
				if (isset($this->request->data['subespecie'])) {
					$subespecie = $this->Especie->obtenerEspecie(['Especie.genero' => $especie['Especie']['genero'], 'Especie.especie' => $especie['Especie']['especie'], 'Especie.subespecie' => $this->request->data['subespecie']]);
					if (!empty($subespecie)) {
						$especie = $subespecie;
						$this->request->data["Cita"]["especie_id"] = $especie['Especie']['id'];
						$especieId = $this->request->data["Cita"]["especie_id"];
						$cita["Cita"]["especie_id"] = $especieId;
					}
				}

				// Importancia
				$cita["Cita"]["importancia_cita_id"] = CitaUtil::calcularImportanciaCita($especie['Especie']['indRareza'], $especie['Especie']['clasificacion_criterio_esp_id'], $cita["Cita"]["clase_reproduccion_id"]);

				// Criterio seleccion
				$numeroCitasPorLugar = $this->Cita->obtenerTotalCitasPorLugar($cita["Cita"]["lugar_id"]);
				$cita["Cita"]["criterio_seleccion_cita_id"] = CitaUtil::calcularCriterioSeleccion($cita["Cita"], $especie, $numeroCitasPorLugar);
				if ($cita["Cita"]["criterio_seleccion_cita_id"] != 21) {
					$cita["Cita"]["indSeleccionada"] = 1;
				}

				// Indicadores
				{
					if (isset($this->request->data["Cita"]["indHabitatRaro"])) {
						$cita["Cita"]["indHabitatRaro"] = $this->request->data["Cita"]["indHabitatRaro"];
					} else {
						$cita["Cita"]["indHabitatRaro"] = false;
					}
					if (isset($this->request->data["Cita"]["indCriaHabitatRaro"])) {
						$cita["Cita"]["indCriaHabitatRaro"] = $this->request->data["Cita"]["indCriaHabitatRaro"];
					} else {
						$cita["Cita"]["indCriaHabitatRaro"] = false;
					}
					if (isset($this->request->data["Cita"]["indHerido"])) {
						$cita["Cita"]["indHerido"] = $this->request->data["Cita"]["indHerido"];
					} else {
						$cita["Cita"]["indHerido"] = false;
					}
					if (isset($this->request->data["Cita"]["indComportamiento"])) {
						$cita["Cita"]["indComportamiento"] = $this->request->data["Cita"]["indComportamiento"];
					} else {
						$cita["Cita"]["indComportamiento"] = false;
					}
					if (isset($this->request->data["Cita"]["dormidero"])) {
						$cita["Cita"]["dormidero"] = $this->request->data["Cita"]["dormidero"];
					} else {
						$cita["Cita"]["dormidero"] = false;
					}
					if (isset($this->request->data["Cita"]["colonia_de_cria"])) {
						$cita["Cita"]["colonia_de_cria"] = $this->request->data["Cita"]["colonia_de_cria"];
					} else {
						$cita["Cita"]["colonia_de_cria"] = false;
					}
					if (isset($this->request->data["Cita"]["migracion_activa"])) {
						$cita["Cita"]["migracion_activa"] = $this->request->data["Cita"]["migracion_activa"];
					} else {
						$cita["Cita"]["migracion_activa"] = false;
					}
					if (isset($this->request->data["Cita"]["sedimentado"])) {
						$cita["Cita"]["sedimentado"] = $this->request->data["Cita"]["sedimentado"];
					} else {
						$cita["Cita"]["sedimentado"] = false;
					}
					if (isset($this->request->data["Cita"]["electrocutado"])) {
						$cita["Cita"]["electrocutado"] = $this->request->data["Cita"]["electrocutado"];
					} else {
						$cita["Cita"]["electrocutado"] = false;
					}
					if (isset($this->request->data["Cita"]["atropellado"])) {
						$cita["Cita"]["atropellado"] = $this->request->data["Cita"]["atropellado"];
					} else {
						$cita["Cita"]["atropellado"] = false;
					}
				}

				/*
				 * Precisión
				 */
				$precision = $this->request->data["Cita"]["precision"];
				if ($precision == "cantidad_exacta") {
					$cita["Cita"]["cantidad_exacta"] = true;
					$cita["Cita"]["cantidad_aproximada"] = false;
					$cita["Cita"]["cantidad_precisa"] = false;
					$cita["Cita"]["cantidad_estimada"] = false;
				}
				else if ($precision == "cantidad_aproximada") {
					$cita["Cita"]["cantidad_exacta"] = false;
					$cita["Cita"]["cantidad_aproximada"] = true;
					$cita["Cita"]["cantidad_precisa"] = false;
					$cita["Cita"]["cantidad_estimada"] = false;
				}
				else if ($precision == "cantidad_precisa") {
					$cita["Cita"]["cantidad_exacta"] = false;
					$cita["Cita"]["cantidad_aproximada"] = false;
					$cita["Cita"]["cantidad_precisa"] = true;
					$cita["Cita"]["cantidad_estimada"] = false;
				}
				else if ($precision == "cantidad_estimada") {
					$cita["Cita"]["cantidad_exacta"] = false;
					$cita["Cita"]["cantidad_aproximada"] = false;
					$cita["Cita"]["cantidad_precisa"] = false;
					$cita["Cita"]["cantidad_estimada"] = true;
				}

				// Indicador de Rareza
				if ($especie['Especie']['indRareza'] == 1) {
					$this->request->data["Cita"]["indRarezaHomologada"] = 2;
				}

				// Inicializamos la cita y la rellenamos antes de validar
				$this->Cita->create();
				$this->Cita->set($cita);

				if ($this->Cita->validates()) {

					// Guardamos la cita
					if ($this->Cita->save()) {

						// Cita historico
						$errorsMessagesHist = $citaHistorico = $this->CitaHistorico->guardarHistorico($this->Cita->obtenerDatosBasicosPorId($this->Cita->id), $current_user['id']);
						if (!empty($errorsMessagesHist)) {
							array_push($errorsMessagesList, $errorsMessagesHist);
						}

						// Cita-observador_secundario
						{
							// Borramos las relaciones existentes
							$this->AsoCitaObservador->deleteAll(['AsoCitaObservador.cita_id' => $citaId], false);

							// Insertamos los observadores recibidos
							if (!empty($this->request->data["colaboradoresSeleccionados"])) {

								$observadores = explode(",", $this->request->data["colaboradoresSeleccionados"]);
								foreach ($observadores as $observador) {

									$errorsMessagesObs = $this->AsoCitaObservador->crearAsoCitaObservador($observador, $this->Cita->id);
									if (!empty($errorsMessagesObs)) {
										array_push($errorsMessagesList, $errorsMessagesObs);
									}
								}
							}
						}

						// Cita-clase_edad_sexo
						{
							// Eliminamos todas las existentes
							$this->AsoCitaClaseEdadSexo->deleteAll(['AsoCitaClaseEdadSexo.cita_id' => $citaId], false);

							// Insertamos las nuevas
							foreach ($this->request->data["claseEdadSexo"] as $claseEdadSexo) {
								$claseEdadSexoId = key($claseEdadSexo);

								$this->AsoCitaClaseEdadSexo->crearAsoCitaClaseEdadSexo($claseEdadSexoId, $this->Cita->id, $claseEdadSexo[$claseEdadSexoId]);
							}
						}

						// Privacidad
						$privacidad = $this->calcularPrivacidadCita($this->Cita->id, $this->Cita->field('fechaAlta'), $especieId, $this->Cita->field('clase_reproduccion_id'));
						$this->Cita->saveField('indPrivacidad', $privacidad);

						// Subir fotos
						if (isset($_FILES["fotos"])) {

							$fotos = $this->Fichero->reArrayFiles($_FILES['fotos']);
							$falloSubidaImagen = false;

							foreach ($fotos as $foto) {
								if (UPLOAD_ERR_NO_FILE !== $foto['error']) {
									$observadorPrincipalNombre = $this->ObservadorPrincipal->obtenerNombre($this->request->data["Cita"]["observador_principal_id"]);
									if (!$this->Fichero->subirImagenCita($foto, $cita, $observadorPrincipalNombre, $current_user['id'], 1)) {
										$falloSubidaImagen = true;
									}
								}
							}
							if ($falloSubidaImagen) {
								$warningMessagesList[] = 'Hubo problemas al subir alguna de las imágenes. Compruebe que el formato es correcto (jpg, jpeg, png o gif) y que no ocupan más de 2 megas.';
							}
						}
						// Eliminar
						if (isset($_POST['fotosEliminar'])) {
							foreach ($_POST['fotosEliminar'] as $fotoId) {
								$this->Fichero->delete($fotoId);
							}
						}
						// Indicador tiene fotos
						$this->Cita->saveField('indFoto', $this->Fichero->tieneFotos($citaId));

						if (empty($errorsMessagesList)) {

							$dataSource->commit();

							$this->Session->setFlash(__('La cita se ha guardado correctamente.'), 'success');

							// Si hay warnings los pasamos a la vista
							if (empty($warningMessagesList)) {
								$this->Session->setFlash(__('La cita se ha guardado correctamente.'), 'success');
							} else {
								$this->set('warnings', $warningMessagesList);
							}

							$this->redirect(array("action" => "edit", "id" => $this->Cita->id));
						} else {
							$dataSource->rollback();

							$errorsMessages = implode("\n", $errorsMessagesList);
							$this->Session->setFlash($errorsMessages, "failure");
						}
					}
				} else {

					$dataSource->rollback();

					$errors = $this->Cita->validationErrors;

					$errorsMessages = "";
					foreach ($errors as $validationError) {
						$errorsMessages .= $validationError[0] . "\n";
					}

					$this->Session->setFlash($errorsMessages, "failure");
				}
			} catch (Exception $e) {
				$dataSource->rollback();
				throw $e;
			}
		}
	}

	/**
	 * Función que se ejecuta al carga la página inicial
	 */
	public function mis_citas()
	{
	}

	/**
	 * Función que se ejecuta al carga la página inicial
	 */
	public function add()
	{
		// Opcion seleccionada del menu
		$this->set('id_opcion_seleccionada', $this::ID_OPCION_MENU);

		/* Usuario */
		$current_user = $this->Auth->user();
		$this->set('usuario', $current_user);

		// Carga los combos necesarios para la pantalla de alta
		$this->cargarCombosCita();

		if ($this->request->is('post')) {

			try {

				$dataSource = $this->Cita->getDataSource();
				$dataSource->begin();

				// Fecha de alta
				$fechaAlta = $this->request->data["Cita"]["fechaAlta"];
				$fechaAltaFormateada = DateUtil::europeanFormatToAmericanFormat($fechaAlta);
				if ($fechaAltaFormateada == false) {
					$this->Session->setFlash('El formato de la fecha de observación no es correcto, debe indicar una fecha con formato dd/mm/aaaa', 'failure');
					return;
				}
				// Hora de alta
				$horaAlta = $this->request->data["Cita"]["horaAlta"];
				if ($horaAlta) {
					$horaAltaFormateada = DateUtil::formatTime($horaAlta);
					if ($horaAltaFormateada == false) {
						$this->Session->setFlash('El formato de la hora de observación no es correcto, debe indicar una hora con formato hh:mm', 'failure');
						return;
					}
					$this->request->data["Cita"]["fechaAlta"] = $fechaAltaFormateada . " " . $horaAltaFormateada;
				} else {
					$this->request->data["Cita"]["fechaAlta"] = $fechaAltaFormateada . " 00:00:00";
				}

				// Especie
				$especieId = $this->request->data["Cita"]["especie_id"];
				$especie = $this->Especie->obtenerTodoPorId($especieId, array(
					'Especie.estatus_reproductivo_ab_id',
					'Especie.clasificacion_criterio_esp_id',
					'Especie.indRareza',
					'Especie.genero',
					'Especie.especie'
				));
				// Subespecie
				if (isset($this->request->data['subespecie'])) {
					$subespecie = $this->Especie->obtenerEspecie(['Especie.genero' => $especie['Especie']['genero'], 'Especie.especie' => $especie['Especie']['especie'], 'Especie.subespecie' => $this->request->data['subespecie']]);
					if (!empty($subespecie)) {
						$especie = $subespecie;
						$this->request->data["Cita"]["especie_id"] = $especie['Especie']['id'];
						$especieId = $this->request->data["Cita"]["especie_id"];
					}
				}

				/*
				 * Importancia
				 */
				$this->request->data["Cita"]["importancia_cita_id"] = CitaUtil::calcularImportanciaCita($especie['Especie']['indRareza'], $especie['Especie']['clasificacion_criterio_esp_id'], $this->request->data["Cita"]["clase_reproduccion_id"]);

				/*
				 * Criterio seleccion
				 */
				$numeroCitasPorLugar = $this->Cita->obtenerTotalCitasPorLugar($this->request->data["Cita"]["lugar_id"]);
				$this->request->data["Cita"]["criterio_seleccion_cita_id"] = CitaUtil::calcularCriterioSeleccion($this->request->data["Cita"], $especie, $numeroCitasPorLugar);
				if ($this->request->data["Cita"]["criterio_seleccion_cita_id"] != 21) {
					$this->request->data["Cita"]["indSeleccionada"] = 1;
				}

				/*
				 * Rareza
				 */
				if ($especie['Especie']['indRareza'] == 1) {
					$this->request->data["Cita"]["indRarezaHomologada"] = 2;
				}

				/*
				 * Precisión
				 */
				$precision = $this->request->data["Cita"]["precision"];
				if ($precision == "cantidad_exacta") {
					$this->request->data["Cita"]["cantidad_exacta"] = 1;
				}
				else if ($precision == "cantidad_aproximada") {
					$this->request->data["Cita"]["cantidad_aproximada"] = 1;
				}
				else if ($precision == "cantidad_precisa") {
					$this->request->data["Cita"]["cantidad_precisa"] = 1;
				}
				else if ($precision == "cantidad_estimada") {
					$this->request->data["Cita"]["cantidad_estimada"] = 1;
				}

				$this->Cita->create();

				$this->Cita->set($this->request->data);

				if ($this->Cita->validates()) {

					if ($this->Cita->save()) {

						$this->request->data['Cita']['id'] = $this->Cita->id;

						/* Cita historico */
						$citaHistorico = $this->CitaHistorico->guardarHistorico($this->Cita->obtenerDatosBasicosPorId($this->Cita->id), $current_user['id']);

						/* Fichero */
						if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] != 4) {
							$observadorPrincipalNombre = $this->ObservadorPrincipal->obtenerNombre($this->request->data["Cita"]["observador_principal_id"]);
							$this->Fichero->subirImagenCita($_FILES["imagen"], $this->request->data, $observadorPrincipalNombre, $current_user['id'], 1);
							$this->Cita->saveField('indFoto', true);
						}

						/* Cita-observador_secundario */
						$observadores = explode(",", $this->request->data["colaboradoresSeleccionados"]);
						foreach ($observadores as $observador) {
							$this->AsoCitaObservador->crearAsoCitaObservador($observador, $this->Cita->id);
						}

						/* Cita-clase_edad_sexo */
						foreach ($this->request->data["claseEdadSexo"] as $claseEdadSexo) {
							$claseEdadSexoId = key($claseEdadSexo);

							$this->AsoCitaClaseEdadSexo->crearAsoCitaClaseEdadSexo($claseEdadSexoId, $this->Cita->id, $claseEdadSexo[$claseEdadSexoId]);
						}

						/*
						 * Privacidad
						 */
						$privacidad = $this->calcularPrivacidadCita($this->Cita->id, $this->Cita->field('fechaAlta'), $especieId, $this->Cita->field('clase_reproduccion_id'));
						$this->Cita->saveField('indPrivacidad', $privacidad);

						if ($especie['Especie']['indRareza']) {
							EmailUtil::enviarEmailNuevaCitaRareza($especie, $this->Cita->id, $current_user);
						}

						$dataSource->commit();
						$this->Session->setFlash(__('La cita se ha creado correctamente.'), 'success');
						return $this->redirect(array(
							"action" => "edit",
							"id" => $this->Cita->id
						));
					}

					$dataSource->rollback();
					$this->Session->setFlash(__('La cita no ha podido ser creada. Por favor, inténtelo de nuevo.'), "failure");
				} else {

					$dataSource->rollback();

					$errors = $this->Cita->validationErrors;

					$errorsMessages = "";
					foreach ($errors as $validationError) {
						$errorsMessages .= $validationError[0] . "\n";
					}

					$this->Session->setFlash($errorsMessages, "failure");
				}
			} catch (Exception $e) {
				$dataSource->rollback();
				throw $e;
			}
		}
	}

	/**
	 * Función que se ejecuta al carga la página inicial
	 */
	public function add_multiple()
	{
		// Opcion seleccionada del menu
		$this->set('id_opcion_seleccionada', $this::ID_OPCION_MENU);

		/* Usuario */
		$current_user = $this->Auth->user();
		$this->set('usuario', $current_user);

		// Carga los combos necesarios para la pantalla de alta
		$this->cargarCombosCita();

		if ($this->request->is('post')) {

			try {

				$dataSource = $this->Cita->getDataSource();
				$dataSource->begin();

				// Fecha de alta
				$fechaAlta = $this->request->data["Cita"]["fechaAlta"];
				$fechaAltaFormateada = DateUtil::europeanFormatToAmericanFormat($fechaAlta);
				if ($fechaAltaFormateada == false) {
					$this->Session->setFlash('El formato de la fecha de observación no es correcto, debe indicar una fecha con formato dd/mm/aaaa', 'failure');
					return;
				}

				// Citas por lugar
				$numeroCitasPorLugar = $this->Cita->obtenerTotalCitasPorLugar($this->request->data["Cita"]["lugar_id"]);

				// Usuario
				$this->request->data["Cita"]["usuario_id"] = $current_user['id'];

				if (!isset($this->request->data['Especie']) || empty($this->request->data['Especie'])) {
					$this->Session->setFlash('Debe incluir al menos una especie', 'failure');
					return;
				}

				foreach ($this->request->data['Especie'] as $datosEspecie) {

					$this->request->data["Cita"]["especie_id"] = $datosEspecie["especie_id"];
					$this->request->data["Cita"]["cantidad"] = $datosEspecie["cantidad"];

					// Hora de alta
					$horaAlta = $datosEspecie["horaAlta"];
					if ($horaAlta) {
						$horaAltaFormateada = DateUtil::formatTime($horaAlta);
						if ($horaAltaFormateada == false) {
							$this->Session->setFlash('El formato de la hora de observación no es correcto, debe indicar una hora con formato hh:mm', 'failure');
							return;
						}
						$this->request->data["Cita"]["fechaAlta"] = $fechaAltaFormateada . " " . $horaAltaFormateada;
					} else {
						$this->request->data["Cita"]["fechaAlta"] = $fechaAltaFormateada . " 00:00";
					}

					$this->request->data["Cita"]["clase_reproduccion_id"] = $datosEspecie["clase_reproduccion_id"];

					$this->request->data["Cita"]["indHabitatRaro"] = $datosEspecie["indHabitatRaro"];
					$this->request->data["Cita"]["indCriaHabitatRaro"] = $datosEspecie["indCriaHabitatRaro"];
					$this->request->data["Cita"]["indHerido"] = $datosEspecie["indHerido"];
					$this->request->data["Cita"]["indComportamiento"] = $datosEspecie["indComportamiento"];
					$this->request->data["Cita"]["dormidero"] = $datosEspecie["dormidero"];
					$this->request->data["Cita"]["colonia_de_cria"] = $datosEspecie["colonia_de_cria"];
					$this->request->data["Cita"]["migracion_activa"] = $datosEspecie["migracion_activa"];
					$this->request->data["Cita"]["sedimentado"] = $datosEspecie["sedimentado"];
					$this->request->data["Cita"]["electrocutado"] = $datosEspecie["electrocutado"];
					$this->request->data["Cita"]["atropellado"] = $datosEspecie["atropellado"];


					$this->request->data["Cita"]["observaciones"] = $datosEspecie["observaciones"];

					/*
					 * Especie
					 */
					$especieId = $this->request->data["Cita"]["especie_id"];
					$especie = $this->Especie->obtenerTodoPorId($especieId, array(
						'Especie.estatus_reproductivo_ab_id',
						'Especie.clasificacion_criterio_esp_id',
						'Especie.indRareza',
						'Especie.genero',
						'Especie.especie'
					));
					// Subespecie
					if (isset($datosEspecie["subespecie"])) {
						$subespecie = $this->Especie->obtenerEspecie(['Especie.genero' => $especie['Especie']['genero'], 'Especie.especie' => $especie['Especie']['especie'], 'Especie.subespecie' => $datosEspecie["subespecie"]]);
						if (!empty($subespecie)) {
							$especie = $subespecie;
							$this->request->data["Cita"]["especie_id"] = $especie['Especie']['id'];
							$especieId = $this->request->data["Cita"]["especie_id"];
						}
					}

					/*
					 * Importancia
					 */
					$this->request->data["Cita"]["importancia_cita_id"] = CitaUtil::calcularImportanciaCita($especie['Especie']['indRareza'], $especie['Especie']['clasificacion_criterio_esp_id'], $this->request->data["Cita"]["clase_reproduccion_id"]);

					/*
					 * Criterio seleccion
					 */
					$cita = $this->request->data["Cita"];
					$this->request->data["Cita"]["criterio_seleccion_cita_id"] = CitaUtil::calcularCriterioSeleccion($cita, $especie, $numeroCitasPorLugar);
					if ($this->request->data["Cita"]["criterio_seleccion_cita_id"] != 21) {
						$this->request->data["Cita"]["indSeleccionada"] = 1;
					}

					/*
					 * Rareza
					 */
					if ($especie['Especie']['indRareza'] == 1) {
						$this->request->data["Cita"]["indRarezaHomologada"] = 2;
					}

					$this->Cita->create();
					$this->Cita->set($this->request->data);

					if ($this->Cita->validates()) {

						$cita = $this->Cita->save();

						/* Cita-observador_secundario */
						$observadores = explode(",", $this->request->data["colaboradoresSeleccionados"]);
						foreach ($observadores as $observador) {
							$this->AsoCitaObservador->crearAsoCitaObservador($observador, $this->Cita->id);
						}

						/*
						 * Cita clase edad sexo
						 */
						foreach ($datosEspecie["claseEdadSexo"] as $claseEdadSexo) {
							$claseEdadSexoId = key($claseEdadSexo);

							$this->AsoCitaClaseEdadSexo->crearAsoCitaClaseEdadSexo($claseEdadSexoId, $this->Cita->id, $claseEdadSexo[$claseEdadSexoId]);
						}

						/*
						 * Privacidad
						 */
						$privacidad = $this->calcularPrivacidadCita($this->Cita->id, $this->Cita->field('fechaAlta'), $especieId, $this->Cita->field('clase_reproduccion_id'));
						$this->Cita->saveField('indPrivacidad', $privacidad);
					} else {

						$dataSource->rollback();

						$errors = $this->Cita->validationErrors;

						$errorsMessages = "";
						foreach ($errors as $validationError) {
							$errorsMessages .= $validationError[0] . "\n";
						}

						$this->Session->setFlash($errorsMessages, "failure");
						return;
					}
				}

				$dataSource->commit();
				$this->Session->setFlash(__('Las citas se han creado correctamente.'), 'success');
				return $this->redirect(array(
					"action" => "mis_citas"
				));
			} catch (Exception $e) {
				$dataSource->rollback();
				throw $e;
			}
		}
	}

	/**
	 * Carga los niveles de protección de una especie
	 */
	public function cargar_niveles_proteccion()
	{
		if ($this->request->is('ajax')) {

			$this->autoRender = false;

			$categoriaProteccion = $this->request->params['named']['figuraProteccion'];
			$nivelProteccion = $this->request->params['named']['nivelProteccion'];

			if ($categoriaProteccion == 'catalogoRegional') {

				$results = $this->ProteccionClm->find('all', array(
					'fields' => array(
						'ProteccionClm.id',
						'ProteccionClm.codigo',
						'ProteccionClm.nombre'
					),
					'conditions' => array(
						'ProteccionClm.indActivo' => 1
					),
					'order' => array(
						'ProteccionClm.codigo'
					),
					'recursive' => -1
				));
				foreach ($results as $result) {

					if ($nivelProteccion == $result['ProteccionClm']['id']) {
						echo '<option value="' . $result['ProteccionClm']['id'] . '" selected="selected">' . $result['ProteccionClm']['codigo'] . ' - ' . $result['ProteccionClm']['nombre'] . '</option>';
					} else {
						echo '<option value="' . $result['ProteccionClm']['id'] . '">' . $result['ProteccionClm']['codigo'] . ' - ' . $result['ProteccionClm']['nombre'] . '</option>';
					}
				}
			} elseif ($categoriaProteccion == 'libroRojo') {
				$results = $this->ProteccionLr->find('all', array(
					'fields' => array(
						'ProteccionLr.id',
						'ProteccionLr.codigo',
						'ProteccionLr.nombre'
					),
					'conditions' => array(
						'ProteccionLr.indActivo' => 1
					),
					'order' => array(
						'ProteccionLr.codigo'
					),
					'recursive' => -1
				));
				foreach ($results as $result) {

					if ($nivelProteccion == $result['ProteccionClm']['id']) {
						echo '<option value="' . $result['ProteccionLr']['id'] . '" selected="selected">' . $result['ProteccionLr']['codigo'] . ' - ' . $result['ProteccionLr']['nombre'] . '</option>';
					} else {
						echo '<option value="' . $result['ProteccionLr']['id'] . '">' . $result['ProteccionLr']['codigo'] . ' - ' . $result['ProteccionLr']['nombre'] . '</option>';
					}
				}
			} elseif ($categoriaProteccion == 'estatusAlbacete') {
				$results = $this->EstatusCuantitativoAb->find('all', array(
					'fields' => array(
						'EstatusCuantitativoAb.id',
						'EstatusCuantitativoAb.codigo',
						'EstatusCuantitativoAb.nombre'
					),
					'conditions' => array(
						'EstatusCuantitativoAb.indActivo' => 1
					),
					'order' => array(
						'EstatusCuantitativoAb.codigo'
					),
					'recursive' => -1
				));
				foreach ($results as $result) {

					if ($nivelProteccion == $result['ProteccionClm']['id']) {
						echo '<option value="' . $result['EstatusCuantitativoAb']['id'] . '" selected="selected">' . $result['EstatusCuantitativoAb']['codigo'] . ' - ' . $result['EstatusCuantitativoAb']['nombre'] . '</option>';
					} else {
						echo '<option value="' . $result['EstatusCuantitativoAb']['id'] . '">' . $result['EstatusCuantitativoAb']['codigo'] . ' - ' . $result['EstatusCuantitativoAb']['nombre'] . '</option>';
					}
				}
			}
		}
	}

	/**
	 * Función que se ejecuta al cargar la página de detalle de una cita
	 */
	public function view()
	{
		// Opcion seleccionada del menu
		$this->set('id_opcion_seleccionada', $this::ID_OPCION_MENU);

		// Recogemos los parámetros de la request
		$citaId = $this->request->named['id'];

		// Obtenemos el usuario actual
		$current_user = $this->Auth->user();

		// Obtenemos los datos de la cita
		$cita = $this->obtenerDetalleCita($citaId);

		if (!$this->esCitaVisible($cita)) {
			throw new ForbiddenException(sprintf('El usuario con email %s no tiene permisos ver la cita con id %s', $current_user['email'], $citaId));
		}

		$precision = "";
		if ($cita["Cita"]["cantidad_exacta"] == true) {
			$precision = "Número exacto";
		}
		else if ($cita["Cita"]["cantidad_aproximada"] == true) {
			$precision = "Número aproximado";
		}
		else if ($cita["Cita"]["cantidad_precisa"] == true) {
			$precision = "Conteo preciso";
		}
		else if ($cita["Cita"]["cantidad_estimada"] == true) {
			$precision = "Estima";
		}

		// Seteamos los datos a mostrar en la vista
		$this->set('cita', $cita);
		$this->set('precision', $precision);
		$this->set('usuario', $current_user);
	}

	/**
	 * Borra una cita
	 */
	public function delete()
	{
		// Obtenemos el id de la cita a eliminar
		$this->Cita->id = $this->request->named['id'];

		/*
		 * Comprobamos si existe la cita
		 */
		if (!$this->Cita->exists()) {
			throw new NotFoundException(sprintf('La cita con id %s no existe', $this->request->named['id']));
		}

		$cita = $this->Cita->read(array(
			'Cita.observador_principal_id',
			'Cita.especie_id',
			'Cita.indActivo'
		), $this->Cita->id);

		// Usuario
		$current_user = $this->Auth->user();

		// Comprobamos si el usuario tiene permisos para dar de baja la cita
		if (!$this->esCitaEditable($cita, $current_user)) {
			throw new ForbiddenException(sprintf('El usuario con email %s no tiene permisos borrar la cita con id %s', $current_user['email'], $this->request->named['id']));
		}

		// Damos de baja la cita
		$this->Cita->saveField('indActivo', 0);

		// Mandamos un email para registrar la eliminacion de la cita
		$especie = $this->Especie->read(array(
			'Especie.genero',
			'Especie.especie'
		), $cita['Cita']['especie_id']);
		EmailUtil::enviarEmailBajaCita($especie, $this->Cita->id, $current_user);

		// Mostramos un mensaje informando de la eliminacion de la cita y volvemos a la Mis Citas
		$this->Session->setFlash(__('La cita ha sido eliminada.'), 'success');
		$this->redirect(array(
			'action' => 'mis_citas'
		));
	}

	/**
	 * Comprueba si existen citas de un observador para las especies, lugar y fecha recibidos por parametro
	 */
	public function existenCitas()
	{
		$response = [];
		$citas = [];

		try {

			if ($this->request->is('ajax')) {

				$this->autoRender = false;

				$currentUser = $this->Auth->user();
				$observadorPrincipalId = $currentUser['observador_principal_id'];
				$lugarId = $this->request->query["lugarId"];
				$fechaAlta = $this->request->query["fechaAlta"];
				$especies = $this->request->query["especies"];

				$especies = explode(",", $especies);

				foreach ($especies as $especieId) {

					if (count($this->Cita->existeCita($especieId, $lugarId, $fechaAlta, $observadorPrincipalId)) > 0) {
						$citas = false;
						break;
					} else {
						$resultado = $this->Cita->existeCita($especieId, $lugarId, $fechaAlta);
						if (!empty($resultado)) {
							$citas = array_merge($citas, $resultado);
						}
					}
				}

				$response['status'] = 0;
				$response['citasSimilares'] = $citas;
			}
		} catch (Exception $e) {
			$response['status'] = 1;
			CakeLog::error(sprintf('[%s] %s', __METHOD__, $e->getMessage()), $e);
		}

		echo json_encode($response);
	}

	/**
	 * Obtiene el detalle de una cita
	 *
	 * @param $citaId
	 * @return array
	 */
	private function obtenerDetalleCita($citaId)
	{
		// Datos generales cita
		$cita = $this->Cita->obtenerTodoPorId($citaId);

		// Comprobamos si la cita existe
		if (!isset($cita) || empty($cita)) {
			throw new NotFoundException(sprintf('La cita con id %s no existe', $citaId));
		}

		// Observadores
		$cita['observadores'] = $this->AsoCitaObservador->obtenerObservadoresPorCita($citaId);

		// Especie
		$cita['Especie'] = $this->Especie->obtenerTodoPorId($cita['Especie']['id']);

		// Orden taxonomico
		$this->OrdenTaxonomico->id = $cita['Especie']['Familia']['orden_taxonomico_id'];
		$cita['Especie']['OrdenTaxonomico']['nombre'] = $this->OrdenTaxonomico->field("nombre");

		// Ubicacion
		$cita['Lugar'] = $this->Lugar->obtenerTodoPorId($cita['Lugar']['id']);

		// Clase edad sexo
		$i = 0;
		foreach ($cita['AsoCitaClaseEdadSexo'] as $claseEdadSexo) {
			$this->ClaseEdadSexo->id = $claseEdadSexo['clase_edad_sexo_id'];
			$cita['AsoCitaClaseEdadSexo'][$i]['clase_edad_sexo_nombre'] = $this->ClaseEdadSexo->field("nombre");
			$i++;
		}

		return $cita;
	}

	/**
	 * Calcula el grado de privacidad de la cita
	 *
	 * @param $citaId
	 * @param $citaFechaAlta
	 * @param $especieId
	 * @param $claseReproduccionId
	 * @return int
	 */
	private function calcularPrivacidadCita($citaId, $citaFechaAlta, $especieId, $claseReproduccionId)
	{
		$privacidad = 1;

		$criteriosPrivacidad = $this->AsoEspeciePrivacidad->obtenerCriteriosPrivacidadPorIdEspecie($especieId);

		if (!empty($criteriosPrivacidad)) {

			for ($i = 0; $i < count($criteriosPrivacidad); $i++) {

				$criterioPrivacidad = $criteriosPrivacidad[$i]['AsoEspeciePrivacidad']['id_privacidad_id'];

				// Cualquier sexo o edad o periodo del 1 de enero al 31 de diciembre
				if ($criterioPrivacidad == Constants::PRIVACIDAD_CUALQUIER_SEXO_EDAD || $criterioPrivacidad == Constants::PRIVACIDAD_PERIODO_1ENERO_31DICIEMBRE) {
					$privacidad = 0;
					break;
				}                    // Comportamiento reproductivo
				elseif ($criterioPrivacidad == Constants::PRIVACIDAD_COMPORTAMIENTO_REPRODUCTIVO) {
					if ($claseReproduccionId >= 2 && $claseReproduccionId <= 10) {
						$privacidad = 0;
						break;
					}
				}                    // Periodo
				elseif ($criterioPrivacidad >= 1 && $criterioPrivacidad <= 11) {

					$fechaArray = explode("-", $citaFechaAlta);
					$mes = (int)$fechaArray[1];

					// Periodo del 1 de abril al 31 de agosto
					if ($criterioPrivacidad == Constants::PRIVACIDAD_PERIODO_1ABRIL_31AGOSTO) {
						if ($mes >= Constants::ABRIL && $mes <= Constants::AGOSTO) {
							$privacidad = 0;
							break;
						}
					}                        // Periodo del 1 de abril al 31 de julio
					elseif ($criterioPrivacidad == Constants::PRIVACIDAD_PERIODO_1ABRIL_31JULIO) {
						if ($mes >= Constants::ABRIL && $mes <= Constants::JULIO) {
							$privacidad = 0;
							break;
						}
					}                        // Periodo del 1 de enero al 31 de julio
					elseif ($criterioPrivacidad == Constants::PRIVACIDAD_PERIODO_1ENERO_31JULIO) {
						if ($mes >= Constants::ENERO && $mes <= Constants::JULIO) {
							$privacidad = 0;
							break;
						}
					}                        // Periodo del 1 de febrero al 31 de julio
					elseif ($criterioPrivacidad == Constants::PRIVACIDAD_PERIODO_1FEBRERO_31JULIO) {
						if ($mes >= Constants::FEBRERO && $mes <= Constants::JULIO) {
							$privacidad = 0;
							break;
						}
					}                        // Periodo del 1 de marzo al 30 de junio
					elseif ($criterioPrivacidad == Constants::PRIVACIDAD_PERIODO_1MARZO_30JUNIO) {
						if ($mes >= Constants::MARZO && $mes <= Constants::JUNIO) {
							$privacidad = 0;
							break;
						}
					}                        // Periodo del 1 de marzo al 31 de agosto
					elseif ($criterioPrivacidad == Constants::PRIVACIDAD_PERIODO_1MARZO_31AGOSTO) {
						if ($mes >= Constants::MARZO && $mes <= Constants::AGOSTO) {
							$privacidad = 0;
							break;
						}
					}                        // Periodo del 1 de marzo al 31 de julio
					elseif ($criterioPrivacidad == Constants::PRIVACIDAD_PERIODO_1MARZO_31JULIO) {
						if ($mes >= Constants::MARZO && $mes <= Constants::JULIO) {
							$privacidad = 0;
							break;
						}
					}                        // Periodo del 1 de mayo al 31 de agosto
					elseif ($criterioPrivacidad == Constants::PRIVACIDAD_PERIODO_1MAYO_31AGOSTO) {
						if ($mes >= Constants::MAYO && $mes <= Constants::AGOSTO) {
							$privacidad = 0;
							break;
						}
					}                        // Periodo del 1 de mayo al 31 de julio
					elseif ($criterioPrivacidad == Constants::PRIVACIDAD_PERIODO_1MAYO_31JULIO) {
						if ($mes >= Constants::MAYO && $mes <= Constants::JULIO) {
							$privacidad = 0;
							break;
						}
					}
				} elseif ($criterioPrivacidad >= 13 && $criterioPrivacidad <= 15) {

					// Edad adulta de cualquier sexo
					if ($criterioPrivacidad == Constants::PRIVACIDAD_EDAD_ADULTA_CUALQUIER_SEXO) {
						if ($this->AsoCitaClaseEdadSexo->existenCitasAdultos($citaId, $especieId)) {
							$privacidad = 0;
							break;
						}
					}                        // Sexo hembra de cualquier edad
					elseif ($criterioPrivacidad == Constants::PRIVACIDAD_SEXO_HEMBRA_CUALQUIER_EDAD) {
						if ($this->AsoCitaClaseEdadSexo->existenCitasHembras($citaId)) {
							$privacidad = 0;
							break;
						}
					}                        // Sexo macho de cualquier edad
					elseif ($criterioPrivacidad == Constants::PRIVACIDAD_SEXO_MACHO_CUALQUIER_EDAD) {
						if ($this->AsoCitaClaseEdadSexo->existenCitasMachos($citaId)) {
							$privacidad = 0;
							break;
						}
					}
				}
			}
		}

		return $privacidad;
	}


	/**
	 * Carga los combos necesarios en las pantallas de alta, alta multimple y edición de cita
	 */
	private function cargarCombosCita()
	{
		/* Clases de reproduccion */
		$clasesReproduccion = $this->ClaseReproduccion->getAllClasesReproduccionBasic();
		$this->set('clasesReproduccion', $clasesReproduccion);

		/* Lugares */
		$lugares = $this->Lugar->obtenerLugaresActivosOrdenadosPorNombre(false);
		$this->set('lugares', $lugares);

		/* Fuentes */
		$fuentes = $this->Fuente->getAllFuentesBasic();
		$this->set('fuentes', $fuentes);

		/* Estudios */
		$estudios = $this->Estudio->obtenerEstudios(null, null, array(
			'Estudio.descripcion'
		));
		$this->set('estudios', $estudios);

		/*
		 * Comarca
		 */
		$comarcas = $this->Comarca->getAllComarcasBasic();
		$this->set('comarcas', $comarcas);

		/*
		 * Municipio
		 */
		$municipios = $this->Municipio->obtenerMunicipiosActivosOrdenadosPorNombre();
		$this->set('municipios', $municipios);

		/*
		 * Cuadricula UTM
		 */
		$cuadriculasUtm = $this->CuadriculaUtm->obtenerCuadriculasUtmActivosOrdenadosPorCodigo();
		$this->set('cuadriculasUtm', $cuadriculasUtm);
	}

	/**
	 * Comprueba si la cita es editable
	 *
	 * @param array $cita
	 * @param array $usuario
	 * @return bool
	 */
	public function esCitaEditable($cita, $usuario)
	{
		return
			($cita['Cita']['observador_principal_id'] == $usuario['observador_principal_id']
				|| $usuario['perfil_id'] == 1)
			&& $cita['Cita']['indActivo'] == 1;
	}

	/**
	 * Comprueba si la cita es visible
	 *
	 * @param array $cita
	 * @param array $usuario
	 * @return bool
	 */
	public function esCitaVisible($cita)
	{
		return $cita['Cita']['indActivo'] == 1;
	}
}
