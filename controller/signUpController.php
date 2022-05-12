<?php

	include_once "../model/User.php";

	session_start();


	$fullname = $_POST["firstname"] . " " . $_POST['lastname'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$schoolname = $_POST['schoolname'];
	$addr = $_POST['address'];

	echo $fullname . $email .$password . $schoolname . $addr;
	$res = insertUser($fullname, $email, $password, $schoolname, $addr);
	if(!$res) {
		die("something went wrong! ");
	}
	else {

		$_SESSION['userId'] = $email. ":" . $password;

		close_connection();
		header("Location: ./signup_redirect.controller.php");
	}