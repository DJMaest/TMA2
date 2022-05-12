<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/BookMark.php';
include_once '../../helper/session.php';

if (isset($_POST["url"])) {
    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $bookMark = new BookMark($db);

    try {
        $result = $bookMark->deleteUserBookMark($_SESSION["part1_username"], $_POST["url"]);
        echo json_encode(
            array('message' => 'Bookmark Removed')
        );
    } catch (Exception $e) {


        echo json_encode(
            array('message' => 'Error: Could not remove bookmark')
        );
    }
}
