<?php
// Start session before any output
require_once '../includes/session_config.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    require_once '../includes/dbh.inc.php';

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $errors = [];

    // Error handlers

    //checking for empty fields
    if (empty($email) || empty($password)) {
        $errors['empty_fields'] = "Fill in all the fields";
    }
    //validating the email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['invalid_email'] = "Invalid email format";
    }

    // Only query DB if no input errors
    if (!$errors) {
        $query = "SELECT id, psw FROM admin WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$admin) {
            $errors['email_not_found'] = "Email not found";
        } else {
            $hashedPassword = $admin['psw'];
            if (!password_verify($password, $hashedPassword)) {
                $errors['invalid_password'] = "Incorrect password";
            }
        }
    }

    if ($errors) {
        $_SESSION['login_errors'] = $errors;
        header("Location: ../index.php");
        exit();
    }

    // Successful login: set session and redirect
    $_SESSION['user_id'] = $admin['id'];
    header("Location: ../dashboard.php");
    exit();

} else {
    header("Location: ../index.php");
    exit();
}
