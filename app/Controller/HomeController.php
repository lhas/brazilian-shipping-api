<?php
/**
 * HomeController of the application.
 *
 * Just used to implement the index.
 */
class HomeController extends AppController {

/**
 * Index.
 */
	public function index() {
		// HTTP Status
		$status = 200;

		// Response
		$message = "The brazilian-shipping-api is installed with success. Enjoy! =)";

		// Sent to the view
		$this->set(compact('status', 'message'));
	}
}