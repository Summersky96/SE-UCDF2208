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
            $pic_field = 'userpic';
            $username_field = 'Admin';
            $table = 'admininfo';
            break;
        case 'mechanic':
            $unique_id = 'mecid';
            $pic_field = 'userpic';
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

    $output = "";

    // Fetch messages between the two users using emails
    $sql = "SELECT messages.msg, messages.outgoing_msg_id, 
                   CASE 
                       WHEN admininfo.adminid IS NOT NULL THEN admininfo.adminpic
                       WHEN mechanicinfo.mecid IS NOT NULL THEN mechanicinfo.mecpic
                       WHEN userinfo.userid IS NOT NULL THEN userinfo.userpic
                   END AS userpic
            FROM messages 
            LEFT JOIN userinfo ON userinfo.email = messages.outgoing_msg_id
            LEFT JOIN admininfo ON admininfo.adminemail = messages.outgoing_msg_id
            LEFT JOIN mechanicinfo ON mechanicinfo.email = messages.outgoing_msg_id
            WHERE (messages.outgoing_msg_id = '{$outgoing_email}' AND messages.incoming_msg_id = '{$incoming_email}')
               OR (messages.outgoing_msg_id = '{$incoming_email}' AND messages.incoming_msg_id = '{$outgoing_email}') 
            ORDER BY messages.msg_id";

    $query = mysqli_query($con, $sql);

    if ($query) {
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                if ($row['outgoing_msg_id'] === $outgoing_email) {
                    $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>' . htmlspecialchars($row['msg']) . '</p>
                                </div>
                                </div>';
                } else {
                    $output .= '<div class="chat incoming">
                                <img src="' . htmlspecialchars($row[$pic_field]) . '" alt="User Image">
                                <div class="details">
                                    <p>' . htmlspecialchars($row['msg']) . '</p>
                                </div>
                                </div>';
                }
            }
        } else {
            $output .= '<div class="text">No messages are available. Once you send a message, they will appear here.</div>';
        }
    } else {
        $output .= '<div class="text">Failed to retrieve messages. Please try again later.</div>';
    }

    echo $output;
} else {
    header("Location: ../loginpage1.php");
    exit();
}
?>
