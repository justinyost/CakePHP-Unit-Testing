<?php
App::uses('Component', 'Controller');

class MathComponent extends Component {

	/**
	 * square an integer
	 *
	 * @param  integer $integer an input integer to square
	 * @return integer
	 */
	public function squareInteger($integer = 0) {
		return ($integer * $integer);
	}
}