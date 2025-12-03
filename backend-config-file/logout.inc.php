<?php
// Server-side logout handler: clears session, destroys session data, deletes session cookie
// and regenerates a fresh session id to mitigate session fixation/hijacking.
require_once __DIR__ . '/../includes/session_config.inc.php';

// Clear session data
$_SESSION = [];
session_unset();

// Delete session cookie using the same params as session
$params = session_get_cookie_params();
setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);

// Destroy the session on the server
session_destroy();

// Start a new session and regenerate the id to ensure a clean session context
session_start();
session_regenerate_id(true);

// Redirect to login page
header('Location: ../login.php');
exit();
