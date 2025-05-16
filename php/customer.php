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
    <link rel="stylesheet" href="../style/modal.css">

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
                <button onclick="openModal('addModal')">Add Customer</button>
            </div>
        </div>

        <div class="table-container">
            <table id="pageTable">
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">Customer ID</th>
                        <th onclick="sortTable(1)">Customer Name</th>
                        <th onclick="sortTable(2)">Customer Phone</th>
                        <th onclick="sortTable(3)">Customer EMail</th>
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
                                <button class="edit-btn" onclick="openEditModal(
                                    '<?= $row['custID'] ?>',
                                    '<?= $row['custName'] ?>',
                                    '<?= $row['custPhone'] ?>',
                                    '<?= $row['custEmail'] ?>'
                                )">✏️</button>

                                <button class="delete-btn" onclick="openDeleteModal('<?= $row['custID'] ?>')">🗑️</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- add customer -->
        <div id="addModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('addModal')">&times;</span>
                <h2>Add Customer</h2>
                <form action="customerCrud.php" method="POST">
                    <input type="hidden" name="action" value="add">

                    <label>Customer Name:</label>
                    <input type="text" id="addCustName" name="custName" required>

                    <label>Phone:</label>
                    <input type="number" id="custPhone" name="custPhone" maxlength="11" required>

                    <label>Email:</label>
                    <input type="email" id="addCustEmail" name="custEmail" required>

                    <button type="submit" class="btn-submit">Add Customer</button>
                </form>
            </div>
        </div>

        <!-- edit customer -->
        <div id="editModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('editModal')">&times;</span>
                <h2>Edit Customer</h2>
                <form action="customerCrud.php" method="POST">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" id="editCustomerID" name="id">

                    <label>Customer Name:</label>
                    <input type="text" id="editCustName" name="custName" required>

                    <label>Phone:</label>
                    <input type="number" id="editCustPhone" name="custPhone" maxlength="11" required >

                    <label>Email:</label>
                    <input type="email" id="editCustEmail" name="custEmail" required>

                    <button type="submit" class="btn-submit">Save Changes</button>
                </form>
            </div>
        </div>

        <!-- delete customer -->
        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('deleteModal')">&times;</span>
                <h2>Confirm Delete</h2>
                <p>Are you sure you want to delete this customer?</p>
                <form action="customerCrud.php" method="POST">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" id="deleteCustID" name="id">
                    <button type="submit" class="btn-delete">Yes!</button>
                    <button type="button" class="btn-cancel" onclick="closeModal('deleteModal')">Cancel</button>
                </form>
            </div>
        </div>
    </div>

    <script src="../javascript/search.js"></script>
    <script src="../javascript/sort.js"></script>
    <script src="../javascript/modal.js"></script>
    <script>

        // open edit modal
        function openEditModal(custID, custName, custPhone, custEmail) {
            document.getElementById("editCustomerID").value = custID;
            document.getElementById("editCustName").value = custName;
            document.getElementById("editCustPhone").value = custPhone;
            document.getElementById("editCustEmail").value = custEmail;

            openModal('editModal');
        }

        // open delete modal
        function openDeleteModal(custID) {
            document.getElementById("deleteCustID").value = custID;
            openModal('deleteModal');
        }

        // allow only 11 digit max number
        document.getElementById("custPhone").addEventListener("input", function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 11); 
        });

        document.getElementById("editCustPhone").addEventListener("input", function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 11); 
        });

    </script>
</body>

</html>