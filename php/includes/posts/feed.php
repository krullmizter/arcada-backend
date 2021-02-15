<?php 
    /*if(isset($_POST['order'])) { Här försökte jag arbeta ut hur jag skulle få ORDER BY $order att fungera men till ingen lycka...
        $order = $_POST['order'];
        INNER JOIN files ON posts.title = files.postTitle ORDER BY published DESC LIMIT 0, 5";*/
        
        $sql = 'SELECT * FROM posts ORDER BY published DESC LIMIT 0, 5';
        $results = $conn->query($sql);

        if ($results->num_rows > 0) {
            while($row = $results->fetch_assoc()) {
                $postID    = $row['postID'];
                $title     = $row['title'];
                $message   = $row['message'];
                $author    = $row['author'];
                $published = strtotime($row['published']);
                
                echo '
                <div class="post"> 
                    <div class="post__head">
                        <div>
                            <h6>'.$row['title'].'</h6>
                            <p> <i class="far fa-user"></i> '.$author.'</p>
                            <p> <i class="far fa-clock"></i> '.date("j.n.Y - H:i:s", $published).'</p>
                        </div>
                            
                        <div class="post__votes">
                            <p>'.$row['votes'].' Votes</p>
                            <i data-id="'.$postID.'" class="fas fa-arrow-up -upvote"></i>
                            <i data-id="'.$postID.'" class="fas fa-arrow-down -downvote"></i>
                        </div>
                    </div>
                
                    <div class="post__body">';

                        $sqlImg     = "SELECT * FROM posts LEFT JOIN files ON posts.title = files.postTitle WHERE posts.postID = $postID"; // Loop through image images for a given post
                        $resultsImg = $conn->query($sqlImg);

                        if($resultsImg->num_rows > 0){
                            while($row = $resultsImg->fetch_assoc()) {
                                echo '
                                <div class="post__img">
                                    <img src='.$row['fileName'].'>
                                </div>';
                            }

                        } else {
                            echo '';
                        }
    
                        echo '<p>'.$message.'</p>
    
                        <div class="post__comments">
                            <h6>Comments</h6>';
    
                            $sqlComments     = "SELECT * FROM comments WHERE comments.postID = $postID"; // Loop through all comments for a given post
                            $resultsComments = $conn->query($sqlComments);
    
                            if($resultsComments->num_rows > 0){
                                while($row = $resultsComments->fetch_assoc()) {
                                    echo '
                                    <p>'.$row['comment'].' <br>
                                    <i class="far fa-user"></i> '.$row['commentAuthor'].'</p>';
                                }
    
                            } else {
                                echo '<p>No comments yet...</p>';
                            } 
                        echo' 
                        </div>   
                    </div>
                
                    <div class="post__footer">';
                        if(isset($_SESSION["loggedin"])) {
                            $role = $_SESSION['role'];
                            
                            echo '<button type="button" class="post__commentBtn" data-id="'.$postID.'">Comments <i class="fas fa-comments"></i></button>';
    
                            if($role == 'admin' || $role == 'editor' || $author == $_SESSION['username']) { # Edit posts only if logged in and as a either admin, editor or as the user who created the post
                                echo '
                                <button type="button" class="post__editBtn" data-id="'.$postID.'">Edit <i class="fas fa-pencil-alt"></i></button>';
                            }
    
                            if($role == 'admin' || $author == $_SESSION['username']) { # Delete posts only if logged in as a admin or the author of the post
                                echo'
                                <form method="post"> 
                                    <input type="hidden" value="'.$postID.'" name="post__deleteHidden">
                                    <button name="post__deleteBtn">Delete <i class="far fa-trash-alt"></i></button>
                                </form>';
                            }
                        } 
                    echo'</div>
                </div>';
            }
    
            echo ' 
            <div class="overlay-edit">
                <form method="post" action="../../php/includes/posts/editPost.php" class="post__edit">
                    <h5>Edit Post</h5>
                    <input type="text" name="postTitle" maxlength="35" placeholder="Edit title">
                    <textarea name="postMsg" maxlength="255" placeholder="Edit message"></textarea>
                    <button type="submit">Edit Post</button>
                    <button type="button" class="post__edit-close">Close</button>
                    <input type="hidden" name="post__editHidden" value="">
                </form>
            </div>';
    
            echo'
            <div class="overlay-comment">
                <form method="post" action="../../php/includes/posts/createComment.php" class="post__comment">
                    <h5>Comment</h5>
                    <textarea name="comment" maxlength="255" placeholder="Comment"></textarea>
                    <button type="submit">Submit comment</button>
                    <button type="button" class="post__comment-close">Close</button>
                    <input type="hidden" name="post__commentHidden" value="">
                </form>
            </div>';
    
            if(isset($_POST['post__deleteBtn'])) { # Delete a post and the post image
                $stmt = $conn->prepare('DELETE posts, files FROM posts INNER JOIN files on posts.title = files.postTitle WHERE posts.postID = ?');
                $stmt->bind_param('i', $id);
                $id = $_POST['post__deleteHidden'];
                $stmt->execute();
            }
                    
        } else {
            echo '<p class="noposts">No posts to show...</p>';
        }

        $conn->close();

    /*} else {
        echo "It is not set.";
    }*/
?>


