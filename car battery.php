<?php
session_start();
include_once "conn.php"; // Ensure this file includes your database connection ($con)

// Check if the user is logged in and the role is set
if (!isset($_SESSION['role'])) {
    echo '<script>alert("Please Log In!");window.location.href="loginpage1.php";</script>'; 
    exit();
}


// Include the correct navbar based on the user's role
switch ($_SESSION['role']) {
    case 'admin':
        include_once('adminnav.php');
        break;
    case 'mechanic':
        include_once('mecnavbar.php');
        break;
    case 'customer':
    default:
        include_once('navbar.php');
        break;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Battery Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="" >
    <link rel="stylesheet" href="tet.css">
    <script src="https://unpkg.com/scrollreveal"></script>
    <style>
        section{
            margin-top: 6%;
            display: block;
        }
    </style>
</head>
<body>
    <section>
        <div class="sec-01">
            <div class="container">
                <h2 class="main-title">Car Battery Services</h2>
                <div class="contents">
                    <div class="image">
                        <img src="carbattery.png" alt="Car Battery Service">
                    </div>
                    <div class="text-box">
                        <h3>Battery Testing & Replacement</h3>
                        <p>Ensure your car starts every time with our comprehensive battery testing and replacement services. Our experts will check your battery's health and replace it with a top-quality new one if needed.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="sec-02">
            <div class="container">
                <h3 class="section-title">Battery Maintenance</h3>
                <div class="contents">
                    <div class="image">
                        <img src="https://www.carfitexperts.com/wp-content/uploads/2022/09/Image-39.jpg" alt="Battery Maintenance">
                    </div>
                    <div class="info">
                        <h4 class="info-title">Description</h4>
                        <p>
                            Regular maintenance can extend the life of your car battery. We provide cleaning and inspection services to ensure your battery terminals and connections are free of corrosion and functioning correctly.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="sec-03">
            <div class="container">
                <h3 class="section-title">Our Services</h3>
                <div class="contents">
                    <div class="sec-info">
                        <li><a>Battery Testing</a></li>
                        <li><a>Battery Replacement</a></li>
                        <li><a>Battery Charging</a></li>
                        <li><a>Terminal Cleaning</a></li>
                        <li><a>Corrosion Prevention</a></li>
                    </div>
                    <div class="image">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSiibffnUuIFaFHp9CYVetSDdNtLEN84KhPtg&s" alt="Our Services">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include('footer.php') ?>


    <script src="tet.js"></script>
</body>


</html>
