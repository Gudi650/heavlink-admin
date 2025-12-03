<?php
// Seeder: insert sample rows into `demo` for the last 4 months (including today)
// Safe: the script only runs when visited with ?confirm=1

require_once __DIR__ . '/../includes/session_config.inc.php';
require_once __DIR__ . '/../includes/dbh.inc.php';

if (!isset($pdo) || !($pdo instanceof PDO)) {
    echo "PDO connection not available. Check dbh.inc.php path and credentials.";
    exit;
}

if (empty($_GET['confirm']) || $_GET['confirm'] !== '1') {
    echo "Seeder ready. This script will insert sample demo rows for the last 4 months (including today).\n";
    echo "To run it, open this URL in your browser with ?confirm=1 or run via CLI: php seed_demo_today.php confirm=1\n";
    echo "Example: http://your-localhost/admin/backend-config-file/seed_demo_today.php?confirm=1\n";
    exit;
}

$now = time();
$samples = [
    // 2 rows for current month (today)
    [
        'fname' => 'Test',
        'lname' => 'Today1',
        'email' => 'test.today1+' . rand(1000,9999) . '@example.test',
        'phonenumber' => '0000000000',
        'churchname' => 'Demo Church Today 1',
        'role' => 'Pastor',
        'churchsize' => '50-100',
        'additionalinformation' => 'Seeder row',
        'CreatedAt' => date('Y-m-d H:i:s', $now),
        'Status' => 'pending'
    ],
    [
        'fname' => 'Test',
        'lname' => 'Today2',
        'email' => 'test.today2+' . rand(1000,9999) . '@example.test',
        'phonenumber' => '0000000001',
        'churchname' => 'Demo Church Today 2',
        'role' => 'Admin',
        'churchsize' => '100-200',
        'additionalinformation' => 'Seeder row',
        'CreatedAt' => date('Y-m-d H:i:s', $now),
        'Status' => 'approved'
    ],
    // 1 row for 1 month ago
    [
        'fname' => 'Test',
        'lname' => 'LastMonth',
        'email' => 'test.lastmonth+' . rand(1000,9999) . '@example.test',
        'phonenumber' => '0000000002',
        'churchname' => 'Demo Church Last Month',
        'role' => 'Member',
        'churchsize' => '10-50',
        'additionalinformation' => 'Seeder row',
        'CreatedAt' => date('Y-m-d H:i:s', strtotime('-1 month')),
        'Status' => 'pending'
    ],
    // 1 row for 2 months ago
    [
        'fname' => 'Test',
        'lname' => 'TwoMonths',
        'email' => 'test.twomonths+' . rand(1000,9999) . '@example.test',
        'phonenumber' => '0000000003',
        'churchname' => 'Demo Church 2 Months',
        'role' => 'Other',
        'churchsize' => '200+',
        'additionalinformation' => 'Seeder row',
        'CreatedAt' => date('Y-m-d H:i:s', strtotime('-2 months')),
        'Status' => 'pending'
    ],
    // 1 row for 3 months ago
    [
        'fname' => 'Test',
        'lname' => 'ThreeMonths',
        'email' => 'test.threemonths+' . rand(1000,9999) . '@example.test',
        'phonenumber' => '0000000004',
        'churchname' => 'Demo Church 3 Months',
        'role' => 'Volunteer',
        'churchsize' => '20-40',
        'additionalinformation' => 'Seeder row',
        'CreatedAt' => date('Y-m-d H:i:s', strtotime('-3 months')),
        'Status' => 'pending'
    ],
];

$insertSql = "INSERT INTO demo (fname, lname, email, phonenumber, churchname, role, churchsize, additionalinformation, CreatedAt, Status) VALUES (:fname, :lname, :email, :phonenumber, :churchname, :role, :churchsize, :additionalinformation, :CreatedAt, :Status)";
$inserted = 0;

try {
    $pdo->beginTransaction();
    $stmt = $pdo->prepare($insertSql);
    foreach ($samples as $s) {
        $stmt->execute([
            ':fname' => $s['fname'],
            ':lname' => $s['lname'],
            ':email' => $s['email'],
            ':phonenumber' => $s['phonenumber'],
            ':churchname' => $s['churchname'],
            ':role' => $s['role'],
            ':churchsize' => $s['churchsize'],
            ':additionalinformation' => $s['additionalinformation'],
            ':CreatedAt' => $s['CreatedAt'],
            ':Status' => $s['Status'],
        ]);
        $inserted += $stmt->rowCount();
    }
    $pdo->commit();
    echo "Inserted {$inserted} sample demo rows.\n";
    echo "Rows inserted with CreatedAt dates: \n";
    foreach ($samples as $s) {
        echo htmlspecialchars($s['CreatedAt']) . " - " . htmlspecialchars($s['email']) . "\n";
    }
    echo "\nYou can now reload the admin dashboard to see the updated charts (Pie & Bar).\n";
} catch (Exception $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    echo "Error inserting sample rows: " . htmlspecialchars($e->getMessage());
}
