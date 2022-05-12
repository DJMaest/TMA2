<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Enrollment.php';
include_once '../../helper/session.php';
// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$enrollment = new Enrollment($db);


try {
    if (isset($_SESSION["part2_username"])) {
        if (isset($_POST["unitId"])) {
            $_SESSION["unitId"]= $_POST["unitId"];
            echo json_encode(
                array('message' => 'Opened unit')
            );
        }
    } else {
        echo json_encode(
            array('message' => 'User not signed in!')
        );
    }
} catch (Exception $e) {
    print_r($e);
    echo json_encode(
        array('message' => 'Error: Something went wrong')
    );
}