<?php
// logout.php - Handle user logout
session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page
header('Location: index.php');
exit;
?>