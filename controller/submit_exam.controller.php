<?php


		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
    session_start();
	
		require_once "../model/User.php";

		$examInfo = $_SESSION['toei'];

		# takers data
		$name = $_POST["name"];
		$position = $_POST["position"];
		$ipaddr= $_POST["ipaddr"];

		# handle score before inserting to the table
		#----

		if(isset($_POST['submit'])) {
			# add participant to the participants table		
			$goodId = addParticipants($name, $position, $_POST['teacher_id'], $_SESSION['toei'], 10, $ipaddr);

			# check if takers met the limits
			$limits = takersLimit($examInfo);
			if($limits['takers_count'] > $limits['participants']) {
				header('Location: ../error_pages/exceeds_limit.view.php');
			}

			# add participant to the exam details table
			if($goodId) {
				trackTakersToLimitExaminers(1, $goodId);
				header("Location: ../students_view/exam_view.view.php?n=".$name ."&i=".$goodId."&s=".$examInfo);
			}
		}