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
    <title>Car Modification Services</title>
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
                <h2 class="main-title">Car Modification Services</h2>
                <div class="contents">
                    <div class="image">
                        <img src="https://img77.uenicdn.com/image/upload/v1537285028/service_images/shutterstock_57754528.jpg" alt="Car Modification Service">
                    </div>
                    <div class="text-box">
                        <h3>Custom Modifications & Upgrades</h3>
                        <p>Transform your car with our custom modification and upgrade services. Our experts will help you achieve the perfect look and performance for your vehicle.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="sec-02">
            <div class="container">
                <h3 class="section-title">Performance Enhancements</h3>
                <div class="contents">
                    <div class="image">
                        <img src="tinted.jpg" alt="Performance Enhancements">
                    </div>
                    <div class="info">
                        <h4 class="info-title">Description</h4>
                        <p>Boost your car's performance with our range of enhancements, including turbocharging, exhaust systems, and suspension upgrades.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="sec-03">
            <div class="container">
                <h3 class="section-title">Interior & Exterior Customization</h3>
                <div class="contents">
                    <div class="image">
                        <img src="wraping.jpg" alt="Interior & Exterior Customization">
                    </div>
                    <div class="info">
                        <h4 class="info-title">Description</h4>
                        <p>Personalize your car with our interior and exterior customization options, from custom paint jobs to bespoke interiors.</p>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="sec-04">
            <div class="container">
                <h3 class="section-title">Customer Testimonials</h3>
                <div class="testimonials">
                    <div class="testimonial">
                        <p><i class="fas fa-quote-left"></i> The team transformed my car into a work of art! Every detail was executed perfectly. Highly recommend their customization services! <i class="fas fa-quote-right"></i></p>
                        <p class="author">- Alex Martinez</p>
                    </div>
                    <div class="testimonial">
                        <p><i class="fas fa-quote-left"></i> I got a performance upgrade and the difference is phenomenal. My car runs smoother and faster. Great job! <i class="fas fa-quote-right"></i></p>
                        <p class="author">- Jessica Lee</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include('footer.php') ?>

    <script src="tet.js"></script>
</body>
</html>
