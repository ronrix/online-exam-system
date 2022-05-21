<?php

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
    session_start();
	
		require_once "../model/User.php";

		function getIPAddress() {  
			//whether ip is from the share internet  
			if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
									$ip = $_SERVER['HTTP_CLIENT_IP'];  
					}  
			//whether ip is from the proxy  
			elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
									$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
			}  
	//whether ip is from the remote address  
			else{  
							$ip = $_SERVER['REMOTE_ADDR'];  
			}  
			return $ip;  
		}  

		# get information from the database based on the queries or url parameters

		$randomStringId =  $_GET["toei"] ? $_GET['toei'] : "";
		$eid = $_GET['eid'];


		$ipaddr = getIPAddress();

		# check if ipaddr has already store, then prevent them from taking the exam again
		$takersIp = getTakerViaIPAddr($ipaddr, $eid);

		if($takersIp[0]) {
			header("Location: ../error_pages/exam_viewed.view.php");
		}

		$valid = randomStringID($randomStringId);
		if(!$valid) {
			header("Location: ../error_pages/expired.view.php");
		}

	$results = getExamInfoWithRandomStrings($valid[0]['examID']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Take Exam</title>

	<!-- bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
	</script>

	<!-- icons -->
	<link rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css"
		integrity="sha512-Oy+sz5W86PK0ZIkawrG0iv7XwWhYecM3exvUtMKNJMekGFJtVAhibhRPTpmyTj8+lJCkmWfnpxKgT2OopquBHA=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />

	<!-- font -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="../css/colors.css">

	<style>
	.title {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		font-size: 15px;
	}

	.label_text {
		font-size: 14px;
	}
	</style>


</head>

<body style="background-color: #f2f2f2;">
	<div class="p-2 bg-primary text-light">
		<div class="container">
			<h4>Online Exam</h4>
		</div>
	</div>

	<div class="container rounded-3">
		<form action="../controller/submit_exam.controller.php" class="mt-4 p-2" method="POST"
			style="background-color: white;">

			<div class="p-2 row gx-1  rounded-3 d-flex" style="background-color: #edebeb;">
				<div class="col-2 bg-primary d-flex justify-content-center align-items-center p-3"
					style="width: 10px; height: 70px;">
					<i class="bi bi-person-fill text-light"></i>
				</div>
				<div class="col">
					<label for="name" class="fw-bold label_text">name </label>
					<input type="text" name="name" id="name" class="form-control" required>
				</div>
			</div>

			<div class="p-2 row gx-1  rounded-3 d-flex" style="background-color: #edebeb;">
				<div class="col-2 bg-primary d-flex justify-content-center align-items-center p-3"
					style="width: 10px; height: 70px;">
					<i class="bi bi-person-lines-fill text-light"></i>
				</div>
				<div class="col">
					<label for="position" class="fw-bold label_text">What are you?</label>
					<select name="position" id="position" class="form-control" required>
						<option value="">Select Here</option>
						<option value="student">-Student</option>
						<option value="employee">-Employee</option>
						<option value="other">-Other</option>
					</select>
				</div>
			</div>

			<?php foreach(json_decode($results[0]['q_json']) as $key => $res): ?>
			<div class="row mt-2 p-4">
				<h5><?php echo $key + 1 . ". " . $res->q; ?></h5>
				<?php if($res->select == 'essay'): ?>
				<textarea name="textarea" id="" cols="100" rows="2"></textarea>
				<?php elseif($res->select == 'checkbox'): ?>
				<?php foreach($res->options as $o) : ?>
				<ul class="list-group">
					<li class="list-group-item">
						<input type="checkbox" name="checkbox<?php echo $key; ?>[]" value="<?php echo $o ?>"> <?php echo $o; ?>
					</li>
				</ul>
				<?php endforeach; ?>
				<?php else: ?>
				<?php foreach($res->options as $o) : ?>
				<ul class="list-group">
					<li class="list-group-item">
						<input type="radio" name="radio<?php echo $key; ?>" value="<?php echo $o ?>"> <?php echo $o; ?>
					</li>
				</ul>
				<?php endforeach; ?>

				<?php endif; ?>
			</div>
			<?php endforeach; ?>

			<input type="hidden" name="ipaddr" value="<?php echo $ipaddr ?>" />
			<input type="hidden" name="toei" value="<?php echo $_GET['toei']; ?>" />
			<input type="hidden" name="eid" value="<?php echo $valid[0]['examID']; ?>" />
			<input type="hidden" name="t_id" value="<?php echo $valid[0]['userID']; ?>" />

			<div class="d-flex align-items-center justify-content-end flex-column">
				<input type="submit" name="submit" value="submit"
					class="text-uppercase btn btn-primary mt-4 fw-bold align-self-sm-stretch align-self-md-end">
			</div>
			<p class="mt-2 text-center text-muted">Note: Once you take this exam, you can't retake it again!</p>
		</form>
	</div>

</body>

</html>