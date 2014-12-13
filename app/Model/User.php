<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
/**
 * User Model
 *
 * @property Perfil $Perfil
 * @property CitaHistorico $CitaHistorico
 * @property Cita $Cita
 * @property Fichero $Fichero
 * @property Lugar $Lugar
 * @property ObservadorPrincipal $ObservadorPrincipal
 */
class User extends AppModel {

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
    public $useTable = 'usuario';
    
    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'username';


    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Perfil' => array(
            'className' => 'Perfil',
            'foreignKey' => 'perfil_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'ObservadorPrincipal' => array(
            'className' => 'ObservadorPrincipal',
            'foreignKey' => 'observador_principal_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Fichero' => array(
            'className' => 'Fichero',
            'foreignKey' => 'fichero_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    
    /**
     * Validaciones
     */
    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'El nombre completo es obligatorio.'
            ),
            'minLength' => array(
                'rule' => array('minLength', 10),
                'message' => 'El tamaño mínimo del nombre completo son 10 caracteres.'
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 250),
                'message' => 'El tamaño máximo del nombre completo son 256 caracteres.'
            )
        ),
        'email' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'El correo electrónico es obligatorio.'
            ),
            'email' => array(
                'rule' => array('email'),
                'message' => 'El formato del correo no es válido.'
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 150),
                'message' => 'El tamaño máximo del correo electrónico son 150 caracteres.'
            ),
             'isUnique' => array(
                'rule' => array('isUnique'),
                'message' => 'El email introducido ya esta siendo usado.',
                'required' => 'create'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'La contraseña es obligatoria.'
            ),
            'between' => array(
                'rule' => array('between', 8, 40),
                'message' => 'La contraseña debe contener un mímimo de 8 caracteres y un máximo de 40.'
            ),
            'matchPasswords' => array(
                'rule' => 'matchPasswords',
                'message' => 'Las contraseñas no coinciden'
            )
        ),
        'password_confirmation' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'La contraseña es obligatoria.'
            ),
            'between' => array(
                'rule' => array('between', 8, 40),
                'message' => 'La contraseña debe contener un mímimo de 8 caracteres y un máximo de 40.'
            )
        )
    );
    
    public function matchPasswords($data) {
        if($data['password'] == $this->data['User']['password_confirmation']) {
            return true;
        }
        return false;
    }
        
    public function beforeSave($options = array()) {
        if (isset($this->data['User']['password'])) {
            $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
        }
        return true;
    }
    
    /**
     * Comprueba si existe algun usuario con el email recibido por parametro y 
     * devuelve el numero de usuarios encontrados
     * 
     * @param string $email
     * @param number $indActivo
     * @throws Exception
     * @return number
     */
    public function existeUsuarioPorEmail($email, $indActivo=1) {
        
        $usuarios = 0;
        
        try {
            
            if(!empty($email) && ($indActivo == 1 || $indActivo == 0)) {
                $usuarios = $this -> find(
                    'count',
                    array(
                        'conditions'=>array('User.email'=>$email,'User.indActivo'=>$indActivo),
                        'fields'=>array('User.id')
                    )
                );
            }
        }
        catch(Exception $e) {
            CakeLog::error($e->getMessage()." ".$e->getTrace());
            throw $e;
        }
        
        return $usuarios;
    }
    
    /**
     * Obtiene el id de un usuario a partir de su email
     * 
     * @param string $email
     * @throws Exception
     * @return number
     */
    public function obtenerIdUsuarioPorEmail($email) {
    
        $usuarioId = 0;
    
        try {
                
            if(!empty($email)) {
                $usuario = $this -> find(
                    'first',
                    array(
                        'conditions'=>array('User.email'=>$email),
                        'fields'=>array('User.id')
                    )
                );
                
                if(!empty($usuario)) {
                    $usuarioId = $usuario['User']['id'];
                }
            }
        }
        catch(Exception $e) {
            CakeLog::error($e->getMessage()." ".$e->getTrace());
            throw $e;
        }
    
        return $usuarioId;
    }
            
}
