<?php
session_start();
include("conn.php");

// Check for existing cookies and initialize variables
$emailid = isset($_COOKIE['emailid']) ? $_COOKIE['emailid'] : "";
$password = isset($_COOKIE['password']) ? $_COOKIE['password'] : "";

if (isset($_POST['loginbtn'])) {
    // Retrieve user input
    $email = $_POST['email'];
    $user_password = $_POST['user_password'];

    // Query for customers
    $userSql = "SELECT * FROM userinfo WHERE email='$email' AND user_password='$user_password'";
    $userResult = mysqli_query($con, $userSql);
    $userRowcount = mysqli_num_rows($userResult);

    // Query for admins
    $adminSql = "SELECT * FROM admininfo WHERE adminemail='$email' AND adminpassword='$user_password'";
    $adminResult = mysqli_query($con, $adminSql);
    $adminRowcount = mysqli_num_rows($adminResult);

    // Query for mechanics
    $mecSql = "SELECT * FROM mechanicinfo WHERE email='$email' AND mecpassword='$user_password'";
    $mecResult = mysqli_query($con, $mecSql);
    $mecRowcount = mysqli_num_rows($mecResult);

    if ($userRowcount == 1) {
        // Customer login
        $userRow = mysqli_fetch_array($userResult);
        $_SESSION["userid"] = $userRow["userid"];
        $_SESSION["role"] = "customer";
    } elseif ($adminRowcount == 1) {
        // Admin login
        $adminRow = mysqli_fetch_array($adminResult);
        $_SESSION["adminid"] = $adminRow["adminid"];
        $_SESSION["role"] = "admin";
    } elseif ($mecRowcount == 1) {
        // Mechanic login
        $mecRow = mysqli_fetch_array($mecResult);
        $_SESSION["mecid"] = $mecRow["mecid"];
        $_SESSION["role"] = "mechanic";
    } else {
        // Invalid login
        echo "<script>alert('Wrong email/password! If you do not have an account, please SIGN UP!');</script>";
    }

    // Update user status and set cookies
    if (isset($_SESSION["userid"])) {
        $status = "Active now";
        $sql2 = mysqli_query($con, "UPDATE userinfo SET status = '{$status}' WHERE userid = {$_SESSION["userid"]}");
    } elseif (isset($_SESSION["adminid"])) {
        $status = "Active now";
        $sql2 = mysqli_query($con, "UPDATE admininfo SET status = '{$status}' WHERE adminid = {$_SESSION["adminid"]}");
    } elseif (isset($_SESSION["mecid"])) {
        $status = "Active now";
        $sql2 = mysqli_query($con, "UPDATE mechanicinfo SET status = '{$status}' WHERE mecid = {$_SESSION["mecid"]}");
    }

    // Handle "Remember Me" functionality
    if (isset($_REQUEST['rememberMe'])) {
        setcookie('emailid', $_REQUEST['email'], time() + 3600); // 1 hour
        setcookie('password', $_REQUEST['user_password'], time() + 3600); // 1 hour
    } else {
        setcookie('emailid', $_REQUEST['email'], time() - 10); // Expire cookie
        setcookie('password', $_REQUEST['user_password'], time() - 10); // Expire cookie
    }

    // Redirect users based on their role
    if (isset($_SESSION["userid"])) {
        echo '<script>alert("Welcome Customer!"); window.location.href="mainpage.php";</script>';
        exit();
    } elseif (isset($_SESSION["adminid"])) {
        echo '<script>alert("Welcome Admin!"); window.location.href="adminmain.php";</script>';
        exit();
    } elseif (isset($_SESSION["mecid"])) {
        echo '<script>alert("Welcome Mechanic!"); window.location.href="mecmain.php";</script>';
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nav</title>
    <style>
        :root {
            --background-color: #f8f9fa;
            --text-color: #fff;
        }

        .dark-mode {
            --background-color: #343434;
            --text-color: #fff;
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            transition: all ease 0.3s;
        }
        .navbar .mode-toggle i{
            font-size: 30px;
            height: 50px;
            min-width: 50px;
            text-align: center;
            line-height: 50px;
            cursor: pointer;
        }

        .mode-toggle i{
            transition: all 0.3s ease;
        }

        .navbar .mode-toggle i.light{
            position: absolute;
            font-size: 35px;
            /* opacity: 1; */
        }
        .navbar .mode-toggle i.dark{
            /* opacity: 1; */
            transform: translate(50%, -50%) rotate(360deg);
            font-size: 15px;
        }

        .navbar .mode-toggle.active i.light{
            /* opacity: 1; */
            transform: translate(35%, -35%) rotate(180deg);
            font-size: 20px;
        }
        .navbar .mode-toggle.active i.dark{
            /* opacity: 1; */
            position: relative;
            transform: rotate(360deg);
            font-size: 30px;
        }

        .navbar .link .submenu{
            right: 10%;
        }
        #progress {
            position: fixed;
            bottom: 20px;
            right: 10px;
            height: 70px;
            width: 70px;
            display: none;
            place-items: center;
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            z-index: 999;
        }
        #progress-value {
            display: block;
            height: calc(100% - 15px);
            width: calc(100% - 15px);
            background-color: #ffffff;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: 35px;
            color: #001a2e;
            /* z-index: 999; */
        }
    </style>
    <!-- Google Fonts Link For Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Freeman&family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">    <link rel="stylesheet" href="login1.css">
    <script src="login.js" defer></script>
</head>
<body class="<?php echo isset($_COOKIE['mode']) && $_COOKIE['mode'] === 'dark' ? 'dark-mode' : ''; ?>">
    <div id="progress">
      <span id="progress-value"><i class="fa-solid fa-arrow-up"></i></span>
    </div>
    <header>
        <nav class="navbar">
            <span class="hamburger-btn material-symbols-rounded">menu</span>
            <a href="#" class="logo">
                <img src="carlogo.png" alt="logo">
                <h2>AutoMate</h2>
            </a>
            <ul class="links">
                <span class="close-btn material-symbols-rounded">close</span>
                <li><a href="loginpage1.php" class="active">Home</a></li>
                
                <li><a href="#about">About us</a></li>
                
                <li><a href="#maintainance">Maintainance <i class="fa-solid fa-caret-down"></i></a>
                <ul class="submenu">
                    <li><a href="#">Car Services</a></li>
                    <li><a href="#">Car Battery</a></li>
                    <li><a href="#">Engines</a></li>
                    <li><a href="#">Tyres</a></li>
                    <li><a href="#">Air Conds</a></li>
                    <li><a href="#">Audio</a></li>
                    <li><a href="#">Modification</a></li>
                </ul>
            </li>
            
                <li><a href="#booking">Booking <i class="fa-solid fa-caret-down"></i></a>
                <ul class="submenu">
                    <li><a href="add_booking.php">Add Booking</a></li>
                    <li><a href="display_bookings.php">View Booking</a></li>
                </ul>
            </li>
            
                <li><a href="#forum">Community <i class="fa-solid fa-caret-down"></i></a>
                <ul class="submenu">
                    <li><a href="#">Chat</a></li>
                    <li><a href="#">Chatbot</a></li>
                </ul>
            </li>

            </ul>
            <button class="login-btn">LOG IN</button>
            <ul class="link">
                <li><a href="#"><i class="fa-solid fa-bell"></i></a></li>
                <span class="mode-toggle">
                    <i class="bx bxs-sun light"></i>
                    <i class="bx bxs-moon dark"></i>
                </span>
            </ul>
        </nav>
    </header>
    <section id="home" class="showanimate">
        <img class="garage" src="garage.jpg" alt="garage" style="z-index: -5;" >
        <img class="fixing" src="fixing.png" alt="#">
        <div class="content home">
            <h1>Where <span>Maintenance</span></h1>
            <h3>Meets <span>Excellence!</span></h3>
            <a href="#about">Read More</a>
        </div>
    </section>

    <section class="about container" id="about">
        <div class="aboutus one" style="--i:0;">
            <div class="about-img">
                <img src="me.png" alt="">
            </div>
            <div class="about-text">
                <span style="--i:1;">About Us</span>
                <h2 style="--i:2;">Where Maintenance Meets Excellences</h2>
                <p style="--i:3;">Our dedication to excellence extends beyond our technical capabilities. We pride ourselves on building long-lasting relationships with our customers through transparency, integrity, and personalized attention. When you choose AutoMate, you can expect clear communication, honest recommendations, and a commitment to delivering the best possible results.</p>
                <a href="aboutus.php">Learn More</a>
            </div>
        </div>

        <div class="aboutus two" style="--i:1;">
            <div class="about-text">
                <span style="--i:4;">Car Services</span>
                <h2 style="--i:5;">Making Your Cars As New As Ever</h2>
                <p style="--i:6;">We offer a comprehensive range of professional and well-maintained automotive repair services for cars, lorries, vans, and SUVs. Additionally, we provide on-site services from Bukit Jalil to Sri Kembangan and Cheras. Contact us for more information!</p>
                <a href="#">Learn More</a>
            </div>
            <div class="about-img">
                <img src="carservice.png" alt="">
            </div>
        </div>

        <div class="aboutus thr" style="--i:2;">
            <div class="about-img">
                <img src="carbattery.png" alt="">
            </div>
            <div class="about-text">
                <span style="--i:7;">Car Battery</span>
                <h2 style="--i:8;">On The Spot Changing Services</h2>
                <p style="--i:9;">If your car, sedan, SUV, van, or lorry experiences a battery breakdown or fails to start, leaving you stranded in an inconvenient location, there's no need to worry! Our reliable team is ready to assist you wherever you are. Whether you're stuck in the middle of nowhere or in a busy area, we are equipped to provide the help you need to get back on the road safely and quickly.</p>
                <a href="#">Learn More</a>
            </div>
        </div>

        <div class="aboutus fou" style="--i:3;">
            <div class="about-text">
                <span style="--i:10;">Emergency</span>
                <h2 style="--i:11;">24 Hours On Call</h2>
                <p style="--i:12;">Available 24 hours a day, AutoMate offers comprehensive support for your vehicle needs, including battery repairs, delivery, and installation, as well as the replacement of faulty parts. Our fees include on-site service, labor, and the cost of parts, ensuring you receive reliable assistance whenever you need it.</p>
                <a href="#">Learn More</a>
            </div>
            <div class="about-img">
                <img src="emergency.png" alt="">
            </div>
        </div>

        <div class="aboutus fiv" style="--i:4;">
            <div class="about-img">
                <img src="towing.png" alt="">
            </div>
            <div class="about-text">
                <span style="--i:13;">Road Side Assistance</span>
                <h2 style="--i:14;">Will Reach As Soon As Possible</h2>
                <p style="--i:15;">AutoMate can assist you by dispatching a car mechanic for inspections and minor on-site services. Common issues we address include battery breakdowns, flat tires, disconnected sensors, and malfunctioning vehicle parts.</p>
                <a href="#">Learn More</a>
            </div>
        </div>

    </section>
    
    <section id="maintainance">
        <span>AutoMate Services</span>
        <h2>A team of professionals mechanics</h2>
        <div class="slider">
            <div class="list">
                <div class="item">
                    <img src="slider1.png" alt="">
                </div>
                <div class="item">
                    <img src="slider2.png" alt="">
                </div>
                <div class="item">
                    <img src="slider3.png" alt="">
                </div>
                <div class="item">
                    <img src="slider4.png" alt="">
                </div>
                <div class="item">
                    <img src="slider5.png" alt="">
                </div>
            </div>
            <div class="buttons">
                <button id="prev"><</button>
                <button id="next">></button>
            </div>
            <ul class="dots">
                <li class="active"></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>
    </section>

    <section id="booking">
        <div class="heading">
            <span>Services Booking</span>
            <h2>We have all types of Services</h2>
            <h2 style="font-size:30px">Book Your Services now</h2>
        </div>
        <div class="service container">
            <div class="box" style="--i:0;">
                <a href="add_booking.php?service=Car%20Service">
                    <img src="carservice.png" alt="carservice">
                    <h2>Car Service</h2>
                </a>
            </div>
        
            <div class="box" style="--i:1;">
                <a href="add_booking.php?service=Car%20Battery">
                    <img src="carbattery.png" alt="battery">
                    <h2>Car Battery</h2>
                </a>
            </div>
        
            <div class="box" style="--i:2;">
                <a href="add_booking.php?service=Engines">
                    <img src="engine.jpg" alt="Engines">
                    <h2>Engines</h2>
                </a>
            </div>
            
            <div class="box" style="--i:3;">
                <a href="add_booking.php?service=Tyres">
                    <img src="tyres.jpg" alt="Tyres">
                    <h2>Tyres</h2>
                </a>
            </div>
            
            <div class="box" style="--i:4;">
                <a href="add_booking.php?service=Air%20Conds">
                    <img src="ac.jpg" alt="Air Conditioners">
                    <h2>Air Conds</h2>
                </a>
            </div>
            
            <div class="box" style="--i:5;">
                <a href="add_booking.php?service=Audio">
                    <img src="speakers.jpg" alt="Audio">
                    <h2>Audio</h2>
                </a>
            </div>
            
            <div class="box" style="--i:6;">
                <a href="add_booking.php?service=Modification">
                    <img src="wraping.jpg" alt="Modification">
                    <h2>Modification</h2>
                </a>
            </div>
            
            <div class="box" style="--i:7;">
                <a href="add_booking.php?service=Maintenance">
                    <img src="service.jpg" alt="Maintenance">
                    <h2>Maintenance</h2>
                </a>
            </div>
        </div>
    </section>


    <section id="forum">
        <div class="fcontainer">
            <div class="contetnt">
                <h1>Community <a href="#"><i class="fa-regular fa-comment-dots"></i></a></h1>
                <p>Connect with our customers all around the globe.</p>
            </div>
        </div>
    </section>
    
    <?php include('footer.php') ?>

    <div class="blur-bg-overlay"></div>
    <div class="form-popup">
        <span class="close-btn material-symbols-rounded">close</span>
        <div class="form-details">
            <h2 class="logo">Automate</h2>
            
            <div class="text-sci">
                <h2>Welcome!<br><span>To our Page.</span></h2>
                <p>BLABLABLABLABLABLABLA</p>

                <div class="social-icon">
                    <a href="#"><i class='bx bxl-linkedin'></i></a>
                    <a href="#"><i class='bx bxl-facebook'></i></a>
                    <a href="#"><i class='bx bxl-instagram'></i></a>
                    <a href="#"><i class='bx bxl-twitter'></i></a>
                </div>
            </div>
        </div>
        <div class="logreg-box">
            <div class="form-box login">
                <form method="post">
                    <h2>Login</h2>

                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-envelope'></i></span>
                        <input type="email" name="email" required value="<?php echo $emailid; ?>">
                        <label>Email</label>
                    </div>
                    
                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-eye" id="showpass"></i></span>
                        <input type="password" name="user_password" id="pass" required value="<?php echo $password; ?>">
                        <label>Password</label>
                    </div>

                    <div class="remember-forgot">
                        <label for="rememberMe"><input type="checkbox" name="rememberMe">Remember me</label>
                        <a href="forgot.php" class="forgot-link">Forgot Password </a>
                    </div>

                    <button type="submit" class="btn" name="loginbtn">Login</button>

                    <div class="login-register">
                        <p>Don't have an account? <a href="#" class="register-link">Sign Up</a></p>
                    </div>
                </form>
            </div>

            
            <div class="form-box register">
                <form action="insert.php" method="post">
                    <h2>Sign Up</h2>
                    
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-user'></i></span>
                        <input type="name" name="username" required>
                        <label>Name</label>
                    </div>

                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-envelope'></i></span>
                        <input type="email" name="email" required>
                        <label>Email</label>
                    </div>
                    
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-phone'></i></span>
                        <input type="tel" name="telephone" required>
                        <label>Telephone</label>
                    </div>
                    
                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-eye" id="show-password"></i></span>
                        <input type="password" name="user_password" id="password" required>
                        <label>Password</label>
                    </div>
                    
                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-eye" id="show-pass"></i></span>
                        <input type="password" name ="CFpassword" id="passcode" required>
                        <label>Confirm Password</label>
                    </div>
                    
                    <button type="submit" name="submitbtn" class="btn">Sign Up</button>
                    
                    <div class="login-register">
                        <p>Already have an account? <a href="#" class="login-link">Login</a></p>
                    </div>
                </form>
                </div>

            <div class="form-box reset">
                <form action="#" method="post">
                    <h2>Reset Password</h2>
        
                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-eye" id="lookpass"></i></span>
                        <input type="password" id="pword" required>
                        <label>Password</label>
                    </div>
                        
                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-eye" id="sawpass"></i></span>
                        <input type="password" id="psw" required>
                        <label>Confirm Password</label>
                    </div>
        
                    <button type="submit" class="btn">Done</button>
        
                    <div class="login-register">
                        <p><a href="#" class="backlink">Back</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const sliderWrapper = document.querySelector('.slider');
        const sliderList = document.querySelector('.slider .list');
        const items = document.querySelectorAll('.slider .list .item');
        const next = document.getElementById('next');
        const prev = document.getElementById('prev');
        const dots = document.querySelectorAll('.slider .dots li');

        const lengthItems = items.length - 1;
        let active = 0;

        next.onclick = function() {
            active = active + 1 <= lengthItems ? active + 1 : 0;
            reloadSlider();
        }

        prev.onclick = function() {
            active = active - 1 >= 0 ? active - 1 : lengthItems;
            reloadSlider();
        }

        let refreshInterval = setInterval(() => { next.click() }, 3000);

        function reloadSlider() {
            sliderList.style.left = -items[active].offsetLeft + 'px';

            const lastActiveDot = document.querySelector('.slider .dots li.active');
            lastActiveDot.classList.remove('active');
            dots[active].classList.add('active');

            clearInterval(refreshInterval);
            refreshInterval = setInterval(() => { next.click() }, 3000);
        }

        dots.forEach((dot, key) => {
            dot.addEventListener('click', () => {
                active = key;
                reloadSlider();
            });
        });

        window.onresize = function(event) {
            reloadSlider();
        };


        //LIGHT DARK MODE CLASS
        document.addEventListener("DOMContentLoaded", () => {
        const modeToggle = document.querySelector(".mode-toggle");

        // Function to set the initial mode based on the cookie
        function initializeMode() {
            const mode = getCookie("mode");
            if (mode === "dark") {
                document.body.classList.add("dark-mode");
                modeToggle.classList.add("active");
            }
        }

        initializeMode(); // Call the function when the DOM is loaded

        // Function to toggle dark mode
        function toggleDarkMode() {
            document.body.classList.toggle("dark-mode");
            modeToggle.classList.toggle("active");
            const mode = document.body.classList.contains("dark-mode") ? "dark" : "light";
            setCookie("mode", mode, 30); // Set cookie with 30 days expiry
        }

        modeToggle.addEventListener("click", toggleDarkMode);
    });


        //LOGIN REGISTER BOX SWITCH
        const logregBox = document.querySelector('.logreg-box');
        const loginLink = document.querySelector('.login-link');
        const registerLink = document.querySelector('.register-link');
        // const forgotLink = document.querySelector('.forgot-link');
        // const backLink = document.querySelector('.back-link');
        // const bacLink = document.querySelector('.backlink');

        registerLink.addEventListener('click', () => { 
            logregBox.classList.add('active');
        });

        loginLink.addEventListener('click', () => { 
            logregBox.classList.remove('active');
        });

        // PASSWORD VISIBILITY
        const showpass = document.querySelector('#showpass');
        const passField = document.querySelector('#pass');
            showpass.addEventListener('click', function(){
                this.classList.toggle("fa-eye");
                this.classList.toggle("fa-eye-slash", !this.classList.contains("fa-eye"));

                const type = passField.getAttribute("type") === "password" ? "text" : "password";
                passField.setAttribute("type", type);
            })
            
            const showPassword = document.querySelector('#show-password');
            const passwordField = document.querySelector('#password');
            showPassword.addEventListener('click', function() {
                // toggle the eye / eye slash icon
                this.classList.toggle("fa-eye");
                this.classList.toggle("fa-eye-slash", !this.classList.contains("fa-eye"));
                // toggle the type attribute
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
            })
            
            const showPass = document.querySelector('#show-pass');
            const passcodeField = document.querySelector('#passcode');
                showPass.addEventListener('click', function(){
                    this.classList.toggle("fa-eye");
                    this.classList.toggle("fa-eye-slash", !this.classList.contains("fa-eye"));
    
                    const type = passcodeField.getAttribute("type") === "password" ? "text" : "password";
                    passcodeField.setAttribute("type", type);
                })

            const lookPass = document.querySelector('#lookpass');
            const pwordField = document.querySelector('#pword');
                lookPass.addEventListener('click', function(){
                    this.classList.toggle("fa-eye");
                    this.classList.toggle("fa-eye-slash", !this.classList.contains("fa-eye"));
    
                    const type = pwordField.getAttribute("type") === "password" ? "text" : "password";
                    pwordField.setAttribute("type", type);
                })

            const sawPass = document.querySelector('#sawpass');
            const pswField = document.querySelector('#psw');
                sawPass.addEventListener('click', function(){
                    this.classList.toggle("fa-eye");
                    this.classList.toggle("fa-eye-slash", !this.classList.contains("fa-eye"));
    
                    const type = pswField.getAttribute("type") === "password" ? "text" : "password";
                    pswField.setAttribute("type", type);
                })

            //SCROLL BACK TO TOP 
            let calcScrollValue = () => {
                let scrollProgress = document.getElementById("progress");
                let progressValue = document.getElementById("progress-value");
                let pos = document.documentElement.scrollTop;
                let calcHeight =
                    document.documentElement.scrollHeight -
                    document.documentElement.clientHeight;
                let scrollValue = Math.round((pos * 100) / calcHeight);
                if (pos > 100) {
                    scrollProgress.style.display = "grid";
                } else {
                    scrollProgress.style.display = "none";
                }
                scrollProgress.addEventListener("click", () => {
                    document.documentElement.scrollTop = 0;
                });
                scrollProgress.style.background = `conic-gradient(#ffd000 ${scrollValue}%, #d7d7d7 ${scrollValue}%)`;

            // SCROLL SECTION
                let sections = document.querySelectorAll("section");
                let navLinks = document.querySelectorAll("header nav a");
                sections.forEach((sec) => {
                    let top = window.scrollY;
                    let offset = sec.offsetTop - 150;
                    let height = sec.offsetHeight;

                    if (top >= offset && top < offset + height) {
                        sec.classList.add("showanimate");
                        navLinks.forEach((links) => {
                            links.classList.remove("active");
                            document
                            .querySelector(`header nav a[href*=${sec.getAttribute("id")}]`)
                            .classList.add("active");
                        });
                    } else {
                        sec.classList.remove("showanimate");
                    }
                });
            };

            // Function to set a cookie
            function setCookie(name, value, days) {
                var expires = "";
                if (days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    expires = "; expires=" + date.toUTCString();
                }
                document.cookie = name + "=" + (value || "") + expires + "; path=/";
            }

            // Function to get a cookie
            function getCookie(name) {
                var nameEQ = name + "=";
                var ca = document.cookie.split(';');
                for (var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) === ' ') {
                        c = c.substring(1, c.length);
                    }
                    if (c.indexOf(nameEQ) === 0) {
                        return c.substring(nameEQ.length, c.length);
                    }
                }
                return null;
            }

            


        window.onscroll = calcScrollValue;
        window.onload = calcScrollValue;
        </script>
</body>
</html>