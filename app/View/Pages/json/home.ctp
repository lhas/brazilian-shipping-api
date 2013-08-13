<?php
/**
 * JSON attributes.
 */
	$json = array(
		"status" => 200,
		"message" => "The brazilian-shipping-api is installed with success. Enjoy! =)"
	);

/**
 * Encode the array in JSON format with json_encode().
 */
	echo json_encode($json);