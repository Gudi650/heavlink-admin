<?php

$username = 'heavlink_user';
$password = 'supersecret123';
$dsn="mysql:host=heavlink-mysql;dbname=heavlink;charset=utf8mb4";


try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $pdo->exec("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");
    // echo "Connected successfully";
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>