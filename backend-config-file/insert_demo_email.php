<?php
// Insert a single demo row with a specific email. Safe: requires ?confirm=1 to run.
require_once __DIR__ . '/../includes/session_config.inc.php';
require_once __DIR__ . '/../includes/dbh.inc.php';

if (!isset($pdo) || !($pdo instanceof PDO)) {
    echo "PDO connection not available.\n";
    exit;
}

if (empty($_GET['confirm']) || $_GET['confirm'] !== '1') {
    echo "Ready to insert demo row. Call with ?confirm=1 to run.\n";
    exit;
}

$email = 'sefepe3290@moondyal.com';
$now = date('Y-m-d H:i:s');

$insertSql = "INSERT INTO demo (fname, lname, email, phonenumber, churchname, role, churchsize, additionalinformation, CreatedAt, Status) VALUES (:fname, :lname, :email, :phonenumber, :churchname, :role, :churchsize, :additionalinformation, :CreatedAt, :Status)";
try {
    $stmt = $pdo->prepare($insertSql);
    $stmt->execute([
        ':fname' => 'Inserted',
        ':lname' => 'User',
        ':email' => $email,
        ':phonenumber' => '0000000000',
        ':churchname' => 'Inserted Church',
        ':role' => 'Member',
        ':churchsize' => '10-50',
        ':additionalinformation' => 'Inserted via script',
        ':CreatedAt' => $now,
        ':Status' => 'pending'
    ]);
    echo "Inserted demo row with email: " . htmlspecialchars($email) . "\n";
} catch (Exception $e) {
    echo "Error inserting row: " . htmlspecialchars($e->getMessage()) . "\n";
}
