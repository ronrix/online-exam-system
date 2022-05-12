<?php

session_start();

include_once "../model/User.php";

$conn = connectToDB();

// insert question to table
// $data = json_decode($_POST['data'], true);
// $examDetails = json_decode($_POST['exam_details'], true);
# get raw inputs from POST method, sent by JS
$content = trim(file_get_contents("php://input"));
$data = json_decode($content, true);

$userId = explode(':', $_SESSION['userId'])[0];

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// insert exam details
$examId = insertExamDetails($conn, $data, $userId, generateRandomString(15) . ":" . $userId);

// insert exam questions
insertExamQuestions($conn, $data['data'], $examId);

$conn->close();

if($examId) {
    die(json_encode(["status"=>"SUCCESS"]));
}
else {
    die(json_encode(["status"=>"ERROR"]));
}