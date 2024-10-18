<?php
include("db_register.php");

// Start a session and redirect to dashboard
session_start();

// Initialize error message variable
$error_message = "";

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT password, first_name, last_name FROM student WHERE username = ?"); // from database add lang ng column dito kapag gagamit ng session
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        $stored_password = $user_data["password"];
        $firstname = $user_data["first_name"];
        $lastname = $user_data["last_name"]; // then add dito $variable = $user_data["column name"]; 
                                                
        // Verify password (plain text comparison)
        // Verify password
    if ($password) {
        session_regenerate_id(true);
        $_SESSION['username'] = $username; 
        $_SESSION['first_name'] = $firstname; 
        $_SESSION['last_name'] = $lastname; 
        $_SESSION['role'] = 'student';
        header("Location: student_dashboard.php");      
       exit;
    } else {
    // Set error message for invalid password
    $error_message = "Incorrect Username or Password"; 
 
            // Set error message for invalid password
            $error_message = "Incorrect Username or Password"; //Ito yung error message kapag mali ang pag type
        }

    } else {
        // Set error message for username not found
        $error_message = "Username not found"; //error message din to
    }

    $stmt->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Enrollment System For BSIT</title>
    <link rel="stylesheet" href="CSS/login_Student.css"/>
</head>
<body>
<style>body {
    background: rgba(0, 0, 0, 0.2)  url('img/back.jpg') center/cover no-repeat fixed;
    }
</style>
    <form action="" method="post">
        <div class="wrapper">
            <div class="login-wrapper">
                <div class="login-header">Student</div>
                <div class="login-form">
                    <!-- Show Error -->
                    <?php if (!empty($error_message)) { ?> <!-- if not empty yung $error_message sa taas kukunin niya yung text then lagay dito -->
                        <p class="error"><?php echo $error_message; ?></p>  <!-- Dito siya pupunta yung error message -->
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
                               <a href="forgot.php">Forgot Password?</a>
                            </div>
                        </div>
                    <div class="input-wrapper">
                        <button class="input-login" type="submit">Login</button>
                    </div>
                    <div class="register">
                        <span>Don't have an account? <a href="register.php">Register</a></span>
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
