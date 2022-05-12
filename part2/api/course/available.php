<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Unit.php';
include_once '../../models/Enrollment.php';
include_once '../../helper/session.php';
// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$unit = new Unit($db);
$enrollment = new Enrollment($db);

// Blog post query

$result = $unit->getAvailableUnits();
// Get row count
$num = $result->rowCount();

// Check if any posts
if ($num > 0) {
    // Post array
    $units_arr = array();
    $units_arr['data'] = array();
    // session_start();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $unit_item = array(
            'unit_id' => $unit_id,
            'unit_name' => $unit_name,
            'enrolled'=> (isset($_SESSION["part2_username"]))? $enrollment->isEnrolled($_SESSION["part2_username"], $unit_id):false
        );

        // Push to "data"

        array_push($units_arr['data'], $unit_item);
        // header("Location: ../../welcome.php");
        // array_push($users_arr['data'], $user_item);
    }

    // Turn to JSON & output
    // echo json_encode($users_arr);
    echo json_encode(
        $units_arr
    );
} else {
    // No Posts
    echo json_encode(
        array('message' => 'No courses available')
    );
}
