<?php
require_once 'includes/auth.php';

// Destroy the session
$_SESSION = array();
session_destroy();

// Redirect to login page
header("Location: login.php");
exit();
?>