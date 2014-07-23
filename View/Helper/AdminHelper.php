<?php
/**
 * Admin helper
 */
class AdminHelper extends AppHelper {

	/**
	 * Other helpers used by this one.
	 *
	 * @var	array
	 */
	public $helpers = array(
		'Time',
	);

	/**
	 * timeAgo
	 *
	 * Wrapper around TimeHelper::timeAgoInWords(), but with a standardized
	 * alternate ::wordFormat.
	 *
	 * @access	public
	 * @param	string	$datetime			Any date/time string that TimeHelper::timeAgoInWords() can handle.
	 * @param	array	$options			An array of options as normally provided as the second argument to TimeHelper::timeAgoInWords().
	 * @return	string						Formatted HTML for timeAgoInWords with a pre-configured output format.
	 */
	public function timeAgo($datetime, $options = array()) {
		$wordFormat = 'Y-m-d';
		$defaultOptions = array('format' => $wordFormat);
		return $this->Time->timeAgoInWords($datetime, array_merge($defaultOptions, $options));
	}

	/**
	 * modified
	 *
	 * Wrapper around ::timeAgo(), but with a standardized fallback case if
	 * the provided $datetime is null.
	 *
	 * @access	public
	 * @param	string	$datetime			Any date/time string that TimeHelper::timeAgoInWords() can handle.
	 * @param	array	$options			An array of options as normally provided as the second argument to TimeHelper::timeAgoInWords().
	 * @return	string						Formatted HTML for timeAgoInWords with a pre-configured output format, or the word 'Never' if the provided var was null.
	 */
	public function modified($datetime, $options = array()) {
		return (is_null($datetime) ? __('Never') : $this->timeAgo($datetime, $options));
	}

	/**
	 * yesNo
	 *
	 * returns Yes or No on a boolean input
	 *
	 * @param  boolean $boolean Boolean to return a value upon, defaults to false
	 * @return string           String either Yes or No
	 */
	public function yesNo($boolean = false) {
		return (($boolean) ? __('Yes') : __('No'));
	}
}