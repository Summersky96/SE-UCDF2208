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
// session_start();

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $name = $_POST['name'];
//     $phone = $_POST['phone'];
//     $date = $_POST['date'];
//     $service = $_POST['service'];
//     $otherServiceText = isset($_POST['otherServiceText']) ? $_POST['otherServiceText'] : '';

//     // Handle "Others" service type
//     if ($service == 'Others') {
//         $service = $otherServiceText;
//     }

//     $_SESSION['bookings'][] = array('name' => $name, 'phone' => $phone, 'date' => $date, 'service' => $service);

//     header("Location: display_bookings.php");
//     exit();
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Booking</title>
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
        input[type="submit"]:hover,
        input[type="button"]:hover {
            background-color: #45a049;
        }
        input[type="submit"]{
            display: flex;
            margin: auto;
        }
        .otherservice {
            display: none;
            padding-top: 20px;
        }
    </style>
    <link rel="stylesheet" href="login1.css">
</head>
<body>
    <section>
        <div class="container">
            <h2>Car Maintenance Booking</h2>
            <form id="bookingForm" action="booking.php" method="post">
                <div class="form-group">
                    <label for="customer">Name:</label>
                    <input type="text" id="customer" name="customer" required>
                </div>
                <div class="form-group">
                    <label for="name">Car Model:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="phone">Plate Number:</label>
                    <input type="text" id="plate" name="plate" required>
                </div>
                <div class="form-group">
                    <label for="phone">Telephone:</label>
                    <input type="text" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="date">Preferred Date for Appointment:</label>
                    <input type="date" id="date" name="date" min="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="form-group">
                    <label for="service">Service Required:</label>
                    <select id="service" name="service" required onchange="toggleOtherService()">
                        <option value="">Select Service</option>
                        <option value="Car Service">Car Service</option>
                        <option value="Car Battery">Car Battery</option>
                        <option value="Engines">Engines</option>
                        <option value="Tyres">Tyres</option>
                        <option value="Air Conds">Air Conds</option>
                        <option value="Audio">Audio</option>
                        <option value="Modification">Modification</option>
                        <option value="Maintenance">Maintenance</option>
                        <option value="Others">Others</option>
                    </select>
                    <div id="others" class="otherservice">
                        <label for="otherService">Other Service:</label>
                        <input type="text" id="otherService" name="otherService">
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" value="Submit Booking" id="submitBtn" name="submitBtn">
                    <input type="button" value="Update Booking" id="updateBtn" style="display:none;">
                    <input type="button" value="Cancel Booking" id="cancelBtn" style="display:none;">
                </div>
            </form>
        </div>
    </section>

    <?php include('footer.php') ?>
    
    <script>
        function toggleOtherService() {
            var serviceDropdown = document.getElementById("service");
            var otherServiceDiv = document.getElementById("others");
            var otherServiceText = document.getElementById("otherService");

            if (serviceDropdown.value === "Others") {
                otherServiceDiv.style.display = "block";
                otherServiceText.required = true;
            } else {
                otherServiceDiv.style.display = "none";
                otherServiceText.required = false;
            }
        }

        // Set the dropdown value based on the URL parameter
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const serviceType = urlParams.get('service');

            if (serviceType) {
                const serviceDropdown = document.getElementById("service");
                serviceDropdown.value = serviceType;
                toggleOtherService(); 
            }
        });
    </script>
</body>
</html>
