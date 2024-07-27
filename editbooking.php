<?php
session_start();
include('conn.php');

// Check if the user is logged in and the role is set
if (!isset($_SESSION['role'])) {
    echo '<script>alert("Please Log In!");window.location.href="loginpage1.php";</script>'; 
    exit();
}

if (isset($_POST['submitBtn'])) {
    include('conn.php');

    if($_SESSION['role'] == 'admin'||  $_SESSION['role'] == 'mechanic'){
        // Check if the required fields are set
        if (!empty($_POST['customer']) && !empty($_POST['name']) && !empty($_POST['phone']) && !empty($_POST['plate']) && isset($_POST['bookingid'])) {
            
            // Prepare SQL statement with placeholders
            $sql = "UPDATE booking SET
                    customer = '{$_POST['customer']}',
                    carname = '{$_POST['name']}',
                    cusphone = '{$_POST['phone']}',
                    plate = '{$_POST['plate']}',
                    `date` = '{$_POST['date']}',
                    service = '{$_POST['service']}',
                    otherService = '{$_POST['otherService']}',
                    status = '{$_POST['status']}'
                    WHERE 
                    bookingid = '{$_POST['bookingid']}'";
    
            // Execute the SQL query
            if (mysqli_query($con, $sql)) {
                echo '<script>alert("Edit successful!");
                      window.location.href = "display_bookings.php";
                      </script>';
            } else {
                echo '<script>alert("Error editing record!");
                      window.location.href = "editbookingpage.php";
                      </script>';
            }
        } else {
            echo '<script>alert("Please fill in all required fields.");
                  window.location.href = "editbookingpage.php";
                  </script>';
        }
    } else {
        if (!empty($_POST['customer']) && !empty($_POST['name']) && !empty($_POST['phone']) && !empty($_POST['plate']) && isset($_POST['bookingid'])) {
        
            // Prepare SQL statement with placeholders
            $sql = "UPDATE booking SET
                    customer = '{$_POST['customer']}',
                    carname = '{$_POST['name']}',
                    cusphone = '{$_POST['phone']}',
                    plate = '{$_POST['plate']}',
                    `date` = '{$_POST['date']}',
                    service = '{$_POST['service']}',
                    otherService = '{$_POST['otherService']}'
                    WHERE 
                    bookingid = '{$_POST['bookingid']}'";
    
            // Execute the SQL query
            if (mysqli_query($con, $sql)) {
                echo '<script>alert("Edit successful!");
                      window.location.href = "display_bookings.php";
                      </script>';
            } else {
                echo '<script>alert("Error editing record!");
                      window.location.href = "editbookingpage.php";
                      </script>';
            }
        } else {
            echo '<script>alert("Please fill in all required fields.");
                  window.location.href = "editbookingpage.php";
                  </script>';
        }
    
    }
    // Close the database connection
    mysqli_close($con);
} else {
    echo '<script>alert("Failed to update.");
          window.location.href = "editbookingpage.php";
          </script>';
}
?>
