<?php
session_start();
// I-unset ang lahat ng session variables
$_SESSION = array();

// Kung gusto mong i-destroy ang session
session_destroy();

// I-redirect ang user sa role selection page
header("Location: roleselection.php");
exit();
?>