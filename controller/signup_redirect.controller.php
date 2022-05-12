<?php  


		session_start();

    include_once "../model/User.php";

    $email = explode(":",$_SESSION['userId'])[0];
    $pwd = explode(":",$_SESSION['userId'])[1];

    $result = getUser($email, $pwd);

		# unset userId
		unset($_SESSION['userId']);

    if(mysqli_num_rows($result) > 0) {
        # array result
        $arrRes = mysqli_fetch_assoc($result);

        # store the result to the session and pass to the user to get it from the url
        $_SESSION['userId'] = $arrRes['id'] . ":" . $arrRes['fullname'] . ":" . $arrRes["schoolname"] . ":" . $arrRes["address"];
        $user =  $_SESSION['userId'];


        # close the db connection
        // close_connection();

        header('Location: ../view/redirects/loading.php');
    }
    else {

        // close_connection();

        echo "something went wrong";
        header('Location: ../index.php?err=email or password is not correct');


    }