<?php

App::uses('AppController', 'Controller');
App::uses('Constants', 'Utility');
App::uses('StringUtil', 'Utility');

/**
 * Maneja la información de los observadores
 * 
 * @author vcanizares
 */
class ObservadorSecundarioController extends AppController {
    
    /**
     * Componentes
     */
    //public $components = [];
    
    /**
     * Helpers
     */
    //public $helpers = [];
    
    /**
     * Nombre del controlador
     */
    public $name = 'ObservadorSecundario';
    
    /**
     * Modelos
     */
    public $uses = array('ObservadorSecundario','AsoCitaObservador');
    
    /**
     * Constantes
     */
    const ID_OPCION_MENU = Constants::MENU_OBSERVADORES_ID;


    public function beforeFilter()
    {
        parent::beforeFilter();

        $this->Auth->allow(
            'obtenerObservadoresSecundarios'
        );
    }
    
    /**
     * Funcion que se ejecuta al inicio
     */
    public function index() {
        
        // Opcion seleccionada del menu
        $this->set('id_opcion_seleccionada', $this::ID_OPCION_MENU);

        $colaboradores = $this->ObservadorSecundario->getAllObservadoresSecundariosBasic();

        $this->set('colaboradores', $colaboradores);
    }
    
    /**
     * Funcion que se ejecuta al inicio
     */
    public function mis_colaboradores() {
        
        // Usuario
        $current_user = $this->Auth->user();

        $colaboradores = $this->ObservadorSecundario->find('all',
            array(
                'conditions' => array('ObservadorSecundario.observador_principal_id'=>$current_user['observador_principal_id']),
                'fields' => array('ObservadorSecundario.id', 'ObservadorSecundario.nombre', 'ObservadorSecundario.codigo'),
                'order'=>array('ObservadorSecundario.nombre ASC'),
                'recursive'=>-1
            )
        );

        $this->set('colaboradores', $colaboradores);
    }

    /**
     * Funcion que se ejecuta cuando queremos insertar un nuevo observador 
     */
    public function add() {
        
        if ($this->request->is('post')) {

            $current_user = $this->Auth->user();

            $this->ObservadorSecundario->create();

            $observadorSecunadrio['ObservadorSecundario']['nombre'] = $this->request->data["nombreColaborador"];
            $observadorSecunadrio['ObservadorSecundario']['codigo'] = $this->ObservadorSecundario->generarCodigo($this->request->data["nombreColaborador"]);
            $observadorSecunadrio['ObservadorSecundario']['observador_principal_id'] = $current_user['observador_principal_id'];

            $this->ObservadorSecundario->set($observadorSecunadrio);

            if ($this->ObservadorSecundario->validates()) {

                if ($this->ObservadorSecundario->save()) {
                    $this->Session->setFlash(__('El colaborador ha sido creado correctamente.'), 'success');

                    if (isset($this->request->data["controller"]) && isset($this->request->data["action"])) {
                        if(isset($this->request->data["idOrigen"])) {
                            $this->redirect(array('controller' => $this->request->data["controller"], 'action' => $this->request->data["action"], "id"=>$this->request->data["idOrigen"]));
                        }
                        else {
                            $this->redirect(array('controller' => $this->request->data["controller"], 'action' => $this->request->data["action"]));
                        }
                    }
                    else {
                        $this->redirect(array('action' => 'mis_colaboradores'));
                    }
                } else {
                    $this->Session->setFlash(__('El colaborador no ha podido crearse. Por favor, inténtelo de nuevo.'), 'failure');

                    if (isset($this->request->data["controller"]) && isset($this->request->data["action"])) {
                        if(isset($this->request->data["idOrigen"])) {
                            $this->redirect(array('controller' => $this->request->data["controller"], 'action' => $this->request->data["action"], "id"=>$this->request->data["idOrigen"]));
                        }
                        else {
                            $this->redirect(array('controller' => $this->request->data["controller"], 'action' => $this->request->data["action"]));
                        }
                    }
                    else {
                        $this->redirect(array('action' => 'mis_colaboradores'));
                    }
                }
            }
            else {

                $errors = $this->ObservadorSecundario->validationErrors;

                $errorsMessages = "";
                foreach ($errors as $validationError) {
                    $errorsMessages .= $validationError[0]."\n";
                }

                $this->Session->setFlash($errorsMessages, "failure");

                if (isset($this->request->data["controller"]) && isset($this->request->data["action"])) {
                    if(isset($this->request->data["idOrigen"])) {
                        $this->redirect(array('controller' => $this->request->data["controller"], 'action' => $this->request->data["action"], "id"=>$this->request->data["idOrigen"]));
                    }
                    else {
                        $this->redirect(array('controller' => $this->request->data["controller"], 'action' => $this->request->data["action"]));
                    }
                }
                else {
                    $this->redirect(array('action' => 'mis_colaboradores'));
                }
            }
        }
    }

    /**
     * Funcion que se ejecuta cuando queremos editar los datos de un observador ya existente 
     */
    public function edit() {
        
        if ($this->request->is('post')) {

            // Obtenemos el id del observador secundario a eliminar
            $this->ObservadorSecundario->id = $this->request->data['idColaborador'];

            if (!$this->ObservadorSecundario->exists()) {
                throw new NotFoundException(__('Colaborador no válido.'));
            }

            $observadorSecunadrio = $this->ObservadorSecundario->read(null, $this->ObservadorSecundario->id);
            $observadorSecunadrio['ObservadorSecundario']['nombre'] = $this->request->data["nombreColaborador"];

            $this->ObservadorSecundario->set($observadorSecunadrio);

            if ($this->ObservadorSecundario->validates()) {

                if ($this->ObservadorSecundario->save()) {
                    $this->Session->setFlash(__('El colaborador ha sido modificado correctamente.'), 'success');
                    $this->redirect(array('action' => 'mis_colaboradores'));
                } else {
                    $this->Session->setFlash(__('El colaborador no ha podido ser modificado. Por favor, inténtelo de nuevo.'), 'failure');
                    $this->redirect(array('action' => 'mis_colaboradores'));
                }
            }
            else {

                $errors = $this->ObservadorSecundario->validationErrors;

                $errorsMessages = "";
                foreach ($errors as $validationError) {
                    $errorsMessages .= $validationError[0]."\n";
                }

                $this->Session->setFlash($errorsMessages, "failure");
                $this->redirect(array('action' => 'mis_colaboradores'));
            }
        }
    }

    /**
     * Funcion que se ejecuta cuando queremos eliminar un observador previamente dado de alta
     */
    public function delete() {
        
        // Obtenemos el id del observador secundario a eliminar
        $this->ObservadorSecundario->id = $this->request->named['id'];
        $observadorSecundario = $this->ObservadorSecundario->read(null, $this->ObservadorSecundario->id);

        /*
         * Comprobamos si existe el colaborador
         */
        if (!$this->ObservadorSecundario->exists()) {
            throw new NotFoundException(__('Colaborador no válido.'));
        }

        /*
         * Comprobamos que el usuario que ejecuta la acción sea el mismo que dio de alta el observador secundario
         * o tenga rol administrador
         */
        $current_user = $this->Auth->user();
        if($observadorSecundario['ObservadorSecundario']['observador_principal_id'] != $current_user['observador_principal_id'] && $current_user['perfil_id'] > 1) {
            $this->Session->setFlash(__('No tiene permisos para realizar esta acción'), 'failure');
            $this->redirect(array('action' => 'mis_colaboradores'));
        }

        /*
         * Comprobamos que el observador secundario no esté asociado a ninguna cita
         */
        $citas = $this->AsoCitaObservador->obtenerCitasPorObservador($this->ObservadorSecundario->id, array('Cita.id'));
        if(count($citas) > 0) {
            $this->Session->setFlash(__('No se puede eliminar el colaborador ya que tiene citas asociadas'), 'failure');
            $this->redirect(array('action' => 'mis_colaboradores'));
        }

        /*
         * Eliminamos el observador secundario
         */
        if ($this->ObservadorSecundario->delete()) {
            $this->Session->setFlash(__('El colaborador ha sido eliminado.'), 'success');
            $this->redirect(array('action' => 'mis_colaboradores'));
        }

        /*
         * Si no se puede eliminar, mostramos un mensaje
         */
        $this->Session->setFlash(__('El colaborador no ha podido ser eliminado. Por favor, inténtelo de nuevo.'), 'failure');
        $this->redirect(array('action' => 'mis_colaboradores'));
    }

    /**
     * Obtiene los observadores secundarios por codigo y nombre
     */
    public function obtenerObservadoresSecundarios() {
    
        $this->ObservadorSecundario->recursive = -1;

        if ($this->request->is('ajax')) {

            $this->autoRender = false;

            if(!empty($this->request->query['data'])) {
                $observadoresIds = explode(",", $this->request->query['data']);
                $results = $this->ObservadorSecundario->find(
                    'all',
                    [
                        'fields' => ['ObservadorSecundario.id', 'ObservadorSecundario.nombre', 'ObservadorSecundario.codigo'],
                        'conditions' => [
                            'OR' => [
                                'ObservadorSecundario.nombre LIKE ' => '%' . $this->request->query['term'] . '%',
                                'ObservadorSecundario.codigo LIKE ' => '%' . $this->request->query['term'] . '%'
                            ],
                            'NOT'=>['ObservadorSecundario.id' => $observadoresIds]
                        ],
                        'recursive'=>-1
                    ]
                );
            }
            else {
                $results = $this->ObservadorSecundario->find(
                    'all',
                    [
                        'fields' => [
                            'ObservadorSecundario.id',
                            'ObservadorSecundario.nombre',
                            'ObservadorSecundario.codigo'
                        ],
                        'conditions' => ['OR' => [
                            'ObservadorSecundario.nombre LIKE ' => '%' . $this->request->query['term'] . '%',
                            'ObservadorSecundario.codigo LIKE ' => '%' . $this->request->query['term'] . '%']
                        ],
                        'recursive'=>-1
                    ]
                );
            }

            $observadoresEncontrados = [];
            foreach($results as $result) {
                $observadoresEncontrados[] = [
                    "id"=>$result['ObservadorSecundario']['id'],
                    "value"=>$result['ObservadorSecundario']['codigo']." - ".$result['ObservadorSecundario']['nombre']
                ];
            }
            echo json_encode($observadoresEncontrados);
        }
    }

    /**
     * Guarda un nuevo observador secundario usando una llamada asíncrona
     */
    public function addAjax() {

        $response = [];

        try {

            if ($this->request->is('ajax')) {

                $this->autoRender = false;

                $current_user = $this->Auth->user();

                $observadorSecunadrio['ObservadorSecundario']['nombre'] = $this->request->query["nombreColaborador"];
                $observadorSecunadrio['ObservadorSecundario']['codigo'] = $this->ObservadorSecundario->generarCodigo($this->request->query["nombreColaborador"]);
                $observadorSecunadrio['ObservadorSecundario']['observador_principal_id'] = $current_user['observador_principal_id'];

                $this->ObservadorSecundario->create();
                $this->ObservadorSecundario->set($observadorSecunadrio);

                if ($this->ObservadorSecundario->validates()) {

                    if ($this->ObservadorSecundario->save()) {

                        $observadorSecunadrio = $this->ObservadorSecundario->read(null, $this->ObservadorSecundario->id);

                        $response['status'] = 0;
                        $response['observadorSecunadrio'] = $observadorSecunadrio['ObservadorSecundario'];
                    }
                }
                else {
                    $response['status'] = 1;
                    $response['errores'] = $this->ObservadorSecundario->validationErrors;
                    CakeLog::info(sprintf('[%s] Errores de validación al crear observador secundario: %s', __METHOD__, print_r($this->ObservadorSecundario->validationErrors, true)));
                }
            }
        }
        catch(Exception $e) {
            $response['status'] = 1;
            CakeLog::error(sprintf('[%s] Errores inesperado al crear un observador secundario: %s', __METHOD__, $e->getMessage().$e->getTraceAsString()));
        }

        echo json_encode($response);
    }

    /**
     * Buscar observadores secundarios con un nombre similar
     */
    public function searchSimilarAjax() {

        $response = [];

        try {

            if ($this->request->is('ajax')) {

                $this->autoRender = false;

                $nombreColaborador = $this->request->query["nombreColaborador"];
                $nombreColaborador = StringUtil::normaliza(strtoupper($nombreColaborador));

                $observadoresSecundariosSimilares = $this->ObservadorSecundario->getListByConditions(
                    ['ObservadorSecundario.nombre' => $nombreColaborador],
                    ['ObservadorSecundario.id', 'ObservadorSecundario.codigo', 'ObservadorSecundario.nombre']);

                CakeLog::debug(sprintf('[%s] Observadores secundarios encontrados -> %s', __METHOD__, print_r($observadoresSecundariosSimilares, true)));

                $response['status'] = 0;
                $response['observadoresSecundariosSimilares'] = $observadoresSecundariosSimilares;
            }
        }
        catch(Exception $e) {
            $response['status'] = 1;
            CakeLog::error(sprintf('[%s] Errores inesperado al buscar observadores secundarios similares: %s', __METHOD__, $e->getMessage().$e->getTraceAsString()));
        }

        echo json_encode($response);
    }
}
