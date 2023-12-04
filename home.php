<?php
if (isset($_SESSION['loggedin'])){
    $username = $_SESSION['username'];
    echo "
        <!DOCTYPE html>
        <html lang='en'>
            <head>
                <title>OnlyGit</title>
                <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Wix Madefor Text'>
                <link href='https://fonts.googleapis.com/css?family=JetBrains Mono' rel='stylesheet'>
                <style>
                    body {
                        font-family: 'Wix Madefor Text';
                        background-color: #06081f;
                        height: 100%;
                        color: white;
                    }

                    .your_repo {
                        font-size: 30px;
                        padding-left: 10px;
                    }

                    .repo {
                        font-size: 25px;
                        padding: 10px;
                        margin-left: 20px;
                        color: white;
                        text-decoration: none;
                        font-family: 'JetBrains Mono';
                    }

                    .repo:hover {
                        border-style: solid;
                        border-radius: 10px;
                        border-color: rgba(102, 205, 222, 0.8);
                        display: inline-block;
                        width: 95%;
                    }

                    .a_border {
                        border-style: solid;
                        border-radius: 10px;
                        border-color: rgba(116, 114, 114, 0.217);
                        display: inline-block;
                        width: 95%;
                    }

                    .svg {
                        vertical-align: middle;
                        display: inline-block;
                        text-decoration: none;
                    }
                    
                </style>
            </head>
        </html>
        <body>
            <h2 class='your_repo'>Your Repositories:</h2><br>
        </body>
    ";

    foreach (scandir("/show/$username") as $repo) {
        if ($repo == "." || $repo == ".."){
            continue;
        }
        echo "<a class='repo a_border' href='/$username/$repo'><span class='svg'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='#ffffff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-book-marked'><path d='M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20'/><polyline points='10 2 10 10 13 7 16 10 16 2'/></svg></span> $repo</a><br><br><br>";
    }

} else {
    echo "This is the homepage for OnlyGit. OnlyGit is currently under development and might take some time. (and no, im not selling you this domain)";
}

?>