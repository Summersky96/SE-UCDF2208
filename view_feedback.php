<?php
session_start();
include('conn.php');

// Check if the user is logged in and the role is set
if (!isset($_SESSION['role'])) {
    echo '<script>alert("Please Log In!");window.location.href="loginpage1.php";</script>'; 
    exit();
}

// Include the correct navbar based on the user's role
switch ($_SESSION['role']) {
    case 'mechanic':
        include('mecnavbar.php');
        $user_id = $_SESSION['mecid']; // Adjust this to fetch mechanic's unique identifier
        $user_email = "SELECT email FROM mechanicinfo WHERE mecid = $user_id";
        break;
    default:
        include('navbar.php');
        $user_id = $_SESSION['userid']; // Adjust this to fetch customer's unique identifier
        $user_email = "SELECT email FROM userinfo WHERE userid = $user_id";
        break;
}

$result1 = mysqli_query($con, $user_email);
if ($row1 = mysqli_fetch_assoc($result1)) {
    $email = $row1['email'];
} else {
    echo "Error: Outgoing user email not found.";
    exit();
}

// Fetch feedbacks including admin responses for the logged-in user
$sql = "SELECT * FROM feedback WHERE username = ? OR user_email = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("ss", $user_id, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $feedbacks = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $feedbacks = [];
}

$stmt->close();
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Feedbacks</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        section {
            top: 13%;
        }
        .container {
            max-width: 800px;
            width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 0;
            color: #000;
            transition: all .2s ease;
        }
        body.dark-mode .container {
            background-color: #3b4252;
            color: white;
        }
        h1 {
            text-align: center;
            padding-bottom: 30px;
            padding-top: 10px;
        }
        .feedback-item {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #1e1e1e;
            border-radius: 5px;
        }
        body.dark-mode .feedback-item{
            border: 1px solid #ccc;
        }
        .feedback-item h3 {
            /* margin-bottom: 5px; */
            padding: 5px 0;
        }
        .feedback-item p {
            /* padding: 10px 0; */
            margin-bottom: 10px;
            font-weight: 700;
            font-size: 20px;
        }
        .detail{
            padding: 20px 5px;
        }
        .feedback-item textarea {
            width: 100%;
            /* min-height: 100px; */
            padding: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        button {
            display: flex;
            margin: auto;
            padding: 5px 10px;
            border: none;
            background-color: red;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
            transition: all .2s ease;
        }
        button:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
    <section>
        <div class="container">
            <h1>Feedback Responses</h1>
            <?php foreach ($feedbacks as $feedback): ?>
                <div class="feedback-item">
                    <h3><?php echo htmlspecialchars($feedback['username']); ?> (<?php echo htmlspecialchars($feedback['user_email']); ?>)</h3>
                    <div class="detail">
                        <p><?php echo nl2br(htmlspecialchars($feedback['problem_description'])); ?></p>
                        <textarea readonly><?php echo htmlspecialchars($feedback['admin_response']); ?></textarea>
                    </div>
                    <!-- Include a back button or link as needed -->
                </div>
                <button onclick="window.history.back();" type="button">Back</button>
            <?php endforeach; ?>
        </div>
    </section>
    <?php include('footer.php')?>
</body>
</html>
