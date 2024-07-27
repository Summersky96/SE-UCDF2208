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
    <title>Car Air Conditioner Services</title>
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
                <h2 class="main-title">Car Air Conditioner Services</h2>
                <div class="contents">
                    <div class="image">
                        <img src="ac.jpg" alt="Car Air Conditioner Service">
                    </div>
                    <div class="text-box">
                        <h3>AC Maintenance & Repair</h3>
                        <p>Stay cool with our air conditioner maintenance and repair services. We ensure your AC is in top condition, providing efficient cooling during the hottest days.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="sec-02">
            <div class="container">
                <h3 class="section-title">AC Diagnostics</h3>
                <div class="contents">
                    <div class="image">
                        <img src="https://www.shutterstock.com/shutterstock/videos/3461262969/thumb/1.jpg?ip=x480" alt="AC Diagnostics">
                    </div>
                    <div class="info">
                        <h4 class="info-title">Description</h4>
                        <p>Our diagnostic services can quickly identify any issues with your car's air conditioning system, allowing us to provide targeted repairs. Using state-of-the-art equipment, we can detect leaks, measure refrigerant levels, and check for electrical faults to ensure your AC system is running efficiently.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="sec-03">
            <div class="container">
                <h3 class="section-title">AC Recharging</h3>
                <div class="contents reverse-layout">
                    <div class="image">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcShcdzH_Qpch4yalSP0TluPzWyGeslUhmfsnQ&s" alt="AC Recharging">
                    </div>
                    <div class="info">
                        <h4 class="info-title">Description</h4>
                        <p>Ensure your car's air conditioner is fully charged and operating at peak efficiency with our AC recharging services. We use high-quality refrigerants and follow industry standards to recharge your AC system, ensuring optimal cooling performance and preventing potential damage caused by low refrigerant levels.</p>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="sec-04">
            <div class="container">
                <h3 class="section-title">Customer Testimonials</h3>
                <div class="testimonials">
                    <div class="testimonial">
                        <p><i class="fas fa-quote-left"></i> The AC service was top-notch! My car's air conditioning has never worked better. Highly recommend! <i class="fas fa-quote-right"></i></p>
                        <p class="author">- Steeve</p>
                    </div>
                    <div class="testimonial">
                        <p><i class="fas fa-quote-left"></i> Quick and efficient service. The diagnostics were spot on, and the repairs were done on the same day. <i class="fas fa-quote-right"></i></p>
                        <p class="author">- Steeve</p>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- <section class="sec-05">
            <div class="container">
                <h3 class="section-title">Contact Us</h3>
                <form class="contact-form" action="submit_form.php" method="POST">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="4" required></textarea>
                    </div>
                    <button type="submit">Submit</button>
                </form>
            </div>
        </section> -->
    </section>
    <?php include('footer.php') ?>

    <script src="tet.js"></script>
</body>
</html>
