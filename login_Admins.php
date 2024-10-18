<?php
include("db_register.php");
session_start();

// Initialize error message variable
$error_message = "";

// Check if user is already logged in and redirect based on privilege
if (isset($_SESSION['privilege']) && $_SESSION['privilege'] == 'admin') {
    header("Location: admin_dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input to prevent XSS
    $username = htmlspecialchars(trim($_POST["username"]));
    $password = htmlspecialchars(trim($_POST["password"]));

    if (empty($username) || empty($password)) {
        $error_message = "Please fill in all fields.";
    } else {
        try {
            $stmt = $conn->prepare("SELECT password, first_name, last_name, privilege FROM admin WHERE username = ?");
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
                if ($password === $stored_password && $privilege == 'admin') { 
                    session_regenerate_id(true);
                    $_SESSION['username'] = $username;
                    $_SESSION['first_name'] = $firstname;
                    $_SESSION['last_name'] = $lastname;
                    $_SESSION['privilege'] = $privilege; 

                    header("Location: admin_Dashboard.php");
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
    <link rel="stylesheet" href="CSS/login_Admins.css" />
</head>
<body>
    <style>body {
        background: rgba(0, 0, 0, 0.2)  url('img/kolot.jpg') center/cover no-repeat fixed;
    }

    </style>
    
    <form action="" method="post">
        <div class="wrapper">
            <div class="login-wrapper">
                <div class="login-header">Admin</div>
                <div class="login-form">
                    <!-- Show Error -->
                    <?php if (!empty($error_message)) { ?>
                        <p class="error"><?php echo $error_message; ?></p>
                    <?php } ?>
                    <div class="input-wrapper">
                        <input type="text" id="username" name="username" class="input-field" required />
                        <label for="username" class="label">Username</label>
                        <i class="bx bx-user icon"></i>
                    </div>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" class="input-field" required />
                        <label for="password" class="label">Password</label>
                        <i class="bx bx-lock-alt icon"></i>
                    </div>
                    <div class="login-check">
                         <div class="show">
                             <input type="checkbox" id="show-password" name="show-password" />
                              <label for="show-password">Show Password</label>
                         </div>
                        <div class="forgot">
                            <a href="#">Forgot Password?</a>
                        </div>
                    </div>
                    <div class="input-wrapper">
                        <button class="input-login" type="submit">Login</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
