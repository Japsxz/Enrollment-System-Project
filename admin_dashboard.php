<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <title>Admin Panel</title>
</head>
<body>
    <div class="side-menu">
        <div class="brand-name">
            <h1>Admin</h1>
        </div>
        <ul>
            <li><a href="dashboard.html"><img src="dashboard (2).png" alt="">&nbsp; <span>Dashboard</span></a></li>
            <li><a href="students.html"><img src="reading-book.png" alt="">&nbsp;<span>Students</span></a</li>
            <li><a href="teachers.html"><img src="teacher2.png" alt="">&nbsp;<span>Teachers</span></a></li>
        </ul>
    </div>
    <div class="container">
        <div class="header">
            <div class="nav">
                <div class="search">
                    <input type="text" placeholder="Search..">
                    <button type="submit"><img src="search.png" alt=""></button></a>
                </div>
                <div class="user">
                 <a href="#" id="notifications-link"><img src="notifications.png" alt=""></a>
                    <div class="img-case">
                        <a href="user-profile.html"><img src="user.png" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="cards">
                <div class="card">
                    <div class="box">
                        <h1>2194</h1>
                        <h3>Students</h3>
                    </div>
                    <div class="icon-case">
                        <img src="students.png" alt="">
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h1>53</h1>
                        <h3>Teachers</h3>
                    </div>
                    <div class="icon-case">
                        <img src="teachers.png" alt="">
                    </div>
                </div>
                
            </div>
            <div class="content-2">
                <div class="allstudents">
                    <div class="title">
                        <h2>All Students</h2>
                        <a href="#" class="btn">View All</a>
                        <table id="allUsers"></table>
                    </div>
                    <table>
                        <tr>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Verification Status</th>
                        </tr>
                        <tr>
                            <td><img src="user.png" alt="User  Profile" style="width: 50px; height: 50px;"></td>
                            <td>Ashlene Magbual</td>
                            <td>
                                <i class="fas fa-times" style="color: red;" id="verify-1" onclick="toggleVerify(1)"></i>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="user.png" alt="User  Profile" style="width: 50px; height: 50px;"></td>
                            <td>Jane Smith</td>
                            <td>
                                <i class="fas fa-times" style="color: red;" id="verify-2" onclick="toggleVerify(2)"></i>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="user.png" alt="User  Profile" style="width: 50px; height: 50px;"></td>
                            <td>Bob Johnson</td>
                            <td>
                                <i class="fas fa-times" style="color: red;" id="verify-3" onclick="toggleVerify(3)"></i>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="user.png" alt="User  Profile" style="width: 50px; height: 50px;"></td>
                            <td>Alice Brown</td>
                            <td>
                                <i class="fas fa-times" style="color: red;" id="verify-4" onclick="toggleVerify(4)"></i>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="verified">
                    <div class="title">
                     <h2>Verified Students</h2>
                     <table id="verifiedUsers"></table>
                        <a href="#" class="btn">View All</a>
                    </div>
                    <table>
                        <tr>
                            <th>Name</th>
                            <th>Verified</th>
                        </tr>
                        <tr>
                            <td>John Doe</td>
                            <td><i class="fas fa-check" style="color: green;"></i></td>
                        </tr>
                        <tr>
                            <td>Jane Smith</td>
                            <td><i class="fas fa-check" style="color: green;"></i></td>
                        </tr>
                        <tr>
                            <td>Bob Johnson</td>
                            <td><i class="fas fa-check" style="color: green;"></i></td>
                        </tr>
                        <tr>
                            <td>Alice Brown</td>
                            <td><i class="fas fa-check" style="color: green;"></i></td>
                        </tr>
                        <tr>
                            <td>Charlie White</td>
                            <td><i class="fas fa-check" style="color: green;"></i></td>
                        </tr>
                        <tr>
                            <td>Emily Green</td>
                            <td><i class="fas fa-check" style="color: green;"></i></td>
                        </tr>
                    </table>

                    <script>
                        function toggleVerify(userId) {
                            const verifyIcon = document.getElementById(`verify-${userId}`);
                            const userRow = verifyIcon.closest('tr');
                            const verifiedTable = document.getElementById('verifiedUsers');
                
                            if (verifyIcon.classList.contains('fa-times')) {
                                // Change to verified
                                verifyIcon.classList.remove('fa-times');
                                verifyIcon.classList.add('fa-check');
                                verifyIcon.style.color = 'green';
                
                                // Move user to verified table
                                const userName = userRow.cells[1].innerText;
                                const userProfile = userRow.cells[0].innerHTML;
                
                                // Create new row for verified user
                                const newRow = verifiedTable.insertRow(-1);
                                newRow.innerHTML = `<td>${userProfile}</td><td>${userName}</td>`;
                
                                // Remove user from all users table
                                userRow.remove();
                            } else {
                                // Change to not verified
                                verifyIcon.classList.remove('fa-check');
                                verifyIcon.classList.add('fa-times');
                                verifyIcon.style.color = 'red';
                
                                // Move user back to all users table
                                const userName = userRow.cells[1].innerText;
                                const userProfile = userRow.cells[0].innerHTML;
                
                                // Create new row for all users table
                                const allUsersTable = document.getElementById('allUsers');
                                const newRow = allUsersTable.insertRow(-1);
                                newRow.innerHTML = `<td>${userProfile}</td><td>${userName}</td><td><i class="fas fa-times" style="color: red;" id="verify-${userId}" onclick="toggleVerify(${userId})"></i></td>`;
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</body>
</html


