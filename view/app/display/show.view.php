<?php

# show errors	
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require_once '../../../model/User.php';

$key = 0;

# get the email only
$user = explode(":", $_SESSION["userId"]);

if (empty($_SESSION['userId'])) {
	header("Location: ../../index.php");
}

# deleting the session 
if (isset($_POST["logout"])) {
	session_unset();
	session_destroy();
	header("Location: ../../index.php");
}

$userId = explode(":", $_SESSION['userId'])[0];
$examID = $_GET['eid'];

# get exam takers
$results = getTakers($examID, $userId);

# get exam and render to the dom
$exams = getExamQuestions($examID);

$totalExamQ = count($exams[0]) > 2 ?? count($exams[0]);
$passingGrade = 0.7 * $totalExamQ;

$questions = $exams;

$passed = 0;
$not_passed = 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Online Exam | Results</title>

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

	<!-- chartjs -->
	<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>


	<link rel="stylesheet" href="" id="modek">
	<script>
	const link = document.querySelector('#modek')
	if (localStorage.getItem('dark')) {
		link.href = "../../../css/dark.css"
	} else {
		link.href = "../../../css/colors.css"
	}
	</script>
	<link rel="stylesheet" href="../../../css/dashboard.css">

	<style>
	*,
	input,
	button,
	a {
		font-family: 'Poppins', sans-serif;
	}

	canvas {
		width: 200px !important;
		height: 200px !important;
	}

	/* width */
	::-webkit-scrollbar {
		width: 10px;
	}

	/* Track */
	::-webkit-scrollbar-track {
		background: #f1f1f1;
	}

	/* Handle */
	::-webkit-scrollbar-thumb {
		background: #888;
	}

	/* Handle on hover */
	::-webkit-scrollbar-thumb:hover {
		background: #555;
	}
	</style>

</head>

<body class="container p-4 position-relative">
	<h4 class="fw-bold text-capitalize"><?php echo $_GET['en']; ?></h4>
	<div class="mt-5 container align-items-center position-relative" style="height: 80vh;">
		<div class="row flex-sm-column flex-md-row h-100" style="overflow-y: hidden">

			<div class="col h-100 bg-light" style="overflow-y: scroll">
				<?php foreach($exams as $key => $que): ?>
				<div><?php echo $key + 1 . ". " . json_decode($que['q_json'], true)[0]['q']; ?> </div>
				<ul>
					<?php foreach(json_decode($que['q_json'], true)[0]['options'] as $options): ?>
					<li><?php echo $options ?></li>
					<?php endforeach; ?>
				</ul>
				<?php endforeach; ?>

			</div>

			<div class="col">
				<div class="d-flex justify-content-between">
					<canvas id="myChart"></canvas>
					<button class="align-self-end btn btn-primary text-uppercase" id="downloadResults">download results</button>
				</div>
				<div class="lead my-2 fw-bold">Takers</div>
				<ul class="list-group">
					<?php if(empty($results)): ?>
					<li class="list-group-item">No Takers Yet!</li>
					<?php endif; ?>
					<?php foreach($results as $taker) : ?>
					<?php if($taker['score'] >= $passingGrade): ?>
					<li class="list-group-item list-group-item-action d-flex justify-content-between">
						<span class="fw-bold"><?php echo $taker["name"]; ?></span>
						<span class="fw-medium">score: <?php echo $taker['score']; ?> </span>

						<!-- put score to passed/not-passed -->
						<?php $passed = $taker['score'] >= count($results) ? ++$passed: 0;?>
						<?php $not_passed = $taker['score'] < count($results) ? ++$not_passed: 0; ?>
					</li>
					<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>

	<script type="text/javascript">
	const total = <?php echo count($results); ?>

	const passed = <?php echo $passed; ?>;
	const not_passed = <?php echo $not_passed; ?>;

	// download results
	const downloadBtn = document.querySelector("#downloadResults");

	downloadBtn.addEventListener('click', () => {
		window.location.href =
			"http://localhost/OnlineExamApp/controller/downloadResult.controller.php?eid=<?php echo $exams[0]['examId']; ?>&en=<?php echo $_GET['en']; ?>";
	})
	</script>


	<script type="text/javascript" src="../../../js/display_show.js">
	</script>
</body>

</html>