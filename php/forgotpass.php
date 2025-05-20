<?php
include "connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $users_id = $_POST['users_id'];
    $email = strtolower(trim($_POST['email'])); //convert all letter to lowercase for email
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if (!preg_match('/^(?=.*[A-Z])(?=.*\d).{6,}$/', $new_password)) {
        $error_message = "Password must be at least 6 characters and include an uppercase letter and a number.";
    } elseif ($new_password !== $confirm_password) { 
        $error_message = "Passwords do not match.";
    } else {
        // Check if User ID and Email exist together
        $sql = "SELECT * FROM users WHERE usersID = ? AND usersEmail = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("ss", $users_id, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Update password if users ID and Email are valid
            $update_sql = "UPDATE users SET usersPassword = ? WHERE usersID = ?";
            $update_stmt = $connect->prepare($update_sql);
            $update_stmt->bind_param("ss", $new_password, $users_id);
            $update_stmt->execute();

            // check if the update was successful or not
            if ($update_stmt->affected_rows === 1) {
                $success_message = "Password successfully updated. <br><a href='login.php'>Login here</a>";
            } else {
                $error_message = "Password cannot be same as old password!";
            }

            $update_stmt->close();
        } else {
            $error_message = "User ID or email is incorrect."; // Added validation error
        }

        $stmt->close();
    }
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
    <link rel="stylesheet" href="../style/forgotpass.css">

    <title>Forgot Password</title>

</head>

<body>
    <?php include '../bubble_file/bubble.html'; ?>

    <div class="forgot-card">
        <!-- <img src="../images/bowling logo.png" class="bowling-image"> -->
        <h2>Forgot Password</h2>

        <!-- Show success or error message -->
        <?php
        if (isset($error_message))
            echo "<p class='error-message'>$error_message</p>";
        if (isset($success_message))
            echo "<p class='success-message'>$success_message</p>";
        ?>

        <!-- Forgot Password Form -->
        <form action="forgotpass.php" method="POST">
            <div class="text-start">
                <label for="users_id" class="form-label">User ID:</label>
                <input type="text" class="form-control" id="users_id" name="users_id" required />
            </div>

            <div class="text-start">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required />
            </div>

            <div class="text-start">
                <label for="new_password" class="form-label">New Password:</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required />
                <div id="password-requirements" class="form-text text-danger hidden">
                    Password must be at least 6 characters and include one uppercase letter and number.
                </div>
            </div>

            <div class="text-start">
                <label for="confirm_password" class="form-label">Confirm Password:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required />
            </div>

            <button type="submit" class="btn-submit">Reset Password</button>
        </form>

        <p><a href="login.php">Back to Login</a></p>
    </div>

    <!-- password requiremnet -->
    <script>
        const newPasswordInput = document.getElementById('new_password');
        const requirements = document.getElementById('password-requirements');

        newPasswordInput.addEventListener('input', function () {
            const password = this.value;

            if (password.length > 0) {
                requirements.classList.remove('hidden');
                requirements.style.display = "block";

                const hasUpperCase = /[A-Z]/.test(password);
                const hasNumber = /[0-9]/.test(password);
                const hasMinLength = password.length >= 6;

                if (hasUpperCase && hasNumber && hasMinLength) {
                    requirements.textContent = "Password looks good!";
                    requirements.classList.remove("text-danger");
                    requirements.classList.add("text-success");
                } else {
                    requirements.textContent = "Password must be at least 6 characters and include one uppercase letter and number.";
                    requirements.classList.remove("text-success");
                    requirements.classList.add("text-danger");
                }
            } else {
                requirements.style.display = "none";
            }
        });
    </script>

</body>

</html>