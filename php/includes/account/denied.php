<?php
    if(!isset($_SESSION['loggedin'])) {
        echo 
        '<div id="denied">
            <h1>Access denied!</h1>
            <img src="../../img/denied.gif" alt="denied">
        </div>';
        die();
    }
?>