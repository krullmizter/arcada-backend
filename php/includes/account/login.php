<?php

    require '../../core/init.php';

    $username = sanitizeInput(mysqli_real_escape_string($conn, $_POST['loginUsername']));
    $password = sanitizeInput(mysqli_real_escape_string($conn, $_POST['loginPass']));
    
    if (isset($username) || isset($password) && $_SERVER['REQUEST_METHOD'] == 'POST') {

        if(empty($username)) {
            echo 'Email is required';

        } else if(empty($password)) {
            echo 'Password is required';

        } else if($stmt = $conn->prepare('SELECT id, password, role, registered, latest, logins FROM users WHERE username = ?')) {
            
            $stmt -> bind_param('s', $username);
	        $stmt -> execute();
            $stmt -> store_result();

            if ($stmt -> num_rows > 0) {
                $stmt -> bind_result($id, $hash, $role, $registered, $latest, $logins);
                $stmt -> fetch();

                if (password_verify($password, $hash)) {

                    $conn->query("UPDATE users SET latest = now(), logins = logins + 1 WHERE id = '$id'"); # Updates latest login and login counter
                    
                    $_SESSION['loggedin']   = TRUE;
                    $_SESSION['username']   = $username;
                    $_SESSION['id']         = $id;
                    $_SESSION['registered'] = $registered;
                    $_SESSION['latest']     = $latest;
                    $_SESSION['logins']     = $logins;
                    $_SESSION['role']       = $role;

                    header('location: ../../../pages/profile');

                } else {
                    echo 'Incorrect password';
                }

            } else {
                echo 'No login details with that username';
            }

        } else {
            echo 'Invalid credentials';
        }

    } else {
        echo "Something bad is going on. Can't send via POST";
    }

    $conn->close();
?>