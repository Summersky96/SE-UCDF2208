<?php
include("conn.php");

$adminPassword = $_POST['admin_password'];
$confirmPassword = $_POST['CFpassword'];

if ($adminPassword === $confirmPassword) {
    $hashedPassword = mysqli_real_escape_string($con, $adminPassword);

    $file_name = basename($_FILES["admin_pic"]["name"]);
    $tmp_name = $_FILES["admin_pic"]["tmp_name"];
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

    $adminemail = mysqli_real_escape_string($con, $_POST['adminemail']);

    $sql = "UPDATE admininfo SET
        adminemail='$adminemail',
        password='$hashedPassword'";

    // Include admin_pic in the update query only if a new profile picture is uploaded
    if (!empty($file_name)) {
        $sql .= ", adminpic='$location'";
    }

    // Execute the SQL query
    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Record updated!');window.location.href='adminmain.php';</script>";
    } else {
        echo '<script>alert("Update failed!");window.location.href = "admininfo.php";</script>';
        die(mysqli_error($con));
    }
} else {
    echo '<script>alert("Your Password did not match!");window.location.href = "admininfo.php";</script>';
}

mysqli_close($con);
?>
