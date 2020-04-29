<?php


class Events{
//DB stuff
private $conn;
private $table = 'events';

// Events properties

public $id;
public $description;
public $from;
public $to;
public $location;

// Constructor with DB

public function __construct($db) {

    $this->conn = $db;
}

// Get events
public function read() {
    
    $sort = 'ASC';
    if (isset($_GET['sort'])) {
        $sort = $_GET['sort'];
    }

    $from = '01/01/1970';
    if (isset($_GET['from'])) {
        $from = $_GET['from'];
    }

    // Query

    $query = "SELECT e.id, e.description, e.event_from, e.event_to, e.location FROM " . $this->table . " e WHERE e.event_from > '" . date("Y-m-d H:i:s", strtotime($from)) . "' ORDER BY e.event_from " . $sort;
    // Prepare statement

    $stmt = $this->conn->prepare($query);

    // Execute query
    $stmt->execute();

    return $stmt;
}


// Update events
public function update() {

    // Query

    $query = "UPDATE 
    " . $this->table . "
    SET 
    description = ?, 
    event_from = ?, 
    event_to = ?, 
    location = ? 
    WHERE 
    id = ?
    ";
    
    // Prepare statement

    $stmt = $this->conn->prepare($query);

    // Execute query
    $stmt->execute([
        $_POST['description'],
        date("Y-m-d H:i:s", strtotime($_POST['from'])),
        date("Y-m-d H:i:s", strtotime($_POST['to'])),
        $_POST['location'],
        $_POST['id']
    ]);

    return $stmt;
}

// create event
public function create() {

    // Query

    $query = "INSERT INTO " . $this->table . " (description, event_from, event_to, location) VALUES (?, ?, ?, ?)";
    
    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Execute query
    return $stmt->execute([
        $_POST['description'],
        date("Y-m-d H:i:s", strtotime($_POST['from'])),
        date("Y-m-d H:i:s", strtotime($_POST['to'])),
        $_POST['location']
    ]);
}

// Delete events
public function delete() {

    // Query

    $query = "DELETE 
    FROM " . $this->table . "
    WHERE 
    id = ?
    ";
    
    // Prepare statement

    $stmt = $this->conn->prepare($query);

    // Execute query
    return $stmt->execute([
        $_POST['id']
    ]);
}
    

}
