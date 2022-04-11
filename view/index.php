<?php 

    session_start();

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


	<link rel="stylesheet" href="../css/colors.css">
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

	<div class="container-xxl p-0">
		<div class="row p-0 m-0">

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
							<img src="../config/sample-user.jpg" alt="profile picture" class="w-50 m-auto d-none d-md-block"
								style="clip-path: circle(40%);">
							<ul class="navbar-nav m-auto mt-4 mb-lg-0 fw-bold w-100 h-sm-100 flex-column px-md-5 px-sm-0">
								<li class="nav-item">
									<a class="nav-link fs-sm-6 active " aria-current="page" href="./">
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
										Exam </a>
								</li>
								<li class="nav-item ">
									<a class="nav-link" href="./app/settings.view.php">
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

			<div class="col p-0 m-0 shadow">
				<div class="container p-0 ">

					<!-- header -->
					<div class="row-4 m-0 shadow-sm " style="background: var(--gray) !important;">
						<div class="col d-flex p-2 px-5 align-items-center justify-content-between ">
							<div>
								<h2 class="fs-6" style="color: var(--tersiary-color) !important">Hello
									<span class="fw-bold text-capitalize"><?php echo $user[1] ?></span>
									, Welcome Back!
								</h2>
							</div>
							<i class="bi bi-bell-fill fs-3" style="color: var(--tersiary-color) !important;"></i>
						</div>
					</div>
					<!-- end of header -->

					<!-- dashboard cards recent results-->
					<div class="row m-4 justify-content-between" style="height: 100vh;">
						<div class="lead mb-2 fw-bold">recent exam</div>

						<div class="col-sm-12 col-md-4 " style="border-radius: 10px !important;">
							<div class="card shadow w-sm-100 w-md-50 h-100 mx-sm-5 mx-md-0" style="border-radius: 10px !important;">
								<div class="card-body d-flex justify-content-around align-items-center text-center overflow-hidden p-2">
									<h5 class="card-title fs-4 fs-md-4 fw-bolder">40%</h5>
									<p class="card-text p-0 p-md-2 fs-6 fs-md-5">Exam Takers</p>
									<a href="./" class="btn view">view</a>
								</div>
							</div>
						</div>

						<div class="col-sm-12 col-md-4 " style="border-radius: 10px !important;">
							<div class="card shadow w-sm-100 w-md-50 h-100 mx-sm-5 mx-md-0" style="border-radius: 10px !important;">
								<div class="card-body d-flex justify-content-around align-items-center overflow-hidden text-center p-2">
									<h5 class="card-title fs-4 fs-md-4 fw-bolder">40%</h5>
									<p class="card-text p-0 p-md-2 fs-6">Percentage of Passed Takers</p>
									<a href="./" class="btn view">view</a>
								</div>
							</div>
						</div>

						<div class="col-sm-12 col-md-4 " style="border-radius: 10px !important;">
							<div class="card shadow w-sm-100 w-md-50 h-100 mx-sm-5 mx-md-0" style="border-radius: 10px !important;">
								<div class="card-body d-flex justify-content-around align-items-center overflow-hidden text-center p-2">
									<h5 class="card-title fs-5 fs-md-4 fw-bolder">40%</h5>
									<p class="card-text p-0 p-md-2 fs-6 fs-md-5">Percentage of Failed Takers</p>
									<a href="./" class="btn view">view</a>
								</div>
							</div>
						</div>

						<!-- end of results -->

						<!-- lists of examiners -->
						<span class="lead fw-bold mt-4">Lists of Takers</span>
						<div class="col overflow-auto hide-scrollbar border border-light border-1 rounded" style="height: 60vh;">
							<ol class="list-group list-group-numbered mt-4">
								<li
									class="list-group-item list-group-item-secondary list-group-item-action d-flex justify-content-between align-items-start">
									<div class="ms-2 me-auto">
										<div class="fw-bold">Subheading</div>
										Cras justo odio
									</div>
									<span class="badge bg-primary rounded-pill">14</span>
								</li>
								<li class="list-group-item d-flex justify-content-between list-group-item-action align-items-start">
									<div class="ms-2 me-auto">
										<div class="fw-bold">Subheading</div>
										Cras justo odio
									</div>
									<span class="badge bg-primary rounded-pill">14</span>
								</li>
								<li
									class="list-group-item d-flex list-group-item-secondary list-group-item-action justify-content-between align-items-start">
									<div class="ms-2 me-auto">
										<div class="fw-bold">Subheading</div>
										Cras justo odio
									</div>
									<span class="badge bg-primary rounded-pill">14</span>
								</li>

								<li
									class="list-group-item d-flex list-group-item-light list-group-item-action justify-content-between align-items-start">
									<div class="ms-2 me-auto">
										<div class="fw-bold">Subheading</div>
										Cras justo odio
									</div>
									<span class="badge bg-primary rounded-pill">14</span>
								</li>

								<li
									class="list-group-item d-flex list-group-item-secondary list-group-item-action justify-content-between align-items-start">
									<div class="ms-2 me-auto">
										<div class="fw-bold">Subheading</div>
										Cras justo odio
									</div>
									<span class="badge bg-primary rounded-pill">14</span>
								</li>

								<li
									class="list-group-item d-flex list-group-item-light list-group-item-action justify-content-between align-items-start">
									<div class="ms-2 me-auto">
										<div class="fw-bold">Subheading</div>
										Cras justo odio
									</div>
									<span class="badge bg-primary rounded-pill">14</span>
								</li>

								<li
									class="list-group-item d-flex list-group-item-secondary list-group-item-action justify-content-between align-items-start">
									<div class="ms-2 me-auto">
										<div class="fw-bold">Subheading</div>
										Cras justo odio
									</div>
									<span class="badge bg-primary rounded-pill">14</span>
								</li>

								<li
									class="list-group-item d-flex list-group-item-light list-group-item-action justify-content-between align-items-start">
									<div class="ms-2 me-auto">
										<div class="fw-bold">Subheading</div>
										Cras justo odio
									</div>
									<span class="badge bg-primary rounded-pill">14</span>
								</li>

								<!-- no item -->
								<li
									class="list-group-item d-flex list-group-item-secondary list-group-item-action justify-content-between align-items-start">
									<div class="ms-2 me-auto">
										<div class="fw-bold"></div>
									</div>
									<span class="badge bg-primary rounded-pill"></span>
								</li>
							</ol>
						</div>
						<!-- end of lists of examiners-->

					</div>

				</div>

			</div>
		</div>

</body>

</html>