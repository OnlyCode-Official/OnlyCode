<?php
require 'vendor/autoload.php';
use Gravatar\Gravatar;
$url = $_SERVER['REQUEST_URI'];
$path = parse_url($url, PHP_URL_PATH);
$pathParts = explode('/', ltrim($path, '/'));
$parsed_url = [];

foreach ($pathParts as $index => $part) {
    $parsed_url[$index] = $part;
}

$owner = $parsed_url[0];

$repo = $parsed_url[1];

if(isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    $imageUrl = Gravatar::image($email, defaultImage: "identicon")->url();
}

if (empty($parsed_url[2])) {
    header("Location: /$owner/$repo/blob/master/");
}

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

        .topNav {
            background: rgb(6, 20, 53);
            width: 100%;
            border-radius: 1rem;
        }

        .right-links {
            float: right;
            padding-right: 0.75rem;
            padding-top: 5px;
            padding-bottom: 5px;
            margin-top: 5px;
            text-decoration: none;
            border: none;
        }
        
        .left-links {
            padding-left: 0.75rem;
            padding-top: 5px;
            padding-bottom: 5px;
            display: inline-block;
        }
        
        .pfp {
            border-radius: 30px;
        }

        .settings-sidenav {
            border-radius: 1rem;
            padding-left: 1rem;
            padding-top: 2rem;
            float: left;
            height: 100%;
            margin-left: 2rem;
            margin-top: 2rem;
        }

        .settings-sidenav a {
            color: white;
            text-decoration: none;
            font-size: 30px;
        }

        .settings-sidenav a:hover {
            padding: 1rem;
            height: 3rem;
        }

        .settings-general {
            border: 1px solid white;
            float: right;
            margin-top: 4rem;
        }
            
    </style>
";

ob_start();

echo "
    <nav class='topNav'>
    <div class='left-links'>
        <a href='/' alt='home-button'><img src='https://OnlyGit-Official.github.io/icons/small-logo.png' width='50' height='50' alt='onlygit-logo'></a>
    </div>

    <div class='right-links'>

    <a href='/create' alt='create-repo-button' style='padding-right: 0.75rem; text-decoration: none;'>
        <span class='svg'>
            <svg xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-plus'><path d='M5 12h14'/><path d='M12 5v14'/></svg>
        </span>
    </a>

    <a href='/issues' alt='issues-button' style='padding-right: 0.90rem; text-decoration: none;'>
        <span class='svg'>
            <svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-circle-dot'><circle cx='12' cy='12' r='10'/><circle cx='12' cy='12' r='1'/></svg>
        </span>
    </a>

    <a href='/pr' alt='pull-request-button' style='padding-right: 0.90rem; text-decoration: none;'>
        <span class='svg'>
            <svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-git-pull-request-arrow'><circle cx='5' cy='6' r='3'/><path d='M5 9v12'/><circle cx='19' cy='18' r='3'/><path d='m15 9-3-3 3-3'/><path d='M12 6h5a2 2 0 0 1 2 2v7'/></svg>
        </span>
    </a>

    <a href='/notifications' alt='notifications-button' style='padding-right: 0.90rem; text-decoration: none;'>
        <span class='svg'>
            <svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-bell-ring'><path d='M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9'/><path d='M10.3 21a1.94 1.94 0 0 0 3.4 0'/><path d='M4 2C2.8 3.7 2 5.7 2 8'/><path d='M22 8c0-2.3-.8-4.3-2-6'/></svg>
        </span>
    </a>

    <a href='/$username'>
        <span class='svg'>
            <img  class='pfp' src='$imageUrl' height='40' width='40'/>
        </span>
    </a>

    </div>
    </nav>
";

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

        $query = "SELECT `visibility` FROM `repos` WHERE `name` = ? AND `owner` = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $parsed_url[1], $parsed_url[0]);
        $stmt->execute();
        $stmt->bind_result($visibility);
        $stmt->fetch();
        $stmt->close();

        if ($visibility == "private"){

            if (!isset($username)) {
                ob_end_clean();
                require "404.php";
                die();
            }

            $query = "SELECT `id`, `admin` FROM `users` WHERE `username` = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($id, $admin);
            $stmt->fetch();
            $stmt->close();

            $query = "SELECT `collaborators` FROM `repos` WHERE `name` = ? AND `owner` = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $parsed_url[1], $parsed_url[0]);
            $stmt->execute();
            $stmt->bind_result($collaborators);
            $stmt->fetch();
            $stmt->close();
            
            if (empty($collaborators)) {
                $collaborators = "[]";
            }

            $collab_array = json_decode($collaborators, true);
            if (!in_array($username, $collab_array)) {
                if ($id != 1 && $admin != true && $parsed_url[0] != $username){
                    ob_end_clean();
                    require "404.php";
                    die();
                }
            }

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
            ob_end_clean();
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
            ob_end_clean();
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

        if(mb_check_encoding($contents, 'ASCII')) {

            echo nl2br("<pre class='content'>" . htmlspecialchars($contents ?? '') . "</pre>");

        } else {
            echo "File Contains Non-Ascii Characters";
        }

        die();
    } elseif ($parsed_url[2] == "commits") {

    } elseif ($parsed_url[2] == "branches") {
        
    } elseif ($parsed_url[2] == "settings") {
        echo "
            <div class='settings-sidenav'>
                <a href='/$parsed_url[0]/$parsed_url[1]/settings'><span class='svg'><svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-cog'><path d='M12 20a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z'/><path d='M12 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z'/><path d='M12 2v2'/><path d='M12 22v-2'/><path d='m17 20.66-1-1.73'/><path d='M11 10.27 7 3.34'/><path d='m20.66 17-1.73-1'/><path d='m3.34 7 1.73 1'/><path d='M14 12h8'/><path d='M2 12h2'/><path d='m20.66 7-1.73 1'/><path d='m3.34 17 1.73-1'/><path d='m17 3.34-1 1.73'/><path d='m11 13.73-4 6.93'/></svg></span> General Settings</a>
                <br>
                <br>
                <a href='/$parsed_url[0]/$parsed_url[1]/settings/collaborators'><span class='svg'><svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-users-round'><path d='M18 21a8 8 0 0 0-16 0'/><circle cx='10' cy='8' r='5'/><path d='M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3'/></svg></span> Collaborators</a>
            </div>
        ";

        if(empty($parsed_url[3])){
            echo "
                <div class='settings-general'>
                    <input type='text'></input>
                </div>
            ";
        }
        
    } elseif ($parsed_url[2] == "analytics") {
        
    } elseif ($parsed_url[2] == "issues") {
        
    } elseif ($parsed_url[2] == "pr") {
        
    } elseif ($parsed_url[2] == "wiki") {
        
    } else {
        ob_end_clean();
        require "404.php";
    }

}
