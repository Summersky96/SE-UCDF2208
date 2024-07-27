<?php
session_start();
include('conn.php');

// Check if the user is logged in and the role is set
if (!isset($_SESSION['role'])) {
    echo '<script>alert("Please Log In!");window.location.href="loginpage1.php";</script>';
    exit();
}

$unique_id = '';
$pic_field = '';
$username_field = '';
$table = '';

switch ($_SESSION['role']) {
    case 'admin':
        include_once('adminnav.php');
        $unique_id = 'adminid';
        $pic_field = 'adminpic';
        $username_field = 'name';
        $table = 'admininfo';
        break;
    case 'mechanic':
        include_once('mecnavbar.php');
        $unique_id = 'mecid';
        $pic_field = 'mecpic';
        $username_field = 'name';
        $table = 'mechanicinfo';
        break;
    case 'customer':
        include_once('navbar.php');
        $unique_id = 'userid';
        $pic_field = 'userpic';
        $username_field = 'username';
        $table = 'userinfo';
        break;
    default:
        echo "Invalid role.";
        exit();
}

// Fetch the current user's email based on role
$outgoing_id = $_SESSION[$unique_id];
switch ($_SESSION['role']) {
    case 'admin':
        $sql_outgoing = "SELECT adminemail AS email FROM admininfo WHERE adminid = '{$outgoing_id}'";
        break;
    case 'mechanic':
        $sql_outgoing = "SELECT email FROM mechanicinfo WHERE mecid = '{$outgoing_id}'";
        break;
    default:
        $sql_outgoing = "SELECT email FROM userinfo WHERE userid = '{$outgoing_id}'";
        break;
}

$result_outgoing = mysqli_query($con, $sql_outgoing);
if ($row_outgoing = mysqli_fetch_assoc($result_outgoing)) {
    $user_email = $row_outgoing['email'];
} else {
    echo "Error: User email not found.";
    exit();
}

// Sanitize input
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Function to handle file upload
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
        }
    }
    return null;
}

// Function to fetch posts from the database
function getPosts() {
    global $con, $username_field, $pic_field;
    $result = $con->query("SELECT p.postsid, p.content, p.media_url, DATE_FORMAT(p.created_at, '%b %d, %Y %h:%i %p') AS created_at, p.user_email,
                           COALESCE(a.name, m.name, c.username) AS username,
                           COALESCE(a.adminpic, m.mecpic, c.userpic) AS userpic 
                           FROM posts p 
                           LEFT JOIN admininfo a ON p.user_email = a.adminemail 
                           LEFT JOIN mechanicinfo m ON p.user_email = m.email 
                           LEFT JOIN userinfo c ON p.user_email = c.email 
                           ORDER BY p.created_at DESC");
    if (!$result) {
        echo "Error: " . $con->error;
        return [];
    }
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return []; // Return an empty array if no posts are found
    }
}

// Function to fetch comments for a specific post
function getComments($post_id) {
    global $con, $table, $username_field, $pic_field;
    
    $stmt = $con->prepare("SELECT c.commentsid, c.content, DATE_FORMAT(c.created_at, '%b %d, %Y %h:%i %p') AS created_at, c.user_email,
                           COALESCE(a.name, m.name, u.username) AS username,
                           COALESCE(a.adminpic, m.mecpic, u.userpic) AS userpic 
                           FROM comments c 
                           LEFT JOIN admininfo a ON c.user_email = a.adminemail
                           LEFT JOIN mechanicinfo m ON c.user_email = m.email 
                           LEFT JOIN userinfo u ON c.user_email = u.email 
                           WHERE c.post_id = ? 
                           ORDER BY c.created_at DESC");

    if (!$stmt) {
        echo "Prepare failed: (" . $con->errno . ") " . $con->error;
        return [];
    }

    $stmt->bind_param("i", $post_id);
    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        return [];
    }

    $result = $stmt->get_result();
    if (!$result) {
        echo "Get result failed: (" . $stmt->errno . ") " . $stmt->error;
        return [];
    }

    $comments = $result->fetch_all(MYSQLI_ASSOC);
    return $comments;
}

// Handle post creation
if (isset($_POST['createPost'])) {
    $user_role = $_SESSION['role'];
    $content = sanitizeInput($_POST['content']);
    $media_url = null;

    // Handle file upload (image or video)
    $media_url = handleFileUpload('postMedia', 'forum-media/');

    if (!empty($content) && $user_email) {
        $stmt = $con->prepare("INSERT INTO posts (user_email, user_role, content, media_url, created_at) VALUES (?, ?, ?, ?, NOW())");
        if (!$stmt) {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $con->error]);
            exit();
        }
        $stmt->bind_param("ssss", $user_email, $user_role, $content, $media_url);
        if ($stmt->execute()) {
            echo '<script>alert("Post successful!");window.location.href="testforum.php";</script>';
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: Content and user information are required.']);
    }
    exit();
}

// Handle comment creation
if (isset($_POST['createComment'])) {
    $post_id = $_POST['post_id'];
    $content = sanitizeInput($_POST['content']);

    if (!empty($content) && $user_email) {
        $stmt = $con->prepare("INSERT INTO comments (post_id, user_email, content, created_at) VALUES (?, ?, ?, NOW())");
        if (!$stmt) {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $con->error]);
            exit();
        }
        $stmt->bind_param("iss", $post_id, $user_email, $content);
        if ($stmt->execute()) {
            echo '<script>alert("Comment successful!");window.location.href="testforum.php";</script>';
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: Content and user information are required.']);
    }
    exit();
}

// Handle post deletion
if (isset($_POST['deletePost'])) {
    $post_id = $_POST['post_id'];
    
    // Admin can delete any post
    if ($_SESSION['role'] === 'admin') {
        $stmt = $con->prepare("DELETE FROM posts WHERE postsid = ?");
        if (!$stmt) {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $con->error]);
            exit();
        }
        $stmt->bind_param("i", $post_id);
        if ($stmt->execute()) {
            echo '<script>alert("Post deleted!");window.location.href="testforum.php";</script>';
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        // Customers and mechanics can delete only their own posts
        $stmt = $con->prepare("DELETE FROM posts WHERE postsid = ? AND user_email = ?");
        if (!$stmt) {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $con->error]);
            exit();
        }
        $stmt->bind_param("is", $post_id, $user_email);
        if ($stmt->execute()) {
            echo '<script>alert("Post deleted!");window.location.href="testforum.php";</script>';
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);
        }
        $stmt->close();
    }
}

// Handle comment deletion
if (isset($_POST['deleteComment'])) {
    $comment_id = $_POST['comment_id'];
    
    // Admin can delete any comment
    if ($_SESSION['role'] === 'admin') {
        $stmt = $con->prepare("DELETE FROM comments WHERE commentsid = ?");
        if (!$stmt) {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $con->error]);
            exit();
        }
        $stmt->bind_param("i", $comment_id);
        if ($stmt->execute()) {
            echo '<script>alert("Comment deleted!");window.location.href="testforum.php";</script>';
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        // Customers and mechanics can delete only their own comments
        $stmt = $con->prepare("DELETE FROM comments WHERE commentsid = ? AND user_email = ?");
        if (!$stmt) {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $con->error]);
            exit();
        }
        $stmt->bind_param("is", $comment_id, $user_email);
        if ($stmt->execute()) {
            echo '<script>alert("Comment deleted!");window.location.href="testforum.php";</script>';
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);
        }
        $stmt->close();
    }
}

// Fetch posts and comments
$posts = getPosts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Automate Forum</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 60%;
            width: 100%;
            margin: auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        body.dark-mode .container{
            background-color: #2e3440;
        }
        .container h2{
            display: flex;
            justify-content: center;
            align-content: center;
            padding: 10px;
            font-size: 2rem;
        }
        .container h2 span{
            display: flex;
            padding-left: 5px;
            align-content: center;
        }
        section{
            top: 13%;
            color: #000;
            transition: all 0.3s ease;
        }
        body.dark-mode section{
            color: #fff;
        }
        .post {
            position: relative;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        body.dark-mode .post{
            background-color: #434c5e;
            border: 1px solid #3b4252;
        }
        .post-section{
            display: flex;
        }
        .user-profile {
            /* position: relative; */
            display: flex;
            /* width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 10px; */
        }
        .user-profile h3{
            justify-self: center;
            align-self: center;
            padding-left: 5px;
        }
        .user-profile img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 10px;
            object-fit: cover;
        }
        .post-content {
            flex: 1;
            padding-left: 10px;
            margin-top: 2%;
        }
        .post-content .contents{
            font-size: 20px;
            font-weight: 550;
            padding: 20px 0;
            text-align: justify;
        }
        .post-content video,
        .post-content img{
            border-radius: 1rem;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.3);
            max-width: 450px;
            width: 100%;
        }
        .comment-content .contents{
            font-size: 17px;
            padding: 5px 0;
        }
        .comment-content .time{
            font-size: 11px;
            padding: 5px 0;
        }
        .post-content .time{
            padding: 10px 0;
            font-size: 13px;
            padding-top: 20px;
        }
        .comments {
            margin-top: 10px;
        }
        .comment {
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
            border: 1px solid #3b4252;
            border-radius: 5px;
            display: flex;
        }
        .comment .user-profile {
            margin-right: 10px;
        }
        .comment .comment-content {
            flex: 1;
        }
        .comment p {
            margin: 5px 0;
        }
        .comment-form {
            position: sticky;
            margin-top: 10px;
            display: flex;
            align-items: center;
            bottom: 0;
            z-index: 10;
            padding: 10px;
        }
        .comment-form textarea {
            width: calc(100% - 80px); /* Adjust based on your design */
            margin-right: 10px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            resize: none;
        }
        .comment-form button {
            padding: 10px 20px;
            background-color: #ffe000;
            color: black;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: all .1s ease;
        }
        .comment-form button:hover {
            background-color: #F8CF2C;
        }
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            z-index: 1000; /* Ensure it's above other content */
        }
        body.dark-mode .popup{
            background-color: #4c566a;
        }
        .popup h2 {
            margin-top: 0;
            font-size: 24px;
        }
        .popup textarea {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            resize: none;
        }
        body.dark-mode .popup textarea{
            border: 1px solid #3b4252;
        }
        .popup input[type=file] {
            margin-bottom: 10px;
        }
        .popup button {
            padding: 10px 20px;
            background-color: #ffe000;
            color: #000;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .popup button:hover {
            background-color: #F8CF2C;
        }
        /* Styling for the add post button */
        .add-post-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #ffe000;
            color: #000;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            text-align: center;
            font-size: 24px;
            line-height: 50px;
            cursor: pointer;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2);
            z-index: 1000; /* Ensure it's above other content */
        }
        /* Styling for the overlay */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999; /* Ensure it's above other content */
        }
        .comment {
            position: relative; /* Ensure position context for absolute positioning */
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            display: flex;
            justify-content: space-between; /* Align items horizontally */
            align-items: flex-start; /* Align items vertically */
        }
        body.dark-mode .comment{
            background-color: #2e3440;
            border: 1px solid #3b4252;
        }

        .delete-post-form,
        .delete-comment-form {
            position: absolute;
            top: 10px; /* Adjust top position */
            right: 10px; /* Adjust right position */
        }

        .delete-post-form button,
        .delete-comment-form button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 20px;
            color: grey;
            transition: all .3s ease;
        }

        .delete-post-form button:hover,
        .delete-comment-form button:hover{
            color: red;
        }

        .show-replies-btn:hover {
            border: solid 1px #F8CF2C;
        }
        .show-replies-btn {
            background:none;
            color: #000;
            padding: 10px 20px;
            border: solid 1px transparent;
            cursor: pointer;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: all 0.1s ease;
        }
        body.dark-mode .show-replies-btn{
            color: #ffe00f;
        }

        .arrow-icon {
            margin-left: 10px; /* Adjust as needed */
            transition: transform 0.3s ease;
        }

        .arrow-icon.rotate {
            transform: rotate(180deg);
        }

        .comments {
            display: none;
            max-height: 0; /* Initially hidden */
            overflow: auto;
            transition: all 0.5s ease-out;
            margin-bottom: 10px;
        }

        .comments.active {
            display: block;
            max-height: 500px; /* Adjust this value based on your design */
        }
        .comments::-webkit-scrollbar{
            width: 8px;
        }
        .comments::-webkit-scrollbar-track {
            box-shadow: inset 0 0 5px grey; 
            border-radius: 10px;
        }
        .comments::-webkit-scrollbar-thumb {
            background: #7a7a7a; 
            border-radius: 10px;
        }
        .comments::-webkit-scrollbar-thumb:hover {
            background: #696969; 
            cursor: pointer;
        }
        .form-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .popup h2{
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px 0;
        }
        .buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }
        .preview {
            margin-top: 10px;
        }
        .preview img, .preview video {
            max-width: 100%;
            height: auto;
        }
        textarea {
            width: 100%;
            max-width: 700px;
        }
        body.dark-mode textarea{
            background-color: #d8dee9;
        }
        input[type="file"] {
            margin-top: 10px;
        }
        .no-posts {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
            text-align: center;
            background-color: #f0f0f0;
            border-radius: 8px;
            margin-top: 20px;
        }
        body.dark-mode .no-posts{
            background-color: #434c5e;
            border: 1px solid #3b4252;
        }
        .no-posts p {
            font-size: 24px;
            color: #555;
            transition: all .2s ease;
        }
        body.dark-mode .no-posts p{
            color: #f0f0f0;
        }
    </style>
</head>
<body>
    <section>
        <div class="container">
            <h2>Forum <span><i class="fa-regular fa-comment-dots"></i></span></h2>
            <?php if (empty($posts)): ?>
                <div class="no-posts">
                    <p>No post yet ...</p>
                </div>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <div class="post">
                        <div class="post-section">
                            <div class="user-profile">
                                <img src="<?= htmlspecialchars($post['userpic']) ?>" alt="Profile Picture">
                            </div>
                            <div class="post-content">
                                <h3><?= htmlspecialchars($post['username']) ?></h3>
                                <p class="contents"><?= htmlspecialchars($post['content']) ?></p>
                                <?php if (strpos($post['media_url'], '.jpg') !== false || strpos($post['media_url'], '.png') !== false): ?>
                                    <img src="<?= htmlspecialchars($post['media_url']) ?>" alt="Image">
                                <?php elseif (strpos($post['media_url'], '.mp4') !== false || strpos($post['media_url'], '.mov') !== false): ?>
                                    <video src="<?= htmlspecialchars($post['media_url']) ?>" controls></video>
                                <?php endif; ?>
                                <p class="time"><?= htmlspecialchars($post['created_at']) ?></p>
                                <?php if ($_SESSION['role'] === 'admin' || $post['user_email'] === $user_email): ?>
                                    <form class="delete-post-form" method="post" action="testforum.php">
                                        <input type="hidden" name="post_id" value="<?= $post['postsid'] ?>">
                                        <button type="submit" name="deletePost" class="delete-button">
                                            <i class='bx bxs-trash'></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                        <button class="show-replies-btn">
                            Show Replies
                            <i class="bx bxs-chevron-down arrow-icon"></i>
                        </button>

                        <div class="comments">
                            <?php
                            $comments = getComments($post['postsid']);
                            foreach ($comments as $comment):
                            ?>
                                <div class="comment">
                                    <div class="user-profile">
                                        <img src="<?= htmlspecialchars($comment['userpic']) ?>" alt="Profile Picture">
                                    </div>
                                    <div class="comment-content">
                                        <h4><?= htmlspecialchars($comment['username']) ?></h4>
                                        <p class="contents"><?= htmlspecialchars($comment['content']) ?></p>
                                        <p class="time"><?= htmlspecialchars($comment['created_at']) ?></p>
                                        <?php if ($_SESSION['role'] === 'admin' || $comment['user_email'] === $user_email): ?>
                                            <form class="delete-comment-form" method="post" action="testforum.php">
                                                <input type="hidden" name="comment_id" value="<?= $comment['commentsid'] ?>">
                                                <button type="submit" name="deleteComment" class="delete-button">
                                                    <i class='bx bxs-trash'></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <form class="comment-form" method="post" action="testforum.php">
                                <input type="hidden" name="post_id" value="<?= $post['postsid'] ?>">
                                <textarea name="content" placeholder="Write a comment..." required></textarea>
                                <button type="submit" name="createComment">Comment</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    
        <!-- + Button for Adding Post -->
        <div class="add-post-button" onclick="togglePopup()">+</div>
    
        <!-- Dark Overlay -->
        <div class="overlay" onclick="togglePopup()"></div>
    
        <!-- Popup for Adding Post -->
        <div class="popup" id="addPostPopup">
            <h2>Add Post</h2>
            <form method="post" action="testforum.php" enctype="multipart/form-data" class="form-container">
                <textarea name="content" placeholder="Write something..." required></textarea>
                <input type="file" name="postMedia" accept="image/*, video/*" id="postMedia">
                <div class="preview" id="mediaPreview"></div>
                <div class="buttons">
                    <button type="submit" name="createPost">Post</button>
                    <button type="reset" id="resetForm">Reset</button>
                </div>
            </form>
        </div>
    </section>
    <?php include('footer.php') ?>

    <script>
        function togglePopup() {
            var popup = document.getElementById('addPostPopup');
            var overlay = document.querySelector('.overlay');
            if (popup.style.display === 'block') {
                popup.style.display = 'none';
                overlay.style.display = 'none';
            } else {
                popup.style.display = 'block';
                overlay.style.display = 'block';
            }
        }

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

        document.addEventListener('DOMContentLoaded', function() {
            const showRepliesButtons = document.querySelectorAll('.show-replies-btn');

            showRepliesButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const arrowIcon = this.querySelector('.arrow-icon');
                    const comments = this.nextElementSibling;

                    comments.classList.toggle('active');
                    arrowIcon.classList.toggle('rotate');
                });
            });
        });

    </script>
</body>
</html>
