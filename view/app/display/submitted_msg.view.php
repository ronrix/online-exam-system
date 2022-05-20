<?php

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);

		require_once "../../../model/User.php";


		$info = $_GET["toei"];
		$score = $_GET["score"];
		$verified = getVerifiedWithString($info);

		if(!$verified) {
			header("Locatin: ../../../error_pages/error.view.php");
		}

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

<body class="d-flex justify-content-center" style="background-color: #f2f2f2;">

	<div class="text-center">
		<i class="bi bi-check-circle-fill text-success" style="font-size: 50px;"></i>
		<?php if($score != 0): ?>
		<h3>Your score is <?php echo $score; ?></h3>
		<?php endif; ?>
		<h3>SUBMITTED!</h3>
		<p class="font-monospace text-muted">thank you for submitting!</p>
	</div>

</body>

</html>