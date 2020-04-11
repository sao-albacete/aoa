<?php


class ObservationsController extends AppController
{
	public $components = array('RequestHandler');

	public function beforeFilter()
	{
		parent::beforeFilter();

		$this->Auth->allow(
			'index'
		);
	}

	public function index()
	{
		$this->set(array(
			'observations' => ['Hello world!'],
			'_serialize' => array('observations')
		));
	}

	public function view($id)
	{
//		$recipe = $this->Recipe->findById($id);
//		$this->set(array(
//			'recipe' => $recipe,
//			'_serialize' => array('recipe')
//		));
	}

	public function add()
	{
//		$this->Recipe->create();
//		if ($this->Recipe->save($this->request->data)) {
//			$message = 'Saved';
//		} else {
//			$message = 'Error';
//		}
//		$this->set(array(
//			'message' => $message,
//			'_serialize' => array('message')
//		));
	}

	public function edit($id)
	{
//		$this->Recipe->id = $id;
//		if ($this->Recipe->save($this->request->data)) {
//			$message = 'Saved';
//		} else {
//			$message = 'Error';
//		}
//		$this->set(array(
//			'message' => $message,
//			'_serialize' => array('message')
//		));
	}

	public function delete($id)
	{
//		if ($this->Recipe->delete($id)) {
//			$message = 'Deleted';
//		} else {
//			$message = 'Error';
//		}
//		$this->set(array(
//			'message' => $message,
//			'_serialize' => array('message')
//		));
	}
}
