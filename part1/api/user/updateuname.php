<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/User.php';
include_once '../../helper/session.php';

if (isset($_POST["username"])) {
    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $user = new User($db);

    // Blog post query

    if ($_POST["username"] == $_SESSION["part1_username"]) {
        echo json_encode(
            array('message' => 'This is the same username!')
        );
        // error_log("I got here 1\n", 3, "/Applications/XAMPP/logs/php_error_log");
        exit();
    }

    try {
        $result = $user->updateUsername($_POST["username"], $_SESSION["part1_username"]);
        echo json_encode(
            array('message' => 'Username updated')
        );
        $_SESSION["part1_username"] = $_POST["username"];
        // error_log("I got here 2\n", 3, "/Applications/XAMPP/logs/php_error_log");
    } catch (Exception $e) {
        // error_log("I got here 3\n", 3, "/Applications/XAMPP/logs/php_error_log");
        if (preg_match("/duplicate entry/i", $e->getMessage())) {
            echo json_encode(
                array('message' => 'Username already exists!')
            );
        } else {
            echo json_encode(
                array('message' => 'Error: Could not add username')
            );
        }
    }
}
