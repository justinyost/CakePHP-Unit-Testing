<?php
/**
 * Total = (BasePrice  - Coupon Discount) + CancelationInsuranceCost + International Fee
 * CancelationInsuranceCost = (BasePrice * CancellationInsurancePercent)
 * CouponDiscountDollar = BasePrice - CouponDollarValue
 * CouponDiscoutPercentage = BasePrice - (CouponValuePercent * BasePrice)
 */
class BalanceCalculation {

	protected $coupon = array(
		'couponBool' => false, // true or false
		'couponValue' => 0, // double 10 or 10.1
		'couponType' => '', // '$ off' or '% off'
	);

	protected $cancelationInsurance = false; // default not set

	protected $internationalFee = false; // default is not set

	protected $basePrice = 0; // default is 0

	public function __construct($basePrice) {
		$this->setBasePrice($basePrice);
	}

	public function setBasePrice($basePrice) {
		$this->basePrice = floatval($basePrice);
		return $this;
	}

	public function getBasePrice() {
		return $this->basePrice;
	}

	/**
	 * set coupon data
	 *
	 * @param array $couponData CouponBool, CouponValue, CouponType
	 */
	public function setCoupon($couponData) {
		if ($couponData['couponType'] == '$ off') {
			$couponData['couponValue'] = floatval(abs($couponData['couponValue']));
		}

		$this->coupon = $couponData;
		return $this;
	}

	public function getCoupon() {
		return $this->coupon;
	}

	public function setCancelationInsurance($cancelationInsuranceBool, $cancelationInsurancePercent) {
		$this->cancelationInsurance = ($cancelationInsuranceBool ? floatval($cancelationInsurancePercent) : false);
		return $this;
	}

	public function getCancelationInsurance() {
		return $this->cancelationInsurance;
	}

	public function setInternationalFee($internataionalFeeBool, $internationalFeeAmount) {
		$this->internationalFee = ($internataionalFeeBool ? floatval($internationalFeeAmount) : false);
		return $this;
	}

	public function getInternationalFee() {
		return $this->internationalFee;
	}

	/**
	 * this method calculates the balance based upon the class parameters
	 *
	 * @return double returns the balance after being calculated
	 */
	public function call() {
		return $this->applyInternationalFee(
			$this->applyCancelationInsurance(
				$this->applyCoupon(
					$this->getBasePrice()
				)
			)
		);
	}

	protected function applyInternationalFee($runningTotal) {
		if ($this->internationalFee !== false) {
			$runningTotal = $runningTotal + $this->internationalFee;
		}

		return floatval($runningTotal);
	}

	protected function applyCancelationInsurance($runningTotal) {
		if ($this->cancelationInsurance !== false) {
			$insuranceCost = $this->getBasePrice() * $this->cancelationInsurance;
			$runningTotal = $runningTotal + floatval($insuranceCost);
		}

		return floatval($runningTotal);
	}

	protected function applyCoupon($runningTotal) {
		if (!$this->coupon['couponBool']) {
			return $runningTotal;
		}

		if ($this->coupon['couponType'] == '$ off') {
			$runningTotal -= $this->coupon['couponValue'];
		} elseif ($this->coupon['couponType'] == '% off') {
			$runningTotal -= floatval(abs(($runningTotal * ($this->coupon['couponValue']/100))));
		}

		return floatval($runningTotal);
	}
}
