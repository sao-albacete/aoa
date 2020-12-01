<?php

App::uses('AppController', 'Controller');
App::uses('EmailUtil', 'Utility');

/**
 * Maneja la información de los usuarios
 *
 * @author vcanizares
 */
class UserController extends AppController
{

    /**
     * Componentes
     */
    public $components = array();

    /**
     * Helpers
     */
    public $helpers = array('Html');

    /**
     * Nombre del controlador
     */
    //public $name = 'User';

    /**
     * Modelos
     */
    public $uses = array(
        'User',
        'ObservadorPrincipal',
        'ObservadorSecundario',
        'Fichero'
    );


    /**
     * Funciones
     */

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('add', 'renewPassword', 'recoverPassword', 'activateUser');
    }

    public function login()
    {

        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash(__("El usuario o contraseña son incorrectos."), 'failure');
            }
        }
    }

    public function logout()
    {
        $this->redirect($this->Auth->logout());
    }

    public function isAuthorized($user)
    {
        if (in_array($this->action, array('edit', 'delete'))) {
            if ($user['id'] != $this->request->params['pass'][0]) {
                return false;
            }
        }
        return true;
    }

    public function index()
    {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

    public function view()
    {
        if (isset($this->request->named['id'])) {
            $this->User->id = $this->request->named['id'];

            // Comprobamos si el usuario que se desea editar existe
            if (!$this->User->exists()) {
                throw new NotFoundException(sprintf('El usuario con id %s no existe', $this->request->params['pass'][0]));
            }

        } else {
            $current_user = $this->Auth->user();
            $this->User->id = $current_user['id'];
        }

        /* Datos de usuario */
        $usuario = $this->User->read(null, $this->User->id);
        unset($usuario['User']['password']);
        $this->set('user', $usuario);

        if (isset($usuario['Fichero']['nombreFisico'])) {
            /* Url del avatar */
            $this->set('urlAvatar', IMAGES . 'users/' . $this->User->id . "/" . $usuario['Fichero']['nombreFisico']);
        }
    }

    /**
     * Alta de un nuevo usuario
     */
    public function add()
    {
        if ($this->request->is('post')) {

			/*
			 * Comprobamos si se ha introducido un codigo en el honeypot, y e ese caso, no continuamos
			 */
			if ($this->request->data["codigo"] != "5asdf45asdf4sa5df4asdf55as7df" || $this->request->data["codigo2"] != "") {
				CakeLog::error('[' . __METHOD__ . '] Intento de creación de usuario fraudulento con email: ' . $this->request->data["User"]["email"]);
				$this->Session->setFlash(__('Tu usuario ha sido creado. Para activarlo, te hemos enviado un email a tu dirección de correo electrónico. Por favor, sigue las instrucciones que en él se indican.'), "success");
				$this->redirect(array("action" => "login"));
				return;
			}

            /*
             * Comprobamos si el usuario ya existe y está activo
             */
            if ($this->User->existeUsuarioPorEmail($this->request->data["User"]["email"], 1)) {
                $this->Session->setFlash(
                    __('Ya existe un usuario activo con el email ' . $this->request->data["User"]["email"]), "failure"
                );
                return;
            } elseif ($this->User->existeUsuarioPorEmail($this->request->data["User"]["email"], 0)) {

                $this->User->read(null, $this->User->obtenerIdUsuarioPorEmail($this->request->data["User"]["email"]));

                $this->User->saveField('indActivo', 1);

                EmailUtil::enviarEmailNuevoUsuario($this->User->read(null, $this->User->id));

                $this->Session->setFlash(__('¡BIENVENID@ DE NUEVO AL ANUARIO! Su usuario ha sido reactivado correctamente.'), 'success');
                $this->login();

            } else {

                // Desactivado por defecto
                $this->request->data["User"]["indActivo"] = 0;

                $this->User->create();

                $this->User->set($this->request->data);

                if ($this->User->validates()) {

                    if ($this->User->save()) {

                        // Cargamos los datos del nuevo usuario
                        $user = $this->User->read(null, $this->User->id);

                        //Creamos el directorio donde el usuario podrá subir sus ficheros
                        $imageAbsolutePath = IMAGES . 'users/' . $this->User->id . "/";
                        mkdir($imageAbsolutePath);

                        // Cargamos el plugin de herramientas de CakePHP
                        $this->Token = ClassRegistry::init('Tools.Token');

                        // Generamos una nueva clave
                        $cCode = $this->Token->newKey('newUser', null, $user['User']['id'], $user['User']['email']);

                        // Generamos el enlace
                        $enlace = "https://$_SERVER[HTTP_HOST]/User/activateUser/$cCode";

                        // Enviamos el correo al usuario
                        EmailUtil::enviarEmailActivarUsuario($user['User']['email'], $enlace);

                        // Mostramos un mensaje en pantalla informando al usuario de que el correo ha sido enviado
                        $this->Session->setFlash(__('Tu usuario ha sido creado. Para activarlo, te hemos enviado un email a tu dirección de correo electrónico. Por favor, sigue las instrucciones que en él se indican.'), "success");

                        $this->redirect(array("action" => "login"));
                    }
                } else {

                    $errors = $this->User->validationErrors;

                    $errorsMessages = "";
                    foreach ($errors as $validationError) {
                        $errorsMessages .= $validationError[0] . "\n";
                    }

                    $this->Session->setFlash($errorsMessages, "failure");
                }
            }
        }
    }

    public function activateUser()
    {
        $validToken = true;

        // Obtenemos el token de la request
        $keyToCheck = $this->request->params['pass'][0];

        $this->Token = ClassRegistry::init('Tools.Token');
        $token = $this->Token->getToken('newUser', $keyToCheck);

        if (!empty($token) && $token['Token']['used'] > 0) {
            // La contraseña ya ha sido regenerada
            $this->Session->setFlash(__('Tu usuario ya ha sido activado. Puedes acceder a la aplicación usando el botón \"Entrar\"'), "warning");
            return;
        } elseif (empty($token)) {
            // Enlace no valido
            $this->Session->setFlash(__('Operación no permitida. Puedes registrarse en la web pulsando el botón \"Regístrate\" de la pantalla principal.'), "warning");
            return;
        }

        $this->set('validToken', $validToken);

        $userId = $token['Token']['user_id'];

        $this->User->id = $userId;
        $this->User->saveField('indActivo', 1);

        if (!$this->Token->spendKey($token['Token']['id'])) {
            CakeLog::error('[' . __METHOD__ . '] No se ha marcado como usado el token');
        }

        $user = $this->User->read(null, $userId);

        // Creamos el observador principal
        $codigo = $this->ObservadorPrincipal->generarCodigo($user["User"]["username"]);
        $this->ObservadorPrincipal->create();
        $observador = array('ObservadorPrincipal' => array(
            'codigo' => $codigo,
            'nombre' => $user["User"]["username"])
        );
        $this->ObservadorPrincipal->set($observador);
        if ($this->ObservadorPrincipal->validates()) {
            $this->ObservadorPrincipal->save();
        } else {
            CakeLog::error(sprintf('[%s] Error creando usuario principal. %s', __METHOD__, print_r($this->ObservadorPrincipal->validationErrors)));
        }

        $this->User->saveField('observador_principal_id', $this->ObservadorPrincipal->id);

        // Creamos el observador secundario
        $codigo = $this->ObservadorSecundario->generarCodigo($user["User"]["username"]);
        $this->ObservadorSecundario->create();
        $observadorSecundario = array('ObservadorSecundario' => array(
            'codigo' => $codigo,
            'nombre' => $user["User"]["username"],
            'observador_principal_id' => $this->ObservadorPrincipal->id
        ));
        $this->ObservadorSecundario->set($observadorSecundario);
        if ($this->ObservadorSecundario->validates()) {
            $this->ObservadorSecundario->save();
        } else {
            CakeLog::error(sprintf('[%s] Error creando usuario secundario. %s', __METHOD__, print_r($this->ObservadorSecundario->validationErrors)));
        }

        // Enviamos un email para que el alta quede registrada
        EmailUtil::enviarEmailNuevoUsuario($user);

        $this->Session->setFlash(__('¡BIENVENID@ AL ANUARIO ' . $user['User']['username'] . '! Tu usuario ha sido activado correctamente, ya puede entrar en la web.'), 'success');

        $this->login();
    }

    /**
     * Edita los datos de un usuario
     *
     * @throws Exception
     */
    public function edit()
    {
        // Recogemos los parámetros de la request
        $this->User->id = $this->request->params['pass'][0];
        $usuario = $this->User->read(null, $this->User->id);

        // Comprobamos si el usuario que se desea editar existe
        if (!$this->User->exists()) {
            throw new NotFoundException(sprintf('El usuario con id %s no existe', $this->request->params['pass'][0]));
        }

        // Usuario de sesión
        $current_user = $this->Auth->user();

        // Comprobamos si el usuario de sesión tiene permisos para modificar el usuario
        if (($current_user['id'] != $usuario['User']['id'] && $current_user['perfil_id'] > 1) || $current_user['indActivo'] == 0) {
            throw new ForbiddenException(sprintf('El usuario con email %s no tiene permisos editar el usuario con id %s',$current_user['email'], $usuario['User']['id']));
        }

        if ($this->request->is('post') || $this->request->is('put')) {

            // Comprobamos si la contraseña introducida es correcta
            if ($usuario['User']['password'] != AuthComponent::password($this->request->data['User']['password'])) {
                $this->Session->setFlash(__('La contraseña introducida no es correcta.'), 'failure');
                $this->redirect(array('action' => 'edit', $this->User->id));
            }

            $this->User->set('password', $this->request->data['User']['password']);
            $this->User->set('password_confirmation', $this->request->data['User']['password']);

            // Comprobamos si se ha introducido una nueva contraseña
            if (isset($this->request->data['User']['new_password']) && strlen($this->request->data['User']['new_password']) > 0) {
                $this->User->set('password', $this->request->data['User']['new_password']);
                $this->User->set('password_confirmation', $this->request->data['User']['password_confirmation']);
            }

            $this->User->set('username', $this->request->data['User']['username']);
            $this->User->set('email', $this->request->data['User']['email']);

            /* Fichero */
            $ficheroId = 0;
            if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] != 4) {
                $ficheroId = $this->Fichero->subirAvatar($_FILES["imagen"], $this->User->id, $usuario['Fichero']['id']);
            }

            if ($ficheroId != null && $ficheroId > 0) {
                $this->User->set('fichero_id', $ficheroId);
            }

            if ($this->User->validates()) {

                if ($this->User->save()) {

                    $this->Session->setFlash(__('El usuario ha sido modificado correctamente.'), 'success');
                    $this->redirect(array('action' => 'edit', $this->User->id));
                } else {
                    $this->Session->setFlash(__('El usuario no ha podido ser modificado. Por favor, inténtelo de nuevo.'), 'failure');
                    $this->redirect(array('action' => 'edit', $this->User->id));
                }
            } else {
                $errors = $this->User->validationErrors;

                $errorsMessages = "";
                foreach ($errors as $validationError) {
                    $errorsMessages .= $validationError[0] . "\n";
                }

                $this->Session->setFlash($errorsMessages, "failure");
                $this->redirect(array('action' => 'edit', $this->User->id));
            }
        } else {

            /* Datos de usuario */
            $usuario = $this->User->read(null, $this->User->id);
            unset($usuario['User']['password']);
            $this->set('user', $usuario);

            if (isset($usuario['Fichero']['nombreFisico'])) {
                /* Url del avatar */
                $this->set('urlAvatar', IMAGES . 'users/' . $this->User->id . "/" . $usuario['Fichero']['nombreFisico']);
            }
        }
    }

    /**
     * Da de baja un usuario
     */
    public function delete()
    {
        $this->request->onlyAllow('post');

        // Recogemos los parámetros de la request
        $this->User->id = $this->request->params['pass'][0];
        $usuario = $this->User->read(null, $this->User->id);

        if (!$this->User->exists()) {
            $this->Session->setFlash(__('El usuario que desea editar no existe'), "failure");
        }

        $current_user = $this->Auth->user();

        // Comprobamos si la contraseña introducida es correcta
        if ($usuario['User']['password'] != AuthComponent::password($this->request->data['bajaUsuarioPassword'])) {
            $this->Session->setFlash(__('La contraseña introducida no es correcta.'), 'failure');
            $this->redirect(array('action' => 'view', $this->User->id));
        }

        /**
         * Baja logica
         */
        {
            $this->User->saveField('indActivo', 0);

            EmailUtil::enviarEmailBajaUsuario($current_user);

            $this->Session->setFlash(__('Tu usuario ha sido dado de baja correctamente en el anuario. ¡Esperamos volver a verte pronto!'), 'success');

            $this->logout();
        }

        /**
         * Borrado fisico
         */
// 	        if($this->User->delete()) {

// 	        	$current_user = $this->Auth->user();
// 	        	EmailUtil::enviarEmailBajaUsuario($current_user);

// 	        	$this->Session->setFlash(__('Su usuario ha sido dado de baja correctamente'), 'success');

// 	        	$this->logout();
// 	        }

        $this->Session->setFlash(__('El usuario no ha podido ser dado de baja.'), 'failure');
        $this->redirect(array('action' => 'view', $this->User->id));
    }

    /**
     * Enviar un correo al usuario para que pueda recuperar su contraseña
     */
    public function recoverPassword()
    {

        if ($this->request->is('post')) {

            // Recuperamos el email introducido por pantalla
            $email = $this->request->data['UserEmail'];

            // Saneamos y validamos el email
            $email_sanitized = filter_var($email, FILTER_SANITIZE_EMAIL);

            if (!filter_var($email_sanitized, FILTER_VALIDATE_EMAIL)) {
                $this->Session->setFlash(__('El correo electrónico introducido no es correcto.'), "failure");
            } else {
                // Comprobamos si el email introducido por el usuario existe y está activo
                $bExisteEmail = $this->User->existeUsuarioPorEmail($email_sanitized);

                if ($bExisteEmail > 0) {

                    // Cargamos el plugin de herramientas de CakePHP
                    $this->Token = ClassRegistry::init('Tools.Token');

                    // Generamos una nueva clave
                    $cCode = $this->Token->newKey('renewPass', null, null, $email_sanitized);

                    // Generamos el enlace
                    $enlace = "https://$_SERVER[HTTP_HOST]/User/renewPassword/$cCode";

                    // Enviamos el correo al usuario
                    EmailUtil::enviarEmailRegenerarPassword($email_sanitized, $enlace);

                    // Mostramos un mensaje en pantalla informando al usuario de que el correo ha sido enviado
                    $this->Session->setFlash(__('Se ha enviado el email correctamente a tu dirección de correo electrónico. Por favor, sigue las instrucciones que en él se indican.'), "success");
                } else {
                    // Mostramos un mensaje en pantalla informando al usuario de que el correo no existe
                    $this->Session->setFlash(__('El correo electrónico introducido no pertenece a ningún usuario activo en la aplicación.'), "failure");
                }
            }
        }
    }

    /**
     * Renueva la contraseña de un usuario
     */
    public function renewPassword()
    {

        $validToken = true;

        // Obtenemos el token de la request
        $keyToCheck = $this->request->params['pass'][0];

        $this->Token = ClassRegistry::init('Tools.Token');
        $token = $this->Token->getToken('renewPass', $keyToCheck);

        if (!empty($token) && $token['Token']['used'] > 0) {
            $validToken = false;
            // La contraseña ya ha sido regenerada
            $this->Session->setFlash(__('Tu contraseña ya ha sido regenerada, introdúcela en la pantalla de acceso o vuelve a solicitarla si no la recuerdas.'), "warning");
        } elseif (empty($token)) {
            $validToken = false;
            $this->Session->setFlash(__('El tiempo de regeneración de contraseña ha caducado. Si aún no recuerdas tu contraseña, puedes volver a solicitarla.'), "failure");
        }

        $this->set('validToken', $validToken);
        $this->set('keyToCheck', $keyToCheck);

        if ($this->request->is('post')) {

            $email = $token['Token']['content'];
            $userId = $this->User->obtenerIdUsuarioPorEmail($email);

            $user = $this->User->read(null, $userId);
            $user['User']['password'] = $this->request->data['User']['password'];
            $user['User']['password_confirmation'] = $this->request->data['User']['password_confirmation'];

            $this->User->create();
            $this->User->set($user);

            if ($this->User->validates()) {

                // Almacenamos la nueva contraseña
                $this->User->save();

                if (!$this->Token->spendKey($token['Token']['id'])) {
                    CakeLog::error('[' . __METHOD__ . '] No se ha marcado como usado el token');
                }

                $this->Session->setFlash(__('Su nueva contraseña se ha guardado correctamente.'), "success");

                // Redirige a la pantalla de login
                return $this->redirect(array("action" => "login"));
            } else {

                $errors = $this->User->validationErrors;

                $errorsMessages = "";
                foreach ($errors as $validationError) {
                    $errorsMessages .= $validationError[0] . "\n";
                }

                $this->Session->setFlash($errorsMessages, "failure");
            }
        }
    }

}
