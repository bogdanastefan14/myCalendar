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

$result = $event->update();

if (!$result) {
    echo json_encode(array('message' => 'cannot update event'));
} else {
    echo json_encode(array('message' => 'event updated'));
}