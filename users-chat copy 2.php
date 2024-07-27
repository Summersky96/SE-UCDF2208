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


// Database connection error handling
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$unique_id = '';
$pic_field = '';
$username_field = '';
$table = '';
// $table1 = '';
// $row = null;

switch ($_SESSION['role']) {
    case 'admin':
        $unique_id = 'adminid';
        $pic_field = 'adminpic';
        $username_field = 'Admin';
        $table = 'admininfo';
        break;
    case 'mechanic':
        $unique_id = 'mecid';
        $pic_field = 'mecpic';
        $username_field = 'name';
        $table = 'mechanicinfo';
        break;
    case 'customer':
        $unique_id = 'userid';
        $pic_field = 'userpic';
        $username_field = 'username';
        $table = 'userinfo';
        break;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <style>
        section {
            top: 13%;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

    </style>
    <link rel="stylesheet" href="chat1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
</head>
<body>
    <section>
        <div class="wrapper">
        <container class="users">
                <div class="header">
                    <div class="contents">
                        <?php 
                        // Check if unique_id is set in the session
                        if (isset($_SESSION[$unique_id])) {
                            $unique_id_value = mysqli_real_escape_string($con, $_SESSION[$unique_id]);
                            $sql = mysqli_query($con, "SELECT * FROM {$table} WHERE {$unique_id} = '{$unique_id_value}'");

                            // Check if query returned any rows
                            if (mysqli_num_rows($sql) > 0) {
                                $row = mysqli_fetch_assoc($sql);
                            } else {
                                echo "User not found.";
                            }
                        }
                        ?>
                        <img src="<?php echo htmlspecialchars($row[$pic_field]); ?>" alt="">
                        <div class="details">
                            <span><?php echo $_SESSION['role'] === 'admin' ? 'Admin' : htmlspecialchars($row[$username_field]); ?></span>
                            <p><?php echo htmlspecialchars($row['status']); ?></p>
                        </div>
                    </div>
                </div>
                <div class="search">
                    <span class="text">Select a user to start chat</span>
                    <input type="text" placeholder="Enter name to search...">
                    <button><i class="fas fa-search"></i></button>
                </div>
                <div class="users-list">
                    <?php include_once "users copy.php"; ?>
                </div>
            </container>
            <container class="chat-area">
                <div class="header">
                    <?php
                    // Debug: Output session role
                    // echo "Session Role: " . $_SESSION['role'] . "<br>";
                    // echo "Session ID: " . $_SESSION[$unique_id] . "<br>";

                    // Determine the correct table and unique ID field based on the role and URL parameters
                    if (isset($_GET['role']) && isset($_GET['userid'])) {
                        $role = mysqli_real_escape_string($con, $_GET['role']);
                        $user_id = mysqli_real_escape_string($con, $_GET['userid']);

                        // Debug: Output role and user ID from URL parameters
                        // echo "Role from URL: " . $role . ", User ID from URL: " . $user_id . "<br>";

                        switch ($role) {
                            case 'admin':
                                $table1 = 'admininfo';
                                $pic_field = 'adminpic';
                                $username_field = 'Admin';
                                $unique_id_field = 'adminid';
                                $email = 'adminemail';
                                break;
                            case 'mechanic':
                                $table1 = 'mechanicinfo';
                                $pic_field = 'mecpic';
                                $username_field = 'name';
                                $unique_id_field = 'mecid';
                                $email = 'email';
                                break;
                            case 'customer':
                                $table1 = 'userinfo';
                                $pic_field = 'userpic';
                                $username_field = 'username';
                                $unique_id_field = 'userid';
                                $email = 'email';
                                break;
                            default:
                                echo "Invalid user role.";
                                break;
                        }

                        // Fetch the user information based on the unique ID field and user ID
                        if (!empty($unique_id_field) && !empty($user_id)) {
                            $sql = "SELECT * FROM {$table1} WHERE {$unique_id_field} = '{$user_id}'";
                            $result = mysqli_query($con, $sql);

                            // Check if query returned any rows
                            if ($result && mysqli_num_rows($result) > 0) {
                                if($row = mysqli_fetch_assoc($result)){
                                    $update_status_sql = "UPDATE messages SET status = 'read' 
                                                      WHERE incoming_msg_id = '{$outgoing_email}' 
                                                      AND outgoing_msg_id = '{$user_id}' 
                                                      AND status = 'unread'";
                                    $update_status_result = mysqli_query($con, $update_status_sql);
                                }
                            } else {
                                echo "User not found.";
                            }
                        } else {
                            echo "Select a user to chat with";
                        }
                    }
                    ?>
                    <?php if ($row): ?>
                        <img src="<?php echo htmlspecialchars($row[$pic_field]); ?>" alt="">
                        <div class="details">
                        <span><?php echo ($role === 'admin' && $username_field === 'Admin') ? 'Admin' : htmlspecialchars($row[$username_field]); ?></span>
                        <span class="role"><p><?php echo "$role";?></p></span>
                            <p><?php echo htmlspecialchars($row['status']); ?></p>
                        </div>
                    <?php else: ?>
                        <div class="details">
                            <span>Please select a user</span>
                            <p></p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="chat-box">
                    <?php if (!$row): ?>
                        <p style="display: flex; align-items: center; justify-content: center; margin-top: 25%; font-weight: 600; font-size: 18px;">Please select a user to start chatting.</p>
                    <?php endif; ?>
                </div>
                <?php if ($row): ?>
                <form action="#" class="typing-area">
                    <input type="text" class="incoming_id" name="incoming_id" value="<?php echo htmlspecialchars($row[$email]); ?>" hidden>
                    <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
                    <button><i class="fab fa-telegram-plane"></i></button>
                </form>
                <?php endif; ?>
            </container>
        </div>
    </section>
    <?php include('footer.php') ?>

<script src="users copy.js"></script>
<script src="chat copy.js"></script>

</body>
</html>
