<?php
/**
 * Database Connection using PDO
 * XAMPP Default Settings (root user, no password)
 */

$host = 'localhost';
$db   = 'nrb_national_id';
$user = 'root';
$pass = 'bernamasiye@1026'; // XAMPP default is empty
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // If connection fails, stop and show the error
    die("Database connection error: " . $e->getMessage());
}
?>