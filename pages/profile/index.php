<?php 
    require '../../php/core/init.php';
    require '../../php/core/head.php';
    require '../../php/core/navbar.php';
    require '../../php/includes/account/denied.php';
?>

<div class="row">
    <div class="profile">
        <?php 
            if(!isset($_SESSION['loggedin'])) {
                echo '<h3>' .$_SESSION['username']. '</h3>';

            } else {
                if($_SESSION['logins'] == 0) {
                    echo '<h3>Welcome to ReadIt '.$_SESSION['username'].'</h3>'; 
                
                } else {
                    echo '<h3>Welcome back '.$_SESSION['username'].'</h3>';
                }

                echo'
                <ul>
                    <li><i class="fas fa-user-plus"></i> '  .date("j.n.Y - H:i:s", strtotime($_SESSION['registered'])).'</li>
                    <li><i class="fas fa-user-clock"></i> ' .date("j.n.Y - H:i:s", strtotime($_SESSION['latest'])).'</li>
                    <li><i class="fas fa-user-tag"></i> '   .$_SESSION['role'].'</li>
                    <li><i class="fas fa-history"></i> '    .$_SESSION['logins'].'</li>
                </ul>';
            }
        ?>
    </div>
</div>

<?php include '../../php/core/footer.php'; ?>