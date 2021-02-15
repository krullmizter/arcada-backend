<?php

    require '../../core/init.php';

    $comment = sanitizeInput(mysqli_real_escape_string($conn, $_POST['comment']));
    $postID  = $_POST['post__commentHidden'];
    $user    = $_SESSION['username'];
    $sql     = 'SELECT * FROM comments';
    $result  = $conn->query($sql);

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        if(empty($comment)) {
            echo 'A comment is needed';

        } else { 
            $stmt = $conn->prepare('INSERT INTO comments (postID, commentAuthor, comment) VALUES (?, ?, ?)');
            $stmt -> bind_param('iss', $postID, $user, $comment);
            $stmt -> execute();

            header("location: ../../../pages/frontpage");
        }   

    } else {
        echo "Something bad is going on. Can't send via POST";
    }

    $conn->close();
?>