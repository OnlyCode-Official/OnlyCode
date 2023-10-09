<?php

/**
 * @var $conn
 * @var $admin
 * @var $id
 * @var $username
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require "dbconn.php";

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    $username = $_SESSION["username"];

    $querry = "SELECT `id`, `admin` FROM users WHERE username = ?";
    $stmt = $conn->prepare($querry);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $admin);
    $stmt->fetch();

    if ($admin != true && $id != 1) {
        require '404.php';
        exit();
    }

    $stmt->close();
} elseif (!isset($_SESSION["loggedin"])){
    require '404.php';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin · OnlyGit</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Wix Madefor Text">
    <script>
        function redirect(location){
            window.location.replace(locationn)
        }

        function openTools(){
            modal.style.display = "block";
        }

        function closeTools(){
            modal.style.display = "none";
            redirect("/admin/users");
        }

    </script>
    <style>

        body {
            font-family: "Wix Madefor Text";
            background-color: #06081f;
        }

        .sidenav {
            background: rgb(6, 20, 53);
            position: fixed;
            top: 0;
            left: 0;
            width: 300px;
            height: 100%;
            padding: 20px 0;
            color: white;
            text-align: center;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .top {
            padding-top: 2rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .toptext {
            white-space: nowrap;
        }

        .svg,
        .text-a {
            vertical-align: middle;
            display: inline-block;
            text-decoration: none;
        }

        a {
            text-decoration: none;
            color: white;
        }

        .sidenav-button:hover,
        .sidenav-button:focus,
        .sidenav-button:active {
            background-color: #3bd0e1;
            border-radius: 10px;
        }

        .sidenav-button {
            padding: 10px;
            text-align: left;
            padding-left: 60px;
        }

        .tools {
            margin-left: 320px !important;
            margin-right: 20px;
            color: white;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .square-button {
            display: inline-block;
            width: 150px;
            height: 40px;
            border-radius: 5px;
            background-color: #3bd0e1;
            padding: 5px;
            box-sizing: border-box;
            border: none; /* Remove the border */
            color: white;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px; 
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            position: relative;
            background-color: #fefefe;
            margin: auto;
            padding: 0;
            border: 1px solid #3bd0e1;
            width: 80%;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
            -webkit-animation-name: animatetop;
            -webkit-animation-duration: 0.4s;
            animation-name: animatetop;
            animation-duration: 0.4s
        }

        .user_action_button {
            width: 100%;
            max-width: 150px;
            background-color: #3bd0e1;
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

        @-webkit-keyframes animatetop {
            from {top:-300px; opacity:0} 
            to {top:0; opacity:1}
        }

        @keyframes animatetop {
            from {top:-300px; opacity:0}
            to {top:0; opacity:1}
        }

        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: white;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-header {
            padding: 2px 16px;
            background: rgb(6, 20, 53);
            color: white;
        }

        .modal-body {padding: 2px 16px;color: white;background-color: #06081f;}

        /*
            .modal-footer {
                padding: 2px 16px;
                background: rgb(6, 20, 53);
                color: white;
            }
         */

        .user-info,
        .user-stats,
        .user-actions {
            margin-left: 20px;
            padding-top: 5px;
            padding-bottom: 5px;
        }

    </style>
</head>
<body>
    <div class="sidenav">
        <nav>
            <div class='top'>
                <img src='https://OnlyGit-official.github.io/icons/small-logo.png' alt='logo' width='100' height='100'>
                <h3 class="toptext">Site Administration</h3>
            </div>
            <div class='sidenav-button'>
                <span class='svg'>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                </span>
                <span class='text-a'>
                    <a href='/admin/'> Overview</a>
                </span>
            </div>
            <div class='sidenav-button'>
                <span class='svg'>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </span>
                <span class='text-a'>
                    <a href='/admin/users'> Users</a>
                </span>
            </div>   
        </nav>
    </div>

    <div class='tools'>

    <?php
    
        $url = $_SERVER['REQUEST_URI'];
        $path = parse_url($url, PHP_URL_PATH);
        $pathParts = explode('/', ltrim($path, '/'));
        $parsed_url = [];
        
        
        foreach ($pathParts as $index => $part) {
            $parsed_url[$index] = $part;
        }


        if (!isset($parsed_url[1])){
            echo "

            ";
        } elseif ($parsed_url[1] == "users") {

            echo "
            
            <h3>Users</h3>
            <br>


            ";

            $query = "SELECT * FROM `users`";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $rows = $stmt->get_result();

            // Table goes brrrrrr
            echo '<table>';
            echo '<tr>';
            echo '<th><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-credit-card"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg></span> ID</th>';
            echo '<th><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-2"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 1 0-16 0"/></svg></span> Username</th>';
            echo '<th><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-marked"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/><polyline points="10 2 10 10 13 7 16 10 16 2"/></svg></span> Repos</th>';
            echo '<th><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg></span> Email</th>';
            echo '<th><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-crown"><path d="m2 4 3 12h14l3-12-6 7-4-7-4 7-6-7zm3 16h14"/></svg></span> Admin</th>';
            echo '<th><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-gavel"><path d="m14 13-7.5 7.5c-.83.83-2.17.83-3 0 0 0 0 0 0 0a2.12 2.12 0 0 1 0-3L11 10"/><path d="m16 16 6-6"/><path d="m8 8 6-6"/><path d="m9 7 8 8"/><path d="m21 11-8-8"/></svg></span> Suspended</th>';
            echo '<th><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg></span> Terminated</th>';
            echo '<th><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-wrench"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg></span> Manage User</th>';
            echo '</tr>';

            // Contents of table goes brrr

            foreach ($rows as $row) {
                $row_username = $row['username'];
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['username'] . '</td>';
                echo '<td>' . $row['repo'] . '</td>';
                echo '<td>' . $row['email'] . '</td>';
                echo '<td>' . $row['admin'] . '</td>';
                echo '<td>' . $row['suspended'] . '</td>';
                echo '<td>' . $row['terminated'] . '</td>';
                echo "<td style='text-align: left;'>
                    <a href='/admin/users/manage/$row_username'>
                        <button class='square-button'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-wrench'><path d='M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z'/></svg>
                        </button>
                    </a>
                </td>";

                echo '</tr>';
            }
            
            echo '</table>';

            if (isset($parsed_url[2]) && $parsed_url[2] == "manage" && isset($parsed_url[3])) {
                $username = $parsed_url[3];

                if ($username == ""){
                    echo "
                        <script>
                            redirect('/admin/users')
                        </script>
                    ";
                }

                $querry = "SELECT `id` FROM `users` WHERE `username` = ?";

                if ($stmt = mysqli_prepare($conn, $querry)){
                    mysqli_stmt_bind_param($stmt, "s", $username);
        
                    if (mysqli_stmt_execute($stmt)){
                        mysqli_stmt_store_result($stmt);
                        
                        if(mysqli_stmt_num_rows($stmt) !== 1){
                            echo "
                                <script>
                                    redirect('/admin/users');
                                </script>
                            ";
                        }
                    } else {
                        echo "500 Internal Server Error";
                    }
                }

                $query = "SELECT * FROM `users` WHERE `username` = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('s', $username);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_all(MYSQLI_ASSOC);
                $stmt->close();

                foreach ($row as $contents) {
                    $id = $contents['id'];
                    $email = $contents['email'];
                    $suspended = $contents['suspended'];
                    $terminated = $contents['terminated'];
                    $admin = $contents['admin'];
                    $repo = $contents['repo'];
                    $pr = $contents['pr'];
                    $issue = $contents['issue'];
                    $signup_ip = $contents['signup_ip'];
                    $ip = $contents['current_ip'];
                }

                if ($admin == 1) {
                    $admin = "Yes";
                    $action2 = "Demote user";
                    $task2 = "demote";
                } else {
                    $admin = "No";
                    $action2 = "Promote user";
                    $task2 = "promote";
                }

                if ($suspended == 1){
                    $suspended = "Yes";
                    $action1 = "Unsuspend user";
                    $task1 = "unsuspend";
                } else {
                    $suspended = "No";
                    $action1 = "Suspend user";
                    $task1 = "suspend";
                }

                if ($terminated == 1){
                    $terminated = "Yes";
                } else {
                    $terminated = "No";
                    $action3 = "Terminate user";
                    $task3 = "terminate";
                }

                

                echo "
                    <div class='modal' id='ToolsModal'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <span class='close' onclick='closeTools();'>&times;</span>
                                <h2>$username</h2>
                                
                            </div>
                            <div class='modal-body'>
                                <h4>User information:</h4>
                                <div class='user-info'>
                                    <span class='svg'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-credit-card'><rect width='20' height='14' x='2' y='5' rx='2'/><line x1='2' x2='22' y1='10' y2='10'/></svg></span> User ID: $id
                                    <br>
                                    <span class='svg'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-mail'><rect width='20' height='16' x='2' y='4' rx='2'/><path d='m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7'/></svg></span> Email: $email
                                    <br>
                                    <span class='svg'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-crown'><path d='m2 4 3 12h14l3-12-6 7-4-7-4 7-6-7zm3 16h14'/></svg></span> Admin: $admin
                                    <br>
                                    <span class='svg'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-gavel'><path d='m14 13-7.5 7.5c-.83.83-2.17.83-3 0 0 0 0 0 0 0a2.12 2.12 0 0 1 0-3L11 10'/><path d='m16 16 6-6'/><path d='m8 8 6-6'/><path d='m9 7 8 8'/><path d='m21 11-8-8'/></svg></span> Suspended: $suspended
                                    <br>
                                    <span class='svg'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-trash-2'><path d='M3 6h18'/><path d='M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6'/><path d='M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2'/><line x1='10' x2='10' y1='11' y2='17'/><line x1='14' x2='14' y1='11' y2='17'/></svg></span> Terminated: $terminated
                                </div>
                                <h4>User statistics:</h4>
                                <div class='user-stats'>
                                    <span class='svg'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-book-marked'><path d='M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20'/><polyline points='10 2 10 10 13 7 16 10 16 2'/></svg></span> Repos: $repo
                                    <br>
                                    <span class='svg'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-circle-dot'><circle cx='12' cy='12' r='10'/><circle cx='12' cy='12' r='1'/></svg></span> Issues: $issue
                                    <br>
                                    <span class='svg'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-git-pull-request'><circle cx='18' cy='18' r='3'/><circle cx='6' cy='6' r='3'/><path d='M13 6h3a2 2 0 0 1 2 2v7'/><line x1='6' x2='6' y1='9' y2='21'/></svg></span> Pull Requests: $pr
                                </div>";
                                if ($terminated == "No"){
                                    echo "
                                    <h4>Danger Zone:</h4>
                                    <div class='user-actions'>
                                        <a href='/api/$task1/$username' class='user_action_button'>$action1</a>
                                        <br>
                                        <a href='/api/$task2/$username' class='user_action_button'>$action2</a>
                                        <br>
                                        <a href='/api/$task3/$username' class='user_action_button'>$action3</a>
                                        <br>
                                    </div>
                                    ";
                                } else {
                                    echo "
                                        <h4>Danger Zone:</h4>
                                        <h5>User settings is disabled because the user is terminated.</h5>
                                    ";
                                }
                                    echo "
                                <br>
                            <!--
                            </div>
                                <div class='modal-footer'>
                                <h3></h3>
                            </div>
                            -->
                        </div>
                    </div>
                ";

                echo "
                    <script>
                        var modal = document.getElementById('ToolsModal');

                        openTools();

                        window.onclick = function(event) {
                            if (event.target == modal) {
                              closeTools();
                            }
                        }

                    </script>
                
                ";

                


            } elseif (isset($parsed_url[2]) && $parsed_url[2] == "manage" && !isset($parsed_url[3])){
                echo "
                    <script>
                        redirect('/admin/users')
                    </script>
                ";
            }


        }

    ?>

    </div>
</body>
</html>

<?php

    $conn->close();

?>
