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

    <link rel="stylesheet" href="../style/products.css">
    <link rel="stylesheet" href="../style/table_action.css">
    <link rel="stylesheet" href="../style/modal.css">

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
                <button onclick="openModal('addModal')">Add Order</button>
            </div>
        </div>

        <div class="table-container">
            <table id="pageTable">
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">Order ID</th>
                        <th onclick="sortTable(1)">Staff ID</th>
                        <th onclick="sortTable(2)">Cust ID</th>
                        <th onclick="sortTable(3)">Product ID</th>
                        <th onclick="sortTable(4)">Quantity</th>
                        <th onclick="sortTable(5)">Date</th>
                        <th onclick="sortTable(6)">Time</th>
                        <th onclick="sortTable(7)">Total Amount</th>
                        <th onclick="sortTable(8)">Payment Method</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['orderID']) ?></td>
                            <td><?= htmlspecialchars($row['usersID']) ?></td>
                            <td><?= htmlspecialchars($row['custID']) ?></td>
                            <td><?= htmlspecialchars($row['productID']) ?></td>
                            <td><?= htmlspecialchars($row['qty']) ?></td>
                            <td><?= htmlspecialchars($row['orderDate']) ?></td>
                            <td><?= htmlspecialchars($row['orderTime']) ?></td>
                            <td><?= htmlspecialchars($row['totAmount']) ?></td>
                            <td><?= htmlspecialchars($row['payMethod']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- add product -->
        <div id="addModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('addModal')">&times;</span>
                <h2>Add Order</h2>
                <form action="orderCrud.php" method="POST">
                    <input type="hidden" name="action" value="add">

                    <label>Staff:</label>
                    <select name="usersID" required>
                        <?php
                        $suppResult = $connect->query("SELECT usersID, usersName FROM users");
                        while ($supp = $suppResult->fetch_assoc()):
                            ?>
                            <option value="<?= $supp['usersID'] ?>"><?= htmlspecialchars($supp['usersName']) ?></option>
                        <?php endwhile; ?>
                    </select>

                    <label>Customer ID:</label>
                    <select name="custID" required>
                        <?php
                        $suppResult = $connect->query("SELECT custID FROM customer");
                        while ($supp = $suppResult->fetch_assoc()):
                            ?>
                            <option value="<?= $supp['custID'] ?>"><?= htmlspecialchars($supp['custID']) ?></option>
                        <?php endwhile; ?>
                    </select>

                    <label>Product:</label>
                    <select id="productSelect" name="productID" required onchange="updateTotalAmount()">
                        <?php
                        $productResult = $connect->query("SELECT productID, brand, model, weight, price, qty FROM product");
                        while ($product = $productResult->fetch_assoc()):
                            ?>
                            <option value="<?= $product['productID'] ?>" data-price="<?= $product['price'] ?>"
                                data-stock="<?= $product['qty'] ?>">
                                <?= htmlspecialchars($product['brand']) ?> -
                                <?= htmlspecialchars($product['model']) ?> -
                                <?= htmlspecialchars($product['weight']) ?>lb -
                                RM<?= htmlspecialchars($product['price']) ?>
                                (qty:<?= htmlspecialchars($product['qty']) ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>

                    <label>Quantity:</label>
                    <input type="number" id="quantityInput" name="qty" min="1" value="1" required
                        onchange="updateTotalAmount()">

                    <label>Order Date:</label>
                    <input type="date" id="orderDate" name="orderDate" required>

                    <label>Order Time:</label>
                    <input type="time" id="orderTime" name="orderTime" required>

                    <label>Total Amount:</label>
                    <input type="text" id="totalAmount" name="totAmount" required readonly>

                    <label>Payment Method:</label>
                    <select name="payMethod" required>
                        <option value="Cash">Cash</option>
                        <option value="Credit Card">Bank Card</option>
                        <option value="E-Wallet">E-Wallet</option>
                    </select>

                    <button type="submit" class="btn-submit">Add Order</button>
                </form>
            </div>
        </div>

    </div>

    <script src="../javascript/search.js"></script>
    <script src="../javascript/sort.js"></script>
    <script src="../javascript/modal.js"></script>
    <script>
        function updateTotalAmount() {
            const productSelect = document.getElementById("productSelect");
            const quantityInput = document.getElementById("quantityInput");
            const totalAmount = document.getElementById("totalAmount");

            let selectedProduct = productSelect.options[productSelect.selectedIndex];
            let productPrice = parseFloat(selectedProduct.getAttribute("data-price")) || 0;
            let stock = parseInt(selectedProduct.getAttribute("data-stock")) || 1;
            let quantity = parseInt(quantityInput.value) || 1;

            // Ensure quantity does not exceed stock
            if (quantity > stock) {
                quantityInput.value = stock;
                quantity = stock;
            }

            totalAmount.value = (productPrice * quantity).toFixed(2);
        }
    </script>
</body>

</html>