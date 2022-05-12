<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/User.php';
include_once '../../helper/session.php';

if (isset($_GET["username"], $_GET["password"])) {
    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $user = new User($db);


    // Blog post query
    $result = $user->read($_GET["username"], $_GET["password"]);
    // Get row count
    $num = $result->rowCount();

    // Check if any posts
    if ($num > 0) {
        // Post array
        $users_arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $user_item = array(
                'username' => $username,
                'password' => $password,
            );

            // Push to "data"

            $_SESSION["part2_username"] = $user_item['username'];

        }

        // Turn to JSON & output
        // echo json_encode($users_arr);
        echo json_encode(
            array('message' => 'Login Success')
        );
    } else {
        // No Posts
        echo json_encode(
            array('message' => 'Invalid Credentials')
        );
    }
}
