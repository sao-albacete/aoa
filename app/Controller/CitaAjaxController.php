<?php
App::uses('AppController', 'Controller');
App::uses('Constants', 'Utility');
App::uses('ConnectionManager', 'Model');

/**
 * Maneja la información a mostrar el la página de inicio
 *
 * @author vcanizares
 */
class CitaAjaxController extends AppController
{
    
    /**
     * Nombre del controlador
     */
    public $name = 'CitaAjax';

    /**
     * Componentes
     */
    public $components = array();

    /**
     * Helpers
     */
    public $helpers = array();

    /**
     * Modelos
     */
    public $uses = array(
        'Cita',
        'AsoCitaObservador',
        'AsoCitaClaseEdadSexo',
        'ObservadorSecundario',
        'Lugar'
    );
    
    // Array de columnas que serán mostradas en la tabla de DataTables.
    public $aColumns = array(
        'Ver Detalle',
        'Importancia',
        'Especie',
        'Fecha',
        'Lugar',
        'Número de Aves',
        'Observador',
        'Colaboradores',
        'Clase de Reproducción',
        'Criterio de Selección',
    );
    
    // Array de columnas por las que se puede ordenar
    public $aSortableColumns = array(
        ' ',
        'ImportanciaCita.descripcion',
        'Especie.nombreComun',
        'Cita.fechaAlta',
        'Lugar.nombre',
        'Cita.cantidad',
        'ObservadorPrincipal.codigo',
        ' ',
        'ClaseReproduccion.codigo',
        'CriterioSeleccionCita.codigo',
    );
    
    // Array de columnas por las que se puede ordenar
    public $aSearchableColumns = array(
        'ImportanciaCita.descripcion',
        'Especie.nombreComun',
        'Especie.genero',
        'Especie.especie',
        'Especie.subespecie',
        'Cita.fechaAlta',
        'Lugar.nombre',
        'Cita.cantidad',
        'ObservadorPrincipal.codigo',
        'ObservadorPrincipal.nombre',
        'ClaseReproduccion.codigo',
        'ClaseReproduccion.descripcion',
        'CriterioSeleccionCita.codigo',
        'CriterioSeleccionCita.nombre',
    );
    
    // Array de columnas que queremos obtener de base de datos
    public $aFields = array(
        'Cita.id',
        'Cita.fechaAlta',
        'Cita.indPrivacidad',
        'Cita.observador_principal_id',
        'Especie.id',
        'Especie.nombreComun',
        'Especie.genero',
        'Especie.especie',
        'Especie.subespecie',
        'Lugar.id',
        'Lugar.nombre',
        'ObservadorPrincipal.id',
        'ObservadorPrincipal.nombre',
        'ObservadorPrincipal.codigo',
        'ClaseReproduccion.id',
        'ClaseReproduccion.descripcion',
        'ClaseReproduccion.codigo',
        'ImportanciaCita.id',
        'ImportanciaCita.descripcion',
        'Cita.cantidad',
        'CriterioSeleccionCita.id',
        'CriterioSeleccionCita.codigo',
        'CriterioSeleccionCita.nombre',
    );
    
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('obtenerCitasDatatables', 'obtenerCitasEspecieDatatables');
    }

    public function obtenerCitasDatatables()
    {
        $this->autoRender = false;

        // Usuario
        $usuario = $this->Auth->user();

        /* Paginacion */
        $paginationParams = self::getPaginationParams();
        $iLimit = $paginationParams['iLimit'];
        $iPage = $paginationParams['iPage'];

        /* Ordenacion */
        $aOrder = self::getOrderArray();

        /* Filtrado */
        $aConditions = array(
            'Cita.indActivo' => 1
        );
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $aOrConditions = array();
            for ($i = 0; $i < count($this->aSearchableColumns); $i ++) {
                $aSearchableItemTo = array(
                    $this->aSearchableColumns[$i] . " LIKE " => "%" . $_GET['sSearch'] . "%"
                );
                array_push($aOrConditions, $aSearchableItemTo);
            }
            array_push($aConditions, array(
                'OR' => $aOrConditions
            ));
        }

        /* Total citas */
        $iTotal = self::getTotal();

        /* Total registros encontrados */
        $iFilteredTotal = self::getFilteredTotal($aConditions, $iTotal);

        /* Obtener los datos a mostrar */
        $citas = self::getCitas($aConditions, $iLimit, $iPage, $aOrder);

        /* Output */
        $output = self::getOutput($citas, $iFilteredTotal, $iTotal, $usuario, array('ver'));

        echo json_encode($output);
    }

    public function obtenerCitasObservadorDatatables()
    {
        $this->autoRender = false;

        // Usuario
        $usuario = $this->Auth->user();

        /* Paginacion */
        $paginationParams = self::getPaginationParams();
        $iLimit = $paginationParams['iLimit'];
        $iPage = $paginationParams['iPage'];

        /* Ordenacion */
        $aOrder = self::getOrderArray();

        /* Filtrado */
        $aConditions = array(
            'Cita.observador_principal_id' => $usuario['observador_principal_id'],
            'Cita.indActivo' => 1
        );
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $aOrConditions = array();
            for ($i = 0; $i < count($this->aSearchableColumns); $i ++) {
                $aSearchableItemTo = array(
                    $this->aSearchableColumns[$i] . " LIKE " => "%" . $_GET['sSearch'] . "%"
                );
                array_push($aOrConditions, $aSearchableItemTo);
            }
            array_push($aConditions, array(
                'OR' => $aOrConditions
            ));
        }

        /* Total citas */
        $iTotal = self::getTotal();

        /* Total registros encontrados */
        $iFilteredTotal = self::getFilteredTotal($aConditions, $iTotal);

        /* Obtener los datos a mostrar */
        $citas = self::getCitas($aConditions, $iLimit, $iPage, $aOrder);

        /* Output */
        $output = self::getOutput($citas, $iFilteredTotal, $iTotal, $usuario, array('ver', 'editar', 'eliminar'));

        echo json_encode($output);
    }

    public function obtenerCitasColaboradorDatatables()
    {
        $this->autoRender = false;

        // Usuario
        $usuario = $this->Auth->user();

        /* Paginacion */
        $paginationParams = self::getPaginationParams();
        $iLimit = $paginationParams['iLimit'];
        $iPage = $paginationParams['iPage'];

        /* Ordenacion */
        $aOrder = self::getOrderArray();

        /* Filtrado */
        $aJoins = array();

        $observadoresSecundariosIds = $this->ObservadorSecundario->getObservadoresSecundariosByNombre($usuario['ObservadorPrincipal']['nombre']);

        if (! empty($observadoresSecundariosIds)) {

            $aConditions = array(
                'AsoCitaObservador.observador_secundario_id IN (' . implode(',', $observadoresSecundariosIds) . ')',
                'Cita.indActivo = 1'
            );
            if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
                $aOrConditions = array();
                for ($i = 0; $i < count($this->aSearchableColumns); $i ++) {
                    $aOrConditions[] = $this->aSearchableColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%'";
                }
                $aConditions[] = ' ( ' . implode(' OR ', $aOrConditions) . ' ) ';
            }
        } else {
            // Creamos una condicion que no se cumpla nunca para que no devuelva ningún resultado
            $aConditions = array(
                'Cita.id = -1'
            );
        }

        $select = 'SELECT ' . implode(', ', $this->aFields);
        $selectCount = 'SELECT COUNT(Cita.id)';
        $from = ' FROM ' . implode(' LEFT JOIN ', $this->getFroms());
        $where = ' WHERE ' . implode(' AND ', $aConditions);
        $orderBy = ' ORDER BY ' . implode(',', $aOrder);
        $limit = ' LIMIT ' . (($iPage - 1) * $iLimit) . ', ' . $iLimit;

        /* Total citas */
        $iTotal = self::getTotal();

        /* Total registros encontrados */
        $iFilteredTotal = $this->Cita->query($selectCount . $from . $where);

        /* Obtener los datos a mostrar */
        $citas = $this->Cita->query($select . $from . $where . $orderBy . $limit);

        /* Output */
        $output = self::getOutput($citas, $iFilteredTotal[0][0]['COUNT(Cita.id)'], $iTotal, $usuario, array('ver'));

        echo json_encode($output);
    }
    
    public function obtenerCitasEspecieDatatables()
    {
        $this->autoRender = false;

        // Usuario
        $usuario = $this->Auth->user();

        /* Paginacion */
        $paginationParams = self::getPaginationParams();
        $iLimit = $paginationParams['iLimit'];
        $iPage = $paginationParams['iPage'];

        /* Ordenacion */
        $aOrder = self::getOrderArray();

        /* Filtrado */
        $aConditions = array(
            'Cita.especie_id' => $_GET['especieId'],
            'Cita.indActivo = 1'
        );
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $aOrConditions = array();
            for ($i = 0; $i < count($this->aSearchableColumns); $i ++) {
                $aSearchableItemTo = array(
                    $this->aSearchableColumns[$i] . " LIKE " => "%" . $_GET['sSearch'] . "%"
                );
                array_push($aOrConditions, $aSearchableItemTo);
            }
            array_push($aConditions, array(
            'OR' => $aOrConditions
            ));
        }

        /* Total citas */
        $iTotal = self::getTotal();

        /* Total registros encontrados */
        $iFilteredTotal = self::getFilteredTotal($aConditions, $iTotal);

        /* Obtener los datos a mostrar */
        $citas = self::getCitas($aConditions, $iLimit, $iPage, $aOrder);

        /* Output */
        $output = self::getOutput($citas, $iFilteredTotal, $iTotal, $usuario, array('ver'));

        echo json_encode($output);
    }
    
    private function getPaginationParams()
    {
        $paginationParams = array();
        
        $iLimit = 0;
        $iPage = 1;
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $iLimit = intval($_GET['iDisplayLength']);
            $iPage = (intval($_GET['iDisplayStart']) / intval($_GET['iDisplayLength'])) + 1;
        }
        
        $paginationParams['iLimit'] = $iLimit;
        $paginationParams['iPage'] = $iPage;
        
        return $paginationParams;
    }
    
    private function getOrderArray()
    {
        $aOrder = array();
        if (isset($_GET['iSortCol_0'])) {
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i ++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $itemToOrderBy = $this->aSortableColumns[intval($_GET['iSortCol_' . $i])] . " " . ($_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc');
                    array_push($aOrder, $itemToOrderBy);
                }
            }
        }
        if (count($aOrder) == 0) {
            $aOrder = array(
                'Cita.fechaAlta DESC'
            );
        }
        
        return $aOrder;
    }
    
    private function getTotal()
    {
        if (isset($_GET['iTotal'])) {
            $iTotal = $_GET['iTotal'];
        } else {
            $iTotal = $this->Cita->obtenerNumeroCitas(['Cita.indActivo = 1']);
        }
        
        return $iTotal;
    }
    
    private function getFilteredTotal($aConditions, $iTotal, $aJoins = null)
    {
        if (isset($_GET['iTotal'])) {
            $iFilteredTotal = count($this->Cita->obtenerCitas($aConditions, array('Cita.id'), null, $iTotal, $aJoins));
        } else {
            $iFilteredTotal = $this->Cita->obtenerNumeroCitas($aConditions, $aJoins);
        }

        return $iFilteredTotal;
    }
    
    private function getCitas($aConditions, $iLimit, $iPage, $aOrder, $aJoins = null)
    {
        $params = array(
            'fields' => $this->aFields,
            'conditions' => $aConditions,
            'limit' => $iLimit,
            'page' => $iPage,
            'order' => $aOrder
        );
        if(! empty($aJoins)) {
            $params['joins'] = $aJoins;
        }

        $citas = $this->Cita->find('all', $params);
        
        return $citas;
    } 
    
    private function getOutput($citas, $iFilteredTotal, $iTotal, $usuario, array $aOperations)
    {
        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );
        
        for ($index = 0; $index < count($citas); $index ++) {
        
            /*
             * Observadores secundarios
             */
            $observadoresSecundarios = $this->AsoCitaObservador->obtenerObservadoresPorCita($citas[$index]['Cita']['id']);
        
            /*
             * Clases edad sexo
             */
            $clasesEdadSexo = $this->AsoCitaClaseEdadSexo->obtenerClasesEdadSexoPorCita($citas[$index]['Cita']['id']);
        
            $row = array();
        
            for ($i = 0; $i < count($this->aColumns); $i ++) {
                if ($this->aColumns[$i] == "Ver Detalle") {
                    $operationsColumn = '';
                    if (in_array('eliminar', $aOperations)) {
                        $operationsColumn .= "<a href='javascript: eliminarCita(" . $citas[$index]['Cita']['id'] . ",\"" . $citas[$index]['Especie']['nombreComun'] . "\");' title='" . __("Eliminar cita") . "'><img src='/img/icons/fugue-icons-3.5.6/icons/cross.png' alt='Icono eliminar'/></a>&nbsp;&nbsp;";
                    }
                    if (in_array('editar', $aOperations)) {
                        $operationsColumn .= "<a href='/cita/edit/id:" . $citas[$index]['Cita']['id'] . "' title='" . __("Editar cita") . "'><img src='/img/icons/fugue-icons-3.5.6/icons/pencil.png' alt='Icono editar'/></a>&nbsp;&nbsp;";
                    }
                    if (in_array('ver', $aOperations)) {
                        $operationsColumn .= "<a href='/cita/view/id:" . $citas[$index]['Cita']['id'] . "' title='" . __("Detalle cita") . "'><img src='/img/icons/fugue-icons-3.5.6/icons/magnifier-left.png' alt='Icono detalle'/></a>";
                    }
                    $row[] = $operationsColumn;
                } elseif ($this->aColumns[$i] == "Importancia") {
                    $row[] = $this->getIconoImportancia($citas[$index]['ImportanciaCita']['id'], $citas[$index]['ImportanciaCita']['descripcion']);
                } elseif ($this->aColumns[$i] == "Especie") {
                    $row[] = "<a href='/cita/index?especieId=" . $citas[$index]['Especie']['id'] . "' title='" . $citas[$index]['Especie']['genero'] . " " . $citas[$index]['Especie']['especie'] . " " . $citas[$index]['Especie']['subespecie'] . "'>" . $citas[$index]['Especie']['nombreComun'] . ' ' . $citas[$index]['Especie']['subespecie'] . "</a>";
                } elseif ($this->aColumns[$i] == "Fecha") {
                    $row[] = "<a href='/cita/index?fechaAlta=" . date_format(date_create($citas[$index]['Cita']['fechaAlta']), "d/m/Y") . "'>" . date_format(date_create($citas[$index]['Cita']['fechaAlta']), "d/m/Y") . "</a>";
                } elseif ($this->aColumns[$i] == "Lugar") {
                    if ($citas[$index]['Cita']['indPrivacidad'] == 1 || (isset($usuario) && ($usuario['observador_principal_id'] == $citas[$index]['Cita']['observador_principal_id'] || $usuario['perfil_id'] == 1))) {
                        $row[] = "<a href='/cita/index?lugarId=" . $citas[$index]['Lugar']['id'] . "' title='" . $this->mostrarDetalleLugar($citas[$index]['Lugar']['id']) . "'>" . ucwords($citas[$index]['Lugar']['nombre']) . "</a>";
                    } else {
                        $row[] = '<span title="' . $this->mostrarDetalleLugar($citas[$index]['Lugar']['id']) . '"><img width="16" height="16" style="margin-right: 10px;" alt="alert icon" src="/img/icons/fugue-icons-3.5.6/icons/exclamation-red.png"> Lugar confidencial</span>';
                    }
                } elseif ($this->aColumns[$i] == "Número de Aves") {
                    $row[] = "<span title='" . $this->mostrarDetalleClaseEdadEexo($clasesEdadSexo) . "'>" . $citas[$index]['Cita']['cantidad'] . "</span>";
                } elseif ($this->aColumns[$i] == "Observador") {
                    $row[] = "<a href='/cita/index?observadorId=" . $citas[$index]['ObservadorPrincipal']['id'] . "' title='" . $citas[$index]['ObservadorPrincipal']['nombre'] . "'>" . $citas[$index]['ObservadorPrincipal']['codigo'] . "</a>";
                } elseif ($this->aColumns[$i] == "Colaboradores") {
                    $row[] = $this->mostrarCodigosPbservadores($observadoresSecundarios);
                } elseif ($this->aColumns[$i] == "Clase de Reproducción") {
                    $row[] = "<a href='/cita/index?claseReproduccionId=" . $citas[$index]['ClaseReproduccion']['id'] . "' title='" . $citas[$index]['ClaseReproduccion']['descripcion'] . "'>" . $citas[$index]['ClaseReproduccion']['codigo'] . "</a>";
                } elseif ($this->aColumns[$i] == "Criterio de Selección") {
                    $row[] = "<span title='" . $citas[$index]['CriterioSeleccionCita']['nombre'] . "'>" . $citas[$index]['CriterioSeleccionCita']['codigo'] . "</span>";
                }
            }
        
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
    
    private function getFroms()
    {
        $dataSource = ConnectionManager::getDataSource('default');
    
        $prefix = $dataSource->config['database'] . '.' . $dataSource->config['prefix'];
    
        return array(
            $prefix . 'cita AS Cita',
            $prefix . 'aso_cita_observador AS AsoCitaObservador ON (`Cita`.`id` = `AsoCitaObservador`.`cita_id`)',
            $prefix . 'lugar AS Lugar ON (`Cita`.`lugar_id` = `Lugar`.`id`)',
            $prefix . 'observador_principal AS ObservadorPrincipal ON (`Cita`.`observador_principal_id` = `ObservadorPrincipal`.`id`)',
            $prefix . 'clase_reproduccion AS ClaseReproduccion ON (`Cita`.`clase_reproduccion_id` = `ClaseReproduccion`.`id`)',
            $prefix . 'especie AS Especie ON (`Cita`.`especie_id` = `Especie`.`id`)',
            $prefix . 'importancia_cita AS ImportanciaCita ON (`Cita`.`importancia_cita_id` = `ImportanciaCita`.`id`)',
            $prefix . 'criterio_seleccion_cita AS CriterioSeleccionCita ON (`Cita`.`criterio_seleccion_cita_id` = `CriterioSeleccionCita`.`id`)',
        );
    }

    private function mostrarCodigosPbservadores($observadores)
    {
        $out = "";
        
        if (! empty($observadores)) {
            
            foreach ($observadores as $observador) {
                
                $out .= "<a href='/cita/index?colaboradorId=" . $observador['ObservadorSecundario']['id'] . "' title='" . $observador['ObservadorSecundario']['nombre'] . "'>" . $observador['ObservadorSecundario']['codigo'] . "</a> ";
            }
        }
        
        return $out;
    }

    /**
     * Genera el detalle de la cantiadad de aves desglosado por clases de edad/sexo
     *
     * @param array $clases_edad_sexo            
     * @return string lista formada por "#[número de aves] -> [código clase edad/sexo] ([nombre clase edad/sexo])"
     */
    public function mostrarDetalleClaseEdadEexo($clases_edad_sexo)
    {
        $out = "";
        
        if (! empty($clases_edad_sexo)) {
            
            foreach ($clases_edad_sexo as $clase_edad_sexo) {
                
                $out .= $clase_edad_sexo['AsoCitaClaseEdadSexo']['cantidad'] . " -> " . $clase_edad_sexo['ClaseEdadSexo']['nombre'] . ", ";
            }
        }
        
        return substr($out, 0, - 2);
    }
    
    /**
     * Genera el detalle del lugar: comarca, municipio y cuadrícula UTM
     *
     * @param int $lugarId
     * @return string
     */
    public function mostrarDetalleLugar($lugarId)
    {
        $out = "";
    
        if (! empty($lugarId)) {
            
            $lugar = $this->Lugar->obtenerTodoPorId($lugarId);
            
            $out .= 'COMARCA: ' . $lugar['Comarca']['nombre'] . ", MUNICIPIO: " . $lugar['Municipio']['nombre'] . " y CUADRICULA UTM: " . $lugar['CuadriculaUtm']['codigo'];
        }
    
        return $out;
    }

    /**
     * Concatena los observadores generando links con el nombre y el codigo del observador.
     *
     * @param array $observadores            
     * @return string cadena de links con el nombre y el codigo del observador
     */
    public function getIconoImportancia($importanciaId, $importanciaDescripcion)
    {
        $out = "";
        $icono = "";
        
        switch ($importanciaId) {
            case Constants::IMPORTANCIA_RAREZA_NACIONAL_ID:
                $icono = "rareza_nacional.png";
                break;
            case Constants::IMPORTANCIA_RAREZA_LOCAL_ID:
                $icono = "rareza_local.png";
                break;
            case Constants::IMPORTANCIA_ESP_PROTEGIDA_ID:
                $icono = "especie_protegida.png";
                break;
            case Constants::IMPORTANCIA_ESP_MUY_ESCASA_ID:
                $icono = "especie_escasa.png";
                break;
            case Constants::IMPORTANCIA_RAREZA_NAC_CRIA_PROBABLE_ID:
                $icono = "rareza_cria_probable.png";
                break;
            case Constants::IMPORTANCIA_RAREZA_LOCAL_CRIA_PROBABLE_ID:
                $icono = "rareza_local_cria_probable.png";
                break;
            case Constants::IMPORTANCIA_ESP_PROTEGIDA_CRIA_PROBABLE_ID:
                $icono = "protegida_cria_probable.png";
                break;
            case Constants::IMPORTANCIA_ESP_ESCASA_CRIA_PROBABLE_ID:
                $icono = "escasa_cria_probable.png";
                break;
            case Constants::IMPORTANCIA_RAREZA_NAC_CRIA_SEGURA_ID:
                $icono = "rareza_cria.png";
                break;
            case Constants::IMPORTANCIA_RAREZA_LOCAL_CRIA_SEGURA_ID:
                $icono = "rareza_local_cria.png";
                break;
            case Constants::IMPORTANCIA_ESP_PROTEGIDA_CRIA_SEGURA_ID:
                $icono = "protegida_cria.png";
                break;
            case Constants::IMPORTANCIA_ESP_ESCASA_CRIA_SEGURA_ID:
                $icono = "escasa_cria.png";
                break;
            case Constants::IMPORTANCIA_NO_DESTACADO_ID:
                $icono = "";
                break;
            default:
                $icono = "";
                break;
        }
        
        if (! empty($icono)) {
            $out = "<img src='/img/icons/importancia/$icono' title='$importanciaDescripcion' alt='$importanciaDescripcion'/>";
        }
        
        return $out;
    }
    
    function getLastQuery() {
        $dbo = $this->Cita->getDatasource();
        $logs = $dbo->getLog();
        $lastLog = end($logs['log']);
        return $lastLog['query'];
    }
}

