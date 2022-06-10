<?php 

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
    session_start();
	
		require_once "../model/User.php";

    # get the email only
    $user = explode(":", $_SESSION["userId"]);

    if(empty($_SESSION['userId'])) {
        header("Location: ../index.php");
    }

    # deleting the session 
    if(isset($_POST["logout"])) {
        session_unset();
        session_destroy();
        header("Location: ../index.php");
    }

		$details = getExamDetailsForExam($user[0]);

		$on_going_exams = [];
		$ended_exams = [];

		function ongoing_exams($arr){
			return date("Y-m-d H:i:sa") <= $arr['endTime'];
		}

		function ended_exams($arr){
			return date("Y-m-d H:i:sa") > $arr['endTime'];
		}


		// filter ongoing exmas
		$on_going_exams = array_filter($details, "ongoing_exams");

		// filter ended exmas
		$ended_exams= array_filter($details, "ended_exams");

		$stringed_nums = ["One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten"];

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Online Exam</title>

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
		link.href = "../css/dark.css"
	} else {
		link.href = "../css/colors.css"
	}
	</script>
	<link rel="stylesheet" href="../css/dashboard.css">

	<style>
	*,
	input,
	button,
	a {
		font-family: 'Poppins', sans-serif;
	}
	</style>

</head>

<body style="overflow-x: hidden;">

	<div class=" container-xxl p-0">
		<div class="row p-0 m-0">

			<!-- navbar -->
			<div class="col-sm-100 col-md-auto ">
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
							<ul class="navbar-nav m-auto mt-4 mb-lg-0 w-100 h-sm-100 flex-column px-md-5 px-sm-0">
								<li class="nav-item">
									<a class="nav-link fs-sm-6 active" aria-current="page" href="./">
										<i class="bi bi-house-door-fill "></i>
										Dashboard
									</a>
								</li>
								<li class="nav-item ">
									<a class="nav-link fs-6" aria-current="page" href="./app/create_exam.view.php">
										<i class="bi bi-plus-square-fill"></i>
										Create Exam</a>
								</li>
								<li class="nav-item ">
									<a class="nav-link fs-6 " href="./app/exam_results.view.php">
										<i class="bi bi-view-list"></i>
										Manage Exam </a>
								</li>
								<li class="nav-item ">
									<a class="nav-link" href="./app/settings.view.php">
										<i class="bi bi-gear-wide-connected"></i>
										Settings
									</a>
								</li>
								<li class="nav-item">
									<form action="./index.php" method="post">
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

			<div class="col p-0 m-0 " style="box-shadow: -4px 0 10px rgba(0, 0, 0, .125)">
				<div class="container p-0 ">

					<!-- header -->
					<div class="row-4 m-0 shadow-sm " style="background: var(--gray) !important;">
						<div class="col d-flex p-2 px-5 align-items-center justify-content-between ">
							<div>
								<h2 class="fs-6">Hello
									<span class="fw-bold text-capitalize"><?php echo $user[1] ?></span>
									, Welcome Back!
								</h2>
							</div>
							<i class="bi bi-bell-fill fs-3" id="bell-icon"></i>
						</div>
					</div>
					<!-- end of header -->

					<!-- dashboard cards results-->
					<div class="row m-4 justify-content-between">

						<!-- ongoing exams -->
						<div class="lead fw-bold">Ongoing Exams</div>

						<?php foreach($on_going_exams as $oge) : ?>
						<div class="accordion accordion-flush" id="accordionFlushExample">
							<div class="accordion-item">
								<h2 class="accordion-header" id="flush-headingOne">
									<button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse"
										data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
										<?php echo $oge['examName']; ?>
									</button>
									<div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
										data-bs-parent="#accordionFlushExample">
										<div class="accordion-body text-dark">
											<?php $d = date_create($oge['endTime']); ?>
											<p class="text-dark fs-6">This exam ends on <?php echo date_format($d, 'Y M d'); ?> @
												<?php echo date_format($d, 'h:i:sa'); ?></p>
										</div>
									</div>
								</h2>
							</div>

							<?php endforeach; ?>

							<!-- end of ongoing exams -->

							<!-- ended exams -->
							<div class="mt-4 lead fw-bold">Ended Exams</div>

							<?php foreach($ended_exams as $key => $ee) : ?>
							<div class="accordion" id="accordionExample1">
								<div class="accordion-item">
									<h2 class="accordion-header" id="heading<?php echo $stringed_nums[$key]; ?>">
										<button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse"
											data-bs-target="#collapse<?php echo $stringed_nums[$key]; ?>" aria-expanded="false"
											aria-controls="collapse<?php echo $stringed_nums[$key]; ?>">
											<?php echo $ee['examName']; ?>
										</button>
									</h2>
									<div id="collapse<?php echo $stringed_nums[$key]; ?>" class="accordion-collapse collapse show"
										aria-labelledby="heading<?php echo $stringed_nums[$key]; ?>" data-bs-parent="#accordionExample">
										<div class="accordion-body text-dark">
											<?php $d = date_create($ee['endTime']); ?>
											<p>This exam ends on <?php echo date_format($d, 'Y M d'); ?> @
												<?php echo date_format($d, 'h:i:sa'); ?></p>
										</div>
									</div>
								</div>
							</div>
							<?php endforeach; ?>

							<!-- end of ended exams -->
						</div>

					</div>

				</div>
			</div>

			<script>
			// theme mode
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