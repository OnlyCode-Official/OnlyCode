<?php

    include "dbconn.php";

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Wix Madefor Text">
        <title>Join OnlyCode · OnlyCode</title>

        <style>

            @import url("https://fonts.googleapis.com/css?family=JetBrains%20Mono");

            body {
                font-family: "Wix Madefor Text";
                background-color: #06081f;
                color: white;
            }

            .center {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }

            .signup-text {
                text-align: center;
                padding: 10px;
            }

            form {
                border-style: solid;
                border-radius: 10px;
                border-color: rgba(116, 114, 114, 0.217);
                margin-left: 20px;
                margin-right: 20px;
                padding: 40px;

            }

            .signup-button {
                width: 100%;
                max-width: 915px; /* Adjust the max-width value as needed */
                background-color: #3bd0e1; /* Vibrant green color */
                color: white;
                padding: 10px;
                border: none;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 10px 0;
                cursor: pointer;
                border-radius: 1rem;
            }

            input[type="text"] {height: 40px;width:900px;background-color:#282960;border-radius:1rem;border: 2px solid rgba(255, 255, 255, 0.747);color:white;font-family: 'JetBrains Mono';font-size: 23px;padding-left:10px;margin-top:10px;}

            input[type="password"] {height: 40px;width:900px;background-color:#282960;border-radius:1rem;border: 2px solid rgba(255, 255, 255, 0.747);color:white;font-family: 'JetBrains Mono';font-size: 23px;padding-left:10px;margin-top:10px;}

            input[type="email"] {height: 40px;width:900px;background-color:#282960;border-radius:1rem;border: 2px solid rgba(255, 255, 255, 0.747);color:white;font-family: 'JetBrains Mono';font-size: 23px;padding-left:10px;margin-top:10px;}

            .error {
                background-color: #f54747;
                padding: 10px;
                border-style: solid;
                border-radius: 10px;
                border-color: rgba(116, 114, 114, 0.217);
            }


        </style>
    </head>
    <body>
        <div class='center'>
            <div class='signup-text'>
                <a href="/"><img src="https://onlycode-official.github.io/icons/small-logo.png" alt="logo" height="100" width="100" draggable="false"></img></a>
                <h3>Welcome to OnlyCode!</h3>
                
                <?php
                    $url = $_SERVER['REQUEST_URI'];
                    $path = parse_url($url, PHP_URL_PATH);
                    $pathParts = explode('/', ltrim($path, '/'));
                    $parsed_url = [];
                    
                    
                    foreach ($pathParts as $index => $part) {
                        $parsed_url[$index] = $part;
                    }

                    if (!empty($parsed_url[2]) && $parsed_url[1] == "error"){
                        if ($parsed_url[2] == "empty"){
                            if (!empty($parsed_url[3]) && $parsed_url[3] == "username") {
                                echo "<h4 class='error'>Username required!</h4>";
                            } elseif (!empty($parsed_url[3]) && $parsed_url[3] == "email") {
                                echo "<h4 class='error'>Email required!</h4>";
                            } elseif (!empty($parsed_url[3]) && $parsed_url[3] == "password") {
                                echo "<h4> Password required!</h4>";
                            } elseif (!empty($parsed_url[3]) && $parsed_url[3] == "name") {
                                echo "<h4 class='error'>Please enter your full name!</h4>";
                            } else {
                                echo "<h4 class='signup-text'>We'll get you started in no time!</h4>";
                            }
                        } elseif ($parsed_url[2] == "username"){
                            if (!empty($parsed_url[3]) && $parsed_url[3] == "invalid"){
                                echo "<h4 class='error'>Username must be alphanumerical!</h4>";
                            } elseif (!empty($parsed_url[3]) && $parsed_url[3] == "taken"){
                                echo "<h4 class='error'>That username is unavaliable!</h4>";
                            } else {
                                echo "<h4 class='signup-text'>We'll get you started in no time!</h4>";
                            }
                        } elseif ($parsed_url[2] == "password") {
                            echo "<h4 class='error'>Please confirm your password!</h4>";
                        } else {
                            echo "<h4 class='signup-text'>We'll get you started in no time!</h4>";
                        }
                    } else {
                        echo "<h4 class='signup-text'>We'll get you started in no time!</h4>";
                    }
                ?>
            </div>

            <br>
        
        <form action='/api/signup' method='post'>
            <label>Email:</label><br>
            <input type='email' name='email' size='100'>
            <br><br>
            <label>Password:</label><br>
            <input type='password' name='password' size='100'>
            <br><br>
            <label>Confirm password:</label><br>
            <input type='password' name='conf_password' size='100'>
            <br><br>
            <label>Username:</label><br>
            <input type='text' name='username' size='100'>
            <br><br>
            <label>Full name:</label><br>
            <input type='text' name='name' size='100'>
            <br><br>
            <input type="submit" class="signup-button" value="Sign Up">
        </form>    
        <br><br>
    </div>


        <!--
            <script>

            </script>
        -->
    </body>
</html>
