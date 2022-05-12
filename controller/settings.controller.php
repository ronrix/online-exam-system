<?php 

	# show errors	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
		
	session_start();

	require_once "../model/User.php";

	# get the email only
	$id = explode(":", $_SESSION["userId"])[0];

	/* Receive the RAW post data. */
	$content = trim(file_get_contents("php://input"));
	$decodeContent = json_decode($content, true);

	# make title lowercase and trim any space
	$title = str_replace(' ', '', $decodeContent['title']);

	$result = editUserInfo($title, $decodeContent['value'], $id);

	if($result) {
		die(json_encode(["status" => "SUCCESS"]));
	}
	else {
		die(json_encode(['status' => 'ERROR']));
	}