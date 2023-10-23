<?php
if (isset($_S0.ESSION['loggedin'])){
    $username = $_SESSION['username'];
    echo "
        <!DOCTYPE html>
        <html lang='en'>
            <head>
                <title>OnlyGit</title>
            </head>
        </html>
        <body>
            <h2>Your Repositories:</h2>
    ";

    foreach (scandir("/show/$username") as $repo) {
        if ($repo == "." || $repo == ".."){
            continue;
        }
        echo "$repo<br>";
    }

} else {
    echo "This is the homepage for OnlyGit. OnlyGit is currently under development and might take some time. (and no, im not selling you this domain)";
}

?>