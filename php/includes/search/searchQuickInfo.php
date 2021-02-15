<?php 

    require '../../core/init.php';

    $title  = $_GET['title'];
    $sql    = $conn->query("SELECT * FROM posts WHERE title = '$title'");

    if ($sql->num_rows > 0) {
        while($row = $sql->fetch_assoc()) {
            echo ' 
            <div class="search__info"> 
                <p>Quick ' . $row['title'] . ' info</p>
                <p><i class="far fa-user"></i> '.$row['author'] . '<br> <i class="far fa-clock"></i> ' . $row['published'].'</p>
            </div>';
        }
    }
    
    $conn->close();
?>