<?php
// Handle category selection and search

if (isset($_POST['submitBtn'])) {
    if($category === 'user'){
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
                window.location.href = "add_user.php";
                </script>';
            }
            else if($ber>0){
                echo'<script>alert("The Email has been used!");
                window.location.href = "add_user.php";
                </script>';
            }
            else{
                if($Userpassword===$CFpassword){
                $sql="INSERT INTO userinfo (username, email, telephone, user_password, userpic, status)
                
                VALUES
                
                ('$_POST[username]','$_POST[email]','$_POST[telephone]','$_POST[user_password]', 'pfp/userimage.png', 'Offline now')";
    
                if(mysqli_query($con,$sql)){
                    echo '<script>alert("Customer Signup successfull!");
                    window.location.href = "add_user.php";
                    </script>';
                }
            }   else    {
                    echo '<script>alert("Your Password did not matched!");
                    window.location.href = "add_user.php";
                    </script>';
                    die(mysqli_error($con));
                }
    
            }
        }
    } else{
        include('conn.php');
        $sql="SELECT * FROM mechanicinfo WHERE name='$_POST[username]'";
        $email="SELECT * FROM mechanicinfo WHERE email='$_POST[email]'";
        $Userpassword=$_POST['user_password'];
        $CFpassword=$_POST['CFpassword'];
    
        $result=mysqli_query($con,$sql);
        $mail=mysqli_query($con,$email);
        if($result){
            $num=mysqli_num_rows($result);
            $ber=mysqli_num_rows($mail);
            if($num>0){
                echo'<script>alert("The Username has been used!");
                window.location.href = "add_user.php";
                </script>';
            }
            else if($ber>0){
                echo'<script>alert("The Email has been used!");
                window.location.href = "add_user.php";
                </script>';
            }
            else{
                if($Userpassword===$CFpassword){
                $sql="INSERT INTO mechanicinfo (name, email, telephone, mecpassword, mecpic, status)
                
                VALUES
                
                ('$_POST[username]','$_POST[email]','$_POST[telephone]','$_POST[user_password]', 'pfp/userimage.png', 'Offline now')";
    
                if(mysqli_query($con,$sql)){
                    echo '<script>alert("Mechanic Signup successfull!");
                    window.location.href = "add_user.php";
                    </script>';
                }
            }   else    {
                    echo '<script>alert("Your Password did not matched!");
                    window.location.href = "add_user.php";
                    </script>';
                    die(mysqli_error($con));
                }
    
            }
        }
    }
    mysqli_close($con);
} else {
    echo"<script>alert('Please key in the input.');window.location.href='add_user.php';</script>";
}