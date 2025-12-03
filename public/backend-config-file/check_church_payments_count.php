<?php
require __DIR__ . '/../includes/dbh.inc.php';
try {
    $c = $pdo->query('SELECT COUNT(*) FROM church_payments')->fetchColumn();
    echo (int)$c;
} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage();
}
