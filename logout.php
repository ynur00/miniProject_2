<?php
session_start();

// kosongkan semua session
$_SESSION = [];

// destroy session
session_destroy();

// redirect balik ke login page
header("Location: login.php");
exit();
?>