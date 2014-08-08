<?php
App::uses('AppController', 'Controller');
/**
 * Blogs Controller
 *
 * @property Blog $Blog
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class BlogsController extends AppController {

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Session');

	/**
	 * array of helpers used in this controller
	 * @var array
	 */
	public $helpers = array(
		'Admin',
	);

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->Blog->recursive = 0;
		$this->set('blogs', $this->Paginator->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		if (!$this->Blog->exists($id)) {
			throw new NotFoundException(__('Invalid blog'));
		}
		$options = array('conditions' => array('Blog.' . $this->Blog->primaryKey => $id));
		$this->set('blog', $this->Blog->find('first', $options));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Blog->create();
			if ($this->Blog->save($this->request->data)) {
				$this->Session->setFlash(__('The blog has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The blog could not be saved. Please, try again.'));
			}
		}
		$tags = $this->Blog->Tag->find('list');
		$this->set(compact('tags'));
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		if (!$this->Blog->exists($id)) {
			throw new NotFoundException(__('Invalid blog'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Blog->save($this->request->data)) {
				$this->Session->setFlash(__('The blog has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The blog could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Blog.' . $this->Blog->primaryKey => $id));
			$this->request->data = $this->Blog->find('first', $options);
		}
		$tags = $this->Blog->Tag->find('list');
		$this->set(compact('tags'));
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null) {
		$this->Blog->id = $id;
		if (!$this->Blog->exists()) {
			throw new NotFoundException(__('Invalid blog'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Blog->delete()) {
			$this->Session->setFlash(__('The blog has been deleted.'));
		} else {
			$this->Session->setFlash(__('The blog could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
