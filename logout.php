<!-- Bikin Logout -->
<?php
//  seharusnya ada session_start
session_start();
session_destroy();
// tambahin redirect deh, jadi pas logout langsung diarahin ke login
header('location: login.php');
?>