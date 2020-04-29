<?php
// HEADERS

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Users.php';

// Instantiate DB & connect

$database = new Database();
$db = $database->connect();

// Instantiate event object

$user = new Users($db);

// User query

$result = $user->create();

if (!$result) {
    echo json_encode(array('message' => 'cannot create user'));
} else {
    echo json_encode(array('message' => 'user created'));
}