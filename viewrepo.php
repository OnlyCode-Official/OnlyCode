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

        $branches_trimmed = trim($branches);

        $branches_final = str_replace("* ", "", $branches_trimmed);

        $branches_array = explode("\n", $branches_final);

        // print_r($branches_array);
        // echo "<br>";
        
        $target = $parsed_url[3];

        if (!in_array($target, $branches_array)) {
            require "404.php";
            die();
        }

        shell_exec("cd /show/$owner/$repo && sudo git checkout $target && sudo git pull");

        $path_array = array_slice($parsed_url, 4);
        // print_r($path_array);

        $path_string = implode("/", $path_array);
        // echo "<br>$path_string";

        $path = "/show/$owner/$repo/" . $path_string;
        // echo "$path<br>";

        // check if path exists
        if (!file_exists($path)) {
            require "404.php";
            die();

        }

        // check if path is a directory
        if (is_dir($path)) {
            foreach (scandir($path) as $contents) {
                if ($contents == "." || $contents == ".."){
                    continue;
                }
                $fullpath = implode("/", $parsed_url);
                // check if $fullpath ends with a slash
                if (substr($fullpath, -1) == "/") {
                    // delete the slash
                    $fullpath = substr($fullpath, 0, -1);
                }
                $redirect = $fullpath . "/" . $contents;
                echo "<a href='/$redirect'>$contents</a><br>";
            }
            die();
        }

        // print contents of file
        $fs = filesize("$path");
        $f = fopen($path, 'r');
        $contents = fread($f, $fs);
        fclose($f);

        echo nl2br(htmlspecialchars($contents));



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

header("Location: /$owner/$repo/blob/master/");