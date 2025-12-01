<?php
// Centralized auth check for admin pages
// Requires session to be started and verifies that a user is logged in.
require_once __DIR__ . '/session_config.inc.php';

// If user is not authenticated, redirect to login page
if (empty($_SESSION['user_id'])) {
    // Provide a user-visible message on login page
    $_SESSION['login_errors'] = ['Please login to access the admin panel'];
    // Redirect to admin login (relative path expected from top-level admin pages)
    header('Location: login.php');
    exit();
}
