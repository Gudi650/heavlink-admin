<?php
// Centralized auth check for admin pages
// Requires session to be started and verifies that a user is logged in.
require_once __DIR__ . '/session_config.inc.php';

// If user is not authenticated, redirect to login page
if (empty($_SESSION['user_id'])) {

    // Provide a user-visible message on login page
    $_SESSION['login_errors'] = ['Please login to access the admin panel'];

    // Allow overriding the login URL by defining ADMIN_LOGIN_URL (e.g. in a config file)
    if (defined('ADMIN_LOGIN_URL') && !empty(constant('ADMIN_LOGIN_URL'))) {
        $loginUrl = constant('ADMIN_LOGIN_URL');
    } else {
        // Build an absolute URL to the site's root index.php. This works when
        // the app is served from the web server's document root. If your app
        // lives in a subfolder, define ADMIN_LOGIN_URL to the correct path.
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $loginUrl = $scheme . '://' . $host . '/index.php';
    }

    header('Location: ' . $loginUrl);
    exit();
}
