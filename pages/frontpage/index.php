<?php 
    require '../../php/core/init.php';
    require '../../php/core/head.php';
    require '../../php/core/navbar.php';
?>

<div class="row">
    <div class="col" id="welcome">
        <h1>Welcome To <span id="welcome-highlight">ReadIt</h1>
        <h5>The backbone of the internet!</h5>
    </div>
</div>

<div class="row feed">
    <div class="feed__wrapper">
        <?php
            if(isset($_SESSION['loggedin'])) { 
                echo '<div class="feed__wrapperSettings">';
                echo '<button class="btn-reverse post__createBtn">Create Post <i class="fas fa-plus"></i></button>'; #toggles jquery

                /*<select id="order" name="order" class="btn"> Här försökte jag arbeta ut hur jag skulle få ORDER BY $order att fungera men till ingen lycka...
                    <option value="">Please choose an order</option>
                    <option value="published">Newest</option>
                    <option value="votes">Hottest</option>
                </select>*/
                echo '</div>';
            }
        ?>

        <div class="feed__wrapperPosts">
            <?php include '../../php/includes/posts/feed.php'; ?>
        </div>
    </div>
</div>

<div class="overlay">
    <form method="post" action='../../php/includes/posts/createPost.php' class="post__create" enctype="multipart/form-data">
        <h5>Create Post</h5>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <p>Can't exceed 500KB</p>
        <input type="text" name="postTitle" placeholder="Title *" required>
        <textarea name="postMsg" maxlength="255" placeholder="Message *" required></textarea>
        <input type='submit' value='Create Post' class='btn'>
        <input type="button" value="Close" class="btn post__create-close">
    </form>
</div>

<?php include '../../php/core/footer.php'; ?>