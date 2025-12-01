<?php
// Basic settings handler (placeholder).
require_once __DIR__ . '/../includes/auth.inc.php';
require_once __DIR__ . '/../includes/dbh.inc.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../Settings.php');
    exit();
}

$action = $_POST['action'] ?? '';
try {
    switch ($action) {
        case 'profile':
            // TODO: validate and save profile to DB
            $_SESSION['settings_success'] = 'Profile updated successfully.';
            break;
        case 'password':
            // Change password for current admin
            $current = $_POST['current_password'] ?? '';
            $new = $_POST['new_password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';
            $errs = [];

            if (empty($current) || empty($new) || empty($confirm)) {
                $errs[] = 'Fill in all password fields.';
            }

            if ($new !== $confirm) {
                $errs[] = 'New passwords do not match.';
            }

            if (strlen($new) < 8) {
                $errs[] = 'New password must be at least 8 characters.';
            }

            if ($errs) {
                $_SESSION['settings_errors'] = $errs;
                break;
            }

            // Load current admin password
            $adminId = $_SESSION['user_id'] ?? null;
            if (!$adminId) {
                $_SESSION['settings_errors'] = ['Not authenticated. Please login again.'];
                break;
            }

            $stmt = $pdo->prepare('SELECT psw FROM admin WHERE id = :id');
            $stmt->execute([':id' => $adminId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) {
                $_SESSION['settings_errors'] = ['Account not found.'];
                break;
            }

            $hash = $row['psw'];
            if (!password_verify($current, $hash)) {
                $_SESSION['settings_errors'] = ['Current password is incorrect.'];
                break;
            }

            if (password_verify($new, $hash)) {
                $_SESSION['settings_errors'] = ['New password must be different from the current password.'];
                break;
            }

            $newHash = password_hash($new, PASSWORD_DEFAULT);
            $up = $pdo->prepare('UPDATE admin SET psw = :psw WHERE id = :id');
            $up->execute([':psw' => $newHash, ':id' => $adminId]);

            $_SESSION['settings_success'] = 'Password changed successfully.';
            break;
        case 'appearance':
            // TODO: handle file upload and save path
            $_SESSION['settings_success'] = 'Appearance saved successfully.';
            break;
        case 'notifications':
            // TODO: save notification prefs
            $_SESSION['settings_success'] = 'Notification preferences saved.';
            break;
        default:
            $_SESSION['settings_errors'] = ['Unknown action.'];
    }
} catch (Exception $e) {
    $_SESSION['settings_errors'] = ['An error occurred: ' . $e->getMessage()];
}

header('Location: ../Settings.php');
exit();
