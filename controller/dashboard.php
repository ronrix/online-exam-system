<?php

		session_start();

		$userInfo = $_SESSION["userId"];

		echo json_encode($userInfo, JSON_PRETTY_PRINT);