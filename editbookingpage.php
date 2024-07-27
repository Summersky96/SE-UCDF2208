<?php
session_start();
include('conn.php');

// Calculate today's date
$today = date('Y-m-d');

// Check if the user is logged in and the role is set
if (!isset($_SESSION['role'])) {
    echo '<script>alert("Please Log In!");window.location.href="loginpage1.php";</script>'; 
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
    case 'customer':
    default:
        include('navbar.php');
        break;
}

// Check if bookingid is set in the query parameters
if (isset($_GET['bookingid'])) {
    $bookingId = intval($_GET['bookingid']);
    
    // Determine the query based on the user role
    if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'mechanic') {
        // Admins and mechanics can fetch booking data based on bookingid alone
        $sql = "SELECT * FROM booking WHERE bookingid = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $bookingId);
    } else {
        // Customers can fetch booking data based on bookingid and userid
        if (isset($_SESSION['userid'])) {
            $userId = $_SESSION['userid'];
            $sql = "SELECT * FROM booking WHERE bookingid = ? AND userid = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ii", $bookingId, $userId);
        } else {
            echo "Session ID is not set!";
            exit();
        }
    }

    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch the booking data
        $row = $result->fetch_assoc();
    } else {
        // Handle query error or no result found
        echo "Booking not found!";
        exit();
    }

    // Close the statement
    $stmt->close();
} else {
    // Handle the case where bookingid is not set
    echo "Booking ID is not set!";
    exit();
}

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
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
            margin: 0px auto;
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 0;
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
            margin-bottom: 20px;
        }
        .form-group.button{
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 250px;
            margin: auto;
            padding-top: 1rem;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
        input[type="submit"],
        input[type="button"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }
        input[type="button"]{
            background-color: #ff3737;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        input[type="button"]:hover{
            background-color: red;
        }
        .otherservice {
            display: none;
            padding-top: 20px;
        }
        .center{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding-top: 20px;
            font-size: 1.5rem;
        }
        .center p{
            padding-bottom: 20px;
        }
    </style>
    <link rel="stylesheet" href="login1.css">
</head>
<body>
    <section>
        <div class="container">
            <h2>Edit Car Maintenance Booking</h2>
            <form id="bookingForm" action="editbooking.php" method="post">
                <?php if (isset($row)): ?>
                    <?php 
                    $isEditable = $row['status'] == 'Pending' && strtotime($row['date']) > strtotime($today);
                    ?>
                    <?php if ($row['status'] != 'Expired'): ?>
                        <?php if (!$isEditable): ?>
                            <div class="center">
                                <p>This booking cannot be edited.</p>
                                <a href="display_bookings.php"><input type="button" value="Back" id="backBtn" name="backBtn"></a>
                            </div>
                        <?php else: ?>
                        <input type="hidden" name="bookingid" value="<?php echo $row['bookingid']; ?>">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" id="customer" name="customer" value="<?php echo $row['customer']; ?>" required <?php echo !$isEditable ? 'disabled' : ''; ?>>
                        </div>
                        <div class="form-group">
                            <label for="name">Car Model:</label>
                            <input type="text" id="name" name="name" value="<?php echo $row['carname']; ?>" required <?php echo !$isEditable ? 'disabled' : ''; ?>>
                        </div>
                        <div class="form-group">
                            <label for="plate">Plate Number:</label>
                            <input type="text" id="plate" name="plate" value="<?php echo $row['plate']; ?>" required <?php echo !$isEditable ? 'disabled' : ''; ?>>
                        </div>
                        <div class="form-group">
                            <label for="phone">Telephone:</label>
                            <input type="text" id="phone" name="phone" value="<?php echo $row['cusphone']; ?>" required <?php echo !$isEditable ? 'disabled' : ''; ?>>
                        </div>
                        <div class="form-group">
                            <label for="date">Preferred Date for Appointment:</label>
                            <input type="date" id="date" name="date" value="<?php echo $row['date']; ?>" required <?php echo !$isEditable ? 'disabled' : ''; ?>>
                        </div>
                        <div class="form-group">
                            <label for="service">Service Required:</label>
                            <select id="service" name="service" required onchange="toggleOtherService()" <?php echo !$isEditable ? 'disabled' : ''; ?>>
                                <option value="">Select Service</option>
                                <option value="Car Service" <?php echo ($row['service'] == 'Car Service') ? 'selected' : ''; ?>>Car Service</option>
                                <option value="Car Battery" <?php echo ($row['service'] == 'Car Battery') ? 'selected' : ''; ?>>Car Battery</option>
                                <option value="Engines" <?php echo ($row['service'] == 'Engines') ? 'selected' : ''; ?>>Engines</option>
                                <option value="Tyres" <?php echo ($row['service'] == 'Tyres') ? 'selected' : ''; ?>>Tyres</option>
                                <option value="Air Conds" <?php echo ($row['service'] == 'Air Conds') ? 'selected' : ''; ?>>Air Conds</option>
                                <option value="Audio" <?php echo ($row['service'] == 'Audio') ? 'selected' : ''; ?>>Audio</option>
                                <option value="Modification" <?php echo ($row['service'] == 'Modification') ? 'selected' : ''; ?>>Modification</option>
                                <option value="Maintenance" <?php echo ($row['service'] == 'Maintenance') ? 'selected' : ''; ?>>Maintenance</option>
                                <option value="Others" <?php echo ($row['service'] == 'Others') ? 'selected' : ''; ?>>Others</option>
                            </select>
                            <div id="others" class="otherservice" style="<?php echo ($row['service'] == 'Others') ? 'display:block;' : ''; ?>">
                                <label for="otherService">Other Service:</label>
                                <input type="text" id="otherService" name="otherService" value="<?php echo $row['otherService']; ?>" <?php echo !$isEditable ? 'disabled' : ''; ?>>
                            </div>
                        </div>
                        <?php if($_SESSION['role'] == 'admin'|| $_SESSION['role'] == 'mechanic'): ?>
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select id="status" name="status" required <?php echo !$isEditable ? 'disabled' : ''; ?>>
                                    <option value="Confirmed" <?php echo ($row['status'] == 'Confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                                    <option value="Rejected" <?php echo ($row['status'] == 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
                                    <option value="Canceled" <?php echo ($row['status'] == 'Canceled') ? 'selected' : ''; ?>>Canceled</option>
                                    <option value="Expired" <?php echo ($row['status'] == 'Expired') ? 'selected' : ''; ?>>Expired</option>
                                </select>
                            </div>
                        <?php endif; ?>
                        <div class="form-group button">
                            <input type="submit" value="Edit Booking" id="submitBtn" name="submitBtn" <?php echo !$isEditable ? 'disabled' : ''; ?>>
                            <a href="display_bookings.php"><input type="button" value="Back" id="backBtn" name="backBtn"></a>
                        </div>
                    <?php endif; ?>
                    <?php else: ?>
                        <div class="center">
                            <p>This booking is expired and cannot be edited.</p>
                            <a href="display_bookings.php"><input type="button" value="Back" id="backBtn" name="backBtn"></a>
                        </div>
                    <?php endif; ?>

                <?php else: ?>
                    <!-- Handle the case where $row is not set (booking not found) -->
                    <p>Booking not found!</p>
                <?php endif; ?>
            </form>
        </div>
    </section>

    <?php include('footer.php') ?> 
    
    <script>
        function toggleOtherService() {
            var serviceDropdown = document.getElementById("service");
            var otherServiceDiv = document.getElementById("others");

            if (serviceDropdown.value === "Others") {
                otherServiceDiv.style.display = "block";
                document.getElementById("otherService").required = true;
            } else {
                otherServiceDiv.style.display = "none";
                document.getElementById("otherService").required = false;
            }
        }

        // Initialize the "Other Service" field based on current selection
        document.addEventListener("DOMContentLoaded", function() {
            toggleOtherService();
        });
    </script>
</body>
</html>
