<?php


	echo "<pre>";
		var_dump($_POST);
	echo "</pre>";
	var_dump($_POST['data']);

	echo "<pre>";
	json_decode($_POST['data']);
	echo "</pre>";

?>