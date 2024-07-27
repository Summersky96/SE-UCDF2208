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
        $user_name = 'name';
        break;
    default:
        include('navbar.php');
        $user_name = 'username';
        break;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input data to prevent SQL injection
    $name = $con->real_escape_string($_POST['name']);
    $email = $con->real_escape_string($_POST['email']);
    $problem = $con->real_escape_string($_POST['problem']);

    // Prepare and execute the SQL statement
    $stmt = $con->prepare("INSERT INTO feedback (username, user_email, problem_description) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $problem);
    
    if ($stmt->execute()) {
        echo '<script>alert("Thanks for the Feedback!");
        window.location.href = "probleam_feedback.php";
        </script>';
    } else {
        echo '<script>alert("Error Submitting Feedback!");
        window.location.href = "probleam_feedback.php";
        </script>';
    }
    
    $stmt->close();
    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Problem</title>
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
            max-width: 700px;
            width: 700px;
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
        h2 {
            text-align: center;
        }
        form {
            max-width: 600px;
            margin: auto;
            border-radius: 10px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        button {
            display: flex;
            margin: auto;
            padding: 10px 20px;
            border: none;
            background-color: #28a745;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #218838;
        }
        .message {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            text-align: center;
        }
        .message-success {
            background-color: #28a745;
            color: #fff;
        }
        .message-error {
            background-color: #dc3545;
            color: #fff;
        }
    </style>
</head>
<body>
    <section>
        <div class="container">
            <h2>Report a Problem</h2>
            <form id="feedbackForm" method="POST" action="probleam_feedback.php">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required value="<?php echo $row[$user_name]?>">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required value="<?php echo $row['email']?>">
                <label for="problem">Problem Description:</label>
                <textarea id="problem" name="problem" required></textarea>
                <button type="submit" name="submitBtn">Submit</button>
            </form>
        </div>
    </section>
    <?php include('footer.php')?>
</body>
</html>
