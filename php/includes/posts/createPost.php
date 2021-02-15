<?php
    require '../../core/init.php';

    $postTitle = sanitizeInput(mysqli_real_escape_string($conn, $_POST['postTitle']));
    $postMsg   = sanitizeInput(mysqli_real_escape_string($conn, $_POST['postMsg']));
    $author    = $_SESSION['username'];
    $userID    = $_SESSION['id'];

    // Post-img upload
    $uploadDir     = '../../../uploads/';
    $uploadFile    = $uploadDir . basename($_FILES['fileToUpload']['name']);
    $uploadOk      = 1;
    $imageFileType = strtolower(pathinfo($uploadFile,PATHINFO_EXTENSION));

    if(isset($_POST['submit'])) {
        $check = getimagesize($_FILES['fileToUpload']['tmp_name']);

        if($check !== false) {
            echo 'File is an image - ' . $check['mime'] . '.';
            $uploadOk = 1;

        } else {
            echo 'File is not an image.';
            $uploadOk = 0;
        }
    }

    if (file_exists($uploadFile)) {
        echo 'Sorry, file already exists.';
        $uploadOk = 0;
    }

    if ($_FILES['fileToUpload']['size'] > 500000) {
        echo 'Sorry, your file is too large.';
        $uploadOk = 0;
    }

    if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg' && $imageFileType != 'gif' ) {
        echo 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo 'Sorry, your file was not uploaded.';

    } else {
        if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploadFile)) {
            echo 'The file '. basename( $_FILES['fileToUpload']['name']). ' has been uploaded.';

        } else {
            echo 'Sorry, there was an error uploading your file.';
        }
    }

    # Entire post upload
    $stmtTitle   = $conn->prepare('SELECT title FROM posts WHERE title = ?'); # Check if username is registered
    $stmtTitle   -> bind_param('s', $postTitle);
    $stmtTitle   -> execute();
    $resultTitle = $stmtTitle->get_result();

    if ((isset($postTitle)) || (isset($postMsg)) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {

        if (empty($postTitle)) {
            echo 'Title is required';

        } else if(empty($postMsg)) {
            echo 'Message is required';

        } else if(mysqli_num_rows($resultTitle) > 0) {
            echo 'Sorry that title is unavailable';
            
        } else { 
            $stmtImg = $conn->prepare('INSERT INTO files (userID, fileName, postTitle) VALUES (?, ?, ?)'); #Insert post-img to file DB
            $stmtImg->bind_param('sss', $userID, $uploadFile, $postTitle);
            $stmtImg->execute();

            $stmtPost = $conn->prepare('INSERT INTO posts (title, message, author) VALUES (?, ?, ?)'); #Insert post content to post DB
            $stmtPost->bind_param('sss', $postTitle, $postMsg, $author);
            $stmtPost->execute();

            header('location: ../../../pages/frontpage');
        }   

    } else {
        echo "
        Something bad is going on. Can't send via POST <br>
        Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
?>