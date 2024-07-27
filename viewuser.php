<?php
session_start();
include('conn.php');

// Check if the user is logged in and has the admin role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo '<script>alert("Access Denied! Only admins can access this page.");window.location.href="loginpage1.php";</script>'; 
    exit();
}

include('adminnav.php');

// Handle user account deletion
if (isset($_GET['delete']) && isset($_GET['category'])) {
    $deleteId = intval($_GET['delete']);
    $category = $_GET['category'];
    if ($category === 'mechanic') {
        $stmt = $con->prepare("DELETE FROM mechanicinfo WHERE mecid = ?");
    } else {
        $stmt = $con->prepare("DELETE FROM userinfo WHERE userid = ?");
    }
    $stmt->bind_param("i", $deleteId);
    $stmt->execute();
    $stmt->close();
    echo '<script>alert("User Deleted!");window.location.href="viewuser.php?category='.$category.'";</script>'; 
    exit();
}

// Handle category selection and search
$search = "";
$category = "user";
if (isset($_GET['category'])) {
    $category = $_GET['category'];
}
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $likeSearch = "%$search%";
    if ($category === 'mechanic') {
        $stmt = $con->prepare("SELECT mecid as userid, name as username, email, telephone FROM mechanicinfo WHERE name LIKE ? OR email LIKE ? OR telephone LIKE ?");
        $stmt->bind_param("sss", $likeSearch, $likeSearch, $likeSearch);
    } else {
        $stmt = $con->prepare("SELECT userid, username, email, telephone FROM userinfo WHERE username LIKE ? OR email LIKE ? OR telephone LIKE ?");
        $stmt->bind_param("sss", $likeSearch, $likeSearch, $likeSearch);
    }
} else {
    if ($category === 'mechanic') {
        $stmt = $con->prepare("SELECT mecid as userid, name as username, email, telephone FROM mechanicinfo");
    } else {
        $stmt = $con->prepare("SELECT userid, username, email, telephone FROM userinfo");
    }
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <style>
        section {
            top: 13%;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
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
        .search-bar {
            margin: 20px 0;
            text-align: center;
        }
        .search-bar input[type="text"] {
            padding: 8px;
            width: 300px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
        .search-bar select {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
        .search-bar button {
            padding: 8px 15px;
            border-radius: 5px;
            border: none;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        .search-bar button:hover {
            background-color: #45a049;
        }
        .table-container {
            width: 100%;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        body.dark-mode th {
            background-color: #577399;
        }
        body.dark-mode td {
            background-color: #4c566a;
        }
        .cancel-button {
            background-color: #ff4d4d;
            color: #fff;
            border: none;
            padding: 4px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .cancel-button:hover {
            background-color: #cc0000;
        }
        .add-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            cursor: pointer;
        }
        .add-button:hover {
            background-color: #45a049;
        }
    </style>
    <link rel="stylesheet" href="login1.css">
    <script>
        function submitCategoryForm() {
            document.getElementById('categoryForm').submit();
        }

        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }

        function saveCursorPosition() {
            const searchInput = document.getElementById('searchInput');
            localStorage.setItem('searchCursorPosition', searchInput.selectionStart);
            localStorage.setItem('searchTerm', searchInput.value);
        }

        function restoreCursorPosition() {
            const searchInput = document.getElementById('searchInput');
            const searchTerm = localStorage.getItem('searchTerm');
            const cursorPosition = localStorage.getItem('searchCursorPosition');
            if (searchTerm !== null && cursorPosition !== null) {
                searchInput.value = searchTerm;
                searchInput.setSelectionRange(cursorPosition, cursorPosition);
                searchInput.focus();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('input', debounce(function() {
                saveCursorPosition();
                document.getElementById('categoryForm').submit();
            }, 300));
            restoreCursorPosition();
        });
    </script>
</head>
<body>
    <section>
        <div class="container">
            <h2>Users</h2>
            <div class="search-bar">
                <form id="categoryForm" method="GET" action="viewuser.php">
                    <select name="category" onchange="submitCategoryForm()">
                        <option value="user" <?= $category == "user" ? 'selected' : '' ?>>Users</option>
                        <option value="mechanic" <?= $category == "mechanic" ? 'selected' : '' ?>>Mechanics</option>
                    </select>
                    <input type="text" id="searchInput" name="search" placeholder="Search users..." value="<?= htmlspecialchars($search) ?>">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Telephone</th>
                            <th class="actions">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['username']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['telephone']) ?></td>
                                <td class="actions">
                                    <form method="GET" action="viewuser.php" style="display:inline;">
                                        <input type="hidden" name="delete" value="<?= $row['userid'] ?>">
                                        <input type="hidden" name="category" value="<?= $category ?>">
                                        <button type="submit" class="cancel-button" onclick="return confirm('Are you sure you want to Delete this user?');">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php $stmt->close(); ?>
            </div>
            <a href="add_user.php" class="add-button">Add User</a>
        </div>
    </section>

    <?php include('footer.php') ?>
    
</body>
</html>

<?php
// Close the database connection
mysqli_close($con);
?>
