<?php

App::uses('AppController', 'Controller');
App::uses('Constants', 'Utility');

/**
 * Maneja la información de los municipios
 * 
 * @author vcanizares
 */
class CuadriculaUtmController extends AppController {
    
    /**
     * Nombre del controlador
     */
    public $name = 'CuadriculaUtm';
    
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
    public $uses = array('Lugar', 'Comarca', 'Municipio', 'CuadriculaUtm', 'AsoCuadriculaUtmMunicipio');
    
    /**
     * Función que se ejecuta al carga la página inicial
     */
    public function index() {
        
        // Opcion seleccionada del menu
        $this->set('id_opcion_seleccionada', $this::ID_OPCION_MENU);

        /*
         * Cuadriculas UTM
         */
        $cuadriculasUtm = $this->CuadriculaUtm->find('all', array(
            'fields' => array('CuadriculaUtm.id', 'CuadriculaUtm.codigo'),
            'conditions'=>array('CuadriculaUtm.indActivo'=>1),
            'order'=>array('CuadriculaUtm.codigo ASC'),
            'recursive'=>-1
        ));
        $this->set('cuadriculasUtm', $cuadriculasUtm);

        if ($this->request->is('post')) {

            if(isset($this->request->data["cuadriculaUtmId"]) && !empty($this->request->data["cuadriculaUtmId"])) {

                /*
                 * Lugares
                 */
                $lugares = $this->Lugar->find('all', array(
                    'fields' => array('Lugar.id', 'Lugar.nombre', 'Comarca.nombre', 'Comarca.id', 'Municipio.id', 'Municipio.nombre'),
                    'conditions'=>array('Lugar.indActivo'=>1, 'Lugar.cuadricula_utm_id'=>$this->request->data["cuadriculaUtmId"]),
                    'order'=>array('Lugar.nombre ASC')
                ));
                $this->set('lugares', $lugares);

                /*
                 * Municipios
                 */
                $municipios = $this->AsoCuadriculaUtmMunicipio->find('all', array(
                    'fields' => array('Municipio.id','Municipio.nombre','Municipio.comarca_id'),
                    'conditions'=>array('AsoCuadriculaUtmMunicipio.cuadricula_utm_id'=>$this->request->data["cuadriculaUtmId"]),
                    'order'=>array('Municipio.nombre')
                ));
                $this->set('municipios', $municipios);

                /*
                 * Comarcas
                 */
                $comarcas = array();
                foreach ($municipios as $municipio) {

                    $comarca = $this->Comarca->find('first', array(
                        'conditions'=>array('Comarca.id'=>$municipio['Municipio']['comarca_id']),
                        'recursive'=>-1
                    ));
                    if (! in_array($comarca, $comarcas)) {
                        array_push($comarcas, $comarca);
                    }
                }
                $this->set('comarcas', $comarcas);

                /*
                 * Cuadricula UTM
                 */
                $this->CuadriculaUtm->id = $this->request->data["cuadriculaUtmId"];
                $this->set('cuadriculaUtmCodigo', $this->CuadriculaUtm->field('codigo'));
            }

            $this->set('valuesSubmited', $this->request->data);
        }
    }
    
    public function cargarDatosCoordenadaUtm() {
    
        if ($this->request->is('ajax')) {

            $this->autoRender = false;

            $codigoCuadriculaUtm = $this->request->query["codigoCuadriculaUtm"];

            $cuadriculaUtm = $this->CuadriculaUtm->obtenerDatosBasicosCuadriculaUtmPorCodigo($codigoCuadriculaUtm);

            echo json_encode($cuadriculaUtm);
        }
    }
}
