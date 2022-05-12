<?php 
    
    # database connection
    function connectToDB() {
        $servername = "localhost";
        $user= "wp_user";
        $pass= "WP_password12";
        $db_name = "OnlineExam";

        try {
            $conn = mysqli_connect($servername, $user, $pass, $db_name);
            // echo "Connected Successfully!";
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

    # insert exam details 
    function insertExamDetails($conn, $data, $userId, $randomString) {

        $dateTimeNow = date("d-m-y h:i:s");

        try {
            $stmt = $conn->prepare("INSERT INTO exam(examName, userID, participants, startTime, endTime, serverLink) VALUES(?,?,?,?,?,?)");
            $stmt->bind_param('siisss', $data['examName'], $userId, $data['participants'], $dateTimeNow, $data['exam_time'], $randomString);
            $stmt->execute();
            echo "done!";
        } catch (Exception $e) {
            echo "Something went wrong!". $e->getMessage() . $e;
            die();
        }
        return mysqli_insert_id($conn);
    }

    # insert exam questions
    function insertExamQuestions($conn, $data, $examId) {
        $newData = json_encode($data);
        try {
            $stmt = $conn->prepare("INSERT INTO examq(examId, q_json) VALUES(?,?)");
            $stmt->bind_param('is', $examId, $newData);
            $stmt->execute();
            
            echo "<br>done!";
        }catch(Exception $e) {
            echo "Something went wrong! ". $e->getMessage() . $e;
            return 0;
        }
    }

    # get the lists of exams
    function getExamDetailsForExam($userId) {

        $conn = connectToDB();

        $data = [];

        try {
            $result = $conn->query("SELECT examID, examName, startTime, endTime FROM exam WHERE userID='$userId'");

            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    array_push($data, $row);
                }
            }

        } catch (Exception $e) {
            die("Server Error: ".$e->getMessage());
        }

        return $data;

    }

    function getUserInfo($id) {
        $conn = connectToDB();
        
        $query = "SELECT id, fullname, schoolname, address, email FROM users WHERE id=?";
        try {

            $stmt = mysqli_prepare($conn, $query);
            # second param should be filled with letter 's'
            mysqli_stmt_bind_param($stmt, "i", $id);

            mysqli_stmt_execute($stmt);
            # get array results in an array format
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        catch(Exception $e) {
            echo "Something went wrong! ". $e->getMessage() .$e;
            return "Something Went Wrong!";
        }

        return $result;
    }

    function editUserInfo($title, $value, $id) {
        $conn = connectToDB();
        
        $query = "UPDATE users SET $title=? WHERE id=?";
        try {

            $stmt = mysqli_prepare($conn, $query);
            # second param should be filled with letter 's'
            mysqli_stmt_bind_param($stmt, "si", $value, $id);

            mysqli_stmt_execute($stmt);
        }
        catch(Exception $e) {
            echo "Something went wrong! ". $e->getMessage() .$e;
            return 0;
        }

        return 1;
    }

    function editUserPassword($currPW, $newPW, $id) {
        $conn = connectToDB();
        
        $query = "UPDATE users SET password=? WHERE id=? AND password=?";
        try {

            $stmt = mysqli_prepare($conn, $query);
            # second param should be filled with letter 's'
            mysqli_stmt_bind_param($stmt, "sis", $newPW, $id, $currPW);

            mysqli_stmt_execute($stmt);
        }
        catch(Exception $e) {
            echo "Something went wrong! ". $e->getMessage() .$e;
            return 0;
        }

        return 1;
    }

    # get random strings id of exam
    function randomStringID($id) {
        $conn = connectToDB();

        $query = "SELECT examID, userID FROM exam WHERE serverLink=?";
        try {
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "s", $id);

            mysqli_stmt_execute($stmt);
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            
        } catch (EXCEPTION $e) {
            return 0;
            die($e->getMessage());
        }

        return $result;
    }

    # participants
    function addParticipants($name, $pos, $tid, $stringId, $score, $ipaddr) {
        $conn = connectToDB();

        # get examID
        $query1 = "SELECT examID FROM exam WHERE serverLink=?";
        $stmt1 = mysqli_prepare($conn, $query1);
        mysqli_stmt_bind_param($stmt1, "s", $stringId);

        mysqli_stmt_execute($stmt1);
        $result = $stmt1->get_result()->fetch_assoc();

        $id = $result['examID'];

        $query = "INSERT INTO takers(name, position, t_id, e_id, score, ipaddr) VALUES(?,?,?,?,?)";
        try {
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ssii", $name, $pos, $tid, $id, $score, $ipaddr);

            mysqli_stmt_execute($stmt);
            $result = $stmt->get_result();
            var_dump($result);
        } catch (EXCEPTION $e) {
            die($e->getMessage());
        }
        return $id;
    }

    # update exam table for takers, limit only takers on whatever the user set 
    function trackTakersToLimitExaminers($count, $eid) {
        $conn = connectToDB();

        # get exam count 
        $query1 = "SELECT takers_count FROM exam WHERE examID=?";
        $stmt1 = mysqli_prepare($conn, $query1);
        mysqli_stmt_bind_param($stmt1, "i", $eid);

        mysqli_stmt_execute($stmt1);
        $result = $stmt1->get_result()->fetch_assoc();

        $takers_count = $result['takers_count'];
        $_count = $takers_count ? $takers_count + $count : $count;

        $query = "UPDATE exam SET takers_count=".$_count." WHERE examID=?";
        try {
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $eid);

           mysqli_stmt_execute($stmt);
        } catch (EXCEPTION $e) {
            return "Error: Exceeds Limit!";
            die($e->getMessage());
        }
        return 1;
    }

    # delete exam 
    function deleteExam($userId, $examId) {
        $conn = connectToDB();

        $query = "DELETE FROM exam WHERE userID=? AND examID=?";
        try {
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ii", $userId, $examId);

           mysqli_stmt_execute($stmt);
        } catch (EXCEPTION $e) {
            close_connection();
            return 0;
            die($e->getMessage());
        }
        close_connection();
        return 1;

    }

    # get takers or examiners
    function getTakers($eid, $uid) {
        $conn = connectToDB();

        $query = "SELECT name, score FROM takers WHERE t_id=? AND e_id=?";
        try {
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ii", $uid, $eid);

           mysqli_stmt_execute($stmt);
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (EXCEPTION $e) {
            close_connection();
            return 0;
            die($e->getMessage());
        }
        close_connection();
        return $result;

    }

    # get exam questions
    function getExamQuestions($eid) {
        $conn = connectToDB();

        $query = "SELECT examId, q_json FROM examq WHERE examId=?";
        try {
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $eid);

           mysqli_stmt_execute($stmt);
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (EXCEPTION $e) {
            close_connection();
            return 0;
            die($e->getMessage());
        }
        close_connection();
        return $result;

    }

    # check takers limit 
    function takersLimit($stringId) {
        $conn = connectToDB();

        $query = "SELECT participants, takers_count FROM exam WHERE $stringId=?";
        try {
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $stringId);

           mysqli_stmt_execute($stmt);
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (EXCEPTION $e) {
            close_connection();
            return 0;
            die($e->getMessage());
        }
        close_connection();
        return $result;
    }

    # get exam questions with random string id
    function getExamInfoWithRandomStrings($examId) {
        $conn = connectToDB();

        $query = "SELECT * FROM examq WHERE examId=?";
        try {
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "s", $examId);

            mysqli_stmt_execute($stmt);
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (EXCEPTION $e) {
            close_connection();
            return 0;
            die($e->getMessage());
        }
        close_connection();
        return $result;
            
    }

    # get verified using string id's
    function getVerifiedWithString($s) {
        $conn = connectToDB();

        $query = "SELECT COUNT(*) FROM exam WHERE serverLink=?";
        try {
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "s", $s);

            mysqli_stmt_execute($stmt);
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (EXCEPTION $e) {
            close_connection();
            return 0;
            die($e->getMessage());
        }
        close_connection();

        return $result;
    }

    # get takers via ipaddr
    function getTakerViaIPAddr($ip) {
        $conn = connectToDB();

        $query = "SELECT COUNT(*) FROM takers WHERE ipaddr=?";
        try {
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "s", $ip);

            mysqli_stmt_execute($stmt);
            $result = $stmt->get_result()->fetch_array();
        } catch (EXCEPTION $e) {
            close_connection();
            return 0;
            die($e->getMessage());
        }
        close_connection();

        return $result;
    }