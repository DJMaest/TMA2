<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/BookMark.php';
include_once '../../helper/urlChecker.php';
include_once '../../helper/session.php';

if (isset($_POST['url'], $_POST['title'])) {
    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();
    $bookMark = new BookMark($db);

    try {

        if (!urlIsOk($_POST["url"])) {
            echo json_encode(
                array('message' => 'URL not active!')

            );
            exit();
        }

        if (!$_POST["title"]) {
            echo json_encode(
                array('message' => 'Title is empty!')

            );

            exit();
        }

        $result = $bookMark->postUserBookMark($_POST["url"], $_SESSION["part1_username"], $_POST["title"]);
        echo json_encode(
            array('message' => 'Bookmark added')
        );
    } catch (Exception $e) {
        if (preg_match("/duplicate entry/i", $e->getMessage())) {
            echo json_encode(
                array('message' => 'Bookmark already added!')
            );
        } else {
            echo json_encode(
                array('message' => 'Could not add bookmark!')
            );
        }
    }
}
