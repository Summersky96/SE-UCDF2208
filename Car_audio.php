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
    <title>Car Audio Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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
                <h2 class="main-title">Car Audio Services</h2>
                <div class="contents">
                    <div class="image">
                        <img src="speakers.jpg" alt="Car Audio Service">
                    </div>
                    <div class="text-box">
                        <h3>Audio System Installation & Repair</h3>
                        <p>Enhance your driving experience with our audio system installation and repair services. We offer top-of-the-line audio systems and expert installation.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="sec-02">
            <div class="container">
                <h3 class="section-title">Speaker Upgrades</h3>
                <div class="contents">
                    <div class="image">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSgGB6apaZh6ANL0839LX0sa2h_wesDphybPNgIlJ2ksmXsqCXVjbE1sKFuZMGeWG6x6TY&usqp=CAU" alt="Speaker Upgrades">
                    </div>
                    <div class="info">
                        <h4 class="info-title">Description</h4>
                        <p>Upgrade your car's audio system with high-quality speakers that deliver crystal-clear sound and deep bass. Whether you're a music enthusiast or looking for a better audio experience on the road, our speaker upgrades will transform your car's sound system.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="sec-03">
            <div class="container">
                <h3 class="section-title">Custom Audio Solutions</h3>
                <div class="contents">
                    <div class="image">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTrkt1az5e0lE46CGY3Vz7s9ZcurhLaGs2d2w&s" alt="Custom Audio Solutions">
                    </div>
                    <div class="info">
                        <h4 class="info-title">Description</h4>
                        <p>Get a custom audio setup tailored to your specific needs and preferences. Our experts design and install unique solutions for an unparalleled audio experience. Whether it's integrating multiple amplifiers, installing custom subwoofers, or creating a seamless audio environment, we ensure every detail matches your expectations.</p>
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
                        <p class="author">- Steeve</p>
                    </div>
                    <div class="testimonial">
                        <p><i class="fas fa-quote-left"></i> I couldn't be happier with the custom audio setup they designed for my car. It's exactly what I wanted, and the team was professional throughout the process. <i class="fas fa-quote-right"></i></p>
                        <p class="author">- Bryan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include('footer.php') ?>


    <script src="tet.js"></script>
</body>
</html>
