<?php

session_start();

include_once "../model/User.php";

$conn = connectToDB();

// insert question to table
$data = json_decode($_POST['data'], true);
$examDetails = json_decode($_POST['exam_details'], true);

// insert exam details
$examId = insertExamDetails($conn, $examDetails[0]);

// insert exam questions
insertExamQuestions($conn, $data[0], $examId);

$conn->close();

header("Location: ../view/app/create_exam.view.php");