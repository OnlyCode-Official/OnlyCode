<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon shortcut" type="image/png" href="https://onlycode-official.github.io/icons/favicon.ico">
    <title></title>
</head>
</html>

<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require "checkBan.php";

function route($url): string {
    
    // print_r($url);

    if (file_exists($url[0])){
        return "404";
    }

    $routes = [
        'login' => 'login',
        'signup' => 'signup',
        'api' => 'api',
        'logout' => 'logout',
        'admin' => 'admin',
        'test' => 'test',
    ];
    if (empty($url[0])){
        return "home";
    }
    return $routes[$url[0]]??'404';

}


$url = $_SERVER['REQUEST_URI'];
$path = parse_url($url, PHP_URL_PATH);
$pathParts = explode('/', ltrim($path, '/'));
$parsed_url = [];


foreach ($pathParts as $index => $part) {
    $parsed_url[$index] = $part;
}

$router_output = route($parsed_url);

// echo "$router_output";

$file = $router_output . ".php";

include "$file";

include 'dbconn.php';




?>