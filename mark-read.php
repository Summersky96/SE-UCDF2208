<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once "conn.php";

// Check if the user is logged in
if (!isset($_SESSION['role'])) {
    header("location: loginpage1.php");
    exit();
}

// Fetch the current user's email
$outgoing_email = '';
switch ($_SESSION['role']) {
    case 'admin':
        $outgoing_email = $_SESSION['adminid'];
        $sql_outgoing = "SELECT adminemail AS email FROM admininfo WHERE adminid = '{$outgoing_email}'";
        break;
    case 'mechanic':
        $outgoing_email = $_SESSION['mecid'];
        $sql_outgoing = "SELECT email FROM mechanicinfo WHERE mecid = '{$outgoing_email}'";
        break;
    default:
        $outgoing_email = $_SESSION['userid'];
        $sql_outgoing = "SELECT email FROM userinfo WHERE userid = '{$outgoing_email}'";
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

// Update the status of unread messages to read
$sql_update = "UPDATE messages SET status = 'read' WHERE incoming_msg_id = '{$outgoing_email}' AND outgoing_msg_id = '{$incoming_email}' AND status = 'unread'";
mysqli_query($con, $sql_update);
?>
