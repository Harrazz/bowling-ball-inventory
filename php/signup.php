<?php
include "connection.php";

// generate user ID
function generateUsersID($connect)
{
    $sql = "SELECT usersID FROM users WHERE usersID LIKE 'ST%' ORDER BY usersID DESC LIMIT 1";
    $result = $connect->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastID = $row['usersID'];
        $number = (int) substr($lastID, 3);
        $newNumber = $number + 1;
    } else {
        $newNumber = 1;
    }

    return 'ST' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
}

// function capitalize first letter
function titleCase($string)
{
    return ucwords(strtolower(trim($string)));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = titleCase($_POST['name']);
    $password = $_POST['password'];
    $tel = preg_replace("/\D/", "", $_POST['tel']); // Remove non-numeric characters
    $email = strtolower(trim($_POST['email']));
    $role = 'Staff'; // Default role

    // Check for duplicate email
    $check_email_sql = "SELECT * FROM users WHERE usersEmail = ?";
    $stmt = $connect->prepare($check_email_sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result_email = $stmt->get_result();

    // Check for duplicate phone number
    $check_phone_sql = "SELECT * FROM users WHERE usersPhone = ?";
    $stmt_phone = $connect->prepare($check_phone_sql);
    $stmt_phone->bind_param("s", $tel);
    $stmt_phone->execute();
    $result_phone = $stmt_phone->get_result();

    if (!preg_match('/^(?=.*[A-Z])(?=.*\d).{6,}$/', $password)) {
        $error_message = "Password must be at least 6 characters and include an uppercase letter and a number."; //password not followed requirement
    } elseif ($result_email->num_rows > 0) {
        $error_message = "Email already exists."; //email is used by other user
    } elseif ($result_phone->num_rows > 0) {
        $error_message = "Phone number already exists."; //phone number is used by other user
    } else {
        $users_id = generateUsersID($connect);

        $insert_sql = "INSERT INTO users (usersID, usersName, usersPassword, usersPhone, usersEmail, usersRole) 
                       VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_insert = $connect->prepare($insert_sql);
        $stmt_insert->bind_param("ssssss", $users_id, $name, $password, $tel, $email, $role);

        if ($stmt_insert->execute()) {
            $success_message = "Registration successful. Your User ID is $users_id. <br><a href='login.php'>Login here</a>";
        } else {
            $error_message = "Error during registration. Please try again.";
        }

        $stmt_insert->close();
    }

    $stmt->close();
    $stmt_phone->close();
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
    <link rel="stylesheet" href="../style/signup.css">

    <title>Sign Up</title>
</head>

<body>
    <?php include '../bubble_file/bubble.html'; ?>

    <div class="signup-card">
        <!-- <img src="../images/bowling logo.png" class="bowling-image"> -->
        <h2>Sign Up</h2>

        <?php
        if (isset($error_message)) {
            echo "<p class='error-message'>$error_message</p>";
        }
        if (isset($success_message)) {
            echo "<p class='success-message'>$success_message</p>";
        }
        ?>

        <form action="signup.php" method="POST">
            <div class="text-start">
                <label for="name" class="form-label">Full Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="text-start">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <div id="password-requirements" class="form-text text-danger hidden">
                    Password must be at least 6 characters and include one uppercase letter and number.
                </div>
            </div>

            <div class="text-start">
                <label for="tel" class="form-label">Phone Number:</label>
                <input type="tel" class="form-control" id="tel" name="tel" pattern="\d*" inputmode="numeric"
                    maxlength="15" required>
            </div>

            <div class="text-start">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <button type="submit" class="btn-signup">Sign Up</button>
        </form>

        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>

    <!-- script to prevent tpying non numeric characters -->
    <script>
        document.getElementById('tel').addEventListener('input', function (e) {
            this.value = this.value.replace(/\D/g, '');
        });
    </script>

    <script>
        const passwordInput = document.getElementById('password');
        const requirements = document.getElementById('password-requirements');

        passwordInput.addEventListener('input', function () {
            const password = this.value;

            // Show message only when user starts typing
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