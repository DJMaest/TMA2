<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/BookMark.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$bookMark = new BookMark($db);


// Blog post query
$result = $bookMark->getPopular();
// Get row count
$num = $result->rowCount();

// Check if any posts
if ($num > 0) {
    // Post array
    $pop_arr = array();
    $pop_arr['data'] = array();
    // session_start();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $bookmark_item = array(
            'used_count' => $used_count,
            'url' => $url,
        );

        // Push to "data"

        array_push($pop_arr['data'], $bookmark_item );

    }

    echo json_encode(
        $pop_arr
    );
   
} else {
    // No Posts
    echo json_encode(
        array('message' => 'User Not Found')
    );
}
