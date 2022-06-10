<?php


		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
    session_start();
	
		require_once "../model/User.php";

		$examInfo = $_POST['toei'];

		# takers data
		$name = $_POST["name"];
		$position = $_POST["position"];
		$ipaddr= $_POST["ipaddr"];
		$tid = $_POST["t_id"];
		$eid = $_POST["eid"];

		# handle score before inserting to the table
		#----
		# get answer for the exam
		$examAnswers = getAnswerForExam($eid);
		$convertToArray = json_decode($examAnswers[0]['q_json']);



	# if exam has no answer or exam questions are more on essays, return message
		$checker = 0;
		foreach(json_decode($examAnswers[0]['q_json'], true) as $ans) {
			if($ans['answer'] == "") {
				$checker = 1;
			}
		}

		# check if takers met the limits
		$limits = takersLimit($examInfo);
		if($limits[0]['takers_count'] > $limits[0]['participants']) {
			header('Location: ../error_pages/exceeds_limit.view.php');
		}

		# get only answers from $_POST	
		function array_except($array, $keys) {
			return array_diff_key($array, array_flip((array) $keys));   
		} 

		$inputAnswers = array_except($_POST, ['position', 'name', 'ipaddr', 'toei', 'eid', 't_id', 'submit']);
		$theAnswer = []; 
		foreach($convertToArray as $a) {
			array_push($theAnswer, $a->answer);
		}

		# compare exam answer with input answers
		$score = 0;
		foreach($inputAnswers as $key => $value) {
			if($value == $theAnswer[substr($key, -1)]){
				$score++;
			}	
		}

		# add participants along with score
		addParticipants($name, $position, $_POST['t_id'], $eid, $score, $ipaddr);
		
		# add participant to the exam details table, tracking participants 
		$limitResults = trackTakersToLimitExaminers(1, $eid);
		if($limitResults == 3) {
			header("Location: ../students_view/exam_view.view.php?n=".$name ."&i=".$eid."&s=".$examInfo);
		}

		# save score
		foreach(json_decode($examAnswers[0]['q_json'], true) as $ans) {
			if($ans['answer'] == "") {
				$checker = 1;
			}
		}

		if($checker) {
			header("Location: ../view/app/display/submitted_msg.view.php?toei=".$examInfo."&score=0");
		}
		else {
			header("Location: ../view/app/display/submitted_msg.view.php?toei=".$examInfo."&score=".$score);
		}