<?php
// HEADERS

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/users.php';

// Instantiate DB & connect

$database = new Database();
$db = $database->connect();

// Instantiate user object

$user = new Users($db);

// User query

$result = $user->login();

if (!$result) {
    echo json_encode(array('message' => 'cannot authenticate'));
} else {
    echo json_encode(array('message' => 'user authenticated', 'token' => $result));
}