<?php
session_start();
include("conn.php");

if (isset($_POST['forgotbtn'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $sql = "SELECT * FROM userinfo WHERE email='$email'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $rowcount = mysqli_num_rows($result);

    if ($rowcount == 1) {
        $_SESSION["email"] = $row["email"];
        // echo "<script>
        //         const form = document.querySelector('form');
        //         form.classList.add('reset');
        //       </script>";
        header("location: add_bookingtest.php?code=1");
    } 
    else {
        echo "<script>alert('Wrong phonenum/ secretword!');window.location.href='add_bookingtest.php';</script>";
    }
}
?>