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
                <h2 class="main-title">Road Side Assistance</h2>
                <div class="contents">
                    <div class="image">
                        <img src="towing1.png" alt="Car Service Image">
                    </div>
                    <div class="text-box">
                        <h3>Reach destination ASAP</h3>
                        <p>Our certified technicians provide high-quality maintenance services to ensure your vehicle runs smoothly. From oil changes to tire rotations, we cover all aspects of car maintenance.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="sec-02">
            <div class="container">
                <h3 class="section-title">Help Transport Cars</h3>
                <div class="contents">
                    <div class="image">
                        <img src="towing.png" alt="Inspection Image">
                    </div>
                    <div class="info">
                        <h4 class="info-title">Car Will Be Transported To Destination</h4>
                        <p>
                            We offer comprehensive vehicle inspections to identify and address potential issues before they become major problems. Our detailed inspection reports help you stay informed about the health of your car.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="sec-04">
            <div class="container">
                <h3 class="section-title">Customer Testimonials</h3>
                <div class="testimonials">
                    <div class="testimonial">
                        <p><i class="fas fa-quote-left"></i> Amazing job with my car's audio system! The sound quality is incredible, and the installation was flawless. Highly recommend their services! <i class="fas fa-quote-right"></i></p>
                        <p class="author">- Joe</p>
                    </div>
                    <div class="testimonial">
                        <p><i class="fas fa-quote-left"></i> I couldn't be happier with the custom audio setup they designed for my car. It's exactly what I wanted, and the team was professional throughout the process. <i class="fas fa-quote-right"></i></p>
                        <p class="author">- Brian</p>
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
