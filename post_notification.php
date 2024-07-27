<?php
session_start();
include('conn.php');

if (!isset($_SESSION['role'])) {
    echo '<script>alert("Please Log In!");window.location.href="loginpage1.php";</script>'; 
    exit();
}

if ($_SESSION['role'] != 'admin') {
    header("Location: loginpage1.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = trim($_POST['subject']);
    $content = trim($_POST['content']);
    $post = handleFileUpload('postMedia', 'notification-media/');

    if (!empty($subject) && !empty($content)) {
        // Prepare the statement
        $stmt = $con->prepare("INSERT INTO notifications (subject, content, post, time) VALUES (?, ?, ?, now())");
        if ($stmt === false) {
            echo "Error: " . $con->error;
            exit();
        }

        // Bind parameters
        $stmt->bind_param("sss", $subject, $content, $post);

        // Execute the statement
        if ($stmt->execute()) {
            echo '<script>alert("Notification posted successfully!");window.location.href="admin_notification.php";</script>';
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Subject and content cannot be empty.";
    }
    
    // Close the database connection
    $con->close();
}

function handleFileUpload($fileKey, $uploadFolder) {
    if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
        $fileTmpName = $_FILES[$fileKey]['tmp_name'];
        $fileName = basename($_FILES[$fileKey]['name']);
        $fileFolder = $uploadFolder;
        $filePath = $fileFolder . $fileName;

        if (!file_exists($fileFolder)) {
            mkdir($fileFolder, 0777, true);
        }

        if (move_uploaded_file($fileTmpName, $filePath)) {
            return $filePath;
        } else {
            echo "File upload failed.";
        }
    }
    return null;
}
?>
