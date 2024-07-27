<?php
session_start();
include("conn.php");

$Userpassword = $_POST['user_password'];
$CFpassword = $_POST['CFpassword'];

if ($Userpassword === $CFpassword) {
    $hashedPassword = mysqli_real_escape_string($con, $Userpassword);

    $file_name = basename($_FILES["contact_pic"]["name"]);
    $tmp_name = $_FILES["contact_pic"]["tmp_name"];
    $upload_directory = "pfp/";

    // Check if a new profile picture is uploaded
    if (!empty($file_name)) {
        $location = $upload_directory . $file_name;
        // Move the uploaded file
        if (!move_uploaded_file($tmp_name, $location)) {
            echo "<script>alert('Failed to change profile picture');</script>";
            exit(); // Exit if failed to upload profile picture
        }
    }

    $userId = $_SESSION['userid'];

    $sql = "UPDATE userinfo SET
        username='" . mysqli_real_escape_string($con, $_POST['username']) . "',
        email='" . mysqli_real_escape_string($con, $_POST['email']) . "',
        telephone='" . mysqli_real_escape_string($con, $_POST['telephone']) . "',
        user_password='$hashedPassword'";

    // Include user_pic in the update query only if a new profile picture is uploaded
    if (!empty($file_name)) {
        $sql .= ", userpic='$location'";
    }

    $sql .= " WHERE userid=$userId";

    // Execute the SQL query
    if (mysqli_query($con, $sql)) {
        $_SESSION['username'] = mysqli_real_escape_string($con, $_POST['username']);
        echo "<script>alert('Record updated!');window.location.href='profile.php';</script>";
    } else {
        echo '<script>alert("Update failed!");window.location.href = "profile.php";</script>';
        die(mysqli_error($con));
    }
} else {
    echo '<script>alert("Your Password did not match!");window.location.href = "profile.php";</script>';
}

mysqli_close($con);
?>
