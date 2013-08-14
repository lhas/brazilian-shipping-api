<?php
/**
 * The Zip Codes Controller.
 */
class ZipcodesController extends AppController {

/**
 * Get some parameters and returns data about the zipcode used.
 */
	public function index($zipcode = null, $source = 'correiocontrol') {
		// No use view
		$this->autoRender = false;

		// Sanitize the zipcode
		$zipcode = $this->Zipcode->sanitize($zipcode);

		// Creates the JSON attributes to format
		$json = array(
			'status' => 200,
			'message' => 'Success',
			'zipcode' => $zipcode
		);

		// If the zipcode isn't on the format correct, error
		if(strlen($zipcode) != 8) {
			// HTTP Status
			$json['status'] = 500;

			// Message
			$json['message'] = 'The zipcode used is not in the format correct.';
		}

		// If the status is success
		if($json['status'] == 200) {

			// Get the Zipcode informations based on source
			switch($source) {
				case 'correiocontrol':
					// Import de HttpSocket library
					App::uses('HttpSocket', 'Network/Http');

					// Generates an HttpSocket object
					$HttpSocket = new HttpSocket();

					// Executes the cURL requisition on correiocontrol.com.br
					$response = $HttpSocket->get('http://cep.correiocontrol.com.br/' . $zipcode . '.json');

					// Generates an JSON object from the response
					$jsonResponse = json_decode($response);

					// Manipulates the response
					$json['address'] = $jsonResponse->logradouro;
					$json['neighbourhood'] = $jsonResponse->bairro;
					$json['state'] = $jsonResponse->uf;
					$json['city'] = $jsonResponse->localidade;
				break;
			}
		}

		// Returns JSON format
		echo json_encode($json);
	}
}