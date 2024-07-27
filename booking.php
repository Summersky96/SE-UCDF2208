<?php
session_start();
if (isset($_POST['submitBtn'])) {
    include('conn.php');
    $currentDate = date('Y-m-d');
    $bookingDate = $_POST['date'];
    
    // Check if the booking date is in the past
    if (strtotime($bookingDate) < strtotime($currentDate)) {
        echo '<script>alert("Cannot book for past dates!");window.location.href="add_booking.php";</script>';
        exit();
    }

    $usersql = "INSERT INTO booking (customer, carname, cusphone, plate, date, service, otherService, userid, status)
    
    VALUES
    
    ('$_POST[customer]', '$_POST[name]', '$_POST[phone]', '$_POST[plate]', '$_POST[date]', '$_POST[service]', '$_POST[otherService]', '$_SESSION[userid]', 'Pending')";
    
    if(!mysqli_query($con,$usersql)) {
        die('Error:'.mysqli_error($con));
    } else {
        echo '<script>alert("Booking Successful!");
        window.location.href = "display_bookings.php";
        </script>';
    }
    mysqli_close($con);
} else {
    echo"<script>alert('Please fill in the form.');window.location.href='add_booking.php';</script>";
}
?>
