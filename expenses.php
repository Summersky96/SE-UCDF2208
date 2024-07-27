<?php
session_start();
include('conn.php');

// Check if the user is logged in and has the admin or mechanic role
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'mechanic'])) {
    echo '<script>alert("Access Denied! Only admins and mechanics can access this page.");window.location.href="loginpage1.php";</script>'; 
    exit();
}

// Include the correct navbar based on the user's role
switch ($_SESSION['role']) {
    case 'admin':
        include('adminnav.php');
        break;
    case 'mechanic':
        include('mecnavbar.php');
        break;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];

    $insertQuery = $con->prepare("INSERT INTO expenses (date, amount, description) VALUES (?, ?, ?)");
    $insertQuery->bind_param("sds", $date, $amount, $description);

    if ($insertQuery->execute()) {
        echo '<script>alert("Expenses data inserted successfully!");window.location.href="expenses.php";</script>';
    } else {
        echo '<script>alert("Error inserting expenses data.");</script>';
    }


    $insertQuery->close();
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Expenses</title>
    <style>
        section {
            top: 13%;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 500px;
            margin: auto;
            color: #000;
            transition: all .2s ease;
        }
        body.dark-mode .container{
            background-color: #3b4252;
            color: white;
        }
        h2 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="date"], select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            margin: auto;
            display: flex;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <section>
        <div class="container">
            <h2>Daily Expenses</h2>
            <form method="POST" action="expenses.php">
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" required>
                </div>
                <div class="form-group">
                    <label for="amount">Amount:</label>
                    <input type="text" id="amount" name="amount" required>
                </div>
                <div class="form-group">
                    <label for="description">Expenses:</label>
                    <select id="description" name="description" required>
                        <option value="Rent">Rent</option>
                        <option value="Utilities">Utilities</option>
                        <option value="Payroll">Payroll</option>
                        <option value="Parts">Parts</option>
                        <option value="External Fees">External Fees</option>
                    </select>
                </div>
                <input type="submit" value="Insert Expenses">
            </form>
        </div>
    </section>

    <?php include('footer.php') ?>
</body>
</html>
