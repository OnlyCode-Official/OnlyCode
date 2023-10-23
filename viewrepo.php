<?php

$url = $_SERVER['REQUEST_URI'];
$path = parse_url($url, PHP_URL_PATH);
$pathParts = explode('/', ltrim($path, '/'));
$parsed_url = [];


foreach ($pathParts as $index => $part) {
    $parsed_url[$index] = $part;
}

$owner = $parsed_url[0];
$repo = $parsed_url[1];

foreach (scandir("/show/$owner/$repo") as $contents) {
    if ($contents == "." || $contents == ".."){
        continue;
    }
    echo "$contents<br>";
}