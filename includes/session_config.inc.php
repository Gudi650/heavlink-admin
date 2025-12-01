<?php

// Use secure cookies only when the request is over HTTPS.
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
$domain = $_SERVER['HTTP_HOST'] ?? 'localhost';

session_set_cookie_params([
    'lifetime' => 1800,
    'domain' => $domain,
    'path' => '/',
    'secure' => $secure,
    'httponly' => true,
    'samesite' => 'Lax',
]);

session_start();

// Regenerate session ID periodically to reduce fixation risk.
// Keep a last_regeneration timestamp in session to avoid excessive calls.
if (!isset($_SESSION['last_regeneration'])) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
} else {
    $interval = 60 * 30; // 30 minutes
    if (time() - $_SESSION['last_regeneration'] >= $interval) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}

function regenerate_session_id() {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}



