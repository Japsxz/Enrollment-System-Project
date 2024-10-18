<?php
include("db_register.php");

session_start();

// Initialize error message variable
$error_message = "";

// Check if user is already logged in and redirect based on privilege
if (isset($_SESSION['privilege']) && $_SESSION['privilege'] == 'super admin') {
    header("Location: SuperAdmin_Dashboard.php");
    exit;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form inputs
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate form inputs
    if (empty($username) || empty($password)) {
        $error_message = "Please fill in all fields.";
    } else {
        try {
            $stmt = $conn->prepare("SELECT password, first_name, last_name, privilege, id FROM admin WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user_data = $result->fetch_assoc();
                $stored_password = $user_data["password"];
                $firstname = $user_data["first_name"];
                $lastname = $user_data["last_name"];
                $privilege = $user_data["privilege"];

                // Check if the password is correct
                if ($password === $stored_password && $privilege == 'super admin') {
                    session_regenerate_id(true);
                    $_SESSION['username'] = $username;
                    $_SESSION['first_name'] = $firstname;
                    $_SESSION['last_name'] = $lastname;
                    $_SESSION['privilege'] = $privilege;
                    $_SESSION['id'] = $id;

                    header("Location: SuperAdmin_Dashboard.php");
                    exit;
                } else {
                    // Set error message for invalid password or privilege
                    $error_message = "Incorrect Username or Password.";
                }
            } else {
                // Set error message for username not found
                $error_message = "Username not found.";
            }

            $stmt->close();
        } catch (Exception $e) {
            $error_message = "An error occurred: " . htmlspecialchars($e->getMessage());
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Enrollment System For BSIT</title>
    <link rel="stylesheet" href="CSS/SuperAdmin.css" />
</head>

<body>

    <div class="container">
        <div class="left">
            <form class="form" method="POST">



                <h1>Admin Login</h1>
                <!-- Show Error -->
                <?php if (!empty($error_message)) { ?>
                    <p class="error"><?php echo $error_message; ?></p>
                <?php } ?>
                <div class="input-block">
                    <input class="input" type="text" name="username" id="username" required>
                    <label for="username">Username</label>
                </div>
                <div class="input-block">
                    <input class="input" type="password" name="password" id="password" required>
                    <label for="password">Password</label>
                </div>
                <div class="input-block">
                    <span class="forgot"><a href="#">Forgot Password?</a></span>
                    <button class="input-login" type="submit">Login</button>
                    <button class="input-back" type="button" onclick="window.history.back();">Back</button>
                </div>
            </form>
        </div>
        <div class="right">
            <div class="img">
                <img src="img/bsit.png" alt="BSIT Image" width="310px" height="70%">
            </div>

        </div>
    </div>



    <script>
        const showPasswordCheckbox = document.getElementById('show-password');
        const passwordInput = document.getElementById('password');

        showPasswordCheckbox.addEventListener('change', () => {
            if (showPasswordCheckbox.checked) {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        });
    </script>
</body>

</html>