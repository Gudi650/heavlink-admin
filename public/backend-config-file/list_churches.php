<?php
require __DIR__ . '/../includes/dbh.inc.php';
try {
    $stmt = $pdo->query('SELECT church_id, name FROM churches LIMIT 50');
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($rows)) { echo "No churches found\n"; }
    foreach ($rows as $r) {
        echo $r['church_id'] . "\t" . ($r['name'] ?? '') . "\n";
    }
} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage();
}
