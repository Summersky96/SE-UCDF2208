<?php
session_start();
include("conn.php");

$Userpassword = $_POST['password'];
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

    $userId = $_SESSION['mecid'];

    $sql = "UPDATE mechanicinfo SET
        name='" . mysqli_real_escape_string($con, $_POST['name']) . "',
        email='" . mysqli_real_escape_string($con, $_POST['email']) . "',
        telephone='" . mysqli_real_escape_string($con, $_POST['telephone']) . "',
        password='$hashedPassword'";

    // Include user_pic in the update query only if a new profile picture is uploaded
    if (!empty($file_name)) {
        $sql .= ", mecpic='$location'";
    }

    $sql .= " WHERE mecid=$userId";

    // Execute the SQL query
    if (mysqli_query($con, $sql)) {
        $_SESSION['name'] = mysqli_real_escape_string($con, $_POST['name']);
        echo "<script>alert('Record updated!');window.location.href='mecmain.php';</script>";
    } else {
        echo '<script>alert("Update failed!");window.location.href = "mecupdate.php";</script>';
        die(mysqli_error($con));
    }
} else {
    echo '<script>alert("Your Password did not match!");window.location.href = "mecupdate.php";</script>';
}

mysqli_close($con);
?>
