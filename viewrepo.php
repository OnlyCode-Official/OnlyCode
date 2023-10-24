<?php

echo "repo<br>";
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

/*

User/repo/mode/branch1/folder/folder/folder/file
User/repo/mode/branch2/folder/folder/file
User/repo/mode/branch1/folder/folder/folder/folder/file
User/repo/mode/branch4/folder/folder/folder/folder/folder/file
              ^    ^^^|_______________________________________|                 
           same  check                   |
                                      variable 
*/