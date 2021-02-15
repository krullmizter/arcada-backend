<?php

    require '../../core/init.php';
    
    $title = sanitizeInput(mysqli_real_escape_string($conn, $_POST['postTitle']));
    $msg   = sanitizeInput(mysqli_real_escape_string($conn, $_POST['postMsg']));
    $id    = $_POST['post__editHidden'];

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $stmt = $conn->prepare("UPDATE posts SET title = ?, message = ? WHERE postID = ?");
        $stmt->bind_param('ssi', $title, $msg, $id);

        $stmt->execute();
        header('location: ../../../pages/frontpage');

    } else {
        echo "Something bad is going on. Can't send via POST";
    }

    $conn->close();
?>