<?php

# show errors	
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require_once '../../model/User.php';

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

# get the lists of exams from database
$details = getExamDetailsForExam($userId);

# handle the due date/time of the exam
function dueDateTime($due)
{

	$dueDate = explode(' ', $due)[0];
	$now = date("Y-m-d h:i:sa");

	if($due < $now) {
		return 0;
	}

	$created_date = date_create($dueDate);
	$formated_date = date_format($created_date, 'D');


	return $formated_date;
}# index for lists style

$id = 0;

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


	<link rel="stylesheet" href="" id="modek">
	<script>
	const link = document.querySelector('#modek')
	if (localStorage.getItem('dark')) {
		link.href = "../../css/dark.css"
	} else {
		link.href = "../../css/colors.css"
	}
	</script>
	<link rel="stylesheet" href="../../css/dashboard.css">

	<style>
	*,
	input,
	button,
	a {
		font-family: 'Poppins', sans-serif;
	}
	</style>

</head>

<body>

	<div class="container-xxl p-0">
		<div class="row p-0 m-0">

			<!-- navbar -->
			<div class="col-sm-100 col-md-auto">
				<nav class="navbar navbar-expand-lg navbar-light w-auto p-0 ">
					<div class="container-fluid align-self-start align-items-center justify-content-center p-0 text-center">

						<!-- burger menu -->
						<button class="navbar-toggler w-sm-25 w-md-100 bg-light" type="button" data-bs-toggle="collapse"
							data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
							aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
						<!-- end of burger menu -->

						<div class="collapse navbar-collapse p-0 flex-column align-items-center justify-content-center"
							id="navbarTogglerDemo01" style="height: 100vh;">
							<!-- <img src="../../config/sample-user.jpg" alt="profile picture" class="w-50 m-auto d-none d-sm-block" style="clip-path: circle(40%);"> -->
							<ul class="navbar-nav m-auto mt-4 mb-lg-0 w-100 h-sm-100 flex-column px-md-5 px-sm-0">
								<li class="nav-item">
									<a class="nav-link fs-sm-6" aria-current="page" href="../">
										<i class="bi bi-house-door-fill "></i>
										Dashboard
									</a>
								</li>
								<li class="nav-item ">
									<a class="nav-link fs-6 " aria-current="page" href="./create_exam.view.php">
										<i class="bi bi-plus-square-fill"></i>
										Create Exam</a>
								</li>
								<li class="nav-item ">
									<a class="nav-link fs-6 active fw-bold" href="./exam_results.view.php">
										<i class="bi bi-view-list"></i>
										Manage Exam</a>
								</li>
								<li class="nav-item ">
									<a class="nav-link" href="./settings.view.php">
										<i class="bi bi-gear-wide-connected"></i>
										Settings
									</a>
								</li>
								<li class="nav-item">
									<form action="./exam_results.view.php" method="post">
										<button name="logout" class="btn m-0 fs-6" type="submit">
											<i class="bi bi-box-arrow-left"></i>
											Logout</button>
									</form>
								</li>
							</ul>
						</div>
					</div>
				</nav>
			</div>
			<!-- end of navbar -->

			<div class="col p-0 m-0" style="min-height: 100vh !important; box-shadow: -4px 0 10px rgba(0, 0, 0, .125);">
				<div class="container p-0 ">

					<!-- header -->
					<div class="row-4 m-0 shadow-sm " style="background: var(--gray) !important;">
						<p class="p-2">Manage exams</p>
					</div>
					<!-- end of header -->

					<!-- dashboard cards recent results-->
					<div class="row m-4 justify-content-between">
						<h5 class="lead text-uppercase fw-bold m-0 my-2 p-0">Lists of Exam</h5>
						<ol class="list-group list-group-numbered">
							<?php foreach ($details as $key => $d) : ?>
							<?php if($id % 2 != 0): ?>
							<li
								class="list-group-item d-flex flex-sm-column flex-md-row justify-content-between align-items-start list-group-item-secondary list-group-item-action exam"
								style="cursor: pointer;" id="<?php echo $key;?>" data-bs-toggle="modal" data-bs-target="#modalList">

								<div class="ms-2 me-auto">
									<div class="fw-bold"><?php echo $d['examName']; ?></div>
								</div>
								<span
									class="badge bg-primary rounded-pill"><?php echo dueDateTime($d['endTime']) ? "ends on ".  dueDateTime($d['endTime']) : 'expired'; ?></span>
							</li>
							<?php else: ?>
							<li class="list-group-item d-flex justify-content-between align-items-start list-group-item-action exam"
								style="cursor: pointer;" id="<?php echo $key; ?>" data-bs-toggle="modal" data-bs-target="#modalList">
								<div class="ms-2 me-auto">
									<div class="fw-bold"><?php echo $d['examName']; ?></div>
								</div>
								<span
									class="badge bg-primary rounded-pill"><?php echo dueDateTime($d['endTime']) ? "ends on ". dueDateTime($d['endTime']) : 'expired'; ?></span>
							</li>
							<?php endif; ?>

							<?php $id += 1; ?>

							<?php endforeach; ?>
						</ol>
					</div>

					<!-- end of results -->

					<!-- modal, when list exam has been clicked, show the contents  -->
					<div class="modal fade" tabindex="-1" id="modalList" style="color: black !important;">
						<div class="modal-dialog" id="modalWrapper">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title text-uppercase fw-bold" id="modal_name">Modal Title</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<div class="modal-body">
									<div>
										<p id="modal_startTime">Modal body text goes here.</p>
									</div>
									<div>
										<p id="modal_endTime">Modal body text goes here.</p>
									</div>
									<div class="text-end">
										<a id="modal_editBtn" href="#">edit</a>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
									<button type="button" class="btn btn-danger" id="deleteExam">Delete</button>
									<button type="button" class="btn btn-primary" id="downloadResult">Download Result</button>
								</div>
							</div>
						</div>
					</div>

				</div>

			</div>

		</div>
	</div>

	<script src="../../js/download.js"></script>
	<script src="../../js/examContent.js"></script>

	<script>
	// download result as pdf extension
	const dlPdf = document.querySelector("#downloadResult");

	dlPdf.addEventListener("click", (e) => {
		const modalName = document.querySelector("#modal_name");
		window.location.href = "http://localhost/OnlineExamApp/controller/downloadResult.controller.php?eid=" + e.target
			.parentElement.parentElement.parentElement.id + "&en=" + modalName.textContent
	});

	if (localStorage.getItem('dark')) {
		document.body.classList.add('dark')
		document
			.querySelectorAll(".btn")
			.forEach((el) => el.classList.add("dark"));

		document
			.querySelectorAll(".nav-link")
			.forEach((el) => el.classList.add("dark"));

	} else {
		document.body.classList.remove('dark')
		document
			.querySelectorAll(".btn")
			.forEach((el) => el.classList.remove("dark"));

		document
			.querySelectorAll(".nav-link")
			.forEach((el) => el.classList.remove("dark"));

	}
	</script>

</body>

</html>