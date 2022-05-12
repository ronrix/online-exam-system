<?php

    session_start();

    if($_SESSION['userId']) {
        $user = explode(":", $_SESSION["userId"]);
        header("Location: ./view/");
    }
    else {
        session_unset();
        session_destroy();
    }

    # get error message
    $err = $_GET['err'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Online Exam | LOGIN</title>

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


	<link rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css"
		integrity="sha512-Oy+sz5W86PK0ZIkawrG0iv7XwWhYecM3exvUtMKNJMekGFJtVAhibhRPTpmyTj8+lJCkmWfnpxKgT2OopquBHA=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />

	<!-- font -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">

	<!-- custom styles -->
	<link rel="stylesheet" href="./css/colors.css">

	<!-- set font family -->
	<style>
	*,
	input,
	button,
	a {
		font-family: 'Poppins', sans-serif;
	}

	body {
		height: 100vh;
	}
	</style>


	<link rel="stylesheet" href="./css/button.css">
</head>

<body class="d-flex flex-column justify-content-between" style="background-color: var(--grayish);">

	<div class="container d-flex flex-column justify-content-center align-items-center login_body  p-sm-5 p-md-0"
		style="height: 80vh;">
		<div class="d-flex align-items-center justify-content-center w-100">
			<?php include_once "./view/login.view.php" ?>
		</div>
	</div>
	<footer class="w-100" style="background-color: var(--primary-color);">
		<div class="container">
			<div class="row d-flex align-items-center text-right">
				<h6 class="col-md-6 col-sm-12">Copyright &copy; 2022</h6>

				<div class=" col-md-6 col-sm-12 ">
					<p>Terms of Service</p>
					<i class=" btn social_media bi bi-facebook fs-5"></i>
					<i class="btn social_media bi bi-google fs-5"></i>
				</div>
			</div>
		</div>
	</footer>

	<script>
	document.querySelector('#focusEl').focus()
	</script>

</body>

</html>