<?php 
session_start();

if (isset($_SESSION['role'])) {
    include_once "conn.php"; // Ensure this file includes your database connection ($con)

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    
    $unique_id = '';
    $pic_field = '';
    $username_field = '';
    $table = '';
    
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
        default:
            echo "Invalid role.";
            exit();
    }

    // Fetch the current user's email based on role
    $outgoing_id = $_SESSION[$unique_id];
    switch ($_SESSION['role']) {
        case 'admin':
            $sql_outgoing = "SELECT adminemail AS email FROM admininfo WHERE adminid = '{$outgoing_id}'";
            break;
        case 'mechanic':
            $sql_outgoing = "SELECT email FROM mechanicinfo WHERE mecid = '{$outgoing_id}'";
            break;
        default:
            $sql_outgoing = "SELECT email FROM userinfo WHERE userid = '{$outgoing_id}'";
            break;
    }

    $result_outgoing = mysqli_query($con, $sql_outgoing);
    if ($row_outgoing = mysqli_fetch_assoc($result_outgoing)) {
        $outgoing_email = $row_outgoing['email'];
    } else {
        echo "Error: Outgoing user email not found.";
        exit();
    }

    // Retrieve incoming_msg_id (recipient's email from POST data)
    $incoming_email = mysqli_real_escape_string($con, $_POST['incoming_id']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    if (!empty($message)) {
        // Insert message into the database using emails
        $sql_insert = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, status)
                       VALUES ('{$incoming_email}', '{$outgoing_email}', '{$message}', 'unread')";

        if (mysqli_query($con, $sql_insert)) {
            echo "Message sent successfully.";
        } else {
            echo "Error: " . mysqli_error($con);
        }
    } else {
        echo "Message cannot be empty.";
    }
} else {
    header("location: ../loginpage1.php");
    exit();
}
?>
