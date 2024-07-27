<?php
if (isset($_POST['submitbtn'])) {
    include('conn.php');
    $sql="SELECT * FROM userinfo WHERE username='$_POST[username]'";
    $email="SELECT * FROM userinfo WHERE email='$_POST[email]'";
    $Userpassword=$_POST['user_password'];
    $CFpassword=$_POST['CFpassword'];

    $result=mysqli_query($con,$sql);
    $mail=mysqli_query($con,$email);
    if($result){
        $num=mysqli_num_rows($result);
        $ber=mysqli_num_rows($mail);
        if($num>0){
            echo'<script>alert("The Username has been used!");
            window.location.href = "loginpage1.php";
            </script>';
        }
        else if($ber>0){
            echo'<script>alert("The Email has been used!");
            window.location.href = "loginpage1.php";
            </script>';
        }
        else{
            if($Userpassword===$CFpassword){
            $status = "Active now";
            $sql="INSERT INTO userinfo (username, email, telephone, user_password, userpic, status)
            
            VALUES
            
            ('$_POST[username]','$_POST[email]','$_POST[telephone]','$_POST[user_password]', 'pfp/userimage.png', '{$status}')";

            if(mysqli_query($con,$sql)){
                echo '<script>alert("Signup successfull!");
                window.location.href = "loginpage1.php";
                </script>';
            }
        }   else    {
                echo '<script>alert("Your Password did not matched!");
                window.location.href = "loginpage1.php";
                </script>';
                die(mysqli_error($con));
            }

        }
    }
    mysqli_close($con);
} else {
    echo"<script>alert('Please key in the input.');window.location.href='loginpage.php';</script>";
}