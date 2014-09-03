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
		parent::tearDown();
	}

	/**
	 * test the returnBalance method
	 *
	 * @dataProvider providerReturnBalance
	 * @param  [type] $basePrice                   [description]
	 * @param  [type] $couponBool                  [description]
	 * @param  [type] $couponValue                 [description]
	 * @param  [type] $couponType                  [description]
	 * @param  [type] $cancelationInsuranceBool    [description]
	 * @param  [type] $cancelationInsurancePercent [description]
	 * @param  [type] $internationalFeeBool        [description]
	 * @param  [type] $internationalFee            [description]
	 * @param  [type] $expectedOutput              [description]
	 * @return void
	 */
	public function testReturnBalance($basePrice, $couponBool, $couponValue, $couponType, $cancelationInsuranceBool, $cancelationInsurancePercent, $internationalFeeBool, $internationalFee, $expectedOutput) {
		$this->assertEquals($expectedOutput, BalanceCalculation::returnBalance($basePrice, $couponBool, $couponValue, $couponType, $cancelationInsuranceBool, $cancelationInsurancePercent, $internationalFeeBool, $internationalFee));
	}

	/**
	 * dataProvider for testReturnBalance
	 * @return array test data input/outputs for testReturnBalance method
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
			'Base Price with a cancellation insurance' => array(
				100,
				false,
				null,
				null,
				true,
				0.10,
				false,
				null,
				110.00,
			),
			'Base Price with an international fee' => array(
				100,
				false,
				null,
				null,
				false,
				null,
				true,
				5,
				105.00,
			),
			'Base Price with an international fee and cancellation insurance' => array(
				100,
				false,
				null,
				null,
				true,
				0.10,
				true,
				5,
				115.00,
			),
		);
	}
}
