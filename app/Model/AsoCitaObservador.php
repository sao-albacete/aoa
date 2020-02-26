<?php
App::uses('AppModel', 'Model');
/**
 * AsoCitasObservadore Model
 *
 * @property Cita $Cita
 * @property Observador $Observador
 */
class AsoCitaObservador extends AppModel {

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
    public $useTable = 'aso_cita_observador';

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
        'ObservadorSecundario' => array(
            'className' => 'ObservadorSecundario',
            'foreignKey' => 'observador_secundario_id',
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
        'observador_secundario_id' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'El identificador del colaborador es obligatorio.'
            ),
            'numeric' => array(
                'rule' => 'naturalNumber',
                'required' => true,
                'message' => 'El identificador del colaborador debe ser un número.'
            )
        )
    );
    
    
    /**
     * Funciones
     */
    
    public function obtenerObservadoresPorCitaBasic($citaId) {
    
        $observadores = $this -> find(
            'all',
            array(
                'conditions'=>array('AsoCitaObservador.cita_id'=>$citaId),
                'fields'=>array('AsoCitaObservador.observador_secundario_id'),
                'recursive'=>-1
            )
        );
    
        return $observadores;
    }
    
    public function obtenerObservadoresPorCita($citaId) {
        
        $observadores = $this -> find(
            'all', 
            array(
                'conditions'=>array('AsoCitaObservador.cita_id'=>$citaId),
                'fields'=>array('ObservadorSecundario.nombre', 'ObservadorSecundario.codigo', 'ObservadorSecundario.id')
            )
        );
        
        return $observadores;
    }
    
    public function obtenerCitasPorObservador($observadorSecundarioId, $fields) {
    
        $citas = $this -> find(
            'all',
            array(
                'conditions'=>array('AsoCitaObservador.observador_secundario_id'=>$observadorSecundarioId),
                'fields'=>$fields
            )
        );
    
        return $citas;
    }
    
    public function existeAsoCitaObservador($observadorSecundarioId, $citaId) {
        
        $count = $this -> find(
            'count',
            array(
                'conditions'=>array('AsoCitaObservador.observador_secundario_id'=>$observadorSecundarioId, 'AsoCitaObservador.cita_id'=>$citaId)
            )
        );
        
        if($count > 0) {
            return true;
        }
        
        return false;
    }
    
    public function crearAsoCitaObservador($observadorSecundarioId, $citaId) {
        
        try {
            $asoCitaObservador = array();
            $asoCitaObservador['AsoCitaObservador']['observador_secundario_id'] = $observadorSecundarioId;
            $asoCitaObservador['AsoCitaObservador']['cita_id'] = $citaId;
            
            $this->create();
            
            $this->set($asoCitaObservador);
                
            if ($this->validates()) {
                $this->save($asoCitaObservador);
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
            CakeLog::write('error', $e->getTrace());
            throw new Exception('Se ha producido un error al asociar cita y observador');
        }
    }
    
    public function eliminarAsoCitaObservador($observadorSecundarioId, $citaId) {
        
        try {
            $asoCitaObservador = array();
            $asoCitaObservador['AsoCitaObservador']['observador_secundario_id'] = $observadorSecundarioId;
            $asoCitaObservador['AsoCitaObservador']['cita_id'] = $citaId;
                
            $this->create();
            
            $this->set($asoCitaObservador);
            
            if ($this->validates()) {
                $this->deleteAll(array('AsoCitaObservador.observador_secundario_id'=>$observadorSecundarioId, 'AsoCitaObservador.cita_id'=>$citaId), false);
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
            CakeLog::write('error', $e->getTrace());
            throw new Exception('Se ha producido un error al eliminar una asociacion cita y observador');
        }
    }
}
