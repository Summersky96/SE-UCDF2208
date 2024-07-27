<?php
session_start();
include('conn.php');

if (!isset($_SESSION['role'])) {
    echo '<script>alert("Please Log In!");window.location.href="loginpage1.php";</script>'; 
    exit();
}

switch ($_SESSION['role']) {
    case 'admin':
        include('adminnav.php');
        break;
    case 'mechanic':
        include('mecnavbar.php');
        break;
    case 'customer':
    default:
        include('navbar.php');
        break;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    body{
        /* overflow: hidden; */
        font-family: Arial, sans-serif;
        background-image: linear-gradient(to right,#141414, #1B1B1B, #333333,  #3d3d3d,#3d3d3d, #333333, #1B1B1B, #141414);
        margin: 0;
        padding: 0;
        transition: all .2s ease;
    }
    section{
        position: relative;
        top: 13%;
        padding: 2px 200px;
        background: hsla(180,0%,10%,0.7);
    }
    section .content{
        padding-top: 2px;
        /* color: #000; */
        transition: all .2s ease;
    }
    body.dark-mode section .content{
        color: #fff;
    }
    /* @media (max-width: 1040px){
            section{
                padding: 100px 20px;
            }
    } */
    .content{
        color: #fff;
        width: 69%;
    }
    .content h1{
            font-size: 4em;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 5px;
            line-height: 75px;
            margin: 40px auto;
            margin-top: 0;
        }   
    .content p{
            margin-bottom: 65px;
            font-size: 20px;
            font-weight: 60;
            text-align: justify;
        }
    .content p2{
            margin-bottom: 65px;
            /* font-size: 20px;
            font-weight: 60; */
            text-align: justify;
            position: absolute;
            right: 15%;
            top: 60%;
        }
    .content p3{
        margin-left: auto;
        margin-right: auto;
            /* font-size: 20px; */
            font-weight: 60;
            text-align: justify;
            font-size: 20px;
        }
    .content p3 i{
        padding: 5px;
    }
    .content p3 h2{
        padding-bottom: 15px;
        text-align: center;
    }
    @media (max-width: 560px){
        .main-content .content h1{
            font-size: 3em;
            line-height: 60px;
        }
    }
    .video-slide{
        position: absolute;
        right: 0;
        bottom: 0;
        z-index: -1;
    }
    @media (min-aspect-ratio: 16/9){
        .video-slide{
            width: 100%;
            height: auto;
        }
    }
    @media (max-aspect-ratio: 16/9){
        .video-slide{
            width: auto;
            height: 100%;
        }
    }
    .video-slide{
            position: absolute;
            right: 0;
            bottom: 0;
            z-index: -1;
        }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<video class="video-slide" src="pfpvid.mp4" autoplay muted loop></video>

<section>
    <div class="content">
        <h1>About Us</h1>
        <p>Welcome to AutoMate, where maintenance meets excellence. At AutoMate, we are dedicated to restoring your vehicle to its prime condition. Our skilled technicians employ the latest techniques and high-quality parts to ensure every repair and service transforms your car to be as good as new. Whether it's routine maintenance or complex repairs, trust AutoMate to deliver superior service and unmatched quality. Join our family of satisfied customers and experience the AutoMate difference today.</p>
        <p3>
        <h2>Members:</h2>
        <i class="fa-solid fa-laptop"></i> Chong Jinn Xiang TP070890<br>
        <i class="fa-solid fa-cat"></i> Bryan Low Zhern Yang TP070347<br>
        <i class="fa-solid fa-coffee"></i> Edward Chia Jing Liang TP070360<br>
        <i class="fa-solid fa-volleyball"></i> Clement Tang Bing Jian TP069715<br>
        <i class="fa-solid fa-ice-cream"></i> Lee Zhi Xiang TP071489
        </p3>
    </div>
</section>

<?php include('footer.php'); ?>
    
</body>
</html>