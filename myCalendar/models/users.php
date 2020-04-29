<?php


class Users{
//DB stuff
private $conn;
private $table = 'users';

// Users properties

public $id;
public $username;
public $password;

// Constructor with DB

public function __construct($db) {

    $this->conn = $db;
}

// Get users
public function login() {
  

    // Query

    $query = "SELECT * FROM " . $this->table . " WHERE username = ?";

    // Prepare statement

    $stmt = $this->conn->prepare($query);

    // Execute query
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch();

    if ($user && password_verify($_POST['password'], $user['password']))
    {
        return $user['password'];
    } else {
        return false;
    }
}


// create user

    public function create() {

    // Query

    $query = "INSERT INTO " . $this->table . " (username, password) VALUES (?, ?)";
    
    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Execute query
    return $stmt->execute([
        $_POST['username'],
        password_hash($_POST['password'], PASSWORD_DEFAULT)
    ]);
}
}