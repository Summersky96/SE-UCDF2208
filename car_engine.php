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
    <title>Engine Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="tet.css" >
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
                <h2 class="main-title">Engine Services</h2>
                <div class="contents">
                    <div class="image">
                        <img src="engine.jpg" alt="Engine Service">
                    </div>
                    <div class="text-box">
                        <h3>Engine Maintenance & Repair</h3>
                        <p>Keep your engine running smoothly with our comprehensive maintenance and repair services. Our experts will diagnose and fix any issues to ensure optimal performance.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="sec-02">
            <div class="container">
                <h3 class="section-title">Engine Diagnostics</h3>
                <div class="contents">
                    <div class="image">
                        <img src="https://www.sunautoservice.com/wp-content/uploads/2020/01/iStock-892109230-1024x683.jpg" alt="Engine Diagnostics">
                    </div>
                    <div class="info">
                        <h4 class="info-title">Description</h4>
                        <p>Our advanced diagnostic tools help pinpoint engine problems quickly and accurately, allowing us to provide efficient repair solutions.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="sec-03">
            <div class="container">
                <h3 class="section-title">Engine Tune-Up</h3>
                <div class="contents">
                    <div class="image">
                        <img src="https://omegaautocare.com/wp-content/uploads/2023/02/car-tune-up-basics.jpg" alt="Engine Tune-Up">
                    </div>
                    <div class="info">
                        <h4 class="info-title">Description</h4>
                        <p>Maximize your engine's performance with our tune-up services. We'll adjust key components to ensure peak efficiency and power.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include('footer.php') ?>

    <script src="tet.js"></script>
</body>
</html>
