<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


$config = file_get_contents('config.json');



$data = json_decode($config);


$use_root = $data->mariadb_use_privilaged_account;

if ($use_root == 'false') {
    $password = $data->mariadb_password;
    
    $conn = new mysqli("localhost", "onlycode", $password, "onlycode");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
} else {
    $password = $data->mariadb_root_password;
    
    $conn = new mysqli("127.0.0.1", "onlycode_root", $password, "onlycode");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    echo "YOU ARE LOGGED IN AS THE ROOT USER! YOU MIGHT DAMAGE THE SERVER!";
}

