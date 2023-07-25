<?php

require "dbconn.php";

$url = $_SERVER['REQUEST_URI'];
$path = parse_url($url, PHP_URL_PATH);
$pathParts = explode('/', ltrim($path, '/'));
$parsed_url = [];


foreach ($pathParts as $index => $part) {
    $parsed_url[$index] = $part;
}

if (empty($parsed_url[1])){
    require "404.php";
} elseif ($parsed_url[1] == "signup"){

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $conf = $_POST['conf_password'];
    $name = $_POST['name'];
    $signup_ip = $_SERVER['REMOTE_ADDR'];

    if (empty(trim($username)) || empty(trim($email)) || empty(trim($password)) || empty(trim($conf)) || empty(trim($name))) {
        
        // header('Location: /signup/error/empty');

        if (empty(trim($username))) {
            header('Location: /signup/error/empty/username');
        } elseif (empty(trim($email))){
            header('Location: /signup/error/empty/email');
        } elseif (empty(trim($password))){
            header('Location: /signup/error/empty/password');
        } else {
            header('Location: /signup/error/empty/name');
        }

    } elseif ($password !== $conf) {
        header('Location: /signup/error/password');
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($username))){
        header('Location: /signup/error/username/invalid');
    } else {
        $querry = "SELECT `id` FROM `users` WHERE `username` = ?";

        if ($stmt = mysqli_prepare($conn, $querry)){
            mysqli_stmt_bind_param($stmt, "s", $username);

            if (mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    header("Location: /signup/error/username/taken");
		            die();
                }
            } else {
                echo "500 Internal Server Error";
            }
        }
    }

    mysqli_stmt_close($stmt);

    $querry = "INSERT INTO `users` (`username`, `password`, `name`, `email`, `signup_ip`, `current_ip`) VALUES (?, ?, ?, ?, ?, ?)";

    if($stmt = mysqli_prepare($conn, $querry)){

        $clientIP = $_SERVER['REMOTE_ADDR'];
        

        mysqli_stmt_bind_param($stmt, "ssssss", $username, $password_hash, $name, $email, $signup_ip, $clientIP);

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        if(mysqli_stmt_execute($stmt)){
            header("Location: /login");
        } else{
            echo "500 Internal Server Error";
            die();
        }    
        mysqli_stmt_close($stmt);
    }



    mysqli_close($conn);

} elseif ($parsed_url[1] == "login"){
    $password = $_POST['password'];
    $username = $_POST['username'];

    if (empty(trim($username)) || empty(trim($password))){
        header("Location: /login/error");
    }

    $querry = "SELECT id, username, password FROM users WHERE username = ?";

    if($stmt = mysqli_prepare($conn, $querry)){
        mysqli_stmt_bind_param($stmt, "s", $username);

        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1){
                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                if(mysqli_stmt_fetch($stmt)){
                    if(password_verify($password, $hashed_password)){
                        session_start();
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;

                        header("Location: /");
                    } else {
                        header("Location: /login/error");
                    }
                } else {
                    header("Location: /login/error");
                }
            } else {
                header("Location: /login/error");
            }
        } else {
            header("Location: /login/error");
        }
    } else {
        header("Location: /login/error");
    }

} else {
    require "404.php";
}