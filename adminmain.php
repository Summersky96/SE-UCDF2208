<?php
include("adminnav.php");
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
    <style>
        .navbar .links li a.home{
            color: #ffd000;
        }
    </style>
</head>
<body>
    <div id="progress">
      <span id="progress-value"><i class="fa-solid fa-arrow-up"></i></span>
    </div>

    <section id="home" class="showanimate">
        <img class="garage" src="garage.jpg" alt="garage" style="z-index: -5;" >
        <img class="fixing" src="fixing.png" alt="#">
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