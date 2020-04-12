<?php
App::uses('AppModel', 'Model');
App::uses('StringUtil', 'Utility');

/**
 * Observadore Model
 *
 * @property Usuario $Usuario
 */
class ObservadorPrincipal extends AppModel
{

	/**
	 * Configuracion de base de datos
	 */
	public $useDbConfig = 'default';

	/**
	 * Nombre de tabla
	 */
	public $useTable = 'observador_principal';

	/**
	 * Campo identificativo
	 */
	public $displayField = 'nombre';

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'Cita' => array(
			'className' => 'Cita',
			'foreignKey' => 'observador_principal_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ObservadorSecundario' => array(
			'className' => 'ObservadorSecundario',
			'foreignKey' => 'observador_principal_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Lugar' => array(
			'className' => 'Lugar',
			'foreignKey' => 'observador_principal_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	/**
	 * Validaciones
	 */
	public $validate = array(
		'nombre' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'required' => true,
				'message' => 'El nombre completo es obligatorio.'
			),
			'maxLength' => array(
				'rule' => array('maxLength', 250),
				'message' => 'El tamaño máximo del nombre completo son 250 caracteres.'
			),
			'minLength' => array(
				'rule' => array('minLength', 10),
				'message' => 'El tamaño mínimo del nombre completo son 10 caracteres.'
			)
		),
		'codigo' => array(
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'El código introducido ya esta siendo usado.'
			),
			'minLength' => array(
				'rule' => array('minLength', 3),
				'message' => 'El tamaño mínimo del código son 3 caracteres.'
			),
			'maxLength' => array(
				'rule' => array('maxLength', 3),
				'message' => 'El tamaño máximo del código son 3 caracteres.'
			)
		)
	);


	public function obtenerNombre($id)
	{
		$this->id = $id;
		return $this->field('nombre');
	}

	public function getAllObservadoresPrincipalesBasic()
	{

		$observadores = $this->find('all', array(
			'fields' => array('ObservadorPrincipal.id', 'ObservadorPrincipal.nombre', 'ObservadorPrincipal.codigo'),
			'order' => array('ObservadorPrincipal.nombre ASC'),
			'recursive' => -1
		));

		return $observadores;
	}

	public function existObservadorPrincipalByCode($codigo)
	{

		$observadores = $this->find('count', array(
			'fields' => array('ObservadorPrincipal.id'),
			'conditions' => array('ObservadorPrincipal.codigo' => $codigo),
			'recursive' => -1
		));

		if ($observadores > 0) {
			return true;
		}

		return false;
	}

	/**
	 * Funcion que genera un codigo de observador a partir del nombre
	 *
	 * @param string $nombre
	 */
	public function generarCodigo($nombre)
	{

		$resultado = "";
		$codigoEncontrado = false;

		// Comprobamos que el nombre no sea nulo
		if (!empty ($nombre)) {

			// Normalizamos y eliminamos los espacios en blanco de la cadena
			$nombre = StringUtil::normaliza(str_replace(' ', '', $nombre));

			/*
			 * Cogemos las dos primeras letras e iteramos las siguientes letras hasta encontrar un código no existente
			 */
			for ($i = 2; $i < strlen($nombre); $i++) {

				$resultado = substr($nombre, 0, 2);

				$resultado .= substr($nombre, $i, 1);

				if (!$this->existObservadorPrincipalByCode($resultado)) {
					$codigoEncontrado = true;
					break;
				}
			}

			// Si hemos agotado todas las letras sin encontrar un codigo valido, iteramos del 1 al 9
			if (!$codigoEncontrado) {

				$resultado = substr($nombre, 0, 2);
				for ($i = 0; $i < 10; $i++) {

					$resultado .= $i;

					if (!$this->existObservadorPrincipalByCode($resultado)) {
						break;
					}
				}
			}
		}

		// Convertimos a mayuscula el resultado
		$resultado = strtoupper($resultado);

		return $resultado;
	}
}
