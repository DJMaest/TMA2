<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Quiz.php';
include_once '../../helper/session.php';
// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$quiz = new Quiz($db);

// Blog post query

$result = $quiz->getQuizCorrectAnswers($_POST["quizId"]);
// Get row count
$num = $result->rowCount();

// Check if any posts
if ($num > 0) {
    // Post array
    $ans_arr = array();
    $ans_arr['data'] = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $unit_item = array(
            'answer_id' => $answer_id,
            'content' => $content,
            'question_id'=> $question_id,
        );

        // Push to "data"

        array_push($ans_arr['data'], $unit_item);
        // header("Location: ../../welcome.php");
        // array_push($users_arr['data'], $user_item);
    }

    // Turn to JSON & output
    // echo json_encode($users_arr);
    echo json_encode(
        $ans_arr
    );
} else {
    // No Posts
    echo json_encode(
        array('message' => 'Quiz Data Not Found')
    );
}
