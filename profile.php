<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <style>
       @import url('https://fonts.cdnfonts.com/css/font');
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        section{
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            width: 100%;
            background: hsla(180,0%,10%,0.8);
        }
        .box{
            position: relative;
            width: 600px;
            /* height: 800px; */
            background: transparent;
            border: 2px solid rgba(255,255,255,5);
            border-radius: 20px;
            backdrop-filter: blur(20px);
            box-shadow: 0 0 30px rgba(0,0,0,.5);
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: auto;
        }
        .box .form{
            padding: 20px;
            width: 88%;
        }
        .form h2{
            font-size: 32px;
            color: #fff;
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
            color: #fff;
        }
        .dobBox{
            position: relative;
            margin: 30px 0;
            width: 310px;
            color: #fff;
        }

        .inputbox label{
            position: absolute;
            top: 50%;
            left: 5px;
            transform: translateY(-50%);
            color: #fff;
            font-size: 16px;
            pointer-events: none;
            transition: .5s;
        }
        .choose label{
            position: absolute;
            top: 20%;
            left: 5px;
            transform: translateY(-50%);
            color: #fff;
            font-size: 16px;
            pointer-events: none;
        }
        .dobBox label{
            position: absolute;
            top: 20%;
            left: 5px;
            transform: translateY(-50%);
            color: #fff;
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
        .dobBox input{
            width: 142%;
            background: transparent;
            border: none;
            outline: none;
            font-size: 19px;
            padding:0 0px 0 5px;
            color: #fff;
        }

        .choose i{
            position: absolute;
            right: 8px;
            color: #fff;
            font-size: 19.2px;
            top: 20px;
        }
        .inputbox i{
            position: absolute;
            right: 8px;
            color: #fff;
            font-size: 19.2px;
            top: 20px;
        }
        button{
            width: 49%;
            height: 40px;
            border-radius: 40px;
            background: #fff;
            border: none;
            outline: none;
            cursor: pointer;
            font-size: 1em;
            font-weight: 600;
        }
        button:hover{
            background-color: grey;
            color: #fff;
            transition: .3s;
        }
        
        .deactivate-btn{
            background-color: darkred;
            color: #fff;
            margin-top: 15px;
            width: 100%;
        }
        .deactivate-btn:hover{
            background-color: red;
        }

/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
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
        .profilepic label{
            position: relative;
            color: #fff;
            font-size: 16px;
            pointer-events: none;
        }
/* -------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
        .backarrow{
            align-content: center;
            font-size: 30px;
            position: absolute;
            top: 20px;
            left: 50px;
            text-decoration: none;
        }
        .backarrow a{
            color: #fff;
            transition: all .1s ease;
        }
        .backarrow a:hover{
            font-size: 40px;
            color: #ccc5b9;
        }

        .profilepic {
            position: relative;
            width: 150px; /* Adjust as needed */
            height: 150px; /* Adjust as needed */
            margin: 0 auto; /* Center the profile picture */
            overflow: hidden;
            border-radius: 50%;
            background-color: #5b5c62; /* Fallback color */
        }

        .profilepic img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 0.3s ease-in-out;
            border-radius: 50%;
        }

        .profilepic .upload-label {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0;
            color: #fff;
            font-weight: 1000;
            font-size: 20px;
            cursor: pointer;
            text-align: center;
            transition: opacity 0.3s ease-in-out;
        }

        .profilepic:hover .upload-label {
            opacity: 1;
            z-index: 1;
        }

        .profilepic:hover img {
            opacity: 0.5;
        }

        /* Semi-transparent overlay */
        .profilepic::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7); /* Adjust opacity as needed */
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            border-radius: 50%;
        }

        .profilepic:hover::before {
            opacity: 1;
        }

        /* Hide input[type="file"] */
        #contact_pic {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            overflow: hidden;
            z-index: 3;
            border-radius: 50%;
            cursor: pointer;
        }
        .backarrow{
            cursor: pointer;
        }
    </style>
    <link href="https://fonts.cdnfonts.com/css/lindsey-samsung" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.cdnfonts.com/css/flow-ext" rel="stylesheet">
</head>
<body>

<?php
    include("conn.php");

    // Check if the session ID is set
    if(isset($_SESSION['userid'])) {
        // Retrieve the user ID from the session
        $userId = $_SESSION['userid'];

        // Query to fetch user data based on the session ID
        $sql = "SELECT * FROM userinfo WHERE userid = $userId";
        $result = mysqli_query($con, $sql);

        // Check if the query was successful
        if($result) {
            // Fetch the user data
            $row = mysqli_fetch_array($result);
        } else {
            // Handle query error
            echo "Query Error: " . mysqli_error($con);
        }
    } else {
        // Handle the case where the session ID is not set
        echo "Session ID is not set!";
    }

    // Close the database connection
    mysqli_close($con);
?>

    <video autoplay loop muted plays-inline class="backgroundVideo">
        <source src="pfpvid.mp4" type="video/mp4">
    </video>
    <section>
        <div class="backarrow"><a onclick="window.history.back();"><i class="fa-solid fa-arrow-left"></i></a></div>
        <div class="box">
            <div class="form">
                <form action="updateinfo.php" method="post" enctype="multipart/form-data">
                    <h2>Edit Profile</h2>
                    <?php if(isset($row)): ?>
                    <input type="hidden" name="id" value="<?php echo $row['userid']?>">
                    <div class="profilepic" id="profile-pic-container">
                        <label for="contact_pic" id="upload-label" class="upload-label">Upload image</label>
                        <input type="file" accept="image/*" id="contact_pic" name="contact_pic" onchange="show(this)">
                        <img id="profile_pic" src="<?php echo $row['userpic'] ?>" alt="Profile Picture">
                    </div>

                    <div class="inputbox">
                        <i class="fa-regular fa-user"></i>
                        <input type="text" name="username" required value="<?php echo $row['username']?>">
                        <label for="">Username</label>
                    </div>
                    <div class="inputbox">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="email" name="email" required value="<?php echo $row['email']?>">
                        <label for="">Email</label>
                    </div>
                    <div class="inputbox">
                        <i class='bx bx-phone'></i>
                        <input type="tel" name="telephone" required value="<?php echo $row['telephone']?>">
                        <label for="">Telephone</label>
                    </div>
                    <div class="inputbox">
                        <i class="fa-regular fa-eye" id="display-password" style="cursor: pointer;"></i>
                        <input type="password" name ="user_password" id="passcode" required value="<?php echo $row['user_password']?>">
                        <label for="">Password</label>
                    </div>
                    <div class="inputbox">
                        <i class="fa-regular fa-eye" id="check-password" style="cursor: pointer;"></i>
                        <input type="password" name ="CFpassword" id="pass" required>
                        <label for="">Confirm Password</label>
                    </div>
                    <button type="submit" name="submitBtn" class="btn">Save</button>
                    <button type="reset" class="btn" onclick="resetProfilePicture()">Reset</button>
                    <?php else: ?>
                        <!-- Handle the case where $row is not set (user not found) -->
                        User not found!
                        <?php endif; ?>             
                    </form>
                    <form action="deactivate_account.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $row['userid']; ?>">
                        <button type="submit" name="deactivateBtn" class="btn deactivate-btn" onclick="return confirm('Are you sure you want to Deactivated this account?');">Deactivate Account</button>
                    </form>
            </div>
        </div>
    </section>
<script>
        function show(input){
            if (input.files){
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('profile_pic').setAttribute("src",e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function resetProfilePicture() {
            var profilePic = document.getElementById('profile_pic');
            var defaultSrc = '<?php echo $row['userpic'] ?>'; // Default image source

            // Reset the profile picture to its default state
            profilePic.src = defaultSrc;

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
</body>
</html>
