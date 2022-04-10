<?php 
    
    # database connection
    function connectToDB() {
        $servername = "localhost";
        $user= "wp_user";
        $pass= "WP_password12";
        $db_name = "OnlineExam";

        try {
            $conn = mysqli_connect($servername, $user, $pass, $db_name);
            echo "Connected Successfully!";
        }
        catch(PDOException $e) {
            die("Connection Failed! ". $e->getMessage());
        }

        return $conn;
    }

    # get user for login (login)
    function getUser($username, $password) {
        $conn = connectToDB();
        
        $query = "SELECT id, fullname, schoolname, address FROM users WHERE email=? AND password=?";
        try {

            $stmt = mysqli_prepare($conn, $query);
            # second param should be filled with letter 's'
            mysqli_stmt_bind_param($stmt, "ss", $username, $password);

            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        }
        catch(Exception $e) {
            echo "Something went wrong! ". $e->getMessage() .$e;
            return "Something Went Wrong!";
        }
        return $result;

    }


    function close_connection() {
        $conn = connectToDB();


        mysqli_close($conn);
    }


    # insert user (signup)
    function insertUser($fullname, $email, $password, $schoolname, $address) {
        $conn = connectToDB();

        $query = "INSERT INTO users (fullname, schoolname, address, email, password) VALUES (?, ?, ?, ?, ?)";
        try {
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssss", $fullname, $schoolname, $address, $email, $password);
            $stmt->execute();
        } catch (Exception $e) {
            echo "Something went wrong! ". $e->getMessage() . $e;
            return 0;
        }
        return 1;
    }