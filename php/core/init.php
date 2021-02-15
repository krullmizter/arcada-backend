<?php
    require_once 'config.php';

    # Force HTTPS
    if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on'){
      header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], true, 301);
      exit;
    }

    # Start session & initialize sanitization validation function
    session_start();
    
    function sanitizeInput($input) {
      $input = trim($input);
      $input = stripslashes($input);
      $input = htmlspecialchars($input);
      return $input;
    }

    # DB Config 
    $servername = 'localhost';
    $username   = $secDbUsername;
    $password   = $secDbPassword;
    $dbname     = $secDbname;

    # Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset('utf-8');

    # Check connection
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }
    
?>