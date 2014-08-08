<?php
App::uses('TagsController', 'Controller');

/**
 * TagsController Test Case
 *
 */
class TagsControllerTest extends ControllerTestCase {

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = array(
		'app.tag',
		'app.blog',
		'app.blogs_tag',
	);

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->Tag = ClassRegistry::init('Tag');
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->Tag);

		parent::tearDown();
	}

	/**
	 * test the index method
	 *
	 * @return void
	 */
	public function testIndex() {
		$result = $this->testAction(
			'/tags/index',
			array('return' => 'vars', 'method' => 'get')
		);
		$this->assertArrayHasKey('tags', $result);
		$this->assertGreaterThan(0, count($result['tags']));
		$this->assertLessThan(21, count($result['tags']));
	}

	/**
	 * test the view method with an id that exists
	 *
	 * @return void
	 */
	public function testViewIdExists() {
		$tagId = '53bccb61-6244-4799-a9ce-5ef974524da5';
		$result = $this->testAction(
			'/tags/view/' . $tagId,
			array('return' => 'vars', 'method' => 'get')
		);
		$this->assertArrayHasKey('tag', $result);
		$this->assertArrayHasKey('Tag', $result['tag']);
		$this->assertEquals($tagId, $result['tag']['Tag']['id']);
	}

	/**
	 * test the view method with an id that does not exists
	 *
	 * @return void
	 */
	public function testViewIdDoesNotExists() {
		$tagId = '0000';
		$this->setExpectedException('NotFoundException');
		$result = $this->testAction(
			'/tags/view/' . $tagId,
			array('return' => 'vars', 'method' => 'get')
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
			'/tags/add/',
			array('return' => 'vars', 'method' => 'get')
		);
		$this->assertArrayHasKey('blogs', $result);
	}

	/**
	 * validate that the add function with post data, adds a new tag record
	 *
	 * @return void
	 */
	public function testAddPostRequestValidData() {
		$Tags = $this->generate('Tags', array(
			'components' => array(
				//'Auth' => array('user')
			)
		));
		/*
		$Tags->Auth
			->staticExpects($this->any())
			->method('user')
			->will($this->returnValue('52e00e3e-0210-41ce-b2ec-3e95b368309d'));
		*/

		// test the add function - post request - redirected to index
		$data = array(
			'Tag' => array(
				'tag' => 'Test New Tag',
			)
		);
		$result = $this->testAction(
			'/tags/add/',
			array('data' => $data, 'method' => 'post')
		);
		$this->assertEquals(1, $this->Tag->find('count', array(
			'conditions' => array(
				'Tag.tag' => 'Test New Tag',
			),
		)));
		$this->assertStringEndsWith("/tags", $this->headers['Location']);
	}

	/**
	 * validate that the add function with invalid data, fails properly
	 *
	 * @return void
	 */
	public function testAddPostRequestInvalidData() {
		$Tags = $this->generate('Tags', array(
			'components' => array(
				//'Auth' => array('user')
			),
			'models' => array(
				'Tag' => array('save')
			),
		));
		/*
		$Tags->Auth
			->staticExpects($this->any())
			->method('user')
			->will($this->returnValue('52e00e3e-0210-41ce-b2ec-3e95b368309d'));
		*/

		$Tags->Tag
			->expects($this->once())
			->method('save')
			->will($this->returnValue(false));

		// test the add function - post request - redirected to index
		$data = array(
			'Tag' => array(
				'tag' => 'Test New Tag',
			)
		);
		$result = $this->testAction(
			'/tags/add/',
			array('data' => $data, 'method' => 'post')
		);
		$this->assertEquals(0, $this->Tag->find('count', array(
			'conditions' => array(
				'Tag.tag' => 'Test New Tag',
			),
		)));
	}

	/**
	 * test the edit method with the get request
	 *
	 * @return void
	 */
	public function testEditGetRequest() {
		$tagId = '53bccb61-6244-4799-a9ce-5ef974524da5';
		// test the edit function - get request
		$result = $this->testAction(
			'/tags/edit/' . $tagId,
			array('return' => 'vars', 'method' => 'get')
		);

		$this->assertArrayHasKey('blogs', $result);
	}

	/**
	 * validate that the edit method with valid post data, edits the record
	 *
	 * @return void
	 */
	public function testEditPostRequestValidData() {
		$tagId = '53bccb61-6244-4799-a9ce-5ef974524da5';
		$tagTitle = 'This is an edited tag record';

		$Tags = $this->generate('Tags', array(
			'components' => array(
				//'Auth' => array('user')
			)
		));
		/*
		$Tags->Auth
			->staticExpects($this->any())
			->method('user')
			->will($this->returnValue('52e00e3e-0210-41ce-b2ec-3e95b368309d'));
		*/

		// test the edit function - post request - redirected to index
		$data = array(
			'Tag' => array(
				'id' => $tagId,
				'tag' => $tagTitle,
			)
		);
		$result = $this->testAction(
			'/tags/edit/'. $tagId,
			array(
				'data' => $data,
				'method' => 'post'
			)
		);
		$this->assertEquals(1, $this->Tag->find('count', array(
			'conditions' => array(
				'Tag.id' => $tagId,
				'Tag.tag' => $tagTitle,
			),
		)));
		$this->assertStringEndsWith("/tags", $this->headers['Location']);
	}

	/**
	 * test the edit method with a post request and failed saving
	 *
	 * @return void
	 */
	public function testEditPostRequestInvalidData() {

		$tagId = '53bccb61-6244-4799-a9ce-5ef974524da5';
		$tagTitle = 'This is an edited tag record';

		$Tags = $this->generate('Tags', array(
			'components' => array(
				//'Auth' => array('user')
			),
			'models' => array(
				'Tag' => array('save')
			),
		));

		$Tags->Tag
			->expects($this->once())
			->method('save')
			->will($this->returnValue(false));

		/*
		$Tags->Auth
			->staticExpects($this->any())
			->method('user')
			->will($this->returnValue('52e00e3e-0210-41ce-b2ec-3e95b368309d'));
		*/

		// test the edit function - post request - redirected to index
		$data = array(
			'Tag' => array(
				'id' => $tagId,
				'tag' => $tagTitle,
			)
		);
		$result = $this->testAction(
			'/tags/edit/'. $tagId,
			array(
				'data' => $data,
				'method' => 'post'
			)
		);
		$this->assertEquals(0, $this->Tag->find('count', array(
			'conditions' => array(
				'Tag.id' => $tagId,
				'Tag.tag' => $tagTitle,
			),
		)));
	}

	/**
	 * test the edit method when the object is not found
	 *
	 * @return void
	 */
	public function testEditNotFoundException() {
		// test exception returned on non-existent tag
		$tagId = '0000';
		$this->setExpectedException('NotFoundException');
		$this->testAction('/tags/edit/' . $tagId,
			array(
				'method' => 'get'
			)
		);
	}

	/**
	 * test the delete method when the object is not found
	 *
	 * @return void
	 */
	public function testDeleteNotFoundException() {
		$tagId = '0000';
		$this->setExpectedException('NotFoundException');
		$this->testAction(
			'/tags/delete/' . $tagId,
			array(
				'method' => 'get'
			)
		);
	}

	/**
	 * test the delete method when using the incorrected method
	 *
	 * @return void
	 */
	public function testDeleteMethodNotAllowedException() {
		$tagId = '53bccb61-6244-4799-a9ce-5ef974524da5';
		$this->setExpectedException('MethodNotAllowedException');
		$this->testAction(
			'/tags/delete/' . $tagId,
			array(
				'method' => 'get'
			)
		);
	}

	/**
	 * test the delete method when using the correct method
	 *
	 * @return void
	 */
	public function testDeleteValidDeletion() {
		$tagId = '53bccb61-6244-4799-a9ce-5ef974524da5';
		$this->testAction(
			'/tags/delete/' . $tagId,
			array(
				'method' => 'post'
			)
		);
		$this->assertStringEndsWith("/tags", $this->headers['Location']);
		$this->assertEquals(array(), $this->Tag->findById($tagId));
	}

	/**
	 * test the delete method when delete fails
	 *
	 * @return void
	 */
	public function testDeleteInvalidDeletion() {
		$tagId = '53bccb61-6244-4799-a9ce-5ef974524da5';

		$Tags = $this->generate('Tags', array(
			'models' => array(
				'Tag' => array('delete')
			),
		));
		$Tags->Tag
			->expects($this->once())
			->method('delete')
			->will($this->returnValue(false));
		$this->testAction(
			'/tags/delete/' . $tagId,
			array(
				'method' => 'post'
			)
		);
		$this->assertStringEndsWith("/tags", $this->headers['Location']);
		$this->assertEquals(1, $this->Tag->find('count', array(
			'conditions' => array(
				'Tag.id' => $tagId,
			),
		)));
	}

}