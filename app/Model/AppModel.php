<?php
App::uses('Model', 'Model');

class AppModel extends Model {

/**
 * Sanitize the string, removing all unexpected characters.
 */
	public function sanitize($string = null) {
		return preg_replace("/[^0-9]/", "", $string);
	}
}
