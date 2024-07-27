<?php
while ($row = mysqli_fetch_assoc($query)) {
    // Fetch the latest message
    $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = '{$row['email']}' 
            OR outgoing_msg_id = '{$row['email']}') AND (outgoing_msg_id = '{$outgoing_email}' 
            OR incoming_msg_id = '{$outgoing_email}') ORDER BY msg_id DESC LIMIT 1";
    $query2 = mysqli_query($con, $sql2);
    $row2 = mysqli_fetch_assoc($query2);

    // Count unread messages
    $sql_unread = "SELECT COUNT(*) AS unread_count FROM messages 
                   WHERE incoming_msg_id = '{$outgoing_email}' 
                   AND outgoing_msg_id = '{$row['email']}' 
                   AND status = 'unread'";
    $query_unread = mysqli_query($con, $sql_unread);
    $row_unread = mysqli_fetch_assoc($query_unread);
    $unread_count = $row_unread['unread_count'];

    $result = (mysqli_num_rows($query2) > 0) ? $row2['msg'] : "No message available";
    $msg = (strlen($result) > 28) ? substr($result, 0, 28) . '...' : $result;
    $you = (isset($row2['outgoing_msg_id']) && $outgoing_email == $row2['outgoing_msg_id']) ? "You: " : "";
    $offline = ($row['status'] == "Offline now") ? "offline" : "";
    $hid_me = ($outgoing_email == $row['email']) ? "hide" : "";

    $output .= '<a href="users-chat copy 2.php?userid=' . $row['userid'] . '&role=' . $row['role'] . '">
                <div class="contents">
                <img src="' . $row['userpic'] . '" alt="">
                <div class="details">
                    <span>' . $row['username'] . '</span>
                    <p>' . $you . $msg . '</p>
                </div>
                </div>
                <div class="status-dot ' . $offline . '">
                    <i class="fas fa-circle"></i>
                    ' . ($unread_count > 0 ? '<span class="unread-count">' . $unread_count . '</span>' : '') . '
                </div>
            </a>';
}
?>
