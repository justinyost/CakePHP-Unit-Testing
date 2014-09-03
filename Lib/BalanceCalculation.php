<?php
/**
 * Total = (BasePrice  - Coupon Discount) + CancelationInsuranceCost + International Fee
 */
class BalanceCalculation {

	/**
	 * this method calculates the balance based upon the passed in parameters
	 *
	 * @param  double $basePrice                   the base price to calculate the balance from
	 * @param  boolean $couponBool                 if the coupon is to be applied
	 * @param  int $couponValue                    the value of the coupon, an int that is applied as a total dollar amount or a percentage
	 * @param  string $couponType                  the string defining the coupon type ($/% off)
	 * @param  boolean $cancelationInsuranceBool   if the cancellation insurance is to be applied
	 * @param  double $cancelationInsurancePercent the percentage fee for cancellation insurance
	 * @param  boolean $internationalFeeBool       if the international fee is to be applied
	 * @param  double $internationalFee            the international fee amount (simply added)
	 * @return double
	 */
	public static function returnBalance($basePrice, $couponBool, $couponValue, $couponType, $cancelationInsuranceBool, $cancelationInsurancePercent, $internationalFeeBool, $internationalFee) {

		// the running balance total
		$runningTotal = 0;

		$runningTotal = floatval($basePrice);

		if($couponType == '$ off' && $couponBool) {
			$runningTotal = $runningTotal - floatval(abs($couponValue));
		} else if ($couponType == '% off' && $couponBool) {
			$runningTotal = $runningTotal - floatval(abs(($runningTotal * ($couponValue/100))));
		}

		if ($cancelationInsuranceBool) {
			$insuranceCost = floatval($basePrice) * $cancelationInsurancePercent;
			$runningTotal = $runningTotal + floatval($insuranceCost);
		} else {
		}

		if ($internationalFeeBool) {
			$runningTotal = $runningTotal + floatval($internationalFee);
		} else {
		}

		return floatval($runningTotal);
	}
}
