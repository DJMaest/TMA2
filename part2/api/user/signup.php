<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/User.php';

if (isset($_POST["username"],  $_POST["password"], $_POST["passwordConfirm"])) {
    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $user = new User($db);

    // Blog post query

    if ($_POST["password"] != $_POST["passwordConfirm"]) {
        echo json_encode(
            array('message' => 'Passwords do not match!')
        );
        exit();
    }
    if (strlen($_POST["password"]) < 8) {
        echo json_encode(
            array('message' => 'Password must be at least 8 characters.')
        );
        exit();
    }

    try {
        $result = $user->createAccount($_POST["username"],  $_POST["password"]);
        echo json_encode(
            array('message' => 'Account Created')
        );
    } catch (Exception $e) {
        if (preg_match("/duplicate entry/i", $e->getMessage())) {
            echo json_encode(
                array('message' => 'Username already exists!')
            );
        } else {
            echo json_encode(
                array('message' => 'Error: Could not create account.')
            );
        }
    }
}
