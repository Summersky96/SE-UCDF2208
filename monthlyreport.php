<?php
session_start();
include('adminnav.php');
include('conn.php');

// Check if the user is logged in and has the admin role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo '<script>alert("Access Denied! Only admins can access this page.");window.location.href="loginpage1.php";</script>'; 
    exit();
}

// Get the selected month or default to the current month
$month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
$startDate = $month . '-01';
$endDate = date("Y-m-t", strtotime($startDate));

// Fetch total income for the current month
$earningsQuery = $con->prepare("SELECT SUM(amount) as total_earnings FROM earnings WHERE date BETWEEN ? AND ?");
$earningsQuery->bind_param("ss", $startDate, $endDate);
$earningsQuery->execute();
$earningsResult = $earningsQuery->get_result();
$totalEarnings = $earningsResult->fetch_assoc()['total_earnings'] ?: 0;
$earningsQuery->close();

// Fetch total expenses for the current month
$expensesQuery = $con->prepare("SELECT SUM(amount) as total_expenses FROM expenses WHERE date BETWEEN ? AND ?");
$expensesQuery->bind_param("ss", $startDate, $endDate);
$expensesQuery->execute();
$expensesResult = $expensesQuery->get_result();
$totalExpenses = $expensesResult->fetch_assoc()['total_expenses'] ?: 0;
$expensesQuery->close();

// Fetch income breakdown by category
$categories = ["Car Service", "Car Battery", "Engines", "Tyres", "Air Conds", "Audio", "Modification", "Maintenance"];
$incomeBreakdown = [];
foreach ($categories as $category) {
    $categoryQuery = $con->prepare("SELECT SUM(amount) as total FROM earnings WHERE date BETWEEN ? AND ? AND description = ?");
    $categoryQuery->bind_param("sss", $startDate, $endDate, $category);
    $categoryQuery->execute();
    $categoryResult = $categoryQuery->get_result();
    $incomeBreakdown[$category] = $categoryResult->fetch_assoc()['total'] ?: 0;
    $categoryQuery->close();
}

// Fetch expense breakdown by category
$expenseCategories = ["Rent", "Utilities", "Payroll", "Parts", "External Fees"];
$expenseBreakdown = [];
foreach ($expenseCategories as $category) {
    $categoryQuery = $con->prepare("SELECT SUM(amount) as total FROM expenses WHERE date BETWEEN ? AND ? AND description = ?");
    $categoryQuery->bind_param("sss", $startDate, $endDate, $category);
    $categoryQuery->execute();
    $categoryResult = $categoryQuery->get_result();
    $expenseBreakdown[$category] = $categoryResult->fetch_assoc()['total'] ?: 0;
    $categoryQuery->close();
}

// Fetch daily income trends
$dailyIncomeQuery = $con->prepare("SELECT date, SUM(amount) as daily_total FROM earnings WHERE date BETWEEN ? AND ? GROUP BY date");
$dailyIncomeQuery->bind_param("ss", $startDate, $endDate);
$dailyIncomeQuery->execute();
$dailyIncomeResult = $dailyIncomeQuery->get_result();
$dailyIncome = [];
while ($row = $dailyIncomeResult->fetch_assoc()) {
    $dailyIncome[$row['date']] = $row['daily_total'];
}
$dailyIncomeQuery->close();

// Fetch previous 6 months income and expenses for comparison charts
$monthlyComparisonQuery = $con->prepare("
    SELECT DATE_FORMAT(date, '%Y-%m') as month, 
    SUM(CASE WHEN description IN ('Car Service', 'Car Battery', 'Engines', 'Tyres', 'Air Conds', 'Audio', 'Modification', 'Maintenance') THEN amount ELSE 0 END) as total_earnings,
    SUM(CASE WHEN description IN ('Rent', 'Utilities', 'Payroll', 'Parts', 'External Fees') THEN amount ELSE 0 END) as total_expenses
    FROM (
        SELECT date, amount, description FROM earnings WHERE date >= DATE_SUB(?, INTERVAL 6 MONTH)
        UNION ALL
        SELECT date, amount, description FROM expenses WHERE date >= DATE_SUB(?, INTERVAL 6 MONTH)
    ) as combined
    GROUP BY month
    ORDER BY month
");
$monthlyComparisonQuery->bind_param("ss", $startDate, $startDate);
$monthlyComparisonQuery->execute();
$monthlyComparisonResult = $monthlyComparisonQuery->get_result();
$monthlyIncomeExpenses = [];
while ($row = $monthlyComparisonResult->fetch_assoc()) {
    $monthlyIncomeExpenses[$row['month']] = $row;
}
$monthlyComparisonQuery->close();

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Report</title>
    <style>
        section {
            top: 13%;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 1200px;
            margin-bottom: 20px;
            color: #111;
            transition: all 0.2s ease;
        }

        body.dark-mode .container{
            background-color: #333;
            color: #fff;
        }
        h2, h3, h4 {
            text-align: center;
            color: #1e1e1e;
            transition: all 0.1s ease;
        }

        body.dark-mode h2,
        body.dark-mode h3,
        body.dark-mode h4{
            color: #fff;
        }

        .section {
            margin-top: 20px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 20px;
        }
        .section p {
            margin: 5px 0;
            color: #111;
            transition: all 0.1s ease;
        }
        body.dark-mode .section p{
            color: #fff;
        }
        .chart-container {
            width: 30%;
            position: relative;
        }
        canvas {
            background: transparent;
        }
        
        .full-width-chart {
            width: 70%;
            position: relative;
            margin-top: 20px;
        }
        .section .full-width-chart{
            padding: 20px 10px;
        }
        .full-width-chart.daily{
            display: flex;
            flex-direction: column;
            margin: auto;
            padding: 20px;
        }
        .section .details{
            font-size: 1.3rem;
        }
        .section.summary{
            padding: 20px;
        }
        .pdf {
            position: absolute;
            top: 3%;
            right: 15%;
            padding: 5px 10px;
            background-color: grey;
            color: #ffe000;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: 600;
        }
        .pdf:hover {
            background-color: #ffe000;
            color: black;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
    <link rel="stylesheet" href="login1.css">
</head>
<body>
    <section>
        <div class="container">
            <h2>AutoMate Car Maintenance and Service</h2>
            <h3>Monthly Financial Report for <?= date("F Y", strtotime($startDate)) ?></h3>
            <p>Generated on: <?= date("F j, Y") ?></p>
            <button class="pdf" onclick="generatePDF()">Generate PDF File</button>
            <hr>
            <div class="section breakdown">
                <div class="details">
                    <h4>Income Breakdown:</h4>
                    <?php foreach ($incomeBreakdown as $category => $amount): ?>
                        <p><?= $category ?>: RM <?= number_format($amount, 2) ?></p>
                    <?php endforeach; ?>
                </div>
                <div class="chart-container">
                    <h4>Income by Category</h4>
                    <canvas id="incomeChart"></canvas>
                </div>
            </div>
            
            <div class="section breakdown">
                <div class="chart-container">
                    <h4>Expenses by Category</h4>
                    <canvas id="expensesChart"></canvas>
                </div>
                <div class="details">
                    <h4>Expenses Breakdown:</h4>
                    <?php foreach ($expenseBreakdown as $category => $amount): ?>
                        <p><?= $category ?>: RM <?= number_format($amount, 2) ?></p>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="section summary">
                <div class="details">
                    <h4>Summary:</h4>
                    <p>Total Income: RM <?= number_format($totalEarnings, 2) ?></p>
                    <p>Total Expenses: RM <?= number_format($totalExpenses, 2) ?></p>
                    <p>Net Profit/Loss: RM <?= number_format($totalEarnings - $totalExpenses, 2) ?></p>
                </div>
            </div>
            
            <div class="full-width-chart daily">
                <h4>Daily Income</h4>
                <canvas id="dailyIncomeChart"></canvas>
            </div>
                
            <div class="section compare">
                <div class="full-width-chart">
                    <h4>Income Comparison (Last 6 Months)</h4>
                    <canvas id="incomeComparisonChart"></canvas>
                </div>
    
                <div class="full-width-chart">
                    <h4>Expenses Comparison (Last 6 Months)</h4>
                    <canvas id="expensesComparisonChart"></canvas>
                </div>
            </div>
        </div>
    </section>

    <?php include('footer.php'); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const incomeData = <?= json_encode(array_values($incomeBreakdown)) ?>;
            const incomeLabels = <?= json_encode(array_keys($incomeBreakdown)) ?>;
            const expensesData = <?= json_encode(array_values($expenseBreakdown)) ?>;

            const expensesLabels = <?= json_encode(array_keys($expenseBreakdown)) ?>;
            const dailyIncomeData = <?= json_encode(array_values($dailyIncome)) ?>;
            const dailyIncomeLabels = <?= json_encode(array_keys($dailyIncome)) ?>;
            const monthlyComparisonLabels = <?= json_encode(array_keys($monthlyIncomeExpenses)) ?>;
            const monthlyIncomeData = <?= json_encode(array_column($monthlyIncomeExpenses, 'total_earnings')) ?>;
            const monthlyExpensesData = <?= json_encode(array_column($monthlyIncomeExpenses, 'total_expenses')) ?>;

            const incomeChartCtx = document.getElementById('incomeChart').getContext('2d');
            const expensesChartCtx = document.getElementById('expensesChart').getContext('2d');
            const dailyIncomeChartCtx = document.getElementById('dailyIncomeChart').getContext('2d');
            const incomeComparisonChartCtx = document.getElementById('incomeComparisonChart').getContext('2d');
            const expensesComparisonChartCtx = document.getElementById('expensesComparisonChart').getContext('2d');

            new Chart(incomeChartCtx, {
                type: 'pie',
                data: {
                    labels: incomeLabels,
                    datasets: [{
                        label: 'Income by Category',
                        data: incomeData,
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(201, 203, 207, 0.2)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(201, 203, 207, 1)'
                        ],
                        borderWidth: 1
                    }]
                }
            });

            new Chart(expensesChartCtx, {
                type: 'pie',
                data: {
                    labels: expensesLabels,
                    datasets: [{
                        label: 'Expenses by Category',
                        data: expensesData,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                }
            });

            new Chart(dailyIncomeChartCtx, {
                type: 'line',
                data: {
                    labels: dailyIncomeLabels,
                    datasets: [{
                        label: 'Daily Income',
                        data: dailyIncomeData,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.1
                    }]
                }
            });

            new Chart(incomeComparisonChartCtx, {
                type: 'bar',
                data: {
                    labels: monthlyComparisonLabels,
                    datasets: [{
                        label: 'Monthly Income',
                        data: monthlyIncomeData,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                }
            });

            new Chart(expensesComparisonChartCtx, {
                type: 'bar',
                data: {
                    labels: monthlyComparisonLabels,
                    datasets: [{
                        label: 'Monthly Expenses',
                        data: monthlyExpensesData,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                }
            });
        });

        function generatePDF(){
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Add logo
            const img = new Image();
            img.src = 'carlogo.png';
            img.onload = function() {
                const logoWidth = 40; // Reduce size
                const logoHeight = 33; // Reduce size
                const pageWidth = doc.internal.pageSize.getWidth();
                const xOffset = (pageWidth - logoWidth) / 2; // Center horizontally

                doc.addImage(img, 'PNG', xOffset, 10, logoWidth, logoHeight);

                // Title
                doc.setFontSize(18);
                doc.text('AutoMate Car Maintenance and Service', pageWidth / 2, 50, null, null, 'center');
                doc.setFontSize(16);
                doc.text(`Monthly Financial Report for <?= date("F Y", strtotime($startDate)) ?>`, pageWidth / 2, 60, null, null, 'center');
                doc.setFontSize(12);
                doc.text(`Generated on: <?= date("F j, Y") ?>`, pageWidth / 2, 70, null, null, 'center');

                // Income Breakdown
                doc.setFontSize(14);
                doc.text('Income Breakdown', 14, 80);
                const incomeTableData = <?= json_encode(array_map(function($category, $amount) {
                    return [$category, number_format($amount, 2)];
                }, array_keys($incomeBreakdown), array_values($incomeBreakdown))) ?>;
                doc.autoTable({
                    head: [['Category', 'Amount (RM)']],
                    body: incomeTableData,
                    startY: 85,
                });

                // Expenses Breakdown
                doc.setFontSize(14);
                doc.text('Expenses Breakdown', 14, doc.lastAutoTable.finalY + 10);
                const expensesTableData = <?= json_encode(array_map(function($category, $amount) {
                    return [$category, number_format($amount, 2)];
                }, array_keys($expenseBreakdown), array_values($expenseBreakdown))) ?>;
                doc.autoTable({
                    head: [['Category', 'Amount (RM)']],
                    body: expensesTableData,
                    startY: doc.lastAutoTable.finalY + 15,
                });

                // Summary
                doc.setFontSize(14);
                doc.text('Summary', 14, doc.lastAutoTable.finalY + 20);
                doc.setFontSize(12);
                doc.text(`Total Income: RM <?= number_format($totalEarnings, 2) ?>`, 14, doc.lastAutoTable.finalY + 30);
                doc.text(`Total Expenses: RM <?= number_format($totalExpenses, 2) ?>`, 14, doc.lastAutoTable.finalY + 35);
                doc.text(`Net Profit/Loss: RM <?= number_format($totalEarnings - $totalExpenses, 2) ?>`, 14, doc.lastAutoTable.finalY + 40);

                doc.save('Monthly Report.pdf');
            };
        }
    </script>
</body>
</html>
