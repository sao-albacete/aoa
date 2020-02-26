<?php

App::uses('ExceptionRenderer', 'Error');

/**
 * Class AppExceptionRenderer
 */
class AppExceptionRenderer extends ExceptionRenderer
{
    public function notFound()
    {
        $this->controller->redirect(array(
            'controller' => 'errors',
            'action' => 'error404'
        ));
    }

    public function forbidden()
    {
        $this->controller->redirect(array(
            'controller' => 'errors',
            'action' => 'error403'
        ));
    }
}
