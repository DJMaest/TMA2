<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include_once '../../helper/session.php';

unset($_SESSION['part2_username']);
echo json_encode(
    array('message' => 'Logged Out')
);
