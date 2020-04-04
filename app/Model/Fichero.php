<?php
App::uses('AppModel', 'Model');
App::uses('FicheroUtility', 'Utility');

/**
 * Fichero Model
 *
 * @property Cita $Cita
 * @property User $Usuario
 */
class Fichero extends AppModel
{

	/**
	 * Use database config
	 *
	 * @var string
	 */
	public $useDbConfig = 'default';

	/**
	 * Use table
	 *
	 * @var mixed False or table name
	 */
	public $useTable = 'fichero';

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'nombre';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Cita' => array(
			'className' => 'Cita',
			'foreignKey' => 'cita_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
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
				'message' => 'El nombre es obligatorio.'
			),
			'maxLength' => array(
				'rule' => array('maxLength', 100),
				'message' => 'El tamaño máximo del nombre son 100 caracteres.'
			)
		),
		'descripcion' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 500),
				'message' => 'El tamaño máximo de la descripción son 500 caracteres.'
			)
		),
		'ruta' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'required' => true,
				'message' => 'La ruta es obligatoria.'
			),
			'maxLength' => array(
				'rule' => array('maxLength', 250),
				'message' => 'El tamaño máximo de la ruta son 250 caracteres.'
			)
		),
		'tipoMime' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'required' => true,
				'message' => 'El tipo MIME es obligatorio.'
			),
			'maxLength' => array(
				'rule' => array('maxLength', 100),
				'message' => 'El tamaño máximo del tipo MIME son 100 caracteres.'
			)
		),
		'nombreFisico' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'required' => true,
				'message' => 'El nombre físico es obligatorio.'
			),
			'maxLength' => array(
				'rule' => array('maxLength', 50),
				'message' => 'El tamaño máximo del nombre físico son 50 caracteres.'
			)
		),
		'fechaAlta' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'required' => true,
				'message' => 'La fecha es obligatoria.'
			),
			'date' => array(
				'rule' => array('datetime', 'ymd'),
				'required' => true,
				'message' => 'Debe introducir una fecha de observación con formato correcto (dd/mm/aaaa).'
			)
		)
	);

	public function obtenerFotosPortada($orden, $limite)
	{

		$fotos = $this->find(
			'all',
			array(
				'conditions' => array('Fichero.indImagenPortada' => 1),
				'order' => $orden,
				'limit' => $limite
			)
		);

		return $fotos;
	}

	public function contarFotosPorEspecie($especieId)
	{
		$fotos = $this->find(
			'count',
			array(
				'conditions' => array('Cita.especie_id' => $especieId),
			)
		);

		return $fotos;
	}

	public function obtenerFotosPorEspecie($especieId, $start, $length)
	{
		$fotos = $this->find(
			'all',
			array(
				'conditions' => array('Cita.especie_id' => $especieId),
				'order' => array('Fichero.fechaAlta'=> 'Desc'),
				'limit' => $length,
				'offset' => $start,
			)
		);

		return $fotos;
	}

	public function subirImagenCita($fichero, $cita, $usuarioId, $esImagenPortada = 0)
	{

		try {

			// Comprobamos si la imagen se ha enviado correctamente por POST
			if ($fichero["error"] > 0) {
				CakeLog::error("Se ha producido un error al subir la imagen. Código de error: " . $fichero["error"]);
				return false;
			} else {
				// Extension de la imagen subida
				$imageExtension = explode(".", $fichero["name"]);
				$imageExtension = end($imageExtension);
				$imageExtension = strtolower($imageExtension);

				// Nombre de la imagen
				$nombre_fisico = uniqid() . "_" . $cita["Cita"]["id"] . "." . $imageExtension;

				// Ruta donde se ubicará la imagen
				$imageAbsolutePath = IMAGES . 'users/' . $usuarioId . "/";
				$imageRelativePath = '/' . IMAGES_URL . 'users/' . $usuarioId . "/";

				// Validamos la imagen
				if (FicheroUtility::validar_imagen($nombre_fisico, $imageExtension, $imageAbsolutePath, $fichero["type"], $fichero["tmp_name"])) {

					// Seteamos los datos recibidos
					$imagen['Fichero']['nombreFisico'] = $nombre_fisico;
					$imagen['Fichero']['nombre'] = $fichero["name"];
					$imagen['Fichero']['fechaAlta'] = $cita["Cita"]["fechaAlta"];
					$imagen['Fichero']['cita_id'] = $cita["Cita"]["id"];
					$imagen['Fichero']['tipoMime'] = $fichero["type"];
					$imagen['Fichero']['ruta'] = $imageRelativePath;
					$imagen['Fichero']['indImagenPortada'] = $esImagenPortada;

					$this->create();
					$this->set($imagen);

					if ($this->validates()) {
						$this->save($imagen);
					} else {
						CakeLog::write('error', $this->invalidFields());
						return false;
					}
				} else {
					CakeLog::write('error', "Error procesando la imagen.");
					return false;
				}
			}
		} catch (Exception $e) {
			// Eliminamos el fichero generado
			if (file_exists($imageAbsolutePath . $nombre_fisico)) {
				unlink($imageAbsolutePath . $nombre_fisico);
			}

			CakeLog::error(sprintf('[%s] Hubo un error inesperado al intentar subir una imagen', __METHOD__), $e);
		}

		return true;
	}

	public function subirAvatar($fichero, $usuarioId, $avatarId)
	{

		try {

			// Comprobamos si la imagen se ha enviado correctamente por POST
			if ($fichero["error"] > 0) {
				CakeLog::error("Se ha producido un error al subir la imagen. Código de error: " . $fichero["error"]);
				return false;
			} else {

				// Extension de la imagen subida
				$imageExtension = explode(".", $fichero["name"]);
				$imageExtension = end($imageExtension);
				$imageExtension = strtolower($imageExtension);

				// Nombre de la imagen
				$nombre_fisico = "avatar." . $imageExtension;

				// Ruta donde se ubicará la imagen
				$imageAbsolutePath = IMAGES . 'users/' . $usuarioId . "/";
				$imageRelativePath = '/' . IMAGES_URL . 'users/' . $usuarioId . "/";

				// Validamos la imagen
				if (FicheroUtility::validar_imagen($nombre_fisico, $imageExtension, $imageAbsolutePath, $fichero["type"], $fichero["tmp_name"], 200)) {

					if ($avatarId == null || !$this->exists($avatarId)) {

						// Seteamos los datos recibidos
						$imagen['Fichero']['nombreFisico'] = $nombre_fisico;
						$imagen['Fichero']['nombre'] = $fichero["name"];
						$imagen['Fichero']['fechaAlta'] = date('Y-m-d H:i:s');
						$imagen['Fichero']['tipoMime'] = $fichero["type"];
						$imagen['Fichero']['ruta'] = $imageRelativePath;

						$this->create();
						$this->set($imagen);
					} else {
						$this->read(null, $avatarId);
						$this->set('nombreFisico', $nombre_fisico);
						$this->set('nombre', $fichero["name"]);
						$this->set('fechaAlta', date('Y-m-d H:i:s'));
						$this->set('tipoMime', $fichero["type"]);
					}

					if ($this->validates()) {
						$this->save($imagen);

						return $this->id;
					} else {
						CakeLog::write('error', print_r($this->invalidFields(), true));
					}
				} else {
					CakeLog::write('error', "Error procesando la imagen.");
				}
			}
		} catch (Exception $e) {
			// Eliminamos el fichero generado
			if (file_exists($imageAbsolutePath . $nombre_fisico)) {
				unlink($imageAbsolutePath . $nombre_fisico);
			}

			CakeLog::write('error', $e->getTraceAsString());
		}
	}

	public function reArrayFiles(&$file_post)
	{

		$file_ary = array();
		$file_count = count($file_post['name']);
		$file_keys = array_keys($file_post);

		for ($i = 0; $i < $file_count; $i++) {
			foreach ($file_keys as $key) {
				$file_ary[$i][$key] = $file_post[$key][$i];
			}
		}

		return $file_ary;
	}

	/**
	 * Comprueba si una cita tiene fotos asociadas
	 *
	 * @param $citaId
	 * @return boolean
	 */
	public function tieneFotos($citaId)
	{

		$conditions = [
			'Fichero.cita_id' => $citaId,
		];

		$ficheros = $this->find(
			'count',
			[
				'conditions' => $conditions,
			]
		);

		return $ficheros > 0;
	}
}
