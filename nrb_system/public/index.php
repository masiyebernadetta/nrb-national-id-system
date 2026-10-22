<?php
require_once __DIR__ . '/../includes/header.php';

// Fetch some simple stats from the database
$applicants = $pdo->query("SELECT COUNT(*) FROM MALAWIAN_CITIZEN")->fetchColumn();
$applications = $pdo->query("SELECT COUNT(*) FROM NEW_APPLICATION")->fetchColumn();
$cards = $pdo->query("SELECT COUNT(*) FROM NATIONAL_ID_CARD")->fetchColumn();
?>

<h1>Welcome to NRB System</h1>
<p>Manage applicant registrations, applications, and National ID card issuance.</p>

<div style="display: flex; gap: 20px; margin-top: 30px;">
    <div style="flex: 1; background: #ebf8ff; padding: 20px; border-radius: 8px; text-align: center;">
        <h2 style="color: #2b6cb0; font-size: 2.5em; margin: 0;"><?= $applicants ?></h2>
        <p>Registered Applicants</p>
    </div>
    <div style="flex: 1; background: #ebf8ff; padding: 20px; border-radius: 8px; text-align: center;">
        <h2 style="color: #2b6cb0; font-size: 2.5em; margin: 0;"><?= $applications ?></h2>
        <p>Total Applications</p>
    </div>
    <div style="flex: 1; background: #ebf8ff; padding: 20px; border-radius: 8px; text-align: center;">
        <h2 style="color: #2b6cb0; font-size: 2.5em; margin: 0;"><?= $cards ?></h2>
        <p>ID Cards Issued</p>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>