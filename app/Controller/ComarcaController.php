<?php

App::uses('AppController', 'Controller');
App::uses('Constants', 'Utility');

/**
 * Maneja la información de los municipios
 * 
 * @author vcanizares
 */
class ComarcaController extends AppController {
    
    /**
     * Nombre del controlador
     */
    public $name = 'Comarca';
    
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
    public $uses = array('Lugar', 'Comarca', 'Municipio');
    
    /**
     * Función que se ejecuta al carga la página inicial
     */
    public function index() {
        
        // Opcion seleccionada del menu
        $this->set('id_opcion_seleccionada', $this::ID_OPCION_MENU);

        /*
         * Comarcas
         */
        $comarcas = $this->Comarca->find('all', array(
            'fields' => array('Comarca.id', 'Comarca.nombre'),
            'conditions'=>array('Comarca.indActivo'=>1),
            'order'=>array('Comarca.nombre ASC'),
            'recursive'=>-1
        ));
        $this->set('comarcas', $comarcas);

        if ($this->request->is('post')) {

            if(isset($this->request->data["comarcaId"]) && !empty($this->request->data["comarcaId"])) {

                /*
                 * Lugares
                 */
                $lugares = $this->Lugar->find('all', array(
                    'fields' => array('Lugar.id', 'Lugar.nombre', 'CuadriculaUtm.codigo', 'CuadriculaUtm.id', 'Municipio.id', 'Municipio.nombre'),
                    'conditions'=>array('Lugar.indActivo'=>1, 'Lugar.comarca_id'=>$this->request->data["comarcaId"]),
                    'order'=>array('Lugar.nombre ASC')
                ));
                $this->set('lugares', $lugares);

                /*
                 * Municipios
                 */
                $municipios = $this->Municipio->find('all', array(
                    'fields' => array('Municipio.id','Municipio.nombre'),
                    'conditions'=>array('Comarca.id'=>$this->request->data["comarcaId"])
                ));
                $this->set('municipios', $municipios);

                /*
                 * Comarca
                 */
                $this->Comarca->id = $this->request->data["comarcaId"];
                $this->set('comarcaNombre', $this->Comarca->field('nombre'));
            }

            $this->set('valuesSubmited', $this->request->data);
        }
    }
}
