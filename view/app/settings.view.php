<?php 

		# show errors	
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);

    session_start();

		require_once "../../model/User.php";

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

		$userInfo = getUserInfo($user[0]);

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Online Exam | Settings</title>

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
							<!-- <img src="../../config/sample-user.jpg" alt="profile picture" class="w-50 m-auto d-none d-sm-block"
								style="clip-path: circle(40%);"> -->
							<ul class="navbar-nav m-auto mt-4 mb-lg-0 w-100 h-sm-100 flex-column px-md-5 px-sm-0">
								<li class="nav-item">
									<a class="nav-link fs-sm-6" aria-current="page" href="../">
										<i class="bi bi-house-door-fill "></i>
										Dashboard
									</a>
								</li>
								<li class="nav-item ">
									<a class="nav-link fs-6" aria-current="page" href="./create_exam.view.php">
										<i class="bi bi-plus-square-fill"></i>
										Create Exam</a>
								</li>
								<li class="nav-item ">
									<a class="nav-link fs-6 " href="./exam_results.view.php">
										<i class="bi bi-view-list" style="font-weight: bold !important;"></i>
										Manage Exam</a>
								</li>
								<li class="nav-item ">
									<a class="nav-link fs-6 active fw-bold" href="./settings.view.php">
										<i class="bi bi-gear-wide-connected"></i>
										Settings
									</a>
								</li>
								<li class="nav-item">
									<form action="./settings.view.php" method="post">
										<button name="logout" class="btn m-0 fs-6" type="submit" id="logout">
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

			<div class="col p-0 m-0" style="min-height: 100vh !important;box-shadow: -4px 0 10px rgba(0, 0, 0, .125);">
				<div class="container p-0 ">

					<!-- header -->
					<div class="row-4 m-0 shadow-sm " style="background: var(--gray) !important;">
						<h6 class="p-2">Settings</h6>
					</div>
					<!-- end of header -->

					<!-- dashboard cards recent results-->
					<div class="row m-4 justify-content-between">
						<!-- dark/light mode  -->
						<div class="d-flex justify-content-between">
							<div class="lead">Mode</div>
							<!-- toggle mode -->
							<div>
								<i class="bi bi-brightness-high-fill fs-2 " id="light"></i>
								<i class="bi bi-moon-stars-fill fs-3" style="display: none;" id="dark"></i>
							</div>
						</div>
						<!-- information details | edit -->
						<div class="container">
							<div class="row border d-flex align-items-center justify-content-between">
								<div class="col">
									<span class="fw-bold ">Full name:</span>
									<span class="text-capitalize"><?php echo $userInfo[0]['fullname']; ?></span>
								</div>
								<div class="col-sm-2 col-md-1 align-content-start" id="Full Name">
									<button class="btn text-primary" id="edit" type="button" data-bs-toggle="modal"
										data-bs-target="#editModal">edit</button>
								</div>
							</div>

							<div class="row border d-flex align-items-center justify-content-between">
								<div class="col">
									<span class="fw-bold">Establishment Name:</span>
									<span class="text-capitalize"><?php echo $userInfo[0]['schoolname']; ?></span>
								</div>
								<div class="col-sm-2 col-md-1 align-content-start" id="School Name">
									<button class="btn text-primary" id="edit" type="button" data-bs-toggle="modal"
										data-bs-target="#editModal">edit</button>
								</div>
							</div>

							<div class="row border d-flex align-items-center justify-content-between">
								<div class="col">
									<span class="fw-bold">Email:</span>
									<span><?php echo $userInfo[0]['email']; ?></span>
								</div>
								<div class="col-sm-2 col-md-1 align-content-start" id="Email">
									<button class="btn text-primary" id="edit" type="button" data-bs-toggle="modal"
										data-bs-target="#editModal">edit</button>
								</div>
							</div>

							<div class="row border d-flex align-items-center justify-content-between">
								<div class="col">
									<span class="fw-bold">Address:</span>
									<span class="text-capitalize"><?php echo $userInfo[0]['address']; ?></span>
								</div>
								<div class="col-sm-2 col-md-1 align-content-start" id="Address">
									<button class="btn text-primary" id="edit" type="button" data-bs-toggle="modal"
										data-bs-target="#editModal">edit</button>
								</div>
							</div>

							<div class="row border d-flex align-items-center justify-content-between mt-4">
								<div class="col">
									<span class="fw-bold">Change Password</span>
								</div>
								<div class="col-sm-2 col-md-1 align-content-start" id="Password">
									<button class="btn text-primary" id="editPass" type="button" data-bs-toggle="modal"
										data-bs-target="#passwordModal">edit</button>
								</div>
							</div>

							<!-- modal for password changing -->
							<div class="modal" tabindex="-1" id="passwordModal">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="modalTitlePW">Modal title</h5>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
											<input type="password" class="form-control" placholder="" id="currentPW" />
											<input type="password" class="form-control my-2" placholder="" id="newPW" />
											<input type="password" class="form-control" placholder="" id="confirmNewPW" />
											<p id="statusLbl"></p>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
												id="modalClosePW">Close</button>
											<button type="button" class="btn btn-primary" id="modalSubmitPW">Save changes</button>
										</div>
									</div>
								</div>
							</div>

							<!-- modal for edit -->
							<div class="modal" tabindex="-1" id="editModal">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="modalTitle">Modal title</h5>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
											<label for="modalInput" id="modalLabel" class="d-block"></label>
											<input type="text" placholder="" id="modalInput" class="form-control" />
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
												id="modalClose">Close</button>
											<button type="button" class="btn btn-primary" id="modalSubmit">Save changes</button>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>

				<!-- end of results -->

				<!-- toast : show result from modal right bottom -->
				<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
					<div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
						<div class="toast-header">
							<strong class="me-auto" id="successTitle"></strong>
							<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
						</div>
						<div class="toast-body" id="successLbl">
							Hello, world! This is a toast message.
						</div>
					</div>
				</div>

			</div>



		</div>

	</div>
	</div>

	<script src="../../js/settings.js"></script>
	<script>
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

	// password edit
	const chpwdBtn = document.querySelector('#editPass')

	const modalClosePW = document.querySelector('#modalClosePW')
	const modalSubmitPW = document.querySelector('#modalSubmitPW')
	const modalTitlePW = document.querySelector('#modalTitlePW')

	const currentPW = document.querySelector('#currentPW')
	const newPW = document.querySelector('#newPW')
	const confirmNewPW = document.querySelector('#confirmNewPW')
	const statusLbl = document.querySelector('#statusLbl')

	const toast = document.querySelector('#liveToast')
	const successTitle = document.querySelector('#successTitle')
	const successLbl = document.querySelector('#successLbl')

	successTitle.classList.add('fw-bold')

	statusLbl.classList = "fs-6 text-danger p-2 fw-bold"

	chpwdBtn.addEventListener('click', (e) => {
		const contentName = e.target.parentElement.id

		modalTitlePW.textContent = "Change " + contentName
		currentPW.placeholder = "last password"
		newPW.placeholder = "new password"
		confirmNewPW.placeholder = "confirm new password"

	})

	modalSubmitPW.addEventListener('click', () => {
		// check if inputs have values before submitting
		if (!newPW.value || !confirmNewPW.value || !currentPW.value) {
			statusLbl.textContent = "Please input values before submitting!"
			return
		}

		// check new and confirm input if they are the same
		if (newPW.value !== confirmNewPW.value) {
			newPW.classList.add("border-danger")
			newPW.classList.add("border-3")

			confirmNewPW.classList.add("border-danger")
			confirmNewPW.classList.add("border-3")

			return
		} else {
			newPW.classList.remove("border-danger")
			newPW.classList.remove("border-3")

			confirmNewPW.classList.remove("border-danger")
			confirmNewPW.classList.remove("border-3")
		}

		// submit
		fetch('http://localhost/OnlineExamApp/controller/change_pwd.controller.php', {
			method: "POST",
			headers: {
				"Content-Type": 'application/json'
			},
			referrerPolicy: 'no-referrer',
			body: JSON.stringify({
				"current_pwd": currentPW.value,
				"new_pwd": newPW.value,
			})
		}).then(res => res.json()).then(data => {
			if (data.status == "SUCCESS") {

				// set toast content
				successLbl.textContent = "Successfully changing the password"
				successTitle.textContent = "Success!"

				toast.classList.replace('hide', 'show')

				modalClosePW.click()
			} else {

				// set toast content
				successLbl.textContent = "Error changing the password"
				successTitle.textContent = "Error!"

				toast.classList.replace('hide', 'show')
				modalClosePW.click()
			}

			setTimeout(() => {
				toast.classList.replace('show', 'hide')
			}, 2000)
		})

	})

	modalClosePW.addEventListener('click', () => {
		newPW.value = ""
		currentPW.value = ""
		confirmNewPW.value = ""
		statusLbl.textContent = ""
	})


	// edit function
	const editBtn = document.querySelectorAll('#edit')
	const modalTitle = document.querySelector('#modalTitle')
	const modalInput = document.querySelector('#modalInput')
	const modalLabel = document.querySelector('#modalLabel')
	const modalSubmit = document.querySelector('#modalSubmit')
	const modalClose = document.querySelector('#modalClose')

	editBtn.forEach(el => {
		el.addEventListener('click', (e) => {
			const contentName = e.target.parentElement.id

			modalTitle.textContent = contentName
			modalLabel.textContent = "Update the " + contentName
			modalInput.placeholder = "write here"
		})
	})

	modalSubmit.addEventListener('click', () => {

		fetch('http://localhost/OnlineExamApp/controller/settings.controller.php', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			referrerPolicy: 'no-referrer',
			body: JSON.stringify({
				"title": modalTitle.textContent,
				"value": modalInput.value
			})
		}).then(res => res.json()).then(data => {
			if (data.status == "SUCCESS") {
				modalClose.click()
				window.location.reload()
			}
		})

	})
	</script>
</body>

</html>