<?php
echo "    
    <script>
        function redirect(location){
            window.location.replace(location)
        }
    </script>
    ";
if (!isset($_SESSION["loggedin"])) {
    echo "<script>redirect('/login');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Wix Madefor Text">
    <title>Import Repository · OnlyGit</title>
    <style>
        @import url("https://fonts.googleapis.com/css?family=JetBrains%20Mono");
        body {
            font-family: "Wix Madefor Text";
            background-color: #06081f;
            color: white;
        }
        .slash {
            font-size: 30pt;
            vertical-align: middle;
            padding: 5px;
        }
        .label2 {
            padding-left: 180px;
        }
        .center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        #repo {height: 30px;width:300px;background-color:#282960;border-radius:10px;border: 2px solid rgba(255, 255, 255, 0.747);color:white;font-family: 'JetBrains Mono';font-size: 23px;padding-left: 7px;vertical-align: middle}
        #url {height: 30px;width:535px;background-color:#282960;border-radius:10px;border: 2px solid rgba(255, 255, 255, 0.747);color:white;font-family: 'JetBrains Mono';font-size: 23px;padding-left: 7px;vertical-align: middle; margin-bottom: 5px; margin-top: 5px;}
        #owner {
            vertical-align: middle;
            width: 200px;
            height: 37px;
            padding: 10px;
            /* border: 2px solid #3498db; */
            border-radius: 5px;
            background-color: #f2f2f2;
            color: #333;
            font-size: 16px;
        }
        #owner option {
            background-color: #fff;
            color: #333;
        }
        .create-button {
            width: 100%;
            max-width: 915px;
            background-color: #3bd0e1;
            color: white;
            padding: 10px;
            border: none;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px 0;
            cursor: pointer;
            border-radius: 10px;
        }
        svg {
            vertical-align: top;
        }
        .container {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 22px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #eee;
            border-radius: 50%;
        }


        .container:hover input ~ .checkmark {
            background-color: #ccc;
        }


        .container input:checked ~ .checkmark {
            background-color: #2196F3;
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        .container input:checked ~ .checkmark:after {
            display: block;
        }

        .container .checkmark:after {
            top: 9px;
            left: 9px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: white;
        }

        .error {
            background-color: #f54747;
            padding: 10px;
            border-style: solid;
            border-radius: 10px;
            border-color: rgba(116, 114, 114, 0.217);
            text-align: center;
        }

        .importrepo-text {
            text-align: center;
            padding: 10px;
        }

        form {
            border-style: solid;
            border-radius: 10px;
            border-color: rgba(116, 114, 114, 0.217);
            padding: 40px;
        }

    </style>
</head>
<body>
<div class="center">
    <div class='importrepo-text'>
        <a href="/"><img src="https://OnlyGit-official.github.io/icons/small-logo.png" alt="logo" height="100" width="100" draggable="false"></img></a>
        <h3>Import a Repository</h3>
    </div>
    <?php
    $url = $_SERVER['REQUEST_URI'];
    $path = parse_url($url, PHP_URL_PATH);
    $pathParts = explode('/', ltrim($path, '/'));
    $parsed_url = [];

    foreach ($pathParts as $index => $part) {
        $parsed_url[$index] = $part;
    }

    if (!empty($parsed_url[2]) && $parsed_url[1] == "error"){
        if ($parsed_url[2] == "taken"){
            echo "<h4 class='error'>The name that you picked is unavailable!</h4>";
        } elseif ($parsed_url[2] == "empty"){
            echo "<h4 class='error'>Repository URL can not be empty!</h4>";
        } elseif ($parsed_url[2] == "failed") {
            echo "<h4 class='error'>OnlyGit failed to import your repository!</h4>";
        }
    }
    ?>
    <form action="/api/import" method="post">
        <label for="url">
           Repository URL:
        </label>
        <br>
        <input type="text" id="url" name="url">
        <br>
        <label for="owner">
            Owner:
        </label>
        <label for="repo" class="label2">
            Repository name:
        </label>
        <br>
        <select name="owner" id="owner">
            <?php
            $username = $_SESSION["username"];
            echo "<option value='$username'>$username</option>";
            ?>
        </select>
        <span class="slash">/</span>
        <input type="text" name="repo" id="repo" maxlength="100" required>
        <br><br><br>
        <label class="container"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-marked"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/><polyline points="10 2 10 10 13 7 16 10 16 2"/></svg> Public
            <input type="radio" checked="checked" name="visibility" value="public">
            <span class="checkmark"></span>
        </label>
        <br>
        <label class="container"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lock"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> Private
            <input type="radio" name="visibility" value="private">
            <span class="checkmark"></span>
        </label>
        <br>
        <input type="submit" class="create-button" value="Import Repository">
    </form>
    <br><br><br>
</div>
</body>
</html>