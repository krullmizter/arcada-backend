<?php

    $sqlComments    = 'SELECT * FROM posts LEFT JOIN comments ON posts.postID = comments.postID where posts.postID = posts.postID';
    $resultComments = $conn->query($sqlComments);
    
    echo '
    <div class="post__comments">
        <p>Comments</p>';
        if ($resultComments->num_rows > 0) {
            while($row = $resultComments->fetch_assoc()) {
                echo 'by:' .$row['commentAuthor']. '<br>'.$row['comment'].'</br>';
            } 
        }
    echo '</div>';

    $conn->close();

?>