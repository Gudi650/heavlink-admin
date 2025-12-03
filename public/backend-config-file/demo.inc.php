<?php

//requiring the session file
require_once __DIR__ . '/../includes/session_config.inc.php';

//requiring the database connection file
require_once __DIR__ . '/../includes/dbh.inc.php';

//fetching the total count of pending status needed to be approved
$query = "SELECT COUNT(*) AS total_rows FROM demo WHERE Status = 'pending';";
$stmt = $pdo->prepare($query);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['totaldemos'] = $result['total_rows'];



//fetching data from the demo table in db
$query = "SELECT fname,lname,email, churchname, role,CreatedAt,Status FROM demo ORDER BY CreatedAt DESC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$demos = $stmt->fetchAll(PDO::FETCH_ASSOC);

//checking if any church data is fetched
if (!$demos) {

    $demos = [];
    
}