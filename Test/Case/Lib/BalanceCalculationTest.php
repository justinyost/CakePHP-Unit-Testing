<?php
App::uses('BalanceCalculation', 'Lib');

class BalanceCalculationTest extends CakeTestCase {

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->BalanceCalculation);
		parent::tearDown();
	}

	/**
	 * test the returnBalance function
	 *
	 * @dataProvider providerReturnBalance
	 * @return [type] [description]
	 */
	public function testReturnBalance($basePrice, $couponBool, $couponValue, $couponType, $cancelationInsuranceBool, $cancelationInsurancePercent, $internationalFeeBool, $internationalFee, $expectedOutput) {
		$this->assertEquals($expectedOutput, BalanceCalculation::returnBalance($basePrice, $couponBool, $couponValue, $couponType, $cancelationInsuranceBool, $cancelationInsurancePercent, $internationalFeeBool, $internationalFee));
	}

	/**
	 * [providerReturnBalance description]
	 * @return [type] [description]
	 */
	public function providerReturnBalance() {
		return array(
			'Only a simple base price' => array(
				100.00,
				false,
				null,
				null,
				false,
				null,
				false,
				null,
				100.00,
			),
			'Only a base price without a decimal' => array(
				100,
				false,
				null,
				null,
				false,
				null,
				false,
				null,
				100.00,
			),
			'Base Price with a % coupon' => array(
				100,
				true,
				10,
				'% off',
				false,
				null,
				false,
				null,
				90.00,
			),
			'Base Price with a $ coupon' => array(
				100,
				true,
				20,
				'$ off',
				false,
				null,
				false,
				null,
				80.00,
			),
		);
	}
}
