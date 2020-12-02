<!-- Bikin Logout -->
<?php
// session_start
session_start();
session_destroy();
// tambahin redirect, pas logout langsung diarahin ke login
header('location: login.php');
?>