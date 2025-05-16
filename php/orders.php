<?php
include "connection.php";

// Fetch products
$sql = "SELECT * FROM orders";
$result = $connect->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- favicon -->
    <link rel="icon" href="../bowling.ico" type="image/x-icon" />

    <link rel="stylesheet" href="../style/orders.css">
    <link rel="stylesheet" href="../style/table_action.css">

    <title>Orders</title>
</head>

<body>
    <?php include '../navbar_file/navbar.php'; ?>

    <div class="main-content">
        <header class="page-header">
            <h1>Sales</h1>
        </header>

        <div class="actions">
            <div class="search-box">
                <input type="text" placeholder="Search order..." id="searchInput" onkeyup="searchTable()">
            </div>
            <div class="add-button">
                <button>Add Order</button>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Staff ID</th>
                    <th>Cust ID</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Total Amount</th>
                    <th>Payment Method</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['orderID']) ?></td>
                        <td><?= htmlspecialchars($row['staffID']) ?></td>
                        <td><?= htmlspecialchars($row['custID']) ?></td>
                        <td><?= htmlspecialchars($row['date']) ?></td>
                        <td><?= htmlspecialchars($row['time']) ?></td>
                        <td><?= htmlspecialchars($row['totalAmount']) ?></td>
                        <td><?= htmlspecialchars($row['payMethod']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>