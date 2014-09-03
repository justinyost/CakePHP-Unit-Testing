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
	 * @param  double $basePrice                   the base price to calculate the balance from
	 * @param  boolean $couponBool                 if the coupon is to be applied
	 * @param  int $couponValue                    the value of the coupon, an int that is applied as a total dollar amount or a percentage
	 * @param  string $couponType                  the string defining the coupon type ($/% off)
	 * @param  boolean $cancelationInsuranceBool   if the cancellation insurance is to be applied
	 * @param  double $cancelationInsurancePercent the percentage fee for cancellation insurance
	 * @param  boolean $internationalFeeBool       if the international fee is to be applied
	 * @param  double $internationalFee            the international fee amount (simply added)
	 * @param  double $expectedOutput              the expected output
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
			'Only a base price without a decimal, should return decimal stuff' => array(
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
			'Base Price with an international fee set but no boolean' => array(
				100,
				false,
				null,
				null,
				false,
				null,
				false,
				5,
				100.00,
			),
			'Base Price with a % coupon and an international fee' => array(
				100,
				true,
				10,
				'% off',
				false,
				null,
				true,
				5,
				95.00,
			),
			'Base Price with a $ coupon and an international fee' => array(
				100,
				true,
				20,
				'$ off',
				false,
				null,
				true,
				50,
				130.00,
			),
			'Base Price with a $ coupon and cancellation insurance' => array(
				100,
				true,
				20,
				'$ off',
				true,
				0.10,
				false,
				null,
				90.00,
			),
			'Base Price with a $ coupon and cancellation insurance and an international fee' => array(
				100,
				true,
				20,
				'$ off',
				true,
				0.10,
				true,
				50,
				140.00,
			),
		);
	}
}
