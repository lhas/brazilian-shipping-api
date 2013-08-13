<?php
/**
 * JSON attributes.
 */
	$json = array(
		"status" => $status,
		"message" => $message
	);

/**
 * Encode the array in JSON format with json_encode().
 */
	echo json_encode($json);