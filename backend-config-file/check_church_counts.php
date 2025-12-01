<?php
require_once __DIR__ . '/../includes/dbh.inc.php';
if (!isset($pdo) || !($pdo instanceof PDO)) { echo "No PDO\n"; exit(1); }
// Show columns for debugging (helps when column names differ)
$cols = $pdo->query("SHOW COLUMNS FROM churches")->fetchAll(PDO::FETCH_ASSOC);
echo "Columns in churches table:\n";
foreach ($cols as $c) {
    echo "- " . $c['Field'] . " (" . $c['Type'] . ")\n";
}

$sql = "SELECT * FROM churches WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH) ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (!$rows) {
    echo "No rows returned\n";
} else {
    echo "\nRecent rows (showing keys/values):\n";
    foreach ($rows as $r) {
        foreach ($r as $k => $v) {
            echo "$k=$v | ";
        }
        echo "\n";
    }
}

// Also print grouped counts
$sql2 = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS ym, COUNT(*) AS cnt FROM churches WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH) GROUP BY ym ORDER BY ym";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute();
$groups = $stmt2->fetchAll(PDO::FETCH_ASSOC);
if ($groups) {
    echo "\nGrouped counts:\n";
    foreach ($groups as $g) {
        echo sprintf("%s => %s\n", $g['ym'], $g['cnt']);
    }
} else {
    echo "\nNo grouped counts returned\n";
}
