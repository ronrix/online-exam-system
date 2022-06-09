<?php

	# show errors	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	session_start();
	require_once("../model/User.php");

	# get the email only
	$userId = explode(":", $_SESSION["userId"])[0];
 
	# get raw inputs from POST method, sent by JS
	$content = trim(file_get_contents("php://input"));
	$eid = json_decode($content, true)['eid'];

	$result = startExam($eid);

	if($result) {
		die(json_encode(['status' => 'SUCCESS']));
	}
	else {
		die(json_encode(['status' => 'ERROR']));
	}