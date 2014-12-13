<?php
App::uses('AppController', 'Controller');
App::uses('Constants', 'Utility');
App::uses('ImageUtil', 'Utility');

/**
 * Maneja la información a mostrar en la página de metodologia
 */
class MetodologiaController extends AppController {

    /**
     * Nombre del controlador
     */
    public $name = 'Metodologia';

    /**
     * Constantes
     */
    const ID_OPCION_MENU = Constants::MENU_ACERCA_DE_ID;

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
        'CriterioSeleccionCita',
        'Especie'
    );

    /**
     * Función que se ejecuta al carga la página inicial
     */
    public function index() {

        // Opcion seleccionada del menu
        $this->set('id_opcion_seleccionada', $this::ID_OPCION_MENU);

        // Criterios de seleccion de citas
        $criteriosSeleccion = $this->CriterioSeleccionCita->find('all');
        $this->set('criteriosSeleccion', $criteriosSeleccion);

        // Rarezas locales
        $rarezasLocales = $this->Especie->find(
            'all',
            [
                'conditions' => ['Especie.indRareza' => 2],
                'order' => ['Especie.codigoAerc' => 'ASC']
            ]);
        $this->set('rarezasLocales', $rarezasLocales);
    }
}