<?php
session_start();
include('adminnav.php');
if ($_SESSION['role'] != 'admin') {
    header("Location: loginpage1.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        section{
            top: 13%;
         }
        .container {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            color: #000;
            width: 100%;
            max-width: 520px;
            transition: all .2s ease;
        }
        body.dark-mode .container{
            background-color: #3b4252;
            color: white;
        }
        .container h2 {
            margin-top: 0;
            padding-bottom: 20px;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            
        }
        input[type="text"],
        textarea {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
        }
        button {
            padding: 10px;
            font-size: 16px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .preview {
            padding: 20px;
        }
        .preview img, .preview video {
            max-width: 100%;
            height: 355px;
            max-width: 450px;
        }
        .buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }
        #resetForm{
            background-color: #dc3545;
        }
        #resetForm:hover{
            background-color: #c82333;
        }
        input[type="file"] {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <section>
        <div class="container">
            <h2>Post a Notification</h2>
            <form action="post_notification.php" method="POST" enctype="multipart/form-data">
                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" required>
                <label for="content">Content:</label>
                <textarea id="content" name="content" rows="5" required></textarea>
                <input type="file" name="postMedia" accept="image/*, video/*" id="postMedia">
                <div class="preview" id="mediaPreview"></div>
            <div class="buttons">
                <button type="submit">Post Notification</button>
                <button type="reset" id="resetForm">Reset</button>
            </div>
            </form>
        </div>
    </section>
    <?php include('footer.php') ?>
    <script>
         document.getElementById('postMedia').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('mediaPreview');
            previewContainer.innerHTML = '';

            if (file) {
                const fileURL = URL.createObjectURL(file);
                if (file.type.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.src = fileURL;
                    previewContainer.appendChild(img);
                } else if (file.type.startsWith('video/')) {
                    const video = document.createElement('video');
                    video.src = fileURL;
                    video.controls = true;
                    previewContainer.appendChild(video);
                }
            }
        });

        document.getElementById('resetForm').addEventListener('click', function() {
            const previewContainer = document.getElementById('mediaPreview');
            previewContainer.innerHTML = '';
        });
    </script>
</body>
</html>
