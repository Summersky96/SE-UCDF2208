<?php
session_start();
include('conn.php');
include('mecnavbar.php');

// Search functionality
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $likeSearch = "%$search%";
    $stmt = $con->prepare("SELECT * FROM orders WHERE name LIKE ? OR price LIKE ? OR quantity LIKE ? OR total_price LIKE ? OR order_date LIKE ? OR status LIKE ?");
    $stmt->bind_param("ssssss", $likeSearch, $likeSearch, $likeSearch, $likeSearch, $likeSearch, $likeSearch);
} else {
    $stmt = $con->prepare("SELECT * FROM orders");
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
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
        body.dark-mode .container {
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
        .received-button {
            background-color: #4CAF50;
            color: white;
            padding: 4px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 2px;
        }
        .received-button:hover {
            background-color: #45a049;
        }
        .received-button:disabled {
            background-color: #ddd;
            cursor: not-allowed;
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

        function markAsReceived(orderId) {
            if (confirm("Are you sure you have received this order?")) {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "parthistory.php", true);
                xhr.setRequestHeader("Content-Type", "application/json");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert('Order has been received.');
                    location.reload();
                }
            };

            const data = JSON.stringify({ partsid: orderId, status: 'Received' });
            xhr.send(data);
        }
    }
    </script>
</head>
<body>
    <section>
        <div class="container">
            <h2>Order History</h2>
            <div class="search-bar">
                <form id="searchForm" method="GET" action="parthistory.php">
                    <input type="text" id="searchInput" name="search" placeholder="Search orders..." value="<?= htmlspecialchars($search) ?>">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
            <div class="table-container">
                <table>
                <thead>
                        <tr>
                            <th>No</th>
                            <th>Parts</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Order Date</th>
                            <th>Order Time</th>
                            <th>Status</th>
                            <th class="actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $rowNumber = 1;
                        while ($row = $result->fetch_assoc()): 
                            $orderDateTime = new DateTime($row['order_date']);
                            $orderDate = $orderDateTime->format('Y-m-d');
                            $orderTime = $orderDateTime->format('H:i:s');
                        ?>
                            <tr>
                                <td><?= $rowNumber++ ?></td>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['price']) ?></td>
                                <td><?= htmlspecialchars($row['quantity']) ?></td>
                                <td><?= htmlspecialchars($row['total_price']) ?></td>
                                <td><?= htmlspecialchars($orderDate) ?></td>
                                <td><?= htmlspecialchars($orderTime) ?></td>
                                <td><?= htmlspecialchars($row['status']) ?></td>
                                <td class="actions">
                                    <?php if ($row['status'] !== 'Received'): ?>
                                        <button class="received-button" onclick="markAsReceived(<?= $row['partsid'] ?>, this)">Receive</button>
                                    <?php else: ?>
                                        <button class="received-button" disabled>Received</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php $stmt->close(); ?>
            </div>
            <a href="part.php" class="add-button">Order Now</a>
        </div>
    </section>

    <?php include('footer.php') ?>

    <?php
    // Handle status update request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['partsid'];
        $status = $data['status'];

        $stmt = $con->prepare("UPDATE orders SET status = ? WHERE partsid = ?");
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Status updated successfully";
        } else {
            echo "Error updating status";
        }

        $stmt->close();
        $con->close();
        exit();
    }
    ?>
</body>
</html>

<?php
mysqli_close($con);
?>
