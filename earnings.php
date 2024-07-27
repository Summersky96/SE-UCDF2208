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
    $method = $_POST['method'];
    $description = $_POST['description'];
    $customer = $_POST['customer'];

    $insertQuery = $con->prepare("INSERT INTO earnings (date, amount, method, description, customer) VALUES (?, ?, ?, ?, ?)");
    $insertQuery->bind_param("sdsss", $date, $amount, $method, $description, $customer);

    if ($insertQuery->execute()) {
        echo '<script>alert("Earnings data inserted successfully!");window.location.href="earnings.php";</script>';
    } else {
        echo '<script>alert("Error inserting earnings data.");</script>';
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
    <title>Insert Earnings</title>
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
            color: #333;
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
            <h2>Daily Income</h2>
            <form method="POST" action="earnings.php">
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" required>
                </div>
                <div class="form-group">
                    <label for="amount">Amount:</label>
                    <input type="text" id="amount" name="amount" required>
                </div>
                <div class="form-group">
                    <label for="method">Method:</label>
                    <select id="method" name="method" required>
                        <option value="Cash">Cash</option>
                        <option value="Credit Card">Credit Card</option>
                        <option value="Online Payment">Online Payment</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Service:</label>
                    <select id="description" name="description" required>
                        <option value="Car Service">Car Service</option>
                        <option value="Car Battery">Car Battery</option>
                        <option value="Engines">Engines</option>
                        <option value="Tyres">Tyres</option>
                        <option value="Air Conds">Air Conds</option>
                        <option value="Audio">Audio</option>
                        <option value="Modification">Modification</option>
                        <option value="Maintenance">Maintenance</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="customer">Customer:</label>
                    <input type="text" id="customer" name="customer">
                </div>
                <input type="submit" value="Insert Earnings">
            </form>
        </div>
    </section>

    <?php include('footer.php') ?>
</body>
</html>
