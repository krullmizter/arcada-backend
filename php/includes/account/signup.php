<?php

    require '../../core/init.php';

    $username   = sanitizeInput(mysqli_real_escape_string($conn, $_POST['signUpUsername']));
    $name       = sanitizeInput(mysqli_real_escape_string($conn, $_POST['signupName']));
    $email      = sanitizeInput(mysqli_real_escape_string($conn, $_POST['signupEmail']));
    $password   = sanitizeInput(mysqli_real_escape_string($conn, $_POST['signupPass']));
    $passRegex  = '/^(?=.*[A-Z]).{8,}$/';
    $hash       = password_hash($password, PASSWORD_DEFAULT);
    $role       = 'user';
    $status     = 'unconfirmed';

    $stmtUser   = $conn->prepare('SELECT username FROM users WHERE username = ?'); // Check if username is registered
    $stmtUser   -> bind_param('s', $username);
    $stmtUser   -> execute();
    $resultUser = $stmtUser->get_result();
    $result     = $resultUser->fetch_assoc();

    if ((isset($username)) || (isset($name)) || (isset($email)) || (isset($password)) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {

        if (empty($username)) {
            echo 'Username is required';

        } else if(empty($name)) {
            echo 'Name is required';

        } else if(empty($email)) {
            echo 'Email is required';

        } else if(empty($password)) {
            echo 'Password is required';

        } else if(!preg_match($passRegex, $password)) {
            echo 'Password needs to be longer than 8 characters & contain a minimum of two uppercase characters.';
            
        } else if(mysqli_num_rows($result) > 0) {
            echo 'Sorry that username is already registered with us.';
            
        } else { 
            $stmt = $conn->prepare('INSERT INTO users (username, name, password, email, role, status) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt -> bind_param('ssssss', $username, $name, $hash, $email, $role, $status);
            $stmt -> execute();
    
            if(password_verify($password, $hash)) {
                header('location: ../../../pages/frontpage');
    
            } else {
                echo 'Error: '.$sql.'<br>'.$conn->error;
            }
        }   

    } else {
        echo "Something bad is going on. Can't send via POST";
    }

    $conn->close();

?>