<?php
include "connection.php";

// Fetch products
$sql = "SELECT * FROM product";
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

    <title>Products</title>
</head>

<body>
    <?php include '../navbar_file/navbar.php'; ?>

    <div class="main-content">
        <header class="page-header">
            <h1>Product</h1>
        </header>

        <div class="actions">
            <div class="search-box">
                <input type="text" placeholder="Search product..." id="searchInput" onkeyup="searchTable()">
            </div>
            <div class="add-button">
                <button onclick="openModal('addModal')">Add Product</button>
            </div>
        </div>

        <div class="table-container">
            <table id="pageTable">
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">Product ID</th>
                        <th onclick="sortTable(1)">Supplier ID</th>
                        <th onclick="sortTable(2)">Shelf</th>
                        <th onclick="sortTable(3)">Brand</th>
                        <th onclick="sortTable(4)">Model</th>
                        <th onclick="sortTable(5)">Weight</th>
                        <th onclick="sortTable(6)">Price</th>
                        <th onclick="sortTable(7)">Quantity</th>
                        <th>Actions</th>

                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1; ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['productID']) ?></td>
                            <td><?= htmlspecialchars($row['suppID']) ?></td>
                            <td><?= htmlspecialchars($row['shelf']) ?></td>
                            <td><?= htmlspecialchars($row['brand']) ?></td>
                            <td><?= htmlspecialchars($row['model']) ?></td>
                            <td><?= htmlspecialchars($row['weight']) ?></td>
                            <td><?= htmlspecialchars($row['price']) ?></td>
                            <td><?= htmlspecialchars($row['qty']) ?></td>
                            <td>
                                <button class="edit-btn" onclick="openEditModal(
                                    '<?= $row['productID'] ?>',
                                    '<?= $row['suppID'] ?>',
                                    '<?= $row['shelf'] ?>',
                                    '<?= $row['brand'] ?>',
                                    '<?= $row['model'] ?>',
                                    '<?= $row['weight'] ?>',
                                    '<?= $row['price'] ?>',
                                    '<?= $row['qty'] ?>'
                                )">✏️</button>

                                <button class="delete-btn"
                                    onclick="openDeleteModal('<?= $row['productID'] ?>')">🗑️</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- add product -->
        <div id="addModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('addModal')">&times;</span>
                <h2>Add Product</h2>
                <form action="productCrud.php" method="POST">
                    <input type="hidden" name="action" value="add">

                    <!-- Supplier Dropdown -->
                    <label>Supplier:</label>
                    <select name="suppID" required>
                        <?php
                        $suppResult = $connect->query("SELECT suppID, suppName FROM supplier");
                        while ($supp = $suppResult->fetch_assoc()):
                            ?>
                            <option value="<?= $supp['suppID'] ?>"><?= htmlspecialchars($supp['suppName']) ?></option>
                        <?php endwhile; ?>
                    </select>

                    <label>Shelf:</label>
                    <select name="shelf" required>
                        <option value="1-A">1-A</option>
                        <option value="1-B">1-B</option>
                        <option value="2-A">2-A</option>
                        <option value="2-B">2-B</option>
                        <option value="3-A">3-A</option>
                        <option value="3-B">3-B</option>
                        <option value="4-A">4-A</option>
                        <option value="4-B">4-B</option>
                        <option value="5-A">5-A</option>
                        <option value="5-B">5-B</option>
                    </select>

                    <label>Brand:</label>
                    <input type="text" name="brand" required>

                    <label>Model:</label>
                    <input type="text" name="model" required>

                    <label>Weight:</label>
                    <input type="number"  name="weight" min="6" required>

                    <label>Price:</label>
                    <input type="number" step="0.01" name="price" required>

                    <label>Quantity:</label>
                    <input type="number" name="qty" min="1" required>

                    <button type="submit" class="btn-submit">Add Product</button>
                </form>
            </div>
        </div>

        <!-- edit product -->
        <div id="editModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('editModal')">&times;</span>
                <h2>Edit Product</h2>
                <form action="productCrud.php" method="POST">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" id="editProductID" name="id">

                    <label>Supplier ID:</label>
                    <select id="editSuppID" name="suppID" required>
                        <?php
                        $suppResult = $connect->query("SELECT suppID, suppName FROM supplier");
                        while ($supp = $suppResult->fetch_assoc()):
                            ?>
                            <option value="<?= $supp['suppID'] ?>"><?= htmlspecialchars($supp['suppName']) ?></option>
                        <?php endwhile; ?>
                    </select>

                    <label>Shelf:</label>
                    <select id="editShelf" name="shelf" required>
                        <option value="1-A">1-A</option>
                        <option value="1-B">1-B</option>
                        <option value="2-A">2-A</option>
                        <option value="2-B">2-B</option>
                        <option value="3-A">3-A</option>
                        <option value="3-B">3-B</option>
                        <option value="4-A">4-A</option>
                        <option value="4-B">4-B</option>
                        <option value="5-A">5-A</option>
                        <option value="5-B">5-B</option>
                    </select>

                    <label>Brand:</label>
                    <input type="text" id="editBrand" name="brand" required>

                    <label>Model:</label>
                    <input type="text" id="editModel" name="model" required>

                    <label>Weight:</label>
                    <input type="number" id="editWeight" name="weight" min="6" required>

                    <label>Price:</label>
                    <input type="number" step="0.01" id="editPrice" name="price" required>

                    <label>Quantity:</label>
                    <input type="number" id="editQty" name="qty" required>

                    <button type="submit" class="btn-submit">Save Changes</button>
                </form>
            </div>
        </div>

        <!-- delete product -->
        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('deleteModal')">&times;</span>
                <h2>Confirm Delete</h2>
                <p>Are you sure you want to delete this product?</p>
                <form action="productCrud.php" method="POST">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" id="deleteProductID" name="id">
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
        function openEditModal(productID, suppID, shelf, brand, model, weight, price, qty) {
            document.getElementById("editProductID").value = productID;
            document.getElementById("editSuppID").value = suppID;
            document.getElementById("editShelf").value = shelf;
            document.getElementById("editBrand").value = brand;
            document.getElementById("editModel").value = model;
            document.getElementById("editWeight").value = weight;
            document.getElementById("editPrice").value = price;
            document.getElementById("editQty").value = qty;

            openModal('editModal');
        }

        function openDeleteModal(productID) {
            document.getElementById("deleteProductID").value = productID;
            openModal('deleteModal');
        }
    </script>
</body>

</html>