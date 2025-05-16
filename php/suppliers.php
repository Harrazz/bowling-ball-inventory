<?php
include "connection.php";

// Fetch products
$sql = "SELECT * FROM supplier";
$result = $connect->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- favicon -->
    <link rel="icon" href="../bowling.ico" type="image/x-icon" />

    <link rel="stylesheet" href="../style/suppliers.css">
    <link rel="stylesheet" href="../style/table_action.css">
    <link rel="stylesheet" href="../style/modal.css">

    <title>Suppliers</title>
</head>

<body>
    <?php include '../navbar_file/navbar.php'; ?>

    <div class="main-content">
        <header class="page-header">
            <h1>Suppliers</h1>
        </header>

        <div class="actions">
            <div class="search-box">
                <input type="text" placeholder="Search supplier..." id="searchInput" onkeyup="searchTable()">
            </div>
            <div class="add-button">
                <button onclick="openModal('addModal')">Add Supplier</button>
            </div>
        </div>

        <div class="table-container">
            <table id="pageTable">
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">Supplier ID</th>
                        <th onclick="sortTable(1)">Name</th>
                        <th onclick="sortTable(2)">Phone</th>
                        <th onclick="sortTable(3)">Email</th>
                        <th onclick="sortTable(4)">Address</th>
                        <th onclick="sortTable(5)">Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['suppID']) ?></td>
                            <td><?= htmlspecialchars($row['suppName']) ?></td>
                            <td><?= htmlspecialchars($row['suppPhone']) ?></td>
                            <td><?= htmlspecialchars($row['suppEmail']) ?></td>
                            <td><?= htmlspecialchars($row['suppAddress']) ?></td>
                            <td><?= htmlspecialchars($row['suppStatus']) ?></td>
                            <td>
                                <button class="edit-btn" onclick="openEditModal(
                                    '<?= htmlspecialchars($row['suppID']) ?>',
                                    '<?= htmlspecialchars($row['suppName']) ?>',
                                    '<?= htmlspecialchars($row['suppPhone']) ?>',
                                    '<?= htmlspecialchars($row['suppEmail']) ?>',
                                    '<?= htmlspecialchars($row['suppAddress']) ?>',
                                    '<?= htmlspecialchars($row['suppStatus']) ?>'
                                )">✏️</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Edit Supplier -->
        <div id="editModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('editModal')">&times;</span>
                <h2>Edit Supplier</h2>
                <form action="supplierCrud.php" method="POST">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" id="editSuppID" name="suppID">

                    <label>Supplier Name:</label>
                    <input type="text" id="editSuppName" name="suppName" required>

                    <label>Phone:</label>
                    <input type="text" id="editSuppPhone" name="suppPhone" required>

                    <label>Email:</label>
                    <input type="email" id="editSuppEmail" name="suppEmail" required>

                    <label>Address:</label>
                    <input type="text" id="editSuppAddress" name="suppAddress" required>

                    <label>Status:</label>
                    <select id="editSuppStatus" name="suppStatus" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>

                    <button type="submit" class="btn-submit">Save Changes</button>
                </form>
            </div>
        </div>

        <!-- add suppier -->
        <div id="addModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('addModal')">&times;</span>
                <h2>Add Supplier</h2>
                <form action="supplierCrud.php" method="POST">
                    <input type="hidden" name="action" value="add">

                    <label>Supplier Name:</label>
                    <input type="text" name="suppName" required>

                    <label>Phone:</label>
                    <input type="number" name="suppPhone" required>

                    <label>Email:</label>
                    <input type="email" name="suppEmail" required>

                    <label>Address:</label>
                    <input type="text" name="suppAddress" required>

                    <input type="hidden" name="suppStatus" value="Active">

                    <button type="submit" class="btn-submit">Add Supplier</button>
                </form>
            </div>
        </div>
    </div>

    <script src="../javascript/search.js"></script>
    <script src="../javascript/sort.js"></script>
    <script src="../javascript/modal.js"></script>
    <script>
        function openEditModal(suppID, suppName, suppPhone, suppEmail, suppAddress, suppStatus) {

            document.getElementById("editSuppID").value = suppID;
            document.getElementById("editSuppName").value = suppName;
            document.getElementById("editSuppPhone").value = suppPhone;
            document.getElementById("editSuppEmail").value = suppEmail;
            document.getElementById("editSuppAddress").value = suppAddress;
            document.getElementById("editSuppStatus").value = suppStatus;

            openModal('editModal');
        }
    </script>
</body>

</html>