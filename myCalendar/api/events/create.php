<?php
// HEADERS

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Event.php';

// Instantiate DB & connect

$database = new Database();
$db = $database->connect();

// Instantiate event object

$event = new Events($db);

// Event query

$result = $event->create();

if (!$result) {
    echo json_encode(array('message' => 'cannot create event'));
} else {
    echo json_encode(array('message' => 'event created'));
}