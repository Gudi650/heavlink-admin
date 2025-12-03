<?php
// Signup handler for admin accounts
require_once '../includes/session_config.inc.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../signup.php');
    exit();
}

require_once '../includes/dbh.inc.php';

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';
$errors = [];

// Basic validation
if (empty($email) || empty($password) || empty($confirm)) {
    $errors[] = 'Fill in all the fields';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid email format';
}

if ($password !== $confirm) {
    $errors[] = 'Passwords do not match';
}

if (strlen($password) < 8) {
    $errors[] = 'Password must be at least 8 characters';
}

if ($errors) {
    $_SESSION['signup_errors'] = $errors;
    header('Location: ../signup.php');
    exit();
}

// Check if email already exists
try {
    $stmt = $pdo->prepare('SELECT id FROM admin WHERE email = :email');
    $stmt->execute([':email' => $email]);
    if ($stmt->fetch()) {
        $_SESSION['signup_errors'] = ['Email already in use'];
        header('Location: ../signup.php');
        exit();
    }

    // Insert new admin
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $insert = $pdo->prepare('INSERT INTO admin (email, psw) VALUES (:email, :psw)');
    $insert->execute([':email' => $email, ':psw' => $hash]);

    $_SESSION['signup_success'] = 'Account created. Please login.';
    header('Location: ../login.php');
    exit();
} catch (PDOException $e) {
    $_SESSION['signup_errors'] = ['Database error: ' . $e->getMessage()];
    header('Location: ../signup.php');
    exit();
}
