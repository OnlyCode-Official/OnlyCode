<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Wix Madefor Text">
    <title>IP Blocked · OnlyGit</title>
    <style>
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
            text-align: center;
        }

        .text {
            border-style: solid;
            border-radius: 10px;
            border-color: rgba(116, 114, 114, 0.217);
            padding: 1.5rem;
            font-size: 23px;
            width: 30rem;
            text-align: left;
        }

    </style>
</head>
<body>
<div class='center'>
    <img src="https://OnlyGit-official.github.io/icons/small-logo.png" alt="logo" height="100" width="100" draggable="false">
    <h1>IP Blocked</h1>

    <?php
        $clientIP = $_SERVER['REMOTE_ADDR'];
    ?>

    <p class='text'>Your IP <?php echo "$clientIP"; ?> has been flagged as suspicious and has been blocked from accessing OnlyGit and it's services. Sorry for the inconvenience.</p><br><br><br><br>
</div>
</body>
</html>