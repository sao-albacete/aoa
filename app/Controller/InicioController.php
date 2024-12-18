<?php
App::uses('AppController', 'Controller');
App::uses('Constants', 'Utility');
App::uses('CabeceraUtil', 'Utility');

/**
 * Maneja la información a mostrar el la página de inicio
 *
 * @author vcanizares
 */
class InicioController extends AppController {

    /**
     * Nombre del controlador
     */
    public $name = 'Inicio';

    /**
     * Constantes
     */
    const ID_OPCION_MENU = Constants::MENU_INICIO_ID;

    /**
     * Componentes
     */
    public $components = array();

    /**
     * Helpers
     */
    public $helpers = array('ObservadorSecundario', 'ClaseEdadSexo', 'Importancia', 'Version');

    /**
     * Modelos
     */
    public $uses = array('Cita', 'Fichero', 'AsoCitaObservador', 'AsoCitaClaseEdadSexo', 'Municipio');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('ajaxData');
    }

    /**
     * Función que se ejecuta al carga la página inicial
     */
    public function index() {

        // Opcion seleccionada del menu
        $this->set('id_opcion_seleccionada', $this::ID_OPCION_MENU);

        /*
         * Obtiene las 10 últimas fotos
         */
        $ultimasFotos = $this -> Fichero -> obtenerFotosPortada(array('Fichero.fechaAlta'=> 'Desc'), 12);

        for ($index = 0 ; $index < count($ultimasFotos) ; $index++) {

            $conditions = array('Cita.id'=>$ultimasFotos[$index]['Cita']['id']);
            $fields = array('Cita.fechaAlta', 'Especie.nombreComun', 'Especie.genero', 'Especie.especie', 'Especie.subespecie', 'ObservadorPrincipal.nombre', 'ObservadorPrincipal.codigo', 'Lugar.municipio_id');

            $citaFoto = $this -> Cita -> obtenerCitas($conditions, $fields);
            $ultimasFotos[$index]['Cita'] = $citaFoto[0]['Cita'];
            $ultimasFotos[$index]['Especie'] = $citaFoto[0]['Especie'];
            $ultimasFotos[$index]['ObservadorPrincipal'] = $citaFoto[0]['ObservadorPrincipal'];

            // Municipio
            $municipio = $this->Municipio->read(null, $citaFoto[0]['Lugar']['municipio_id']);
            $ultimasFotos[$index]['Municipio'] = $municipio['Municipio'];
        }

        $this->set('ultimasFotos', $ultimasFotos);

        // Imagenes de cabecera
        $headerImages = [];
        $headerImages = array_merge($headerImages, CabeceraUtil::getHeaderImages(7));
        $this->set('headerImages', $headerImages);
    }
}
