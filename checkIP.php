<?php

    $clientIP = $_SERVER['REMOTE_ADDR'];
    // echo "$clientIP";
    $bannedIPFile = 'sus_ip.txt';
    $bannedIPs = file($bannedIPFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (in_array($clientIP, $bannedIPs)) {
        require 'suspended.php';
        exit();
    }
