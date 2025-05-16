<?php
include "connection.php";

// Fetch products
$sql = "SELECT * FROM customer";
$result = $connect->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- favicon -->
    <link rel="icon" href="../bowling.ico" type="image/x-icon" />

    <link rel="stylesheet" href="../style/customers.css">
    <link rel="stylesheet" href="../style/table_action.css">

    <title>Customers</title>
</head>

<body>
    <?php include '../navbar_file/navbar.php'; ?>

    <div class="main-content">
        <header class="page-header">
            <h1>Customer</h1>
        </header>

        <div class="actions">
            <div class="search-box">
                <input type="text" placeholder="Search customer..." id="searchInput" onkeyup="searchTable()">
            </div>
            <div class="add-button">
                <button>Add Customer</button>
            </div>
        </div>

        <table id="pageTable">
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>Customer Phone</th>
                    <th>Customer EMail</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['custID']) ?></td>
                        <td><?= htmlspecialchars($row['custName']) ?></td>
                        <td><?= htmlspecialchars($row['custPhone']) ?></td>
                        <td><?= htmlspecialchars($row['custEmail']) ?></td>
                        <td>
                            <button class="edit-btn">✏️</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="../javascript/search.js"></script>
    <script src="../javascript/sort.js"></script>
</body>

</html>