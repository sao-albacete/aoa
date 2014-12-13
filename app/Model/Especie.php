<?php
App::uses('AppModel', 'Model');
/**
 * Especy Model
 *
 * @property Familia $Familia
 * @property DistribucionAb $DisbtribucionAb
 * @property EstatusCuantitativoAb $EstatusCuantitativoAb
 * @property ProteccionClm $ProteccionClm
 * @property ProteccionLr $ProteccionLr
 */
class Especie extends AppModel {

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
    public $useTable = 'especie';
    
    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'nombreComun';


    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Familia' => array(
            'className' => 'Familia',
            'foreignKey' => 'familia_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'ClasificacionCriterioEsp' => array(
            'className' => 'ClasificacionCriterioEsp',
            'foreignKey' => 'clasificacion_criterio_esp_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'DistribucionAb' => array(
            'className' => 'DistribucionAb',
            'foreignKey' => 'distribucion_ab_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'EstatusCuantitativoAb' => array(
            'className' => 'EstatusCuantitativoAb',
            'foreignKey' => 'estatus_cuantitativo_ab_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'EstatusReproductivoAb' => array(
            'className' => 'EstatusReproductivoAb',
            'foreignKey' => 'estatus_reproductivo_ab_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'ProteccionClm' => array(
            'className' => 'ProteccionClm',
            'foreignKey' => 'proteccion_clm_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'ProteccionLr' => array(
            'className' => 'ProteccionLr',
            'foreignKey' => 'proteccion_lr_id',
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
        'Citas' => array(
            'className' => 'Cita',
            'foreignKey' => 'especie_id',
            'dependent' => false,
            'conditions' => 'indActivo = 1',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'AsoEspeciePrivacidad' => array(
            'className' => 'AsoEspeciePrivacidad',
            'foreignKey' => 'id_especie_id',
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
    
    
    /*
     * Funciones
     */
    public function obtenerTodoPorId($especie_id, $fields=null) {
        
        if(!empty($fields)) {
            $especie = $this -> find(
                'first', 
                array(
                    'fields'=>$fields,
                    'conditions'=>array('Especie.id'=>$especie_id)
                )
            );
        }
        else {
            $especie = $this -> find(
                'first', 
                array(
                    'conditions'=>array('Especie.id'=>$especie_id)
                )
            );
        }
        
        return $especie;
    }

    public function obtenerEspecie($conditions, $fields=null) {

        if(!empty($fields)) {
            $especie = $this -> find(
                'first',
                array(
                    'fields'=>$fields,
                    'conditions'=>$conditions
                )
            );
        }
        else {
            $especie = $this -> find(
                'first',
                array(
                    'conditions'=>$conditions
                )
            );
        }

        return $especie;
    }
}
