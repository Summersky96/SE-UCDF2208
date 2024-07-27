<style>
    .footer {
    background-color: #1a1a1a;
    color: #f6f6f6;
    border-top: 2px solid #1a1a1a;
    /* text-align: center; */
}
.footercon{
    display: flex;
    justify-content: space-around;
    gap: 1rem;
    padding: 3rem;
}

.footercon .logo{
    color: #fff;
    margin-bottom: 1rem;
    text-decoration: none;
}

.footercon .logo img{
    width: 110px;
    border-radius: 50%;
    padding-bottom: 10px;
}

.footercon a.logo:hover{
    text-decoration: none;
    color: #fff;
}

.footercon .footer-content {
    /* margin: 0 auto; */
    display: flex;
    flex-direction: column;
    /* max-width: 500px;
    width: 100%; */
    /* text-align: center; */
}

/* .footer-content p {
    margin-bottom: 1rem;
} */

.social-media {
    display: flex;
    justify-content: center;
    align-items: center;
    list-style-type: none;
    /* margin: 0; */
    padding: 20px;
}

/* .social-media li {
    margin: 0 0.5rem;
} */

.social-media a {
    color: #fff;
    font-size: 30px;
    text-decoration: none;
    margin-left: 10px;
    margin-right: 10px;
    text-decoration: none;
}
.social-media li{
    display: flex;
    justify-content: center;
    align-items: center;
    transition: all .3s ease;
}

.social-media a:hover {
    color: #ffd000;
}

.social-media li:hover{
    transform: scale(1.2);
}

.footer-content h3{
    font-size: 1.1rem;
    font-weight: 400;
    margin-bottom: 1rem;
}
.footer-content a{
    color: #818181;
    margin-bottom: 10px;
    text-decoration: none;
    transition: all 0.3s ease;
}
.footer-content a:hover{
    color: #ffd000;
    text-decoration: underline;
}

.copyright{
    /* padding: 20px; */
    text-align: center;
    position: relative;
    margin-top: 3rem;
}

.copyright h3{
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
}
.footer-content h2{
    color: #fff;
}
</style>
<footer class="footer">
        <div class="footercon">
            <div class="footer-content">
                <a href="aboutus.php" class="logo">
                    <img src="carlogo.png" alt="logo">
                    <h2>AutoMate</h2>
                </a>
            </div>
            <div class="footer-content">
                <h3>Page</h3>
                <a href="#home">Home</a>
                <a href="#booking">Booking</a>
                <a href="#maintainance">Maintainance</a>
                <a href="#forum">Community</a>
                <a href="#about">About Us</a>
            </div>
            <div class="footer-content">
                <h3>Partners</h3>
                <a href="https://www.porsche.com/pap/_malaysia_/">Porsche</a>
                <a href="https://www.mercedes-benz.com.my/?group=all&subgroup=see-all&view=BODYTYPE">Mercedes</a>
                <a href="https://www.bmw.com.my/en/index.html">BMW</a>
                <a href="https://www.proton.com/">Proton</a>
                <a href="https://www.perodua.com.my/">Perodua</a>
            </div>
            <div class="footer-content">
                <h3>Contact</h3>
                <a href="https://www.instagram.com/bryanlowzy?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">Bryan Low</a>
                <a href="https://www.instagram.com/summersky96_cjx?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">Chong Jinn Xiang</a>
                <a href="https://www.instagram.com/ec._jl?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">Edward Chia</a>
                <a href="https://www.instagram.com/clementbj_0109?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">Clement Tang</a>
                <a href="https://www.instagram.com/zxiangggg_?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">Lee Zhi Xiang</a>
            </div>
            <div class="copyright">
                <h3>Follow us on</h3>
                <ul class="social-media">
                    <li><a href="https://www.facebook.com/uniqueautotransmission"><i class="fa-brands fa-facebook-f"></i></a></li>
                    <li><a href="https://x.com/FirstStopTyreUK"><i class="fa-brands fa-twitter"></i></a></li>
                    <li><a href="https://www.instagram.com/hnz.carservices?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="><i class="fa-brands fa-instagram"></i></a></li>
                </ul>
                <p>&copy; 2024 AutoMate. All rights reserved.</p>
            </div>
        </div>
    </footer>