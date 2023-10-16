<?php

$null = "";

echo "<script>
    function redirect(location){
        window.location.replace(location)
    }
</script>";

/**
 * @var $conn
 * @var $suspended
 * @var $terminated
 * @var $admin
 * @var $id
 * @var $stmt
 */

require "dbconn.php";

$url = $_SERVER['REQUEST_URI'];
$path = parse_url($url, PHP_URL_PATH);
$pathParts = explode('/', ltrim($path, '/'));
$parsed_url = [];


foreach ($pathParts as $index => $part) {
    $parsed_url[$index] = $part;
}

if (empty($parsed_url[1])) {
    require "404.php";
} elseif ($parsed_url[1] == "signup") {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $conf = $_POST['conf_password'];
    $signup_ip = $_SERVER['REMOTE_ADDR'];

    if (empty(trim($username)) || empty(trim($email)) || empty(trim($password)) || empty(trim($conf))) {
        
        // header('Location: /signup/error/empty');

        if (empty(trim($username))) {
            header('Location: /signup/error/empty/username');
        } elseif (empty(trim($email))){
            header('Location: /signup/error/empty/email');
        } elseif (empty(trim($password))){
            header('Location: /signup/error/empty/password');
        }

    } elseif ($password !== $conf) {
        header('Location: /signup/error/password');
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($username))){
        header('Location: /signup/error/username/invalid');
    } else {
        $query = "SELECT `id` FROM `users` WHERE `username` = ?";

        if ($stmt = mysqli_prepare($conn, $query)){
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

    $query = "INSERT INTO `users` (`username`, `password`, `email`, `signup_ip`, `current_ip`) VALUES (?, ?, ?, ?, ?)";

    if($stmt = mysqli_prepare($conn, $query)){

        $clientIP = $_SERVER['REMOTE_ADDR'];
        

        mysqli_stmt_bind_param($stmt, "sssss", $username, $password_hash, $email, $signup_ip, $clientIP);

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        if(mysqli_stmt_execute($stmt)){
            $dir = "/git/$username";
            if (mkdir($dir, 0755, true)) {
                $useless = "useless";
            } else {
                die("Internal server error 500");
            }
            $dir = "/show/$username";
            if (mkdir($dir, 0755, true)) {
                $useless = "useless";
            } else {
                die("Internal server error 500");
            }
            shell_exec("sudo useradd -m -d /git/$username -p '*' -s /usr/sbin/nologin $username");
            shell_exec("sudo chown -R $username /git/$username");
            header("Location: /login");
        } else{
            echo "500 Internal Server Error";
            die();
        }    
        mysqli_stmt_close($stmt);
    }

    mysqli_close($conn);

} elseif ($parsed_url[1] == "login") {
    $password = $_POST['password'];
    $username = $_POST['username'];

    if (empty(trim($username)) || empty(trim($password))){
        header("Location: /login/error");
    }

    $query = "SELECT id, username, password FROM users WHERE username = ?";

    if($stmt = mysqli_prepare($conn, $query)){
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

} elseif ($parsed_url[1] == "suspend") {
    if (isset($_SESSION["loggedin"])) {

        if (isset($parsed_url[2])) {
            $user = $parsed_url[2];
        } else {
            echo "User is required";
            exit;
        }



        $query = "SELECT `suspended`, `terminated` FROM users WHERE username = ?";

        $stmt = $conn->prepare($query);

        $stmt->bind_param("s", $user);

        $stmt->execute();

        $stmt->bind_result($suspended, $terminated);

        $stmt->fetch();
        
        if (!isset($suspended)) {
            echo "User does not exist";
            exit();
        } elseif ($suspended == 1) {
            echo "User is already suspended";
            exit();
        } elseif ($terminated == 1) {
            echo "User is terminated";
            exit();
        }

        $stmt->close();

        $username = $_SESSION["username"];

        if ($user == $username) {
            echo "You cannot suspend yourself";
            exit();
        }

        $query = "SELECT `id`, `admin` FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($id, $admin);
        $stmt->fetch();
        
        if (!$admin && $id != 1) {
            echo "Permission Denied";
            exit();
        }

        $stmt->close();

        $query = "UPDATE `users` SET `suspended` = ? WHERE `username` = ?";

        $stmt = $conn->prepare($query);

        $value = 1;

        $stmt->bind_param("ss", $value, $user);

        $stmt->execute();

        $stmt->close();

        header("Location: /admin/users/manage/$user");

    } else {
        echo "Permission Denied";
        exit();
    }
} elseif ($parsed_url[1] == "unsuspend") {
    if (isset($_SESSION["loggedin"]) && isset($_SESSION["loggedin"]) === true) {

        if (isset($parsed_url[2])) {
            $user = $parsed_url[2];
        } else {
            echo "User is required";
            exit;
        }


        $query = "SELECT `suspended`, `terminated` FROM users WHERE username = ?";

        $stmt = $conn->prepare($query);

        $stmt->bind_param("s", $user);

        $stmt->execute();

        $stmt->bind_result($suspended, $terminated);

        $stmt->fetch();

        if (!isset($suspended)) {
            echo "User does not exist";
            exit();
        } elseif ($suspended == 0) {
            echo "User is not suspended";
            exit();
        } elseif ($terminated == 1) {
            echo "User is terminated";
            exit();
        }

        $stmt->close();

        $username = $_SESSION["username"];

        $query = "SELECT `id`, `admin` FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($id, $admin);
        $stmt->fetch();

        if (!$admin && $id != 1) {
            echo "Permission Denied";
            exit();
        }

        $stmt->close();

        $query = "UPDATE `users` SET `suspended` = ? WHERE `username` = ?";

        $stmt = $conn->prepare($query);

        $value = 0;

        $stmt->bind_param("ss", $value, $user);

        $stmt->execute();

        $stmt->close();

        header("Location: /admin/users/manage/$user");

    } else {
        echo "Permission Denied";
        exit();
    }
} elseif ($parsed_url[1] == "terminate") {
    if (isset($_SESSION["loggedin"]) && isset($_SESSION["loggedin"]) === true) {

        if (isset($parsed_url[2])) {
            $user = $parsed_url[2];
        } else {
            echo "User is required";
            exit;
        }


        $query = "SELECT `terminated` FROM users WHERE username = ?";

        $stmt = $conn->prepare($query);

        $stmt->bind_param("s", $user);

        $stmt->execute();

        $stmt->bind_result($terminated);

        $stmt->fetch();

        if (!isset($terminated)) {
            echo "User does not exist";
            exit();
        } elseif ($terminated == 1) {
            echo "User is already terminated";
            exit();
        }

        $stmt->close();

        $username = $_SESSION["username"];

        $query = "SELECT `id`, `admin` FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($id, $admin);
        $stmt->fetch();

        if (!$admin && $id != 1) {
            echo "Permission Denied";
            exit();
        } elseif ($user == $username) {
            echo "You cannot terminate yourself";
            exit();
        }

        $stmt->close();

        $query = "UPDATE `users` SET `suspended` = ?, `terminated` = ? WHERE `username` = ?";

        $stmt = $conn->prepare($query);

        $value1 = 0;

        $value2 = 1;

        $stmt->bind_param("sss", $value1, $value2, $user);

        $stmt->execute();

        $stmt->close();

        header("Location: /admin/users/manage/$user");

    } else {
        echo "Permission Denied";
        exit();
    }
} elseif ($parsed_url[1] == "promote") {
    if (isset($_SESSION["loggedin"]) && isset($_SESSION["loggedin"]) === true) {

        if (isset($parsed_url[2])) {
            $user = $parsed_url[2];
        } else {
            echo "User is required";
            exit;
        }


        $query = "SELECT `suspended`, `terminated`, `admin` FROM users WHERE username = ?";

        $stmt = $conn->prepare($query);

        $stmt->bind_param("s", $user);

        $stmt->execute();

        $stmt->bind_result($suspended, $terminated, $admin);

        $stmt->fetch();

        if (!isset($admin)) {
            echo "User does not exist";
            exit();
        } elseif ($admin == 1) {
            echo "User is already an admin";
            exit();
        } elseif ($suspended == 1) {
            echo "User is suspended";
            exit();
        } elseif ($terminated == 1) {
            echo "User is terminated";
            exit();
        }

        $stmt->close();

        $username = $_SESSION["username"];

        $query = "SELECT `id`, `admin` FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($id, $admin);
        $stmt->fetch();

        if (!$admin && $id != 1) {
            echo "Permission Denied";
            exit();
        }

        $stmt->close();

        $query = "UPDATE `users` SET `admin` = ? WHERE `username` = ?";

        $stmt = $conn->prepare($query);

        $value = 1;

        $stmt->bind_param("ss", $value, $user);

        $stmt->execute();

        $stmt->close();

        header("Location: /admin/users/manage/$user");

    } else {
        echo "Permission Denied";
        exit();
    }

} elseif ($parsed_url[1] == "promote") {
    if (isset($_SESSION["loggedin"]) && isset($_SESSION["loggedin"]) === true) {

        if (isset($parsed_url[2])) {
            $user = $parsed_url[2];
        } else {
            echo "User is required";
            exit;
        }


        $query = "SELECT `terminated` FROM users WHERE username = ?";

        $stmt = $conn->prepare($query);

        $stmt->bind_param("s", $user);

        $stmt->execute();

        $stmt->bind_result($terminated);

        $stmt->fetch();

        if (!isset($terminated)) {
            echo "User does not exist";
            exit();
        } elseif ($terminated == 1) {
            echo "User is already terminated";
            exit();
        }

        $stmt->close();

        $username = $_SESSION["username"];

        $query = "SELECT `id`, `admin` FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($id, $admin);
        $stmt->fetch();

        if (!$admin && $id != 1) {
            echo "Permission Denied";
            exit();
        }
    
        $stmt->close();

        $query = "UPDATE `users` SET `suspended` = ?, `terminated` = ? WHERE `username` = ?";

        $stmt = $conn->prepare($query);

        $value1 = 0;

        $value2 = 1;
        
        $stmt->bind_param("sss", $value1, $value2, $user);
        
        $stmt->execute();

        $stmt->close();

        header("Location: /admin/users/manage/$user");

    } else {
        echo "Permission Denied";
        exit();
    }
} elseif ($parsed_url[1] == "demote") {
    if (isset($_SESSION["loggedin"]) && isset($_SESSION["loggedin"]) === true) {

        if (isset($parsed_url[2])) {
            $user = $parsed_url[2];
        } else {
            echo "User is required";
            exit;
        }


        $query = "SELECT `suspended`, `terminated`, `admin` FROM users WHERE username = ?";

        $stmt = $conn->prepare($query);

        $stmt->bind_param("s", $user);

        $stmt->execute();

        $stmt->bind_result($suspended, $terminated, $admin);

        $stmt->fetch();
        
        if (!isset($admin)) {
            echo "User does not exist";
            exit();
        } elseif ($admin == 0) {
            echo "User is not admin";
            exit();
        } elseif ($terminated == 1) {
            echo "User is terminated";
            exit();
        }

        $stmt->close();

        $username = $_SESSION["username"];

        $query = "SELECT `id`, `admin` FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($id, $admin);
        $stmt->fetch();
        
        if (!$admin && $id != 1) {
            echo "Permission Denied";
            exit();
        }
    
        $stmt->close();

        $query = "UPDATE `users` SET `admin` = ? WHERE `username` = ?";

        $stmt = $conn->prepare($query);

        $value = 0;
        
        $stmt->bind_param("ss", $value, $user);
        
        $stmt->execute();

        $stmt->close();

        header("Location: /admin/users/manage/$user");

    } else {
        echo "Permission Denied";
        exit();
    }

} elseif ($parsed_url[1] == "takeover") {
    if (isset($parsed_url[2])) {
        $user = $parsed_url[2];
    } else {
        echo "User is required";
        exit;
    }

    $username = $_SESSION["username"];

    $query = "SELECT `admin` FROM users WHERE username = ?";

    $stmt = $conn->prepare($query);

    $stmt->bind_param("s", $username);

    $stmt->execute();

    $stmt->bind_result($admin);

    $stmt->fetch();

    $stmt->close();

    if (!$admin){
        echo "Permission Denied";
    }

    $query = "SELECT `id` FROM users WHERE username = ?";

    $stmt = $conn->prepare($query);

    $stmt->bind_param("s", $user);

    $stmt->execute();

    $stmt->bind_result($id);
             
    $stmt->fetch();

    $stmt->close();

    if (!isset($id)) {
        echo "User does not exist";
        exit();
    }

    $_SESSION["id"] = $id;
    $_SESSION["username"] = $user;
    $_SESSION["old_username"] = $username;
    $_SESSION["taken_over"] = true;

} elseif ($parsed_url[1] == "create") {
   if (empty(trim($_POST['repo']))) {
       header("Location: /create/error/empty");
       die();
   } elseif (empty($_POST['owner'])) {
       echo "<script>redirect('https://www.youtube.com/watch?v=a3Z7zEc7AXQ')</script>";
       die("Dumbo dumb dumb");
   } elseif (empty($_POST['visibility'])) {
       echo "<script>redirect('https://www.youtube.com/watch?v=a3Z7zEc7AXQ')</script>";
       die("Dumbo dumb dumb");
   }

   $name = $_POST['repo'];
   if (!empty($_POST['description'])) {
       $description = $_POST['description'];
   }

   $visibility = $_POST['visibility'];
   $owner = $_POST['owner'];

   $query = "SELECT `id` FROM `repos` WHERE `name` = ? AND `owner` = ?";
   $stmt = mysqli_prepare($conn, $query);
   mysqli_stmt_bind_param($stmt, "ss", $name, $owner);
   mysqli_stmt_execute($stmt);
   mysqli_stmt_store_result($stmt);

   if(mysqli_stmt_num_rows($stmt) == 1){
       header("Location: /create/error/taken");
       die();
   }

   if (isset($description)) {
       $query = "INSERT INTO `repos` (`name`, `owner`, `visibility`, `description`, `collaborators`) VALUES (?, ?, ?, ?, ?)";
       $stmt = mysqli_prepare($conn, $query);
       mysqli_stmt_bind_param($stmt, "sssss", $name, $owner, $visibility, $description, $null);
   } else {
       $query = "INSERT INTO `repos` (`name`, `owner`, `visibility`, `collaborators`) VALUES (?, ?, ?, ?)";
       $stmt = mysqli_prepare($conn, $query);
       mysqli_stmt_bind_param($stmt, "ssss", $name, $owner, $visibility, $null);
   }

   mysqli_stmt_execute($stmt);
   mysqli_stmt_close($stmt);
   
   $repos = 0;

   $query = "SELECT `repo` FROM users WHERE username = ?";
   $stmt = $conn->prepare($query);
   $stmt->bind_param("s", $owner);
   $stmt->execute();
   $stmt->bind_result($repos);
   $stmt->fetch();
   mysqli_stmt_close($stmt);

   $new_repos = $repos + 1;
   $query = "UPDATE `users` SET `repo` = ? WHERE username = ?";
   $stmt = $conn->prepare($query);
   $stmt->bind_param("ss", $new_repos, $owner);
   $stmt->execute();
   mysqli_stmt_close($stmt);

   $dir = "/git/$owner/$name";
   shell_exec("sudo mkdir $dir");
   shell_exec("sudo chmod 777 $dir");

   shell_exec("git init --bare /git/$owner/$name");
   shell_exec("cd /show/$owner && sudo git clone ssh://root@0.0.0.0:/git/$owner/$name");
   header("Location: /");
} elseif ($parsed_url[1] == "import") {
    if (empty(trim($_POST['url']))) {
        header("Location: /import/error/empty");
        die();
    } elseif (empty($_POST['owner'])) {
        echo "<script>redirect('https://www.youtube.com/watch?v=a3Z7zEc7AXQ')</script>";
        die("Dumbo dumb dumb");
    } elseif (empty($_POST['visibility'])) {
        echo "<script>redirect('https://www.youtube.com/watch?v=a3Z7zEc7AXQ')</script>";
        die("Dumbo dumb dumb");
    } elseif (empty(trim($_POST['repo']))) {
        echo "<script>redirect('https://www.youtube.com/watch?v=a3Z7zEc7AXQ')</script>";
        die("Dumbo dumb dumb");
    }

    $name = $_POST['repo'];


    $giturl = $_POST['url'];
    $visibility = $_POST['visibility'];
    $owner = $_POST['owner'];

    $query = "SELECT `id` FROM `repos` WHERE `name` = ? AND `owner` = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $name, $owner);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if(mysqli_stmt_num_rows($stmt) == 1){
        header("Location: /import/error/taken");
        die();
    }

    shell_exec("sudo mkdir -p /tmp/import/$owner");

    $git = "cd /tmp/import/$owner && sudo git clone --bare $giturl";
    $useless = array();
    $failed = 0;

    exec($git, $output, $failed);

    if ($failed !== 0) {
       header("Location: /import/error/failed");
       die();
    }

    if (isset($name)){
        shell_exec("cd /tmp/import/$owner && sudo mv * /git/$owner/$name");
    }

    shell_exec("sudo rm -rf /tmp/import/$owner/*");
    shell_exec("cd /show/$owner && sudo git clone ssh://root@0.0.0.0:/git/$owner/$name");
    header("Location: /");

    $query = "INSERT INTO `repos` (`name`, `owner`, `visibility`, `collaborators`) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $name, $owner, $visibility, $null);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

} else {
    require "404.php";
}