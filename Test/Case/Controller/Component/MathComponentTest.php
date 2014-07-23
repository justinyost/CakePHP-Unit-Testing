<?php
App::uses('Controller', 'Controller');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');
App::uses('ComponentCollection', 'Controller');
App::uses('MathComponent', 'Controller/Component');

// A fake controller to test against
class MathControllerTest extends Controller {
}

/**
 * MathComponentTest Test Case
 *
 */
class MathComponentTest extends CakeTestCase {
	public $MathComponent = null;
	public $Controller = null;

	/**
	 * setUp the needed stuff for our tests
	 *
	 */
	public function setUp() {
		parent::setUp();
		// Setup our component and fake test controller
		$Collection = new ComponentCollection();
		$this->MathComponent = new MathComponent($Collection);
		$CakeRequest = new CakeRequest();
		$CakeResponse = new CakeResponse();
		$this->Controller = new MathControllerTest($CakeRequest, $CakeResponse);
		$this->MathComponent->startup($this->Controller);
	}

	/**
	 * Destroy any artifacts created for the test.
	 *
	 */
	public function tearDown() {
		parent::tearDown();
		unset($this->MathComponent);
		unset($this->Controller);
	}

	/**
	 * test the squareInteger method
	 *
	 * @dataProvider providerSquareInteger
	 * @param  integer $output expected output for squareInteger
	 * @param  integer $input  test input value for squareInteger
	 * @return void
	 */
	public function testSquareInteger($output, $input) {
		$this->assertEquals($output, $this->MathComponent->squareInteger($input));
	}

	/**
	 * dataProvider for testSquareInteger
	 *
	 * @return array
	 */
	public function providerSquareInteger() {
		return array(
			'3 => 9' => array(9, 3),
			'2 => 4' => array(4, 2),
			'0 => 0' => array(0, 0),
			'1 => 1' => array(1, 1),
			'-1 => 1' => array(1, -1),
			'-2 => 4' => array(4, -2),
		);
	}
}