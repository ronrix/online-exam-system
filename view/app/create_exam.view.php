<?php 

    session_start();

    # get the email only
    $user = explode(":", $_SESSION["userId"]);

    if(empty($_SESSION['userId'])) {
        header("Location: ../../index.php");
    }

    # deleting the session 
    if(isset($_POST["logout"])) {
        session_unset();
        session_destroy();
        header("Location: ../../index.php");
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Online Exam | Create Exam</title>

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


	<link rel="stylesheet" href="../../css/colors.css">
	<link rel="stylesheet" href="../../css/dashboard.css">

	<style>
	*,
	input,
	button,
	a {
		font-family: 'Poppins', sans-serif;
	}

	body {
		min-height: 100vh !important;
		background-color: var(--primary-color) !important;
		overflow-x: hidden !important;
		position: relative;
	}
	</style>

</head>

<body>

	<div class="container-xxl p-0 ">
		<div class=" row p-0 m-0">

			<!-- navbar -->
			<div class="col-sm-100 col-md-auto ">

				<nav class="navbar navbar-expand-lg navbar-light w-auto p-0 ">
					<div class="container-fluid align-self-start align-items-center justify-content-center p-0 text-center">

						<!-- burger menu -->
						<button class="navbar-toggler w-sm-25 w-md-100" type="button" data-bs-toggle="collapse"
							data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
							aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
						<!-- end of burger menu -->

						<div class="collapse navbar-collapse p-0 flex-column" id="navbarTogglerDemo01">
							<img src="../../config/sample-user.jpg" alt="profile picture" class="w-50 m-auto d-none d-md-block"
								style="clip-path: circle(40%);">
							<ul class="navbar-nav m-auto mt-4 mb-lg-0 fw-bold w-100 h-sm-100 flex-column px-md-5 px-sm-0">
								<li class="nav-item">
									<a class="nav-link fs-sm-6" aria-current="page" href="../">
										<i class="bi bi-house-door-fill "></i>
										Dashboard
									</a>
								</li>
								<li class="nav-item ">
									<a class="nav-link fs-6 active " aria-current="page" href="./create_exam.view.php">
										<i class="bi bi-plus-square-fill"></i>
										Create Exam</a>
								</li>
								<li class="nav-item ">
									<a class="nav-link fs-6 " href="./exam_results.view.php">
										<i class="bi bi-view-list"></i>
										Exam </a>
								</li>
								<li class="nav-item ">
									<a class="nav-link" href="./settings.view.php">
										<i class="bi bi-gear-wide-connected"></i>
										Settings
									</a>
								</li>
								<li class="nav-item">
									<form action="<?php echo $_SERVER['php_self'] ?>" method="post">
										<button name="logout" class="btn m-0 fs-6" type="submit">
											<i class="bi bi-box-arrow-left"></i>
											logout</button>
									</form>
								</li>
							</ul>
						</div>
					</div>
				</nav>
			</div>
			<!-- end of navbar -->

			<!-- header (list of exam created) -->
			<div class="col p-0 m-0 border-2 shadow">
				<div class="container p-4">

					<div class="lead fw-bold mb-2 ">
						<h3>Start an Examination</h3>
						<div class="row m-0">
							<div class="col">
								<label for="exam_name">set exam name</label>
								<input type="text" class="form-control" name="" id="exam_name" placeholder="set name">
							</div>
							<div class="col">
								<label for="exam_time">set due date/time</label>
								<input type="datetime-local" class="form-control" name="" id="exam_time" placeholder="set due date">
							</div>
						</div>
					</div>
					<!-- end of header -->

					<!-- exam questionnaire adding page -->
					<div class="row mt-4 justify-content-between ">

						<h3>Set your questions</h3>

						<div id="question_container">
							<div class="each_question_wrapper border shadow-sm rounded p-2" id="inside_question_wrapper" data-q='1'>
								<!-- question input -->
								<label for="question" class="fw-bold my-2">question</label>
								<input type="text" id="question" class="form-control" placeholder="write a question" name="question">
								<!-- select option for answer options -->
								<select name="selectOption" id="selectOption" class="form-select my-2 w-auto">
									<option value="checkbox">checkbox</option>
									<option value="radiobutton">radiobutton</option>
									<option value="definition">definition</option>
									<option value="essay">essay</option>
								</select>
								<!-- adding options -->
								<div id="options" class="d-flex">
									<input type="text" class="form-control" name="option" id="option" placeholder="option">
									<div class="p-2" id="removeOption">
										<i class="bi bi-dash-lg" style="pointer-events: none;"></i>
									</div>
									<div class="p-2" id="addOption">
										<i class="bi bi-plus-lg" style="pointer-events: none;"></i>
									</div>
								</div>
								<!-- end of option wrapper -->
								<!-- set the answer -->
								<div class="my-2">
									<h6 class="fw-bold">Answer</h6>
									<input type="text" name="answer" placeholder="set the answer" class="form-control" id="answer" />
								</div>
								<!-- end answer -->
							</div>

						</div>
						<!-- end of exam questoinnaire -->

						<!-- add question button -->
						<button type="button" class="btn btn-outline-primary w-auto mt-2" id="addQuestionBtn">
							<i class="bi bi-plus-circle-fill"></i> Add Question</button>


						<button type="button" class="btn btn-primary w-auto mt-2" id="submit">
							<i class="bi bi-plus-circle-fill"></i> Create Exam</button>




					</div>

					<!-- end of exam questionnaire adding page-->
				</div>
			</div>
		</div>
	</div>
	</div>
	</div>

	<script src="./create_exam.js"> </script>

</body>

</html>