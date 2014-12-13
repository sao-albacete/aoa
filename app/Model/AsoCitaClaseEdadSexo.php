<?php
App::uses('AppModel', 'Model');
/**
 * AsoCitasClasesEdadSexo Model
 *
 * @property Cita $Cita
 * @property ClaseEdadSexo $ClaseEdadSexo
 */
class AsoCitaClaseEdadSexo extends AppModel {
    
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
    public $useTable = 'aso_cita_clase_edad_sexo';


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
        ),
        'ClaseEdadSexo' => array(
            'className' => 'ClaseEdadSexo',
            'foreignKey' => 'clase_edad_sexo_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    
    
    /**
     * Validaciones
     */
    public $validate = array(
        'cita_id' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'El identificador de la cita es obligatorio.'
            ),
             'numeric' => array(
                 'rule' => 'naturalNumber',
                 'required' => true,
                 'message' => 'El identificador de la cita debe ser un número.'
             )
        ),
        'clase_edad_sexo_id' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'El identificador de la clase edad-sexo es obligatorio.'
            ),
            'numeric' => array(
                'rule' => 'naturalNumber',
                'required' => true,
                'message' => 'El identificador de la clase edad-sexo debe ser un número.'
            )
        ),
        'cantidad' => array(
            'required' => array(
                    'rule' => 'notEmpty',
                    'message' => 'La cantidad es obligatoria.'
            ),
            'numeric' => array(
                    'rule' => 'naturalNumber',
                    'message' => 'La cantidad debe ser un número.'
            )
        )
    );
    
    
    /**
     * Funciones
     */
    
    public function obtenerClasesEdadSexoPorCita($cita_id) {
        
        $clases_edad_sexo = $this -> find(
            'all', 
            array(
                'conditions'=>array('AsoCitaClaseEdadSexo.cita_id'=>$cita_id),
                'fields'=>array('ClaseEdadSexo.id','ClaseEdadSexo.codigo', 'ClaseEdadSexo.nombre', 'AsoCitaClaseEdadSexo.cantidad')
            )
        );
        
        return $clases_edad_sexo;
    }
    
    public function obtenerClasesEdadSexoPorCitaBasic($cita_id) {
    
        $clases_edad_sexo = $this -> find(
            'all',
            array(
                'conditions'=>array('AsoCitaClaseEdadSexo.cita_id'=>$cita_id),
                'fields'=>array('AsoCitaClaseEdadSexo.clase_edad_sexo_id'),
                'recursive'=>-1
            )
        );
    
        return $clases_edad_sexo;
    }
    
    public function obtenerCantidadPorClaseEdadSexoYCita($citaId, $claseEdadSexoId) {
    
        $cantidad = 0;
        
        $claseEdadSexoCita = $this -> find(
            'first',
            array(
                'conditions'=>array('AsoCitaClaseEdadSexo.cita_id'=>$citaId, 'AsoCitaClaseEdadSexo.clase_edad_sexo_id'=>$claseEdadSexoId),
                'fields'=>array('AsoCitaClaseEdadSexo.cantidad')
            )
        );
        
        if($claseEdadSexoCita != null && isset($claseEdadSexoCita['AsoCitaClaseEdadSexo']['cantidad'])) {
            $cantidad = $claseEdadSexoCita['AsoCitaClaseEdadSexo']['cantidad'];
        }
    
        return $cantidad;
    }
    
    public function existeAsoCitaClaseEdadSexo($claseEdadSexoId, $citaId) {
    
        $count = $this -> find(
            'count',
            array(
                'conditions'=>array('AsoCitaClaseEdadSexo.clase_edad_sexo_id'=>$claseEdadSexoId, 'AsoCitaClaseEdadSexo.cita_id'=>$citaId)
            )
        );
    
        if($count > 0) {
            return true;
        }
    
        return false;
    }
    
    public function crearAsoCitaClaseEdadSexo($claseEdadSexoId, $citaId, $cantidad) {
        
        try {
            $asoCitaClaseEdadSexo = array();
            $asoCitaClaseEdadSexo['AsoCitaClaseEdadSexo']['clase_edad_sexo_id'] = $claseEdadSexoId;
            $asoCitaClaseEdadSexo['AsoCitaClaseEdadSexo']['cita_id'] = $citaId;
            $asoCitaClaseEdadSexo['AsoCitaClaseEdadSexo']['cantidad'] = $cantidad;

            CakeLog::debug('$asoCitaClaseEdadSexo -> ' . print_r($asoCitaClaseEdadSexo, true));

            $this->create();
            
            $this->set($asoCitaClaseEdadSexo);
            
            if ($this->validates()) {
                $this->save($asoCitaClaseEdadSexo);
            }
            else {
                $errors = $this->validationErrors;
                    
                $errorsMessages = "";
                foreach ($errors as $validationError) {
                    $errorsMessages .= $validationError[0]."\n";
                }
                    
                return $errorsMessages;
            }
        }
        catch(Exception $e) {
            CakeLog::error($e->getMessage().$e->getTraceAsString());
            throw new Exception('Se ha producido un error al asociar clase edad sexo y cita');
        }
    }
    
    public function modificarCantidadAsoCitaClaseEdadSexo($claseEdadSexoId, $citaId, $cantidad) {
    
        try {
            
            $asoCitaClaseEdadSexo = array();
            $asoCitaClaseEdadSexo['AsoCitaClaseEdadSexo']['clase_edad_sexo_id'] = $claseEdadSexoId;
            $asoCitaClaseEdadSexo['AsoCitaClaseEdadSexo']['cita_id'] = $citaId;
            $asoCitaClaseEdadSexo['AsoCitaClaseEdadSexo']['cantidad'] = $cantidad;
                
            $this->create();
                
            $this->set($asoCitaClaseEdadSexo);
                
            if ($this->validates()) {
                
                $this->updateAll(
                    array('AsoCitaClaseEdadSexo.cantidad' => $cantidad),
                    array('AsoCitaClaseEdadSexo.clase_edad_sexo_id' => $claseEdadSexoId, 'AsoCitaClaseEdadSexo.cita_id' => $citaId)
                );
            }
            else {
                $errors = $this->validationErrors;
                    
                $errorsMessages = "";
                foreach ($errors as $validationError) {
                    $errorsMessages .= $validationError[0]."\n";
                }
                    
                return $errorsMessages;
            }
        }
        catch(Exception $e) {
            CakeLog::error($e->getMessage().$e->getTraceAsString());
            throw new Exception('Se ha producido un error al asociar clase edad sexo y cita');
        }
    }
    
    public function eliminarAsoCitaClaseEdadSexo($claseEdadSexoId, $citaId) {
        
        try {
            $asoCitaClaseEdadSexo = array();
            $asoCitaClaseEdadSexo['AsoCitaClaseEdadSexo']['clase_edad_sexo_id'] = $claseEdadSexoId;
            $asoCitaClaseEdadSexo['AsoCitaClaseEdadSexo']['cita_id'] = $citaId;
                
            $this->create();
            
            $this->set($asoCitaClaseEdadSexo);
                
            if ($this->validates()) {
                $this->deleteAll(array('AsoCitaClaseEdadSexo.clase_edad_sexo_id'=>$claseEdadSexoId, 'AsoCitaClaseEdadSexo.cita_id'=>$citaId), false);
            }
            else {
                $errors = $this->validationErrors;
                    
                $errorsMessages = "";
                foreach ($errors as $validationError) {
                    $errorsMessages .= $validationError[0]."\n";
                }
                    
                return $errorsMessages;
            }
        }
        catch(Exception $e) {
            CakeLog::error($e->getMessage().$e->getTraceAsString());
            throw new Exception('Se ha producido un error al eliminar la asociacion clase edad sexo y cita');
        }
    }

    public function existenCitasHembras($citaId) {
    
        try {
            
            $count = $this -> find(
                'count',
                array(
                    'fields' => array('AsoCitaClaseEdadSexo.id'),
                    'conditions'=>array('AsoCitaClaseEdadSexo.cita_id' => $citaId,'RIGHT(ClaseEdadSexo.codigo, 1)' => 2)
                )
            );
        
            if($count > 0) {
                return true;
            }
        }
        catch(Exception $e) {
            CakeLog::error($e->getMessage().$e->getTraceAsString());
        }
    
        return false;
    }
    
    public function existenCitasMachos($citaId) {
    
        try {
                
            $count = $this -> find(
                'count',
                array(
                    'fields' => array('AsoCitaClaseEdadSexo.id'),
                    'conditions'=>array('AsoCitaClaseEdadSexo.cita_id' => $citaId,'RIGHT(ClaseEdadSexo.codigo, 1)' => 1)
                )
            );
    
            if($count > 0) {
                return true;
            }
        }
        catch(Exception $e) {
            CakeLog::error($e->getMessage().$e->getTraceAsString());
        }
    
        return false;
    }
    
    public function existenCitasAdultos($citaId, $especieId = null) {
    
        try {
            
            $count = 0;
            $conditions = array('AsoCitaClaseEdadSexo.cita_id' => $citaId,'LEFT(ClaseEdadSexo.codigo, 1)' => 9);
            
            // Neophron percnopterus
            if($especieId == 67) {
                $conditions = array('AsoCitaClaseEdadSexo.cita_id' => $citaId,'LEFT(ClaseEdadSexo.codigo, 1)' => 5);
            }
            // Aquila adalberti
            elseif ($especieId == 588) {
                $conditions = array('AsoCitaClaseEdadSexo.cita_id' => $citaId,'LEFT(ClaseEdadSexo.codigo, 1)' => 7);
            }
            // Falco peregrinus
            elseif ($especieId == 159 || $especieId == 160 || $especieId == 605) {
                $conditions = array('AsoCitaClaseEdadSexo.cita_id' => $citaId,'LEFT(ClaseEdadSexo.codigo, 1)' => 5);
            }
            // Aquila fasciata
            elseif ($especieId == 593) {
                $conditions = array('AsoCitaClaseEdadSexo.cita_id' => $citaId,'LEFT(ClaseEdadSexo.codigo, 1)' => 5);
            }
            // Childonias niger
            elseif ($especieId == 499) {
                $conditions = array('AsoCitaClaseEdadSexo.cita_id' => $citaId,'LEFT(ClaseEdadSexo.codigo, 1)' => 3);
            }
            // Aquila chrysaetos
            elseif ($especieId == 591) {
                $conditions = array('AsoCitaClaseEdadSexo.cita_id' => $citaId,'LEFT(ClaseEdadSexo.codigo, 1)' => 7);
            }
    
            $count = $this -> find(
                'count',
                array(
                    'fields' => array('AsoCitaClaseEdadSexo.id'),
                    'conditions'=>$conditions
                )
            );
    
            if($count > 0) {
                return true;
            }
        }
        catch(Exception $e) {
            CakeLog::error($e->getMessage().$e->getTraceAsString());
        }
    
        return false;
    }
}
