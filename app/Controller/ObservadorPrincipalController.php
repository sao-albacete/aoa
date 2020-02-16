<?php

App::uses('AppController', 'Controller');
App::uses('Constants', 'Utility');

/**
 * Maneja la información de los observadores
 * 
 * @author vcanizares
 */
class ObservadorPrincipalController extends AppController {
    
    /**
     * Componentes
     */
    public $components = array();
    
    /**
     * Helpers
     */
    //public $helpers = array();
    
    /**
     * Nombre del controlador
     */
    public $name = 'ObservadorPrincipal';
    
    /**
     * Modelos
     */
    public $uses = array('ObservadorPrincipal');
    
    /**
     * Constantes
     */
    const ID_OPCION_MENU = Constants::MENU_OBSERVADORES_ID;

    public function beforeFilter()
    {
        parent::beforeFilter();

        $this->Auth->allow(
            'obtenerObservadoresPrincipales'
        );
    }
    
    
    /**
     * Funcion que se ejecuta al inicio
     */
    public function index() {
        
        // Opcion seleccionada del menu
        $this->set('id_opcion_seleccionada', $this::ID_OPCION_MENU);

        $observadores = $this->ObservadorPrincipal->getAllObservadoresPrincipalesBasic();

        $this->set('observadores', $observadores);
    }

    /**
     * Obtiene los observadores por codigo o nombre
     */
    public function obtenerObservadoresPrincipales() {
        
        $this->ObservadorPrincipal->recursive = -1;

        if ($this->request->is('ajax')) {

            $this->autoRender = false;
            $results = $this->ObservadorPrincipal->find(
                'all',
                [
                    'fields' => ['ObservadorPrincipal.id', 'ObservadorPrincipal.nombre', 'ObservadorPrincipal.codigo'],
                    'conditions' => [
                        'OR' => [
                            'ObservadorPrincipal.nombre LIKE ' => '%' . $this->request->query['term'] . '%',
                            'ObservadorPrincipal.codigo LIKE ' => '%' . $this->request->query['term'] . '%'
                        ]
                    ],
                    'recursive'=>-1
                ]);

            $observadoresEncontrados = [];
            foreach($results as $result) {
                $observadoresEncontrados[] = [
                    "id"=>$result['ObservadorPrincipal']['id'],
                    "value"=>$result['ObservadorPrincipal']['codigo']." - ".$result['ObservadorPrincipal']['nombre']
                ];
            }
            echo json_encode($observadoresEncontrados);
        }
    }
}
