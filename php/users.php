<?php
include "connection.php";

// Fetch users
$sql = "SELECT * FROM users";
$result = $connect->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- favicon -->
    <link rel="icon" href="../bowling.ico" type="image/x-icon" />

    <link rel="stylesheet" href="../style/users.css">
    <link rel="stylesheet" href="../style/table_action.css">
    <link rel="stylesheet" href="../style/modal.css">

    <title>Users</title>
</head>

<body>
    <?php include '../navbar_file/navbar.php'; ?>

    <div class="main-content">
        <header class="page-header">
            <h1>Users</h1>
        </header>

        <div class="actions">
            <div class="search-box">
                <input type="text" placeholder="Search user..." id="searchInput" onkeyup="searchTable()">
            </div>
        </div>

        <div class="table-container">
            <table id="pageTable">
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">User ID</th>
                        <th onclick="sortTable(1)">User Name</th>
                        <th onclick="sortTable(2)">User Phone</th>
                        <th onclick="sortTable(3)">User Email</th>
                        <th onclick="sortTable(4)">User Password</th>
                        <th onclick="sortTable(5)">User Role</th>
                        <th onclick="sortTable(6)">User Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['usersID']) ?></td>
                            <td><?= htmlspecialchars($row['usersName']) ?></td>
                            <td><?= htmlspecialchars($row['usersPhone']) ?></td>
                            <td><?= htmlspecialchars($row['usersEmail']) ?></td>
                            <td><?= htmlspecialchars($row['usersPassword']) ?></td>
                            <td><?= htmlspecialchars($row['usersRole']) ?></td>
                            <td><?= htmlspecialchars($row['usersStatus']) ?></td>
                            <td>
                                <button class="edit-btn" onclick="openEditModal(
                                '<?= $row['usersID'] ?>',
                                '<?= $row['usersName'] ?>',
                                '<?= $row['usersPhone'] ?>',
                                '<?= $row['usersEmail'] ?>',
                                '<?= $row['usersPassword'] ?>',
                                '<?= $row['usersRole'] ?>',
                                '<?= $row['usersStatus'] ?>'
                            )">✏️</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editModal')">&times;</span>
            <h2>Edit User</h2>
            <form action="userCrud.php" method="POST">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" id="editUsersID" name="id">

                <label>User Name:</label>
                <input type="text" id="editUsersName" name="usersName" required>

                <label>User Phone:</label>
                <input type="number" id="editUsersPhone" name="usersPhone" required>

                <label>User Email:</label>
                <input type="email" id="editUsersEmail" name="usersEmail" required>

                <label>User Password:</label>
                <input type="password" id="editUsersPassword" name="usersPassword" required>

                <label>User Role:</label>
                <select id="editUsersRole" name="usersRole" required>
                    <option value="Staff">Staff</option>
                    <option value="Admin">Admin</option>
                </select>

                <label>User Status:</label>
                <select id="editUsersStatus" name="usersStatus" required>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>

                <button type="submit" class="btn-submit">Save Changes</button>
            </form>
        </div>
    </div>

    <script src="../javascript/search.js"></script>
    <script src="../javascript/sort.js"></script>
    <script src="../javascript/modal.js"></script>
    <script>
        function openEditModal(userID, userName, userPhone, userEmail, userPassword, userRole, userStatus) {
            document.getElementById("editUsersID").value = userID;
            document.getElementById("editUsersName").value = userName;
            document.getElementById("editUsersPhone").value = userPhone;
            document.getElementById("editUsersEmail").value = userEmail;
            document.getElementById("editUsersPassword").value = userPassword;
            document.getElementById("editUsersRole").value = userRole;
            document.getElementById("editUsersStatus").value = userStatus;

            openModal('editModal');
        }
    </script>
</body>

</html>