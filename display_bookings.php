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

// Handle booking status update
if (isset($_GET['action']) && isset($_GET['bookingid'])) {
    $action = $_GET['action'];
    $bookingid = intval($_GET['bookingid']);
    $status = ($action == 'accept') ? 'Confirmed' : 'Rejected';
    $stmt = $con->prepare("UPDATE booking SET status = ? WHERE bookingid = ?");
    $stmt->bind_param("si", $status, $bookingid);
    $stmt->execute();
    $stmt->close();
    echo '<script>alert("Booking status updated!");window.location.href="display_bookings.php";</script>'; 
    exit();
}

// Handle booking cancellation
if (isset($_GET['cancel'])) {
    $cancelId = intval($_GET['cancel']);
    $stmt = $con->prepare("UPDATE booking SET status = 'Canceled' WHERE bookingid = ? AND userid = ?");
    $stmt->bind_param("ii", $cancelId, $_SESSION['userid']);
    $stmt->execute();
    $stmt->close();
    echo '<script>alert("Booking Canceled!");window.location.href="display_bookings.php";</script>'; 
    exit();
}

// Fetch bookings based on user role
$search = "";
$today = date('Y-m-d');
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $likeSearch = "%$search%";
    if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'mechanic') {
        // Admin and mechanic can view all bookings
        $stmt = $con->prepare("SELECT * FROM booking WHERE customer LIKE ? OR carname LIKE ? OR cusphone LIKE ? OR plate LIKE ? OR date LIKE ? OR service LIKE ? OR otherService LIKE ? OR status LIKE ?");
        $stmt->bind_param("ssssssss", $likeSearch, $likeSearch, $likeSearch, $likeSearch, $likeSearch, $likeSearch, $likeSearch, $likeSearch);
    } else {
        // Customer can only view their own bookings
        $stmt = $con->prepare("SELECT * FROM booking WHERE userid = ? AND (customer LIKE ? OR carname LIKE ? OR cusphone LIKE ? OR plate LIKE ? OR date LIKE ? OR service LIKE ? OR otherService LIKE ? OR status LIKE ?)");
        $stmt->bind_param("issssssss", $_SESSION['userid'], $likeSearch, $likeSearch, $likeSearch, $likeSearch, $likeSearch, $likeSearch, $likeSearch, $likeSearch);
    }
} else {
    if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'mechanic') {
        // Admin and mechanic can view all bookings
        $stmt = $con->prepare("SELECT * FROM booking");
    } else {
        // Customer can only view their own bookings
        $stmt = $con->prepare("SELECT * FROM booking WHERE userid = ?");
        $stmt->bind_param("i", $_SESSION['userid']);
    }
}
$stmt->execute();
$result = $stmt->get_result();

// Update status to 'Expired' for past bookings
$updateStmt = $con->prepare("UPDATE booking SET status = 'Expired' WHERE date < ? AND status != 'Expired'");
$updateStmt->bind_param("s", $today);
$updateStmt->execute();
$updateStmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Bookings</title>
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
        .action-buttons button {
            background-color: #4CAF50;
            color: white;
            padding: 4px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 2px;
        }
        .action-buttons button.reject {
            background-color: #ff4d4d;
        }
        .action-buttons button:hover {
            background-color: #45a049;
        }
        .action-buttons button.reject:hover {
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
        td .fa:hover {
            color: #ffe000;
        }
        td .fa-pen-to-square{
            color: #000;
        }
        body.dark-mode td .fa-pen-to-square{
            color: #fff;
        }
    </style>
    <link rel="stylesheet" href="login1.css">
    <script>
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
                document.getElementById('searchForm').submit();
            }, 300));
            restoreCursorPosition();
        });
    </script>
</head>
<body>
    <section>
        <div class="container">
            <h2>Bookings</h2>
            <div class="search-bar">
                <form id="searchForm" method="GET" action="display_bookings.php">
                    <input type="text" id="searchInput" name="search" placeholder="Search bookings..." value="<?= htmlspecialchars($search) ?>">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Car Model</th>
                            <th>Number Plate</th>
                            <th>Date</th>
                            <th>Service</th>
                            <th>Other Service</th>
                            <th>Status</th>
                            <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'mechanic'): ?>
                                <th>Actions</th>
                            <?php else: ?>
                                <th>Cancel Booking</th>
                            <?php endif; ?>
                            <th class="actions">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <?php
                                $isExpired = strtotime($row['date']) < strtotime($today);
                                if ($isExpired && $row['status'] != 'Expired') {
                                    $row['status'] = 'Expired';
                                }
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($row['customer']) ?></td>
                                <td><?= htmlspecialchars($row['cusphone']) ?></td>
                                <td><?= htmlspecialchars($row['carname']) ?></td>
                                <td><?= htmlspecialchars($row['plate']) ?></td>
                                <td><?= htmlspecialchars($row['date']) ?></td>
                                <td><?= htmlspecialchars($row['service']) ?></td>
                                <td><?= htmlspecialchars($row['otherService']) ?></td>
                                <td><?= htmlspecialchars($row['status']) ?></td>
                                <?php if (!$isExpired): ?>
                                    <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'mechanic'): ?>
                                        <td class="actions action-buttons">
                                            <?php if ($row['status'] != 'Confirmed' && $row['status'] != 'Rejected' && $row['status'] != 'Canceled'): ?>
                                                <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'mechanic'): ?>
                                                    <a href="display_bookings.php?action=accept&bookingid=<?= $row['bookingid'] ?>">
                                                        <button type="button" onclick="return confirm('Are you sure you want to accept this booking?');" <?= ($row['status'] == 'Confirmed' || $row['status'] == 'Rejected' || $row['status'] == 'Canceled') ? 'disabled' : '' ?> <?= ($row['status'] == 'Confirmed' || $row['status'] == 'Rejected' || $row['status'] == 'Canceled') ? 'style="background-color:#e0e0e0;color:#a0a0a0;cursor:not-allowed;"' : '' ?>>Accept</button>
                                                    </a>
                                                <?php else: ?>
                                                    <button type="button" disabled style="background-color:#e0e0e0;color:#a0a0a0;cursor:not-allowed;">Accept</button>
                                                <?php endif; ?>

                                                <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'mechanic'): ?>
                                                    <a href="display_bookings.php?action=reject&bookingid=<?= $row['bookingid'] ?>">
                                                        <button type="button" class="reject" onclick="return confirm('Are you sure you want to reject this booking?');" <?= ($row['status'] == 'Confirmed' || $row['status'] == 'Rejected' || $row['status'] == 'Canceled') ? 'disabled' : '' ?> <?= ($row['status'] == 'Confirmed' || $row['status'] == 'Rejected' || $row['status'] == 'Canceled') ? 'style="background-color:#e0e0e0;color:#a0a0a0;cursor:not-allowed;"' : '' ?>>Reject</button>
                                                    </a>
                                                <?php else: ?>
                                                    <button type="button" class="reject" disabled style="background-color:#e0e0e0;color:#a0a0a0;cursor:not-allowed;">Reject</button>
                                                <?php endif; ?>
                                            <?php elseif ($row['status'] == 'Confirmed'): ?>
                                                <button type="button" disabled style="background-color:#e0e0e0;color:#a0a0a0;cursor:not-allowed;">Accepted</button>
                                            <?php elseif ($row['status'] == 'Rejected'): ?>
                                                <button type="button" disabled style="background-color:#e0e0e0;color:#a0a0a0;cursor:not-allowed;">Rejected</button>
                                            <?php elseif ($row['status'] == 'Canceled'): ?>
                                                <button type="button" disabled style="background-color:#e0e0e0;color:#a0a0a0;cursor:not-allowed;">Canceled</button>
                                            <?php endif; ?>
                                        </td>


                                    <?php else: ?>
                                        <td class="actions">
                                            <form method="GET" action="display_bookings.php" style="display:inline;">
                                            <?php if ($row['status'] == 'Rejected' || $row['status'] == 'Canceled' ): ?>
                                                <button type="button" class="cancel-button" disabled style="background-color:#e0e0e0;color:#a0a0a0;cursor:not-allowed;">Cancel</button>
                                            <?php else: ?>
                                                <input type="hidden" name="cancel" value="<?= $row['bookingid'] ?>">
                                                <button type="submit" class="cancel-button" onclick="return confirm('Are you sure you want to Cancel this booking?');">Cancel</button>
                                            <?php endif; ?>
                                            </form>
                                        </td>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <td class="actions">No Actions Available</td>
                                <?php endif; ?>
                                <td class="actions">
                                    <a href="editbookingpage.php?bookingid=<?= $row['bookingid'] ?>">
                                        <i class="fa-solid fa-pen-to-square" style="cursor:pointer;"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php $stmt->close(); ?>
            </div>
            <a href="add_booking.php" class="add-button">Add Booking</a>
        </div>
    </section>

    <?php include('footer.php') ?>
    
</body>
</html>

<?php
// Close the database connection
mysqli_close($con);
?>
