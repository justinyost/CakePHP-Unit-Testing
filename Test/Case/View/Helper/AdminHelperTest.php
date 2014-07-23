<?php
App::uses('Controller', 'Controller');
App::uses('View', 'View');
App::uses('AdminHelper', 'View/Helper');

/**
 * TestHelper Test Case
 *
 */
class AdminHelperTest extends CakeTestCase {

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$Controller = new Controller();
		$View = new View($Controller);
		$this->Admin = new AdminHelper($View);
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->Admin);
		parent::tearDown();
	}

	/**
	 * test timeAgo method
	 *
	 * @dataProvider providerTimeAgo
	 * @return void
	 */
	public function testTimeAgo($expected, $testValue) {
		$this->assertEquals($expected, $this->Admin->timeAgo($testValue));
	}

	/**
	 * dataProvider for testTimeAgo
	 *
	 * @return array
	 */
	public function providerTimeAgo() {
		return array(
			'Empty String' => array('on '. date('Y-m-d', 0), ''),
			'Null String' => array('on '. date('Y-m-d', 0), null),
			'0 String' => array('on '. date('Y-m-d', 0), 0),
			'Unix Timestamp' => array("on 2004-09-24", '1096009200'),
			'DateTime String' => array("on 2000-10-10", '10 Oct 2000'),
			'Recent Timestamp' => array("3 weeks ago", strtotime("-3 weeks")),
		);
	}

	/**
	 * test modified method
	 *
	 * @dataProvider providerModified
	 * @return void
	 */
	public function testModified($expected, $testValue) {
		$this->assertEquals($expected, $this->Admin->modified($testValue));
	}

	/**
	 * dataProvider for testModified
	 *
	 * @return array
	 */
	public function providerModified() {
		return array(
			'Empty String' => array('on '. date('Y-m-d', 0), ''),
			'Null String' => array('Never', null),
			'0 String' => array('on '. date('Y-m-d', 0), 0),
			'Unix Timestamp' => array("on 2004-09-24", '1096009200'),
			'dateTime String' => array("on 2000-10-10", '10 Oct 2000'),
		);
	}

	/**
	 * tests the yesNo method
	 *
	 * @dataProvider providerYesNo
	 * @return void
	 */
	public function testYesNo($expected, $input) {
		$this->assertEquals($expected, $this->Admin->yesNo($input));
	}

	/**
	 * dataProvider for testYesNo method
	 *
	 * @return array
	 */
	public function providerYesNo() {
		return array(
			'True Boolean' => array('Yes', true),
			'False Boolean' => array('No', false),
			'Null' => array('No', null),
		);
	}
}