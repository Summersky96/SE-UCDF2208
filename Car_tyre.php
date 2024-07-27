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
    <title>Car Tyre Services</title>
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
                <h2 class="main-title">Car Tyre Services</h2>
                <div class="contents">
                    <div class="image">
                        <img src="tyres.jpg" alt="Car Tyre Service">
                    </div>
                    <div class="text-box">
                        <h3>Tyre Replacement & Maintenance</h3>
                        <p>Ensure your safety on the road with our tyre replacement and maintenance services. We offer high-quality tyres and professional fitting and balancing.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="sec-02">
            <div class="container">
                <h3 class="section-title">Tyre Alignment</h3>
                <div class="contents">
                    <div class="image">
                        <img src="https://www.carsome.my/news/wp-content/uploads/wp/GettyImages-529003347.jpg" alt="Tyre Alignment">
                    </div>
                    <div class="info">
                        <h4 class="info-title">Description</h4>
                        <p>Maintain even tyre wear and ensure a smooth ride with our professional tyre alignment services.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="sec-03">
            <div class="container">
                <h3 class="section-title">Tyre Rotation</h3>
                <div class="contents">
                    <div class="image">
                        <img src="https://adzktgbqdq.cloudimg.io/https://dgaddcosprod.blob.core.windows.net/cxf-multisite/clsnd2leu002711ow8tgx7mfc/attachments/cl34g7h360hka01hqyy5jzu8c-adobestock-414551736.full.jpg" alt="Tyre Rotation">
                    </div>
                    <div class="info">
                        <h4 class="info-title">Description</h4>
                        <p>Extend the life of your tyres by having them rotated regularly. Our experts ensure that your tyres wear evenly for better performance and safety.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include('footer.php') ?>
    <script src="tet.js"></script>
</body>
</html>
