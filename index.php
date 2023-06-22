<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "checkIP.php";

function route($url){
    
    // print_r($url);

    if (file_exists($url[0])){
        return "404";
    }

    $routes = [
        'login' => 'login',
        'signup' => 'signup',
        'api' => 'api',
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