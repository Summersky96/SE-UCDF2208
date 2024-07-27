<?php
session_start();
include('conn.php');

if (!isset($_SESSION['role'])) {
    echo '<script>alert("Please Log In!");window.location.href="loginpage1.php";</script>'; 
    exit();
}

// Include the correct navbar based on the user's role
switch ($_SESSION['role']) {
    case 'admin':
        include_once('adminnav.php');
        break;
    case 'mechanic':
        include_once('mecnavbar.php');
        break;
    case 'customer':
    default:
        include_once('navbar.php');
        break;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT subject, content, time, post FROM notifications WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $notification = $result->fetch_assoc();
    if (!$notification) {
        echo "Notification not found.";
        exit();
    }
} else {
    echo "Invalid notification ID.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Detail</title>
    <style>
        section {
            top: 13%;
        }
        .container {
            max-width: 800px;
            width: 800px;
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
        h1 {
            text-align: center;
            padding-bottom: 30px;
            padding-top: 10px;
            font-size: 2rem;
        }
        .contents {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #1e1e1e;
            border-radius: 5px;
        }
        body.dark-mode .contents {
            border: 1px solid #ccc;
        }
        .contents h3 {
            margin-bottom: 5px;
            padding: 5px 0;
            font-size: 2rem;
            text-align: center;
        }
        .contents p {
            margin-bottom: 10px;
            font-weight: 700;
            font-size: 20px;
            text-align: justify;
        }
        em {
            color: grey;
            font-size: 14px;
        }
        body.dark-mode em {
            color: #ccc;
            font-size: 14px;
        }
        button {
            display: flex;
            margin: auto;
            padding: 5px 10px;
            border: none;
            background-color: red;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
            transition: all .2s ease;
        }
        button:hover {
            background-color: darkred;
        }
        .contents video,
        .contents img{
            border-radius: 1rem;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.3);
            max-width: 450px;
            width: 100%;
            display: flex;
            margin: auto;
            padding: 10px;
        }
    </style>
</head>
<body>
    <section>
        <div class="container">
            <div class="title">Notice:</div>
            <h1><?php echo htmlspecialchars($notification['subject']); ?></h1>
            <div class="contents">
                <p><?php echo htmlspecialchars($notification['content']); ?></p>
                <?php if ($notification['post'] && (strpos($notification['post'], '.jpg') !== false || strpos($notification['post'], '.png') !== false)): ?>
                    <img src="<?= htmlspecialchars($notification['post']) ?>" alt="Image">
                <?php elseif ($notification['post'] && (strpos($notification['post'], '.mp4') !== false || strpos($notification['post'], '.mov') !== false)): ?>
                    <video src="<?= htmlspecialchars($notification['post']) ?>" controls></video>
                <?php endif; ?>
                <p><em><?php echo date('M d, Y h:i A', strtotime($notification['time'])); ?></em></p>
            </div>
            <button onclick="window.history.back();" type="button">Back</button>
        </div>
    </section>
    <?php include('footer.php') ?>
</body>
</html>
