<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role Selection</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
  body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f9;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  margin: 0;
}

.role-selection {
  text-align: center;
}

.role-card {
  background: white;
  border-radius: 8px;
  padding: 30px; 
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: 0.3s;
}

.role-card:hover {
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
  transform: translateY(-5px);
}

.role-icon {
  font-size: 50px;
  color: #007bff;
  margin-bottom: 20px;
}

.role-title {
  font-size: 22px;
  font-weight: bold;
}

.role-desc {
  font-size: 14px;
  color: #6c757d;
}

.role-btn {
  margin-top: 15px;
}
    </style>
</head>

<body>

    <div class="container role-selection">
        <h1>Select Your Role</h1>
        <div class="row mt-5">

            <!-- Student Card -->
            <div class="col-md-3">
                <div class="role-card">
                    <i class="fas fa-user-graduate role-icon"></i>
                    <h3 class="role-title">Student</h3>
                    <p class="role-desc">Access to course materials and grades.</p>
                    <a href="login_Student.php" class="btn btn-primary role-btn">Select</a>
                </div>
            </div>

            <!-- Instructor Card -->
            <div class="col-md-3">
                <div class="role-card">
                    <i class="fas fa-chalkboard-teacher role-icon"></i>
                    <h3 class="role-title">Instructor</h3>
                    <p class="role-desc">Manage courses and monitor student progress.</p>
                    <a href="login_Instructor.php" class="btn btn-primary role-btn">Select</a>
                </div>
            </div>

            <!-- Admin Card -->
            <div class="col-md-3">
                <div class="role-card">
                    <i class="fas fa-user-shield role-icon"></i>
                    <h3 class="role-title">Admin</h3>
                    <p class="role-desc">Oversee platform and verify user accounts.</p>
                    <a href="login_Admins.php" class="btn btn-primary role-btn">Select</a>
                </div>
            </div>

            <!-- Super Admin Card -->
            <div class="col-md-3">
                <div class="role-card">
                    <i class="fas fa-user-cog role-icon"></i>
                    <h3 class="role-title">Super Admin</h3>
                    <p class="role-desc">Full control of system settings and permissions.</p>
                    <a href="login_SuperAdmin.php" class="btn btn-primary role-btn">Select</a>
                </div>
            </div>

        </div>
    </div>

</body>

</html>