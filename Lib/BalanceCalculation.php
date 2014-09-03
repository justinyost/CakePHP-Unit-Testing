<?php
/**
 * Total = (BasePrice  - Coupon Discount) + CancelationInsuranceCost + International Fee
 */
class BalanceCalculation {

	public static function returnBalance($basePrice, $couponBool, $couponValue, $couponType, $cancelationInsuranceBool, $cancelationInsurancePercent, $internationalFeeBool, $internationalFee) {
		$runningTotal = 0;

		$runningTotal = $basePrice;

		if($couponType == '$ off' && $couponBool) {
			$runningTotal = floatval($runningTotal) - floatval(abs($couponValue));
		} else if ($couponType == '% off' && $couponBool) {
			$runningTotal = floatval($runningTotal) - floatval(abs(($runningTotal * ($couponValue/100))));
		}

		if ($cancelationInsuranceBool) {
			$insuranceCost = $basePrice * $cancelationInsurancePercent;
			$runningTotal = $runningTotal + $insuranceCost;
		} else {
		}

		if ($internationalFeeBool) {
			$runningTotal = $runningTotal + $internationalFee;
		} else {
		}

		return floatval($runningTotal);
	}
}
