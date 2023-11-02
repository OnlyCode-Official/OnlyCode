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

/*
    User/repo/mode/branch1/folder/folder/folder/file
    User/repo/mode/branch2/folder/folder/file
    User/repo/mode/branch1/folder/folder/folder/folder/file
    User/repo/mode/branch4/folder/folder/folder/folder/folder/file
*/

if (!empty($parsed_url[2])) {
    if ($parsed_url[2] == "blob") {
        if(empty($parsed_url[3])) {
            require "404.php";
            die();   
        }
        shell_exec("sudo git config --global --add safe.directory $owner/$repo");
        $branches = shell_exec("cd /show/$owner/$repo && sudo git branch");

        //remove trailing spaces
        $branches_trimmed = trim($branches);
        // remove the *
        $branches_final = str_replace("* ", "", $branches_trimmed);

        $branches_array = explode("\n", $branches_final);

        // print array
        print_r($branches_array);
        echo "<br>";
        die();
    } elseif ($parsed_url[2] == "commits") {

    } elseif ($parsed_url[2] == "branches") {
        
    } elseif ($parsed_url[2] == "settings") {
        
    } elseif ($parsed_url[2] == "analytics") {
        
    } elseif ($parsed_url[2] == "issues") {
        
    } elseif ($parsed_url[2] == "pr") {
        
    } elseif ($parsed_url[2] == "wiki") {
        
    }

}

foreach (scandir("/show/$owner/$repo") as $contents) {
    if ($contents == "." || $contents == ".."){
        continue;
    }
    echo "$contents<br>";
}
