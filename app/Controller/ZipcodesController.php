<?php
/**
 * The Zip Codes Controller.
 */
class ZipcodesController extends AppController {

/**
 * Get some parameters and returns data about the zipcode used.
 */
	public function index($zipcode = null, $source = 'correiocontrol') {

		// Sanitize the zipcode
		$zipcode = $this->Zipcode->sanitize($zipcode);

		// HTTP Status by Default
		$status = 200;

		// Message by Default
		$message = 'Success';

		// If the zipcode isn't on the format correct, error
		if(strlen($zipcode) != 8) {
			// HTTP Status
			$status = 500;

			// Message
			$message = 'The zipcode used is not in the format correct.';
		}

		// Creates the JSON attributes to format
		$json = array(
			'status' => $status,
			'message' => $message,
			'zipcode' => $zipcode
		);

		// Returns JSON format
		echo json_encode($json);
	}
}