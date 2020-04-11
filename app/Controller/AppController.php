<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package        app.Controller
 * @link        http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array(
//         'DebugKit.Toolbar',
        'Session',
        'Auth'=>array(
            'authenticate' => array(
                'Form' => array(
                    'fields' => array('username' => 'email')
                ),
//				'Basic' => [
//					'passwordHasher' => 'Blowfish'
//				],
                'all' => array(
                    'scope' => array('User.indActivo' => 1)
                )
            ),
            'loginAction' => array(
                'controller' => 'user',
                'action' => 'login'
            ),
            'loginRedirect'=>array('controller'=>'inicio', 'action'=>'index'),
            'logoutRedirect'=>array('controller'=>'inicio', 'action'=>'index'),
            'authError'=>'No tiene permisos para acceder a esta página',
            'authorize'=>'Controller'
        )
    );

    public function isAuthorized($user) {
        return true;
    }

    public function beforeFilter() {
        $this->Auth->allow('index', 'view', 'login');
        $this->set('logged_in', $this->Auth->loggedIn());
        $this->set('current_user', $this->Auth->user());
//		if ($this->request->is('json') || $this->request->is('xml')) {
//			$this->Auth->authenticate = [
//				'Basic' => [
//					'passwordHasher' => 'Blowfish'
//				]
//			];
//		}
    }

    public $paginate = array(
        'limit' => 25
    );
}
