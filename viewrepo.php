<?php

echo "
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Wix Madefor Text'>
    <link href='https://fonts.googleapis.com/css?family=JetBrains Mono' rel='stylesheet'>
    <style>
        body {
            font-family: 'Wix Madefor Text';
            background-color: #06081f;
            height: 100%;
            color: white;
        }

        .content {
            font-family: 'JetBrains Mono';
            font-size: 18px;
            padding-left: 20px;
        }

        .empty {
            font-family: 'JetBrains Mono';
            font-size: 20px;
        }

        .owner_repo {
            font-size: 30px;
            padding-left: 10px;
        }

        .a_border {
            border-style: solid;
            border-radius: 10px;
            border-color: rgba(116, 114, 114, 0.217);
            display: inline-block;
            width: 95%;
        }

        .repo_contents {
            font-size: 18px;
            padding: 10px;
            margin-left: 20px;
            color: white;
            text-decoration: none;
            font-family: 'JetBrains Mono';
        }

        .repo_contents:hover {
            border-style: solid;
            border-radius: 10px;
            border-color: rgba(102, 205, 222, 0.8);
            display: inline-block;
            width: 95%;
        }

        .svg {
            vertical-align: middle;
            display: inline-block;
            text-decoration: none;
        }
    </style>
";

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
        shell_exec("cd /show/$owner/$repo && sudo git pull");

        // htmlspecialchars($something ?? '');
        $branches_trimmed = trim($branches ?? '');

        $branches_final = str_replace("* ", "", $branches_trimmed);

        $branches_array = explode("\n", $branches_final);

        // print_r($branches_array);
        // echo "<br>";
        
        $target = $parsed_url[3];

        // check if branches_array is empty

        if (empty($branches_array[0])) {
            echo "<p class='empty'>This repository is empty</p>";
            die();
        }

        if (!in_array($target, $branches_array)) {
            require "404.php";
            die();
        }

        shell_exec("cd /show/$owner/$repo && sudo git checkout $target && sudo git pull");

        $path_array = array_slice($parsed_url, 4);
        // print_r($path_array);

        $path_string = implode("/", $path_array);
        // echo "<br>$path_string";

        echo "<h1 class='owner_repo'>$owner/$repo/$path_string</h1>";

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
                // if $contsnts is a directory, add a folder svg, if its a file, add a file svg
                if (is_dir("$path/$contents")){
                    echo "<a class='repo_contents a_border' href='/$redirect'><span class='svg'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-folder-open'><path d='m6 14 1.5-2.9A2 2 0 0 1 9.24 10H20a2 2 0 0 1 1.94 2.5l-1.54 6a2 2 0 0 1-1.95 1.5H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H18a2 2 0 0 1 2 2v2'/></svg></span> $contents</a><br><br>";
                } else {
                    echo "<a class='repo_contents a_border' href='/$redirect'><span class='svg'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-file-code'><path d='M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z'/><polyline points='14 2 14 8 20 8'/><path d='m10 13-2 2 2 2'/><path d='m14 17 2-2-2-2'/></svg></span> $contents</a><br><br>";
                
                }
            }
            die();
        }

        // print contents of file
        $fs = filesize("$path");
        $f = fopen($path, 'r');
        $contents = fread($f, $fs);
        fclose($f);

        echo nl2br("<pre class='content'>" . htmlspecialchars($contents ?? '') . "</pre>");



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