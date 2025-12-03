<?php
// Handler for creating a church record safely.

// require session and db
require_once __DIR__ . '/../includes/session_config.inc.php';
require_once __DIR__ . '/../includes/dbh.inc.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../Churches.php');
    exit();
}

// collect posted values and trim
$posted = array_map(function($v){ return is_string($v) ? trim($v) : $v; }, $_POST);

// server-side validation for important fields
$errors = [];

// name is required
$name = $posted['name'] ?? '';
if (!is_string($name) || $name === '') {
    $errors[] = 'Church name is required.';
}

// establishd_date: optional but if provided must be a valid date and not in the future
if (!empty($posted['establishd_date'])) {
    $d = DateTime::createFromFormat('Y-m-d', $posted['establishd_date']);
    $validDate = $d && $d->format('Y-m-d') === $posted['establishd_date'];
    if (!$validDate) {
        $errors[] = 'Established date must be a valid date (YYYY-MM-DD).';
    } else {
        $today = new DateTime('today');
        if ($d > $today) {
            $errors[] = 'Established date cannot be in the future.';
        }
    }
}

// registration_number: optional, simple length/char check
if (!empty($posted['registration_number'])) {
    $reg = $posted['registration_number'];
    if (strlen($reg) > 100) {
        $errors[] = 'Registration number is too long.';
    }
    if (!preg_match('/^[A-Za-z0-9\-_. ]+$/', $reg)) {
        $errors[] = 'Registration number contains invalid characters.';
    }
}

// type: optional but if present must be one of allowed values
$allowedTypes = ['church','mission','ministry','other'];
if (!empty($posted['type'])) {
    $t = strtolower($posted['type']);
    if (!in_array($t, $allowedTypes, true)) {
        $errors[] = 'Invalid church type selected.';
    } else {
        // normalize
        $posted['type'] = $t;
    }
}

if (!empty($errors)) {
    // store errors and old input in session so the form can show them
    if (session_status() !== PHP_SESSION_ACTIVE) {
        @session_start();
    }
    $_SESSION['church_form_errors'] = $errors;
    $_SESSION['church_form_old'] = $posted;
    header('Location: ../registerChurch.php');
    exit();
}

try {
    // fetch existing columns from the churches table to avoid schema mismatch
    $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'churches'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $cols = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $cols = array_map('strtolower', $cols ?: []);

    // Prepare insertable fields only when they exist in table
    $insertCols = [];
    $placeholders = [];
    $params = [];

    foreach ($posted as $key => $val) {
        $k = strtolower($key);
        if (in_array($k, $cols, true)) {
            $insertCols[] = "`$k`";
            $placeholders[] = ":$k";
            $params[":$k"] = $val;
        }
    }

    if (empty($insertCols)) {
        // nothing to insert (no matching columns) - safe redirect
        header('Location: ../Churches.php');
        exit();
    }

    $sql = 'INSERT INTO churches (' . implode(',', $insertCols) . ') VALUES (' . implode(',', $placeholders) . ')';
    $stmt = $pdo->prepare($sql);
    foreach ($params as $ph => $val) {
        $stmt->bindValue($ph, $val);
    }
    $stmt->execute();

    // Redirect back to Churches page (no toast)
    header('Location: ../Churches.php');
    exit();

} catch (Exception $e) {
    error_log('Church insert error: ' . $e->getMessage());
    // safe fallback redirect
    header('Location: ../Churches.php');
    exit();
}
