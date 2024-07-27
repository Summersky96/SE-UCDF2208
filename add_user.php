<?php
session_start();
include('conn.php');

// Check if the user is logged in and has the admin role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo '<script>alert("Access Denied! Only admins can access this page.");window.location.href="loginpage1.php";</script>'; 
    exit();
    }
    
include('adminnav.php');

// Handle category selection and search
$category = "user";
if (isset($_GET['category'])) {
    $category = $_GET['category'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <style>
        section {
            top: 13%;
            transition: all 0.2s ease;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .box{
            max-width: 700px;
            width: 700px;
            margin: 0px auto;
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 0;
            color: #000;
            transition: all .2s ease;
        }
        body.dark-mode .box{
            background-color: #3b4252;
            color: white;
        }
        .box .form{
            padding: 40px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 20px;
        }
        .form h2{
            font-size: 32px;
            text-align: center;
            padding-bottom: 1rem;
        }
       
        .inputbox{
            position: relative;
            margin: 33px 0;
            width: 100%;
            border-bottom: 2px solid #fff;
        }
        .choose{
            position: relative;
            margin: 30px 0;
            width: 100%;
        }
        .dobBox{
            position: relative;
            margin: 30px 0;
            width: 310px;
        }

        .inputbox label{
            position: absolute;
            top: 50%;
            left: 5px;
            transform: translateY(-50%);
            font-size: 16px;
            pointer-events: none;
        }
        .choose label{
            position: absolute;
            top: 20%;
            left: 5px;
            transform: translateY(-50%);
            font-size: 16px;
            pointer-events: none;
        }

        .inputbox input:focus~label,
        .inputbox input:valid~label{
            top: -5px;
            background-color: transparent;
        }

        .inputbox input{
            width: 100%;
            height: 50px;
            background: transparent;
            border: none;
            outline: none;
            font-size: 16px;
            padding:0 35px 0 5px;
            color: #fff;
        }
        .profilepic{
            padding: 10px;
        }
        .choose input{
            width: 10%;
            background: transparent;
            border: none;
            outline: none;
            font-size: 25px;
            padding:0 35px 0 5px;
        }

        .choose i{
            position: absolute;
            right: 8px;
            font-size: 19.2px;
            top: 20px;
        }
        .inputbox i{
            position: absolute;
            right: 8px;
            font-size: 19.2px;
            top: 20px;
        }
        button{
            width: 49%;
            height: 40px;
            border-radius: 5px;
            border: none;
            outline: none;
            cursor: pointer;
            font-size: 1em;
            font-weight: 600;
        }
        button:hover{
            transition: .3s;
        }
        
        select {
            background-color: #f9f9f9;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            position: relative;
            margin: auto;
            margin-bottom: 30px;
            display: flex;
        }

        .inputbox{
            border-bottom: 2px solid #1e1e1e;
        }
        body.dark-mode .inputbox{
            border-bottom: 2px solid #ccc;
        }
        .save{
            background-color: #4CAF50;
            color: #fff;
        }
        .save:hover{
            background-color: #3e8e41;
        }
        .reset:hover{
            background-color: darkred;
        }
        .reset{
            background-color: #ff0000;
            color: #fff;
        }
    </style>
    <link rel="stylesheet" href="login1.css">
    
</head>
<body>
        <section>
            <div class="box">
                <div class="form">
                    <form action="adduser.php" method="post" enctype="multipart/form-data">
                    <h2>Add Account</h2>
                        <select name="category" onchange="submitCategoryForm()">
                            <option value="user" <?= $category == "user" ? 'selected' : '' ?>>Users</option>
                            <option value="mechanic" <?= $category == "mechanic" ? 'selected' : '' ?>>Mechanics</option>
                        </select>
                        <input type="hidden" name="id" value="">
                        <div class="inputbox">
                            <i class="fa-regular fa-user"></i>
                            <input type="name" name="username" required value="">
                            <label for="">Username</label>
                        </div>
                        <div class="inputbox">
                            <i class="fa-regular fa-envelope"></i>
                            <input type="email" name="email" required value="">
                            <label for="">Email</label>
                        </div>
                        <div class="inputbox">
                            <i class='bx bx-phone'></i>
                            <input type="tel" name="telephone" required value="">
                            <label for="">Telephone</label>
                        </div>
                        <div class="inputbox">
                            <i class="fa-regular fa-eye" id="display-password" style="cursor: pointer;"></i>
                            <input type="password" name ="user_password" id="passcode" required value="">
                            <label for="">Password</label>
                        </div>
                        <div class="inputbox">
                            <i class="fa-regular fa-eye" id="check-password" style="cursor: pointer;"></i>
                            <input type="password" name ="CFpassword" id="pass" required>
                            <label for="">Confirm Password</label>
                        </div>
                        <button type="submit" name="submitBtn" class="save">Add</button>
                        <button type="reset" class="reset" onclick="resetProfilePicture()">Reset</button>            
                    </form>
                </div>
            </div>
        </section>

        <?php include('footer.php') ?>
        
</body>
</html>
<script>
    function resetProfilePicture() {
            // Clear the file input value
            var fileInput = document.getElementById('contact_pic');
            fileInput.value = '';
        }
        const displayPassword = document.querySelector('#display-password');
             const passcodeField = document.querySelector('#passcode');
                     displayPassword.addEventListener('click', function() {
                        // toggle the eye / eye slash icon
                        this.classList.toggle("fa-eye");
                        this.classList.toggle("fa-eye-slash", !this.classList.contains("fa-eye"));
                        // toggle the type attribute
                        const type = passcodeField.getAttribute('type') === 'password' ? 'text' : 'password';
                             passcodeField.setAttribute('type', type);
                     })
        const checkPassword = document.querySelector('#check-password');
             const passField = document.querySelector('#pass');
                     checkPassword.addEventListener('click', function() {
                        // toggle the eye / eye slash icon
                        this.classList.toggle("fa-eye");
                        this.classList.toggle("fa-eye-slash", !this.classList.contains("fa-eye"));
                        // toggle the type attribute
                        const type = passField.getAttribute('type') === 'password' ? 'text' : 'password';
                             passField.setAttribute('type', type);
                     })
</script>

<?php
// Close the database connection
mysqli_close($con);
?>
