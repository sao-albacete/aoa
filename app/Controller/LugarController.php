<?php

App::uses('AppController', 'Controller');
App::uses('Constants', 'Utility');
App::uses('EmailUtil', 'Utility');

/**
 * Maneja la información de los lugares
 *
 * @author vcanizares
 */
class LugarController extends AppController {

    /**
     * Nombre del controlador
     */
    public $name = 'Lugar';

    /**
     * Constantes
     */
    const ID_OPCION_MENU = Constants::MENU_LOCALIZACION_ID;

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
        'Lugar',
        'Comarca',
        'Municipio',
        'CuadriculaUtm',
        'AsoCuadriculaUtmMunicipio',
        'Cita'
    );

    public function beforeFilter() {

        parent::beforeFilter();

        $this->Auth->allow(
            'index',
            'view',
            'cargarMunicipios',
            'cargarCoordenadasUtm',
            'cargarLugaresSimilares',
            'obtenerLugares',
            'obtenerLugar',
            'obtenerLugaresPorNombre',
            'guardarLugarAjax'
        );
    }

    /**
     * Función que se ejecuta al carga la página inicial
     */
    public function index() {

        // Opcion seleccionada del menu
        $this->set('id_opcion_seleccionada', $this::ID_OPCION_MENU);

        /*
         * Lugares
         */
        $lugares = $this->Lugar->find('all', array(
            'conditions'=>array('Lugar.indActivo'=>1),
            'order'=>array('Lugar.nombre ASC')
        ));
        $this->set('lugares', $lugares);
    }

    /**
     * Función que se ejecuta al carga la página inicial
     */
    public function mis_lugares() {

        // Usuario
        $current_user = $this->Auth->user();

        /*
         * Lugares
         */
        $lugares = $this->Lugar->find('all', array(
            'conditions'=>array('Lugar.indActivo'=>1, 'Lugar.observador_principal_id'=>$current_user['observador_principal_id']),
            'order'=>array('Lugar.nombre ASC')
        ));
        $this->set('lugares', $lugares);
    }

    public function add() {

        // Opcion seleccionada del menu
        $this->set('id_opcion_seleccionada', $this::ID_OPCION_MENU);

        if ($this->request->is('post')) {

            // Municipio
            $this->request->data["Lugar"]["municipio_id"] = $this->request->data["municipioId"];

            // Nombre
            $this->request->data["Lugar"]["nombre"] = $this->request->data["nombre"];

            // Cuadricula UTM- TODO: crear una fórmula que detecte el UTM a partir de las corodenadads lat/lng
            {
                $this->request->data["Lugar"]["cuadricula_utm_id"] = 1;
            }

            // Comarca
            {
                $this->Municipio->id = $this->request->data["municipioId"];
                $this->request->data["Lugar"]["comarca_id"] = $this->Municipio->field('comarca_id');
            }

            // Coordenadas UTM
            {
                $this->request->data["Lugar"]["lat"] = $this->request->data["lat"];
                $this->request->data["Lugar"]["lng"] = $this->request->data["lng"];
            }

            // Usuario
            $current_user = $this->Auth->user();
            $this->request->data["Lugar"]["observador_principal_id"] = $current_user['observador_principal_id'];

            // Indicador activo
            $this->request->data["Lugar"]["indActivo"] = 1;

            $this->Lugar->create();
            $this->Lugar->set($this->request->data);

            if($this->Lugar->validates()) {

                if ($this->Lugar->save()) {

                    $lugar = $this->Lugar->read(array('Lugar.id', 'Lugar.nombre'), $this->Lugar->id);

                    EmailUtil::enviarEmailNuevLugar($lugar, $current_user);

                    $this->Session->setFlash(__('El lugar ha sido creado correctamente.'), 'success');

                    if (isset($this->request->data["controller"]) && !empty($this->request->data["controller"])
                            && isset($this->request->data["action"]) && !empty($this->request->data["action"])) {
                        if(isset($this->request->data["idOrigen"]) && !empty($this->request->data["idOrigen"])) {
                            $this->redirect(array('controller' => $this->request->data["controller"], 'action' => $this->request->data["action"], 'id'=>$this->request->data["idOrigen"]));
                        }
                        else {
                            $this->redirect(array('controller' => $this->request->data["controller"], 'action' => $this->request->data["action"]));
                        }
                    }
                    else {
                        $this->redirect(array('controller' => 'Lugar', 'action' => 'edit', "id"=>$this->Lugar->id));
                    }

                } else {
                    $this->Session->setFlash(__('El lugar no ha podido ser creado. Por favor, inténtelo de nuevo.'), 'failure');

                    if (isset($this->request->data["controller"]) && !empty($this->request->data["controller"])
                            && isset($this->request->data["action"]) && !empty($this->request->data["action"])) {
                        if(isset($this->request->data["idOrigen"]) && !empty($this->request->data["idOrigen"])) {
                            $this->redirect(array('controller' => $this->request->data["controller"], 'action' => $this->request->data["action"], 'id'=>$this->request->data["idOrigen"]));
                        }
                        else {
                            $this->redirect(array('controller' => $this->request->data["controller"], 'action' => $this->request->data["action"]));
                        }
                    }
                    else {
                        $this->redirect(array('controller' => 'Lugar', 'action' => 'add'));
                    }
                }
            }
            else {
                $errors = $this->Lugar->validationErrors;

                $errorsMessages = "";
                foreach ($errors as $validationError) {
                    $errorsMessages .= $validationError[0]."\n";
                }

                $this->Session->setFlash($errorsMessages, "failure");

                if (isset($this->request->data["controller"]) && !empty($this->request->data["controller"])
                        && isset($this->request->data["action"]) && !empty($this->request->data["action"])) {
                    if(isset($this->request->data["idOrigen"]) && !empty($this->request->data["idOrigen"])) {
                        $this->redirect(array('controller' => $this->request->data["controller"], 'action' => $this->request->data["action"], 'id'=>$this->request->data["idOrigen"]));
                    }
                    else {
                        $this->redirect(array('controller' => $this->request->data["controller"], 'action' => $this->request->data["action"]));
                    }
                }
                else {
                    $this->redirect(array('controller' => 'Lugar', 'action' => 'add'));
                }
            }
        }
        elseif ($this->request->is('get')) {

            if(isset($this->request->named['controller'])) {
                $this->set('controller', $this->request->named['controller']);
            }
            if(isset($this->request->named['action'])) {
                $this->set('action', $this->request->named['action']);
            }
            if(isset($this->request->named['idOrigen'])) {
                $this->set('idOrigen', $this->request->named['idOrigen']);
            }
        }

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

    public function edit() {

        // Opcion seleccionada del menu
        $this->set('id_opcion_seleccionada', $this::ID_OPCION_MENU);

        /*
         * Usuario
         */
        $current_user = $this->Auth->user();

        if($this->request->is('get')) {

            // Recogemos los parámetros de la request
            $idLugar = $this->request->named['id'];

            // Obtenemos los datos del lugar
            $lugar = $this->Lugar->obtenerTodoPorId($idLugar);

            // Comprobamos si la cita existe
            if (! isset($lugar) || empty($lugar)) {
                throw new NotFoundException(sprintf('El lugar con id %s no existe', $idLugar));
            }

            //Comprobamos si el usuario que ejecuta la acción tiene permisos para editar la cita
            if (! $this->esLugarEditable($lugar, $current_user)) {
                throw new ForbiddenException(sprintf('El usuario con email %s no tiene permisos editar el lugar con id %s',$current_user['email'], $idLugar));
            }

            $this->set('lugar', $lugar);

            /*
             * Comprobamos que el usuario que ejecuta la acción sea el mismo que dio de alta el lugar o tenga rol administrador
             */
            if ($lugar['Lugar']['observador_principal_id'] != $current_user['observador_principal_id'] && $current_user['perfil_id'] > 1) {
                throw new Exception('No tiene permisos para editar este lugar', 400);
            }

            /*
             * Municipio
            */
            $municipios = $this->Municipio->obtenerMunicipiosActivosOrdenadosPorNombre();
            $this->set('municipios', $municipios);
        }
        elseif ($this->request->is('post')) {

            $lugar = $this->Lugar->obtenerTodoPorId($this->request->data["lugarId"]);

            // Comprobamos si la cita existe
            if (! isset($lugar) || empty($lugar)) {
                throw new NotFoundException(sprintf('El lugar con id %s no existe', $this->request->data["lugarId"]));
            }

            //Comprobamos si el usuario que ejecuta la acción tiene permisos para editar la cita
            if (! $this->esLugarEditable($lugar, $current_user)) {
                throw new ForbiddenException(sprintf('El usuario con email %s no tiene permisos editar el lugar con id %s',$current_user['email'], $this->request->data["lugarId"]));
            }

            /*
             * Comprobamos que el usuario que ejecuta la acción sea el mismo que dio de alta el lugar
            * o tenga rol administrador
            */
            if($lugar['Lugar']['observador_principal_id'] != $current_user['observador_principal_id'] && $current_user['perfil_id'] > 1) {
                throw new Exception('No tiene permisos para editar este lugar', 400);
            }

            // Municipio
            $lugar["Lugar"]["municipio_id"] = $this->request->data["municipioId"];

            // Nombre
            $lugar["Lugar"]["nombre"] = $this->request->data["nombre"];

            // Coordenadas Lugar
            {
                $lugar["Lugar"]["lat"] = $this->request->data["lat"];
                $lugar["Lugar"]["lng"] = $this->request->data["lng"];
            }

            // Comarca
            {
                $this->Municipio->id = $this->request->data["municipioId"];
                $lugar["Lugar"]["comarca_id"] = $this->Municipio->field('comarca_id');
            }

            $this->Lugar->create();
            $this->Lugar->set($lugar);

            if($this->Lugar->validates()) {

                if ($this->Lugar->save()) {
                    $this->Session->setFlash(__('El lugar ha sido modificado correctamente.'), 'success');
                    $this->redirect(array('action' => 'edit', "id"=>$this->Lugar->id));
                } else {
                    $this->Session->setFlash(__('El lugar no ha podido ser modificado. Por favor, inténtelo de nuevo.'), 'failure');
                    $this->redirect(array('action' => 'edit', "id"=>$this->Lugar->id));
                }
            }
            else {
                $errors = $this->Lugar->validationErrors;

                $errorsMessages = "";
                foreach ($errors as $validationError) {
                    $errorsMessages .= $validationError[0]."\n";
                }

                $this->Session->setFlash($errorsMessages, "failure");
                $this->redirect(array('action' => 'edit', "id"=>$this->Lugar->id));
            }
        }
    }

    public function view() {

        // Opcion seleccionada del menu
        $this->set('id_opcion_seleccionada', $this::ID_OPCION_MENU);

        // Recogemos los parámetros de la request
        $idLugar = $this->request->named['id'];

        // Obtenemos los datos del lugar
        $lugar = $this->Lugar->obtenerTodoPorId($idLugar);

        // Comprobamos si la cita existe
        if (! isset($lugar) || empty($lugar)) {
            throw new NotFoundException(sprintf('El lugar con id %s no existe', $idLugar));
        }

        // Comprobamos si el usuario que ejecuta la acción tiene permisos para editar la cita
        if (! $this->esLugarVisible($lugar)) {
            throw new ForbiddenException(sprintf('El lugar con id %s no es visible',$idLugar));
        }

        $this->set('lugar', $lugar);
    }

    /**
     * Funcion que se ejecuta cuando queremos eliminar un lugar previamente dado de alta
     */
    public function delete() {

        $current_user = $this->Auth->user();

        // Obtenemos el id del lugar a eliminar
        $this->Lugar->id = $this->request->named['id'];

        // Comprobamos si existe el lugar
        if (! $this->Lugar->exists()) {
            throw new NotFoundException(sprintf('El lugar con id %s no existe', $this->request->named['id']));
        }

        $lugar = $this->Lugar->read(null, $this->Lugar->id);

        // Comprobamos si el usuario que ejecuta la acción tiene permisos para editar la cita
        if (! $this->esLugarEditable($lugar, $current_user)) {
            throw new ForbiddenException(sprintf('El usuario con email %s no tiene permisos editar el lugar con id %s',$current_user['email'], $this->request->named['id']));
        }

        /*
         * Comprobamos que el usuario que ejecuta la acción sea el mismo que dio de alta el lugar
         * o tenga rol administrador
         */
        if($lugar['Lugar']['observador_principal_id'] != $current_user['observador_principal_id'] && $current_user['perfil_id'] > 1) {
            $this->Session->setFlash(__('No tiene permisos para realizar esta acción'), 'failure');
            $this->redirect(array('action' => 'mis_lugares'));
        }

        // Comprobamos que el lugar no esté asociado a ninguna cita
        $citas = $this->Cita->obtenerTotalCitasPorLugar($this->Lugar->id);
        if($citas > 0) {
            $this->Session->setFlash(__('No se puede eliminar el lugar ya que tiene citas asociadas'), 'failure');
            $this->redirect(array('action' => 'mis_lugares'));
        }

        // Eliminamos el lugar
        if ($this->Lugar->delete()) {
            $this->Session->setFlash(__('El lugar ha sido eliminado.'), 'success');
            $this->redirect(array('action' => 'mis_lugares'));
        }

        // Si no se puede eliminar, mostramos un mensaje
        $this->Session->setFlash(__('El lugar no ha podido ser eliminado. Por favor, inténtelo de nuevo.'), 'failure');
        $this->redirect(array('action' => 'mis_lugares'));
    }

    public function cargarLugaresSimilares() {

        if ($this->request->is('ajax')) {

            $this->autoRender = false;

            $codigoCuadriculaUtm = $this->request->query["codigoCuadriculaUtm"];
            $cuadriculaUtm = $this->CuadriculaUtm->obtenerDatosBasicosCuadriculaUtmPorCodigo($codigoCuadriculaUtm);

            $municipioId = $this->request->query["municipioId"];

            $lugaresSimilares = $this->Lugar->obtenerLugaresPorMunicipioYCodigoCuadriculaUtm($cuadriculaUtm['CuadriculaUtm']['id'], $municipioId);

            echo json_encode($lugaresSimilares);
        }
    }

    /**
     * Guarda un nuevo lugar usando una llamada asíncrona
     */
    public function guardarLugarAjax() {

        $response = [];

        if ($this->request->is('ajax')) {

            $this->autoRender = false;

            // Municipio
            $this->request->data["Lugar"]["municipio_id"] = $this->request->query["municipioId"];

            // Nombre
            $this->request->data["Lugar"]["nombre"] = $this->request->query["nombreLugar"];


            // Comarca
            {
                $this->Municipio->id = $this->request->query["municipioId"];
                $this->request->data["Lugar"]["comarca_id"] = $this->Municipio->field('comarca_id');
            }
            // Cuadricula UTM. TODO: recalcular a partir de las coordenadas o eliminar campo
            {
                $this->request->data["Lugar"]["cuadricula_utm_id"] = 1;
            }
            // Coordenadas
            {
                $this->request->data["Lugar"]["lat"] = $this->request->query["lat"];
                $this->request->data["Lugar"]["lng"] = $this->request->query["lng"];
            }

            // Usuario
            $current_user = $this->Auth->user();
            $this->request->data["Lugar"]["observador_principal_id"] = $current_user['observador_principal_id'];

            // Indicador activo
            $this->request->data["Lugar"]["indActivo"] = 1;

            $this->Lugar->create();
            $this->Lugar->set($this->request->data);

            if($this->Lugar->validates()) {

                if ($this->Lugar->save()) {

                    $lugar = $this->Lugar->read(null, $this->Lugar->id);

                    EmailUtil::enviarEmailNuevLugar($lugar, $current_user);

                    $response['status'] = 0;
                    $response['lugar'] = $lugar;
                }
            } else {
                $response['status'] = 1;
                $response['errores'] = $this->Lugar->validationErrors;
                CakeLog::info(sprintf('[%s] Errores de validación al crear lugar: %s', __METHOD__, print_r($this->Lugar->validationErrors, true)));
            }
        }

        echo json_encode($response);
    }

    /**
     * Obtiene los lugares que coincidan en su nombre, municipio, comarca o cuadricula UTM con el valor recibido
     */
    public function obtenerLugares() {

        $response = [];

        if ($this->request->is('ajax')) {

            $this->autoRender = false;

            $results = $this->Lugar->find(
                'all',
                [
                    'fields' => [
                        'Lugar.id',
                        'Lugar.nombre',
                        'Municipio.nombre',
                        'Comarca.nombre',
                        'CuadriculaUtm.codigo'
                    ],
                    'conditions' => [
                        'OR' => [
                            'Lugar.nombre LIKE ' => '%' . $this->request->query['term'] . '%',
                            'Municipio.nombre LIKE ' => '%' . $this->request->query['term'] . '%',
                            'Comarca.nombre LIKE ' => '%' . $this->request->query['term'] . '%',
                            'CuadriculaUtm.codigo LIKE ' => '%' . $this->request->query['term'] . '%'
                        ]
                    ]
                ]
            );

            $lugaresEncontrados = [];
            foreach($results as $result) {
                $lugaresEncontrados[] = [
                    "id" => $result['Lugar']['id'],
                    "value" => $result['Lugar']['nombre'].", ".$result['Municipio']['nombre'].", ".$result['Comarca']['nombre'].", ".$result['CuadriculaUtm']['codigo']
                ];
            }

            echo json_encode($lugaresEncontrados);
        }
    }

    /**
     * Obtiene los lugares que coincidan en su nombre, municipio, comarca o cuadricula UTM con el valor recibido
     */
    public function obtenerLugar() {

        $response = [];

        if ($this->request->is('ajax')) {

            $this->autoRender = false;

            $results = $this->Lugar->find(
                'all',
                [
                    'fields' => [
                        'Lugar.id',
                        'Lugar.nombre',
                        'Lugar.lng',
                        'Municipio.nombre',
                        'Comarca.nombre',
                        'Lugar.lat',
                    ],
                    'conditions' => [
                        'Lugar.id = ' => $this->request->query['id']
                    ]
                ]
            );

            $lugaresEncontrados = [];
            foreach($results as $result) {
                $lugaresEncontrados[] = [
                    "id" => $result['Lugar']['id'],
                    "nombre" => $result['Lugar']['nombre'],
                    "municipio" => $result['Municipio']['nombre'],
                    "comarca" => $result['Comarca']['nombre'],
                    "lat" => $result['Lugar']['lat'],
                    "lng" => $result['Lugar']['lng']
                ];
            }

            echo json_encode($lugaresEncontrados);
        }
    }

// .", "
    /**
     * Obtiene los lugares que coincidan en su nombre
     */
    public function obtenerLugaresPorNombre() {

        if ($this->request->is('ajax')) {

            $this->autoRender = false;

            $results = $this->Lugar->find(
                'all',
                [
                    'fields' => [
                        'Lugar.id',
                        'Lugar.nombre',
                    ],
                    'conditions' => [
                        'OR' => [
                            'Lugar.nombre LIKE ' => '%' . $this->request->query['term'] . '%',
                        ]
                    ],
                    'recursive' => -1
                ]
            );

            $lugaresEncontrados = [];
            foreach($results as $result) {
                $lugaresEncontrados[] = [
                    "id" => $result['Lugar']['id'],
                    "value" => $result['Lugar']['nombre']
                ];
            }
            echo json_encode($lugaresEncontrados);
        }
    }

    /**
     * Comprueba si el lugar es editable
     *
     * @param array $lugar
     * @param array $usuario
     * @return bool
     */
    private function esLugarEditable($lugar, $usuario)
    {
        return
            ($lugar['Lugar']['observador_principal_id'] == $usuario['observador_principal_id']
                || $usuario['perfil_id'] == 1)
            && $lugar['Lugar']['indActivo'] == 1;
    }

    /**
     * Comprueba si el lugar es visible
     *
     * @param array $lugar
     * @return bool
     */
    private function esLugarVisible($lugar)
    {
        return $lugar['Lugar']['indActivo'] == 1;
    }
}
