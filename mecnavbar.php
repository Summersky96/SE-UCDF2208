<?php
include('mecsession.php');
include('conn.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nav</title>
    <style>
        :root {
            --background-color: #fff;
            --text-color: #333;
            --primary-color: #ff4500;
            --secondary-color: #333;
            --notification-bg: #f4f4f4;
            --notification-border: #ddd;
        }

        .dark-mode {
            --background-color: #343434;
            --text-color: #fff;
            --notification-bg: #555;
            --notification-border: #777;
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            transition: all ease 0.3s;
        }
        .navbar .mode-toggle i{
            font-size: 30px;
            height: 50px;
            min-width: 50px;
            text-align: center;
            line-height: 50px;
            cursor: pointer;
        }

        .mode-toggle i{
            transition: all 0.3s ease;
        }

        .navbar .mode-toggle i.light{
            position: absolute;
            font-size: 35px;
        }
        .navbar .mode-toggle i.dark{
            transform: translate(50%, -50%) rotate(360deg);
            font-size: 15px;
        }

        .navbar .mode-toggle.active i.light{
            transform: translate(35%, -35%) rotate(180deg);
            font-size: 20px;
        }
        .navbar .mode-toggle.active i.dark{
            position: relative;
            transform: rotate(360deg);
            font-size: 30px;
        }
        .navbar .link .submenu{
            right: 43%;
        }

        .pfp img{
            height: 50px;
            width: 50px;
            object-fit: cover;
            border-radius: 50%;
            margin: 0 14px 0 12px;
            background: #e5e5e5;
            padding: 5px;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        body.dark-mode .pfp img{
            height: 50px;
            width: 50px;
            object-fit: cover;
            border-radius: 50%;
            margin: 0 14px 0 12px;
            background: #5b5c62;
            padding: 5px;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .pfp img:hover,
        body.dark-mode .pfp img:hover{
            padding: 2px;
        }

        .navbar .profile-details .pfpname,
        .navbar .profile-details .job{
            color: #fff;
            font-size:  17px;
            font-weight: 500;
            padding-left: 5px;
            white-space: nowrap;
            transition: all 0.5s ease;
        }

        .navbar .profile-details{
            position: relative;
            /* bottom: 0; */
            /* width: 260px; */
            display: flex;
            align-items: center;
            justify-content: space-between;
            /* background: #242526; */
            padding: 6px 0;
            transition: all 0.5s ease;
            text-decoration: none;
        }
        .notification-container {
            position: relative;
            display: inline-block;
        }

        .notification-counter {
            position: absolute;
            top: -10px;
            right: -10px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            display: none; /* Hide the counter initially */
        }

        .notifications-list {
            display: none;
            position: absolute;
            background-color: var(--notification-bg);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            left: 50%;
            transform: translateX(-50%);
            top: 50px;
            list-style: none;
            padding: 0;
            margin: 0;
            width: 180px;
            z-index: 1000;
            border: 1px solid var(--notification-border);
            border-radius: 4px;
            overflow-y: scroll;
            max-height: 30vh;
        }
        .notifications-list::-webkit-scrollbar{
            width: 5px;
        }
        .notifications-list::-webkit-scrollbar-track {
            box-shadow: inset 0 0 5px black; 
            border-radius: 10px;
        }
        .notifications-list::-webkit-scrollbar-thumb{
            background: #7a7a7a; 
            border-radius: 10px;
        }
        .notifications-list::-webkit-scrollbar-thumb:hover{
            background: #696969; 
        }
        .notifications-list li {
            padding: 10px;
            border-bottom: 1px solid var(--notification-border);
            transition: background-color 0.3s;
            font-size: 14px; /* Smaller font size for the list items */
        }

        .notifications-list li:last-child {
            border-bottom: none;
        }

        .notifications-list li a {
            text-decoration: none;
            color: var(--secondary-color);
            display: block;
        }

        .notifications-list .notification-subject {
            font-weight: bold;
            font-size: 20px;
        }

        .notifications-list .notification-time {
            font-size: 12px;
            color: #ddd;
            margin-top: 5px;
            display: block;
        }

        .notifications-list li:hover a {
            color: white;
        }
        .notifications-list li:hover a::after{
            display: none;
        }
    </style>
    <!-- Google Fonts Link For Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="login1.css">
    <script src="login.js" defer></script>
</head>
<body class="<?php echo isset($_COOKIE['mode']) && $_COOKIE['mode'] === 'dark' ? 'dark-mode' : ''; ?>">
    <header>
        <nav class="navbar">
            <span class="hamburger-btn material-symbols-rounded">menu</span>
            <a href="#" class="logo">
                <img src="carlogo.png" alt="logo">
                <h2>AutoMate</h2>
            </a>
            <ul class="links">
                <span class="close-btn material-symbols-rounded">close</span>
                <li><a href="mecmain.php">Home</a></li>
            
                <li><a href="mecmain.php#booking">Booking <i class="fa-solid fa-caret-down"></i></a>
                <ul class="submenu">
                    <li><a href="add_booking.php">Make Booking</a></li>
                    <li><a href="display_bookings.php">View Booking</a></li>
                </ul>
            </li>

            <li><a href="mecmain.php#forum">Community <i class="fa-solid fa-caret-down"></i></a>
                <ul class="submenu">
                    <li><a href="users-chat copy 2.php">Chat Room</a></li>
                    <li><a href="testforum.php">Forum Page</a></li>
                </ul>
            </li>

                <li><a href="mecmain.php#parts">Parts <i class="fa-solid fa-caret-down"></i></a>
                <ul class="submenu">
                    <li><a href="part.php">Order</a></li>
                    <li><a href="parthistory.php">History</a></li>
                </ul>
            </li>
            <li><a href="#">Finance <i class="fa-solid fa-caret-down"></i></a>
                <ul class="submenu">
                    <li><a href="earnings.php">Income</a></li>
                    <li><a href="expenses.php">Expenses</a></li>
                </ul>
            </li>
            </ul>
            <div class='profile-details'>
                <div class='pfp'><a href='mecupdate.php'>
                    <?php 
                        $mecId = $_SESSION['mecid'];
                        $sql = "SELECT * FROM mechanicinfo WHERE mecid = $mecId";
                        $run = mysqli_query($con, $sql);
                        $row = mysqli_fetch_array($run);

                        if ($row) {
                            echo "<img src='$row[mecpic]' alt='profile'>";
                        }
                    ?>
                    </a></div>
                    <div class="name-job">
                        <div class="pfpname">
                            <?php 
                            $mecId = $_SESSION['mecid'];
                            $sql = "SELECT * FROM mechanicinfo WHERE mecid = $mecId";
                            $run = mysqli_query($con, $sql);
                            $row = mysqli_fetch_array($run);

                            if ($row) {
                                echo "$row[name]";
                            }
                            ?>
                        </div>
                        <div class="job">Mechanic</div>
                    </div>
            </div>
            <ul class="link">
             <li class="notification-container">
                    <a href="#" id="bell-icon"><i class="fa-solid fa-bell"></i>
                        <span class="notification-counter" id="notification-counter">0</span>
                    </a>
                    <ul class="notifications-list" id="notifications-list">
                        <?php
                        $sql = "SELECT subject, DATE_FORMAT(time, '%b %d, %Y %h:%i %p') AS time FROM notifications ORDER BY time DESC";
                        $result = mysqli_query($con, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($notification = mysqli_fetch_assoc($result)) {
                                echo "<li><a href='#'><span class='notification-subject'>{$notification['subject']}</span><span class='notification-time'>{$notification['time']}</span></a></li>";
                            }
                        } else {
                            echo "<li><a href='#'>No notifications</a></li>";
                        }
                        ?>
                    </ul>
                </li>
            <span class="mode-toggle">
                <i class="bx bxs-sun light"></i>
                <i class="bx bxs-moon dark"></i>
            </span>
            <li>
                <a href="probleam_feedback.php"><i class='bx bx-error-circle'></i></a>
                <ul class="submenu">
                    <li><a href="probleam_feedback.php">Feedback</a></li>
                    <li><a href="view_feedback.php">Replies</a></li>
                </ul>
            </li>
            <a href="logout.php"  onclick="return confirm('Are you sure to logout?');"><i class='bx bx-log-out logout'></i></a>
            </ul>
        </nav>
    </header>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const counterElement = document.getElementById("notification-counter");
            const notificationsList = document.getElementById("notifications-list");
            const bellIcon = document.getElementById("bell-icon");

            function updateNotificationCount(count) {
                if (count > 0) {
                    counterElement.textContent = count;
                    counterElement.style.display = "block";
                } else {
                    counterElement.style.display = "none";
                }
            }

            fetchNotifications();

            function fetchNotifications() {
                fetch("mec_notifhandler.php?action=count")
                    .then(response => response.json())
                    .then(data => {
                        updateNotificationCount(data.count);
                    });

                fetch("mec_notifhandler.php?action=get_notifications")
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            notificationsList.innerHTML = "";
                            data.notifications.forEach(notification => {
                                const listItem = document.createElement("li");
                                const link = document.createElement("a");
                                link.href = `notification_details.php?id=${notification.id}`;
                                link.innerHTML = `<span class='notification-subject'>${notification.subject}</span><span class='notification-time'>${notification.time}</span>`;
                                listItem.appendChild(link);
                                notificationsList.appendChild(listItem);
                            });
                        }
                    });
            }

            bellIcon.addEventListener("click", (e) => {
                e.preventDefault();
                notificationsList.style.display = notificationsList.style.display === "block" ? "none" : "block";
                
                if (notificationsList.style.display === "block") {
                    fetch("mec_notifhandler.php?action=mark_seen")
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                updateNotificationCount(0);
                            }
                        });
                }
            });

            const modeToggle = document.querySelector(".mode-toggle");

            function initializeMode() {
                const mode = getCookie("mode");
                if (mode === "dark") {
                    document.body.classList.add("dark-mode");
                    modeToggle.classList.add("active");
                }
            }

            initializeMode();

            function toggleDarkMode() {
                document.body.classList.toggle("dark-mode");
                modeToggle.classList.toggle("active");
                const mode = document.body.classList.contains("dark-mode") ? "dark" : "light";
                setCookie("mode", mode, 30);
            }

            modeToggle.addEventListener("click", toggleDarkMode);

            function setCookie(name, value, days) {
                var expires = "";
                if (days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    expires = "; expires=" + date.toUTCString();
                }
                document.cookie = name + "=" + (value || "") + expires + "; path=/";
            }

            function getCookie(name) {
                var nameEQ = name + "=";
                var ca = document.cookie.split(';');
                for (var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) === ' ') {
                        c = c.substring(1, c.length);
                    }
                    if (c.indexOf(nameEQ) === 0) {
                        return c.substring(nameEQ.length, c.length);
                    }
                }
                return null;
            }
        });
    </script>
</body>
</html>