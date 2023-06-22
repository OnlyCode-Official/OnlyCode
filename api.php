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

    if (empty(trim($username)) || empty(trim($email)) || empty(trim($password)) || empty(trim($conf)) || empty(trim($name))) {
        header('Location: /signup/error/empty');
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

    $querry = "INSERT INTO `users` (`username`, `password`, `name`) VALUES (?, ?, ?)";

    if($stmt = mysqli_prepare($conn, $querry)){
    

    mysqli_stmt_bind_param($stmt, "sss", $username, $password_hash, $name);

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    if(mysqli_stmt_execute($stmt)){
        echo "Success!";
    } else{
        echo "500 Internal Server Error";
        die();
    }    
    mysqli_stmt_close($stmt);
}



    mysqli_close($conn);

} elseif ($parsed_url[1] == "login"){
    echo "Feature not avaliable";
} else {
    require "404.php";
}