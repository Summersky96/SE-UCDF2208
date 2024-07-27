<?php
include 'conn.php'; // Include your database connection file

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Handle AJAX requests
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'get_feedbacks') {
        $sql = "SELECT * FROM feedback";
        $result = $con->query($sql);

        $feedbacks = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $feedbacks[] = $row;
            }
            echo json_encode($feedbacks);
        } else {
            echo json_encode(["error" => $con->error]);
        }
        exit();
    }

    if ($_GET['action'] == 'respond' && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $response = $_POST['response'];

        // Validate if response is empty
        if (empty(trim($response))) {
            echo '<script>alert("Response cannot be empty");
            window.location.href = "admin_feedback.php";</script>';
            exit();
        }

        $stmt = $con->prepare("UPDATE feedback SET admin_response = ? WHERE feedbackid = ?");
        if ($stmt) {
            $stmt->bind_param("si", $response, $id);
            if ($stmt->execute()) {
                echo '<script>alert("Reply Successful");
                window.location.href = "admin_feedback.php";</script>';
            } else {
                echo '<script>alert("Reply Error: ' . $stmt->error . '");
                window.location.href = "admin_feedback.php";</script>';
            }
            $stmt->close();
        } else {
            echo '<script>alert("Error preparing statement: ' . $con->error . '");
            window.location.href = "admin_feedback.php";</script>';
        }

        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Feedbacks</title>
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
            padding: 20px;
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
            padding: 10px 20px;
            border: none;
            background-color: #28a745;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
            margin-left: 10px;
        }
        button[type="reset"] {
            background-color: #dc3545;
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
        .feedback-item{
            padding: 15px;
        }
        hr{
            margin-top: 20px;
        }
        p{
            padding: 10px 0;
            font-weight: 700;
            font-size: 20px;
        }
        h3{
            font-weight: 400;
        }
        .reset:hover{
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <?php include('adminnav.php'); ?>
    <section>
        <div class="container">
            <h2>Admin - View and Respond to Feedbacks</h2>
            <div id="feedbacks"></div>
        </div>
    </section>
    <?php include('footer.php') ?>

    <script>
        async function loadFeedbacks() {
            try {
                const response = await fetch('admin_feedback.php?action=get_feedbacks');
                const feedbacks = await response.json();
                const feedbacksDiv = document.getElementById('feedbacks');
                feedbacksDiv.innerHTML = '';
                feedbacks.forEach(fb => {
                    const feedbackElement = document.createElement('div');
                    feedbackElement.classList.add('feedback-item');
                    feedbackElement.innerHTML = `
                        <h3>${fb.username} (${fb.user_email})</h3>
                        <form onsubmit="submitResponse(event, ${fb.feedbackid})">
                            <p>${fb.problem_description}</p>
                            <textarea id="response-${fb.feedbackid}" placeholder="Type your response here..." required>${fb.admin_response || ''}</textarea>
                            <button type="submit">Send Reply</button>
                            <button type="reset" onclick="resetResponse(${fb.feedbackid})" class="reset">Reset</button>
                        </form>
                        <hr>
                    `;
                    feedbacksDiv.appendChild(feedbackElement);
                });
            } catch (error) {
                console.error('Error fetching feedbacks:', error);
                alert('Error fetching feedbacks');
            }
        }

        async function submitResponse(event, feedbackId) {
            event.preventDefault();
            
            const responseText = document.getElementById(`response-${feedbackId}`).value.trim();
            
            if (!responseText) {
                alert('Response cannot be empty');
                return;
            }

            try {
                const formData = new FormData();
                formData.append('id', feedbackId);
                formData.append('response', responseText);
                
                const fetchOptions = {
                    method: 'POST',
                    body: formData
                };

                const response = await fetch('admin_feedback.php?action=respond', fetchOptions);
                const data = await response.text();
                if (data.includes('Reply Successful')) {
                    alert('Reply Successful');
                    loadFeedbacks(); // Reload feedbacks after submission
                } else {
                    alert(`Reply Error: ${data}`);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error submitting response!');
            }
        }

        function resetResponse(feedbackId) {
            document.getElementById(`response-${feedbackId}`).value = '';
        }

        // Load feedbacks initially
        loadFeedbacks();
    </script>
</body>
</html>
