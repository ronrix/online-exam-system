<?php 

		$httpStatus= $_SERVER["REDIRECT_STATUS"];

		$error_title = "";
		$error_msg = "";

		if ($httpStatus == 404) {
			$error_title = "404 Page not Found!";
			$error_msg = "The page you are requesting for has been deleted or moved";
		}

		if ($httpStatus == 500) {
			$error_title = "500 Server Error!";
			$error_msg = "Something went wrong on the server side!";
		}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $httpStatus ?></title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

		<!-- icons -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" integrity="sha512-Oy+sz5W86PK0ZIkawrG0iv7XwWhYecM3exvUtMKNJMekGFJtVAhibhRPTpmyTj8+lJCkmWfnpxKgT2OopquBHA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400&display=swap" rel="stylesheet">

		<link rel="stylesheet" href="../OnlineExamApp/css/defaut.css">
		<link rel="stylesheet" href="../OnlineExamApp/css/colors.css">

</head>
<body class="container d-flex justify-content-center align-items-center bg-primary-gradient" style="height: 100vh">

		<div class="text-center">
				<i class="bi bi-exclamation-triangle-fill" style="font-size: 10rem"></i>
				<h1 class="fw-bold"> <?php echo $error_title ?> </h1>
			<h1 class="fs-3"> <?php echo $error_msg ?> </h1>
		</div>
	
</body>
</html>