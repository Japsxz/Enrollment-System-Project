<?php
include("db_register.php");

session_start();

// Initialize error message variable
$error_message = "";

// Check if user is already logged in
if (isset($_SESSION['role']) && $_SESSION['role'] == 'instructor') {
    header("Location: instructor_dashboard.php");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Using htmlspecialchars to prevent XSS
    $username = htmlspecialchars(trim($_POST["username"]));
    $password = htmlspecialchars(trim($_POST["password"]));

    
    if (empty($username) || empty($password)) {
        $error_message = "Please fill in all fields.";
    } else {
        try {
           
            $stmt = $conn->prepare("SELECT password, first_name, last_name FROM instructor WHERE username = ?"); 
            $stmt->bind_param("s", $username);             
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user_data = $result->fetch_assoc();
                $stored_password = $user_data["password"];
                $firstname = $user_data["first_name"];
                $lastname = $user_data["last_name"];

                if ($password === $stored_password){ 
                    session_regenerate_id(true);
                    $_SESSION['username'] = $username;
                    $_SESSION['first_name'] = $firstname;
                    $_SESSION['last_name'] = $lastname;
                    $_SESSION['role'] = 'instructor';
                  
                    header("Location: instructor_dashboard.php");
                    exit;
                } else {
                    // Set error message for invalid password
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
    <link rel="stylesheet" href="CSS/login_Instructor.css"/>
</head>
<body>
<style>body {
    background: rgba(0, 0, 0, 0.2)  url('img/back.jpg') center/cover no-repeat fixed;
    }
</style>
    <form action="" method="post">
        <div class="wrapper">
            <div class="login-wrapper">
                <div class="login-header">Instructor</div>
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