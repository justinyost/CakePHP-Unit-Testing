<?php
App::uses('Blog', 'Model');

/**
 * Blog Test Case
 *
 */
class BlogTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.blog',
		'app.tag',
		'app.blogs_tag'
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
	 * test the toggleIsPublished when it will return false
	 *
	 * @return void
	 */
	public function testToggleIsPublishedWithValidIdReturnsFalse() {
		$blogId = "53c69fd8-1b90-4252-9a91-7cb374524da5";

		$blog = $this->Blog->find('first', array(
			'conditions' => array(
				'Blog.id' => $blogId,
			),
		));

		// negate the is_published field, for what saveField will expect as
		// an input
		$blog['Blog']['is_published'] = !$blog['Blog']['is_published'];

		$Blog = $this->getMockForModel('Blog', array('saveField'));
		$Blog->expects($this->once())
			->method('saveField')
			->with('is_published', $blog['Blog']['is_published'])
			->will($this->returnValue(false));

		$result = $Blog->toggleIsPublished($blogId);
		$this->assertEquals(false, $result);
	}

	/**
	 * test the toggleIsPublished method with a valid id
	 *
	 * @dataProvider providerToggleIsPublishedWithValidId
	 * @param  string $input input id for the model method to test with
	 * @return void
	 */
	public function testToggleIsPublishedWithValidId($input) {

		$blog = $this->Blog->find('first', array(
			'conditions' => array(
				'Blog.id' => $input,
			),
		));

		$blog['Blog']['is_published'] = !$blog['Blog']['is_published'];

		$result = $this->Blog->toggleIsPublished($input);
		$this->assertEquals(true, $result);
	}

	/**
	 * dataProvider for testToggleIsPublishedWithValidId
	 *
	 * @return array
	 */
	public function providerToggleIsPublishedWithValidId() {
		return array(
			array('53c69fd8-5840-45d9-add0-7cb374524da5'),
			array('53c69fd8-c6cc-44ec-a83b-7cb374524da5'),
			array('53c69fd8-1b90-4252-9a91-7cb374524da5'),
		);
	}

	/**
	 * test the toggleIsPublished method with an invalid id
	 *
	 * @return void
	 */
	public function testToggleIsPublishedInvalidId() {
		$id = '53bccb57-f114-474f-bbb7-5ef964524da5';

		$this->setExpectedException('NotFoundException');
		$result = $this->Blog->toggleIsPublished($id);

	}
}
