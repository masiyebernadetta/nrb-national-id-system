<?php
require_once __DIR__ . '/../config/db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NRB National ID System</title>
    <!-- Notice we go up one folder out of 'includes' to reach 'assets' -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<nav class="navbar">
    <div class="nav-brand">🇲🇼 NRB National ID System</div>
    <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="register.php">Register</a></li>
        <li><a href="applicants_list.php">Applicants</a></li>
        <li><a href="cards_list.php">ID Cards</a></li>
    </ul>
</nav>
<main class="container">

<?php
// Display success or error flash messages
if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success">' . e($_SESSION['success']) . '</div>';
    unset($_SESSION['success']); // Remove it so it doesn't show again on refresh
}
if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-error">' . e($_SESSION['error']) . '</div>';
    unset($_SESSION['error']);
}
?>