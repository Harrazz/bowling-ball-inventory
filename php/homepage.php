<?php
session_start();

// get current user session
$usersName = isset($_SESSION['usersName']) ? $_SESSION['usersName'] : "Guest";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- favicon -->
    <link rel="icon" href="../bowling.ico" type="image/x-icon" />

    <link rel="stylesheet" href="../style/homepage.css">
    <title>Dashboard</title>
</head>

<body>
    <?php include '../bubble_file/bubble_white.html'; ?>
    <?php include '../navbar_file/navbar.php'; ?>

    <div class="main-content">
        <header class="page-header">
            <h1>Homepage</h1>
        </header>

        <section class="welcome">
            <h2>Welcome, <?php echo htmlspecialchars($usersName); ?>!</h2>
            <p>Welcome to the Bowling Ball Inventory System</p>
        </section>

        <!-- dashboard card shows current info -->
        <section class="dashboard">
            <div class="dash-card">
                <h3>Total Bowling Balls Available</h3>

                <!-- get total bowling ball available -->
                <?php
                include "connection.php";
                $result = $connect->query("SELECT SUM(qty) AS totalBalls FROM product");
                $row = $result->fetch_assoc();
                ?>
                <p><?= htmlspecialchars($row['totalBalls']) ?> Balls</p>
            </div>

            <div class="dash-card">
                <h3>Active Staff Members</h3>

                <!-- get total of active users -->
                <?php
                include "connection.php";
                $activeUsersResult = $connect->query("SELECT COUNT(*) AS activeUsers FROM users WHERE usersStatus = 'Active'");
                $activeUsersRow = $activeUsersResult->fetch_assoc();
                ?>
                <p><?= htmlspecialchars($activeUsersRow['activeUsers']) ?> Active Users</p>
            </div>

            <div class="dash-card">
                <h3>Active Suppliers</h3>

                <!-- get total of active supplier -->
                <?php
                include "connection.php";
                $activeSuppliersResult = $connect->query("SELECT COUNT(*) AS activeSuppliers FROM supplier WHERE suppStatus = 'Active'");
                $activeSuppliersRow = $activeSuppliersResult->fetch_assoc();
                ?>
                <p><?= htmlspecialchars($activeSuppliersRow['activeSuppliers']) ?> Active Suppliers</p>
            </div>
        </section>

        <section class="quick-access">
            <div class="quick-card" style="background-color:rgb(233, 191, 191);">
                <h3>Products</h3>
                <p>View Your Product Inventory</p>
                <button onclick="window.location.href='products.php'">View all inventory</b>
            </div>

            <div class="quick-card" style="background-color:rgb(172, 208, 241);">
                <h3>Supplier</h3>
                <p>View Your Supplier Data</p>
                <button onclick="window.location.href='suppliers.php'">View all supplier</button>
            </div>

            <div class="quick-card" style="background-color:rgb(212, 237, 218);">
                <h3>Order</h3>
                <p>View Your Order Data</p>
                <button onclick="window.location.href='orders.php'">View all customer</button>
            </div>
        </section>

    </div>

</body>

</html>