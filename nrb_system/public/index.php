<?php
require_once __DIR__ . '/../includes/header.php';

// Fetch some simple stats from the database
$applicants = $pdo->query("SELECT COUNT(*) FROM MALAWIAN_CITIZEN")->fetchColumn();
$applications = $pdo->query("SELECT COUNT(*) FROM NEW_APPLICATION")->fetchColumn();
$cards = $pdo->query("SELECT COUNT(*) FROM NATIONAL_ID_CARD")->fetchColumn();
?>

<h1><i class="fas fa-id-card" style ="color: #3182ce;"></i> Welcome to NRB System</h1>
<p style="color: #666; font-size: 0.9em; margin-bottom: 20px;">
    <strong>Today is </strong> <?= date('l, F j, Y') ?>
</p>
<p>Manage applicant registrations, applications, and National ID card issuance.</p>

<div style="display: flex; gap: 20px; margin-top: 30px;">
    <!-- Applicants Box -->
    <a href="applicants_list.php" style="flex: 1; text-decoration: none; color: inherit;">
        <div style="background: #ebf8ff; padding: 20px; border-radius: 8px; text-align: center; border: 2px solid transparent; transition: 0.2s;" onmouseover="this.style.borderColor='#3182ce'; this.style.transform='scale(1.02)'" onmouseout="this.style.borderColor='transparent'; this.style.transform='scale(1)'">
            <h2 style="color: #2b6cb0; font-size: 2.5em; margin: 0;"><?= $applicants ?></h2>
            <p style="font-weight: bold;">Registered Applicants</p>
        </div>
    </a>

    <!-- Applications Box (Linking to Applicants List ) -->
    <a href="applicants_list.php" style="flex: 1; text-decoration: none; color: inherit;">
        <div style="background: #ebf8ff; padding: 20px; border-radius: 8px; text-align: center; border: 2px solid transparent; transition: 0.2s;" onmouseover="this.style.borderColor='#3182ce'; this.style.transform='scale(1.02)'" onmouseout="this.style.borderColor='transparent'; this.style.transform='scale(1)'">
            <h2 style="color: #2b6cb0; font-size: 2.5em; margin: 0;"><?= $applications ?></h2>
            <p style="font-weight: bold;">Total Applications</p>
        </div>
    </a>

    <!-- ID Cards Box -->
    <a href="cards_list.php" style="flex: 1; text-decoration: none; color: inherit;">
        <div style="background: #ebf8ff; padding: 20px; border-radius: 8px; text-align: center; border: 2px solid transparent; transition: 0.2s;" onmouseover="this.style.borderColor='#3182ce'; this.style.transform='scale(1.02)'" onmouseout="this.style.borderColor='transparent'; this.style.transform='scale(1)'">
            <h2 style="color: #2b6cb0; font-size: 2.5em; margin: 0;"><?= $cards ?></h2>
            <p style="font-weight: bold;">ID Cards Issued</p>
        </div>
    </a>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>