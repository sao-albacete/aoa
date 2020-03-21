<?php
App::uses('AppModel', 'Model');
App::uses('StringUtil', 'Utility');

/**
 * ObservadorSecundario Model
 *
 * @property Usuario $Usuario
 */
class ObservadorSecundario extends AppModel {

    /**
     * Configuracion de base de datos
     */
    public $useDbConfig = 'default';

    /**
     * Nombre de tabla
     */
    public $useTable = 'observador_secundario';

    /**
     * Campo identificativo
     */
    public $displayField = 'nombre';

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'ObservadorPrincipal' => array(
            'className' => 'ObservadorPrincipal',
            'foreignKey' => 'observador_principal_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'AsoCitaObservador' => array(
            'className' => 'AsoCitaObservador',
            'foreignKey' => 'observador_secundario_id',
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
        'codigo' =>array(
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

    public function getAllObservadoresSecundariosBasic() {

        $observadores = $this->find('all', array(
            'fields' => array('ObservadorSecundario.id', 'ObservadorSecundario.nombre', 'ObservadorSecundario.codigo'),
            'order'=>array('ObservadorSecundario.nombre ASC'),
            'recursive'=>-1
        ));

        return $observadores;
    }

    public function getObservadorSecundarioBasic($id) {

        $observadores = $this->find('first', array(
                'conditions' => array('ObservadorSecundario.id'=>$id),
                'recursive'=>-1
        ));

        return $observadores;
    }

    public function getObservadoresSecundariosByNombre($nombre) {

        $nombre = StringUtil::normaliza(strtoupper($nombre));

        $observadores = $this->find('list', array(
            'fields' => array('ObservadorSecundario.id'),
            'conditions' => array('ObservadorSecundario.nombre'=>$nombre),
            'recursive'=>-1
        ));

        return $observadores;
    }

	public function getObservadoresSecundariosByCode($code) {

		$nombre = StringUtil::normaliza(strtoupper($code));

		$observadores = $this->find('list', array(
			'fields' => array('ObservadorSecundario.id'),
			'conditions' => array('ObservadorSecundario.codigo'=>$code),
			'recursive'=>-1
		));

		return $observadores;
	}

    public function existObservadorSecundarioByCode($codigo) {

        $observadores = $this->find('count', array(
                'fields' => array('ObservadorSecundario.id'),
                'conditions' => array('ObservadorSecundario.codigo' => $codigo),
                'recursive'=>-1
        ));

        if($observadores > 0) {
            return true;
        }

        return false;
    }

    public function getListByConditions($conditions = [], $fields = [], $recursive = -1)
    {
        $observadores = $this->find('all', array(
            'fields' => $fields,
            'conditions' => $conditions,
            'recursive' => $recursive
        ));

        return $observadores;
    }

    /**
     * Funcion que genera un codigo de observador a partir del nombre
     *
     * @param string $nombre
     */
    public function generarCodigo($nombre) {

        $resultado = "";
        $codigoEncontrado = false;

        // Comprobamos que el nombre no sea nulo
        if (! empty ( $nombre )) {

            // Normalizamos y eliminamos los espacios en blanco de la cadena
            $nombre = StringUtil::normaliza ( str_replace(' ', '', $nombre) );

            /*
             * Cogemos las dos primeras letras e iteramos las siguientes letras hasta encontrar un código no existente
             */
            for($i = 2; $i < strlen($nombre); $i++) {

                $resultado = substr($nombre, 0, 2);
                $resultado .= substr($nombre, $i, 1);

                if (! $this->existObservadorSecundarioByCode ( $resultado )) {
                    $codigoEncontrado = true;
                    break;
                }
            }

            // Si hemos agotado todas las letras sin encontrar un codigo valido, iteramos del 1 al 9
            if (!$codigoEncontrado) {

                $resultado = substr($nombre, 0, 2);
                for($i = 0; $i < 10; $i ++) {

                    $resultado .= $i;

                    if (! $this->existObservadorSecundarioByCode ( $resultado )) {
                        break;
                    }
                }
            }
        }

        // Convertimos a mayuscula el resultado
        $resultado = strtoupper ( $resultado );

        return $resultado;
    }
}
