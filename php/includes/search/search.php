<?php 

    require '../../core/init.php';

    $search = "%{$_GET['term']}%";

    $stmt   = $conn->prepare("SELECT * FROM posts WHERE title LIKE ?");
    $stmt   -> bind_param('s', $search);
    $stmt   -> execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row['title'];
        }
    }
    
    echo json_encode($data); 
    
    $conn->close();

?>
