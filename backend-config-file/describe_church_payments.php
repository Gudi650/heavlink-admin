<?php
require __DIR__ . '/../includes/dbh.inc.php';
try {
    $stmt = $pdo->query("SHOW COLUMNS FROM church_payments");
    $cols = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($cols as $c) {
        echo $c['Field'] . "\t" . $c['Type'] . "\n";
    }
} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage();
}
