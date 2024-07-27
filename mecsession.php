<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    if(!isset($_SESSION["mecid"])){
        echo '<script>alert("Please Login!"); window.location.href="loginpage1.php";</script>';
    }
?>