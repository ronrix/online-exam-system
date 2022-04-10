<?php 

    session_start();

    include_once "../model/User.php";

    $email = $_POST['email'];
    $pwd = $_POST['password'];

    $result = getUser($email, $pwd);

    if(mysqli_num_rows($result) > 0) {
        # array result
        $arrRes = mysqli_fetch_assoc($result);

        # store the result to the session and pass to the user to get it from the url
        $user = $_SESSION['userId'] = $arrRes['id'] . ":" . $arrRes['fullname'] . ":" . $arrRes["schoolname"] . ":" . $arrRes["address"];


        # close the db connection
        // close_connection();

        header('Location: ../view/redirects/loading.php');
    }
    else {

        // close_connection();

        echo "something went wrong";
        header('Location: ../index.php?err=email or password is not correct');


    }