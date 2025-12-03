<?php
// Seed script: insert 3 test churches to the `churches` table
// Safety: allow only CLI or localhost web requests
if (php_sapi_name() !== 'cli') {
    $remote = $_SERVER['REMOTE_ADDR'] ?? '';
    if (!in_array($remote, ['127.0.0.1', '::1'])) {
        http_response_code(403);
        echo "Forbidden\n";
        exit;
    }
}

require_once __DIR__ . '/../includes/dbh.inc.php'; // expects $pdo
if (!isset($pdo) || !($pdo instanceof PDO)) {
    echo "No database connection available.\n";
    exit(1);
}

$sample = [
    [
        'name' => 'Test Church Alpha',
        'code' => 'TCA' . rand(100,999),
        'type' => 'SDA',
        'address' => '100 Test St, Testville',
        'contact_email' => 'alpha@example.test',
        'contact_phone' => '255700000001',
        'established_date' => date('Y-m-d')
    ],
    [
        'name' => 'Test Church Beta',
        'code' => 'TCB' . rand(100,999),
        'type' => 'LUTHERAN',
        'address' => '200 Beta Ave, Testville',
        'contact_email' => 'beta@example.test',
        'contact_phone' => '255700000002',
        'established_date' => date('Y-m-d')
    ],
    [
        'name' => 'Test Church Gamma',
        'code' => 'TCG' . rand(100,999),
        'type' => 'METHODIST',
        'address' => '300 Gamma Rd, Testville',
        'contact_email' => 'gamma@example.test',
        'contact_phone' => '255700000003',
        'established_date' => date('Y-m-d')
    ]
];

$insertSql = "INSERT INTO churches (name, code, type, address, contact_email, contact_phone, established_date) VALUES (:name, :code, :type, :address, :contact_email, :contact_phone, :established_date)";
$pdo->beginTransaction();
try {
    $stmt = $pdo->prepare($insertSql);
    $inserted = [];
    foreach ($sample as $s) {
        $stmt->execute([
            ':name' => $s['name'],
            ':code' => $s['code'],
            ':type' => $s['type'],
            ':address' => $s['address'],
            ':contact_email' => $s['contact_email'],
            ':contact_phone' => $s['contact_phone'],
            ':established_date' => $s['established_date']
        ]);
        $inserted[] = $pdo->lastInsertId();
    }
    $pdo->commit();
    echo "Inserted " . count($inserted) . " churches. IDs: " . implode(', ', $inserted) . "\n";
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Insert failed: " . $e->getMessage() . "\n";
    exit(1);
}

return 0;
