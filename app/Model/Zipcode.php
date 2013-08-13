<?php
/**
 * The zipcode Model.
 */
class Zipcode extends AppModel {

/**
 * Sanitize the zipcode, removing all unexpected characters.
 */
	public function sanitize($zipcode = null) {
		return preg_replace("/[^0-9]/", "", $zipcode);
	}
}