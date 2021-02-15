<?php

require '../../core/init.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['loggedin'])) {
        $stmt = $conn->prepare('UPDATE posts set votes=votes+? WHERE postID=?');
        $stmt->bind_param('ii', $vote, $id);

        $id   = $_POST['id'];
        $vote = $_POST['vote'];

        $stmt->execute();
        
    } else {
        echo "Something bad is going on. Can't send via POST";
    }
    
    $conn->close();
?>