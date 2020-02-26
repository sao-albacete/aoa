<?php
App::uses('AppController', 'Controller');
App::uses('Constants', 'Utility');

/**
 * Maneja la información a mostrar el la página de ayuda
 * 
 * @author vcanizares
 */
class AyudaController extends AppController {
	
	/**
	 * Nombre del controlador
	 */
	public $name = 'Ayuda';
	
	/**
	 * Constantes
	 */
	const ID_OPCION_MENU = Constants::MENU_AYUDA_ID;
	
	/**
	 * Componentes
	 */
	public $components = array();
	
	/**
	 * Helpers
	 */
// 	public $helpers = array();
	
	/**
	 * Modelos
	 */
// 	public $uses = array();
	
	
	/**
	 * Función que se ejecuta al carga la página inicial
	 */
	public function index() {
		// Opcion seleccionada del menu
		$this->set('id_opcion_seleccionada', $this::ID_OPCION_MENU);
	}
}
