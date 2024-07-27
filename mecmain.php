<?php
include("mecnavbar.php");
include('conn.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="login1.css">
    <link href="https://fonts.googleapis.com/css2?family=Freeman&family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">    
</head>
<style>
    .cart-icon {
            position: absolute;
            top: 30px;
            right: 30px;
            font-size: 2rem;
            cursor: pointer;
            color: #333;
        }
        body.dark-mode .cart-icon{
            color: #fff;
        }
        .cart-modal {
            display: none;
            position: absolute;
            top: 60px;
            right: 20px;
            background: white;
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 300px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            color: #333;
        }
        .cart-modal .cart-header {
            padding: 10px;
            border-bottom: 1px solid #ccc;
            font-weight: 600;
        }
        .cart-modal .cart-body {
            padding: 10px;
        }
        .cart-modal .cart-footer {
            padding: 10px;
            border-top: 1px solid #ccc;
            text-align: right;
        }
        .cart-modal .cart-footer button {
            background-color: #000;
            color: #fff;
            padding: 10px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
        }
        .parts {
            text-align: center;
            padding: 20px;
        }
        .heading {
            margin-bottom: 40px;
        }
        .heading span {
            display: inline-block;
            font-size: 40px;
            font-weight: 500;
            color: #ffe000;
            margin-bottom: 8px;
            position: relative;
        }
        .heading h2 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 16px;
        }
        .heading p {
            font-size: 40px;
            font-weight: 400;
        }
        .partscontainer {
            display: flex;
            flex-wrap: wrap;
            gap: 32px;
            justify-content: center;
            margin-top: 32px;
        }
        .partscontainer .box {
            flex: 1 1 17rem;
            position: relative;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #f9f9f9;
            border-radius: 8px;
            transition: transform 0.3s ease;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        body.dark-mode .partscontainer .box{
            background: #a6a2a2;
        }
        .partscontainer .box:hover {
            transform: scale(1.05);
        }
        .partscontainer .box img {
            width: 100%;
            height: 150px;
            object-fit: contain;
            object-position: center;
            margin-bottom: 16px;
            border-radius: 8px;
        }
        .partscontainer .box h3 {
            font-size: 17.5px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }
        body.dark-mode .partscontainer .box h3{
            color: #e5e6e4;
        }
        .partscontainer .box span {
            font-size: 17.5px;
            font-weight: 600;
            color: #ffe000;
            margin-bottom: 16px;
        }
        .partscontainer .box button {
            max-width: 120px;
            background-color: #000;
            color: #fff;
            padding: 10px;
            text-align: center;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            margin-bottom: 16px;
            transition: background-color 0.3s ease;
        }
        .partscontainer .box button:hover {
            background-color: #ffe000;
            color: #333;
        }
        .partscontainer .box .details {
            font-size: 16px;
            color: black;
            transition: color 0.3s ease;
            text-decoration: none;
        }
        .partscontainer .box .details:hover,
        body.dark-mode .partscontainer .box .details:hover {
            color: #ffe000;
            text-decoration: underline;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .cart-item div {
            display: flex;
            align-items: center;
        }
        .cart-item .item-name {
            margin-right: 10px;
        }
        .cart-item button {
            background-color: #000;
            color: #fff;
            border: none;
            padding: 5px;
            cursor: pointer;
            margin: 0 5px;
        }
        .cart-item button:hover {
            background-color: red;
        }
        .cart-item .remove-btn {
            background-color: red;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .viewmore{
            position: relative;
            background-color: gray;
            padding: 20px;
            font-size: 20px;
            margin-top: 2rem;
            transition: all 0.2s ease;
            width: 30%;
            margin-left: auto;
            margin-right: auto;
            cursor: pointer;
        }
        .viewmore:hover{
            scale: 1.2;
            background-color: #ffe000;
            a{
                color: #333;
            }
        }
        .viewmore a{
            text-decoration: none;
            color: #fff;
        }
</style>
<body>
    <div id="progress">
      <span id="progress-value"><i class="fa-solid fa-arrow-up"></i></span>
    </div>

    <section id="home" class="showanimate">
        <img class="garage" src="garage.jpg" alt="garage" style="z-index: -5;" >
        <img class="fixing" src="fixing.png" alt="#">
        <!-- <div class="shape"></div>
        <div class="shape1"></div>
        <div class="shape2"></div>
        <div class="shape3"></div>
        <div class="shape4"></div>
        <div class="shape5"></div> -->
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
                <a href="tet.php">Learn More</a>
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
                <a href="car battery.php">Learn More</a>
            </div>
        </div>

        <div class="aboutus fou" style="--i:3;">
            <div class="about-text">
                <span style="--i:10;">Emergency</span>
                <h2 style="--i:11;">24 Hours On Call</h2>
                <p style="--i:12;">Available 24 hours a day, AutoMate offers comprehensive support for your vehicle needs, including battery repairs, delivery, and installation, as well as the replacement of faulty parts. Our fees include on-site service, labor, and the cost of parts, ensuring you receive reliable assistance whenever you need it.</p>
                <a href="emergencycall.php">Learn More</a>
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
                <a href="assistance.php">Learn More</a>
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

    <section id="parts">
        <container class="parts" id="parts">
            <div class="heading">
                <span>Order Parts</span>
                <p>Choose the parts to order from manufacturer</p>
            </div>
            <div class="partscontainer">
                <article class="box" data-name="Tyre Rim" data-price="350">
                    <img src="rim.png" alt="Tyre Rim">
                    <h3>Tyre Rim</h3>
                    <span>RM 350</span>
                    <a href="part.php"><button type="button" onclick="addToCart(this)">Order Now</button></a>
                    <!-- <a href="part.php" class="details">View Details</a> -->
                </article>
                <article class="box" data-name="Head Lights" data-price="1000">
                    <img src="headlight.png" alt="Head Lights">
                    <h3>Head Lights</h3>
                    <span>RM 1000</span>
                    <a href="part.php"><button type="button" onclick="addToCart(this)">Order Now</button></a>
                    <!-- <a href="part.php" class="details">View Details</a> -->
                </article>
                <article class="box" data-name="Suspension" data-price="500">
                    <img src="suspension.png" alt="Suspension">
                    <h3>Suspension</h3>
                    <span>RM 500</span>
                    <a href="part.php"><button type="button" onclick="addToCart(this)">Order Now</button></a>
                    <!-- <a href="part.php" class="details">View Details</a> -->
                </article>
                <article class="box" data-name="Engine Air Filters" data-price="200">
                    <img src="airfilter.png" alt="Engine Air Filters">
                    <h3>Engine Air Filters</h3>
                    <span>RM 200</span>
                    <a href="part.php"><button type="button" onclick="addToCart(this)">Order Now</button></a>
                    <!-- <a href="part.php" class="details">View Details</a> -->
                </article>
                <article class="box" data-name="Break Pads" data-price="1500">
                    <img src="breakpads.png" alt="Break Pads">
                    <h3>Break Pads</h3>
                    <span>RM 1500</span>
                    <a href="part.php"><button type="button" onclick="addToCart(this)">Order Now</button></a>
                    <!-- <a href="part.php" class="details">View Details</a> -->
                </article>
            </div>
            <div class="viewmore" href="part.php">
                <a href="part.php">View More</a>
            </div>
        </container>
    </section>

    <section id="forum">
        <div class="fcontainer">
            <div class="contetnt">
                <h1>Community <a href="testforum.php"><i class="fa-regular fa-comment-dots"></i></a></h1>
                <p>Connect with our customers all around the globe.</p>
            </div>
        </div>
    </section>
    
    <?php include('footer.php') ?>

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

    window.onscroll = calcScrollValue;
    window.onload = calcScrollValue;
    </script>
</body>
</html>