<?php
App::uses('BlogsController', 'Controller');

/**
 * BlogsController Test Case
 *
 */
class BlogsControllerTest extends ControllerTestCase {

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = array(
		'app.blog',
		'app.tag',
		'app.blogs_tag',
	);

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->Blog = ClassRegistry::init('Blog');
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->Blog);

		parent::tearDown();
	}

	/**
	 * test the index method
	 *
	 * @return void
	 */
	public function testIndex() {
		$result = $this->testAction(
			'/blogs/index',
			array('return' => 'vars')
		);
		$this->assertArrayHasKey('blogs', $result);
		$this->assertGreaterThan(0, count($result['blogs']));
		$this->assertLessThan(21, count($result['blogs']));
	}

	/**
	 * test the view method with an id that exists
	 *
	 * @return void
	 */
	public function testViewIdExists() {
		$blogId = '53c69fd8-5840-45d9-add0-7cb374524da5';
		$result = $this->testAction(
			'/blogs/view/' . $blogId,
			array('return' => 'vars')
		);
		$this->assertArrayHasKey('blog', $result);
		$this->assertArrayHasKey('Blog', $result['blog']);
		$this->assertEquals($blogId, $result['blog']['Blog']['id']);
	}

	/**
	 * test the view method with an id that does not exists
	 *
	 * @return void
	 */
	public function testViewIdDoesNotExists() {
		$blogId = '0000';
		$this->setExpectedException('NotFoundException');
		$result = $this->testAction(
			'/blogs/view/' . $blogId,
			array('return' => 'vars')
		);
	}

	/**
	 * validate data set for the add get request
	 *
	 * @return void
	 */
	public function testAddGetRequest() {
		// test the add function - get request
		$result = $this->testAction(
			'/blogs/add/',
			array('return' => 'vars', 'method' => 'get')
		);
		$this->assertArrayHasKey('tags', $result);
	}

	/**
	 * validate that the add function with post data, adds a new blog record
	 *
	 * @return void
	 */
	public function testAddPostRequestValidData() {
		$Blogs = $this->generate('Blogs', array(
			'components' => array(
				//'Auth' => array('user')
			)
		));
		/*
		$Blogs->Auth
			->staticExpects($this->any())
			->method('user')
			->will($this->returnValue('52e00e3e-0210-41ce-b2ec-3e95b368309d'));
		*/

		// test the add function - post request - redirected to index
		$data = array(
			'Blog' => array(
				'title' => 'Test New Blog',
				'body' => 'This is a sample new blog post',
			)
		);
		$result = $this->testAction(
			'/blogs/add/',
			array('data' => $data, 'method' => 'post')
		);
		$this->assertEquals(1, $this->Blog->find('count', array(
			'conditions' => array(
				'Blog.title' => 'Test New Blog',
			),
		)));
		$this->assertStringEndsWith("/blogs", $this->headers['Location']);
	}

	/**
	 * validate that the add function with invalid data, fails properly
	 *
	 * @return void
	 */
	public function testAddPostRequestInvalidData() {
		$Blogs = $this->generate('Blogs', array(
			'components' => array(
				//'Auth' => array('user')
			),
			'models' => array(
				'Blog' => array('save')
			),
		));
		/*
		$Blogs->Auth
			->staticExpects($this->any())
			->method('user')
			->will($this->returnValue('52e00e3e-0210-41ce-b2ec-3e95b368309d'));
		*/

		$Blogs->Blog
			->expects($this->once())
			->method('save')
			->will($this->returnValue(false));

		// test the add function - post request - redirected to index
		$data = array(
			'Blog' => array(
				'title' => 'Test New Blog',
				'body' => 'This is a sample new blog post',
			)
		);
		$result = $this->testAction(
			'/blogs/add/',
			array('data' => $data, 'method' => 'post')
		);
		$this->assertEquals(0, $this->Blog->find('count', array(
			'conditions' => array(
				'Blog.title' => 'Test New Blog',
			),
		)));
	}

	/**
	 * test the edit method with the get request
	 *
	 * @return void
	 */
	public function testEditGetRequest() {
		$blogId = '53c69fd8-5840-45d9-add0-7cb374524da5';
		// test the edit function - get request
		$result = $this->testAction(
			'/blogs/edit/' . $blogId,
			array('return' => 'vars', 'method' => 'get')
		);

		$this->assertArrayHasKey('tags', $result);
	}

	/**
	 * validate that the edit method with valid post data, edits the record
	 *
	 * @return void
	 */
	public function testEditPostRequestValidData() {
		$blogId = '53c69fd8-5840-45d9-add0-7cb374524da5';
		$blogTitle = 'This is an edited blog record';

		$Blogs = $this->generate('Blogs', array(
			'components' => array(
				//'Auth' => array('user')
			)
		));
		/*
		$Blogs->Auth
			->staticExpects($this->any())
			->method('user')
			->will($this->returnValue('52e00e3e-0210-41ce-b2ec-3e95b368309d'));
		*/

		// test the edit function - post request - redirected to index
		$data = array(
			'Blog' => array(
				'id' => $blogId,
				'title' => $blogTitle,
				'text' => 'Lorem ipsum dolor sit',
				'is_published' => 1,
			)
		);
		$result = $this->testAction(
			'/blogs/edit/'. $blogId,
			array('data' => $data, 'method' => 'post')
		);
		$this->assertEquals(1, $this->Blog->find('count', array(
			'conditions' => array(
				'Blog.id' => $blogId,
				'Blog.title' => $blogTitle,
			),
		)));
		$this->assertStringEndsWith("/blogs", $this->headers['Location']);
	}

	/**
	 * test the edit method with a post request and failed saving
	 *
	 * @return void
	 */
	public function testEditPostRequestInvalidData() {

		$blogId = '53c69fd8-5840-45d9-add0-7cb374524da5';
		$blogTitle = 'This is an edited blog record';

		$Blogs = $this->generate('Blogs', array(
			'components' => array(
				//'Auth' => array('user')
			),
			'models' => array(
				'Blog' => array('save')
			),
		));

		$Blogs->Blog
			->expects($this->once())
			->method('save')
			->will($this->returnValue(false));

		/*
		$Blogs->Auth
			->staticExpects($this->any())
			->method('user')
			->will($this->returnValue('52e00e3e-0210-41ce-b2ec-3e95b368309d'));
		*/

		// test the edit function - post request - redirected to index
		$data = array(
			'Blog' => array(
				'id' => $blogId,
				'title' => $blogTitle,
				'text' => 'Lorem ipsum dolor sit',
				'is_published' => 1,
			)
		);
		$result = $this->testAction(
			'/blogs/edit/'. $blogId,
			array('data' => $data, 'method' => 'post')
		);
		$this->assertEquals(0, $this->Blog->find('count', array(
			'conditions' => array(
				'Blog.id' => $blogId,
				'Blog.title' => $blogTitle,
			),
		)));
	}

	/**
	 * test the edit method when the object is not found
	 *
	 * @return void
	 */
	public function testEditNotFoundException() {
		// test exception returned on non-existent blog
		$blogId = '0000';
		$this->setExpectedException('NotFoundException');
		$this->testAction(
			'/blogs/edit/' . $blogId
		);
	}

	/**
	 * test the delete method when the object is not found
	 *
	 * @return void
	 */
	public function testDeleteNotFoundException() {
		$blogId = '0000';
		$this->setExpectedException('NotFoundException');
		$this->testAction(
			'/blogs/delete/' . $blogId
		);
	}

	/**
	 * test the delete method when using the incorrected method
	 *
	 * @return void
	 */
	public function testDeleteMethodNotAllowedException() {
		$blogId = '53c69fd8-5840-45d9-add0-7cb374524da5';
		$this->setExpectedException('MethodNotAllowedException');
		$this->testAction(
			'/blogs/delete/' . $blogId,
			array('method' => 'get')
		);
	}

	/**
	 * test the delete method when using the correct method
	 *
	 * @return void
	 */
	public function testDeleteValidDeletion() {
		$blogId = '53c69fd8-5840-45d9-add0-7cb374524da5';
		$this->testAction(
			'/blogs/delete/' . $blogId,
			array('method' => 'post')
		);
		$this->assertStringEndsWith("/blogs", $this->headers['Location']);
		$this->assertEquals(array(), $this->Blog->findById($blogId));
	}

	/**
	 * test the delete method when delete fails
	 *
	 * @return void
	 */
	public function testDeleteInvalidDeletion() {
		$blogId = '53c69fd8-5840-45d9-add0-7cb374524da5';

		$Blogs = $this->generate('Blogs', array(
			'models' => array(
				'Blog' => array('delete')
			),
		));
		$Blogs->Blog
			->expects($this->once())
			->method('delete')
			->will($this->returnValue(false));
		$this->testAction(
			'/blogs/delete/' . $blogId,
			array('method' => 'post')
		);
		$this->assertStringEndsWith("/blogs", $this->headers['Location']);
		$this->assertEquals(1, $this->Blog->find('count', array(
			'conditions' => array(
				'Blog.id' => $blogId,
			),
		)));
	}

}