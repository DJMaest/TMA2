<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/User.php';
include_once '../../helper/session.php';

if (isset($_POST["newPass"], $_POST["oldPass"])) {
    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $user = new User($db);

    if (strlen($_POST["newPass"]) < 8) {
        echo json_encode(
            array('message' => 'Password must be at least 8 characters')
        );
        exit();
    }

    $result = $user->read($_SESSION["part1_username"], $_POST["oldPass"]);
    // Get row count
    $num = $result->rowCount();

    // Check if any posts
    if ($num > 0) {
        try {
            $result = $user->updatePassword($_SESSION["part1_username"], $_POST["newPass"]);
            echo json_encode(
                array('message' => 'Password changed')
            );
        } catch (Exception $e) {

            echo json_encode(
                array('message' => 'Error: Could change password')
            );
        }
    } else {
        // No Posts
        echo json_encode(
            array('message' => 'Incorrect Password')
        );
    }
}
