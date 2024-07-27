<?php
session_start();
include_once "conn.php";

// Check if user is logged in
if(isset($_SESSION['userid'])){
    $user_id = $_SESSION['userid'];
    $table = 'userinfo';
} elseif(isset($_SESSION['adminid'])){
    $user_id = $_SESSION['adminid'];
    $table = 'admininfo';
} elseif(isset($_SESSION['mecid'])){
    $user_id = $_SESSION['mecid'];
    $table = 'mechanicinfo';
} else {
    header("location: ../loginpage1.php");
    exit(); // Stop further execution
}

// Update user status to "Offline"
$status = "Offline now";

if(isset($_SESSION['userid'])){
    $sql = mysqli_query($con, "UPDATE userinfo SET status = '$status' WHERE userid = $user_id");
} elseif(isset($_SESSION['adminid'])){
    $sql = mysqli_query($con, "UPDATE admininfo SET status = '$status' WHERE adminid = $user_id");
} elseif(isset($_SESSION['mecid'])){
    $sql = mysqli_query($con, "UPDATE mechanicinfo SET status = '$status' WHERE mecid = $user_id");
}

// Destroy session
session_unset();
session_destroy();

// Redirect to login page
echo '<script>alert("You are logged out!"); window.location.href="loginpage1.php";</script>';
?>
