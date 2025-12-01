<?php

include_once __DIR__ . '/../includes/session_config.inc.php';

//include the db conneection configuration files
include_once __DIR__ . '/../includes/dbh.inc.php';

//query the total amount of demo churches
$query = "SELECT COUNT(*) AS totaldemos FROM demo";
$stmt = $pdo->prepare($query);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['totaldemos'] = $result['totaldemos'];

// query total sales (sum of amount in church_payments)
try {
	$query = "SELECT SUM(amount) AS totalsales FROM church_payments";
	$stmt = $pdo->prepare($query);
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	$totalSales = $result['totalsales'] !== null ? (float)$result['totalsales'] : 0.0;
	// store formatted value in session (no currency symbol to allow flexible display)
	$_SESSION['totalsales'] = number_format($totalSales, 2);
} catch (Exception $e) {
	// if table doesn't exist or error, default to 0.00
	$_SESSION['totalsales'] = number_format(0, 2);
}

//query the total amount of subscribers

//query total amount of churches in whole
$query = "SELECT COUNT(*) AS totalchurches FROM churches";
$stmt = $pdo->prepare($query);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['totalchurches'] = $result['totalchurches'];

// query new members (users) registered this month
$query = "SELECT COUNT(*) AS new_members_this_month FROM churches WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())";
$stmt = $pdo->prepare($query);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
// store in session to be used in the dashboard
$_SESSION['newMembersThisMonth'] = $result['new_members_this_month'] ?? 0;

// Fetch the two most recent churches that have paid (based on latest end_date)
$latestPayers = [];
try {
	$sql = "SELECT c.church_id, c.name, c.contact_email, MAX(cp.end_date) AS last_paid
			FROM church_payments cp
			JOIN churches c ON cp.church_id = c.church_id
			GROUP BY c.church_id, c.name, c.contact_email
			ORDER BY last_paid DESC
			LIMIT 2";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($rows as $r) {
		$latestPayers[] = [
			'church_id' => $r['church_id'],
			'name' => $r['name'],
			'contact_email' => $r['contact_email'],
			'last_paid' => $r['last_paid'],
		];
	}
} catch (Exception $e) {
	// leave $latestPayers empty on error
}

// expose to including templates
$GLOBALS['latestPayers'] = $latestPayers;


