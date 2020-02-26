<?php

App::uses('AppController', 'Controller');
App::uses('Constants', 'Utility');

/**
 * Maneja la información de los municipios
 * 
 * @author vcanizares
 */
class MunicipioController extends AppController {
    
    /**
     * Nombre del controlador
     */
    public $name = 'Municipio';
    
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
    public $uses = array('Lugar','Municipio','CuadriculaUtm','AsoCuadriculaUtmMunicipio');
    
    
    /**
     * Función que se ejecuta al carga la página inicial
     */
    public function index() {
        
        // Opcion seleccionada del menu
        $this->set('id_opcion_seleccionada', $this::ID_OPCION_MENU);

        /*
         * Municipios
         */
        $municipios = $this->Municipio->find('all', array(
            'fields' => array('Municipio.id', 'Municipio.nombre'),
            'conditions'=>array('Municipio.indActivo'=>1),
            'order'=>array('Municipio.nombre ASC'),
            'recursive'=>-1
        ));
        $this->set('municipios', $municipios);

        if ($this->request->is('post')) {

            if(isset($this->request->data["municipioId"]) && !empty($this->request->data["municipioId"])) {

                /*
                 * Lugares
                 */
                $lugares = $this->Lugar->find('all', array(
                    'fields' => array('Lugar.id', 'Lugar.nombre', 'CuadriculaUtm.codigo', 'CuadriculaUtm.id'),
                    'conditions'=>array('Lugar.indActivo'=>1, 'Lugar.municipio_id'=>$this->request->data["municipioId"]),
                    'order'=>array('Lugar.nombre ASC')
                ));
                $this->set('lugares', $lugares);

                /*
                 * Municipio
                 */
                $municipio = $this->Municipio->find('first', array(
                    'fields' => array('Municipio.nombre', 'Comarca.nombre'),
                    'conditions'=>array('Municipio.id'=>$this->request->data["municipioId"])
                ));
                $this->set('municipioNombre', $municipio['Municipio']['nombre']);
                $this->set('comarca', $municipio['Comarca']['nombre']);
            }

            $this->set('valuesSubmited', $this->request->data);
        }
    }
    
    public function cargarMunicipios() {
    
        if ($this->request->is('ajax')) {

            $this->autoRender = false;

            $codigoCuadriculaUtm = $this->request->params['named']['codigoCuadriculaUtm'];

            $cuadriculaUtm = $this->CuadriculaUtm->obtenerDatosBasicosCuadriculaUtmPorCodigo($codigoCuadriculaUtm);

            $results = $this->AsoCuadriculaUtmMunicipio->obtenerMunicipiosPorCuadriculaUtm($cuadriculaUtm['CuadriculaUtm']['id']);

            echo '<option value="">'.__("-- Seleccione --").'</option>';

            foreach($results as $result) {
                echo '<option value="'.$result['Municipio']['id'].'">'.$result['Municipio']['nombre'].'</option>';
            }
        }
    }
    
    public function obtenerDatosMunicipio() {
        
        if ($this->request->is('ajax')) {

            $this->autoRender = false;

            $municipioId = $this->request->query['municipioId'];

            $municipio = $this->Municipio->read(null, $municipioId);

            echo json_encode($municipio);
        }
    }
}
