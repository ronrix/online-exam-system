<?php


	# show errors	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	require_once "../model/User.php";

	session_start();

	$userId = explode(":", $_SESSION["userId"])[0];

	# get raw inputs from POST method, sent by JS
	$content = trim(file_get_contents("php://input"));
	$examId = json_decode($content, true)['key'];

	$res = deleteExam($userId, $examId);

	if($res) {
		die(json_encode(["STATUS" => "SUCCESS!"]));
	}
	else {
		die(json_encode(["STATUS" => "SOMETHING WENT WRONG!"]));
	}