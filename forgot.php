<?php
session_start();
$error = array();

require "mail.php";

    if (!$con = mysqli_connect("localhost","root","","carmaintainance")){

        die("Could not Connect");
    }

    $mode = "enter_email";
    if(isset($_GET['mode'])){
        $mode = $_GET['mode'];
    }

    //something is posted
    if(count($_POST) > 0){

        switch ($mode) {
            case 'enter_email':
                # code...
                $email = $_POST['email'];
                //validate email
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $error[] = "Please enter a valid email";
                }elseif(!valid_email($email)){
                    $error[] = "That email was not found";    
                }else{

                    $_SESSION['forgot']['email'] = $email;
                    send_email($email);
                    header("Location: forgot.php?mode=enter_code");
                    die;
                }
                break;
            
            case 'enter_code':
                # code...
                $code = $_POST['code'];
                $result = is_code_correct($code);

                if($result == "the code is correct"){

                    $_SESSION['forgot']['code'] = $code;
                    header("Location: forgot.php?mode=enter_password");
                    die;
                }else{
                    $error[] = $result;
                }
                break;    
            
            case 'enter_password':
                # code...
                $password = $_POST['password'];
                $password2 = $_POST['password2'];

                if($password !== $password2){
                    $error[] = "Passwords do not match";
                }elseif(!isset($_SESSION['forgot']['email']) || !isset($_SESSION['forgot']['code'])){
                    header("Location: forgot.php");
                    die;
                }
                else{
                    save_password($password);
                    if(isset($_SESSION['forgot'])){
                        unset($_SESSION['forgot']);
                    }

                    echo '<script>alert("Password changed successful!");window.location.href="loginpage1.php";</script>';
                    die;

                }
                break; 
            
            default:
                # code...
                break;
        }
    } 

    function send_email($email){
        global $con;
        
        $expire = time() + (60 * 1);
        $code = rand(10000,99999);
        $email = addslashes($email);

        $query = "insert into codes (email,code,expire) value ('$email', '$code', '$expire')";
        mysqli_query($con,$query);

        //send email here
        send_mail($email,'Password Reset',"Your code is " . $code);

    }

    function save_password($password){
        global $con;
        
        //$password = password_hash($password, PASSWORD_DEFAULT);
        $email = addslashes($_SESSION['forgot']['email']);

        $query = "update userinfo set user_password = '$password' where email = '$email' limit 1";
        mysqli_query($con,$query);

    }

    function valid_email($email){
        global $con;
        
        $email = addslashes($email);

        $query = "select * from userinfo where email = '$email' limit 1";
        $result = mysqli_query($con, $query);
        if($result){
            if(mysqli_num_rows($result) > 0)
            {    
                    return true;
            }
        }

        return false;

    }

    function is_code_correct($code){
        global $con;

        $code = addslashes($code);
        $expire = time();
        $email = addslashes($_SESSION['forgot']['email']);

        $query = "select * from codes where code = '$code' && email = '$email' order by id desc limit 1";
        $result = mysqli_query($con, $query);
        if($result){
            if(mysqli_num_rows($result) > 0)
            {
                $row = mysqli_fetch_assoc($result);
                if($row['expire'] > $expire){
                    
                    return "the code is correct";
                }else {
                    return "the code is expired";
                }
            }else{
                return "the code is incorrect";
            }
        }

        return "the code is incorrect";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password - Auto Shop</title>
    <style type="text/css">
        * {
            font-family: Arial, sans-serif;
            box-sizing: border-box;
        }

        body {
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        section{
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            width: 100%;
            background: hsla(150,0%,5%,0.3);
        }

        section .container {
            width: 100%;
            max-width: 500px;
            margin: auto;
            padding: 25px;
            /* background: #3F3F42; */
            background: transparent;
            border: 2px solid #ffe000;
            border-radius: 20px;
            backdrop-filter: blur(20px);
            box-shadow: 0 0 30px rgba(0,0,0,.5);
            border-radius: 8px;
            /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); */
        }

        h1 {
            text-align: center;
            color: #fff;
        }

        h3 {
            text-align: center;
            color: #fff;
            font-weight: normal;
        }

        .textbox {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"], input[type="button"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            background: #ffd100;
            border: none;
            border-radius: 4px;
            color: #1e1e1e;
            cursor: pointer;
            font-size: 17px;
            font-weight: 600;
            transition: all .2s ease;
        }

        input[type="submit"]:hover, input[type="button"]:hover {
            background: #dbb42c;
            /* color: #fff; */
        }

        .error {
            font-size: 12px;
            color: red;
            text-align: center;
        }

        .links {
            text-align: center;
            margin-top: 20px;
        }

        .links a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
        }

        .links a:hover {
            text-decoration: underline;
        }

         @media (min-aspect-ratio: 16/9){
            .backgroundVideo{
                width: 100%;
                height: auto;
            }
        }
        @media (max-aspect-ratio: 16/9){
            .backgroundVideo{
                width: auto;
                height: 100%;
            }
        }
        .backgroundVideo{
            position: absolute;
            right: 0;
            bottom: 0;
            z-index: -1;
        }
    </style>
</head>
<body>
    <video autoplay loop muted plays-inline class="backgroundVideo">
        <source src="forgorvid.mp4" type="video/mp4">
        </video>
        <section>

            <div class="container">
                <?php
                    switch ($mode) {
                        case 'enter_email':
                            ?>
                            <form method="post" action="forgot.php?mode=enter_email">
                                <h1>Forgot Password</h1>
                                <h3>Enter your email below</h3>
                                <div class="error">
                                <?php
                                    foreach ($error as $err){
                                        echo $err . "<br>";
                                    }
                                ?>
                                </div>
                                <input class="textbox" type="email" name="email" placeholder="Email"><br>
                                <input type="submit" value="Next">
                                <div class="links"><a href="loginpage1.php">Login</a></div>
                            </form>
                            <?php
                            break;
        
                        case 'enter_code':
                            ?>
                            <form method="post" action="forgot.php?mode=enter_code">
                                <h1>Forgot Password</h1>
                                <h3>Enter the code sent to your email</h3>
                                <div class="error">
                                <?php
                                    foreach ($error as $err){
                                        echo $err . "<br>";
                                    }
                                ?>
                                </div>
                                <input class="textbox" type="text" name="code" placeholder="12345"><br>
                                <input type="submit" value="Next">
                                <a href="forgot.php">
                                    <input type="button" value="Start Over">
                                </a>
                                <div class="links"><a href="loginpage1.php">Login</a></div>
                            </form>
                            <?php
                            break;
        
                        case 'enter_password':
                            ?>
                            <form method="post" action="forgot.php?mode=enter_password">
                                <h1>Forgot Password</h1>
                                <h3>Enter your new password</h3>
                                <div class="error">
                                <?php
                                    foreach ($error as $err){
                                        echo $err . "<br>";
                                    }
                                ?>
                                </div>
                                <input class="textbox" type="password" name="password" placeholder="Password"><br>
                                <input class="textbox" type="password" name="password2" placeholder="Retype Password"><br>
                                <input type="submit" value="Next">
                                <a href="forgot.php">
                                    <input type="button" value="Start Over">
                                </a>
                                <div class="links"><a href="loginpage1.php">Login</a></div>
                            </form>
                            <?php
                            break;
        
                        default:
                            break;
                    }
                ?>
            </div>
        </section>
</body>
</html>
