<?php

    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $clientIP = $_SERVER['REMOTE_ADDR'];
    // echo "$clientIP";
    $bannedIPFile = 'sus_ip.txt';
    $bannedIPs = file($bannedIPFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (in_array($clientIP, $bannedIPs)) {
        require 'suspended.php';
        exit();
    }

    require "dbconn.php";

    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){

        // check if user is suspended/terminated
        
        $username = $_SESSION["username"];

        $querry = "SELECT `suspended`, `terminated` FROM users WHERE username = ?";

        $stmt = $conn->prepare($querry);

        $stmt->bind_param("s", $username);

        $stmt->execute();

        $stmt->bind_result($suspended, $terminated);

        $stmt->fetch();

        if ($terminated == 1) {
            require 'terminated.php';
            exit();
        } elseif ($suspended == 1) {
            require 'suspended.php';
            exit();
        }

        $stmt->close();


        // update current ip in database        

        $querry = "UPDATE `users` SET `current_ip` = ? WHERE `username` = ?";

        $stmt = $conn->prepare($querry);
        
        $stmt->bind_param("ss", $clientIP, $username);
        
        $stmt->execute();
        


        $stmt->close();
        
        $conn->close();
    }



