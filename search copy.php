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

// Fetch the current user's email and role
$userRole = $_SESSION['role'];
$outgoing_email = '';
$userId = '';

switch ($userRole) {
    case 'customer':
        $userId = $_SESSION['userid'];
        $sql1 = "SELECT email FROM userinfo WHERE userid = $userId";
        break;
    case 'admin':
        $userId = $_SESSION['adminid'];
        $sql1 = "SELECT adminemail AS email FROM admininfo WHERE adminid = $userId";
        break;
    case 'mechanic':
        $userId = $_SESSION['mecid'];
        $sql1 = "SELECT email FROM mechanicinfo WHERE mecid = $userId";
        break;
    default:
        echo "Invalid user role.";
        exit();
}

$result1 = mysqli_query($con, $sql1);
if ($row1 = mysqli_fetch_assoc($result1)) {
    $outgoing_email = $row1['email'];
} else {
    echo "Error: Outgoing user email not found.";
    exit();
}

$searchTerm = mysqli_real_escape_string($con, $_POST['searchTerm']);

// Build SQL query based on role
switch ($_SESSION['role']) {
    case 'admin':
        $sql = "(SELECT userid, username, email, userpic, status, 'customer' AS role FROM userinfo 
                 WHERE NOT email = '{$outgoing_email}' 
                 AND (username LIKE '%{$searchTerm}%' OR email LIKE '%{$searchTerm}%')) 
                UNION 
                (SELECT adminid AS userid, 'Admin' AS username, adminemail AS email, adminpic AS userpic, status, 'admin' AS role FROM admininfo 
                 WHERE NOT adminemail = '{$outgoing_email}' 
                 AND (adminemail LIKE '%{$searchTerm}%' OR 'Admin' LIKE '%{$searchTerm}%'))
                 UNION 
                (SELECT mecid AS userid, name AS username, email, mecpic AS userpic, status, 'mechanic' AS role FROM mechanicinfo 
                 WHERE NOT email = '{$outgoing_email}' 
                 AND (email LIKE '%{$searchTerm}%' OR name LIKE '%{$searchTerm}%'))";
        break;
    case 'mechanic':
        $sql = "(SELECT userid, username, email, userpic, status, 'customer' AS role FROM userinfo 
                 WHERE NOT email = '{$outgoing_email}' 
                 AND (username LIKE '%{$searchTerm}%' OR email LIKE '%{$searchTerm}%'))
                 UNION 
                (SELECT adminid AS userid, 'Admin' AS username, adminemail AS email, adminpic AS userpic, status, 'admin' AS role FROM admininfo 
                 WHERE NOT adminemail = '{$outgoing_email}' 
                 AND (adminemail LIKE '%{$searchTerm}%' OR 'Admin' LIKE '%{$searchTerm}%')) 
                UNION 
                (SELECT mecid AS userid, name AS username, email, mecpic AS userpic, status, 'mechanic' AS role FROM mechanicinfo 
                 WHERE NOT email = '{$outgoing_email}' 
                 AND (email LIKE '%{$searchTerm}%' OR name LIKE '%{$searchTerm}%'))";
        break;
    default:
        $sql = "(SELECT adminid AS userid, 'Admin' AS username, adminemail AS email, adminpic AS userpic, status, 'admin' AS role FROM admininfo 
                 WHERE NOT adminemail = '{$outgoing_email}' 
                 AND (adminemail LIKE '%{$searchTerm}%' OR 'Admin' LIKE '%{$searchTerm}%'))
                 UNION 
                (SELECT mecid AS userid, name AS username, email, mecpic AS userpic, status, 'mechanic' AS role FROM mechanicinfo 
                 WHERE NOT email = '{$outgoing_email}' 
                 AND (email LIKE '%{$searchTerm}%' OR name LIKE '%{$searchTerm}%'))";
        break;
}

$sql .= " ORDER BY userid DESC";

$query = mysqli_query($con, $sql);
$output = "";

if (!$query) {
    $output = "Error searching users.";
} elseif (mysqli_num_rows($query) > 0) {
    include_once "data copy.php"; // Assuming you have a file to handle displaying search results
} else {
    $output .= 'No user found related to your search term';
}

echo $output;
?>
