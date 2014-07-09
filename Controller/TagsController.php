<?php
App::uses('AppController', 'Controller');
/**
 * Tags Controller
 *
 * @property Tag $Tag
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class TagsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Tag->recursive = 0;
		$this->set('tags', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Tag->exists($id)) {
			throw new NotFoundException(__('Invalid tag'));
		}
		$options = array('conditions' => array('Tag.' . $this->Tag->primaryKey => $id));
		$this->set('tag', $this->Tag->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Tag->create();
			if ($this->Tag->save($this->request->data)) {
				$this->Session->setFlash(__('The tag has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tag could not be saved. Please, try again.'));
			}
		}
		$blogs = $this->Tag->Blog->find('list');
		$this->set(compact('blogs'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Tag->exists($id)) {
			throw new NotFoundException(__('Invalid tag'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Tag->save($this->request->data)) {
				$this->Session->setFlash(__('The tag has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tag could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Tag.' . $this->Tag->primaryKey => $id));
			$this->request->data = $this->Tag->find('first', $options);
		}
		$blogs = $this->Tag->Blog->find('list');
		$this->set(compact('blogs'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Tag->id = $id;
		if (!$this->Tag->exists()) {
			throw new NotFoundException(__('Invalid tag'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Tag->delete()) {
			$this->Session->setFlash(__('The tag has been deleted.'));
		} else {
			$this->Session->setFlash(__('The tag could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
