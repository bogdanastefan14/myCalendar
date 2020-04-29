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

$result = $event->read();

// Get row count

$num = $result->rowCount();


// check authorization
$headers = getallheaders();

if (isset($headers['Authorization'])) {
    echo $headers['Authorization'];
} else {
    echo 'unauthorized';
}

// Check if any events

if($num > 0) {

    // event array
    $event_arr = array();
    $event_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $event_item = array(

            'id' => $row['id'],
            'description' => $row['description'],
            'event_from' => $row['event_from'],
            'event_to' => $row['event_to'],
            'location' => $row['location'],
        );

        // Push to data

        array_push($event_arr['data'], $event_item);
    }

    // Turn to json & output
    echo json_encode($event_arr);
} else {
    // if not events
    echo json_encode(

        array('message' => 'no events found')
    );

}