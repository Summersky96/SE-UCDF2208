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
    <title>Car Services</title>
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
                <h2 class="main-title">Car Services</h2>
                <div class="contents">
                    <div class="image">
                        <img src="service.jpg" alt="Car Service Image">
                    </div>
                    <div class="text-box">
                        <h3>Quality Maintenance</h3>
                        <p>Our certified technicians provide high-quality maintenance services to ensure your vehicle runs smoothly. From oil changes to tire rotations, we cover all aspects of car maintenance.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="sec-02">
            <div class="container">
                <h3 class="section-title">Detailed Inspections</h3>
                <div class="contents">
                    <div class="image">
                        <img src="https://autoimage.capitalone.com/cms/Auto/assets/images/1595-hero-pre-purchase-car-inspection.jpg" alt="Inspection Image">
                    </div>
                    <div class="info">
                        <h4 class="info-title">Description</h4>
                        <p>
                            We offer comprehensive vehicle inspections to identify and address potential issues before they become major problems. Our detailed inspection reports help you stay informed about the health of your car.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="sec-03">
            <div class="container">
                <h3 class="section-title">Additional Services</h3>
                <div class="contents">
                    <div class="sec-info">
                        <li><a>Brake Services</a></li>
                        <li><a>Engine Diagnostics</a></li>
                        <li><a>Transmission Repairs</a></li>
                        <li><a>Tire Services</a></li>
                        <li><a>Battery Replacement</a></li>
                    </div>
                    <div class="image">
                        <img src="https://media.istockphoto.com/id/1387759698/photo/hand-of-car-mechanic-with-wrench-auto-repair-garage-mechanic-works-on-the-engine-of-the-car.jpg?s=612x612&w=0&k=20&c=JVYyKMvP-NN-bTMyIF-pNrifwvjyjKcIRjTVEmSmPsM=" alt="Additional Services Image">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include('footer.php') ?>

    <script src="tet.js">

    </script>
</body>
</html>
