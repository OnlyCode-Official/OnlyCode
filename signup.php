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

            input[type="text"] {height: 40px;width:900px;background-color:#282960;border-radius:1rem;border: 2px solid rgba(255, 255, 255, 0.747);color:white;font-family: 'JetBrains Mono';font-size: 23px;padding-left:10px;}

            input[type="password"] {height: 40px;width:900px;background-color:#282960;border-radius:1rem;border: 2px solid rgba(255, 255, 255, 0.747);color:white;font-family: 'JetBrains Mono';font-size: 23px;padding-left:10px;}

            input[type="email"] {height: 40px;width:900px;background-color:#282960;border-radius:1rem;border: 2px solid rgba(255, 255, 255, 0.747);color:white;font-family: 'JetBrains Mono';font-size: 23px;padding-left:10px;}


        </style>
    </head>
    <body>
        <div class='center'>
            <div class='signup-text'>
                <img src="https://onlycode-official.github.io/icons/small-logo.png" alt="logo" height="100" width="100" draggable="false"></img>
                <h3>Welcome to OnlyCode!</h3>
                <h4>We'll get you started in no time!</h4>
            </div>

            <br>
        
        <form action='/api/signup' method='post'>
            <label>Enter your email:</label><br>
            <input type='email' name='email' size='100'>
            <br><br>
            <label>Create a password:</label><br>
            <input type='password' name='password' size='100'>
            <br><br>
            <label>Confirm your password:</label><br>
            <input type='password' name='conf_password' size='100'>
            <br><br>
            <label>Enter a username:</label><br>
            <input type='text' name='username' size='100'>
            <br><br>
            <label>Enter your full name:</label><br>
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