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
            if (isset($this->request->query["especieId"])  && ! empty($this->request->query["especieId"])) {
                $conditions["Cita.especie_id"] = $this->request->query["especieId"];
                $valuesSubmited["especieId"] = $this->request->query["especieId"];

                if (isset($this->request->query["especie"]) && ! empty($this->request->query["especie"])) {
                    $valuesSubmited["especie"] = $this->request->query["especie"];
                } else {
                    $this->Especie->id = $this->request->query["especieId"];
                    $valuesSubmited["especie"] = $this->Especie->field('nombreComun') . ", " . $this->Especie->field('genero') . " " . $this->Especie->field('especie');
                }
            }

            // Familia
            if (isset($this->request->query["familia"])  && ! empty($this->request->query["familia"])) {
                $conditions["Especie.familia_id"] = $this->request->query["familia"];
                $valuesSubmited["familia"] = $this->request->query["familia"];

                if (isset($this->request->query["ordenTaxonomico"]) && ! empty($this->request->query["ordenTaxonomico"])) {
                    $valuesSubmited["ordenTaxonomico"] = $this->request->query["ordenTaxonomico"];
                }
            // Orden taxonomico
            } elseif (isset($this->request->query["ordenTaxonomico"]) && ! empty($this->request->query["ordenTaxonomico"])) {
                $familias = $this->Familia->find('list', array(
                    'fields' => array(
                        'Familia.id'
                    ),
                    'conditions' => array(
                        'Familia.indActivo' => 1,
                        'Familia.orden_taxonomico_id' => $this->request->query["ordenTaxonomico"]
                    ),
                    'recursive' => - 1
                ));
                $conditions["Especie.familia_id"] = $familias;
                $valuesSubmited["ordenTaxonomico"] = $this->request->query["ordenTaxonomico"];
            }

            // Figura de proteccion
            if (isset($this->request->query["figuraProteccion"]) && ! empty($this->request->query["figuraProteccion"]) && isset($this->request->query["nivelProteccion"]) && ! empty($this->request->query["nivelProteccion"])) {

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
            if (isset($this->request->query["estudioId"]) && ! empty($this->request->query["estudioId"])) {
                $conditions["Cita.estudio_id"] = $this->request->query["estudioId"];
                $valuesSubmited["estudioId"] = $this->request->query["estudioId"];
            }

            // Comarca
            if (isset($this->request->query["comarcaId"]) && ! empty($this->request->query["comarcaId"])) {
                $conditions["Lugar.comarca_id"] = $this->request->query["comarcaId"];
                $valuesSubmited["comarcaId"] = $this->request->query["comarcaId"];
            }

            // Municipio
            if (isset($this->request->query["municipioId"]) && ! empty($this->request->query["municipioId"])) {
                $conditions["Lugar.municipio_id"] = $this->request->query["municipioId"];
                $valuesSubmited["municipioId"] = $this->request->query["municipioId"];
            }

            // Cuadricula UTM
            if (isset($this->request->query["cuadriculaUtmId"]) && ! empty($this->request->query["cuadriculaUtmId"])) {
                $conditions["Lugar.cuadricula_utm_id"] = $this->request->query["cuadriculaUtmId"];
                $valuesSubmited["cuadriculaUtmId"] = $this->request->query["cuadriculaUtmId"];
            }

            // Lugar
            if (isset($this->request->query["lugarId"]) && ! empty($this->request->query["lugarId"])) {
                $conditions["Cita.lugar_id"] = $this->request->query["lugarId"];
                $valuesSubmited["lugarId"] = $this->request->query["lugarId"];
                $valuesSubmited["lugar"] = $this->request->query["lugar"];

                // Filtramos las citas privadas salvo las que pertenezcan al usuario
                if (! isset($usuario)) {
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
            if (isset($this->request->query["fechaDesde"]) && ! empty($this->request->query["fechaDesde"])) {
                $fecha_desde = $this->request->query["fechaDesde"];
                $valuesSubmited["fechaDesde"] = $fecha_desde;
                $conditions[] = "Cita.fechaAlta >= STR_TO_DATE('$fecha_desde','%d/%m/%Y')";
            }
            if (isset($this->request->query["fechaHasta"]) && ! empty($this->request->query["fechaHasta"])) {
                $fecha_hasta = $this->request->query["fechaHasta"];
                $valuesSubmited["fechaHasta"] = $fecha_hasta;
                $conditions[] = "Cita.fechaAlta <= STR_TO_DATE('$fecha_hasta','%d/%m/%Y')";
            }
            if (isset($this->request->query["fechaAlta"]) && ! empty($this->request->query["fechaAlta"]) && ! (isset($valuesSubmited["fechaHasta"]) && ! empty($valuesSubmited["fechaHasta"]))) {
                $fecha_alta = $this->request->query["fechaAlta"];
                $conditions[] = "Cita.fechaAlta = STR_TO_DATE('$fecha_alta','%d/%m/%Y')";
                $valuesSubmited["fechaDesde"] = $this->request->query["fechaAlta"];
                $valuesSubmited["fechaHasta"] = $this->request->query["fechaAlta"];
            }

            // Clase reproduccion
            if (isset($this->request->query["claseReproduccionId"]) && ! empty($this->request->query["claseReproduccionId"])) {
                $conditions["Cita.clase_reproduccion_id"] = $this->request->query["claseReproduccionId"];
                $valuesSubmited["claseReproduccionId"] = $this->request->query["claseReproduccionId"];
            }

            // Observador
            if (isset($this->request->query["observadorId"]) && ! empty($this->request->query["observadorId"])) {
                $conditions["Cita.observador_principal_id"] = $this->request->query["observadorId"];
                $valuesSubmited["observadorId"] = $this->request->query["observadorId"];
                $valuesSubmited["observador"] = $this->request->query["observador"];
            }

            // Colaborador
            if (isset($this->request->query["colaboradorId"]) && ! empty($this->request->query["colaboradorId"])) {
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
        }

        if (count($conditions) > 0) {

            $params = [];
            $params['joins'] = $joins;
            $params['conditions'] = $conditions;
            $params['order'] = [
                'Cita.fechaAlta' => 'desc',
                'Cita.fechaCreacion' => 'desc'
            ];
            $params['limit'] = 25;

            // Mostramos aviso si se han filtrado las citas privadas pero existe alguna
            if ($filtraCitasPrivadas) {

                if (! isset($usuario)) {
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
                        ['label' => __('Fecha')],
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
                    ];

                    // add heading with different font and bold text
                    $this->PhpExcel->addTableHeader($table, ['name' => 'Cambria', 'bold' => true]);

                    // add data
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

                        $lugar = $cita['Lugar']['nombre'];
                        if ($cita['Cita']['indPrivacidad'] == 1 || (isset($usuario) && ($usuario['observador_principal_id'] == $cita['Cita']['observador_principal_id'] || $usuario['perfil_id'] == 1))) {
                            $lugar = __('Lugar confidencial');
                        }

                        $this->PhpExcel->addTableRow([
                            $cita['ImportanciaCita']['codigo'],
                            $cita['ImportanciaCita']['descripcion'],
                            $cita['Especie']['nombreComun'],
                            $cita['Especie']['genero'] . ' ' . $cita['Especie']['especie'] . ' ' . $cita['Especie']['subespecie'],
                            $cita['Cita']['fechaAlta'],
                            $lugar,
                            $cita['Municipio']['nombre'],
                            $cita['Comarca']['nombre'],
                            $cita['CuadriculaUtm']['codigo'],
                            $cita['Cita']['cantidad'],
                            $cita['ObservadorPrincipal']['codigo'],
                            $cita['ObservadorPrincipal']['nombre'],
                            $this->ObservadorSecundario->mostrarCodigosObservadores($cita['observadoresSecundarios']),
                            $this->ObservadorSecundario->mostrarNombresObservadores($cita['observadoresSecundarios']),
                            $cita['ClaseReproduccion']['codigo'],
                            $cita['ClaseReproduccion']['descripcion'],
                            $cita['CriterioSeleccionCita']['codigo'],
                            $cita['CriterioSeleccionCita']['nombre'],
                        ]);
                    }

                    // close table and output
                    $this->PhpExcel->addTableFooter()->output('citas.xlsx', 'Excel2007');
                }
            }
            $this->paginate['Cita'] = $params;
            $citas = $this->paginate();

            for ($index = 0; $index < count($citas); $index ++) {

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
        if (! $this->esCitaEditable($cita, $current_user)) {
            throw new ForbiddenException(sprintf('El usuario con email %s no tiene permisos editar la cita con id %s',$current_user['email'], $citaId));
        }

        // Pasamos los datos de la cita y el usuario registrado a la vista
        $this->set('cita', $cita);
        $this->set('usuario', $current_user);

        // Carga los datos de los combos a mostrar en la vista
        $this->cargarCombosCita();

        // Clase edad sexo
        $clasesEdadSexo = $this->ClaseEdadSexo->obtenerActivos();
        $cantidades = [];
        for ($i = 0; $i < count($clasesEdadSexo); $i ++) {
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
                $observaciones = $this->request->data["Cita"]["observaciones"];
                $cita["Cita"]["observaciones"] = trim(strip_tags($observaciones));
                $cita["Cita"]["cantidad"] = $this->request->data["Cita"]["cantidad"];
                $cita["Cita"]["clase_reproduccion_id"] = $this->request->data["Cita"]["clase_reproduccion_id"];

                // Fecha de alta
                {
                    $fechaAlta = $this->request->data["Cita"]["fechaAlta"];
                    $fechaAltaFormateada = DateUtil::europeanFormatToAmericanFormat($fechaAlta);
                    if ($fechaAltaFormateada !== false) {
                        $cita["Cita"]["fechaAlta"] = $fechaAltaFormateada;
                    } else {
                        $this->Session->setFlash('El formato de la fecha de alta no es correcto, debe indicar una fecha con formato dd/mm/aaaa', 'failure');
                        return;
                    }
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
                    if (! empty($subespecie)) {
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
                        if (! empty($errorsMessagesHist)) {
                            array_push($errorsMessagesList, $errorsMessagesHist);
                        }

                        // Cita-observador_secundario
                        {
                            // Borramos las relaciones existentes
                            $this->AsoCitaObservador->deleteAll(['AsoCitaObservador.cita_id' => $citaId], false);

                            // Insertamos los observadores recibidos
                            if (! empty($this->request->data["colaboradoresSeleccionados"])) {

                                $observadores = explode(",", $this->request->data["colaboradoresSeleccionados"]);
                                foreach ($observadores as $observador) {

                                    $errorsMessagesObs = $this->AsoCitaObservador->crearAsoCitaObservador($observador, $this->Cita->id);
                                    if (! empty($errorsMessagesObs)) {
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

                        // Fotos
                        {
                            // Subir
                            if (isset($_FILES["fotos"])) {

                                $fotos = $this->Fichero->reArrayFiles($_FILES['fotos']);
                                $falloSubidaImagen = false;

                                foreach ($fotos as $foto) {
                                    if (UPLOAD_ERR_NO_FILE !== $foto['error']) {
                                        if(! $this->Fichero->subirImagenCita($foto, $cita, $current_user['id'], 1)) {
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
                if ($fechaAltaFormateada != false) {
                    $this->request->data["Cita"]["fechaAlta"] = $fechaAltaFormateada;
                } else {
                    $this->Session->setFlash('El formato de la fecha de alta no es correcto, debe indicar una fecha con formato dd/mm/aaaa', 'failure');
                    return;
                }
                // Fecha creacion
                $this->request->data["Cita"]["fechaCreacion"] = (new DateTime())->format('Y-m-d H:i:s');

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
                    if (! empty($subespecie)) {
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

                $this->Cita->create();

                $this->Cita->set($this->request->data);

                if ($this->Cita->validates()) {

                    if ($this->Cita->save()) {

                        $this->request->data['Cita']['id'] = $this->Cita->id;

                        /* Cita historico */
                        $citaHistorico = $this->CitaHistorico->guardarHistorico($this->Cita->obtenerDatosBasicosPorId($this->Cita->id), $current_user['id']);

                        /* Fichero */
                        if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] != 4) {
                            $this->Fichero->subirImagenCita($_FILES["imagen"], $this->request->data, $current_user['id'], 1);
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
                if ($fechaAltaFormateada != false) {
                    $this->request->data["Cita"]["fechaAlta"] = $fechaAltaFormateada;
                } else {
                    $this->Session->setFlash('El formato de la fecha de alta no es correcto, debe indicar una fecha con formato dd/mm/aaaa', 'failure');
                    return;
                }

                // Fecha creacion
                $fechaActual = (new DateTime())->format('Y-m-d H:i:s');

                // Citas por lugar
                $numeroCitasPorLugar = $this->Cita->obtenerTotalCitasPorLugar($this->request->data["Cita"]["lugar_id"]);

                // Usuario
                $this->request->data["Cita"]["usuario_id"] = $current_user['id'];

                if (! isset($this->request->data['Especie']) || empty($this->request->data['Especie'])) {
                    $this->Session->setFlash('Debe incluir al menos una especie', 'failure');
                    return;
                }

                foreach ($this->request->data['Especie'] as $datosEspecie) {

                    $this->request->data["Cita"]["especie_id"] = $datosEspecie["especie_id"];
                    $this->request->data["Cita"]["cantidad"] = $datosEspecie["cantidad"];
                    $this->request->data["Cita"]["clase_reproduccion_id"] = $datosEspecie["clase_reproduccion_id"];

                    $this->request->data["Cita"]["indHabitatRaro"] = $datosEspecie["indHabitatRaro"];
                    $this->request->data["Cita"]["indCriaHabitatRaro"] = $datosEspecie["indCriaHabitatRaro"];
                    $this->request->data["Cita"]["indHerido"] = $datosEspecie["indHerido"];
                    $this->request->data["Cita"]["indComportamiento"] = $datosEspecie["indComportamiento"];

                    $this->request->data["Cita"]["observaciones"] = $datosEspecie["observaciones"];

                    $this->request->data["Cita"]["fechaCreacion"] = $fechaActual;

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
                        if (! empty($subespecie)) {
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
                    'recursive' => - 1
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
                    'recursive' => - 1
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
                    'recursive' => - 1
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

        if (! $this->esCitaVisible($cita)) {
            throw new ForbiddenException(sprintf('El usuario con email %s no tiene permisos ver la cita con id %s',$current_user['email'], $citaId));
        }

        // Seteamos los datos a mostrar en la vista
        $this->set('cita', $cita);
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
        if (! $this->Cita->exists()) {
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
        if (! $this->esCitaEditable($cita, $current_user)) {
            throw new ForbiddenException(sprintf('El usuario con email %s no tiene permisos borrar la cita con id %s',$current_user['email'], $this->request->named['id']));
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
                        if (! empty($resultado)) {
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
        if (! isset($cita) || empty($cita)) {
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
            $i ++;
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

        if (! empty($criteriosPrivacidad)) {

            for ($i = 0; $i < count($criteriosPrivacidad); $i ++) {

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
                    $mes = (int) $fechaArray[1];

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