<?php
include('adminsession.php');
include('conn.php');
include('csrf_token.php');

if (!isset($_SESSION['adminid'])) {
    // Redirect or handle the case where adminid is not set
    header('Location: login.php');
    exit;
}

$adminId = $_SESSION['adminid'];

// Use prepared statements to prevent SQL injection
$stmt = $con->prepare("SELECT * FROM admininfo WHERE adminid = ?");
$stmt->bind_param("i", $adminId);
$stmt->execute();
$admin = $stmt->get_result()->fetch_assoc();
$stmt->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Nav</title>
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
        .navbar .mode-toggle i {
            font-size: 30px;
            height: 50px;
            min-width: 50px;
            text-align: center;
            line-height: 50px;
            cursor: pointer;
        }
        .mode-toggle i {
            transition: all 0.3s ease;
        }
        .navbar .mode-toggle i.light {
            position: absolute;
            font-size: 35px;
        }
        .navbar .mode-toggle i.dark {
            transform: translate(50%, -50%) rotate(360deg);
            font-size: 15px;
        }
        .navbar .mode-toggle.active i.light {
            transform: translate(35%, -35%) rotate(180deg);
            font-size: 20px;
        }
        .navbar .mode-toggle.active i.dark {
            position: relative;
            transform: rotate(360deg);
            font-size: 30px;
        }
        .navbar .link .submenu {
            right: 43%;
        }
        .pfp img {
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
        body.dark-mode .pfp img {
            background: #5b5c62;
        }
        .pfp img:hover,
        body.dark-mode .pfp img:hover {
            padding: 2px;
        }
        .navbar .profile-details .pfpname,
        .navbar .profile-details .job {
            color: #fff;
            font-size: 17px;
            font-weight: 500;
            padding-left: 5px;
            white-space: nowrap;
            transition: all 0.5s ease;
        }
        .navbar .profile-details {
            display: flex;
            align-items: center;
            justify-content: space-between;
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
            display: none;
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
            overflow: auto;
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
    <!-- External Fonts and Icons -->
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
                <li><a href="adminmain.php">Home</a></li>
                <li>
                    <a href="adminmain.php#booking" class="booking">Booking <i class="fa-solid fa-caret-down"></i></a>
                    <ul class="submenu">
                        <li><a href="add_booking.php">Add Booking</a></li>
                        <li><a href="display_bookings.php">View Booking</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="account">Account <i class="fa-solid fa-caret-down"></i></a>
                    <ul class="submenu">
                        <li><a href="add_user.php">Add User</a></li>
                        <li><a href="viewuser.php">View User</a></li>
                    </ul>
                </li>
                <li>
                    <a href="adminmain.php#forum" class="forum">Community <i class="fa-solid fa-caret-down"></i></a>
                    <ul class="submenu">
                        <li><a href="users-chat copy 2.php">Chat Room</a></li>
                        <li><a href="testforum.php">Forum Page</a></li>
                        <li><a href="admin_notification.php">Post Notification</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="finance">Finance <i class="fa-solid fa-caret-down"></i></a>
                    <ul class="submenu">
                        <li><a href="earnings.php">Income</a></li>
                        <li><a href="expenses.php">Expenses</a></li>
                        <li><a href="monthlyreport.php">Report</a></li>
                    </ul>
                </li>
            </ul>
            <div class="profile-details">
                <div class="pfp"><a href="admininfo.php">
                    <?php if ($admin): ?>
                        <img src="<?= htmlspecialchars($admin['adminpic']) ?>" alt="profile">
                    <?php endif; ?>
                    </a>
                </div>
                <div class="name-job">
                    <div class="pfpname">
                        Mr Admin
                    </div>
                    <div class="job">Admin</div>
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
                                echo "<li><a href='#'><span class='notification-subject'>".htmlspecialchars($notification['subject'])."</span><span class='notification-time'>".htmlspecialchars($notification['time'])."</span></a></li>";
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
                <a href="admin_feedback.php"><i class='bx bx-error-circle'></i></a>
                <a href="logout.php" onclick="return confirm('Are you sure to logout?');"><i class="bx bx-log-out logout"></i></a>
            </ul>
        </nav>
    </header>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const counterElement = document.getElementById("notification-counter");
            const notificationsList = document.getElementById("notifications-list");
            const bellIcon = document.getElementById("bell-icon");

            // Function to update the notification counter
            function updateNotificationCount(count) {
                if (count > 0) {
                    counterElement.textContent = count;
                    counterElement.style.display = "block";
                } else {
                    counterElement.style.display = "none";
                }
            }

            // Fetch notifications count
            fetchNotifications();

            function fetchNotifications() {
                fetch("admin_notifhandler.php?action=count")
                    .then(response => response.json())
                    .then(data => {
                        updateNotificationCount(data.count);
                    });

                fetch("admin_notifhandler.php?action=get_notifications")
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

            // Mark notifications as seen and reset counter
            bellIcon.addEventListener("click", (e) => {
                e.preventDefault();
                notificationsList.style.display = notificationsList.style.display === "block" ? "none" : "block";
                
                if (notificationsList.style.display === "block") {
                    fetch("admin_notifhandler.php?action=mark_seen")
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                updateNotificationCount(0);
                            }
                        });
                }
            });

            const modeToggle = document.querySelector(".mode-toggle");

            // Function to set the initial mode based on the cookie
            function initializeMode() {
                const mode = getCookie("mode");
                if (mode === "dark") {
                    document.body.classList.add("dark-mode");
                    modeToggle.classList.add("active");
                }
            }

            initializeMode(); // Call the function when the DOM is loaded

            // Function to toggle dark mode
            function toggleDarkMode() {
                document.body.classList.toggle("dark-mode");
                modeToggle.classList.toggle("active");
                const mode = document.body.classList.contains("dark-mode") ? "dark" : "light";
                setCookie("mode", mode, 30); // Set cookie with 30 days expiry
            }

            modeToggle.addEventListener("click", toggleDarkMode);

            // Function to set a cookie
            function setCookie(name, value, days) {
                var expires = "";
                if (days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    expires = "; expires=" + date.toUTCString();
                }
                document.cookie = name + "=" + (value || "") + expires + "; path=/";
            }

            // Function to get a cookie
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
