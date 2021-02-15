<?php 
    require '../../php/core/init.php';
    require '../../php/core/head.php';
    require '../../php/core/navbar.php';
    require '../../php/includes/account/denied.php';

    $sql    = 'SELECT * FROM users';
    $result = $conn -> query($sql);
?>

<div class="row">
    <div class="admin">
        <h4>All Registered Users</h4>

        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Delete</th>
            </tr>
        
        <?php
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo'
                        <tr>
                            <td>'.$row['id'].'</td>
                            <td>'.$row['username'].'</td>
                            <td>'.$row['name'].'</td>
                            <td>'.$row['email'].'</td>
                            <td>'.$row['role'].' 
                            <form method="post"> 
                            <select id="roles" name="role" class="btn">
                            <option value="admin" name="admin">Admin</option>
                            <option value="editor" name="editor">Editor</option>
                            <option value="user" name="user">User</option>
                            <input type="submit" name="changeRole" value="Change" class="btn" id="changeRole"> 
                            <input type="hidden" value="'.$row['id'].'" name="changeRoleHidden">
                        </form>
                    </td>
                    <td>'.$row['status'].'</td>
                    <td>
                        <form method="post"> 
                            <button><i class="far fa-trash-alt"></i> '.$row['username'].'</button>
                            <input type="hidden" value="' .$row['id']. '" name="delUserHidden">
                        </form>
                    </td>';
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            if(isset($_POST['changeRoleHidden'])) {
                $stmt = $conn->prepare("UPDATE users set role = ? WHERE id = ?");
                $stmt->bind_param("si", $role, $id);
                
                $role = $_POST['role'];
                $id   = $_POST['changeRoleHidden'];
    
                $stmt->execute();
            }

            if(isset($_POST['delUserHidden']) && $_POST['delUserHidden'] != $_SESSION['id']) {

                $stmt = $conn->prepare('DELETE FROM users WHERE id = ?');
                $stmt->bind_param('i', $id);

                $id   = $_POST['delUserHidden'];

                $stmt->execute();
            }
            
            $conn->close();
        }

    } else {
        echo '<p>No results...</p>';
    }
        ?>

            </tr>
        </table>
    </div>
</div>

<div class="row feed">
    <div class="feed__wrapper">
        <div class="feed__wrapperPosts">
            <h4>All Posts</h4>
                <?php include '../../php/includes/posts/feed.php'; ?>
        </div>
    </div>
</div>

<?php 
    include '../../php/core/footer.php'; 
?>