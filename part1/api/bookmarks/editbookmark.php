<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/BookMark.php';
include_once '../../helper/urlChecker.php';
include_once '../../helper/session.php';

if (isset($_POST["title"], $_POST["new_title"], $_POST["url"], $_POST["new_url"], $_SESSION["part1_username"])) {
    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $bookMark = new BookMark($db);

    // Blog post query


    try {

        // Send the request & save response to $resp
        // $resp = file_get_contents( $_POST["new_url"] );
        // error_log(print_r($resp, true), 3, "/Applications/XAMPP/logs/php_error_log");
        if (!urlIsOk($_POST["new_url"])) {
            echo json_encode(
                array('message' => 'URL not active!')

            );

            exit();
        }
        if (!$_POST["new_title"]) {
            echo json_encode(
                array('message' => 'Title is empty!')

            );

            exit();
        }
        $result = $bookMark->editUserBookMark($_POST["title"], $_POST["new_title"], $_POST["url"], $_POST["new_url"], $_SESSION["part1_username"]);
        echo json_encode(
            array('message' => 'Bookmark Editted')
        );
    } catch (Exception $e) {
        if (preg_match("/duplicate entry/i", $e->getMessage())) {
            echo json_encode(
                array('message' => 'Bookmark already exists!')
            );
        } else {

            echo json_encode(
                array('message' => 'Error: Could not edit bookmark')
            );
        }
    }
}
