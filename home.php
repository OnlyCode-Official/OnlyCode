<?php
echo "home<br><br>";


if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    echo "lol get logged in";
}

