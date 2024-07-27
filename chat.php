<?php 
session_start();
include_once "conn.php";

// Check if user is logged in
if(!isset($_SESSION['userid']) && !isset($_SESSION['adminid']) && !isset($_SESSION['mecid'])){
    echo '<script>alert("Please Login!");window.location.href="loginpage1.php";</script>';
    exit(); // Stop further execution
}

// Define user ID based on session role and initialize chat interface variables
if(isset($_SESSION['userid'])){
    $user_id = $_SESSION['userid'];
    $role = 'customer';
} elseif(isset($_SESSION['adminid'])){
    $user_id = $_SESSION['adminid'];
    $role = 'admin';
} elseif(isset($_SESSION['mecid'])){
    $user_id = $_SESSION['mecid'];
    $role = 'mechanic';
}

// Fetch user data based on role
if($role == 'admin'){
    // Fetch data from the admin database table
    $admin_sql = mysqli_query($con, "SELECT * FROM admininfo WHERE adminid = {$user_id}");
    if(mysqli_num_rows($admin_sql) > 0){
        $user_row = mysqli_fetch_assoc($admin_sql);
    }
} elseif($role == 'mechanic'){
    // Fetch data from the mechanic database table
    $mechanic_sql = mysqli_query($con, "SELECT * FROM mechanicinfo WHERE mecid = {$user_id}");
    if(mysqli_num_rows($mechanic_sql) > 0){
        $user_row = mysqli_fetch_assoc($mechanic_sql);
    }
} elseif($role == 'customer'){
    // Fetch data from the user database table
    $user_sql = mysqli_query($con, "SELECT * FROM userinfo WHERE userid = {$user_id}");
    if(mysqli_num_rows($user_sql) > 0){
        $user_row = mysqli_fetch_assoc($user_sql);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat</title>
  <link rel="stylesheet" href="chat.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <!-- Header content based on user's role -->
        <?php if($role == 'customer'): ?>
            <!-- Display customer chat header -->
            <span>Welcome <?php echo $user_row['username']; ?></span>
        <?php elseif($role == 'admin'): ?>
            <!-- Display admin chat header -->
            <span>Welcome Admin</span>
        <?php elseif($role == 'mechanic'): ?>
            <!-- Display mechanic chat header -->
            <span>Welcome <?php echo $user_row['name']; ?></span>
        <?php endif; ?>
        <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <img src="<?php echo ($role == 'admin') ? (isset($user_row['adminpic']) ? $user_row['adminpic'] : '') : (($role == 'mechanic') ? (isset($user_row['mecpic']) ? $user_row['mecpic'] : '') : (isset($user_row['userpic']) ? $user_row['userpic'] : '')); ?>" alt="">
        <div class="details">
            <span><?php echo ($role == 'admin') ? 'Admin' : (($role == 'mechanic') ? $user_row['name'] : $user_row['username']); ?></span>
            <p><?php echo $user_row['status']; ?></p>
        </div>
      </header>
      <div class="chat-box">
        <!-- Chat messages will be displayed here -->
        <?php
        // Retrieve and display chat messages based on user's role
        if(isset($_SESSION['userid'])){ // Customer
            $sql = "SELECT * FROM messages WHERE incoming_msg_id = {$user_id} ORDER BY msg_id";
        } elseif(isset($_SESSION['adminid']) || isset($_SESSION['mecid'])){ // Admin or Mechanic
            $sql = "SELECT * FROM messages ORDER BY msg_id";
        }

        $query = mysqli_query($con, $sql);

        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)){
                // Format chat messages here based on your UI requirements
                echo '<div class="chat">' . $row['msg'] . '</div>';
            }
        } else {
            echo '<div class="text">No messages available.</div>';
        }
        ?>
      </div>
      <!-- Chat input area -->
      <form id="message-form" action="#" class="typing-area">
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <button><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>
  </div>

  <script src="javascript/chat.js"></script>
  <script>
  // Function to send message via AJAX
  function sendMessage() {
    // Get the message content and incoming user ID
    var message = document.querySelector('.input-field').value;
    var incomingId = document.querySelector('.incoming_id').value;

    // Make sure the message is not empty
    if (message.trim() == '') {
      alert('Please enter a message.');
      return;
    }

    // Create a new FormData object
    var formData = new FormData();
    formData.append('message', message);
    formData.append('incoming_id', incomingId);

    // Send AJAX request
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'send_message.php', true);
    xhr.onload = function () {
      if (xhr.status == 200) {
        // Clear the input field after sending the message
        document.querySelector('.input-field').value = '';

        // Handle the response from the server (if needed)
        console.log(xhr.responseText); // Log the response to the console
      }
    };
    xhr.send(formData);
  }

  // Submit the form when Enter key is pressed
  document.querySelector('.typing-area').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      sendMessage();
    }
  });

  // Submit the form when the send button is clicked
  document.querySelector('.typing-area button').addEventListener('click', function (e) {
    e.preventDefault();
    sendMessage();
  });
</script>


</body>
</html>
