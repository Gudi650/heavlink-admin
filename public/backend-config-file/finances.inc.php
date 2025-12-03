<?php
// finances.inc.php
// Provides $successfulPayments and $failedPayments arrays for the finances view.

// Require DB connection
require_once __DIR__ . '/../includes/dbh.inc.php';

$successfulPayments = [];
$failedPayments = [];

try {
    // Defensive: check that the table exists
    $check = $pdo->query("SHOW TABLES LIKE 'church_payments'");
    if ($check->rowCount() === 0) {
        // table not present, leave arrays empty
    } else {
        // Updated to match actual schema: church_payments (id, church_id, amount, start_date, end_date, status)
        // Join to churches to obtain a display name
        $sql = "SELECT cp.id, cp.church_id, cp.amount, cp.start_date, cp.end_date, cp.status, c.name AS church_name
                  FROM church_payments cp
                  LEFT JOIN churches c ON cp.church_id = c.church_id
                  ORDER BY cp.start_date DESC
                  LIMIT 500";
        $stmt = $pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $r) {
            $status = strtolower(trim($r['status'] ?? ''));
            // Use church name as the user/owner label
            $user = $r['church_name'] ?: ('Church ' . ($r['church_id'] ?? 'N/A'));

            $item = [
                'order_ref' => $r['id'] ?? null,
                'user' => $user,
                'product' => 'Subscription',
                'system' => null,
                'amount' => isset($r['amount']) ? number_format((float)$r['amount'], 2) : null,
                'start_date' => !empty($r['start_date']) ? $r['start_date'] : null,
                'end_date' => !empty($r['end_date']) ? $r['end_date'] : null,
                'status' => $r['status'] ?? '',
                'date' => $r['start_date'] ?? null,
                'phone' => null,
            ];

            if (in_array($status, ['success','paid','active','completed'], true)) {
                $successfulPayments[] = $item;
            } else {
                $failedPayments[] = $item;
            }
        }
    }
} catch (Exception $e) {
    error_log('Finances fetch error: ' . $e->getMessage());
}
