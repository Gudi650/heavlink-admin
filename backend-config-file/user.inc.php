<?php
// Start session before any output
require_once __DIR__ . '/../includes/session_config.inc.php';

// Include database connection
require_once __DIR__ . '/../includes/dbh.inc.php';



    //fetch church data from db 

    $query = "SELECT church_id,name,address, type,address, contact_phone, contact_email FROM churches ORDER BY created_at DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $churches = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //checking if any church data is fetched
    if (!$churches) {
        $churches = [];
    }

    //codes for fetching the data from demo request user