<?php
require_once 'db_con.php';
session_start();

if (isset($_POST['register'])) {
    $id = $_POST['id'];
    $student_number = $_POST['student_number']; // Ensure this field exists in your form
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];
    $year_level = $_POST['year_level']; // Ensure this field is also included in your form
    $age = $_POST['age']; // Ensure this field is also included in your form

    $input_error = array();
    $email_error = '';
    $username_error = '';

    // Validate input data
    if (empty($first_name)) {
        $input_error['first_name'] = "The First Name Field is Required";
    }
    if (empty($middle_name)) {
        $input_error['middle_name'] = "The Middle Name Field is Required";
    }
    if (empty($last_name)) {
        $input_error['last_name'] = "The Last Name Field is Required";
    }
    if (empty($address)) {
        $input_error['address'] = "The Address Field is Required";
    }
    if (empty($email)) {
        $input_error['email'] = "The Email Field is Required";
    }
    if (empty($username)) {
        $input_error['username'] = "The Username Field is Required";
    }
    if (empty($password)) {
        $input_error['password'] = "The Password Field is Required";
    }
    if ($password !== $c_password) {
        $input_error['notmatch'] = "You Typed Wrong Password!";
    }
    if (empty($year_level)) {
        $input_error['year_level'] = "The Year Level Field is Required";
    }
    if (empty($age)) {
        $input_error['age'] = "The Age Field is Required";
    }

    // Check if username or email already exists
    $stmt = $db_con->prepare("SELECT * FROM `student` WHERE `email` = ? OR `username` = ?");
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['email'] === $email) {
            $email_error = "This email already exists";
        }
        if ($row['username'] === $username) {
            $username_error = "This username already exists";
        }
    }


    // Insert data into database
    if (count($input_error) == 0 && empty($email_error) && empty($username_error)) {
        $stmt = $db_con->prepare("INSERT INTO `student` (`id`, `student_number`, `last_name`, `first_name`, `middle_name`, `year_level`, `age`, `address`, `email`, `username`, `password`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisssisisss", $id, $student_number, $last_name, $first_name, $middle_name, $year_level, $age, $address, $email, $username, $password);
        
        if ($stmt->execute()) {
            header('Location: register.php?insert=success');
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}

// Display error messages
if (isset($input_error)) {
    foreach ($input_error as $error) {
        echo "<label class='error'>$error</label>";
    }
}
if (!empty($email_error)) {
    echo "<label class='error'>$email_error</label>";
}
if (!empty($username_error)) {
    echo "<label class='error'>$username_error</label>";
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="register.css">
</head>
<body>
     <form method="POST" action="">
    <div class="header">
    <h1 class="h1">Welcome to Student Registration Form</h1>
    <script>
        const marqueeElement = document.querySelector('.h1');
    
        marqueeElement.addEventListener('mouseover', () => {
            marqueeElement.style.animationPlayState = 'paused';
        });
    
        marqueeElement.addEventListener('mouseout', () => {
            marqueeElement.style.animationPlayState = 'running';
        });
    </script>
      </div>
		<?php 
          		if (isset($_GET['insert'])) {
          			if($_GET['insert']=='sucess'){ echo '<div role="alert" aria-live="assertive" aria-atomic="true" align="center" class="toast alert alert-success fade hide" data-delay="2000">Your Data Inserted!</div>';}
          		}
          	;?>
			<div class="form-group row">
                 <div class="col-sm-6">
                      <input type="text" name="id" class="form-control" placeholder="ID">
                 </div>
                 <div class="col-sm-6">
                      <input type="text" name="student_number" class="form-control" placeholder="Student Number">
                 </div>
                 <div class="col-sm-6">
                      <input type="text" name="first_name" class="form-control" placeholder="First Name">
                 </div>
                <div class="col-sm-6">
                      <input type="text" name="middle_name" class="form-control" placeholder="Middle Name">
                </div>
                <div class="col-sm-6">
                      <input type="text" name="last_name" class="form-control" placeholder="Last Name">
                </div>
                <div class="col-sm-6">
                      <input type="text" name="email" class="form-control" placeholder="Email">
                </div>
                <div class="col-sm-6">
                      <input type="text" name="address" class="form-control" placeholder="Address">
                </div>
                <div class="col-sm-6">
                     <input type="text" name="year_level" class="form-control" placeholder="Year Level">
                </div>
                <div class="col-sm-6">
                     <input type="text" name="age" class="form-control" placeholder="Age">
               </div>
               <div class="col-sm-6">
                     <input type="text" name="username" class="form-control" placeholder="Username">
               </div>
               <div class="col-sm-6">
                     <input type="text" name="password" class="form-control" placeholder="Password">
               </div>
               <div class="col-sm-6">
                     <input type="text" name="c_password" class="form-control" placeholder="Confirm Password">
               </div>
               
				  <div class="text-center">
				      <button type="submit" name="register" class="btn btn-danger">Register!</button>
				    </div>
                    <p>If you have account, you can <a href="loginS.php">Login</a> your account!</p>
				</form>
                </div>
            </di>
            
</body>
</html>





