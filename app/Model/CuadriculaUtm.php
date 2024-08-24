<?php
App::uses('AppModel', 'Model');
/**
 * CuadriculasUtm Model. coordenadaX and coordenadaY points to the center of the square UTM (10km width/height), using WGS 84.
 *
 */
class CuadriculaUtm extends AppModel {

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
    public $useTable = 'cuadricula_utm';

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'codigo';


    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Lugar' => array(
            'className' => 'Lugar',
            'foreignKey' => 'cuadricula_utm_id',
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

    /**
     * Obtiene toda la información de un lugar
     */
    public function obtenerDatosBasicosCuadriculaUtmPorCodigo($codigo) {

        $cuadriculaUtm = $this->find('first', array(
                'conditions'=>array('CuadriculaUtm.codigo'=>$codigo),
                'recursive'=>-1
            ));

        return $cuadriculaUtm;
    }

    /**
     * Obtiene la cuadricula UTM que incluye las coordenadas UTM.
     */
    public function obtenerCuadriculaUtmPorCoordenadas($utm_norte, $utm_este) {
        $cuadriculaUtm = $this->find('first', array(
                'fields' => array('CuadriculaUtm.id'),
                'conditions'=>array('AND' => array(
                                    'CuadriculaUtm.coordenadaY >'=>$utm_norte - 5000,
                                    'CuadriculaUtm.coordenadaY <='=>$utm_norte +5000,
                                    'CuadriculaUtm.coordenadaX >'=>$utm_este -5000,
                                    'CuadriculaUtm.coordenadaX <='=>$utm_este + 5000)),
                'recursive'=>-1
            ));

        return $cuadriculaUtm;
    }

    /**
     * Obtiene todos las cuadrículas UTM activas ordenadas por codigo
     */
    public function obtenerCuadriculasUtmActivosOrdenadosPorCodigo() {

        $cuadriculas_utm = $this -> find(
            'all',
            array(
                'fields'=>array('CuadriculaUtm.id', 'CuadriculaUtm.codigo'),
                'conditions'=>array('CuadriculaUtm.indActivo'=>1),
                'order'=>array('CuadriculaUtm.codigo ASC'),
                'recursive'=>-1
            )
        );

        return $cuadriculas_utm;
    }
}
