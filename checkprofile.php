<?php

require "dbconn.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$url = $_SERVER['REQUEST_URI'];
$path = parse_url($url, PHP_URL_PATH);
$pathParts = explode('/', ltrim($path, '/'));
$parsed_url = [];


foreach ($pathParts as $index => $part) {
    $parsed_url[$index] = $part;
}

$MaybeUsername = $parsed_url[0];

$query = "SELECT `id` FROM users WHERE `username` = ? AND `suspended` = 0 AND `terminated` = 0";

$stmt = $conn->prepare($query);

$stmt->bind_param("s", $MaybeUsername);

$stmt->execute();

$stmt->bind_result($id);

$stmt->fetch();

$stmt->close();

if (!isset($parsed_url[1]) || empty(trim($parsed_url[1]))){

    if (empty($id)){
        require "404.php";
        die();
    } else {
        require "viewprofile.php";
        die();    
    }

} elseif (!empty(trim($parsed_url[1]))){
    $query = "SELECT `name` FROM `repos` WHERE `name` = ? AND `owner` = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $parsed_url[1], $MaybeUsername);
    $stmt->execute();
    $stmt->bind_result($repo);
    $stmt->fetch();
    $stmt->close();
    if (empty($repo)){
        require "404.php";
        die();
    } else {
        require "viewrepo.php";
        die();
    }
}