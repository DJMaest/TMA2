<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/BookMark.php';
include_once '../../helper/session.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$bookMark = new BookMark($db);

$result = $bookMark->getUserBookMarks($_SESSION["part1_username"]);
// Get row count
$num = $result->rowCount();

// Check if any posts
if ($num > 0) {
    // Post array
    $bookmark_arr = array();
    $bookmark_arr['data'] = array();
    // session_start();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $bookmark_item = array(
            'bookmark_url' => $bookmark_url,
            'title' => $title,
        );

        // Push to "data"

        array_push($bookmark_arr['data'], $bookmark_item);
        // header("Location: ../../welcome.php");
        // array_push($users_arr['data'], $user_item);
    }

    // Turn to JSON & output
    // echo json_encode($users_arr);
    echo json_encode(
        $bookmark_arr
    );
} else {
    // No Posts
    echo json_encode(
        array('message' => 'You have no bookmarks!')
    );
}
