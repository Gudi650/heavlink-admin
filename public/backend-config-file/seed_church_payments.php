<?php
// seed_church_payments.php
// Safe development-only seeder for the `church_payments` table.
// Usage: visit this file in your browser with ?confirm=1 to actually run.

// Allow running from browser (?confirm=1) or CLI (--confirm)
$run = false;
if (PHP_SAPI === 'cli') {
    global $argv;
    $run = in_array('--confirm', $argv, true) || in_array('confirm=1', $argv, true);
} else {
    $run = isset($_GET['confirm']) && $_GET['confirm'] === '1';
}

if (!$run) {
    echo "Seeder disabled. To run, append ?confirm=1 to the URL or run from CLI with --confirm.";
    exit();
}

// require DB
require_once __DIR__ . '/../includes/dbh.inc.php';

try {
    $pdo->beginTransaction();

    // Schema observed: id, church_id, amount, start_date, end_date, status
    $sql = "INSERT INTO church_payments (church_id, amount, start_date, end_date, status) VALUES (:church_id, :amount, :start_date, :end_date, :status)";
    $stmt = $pdo->prepare($sql);

    $now = new DateTime();
    // Use existing church IDs present in your DB to satisfy FK constraints
    $rows = [
        [ 'church_id'=>3, 'amount'=>100.00, 'start_date'=>date('Y-m-d', strtotime('-2 days')), 'end_date'=>date('Y-m-d', strtotime('+27 days')), 'status'=>'active'],
        [ 'church_id'=>5, 'amount'=>150.00, 'start_date'=>date('Y-m-d', strtotime('-61 days')), 'end_date'=>date('Y-m-d', strtotime('-31 days')), 'status'=>'failed'],
        [ 'church_id'=>6, 'amount'=>100.00, 'start_date'=>date('Y-m-d', strtotime('-5 days')), 'end_date'=>date('Y-m-d', strtotime('+25 days')), 'status'=>'active'],
        [ 'church_id'=>7, 'amount'=>150.00, 'start_date'=>date('Y-m-d', strtotime('-10 days')), 'end_date'=>date('Y-m-d', strtotime('-1 days')), 'status'=>'failed'],
        [ 'church_id'=>8, 'amount'=>250.00, 'start_date'=>date('Y-m-d', strtotime('-1 days')), 'end_date'=>date('Y-m-d', strtotime('+29 days')), 'status'=>'active'],
    ];

    $inserted = [];
    foreach ($rows as $r) {
        $stmt->execute([
            ':church_id'=>$r['church_id'],
            ':amount'=>$r['amount'],
            ':start_date'=>$r['start_date'],
            ':end_date'=>$r['end_date'],
            ':status'=>$r['status'],
        ]);
        $inserted[] = $pdo->lastInsertId();
    }

    $pdo->commit();

    echo "Inserted " . count($inserted) . " rows into church_payments. Insert IDs: " . implode(', ', $inserted);
} catch (Exception $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    echo "Error inserting seed data: " . htmlspecialchars($e->getMessage());
}
