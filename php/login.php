<?php
session_start();
include "connection.php";

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get values from form input
    $staff_id = $_POST['users_id'];
    $password = $_POST['password'];

    // Prepare SQL to prevent SQL injection
    $sql = "SELECT * FROM users WHERE usersID = ? AND usersPassword = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ss", $staff_id, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exist and password matche
    if ($result->num_rows === 1) {
        // Login successful
        $row = $result->fetch_assoc(); // Fetch the row from the result
        $_SESSION['users_id'] = $staff_id; // Store staff ID
        $_SESSION['usersName'] = $row['usersName']; // Store staff name
        $_SESSION['usersRole'] = $row['usersRole']; // Store role
        header("Location: ./homepage.php"); // Redirect to homepage
        exit();
    } else {
        // Invalid staff or pass
        $error_message = "Invalid User ID or Password.";
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- favicon -->
    <link rel="icon" href="../bowling.ico" type="image/x-icon" />

    <!-- css file -->
    <link rel="stylesheet" href="../style/login.css">

    <title>Login</title>
</head>

<body>
    <?php include '../bubble_file/bubble.html'; ?>

    <div class="login-card">
        <img src="../images/bowling logo.png" class="bowling-image mb-4">
        <h2>Login</h2>

        <!-- Display error message if fails -->
        <?php if (isset($error_message))
            echo "<p class='error-message'>$error_message</p>"; ?>

        <!-- Login Form -->
        <form action="login.php" method="POST">
            <div class="text-start">
                <label for="users_id" class="form-label">Staff ID:</label>
                <input type="text" class="form-control" id="users_id" name="users_id" required>
            </div>

            <div class="text-start">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>

        <p><a href="forgotpass.php">Forgot Password?</a></p>
        <p>Don't have an account? <a href="signup.php">Sign Up here</a>.</p>
    </div>
</body>

</html>