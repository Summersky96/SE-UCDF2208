<?php
include('adminsession.php');
include('conn.php');

$action = isset($_GET['action']) ? $_GET['action'] : '';

$response = ['success' => false];

if ($action == 'count') {
    // Fetch the count of unseen notifications
    $sql = "SELECT COUNT(*) as count FROM notifications WHERE seen = FALSE";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $response['count'] = $row['count'];
    $response['success'] = true;
} elseif ($action == 'mark_seen') {
    // Mark all notifications as seen
    $sql = "UPDATE notifications SET seen = TRUE";
    $result = mysqli_query($con, $sql);
    $response['success'] = $result ? true : false;
} elseif ($action == 'get_notifications') {
    // Fetch all notifications
    $sql = "SELECT id, subject, time FROM notifications ORDER BY time DESC";
    $result = mysqli_query($con, $sql);
    $notifications = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $notifications[] = $row;
    }
    $response['notifications'] = $notifications;
    $response['success'] = true;
}

echo json_encode($response);
?>
