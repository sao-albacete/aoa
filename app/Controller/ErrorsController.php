<?php

/**
 * Class ErrorsController
 * @author Wonnova
 * @link http://www.wonnova.com
 */
class ErrorsController extends AppController
{
    public $name = 'Errors';

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('error404');
    }

    public function error404() {
        $this->response->statusCode(404);
    }

    public function error403() {
        $this->response->statusCode(403);
    }
}
