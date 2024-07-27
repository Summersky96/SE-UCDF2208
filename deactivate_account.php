<?php
session_start();
include("conn.php");

if (isset($_POST['deactivateBtn'])) {
    // Retrieve the user ID from the form submission
    $userId = $_POST['id'];

    // Query to delete the user account
    $sql = "DELETE FROM userinfo WHERE userid = $userId";

    if (mysqli_query($con, $sql)) {
        // Deletion successful
        echo "Account deleted successfully!";
        // Destroy the session and redirect the user to a login or home page
        session_destroy();
        header("Location: goodbye.php"); // Redirect to a farewell page or the home page
        exit;
    } else {
        // Handle query error
        echo "Error deleting account: " . mysqli_error($con);
    }

    // Close the database connection
    mysqli_close($con);
} else {
    // Handle the case where the deactivate button was not pressed
    echo "Invalid request!";
}
?>
