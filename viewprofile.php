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

$query = "SELECT `email` FROM `users` WHERE `username` = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $parsed_url[0]);
$stmt->execute();
$stmt->bind_result($profileOwnerEmail);
$stmt->fetch();
$stmt->close();

$targetProfileImageUrl = Gravatar::image($profileOwnerEmail, 300, defaultImage: "identicon")->url();

if (isset($_SESSION['email'])){
    $email = $_SESSION['email'];
    $imageUrl = Gravatar::image($email, defaultImage: "identicon")->url();
}

?>

<html>
    <head>
        <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Wix Madefor Text'>
        <link href='https://fonts.googleapis.com/css?family=JetBrains Mono' rel='stylesheet'>
        <style>
            body {
                font-family: 'Wix Madefor Text';
                background-color: #06081f;
                height: 100%;
                color: white;
            }

            .a_border {
                border-style: solid;
                border-radius: 10px;
                border-color: rgba(116, 114, 114, 0.217);
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

            .targetProfilePfp {
                border-radius: 50%;
                border: 2px solid white;
            }

            .pageContents {
                display: inline-flex;
                width: 100%;
            }

            .leftnav {
                padding: 1rem;
                float: left;
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                align-items: center;
                width: 300px;
                height: 300px;
                margin-left: 2rem;
                margin-top: 2rem;
            }

            .leftnav p {
                font-size: 35px;
                text-align: center;
            }
            
            .userContents {
                border: 1px solid white;
                border-radius: 1rem;
                float: left;
                margin-left: 3rem;
                margin-top: 3rem;
                margin-right: 3rem;
                padding-left: 1rem;
                width: 100%;
                flex-grow: 1;
            }

            .repo {
                font-size: 25px;
                padding: 10px;
                color: white;
                text-decoration: none;
                font-family: 'JetBrains Mono';
            }

            .repo:hover {
                border-style: solid;
                border-radius: 10px;
                border-color: rgba(102, 205, 222, 0.8);
                display: inline-block;
                width: 95%;
            }

            .a_border {
                border-style: solid;
                border-radius: 10px;
                border-color: rgba(116, 114, 114, 0.217);
                display: inline-block;
                width: 95%;
            }
        </style>
    </head>

    <body>
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

                    <a href='<?php echo"/$username"; ?>'>
                        <span class='svg'>
                            <img  class='pfp' src='<?php echo "$imageUrl"; ?>' height='40' width='40'/>
                        </span>
                    </a>

                </div>
        </nav>
        <br>
        <div class='pageContents'>
            <div class='leftnav'>
                <img src='<?php echo "$targetProfileImageUrl"; ?>' width='300' height='300' class='targetProfilePfp'>
                <br>
                <p class='targetUsername'><?php echo "$parsed_url[0]"; ?></p>
                <br>
            </div>
            <div class='userContents'>
                <h1><?php echo "$parsed_url[0]"; ?>'s Repositories</h1>
                <?php
                    foreach (scandir("/show/$parsed_url[0]") as $repo) {
                        if ($repo == "." || $repo == ".."){
                            continue;
                        }
                        echo "<a class='repo a_border' href='/$parsed_url[0]/$repo'><span class='svg'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='#ffffff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-book-marked'><path d='M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20'/><polyline points='10 2 10 10 13 7 16 10 16 2'/></svg></span> $repo</a><br><br><br>";
                    }
                ?>
            </div>
        </div>
    </body>
</html>