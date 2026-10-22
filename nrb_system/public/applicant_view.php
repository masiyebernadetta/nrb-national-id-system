<?php
require_once __DIR__ . '/../includes/header.php';

$id = (int)($_GET['id'] ?? 0);

// Get Citizen Details
$stmt = $pdo->prepare("
    SELECT mc.*, d.District_name, r.Region_name
    FROM MALAWIAN_CITIZEN mc
    LEFT JOIN DISTRICT d ON mc.District_ID = d.District_ID
    LEFT JOIN REGION r ON d.Region_ID = r.Region_ID
    WHERE mc.Person_ID = :id
");
$stmt->execute([':id' => $id]);
$applicant = $stmt->fetch();

if (!$applicant) {
    echo "<h1>Applicant not found</h1><a href='applicants_list.php' class='btn'>Go Back</a>";
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

// Get Applications for this person
$apps = $pdo->prepare("SELECT * FROM NEW_APPLICATION WHERE Person_ID = :id ORDER BY Application_date DESC");
$apps->execute([':id' => $id]);
$applications = $apps->fetchAll();
?>

<div style="display: flex; justify-content: space-between; align-items: center;">
    <h1>Applicant Profile: <?= e($applicant['Fname'] . ' ' . $applicant['Lname']) ?></h1>
    <div>
        <a href="applicant_edit.php?id=<?=$id ?>" class="btn">Edit Profile</a>
        <a href="applicants_list.php" class="btn">Back to List</a>
    </div>
</div>

<div class="form-card" style="margin-bottom: 30px;">
    <h2 style="margin-top: 0;">Personal Details</h2>
    <p><strong>Citizen ID:</strong> <?= e($applicant['Citizen_ID']) ?></p>
    <p><strong>National ID:</strong> <?= e($applicant['National_ID'] ?? 'Not yet issued') ?></p>
    <p><strong>Date of Birth:</strong> <?= e($applicant['DoB']) ?> (<?= e($applicant['Gender']) ?>)</p>
    <p><strong>Nationality:</strong> <?= e($applicant['Nationality']) ?></p>
    <p><strong>District:</strong> <?= e($applicant['District_name'] ?? 'N/A') ?> (<?= e($applicant['Region_name'] ?? 'N/A') ?> Region)</p>
</div>

<h2>Application History</h2>
<table class="data-table">
    <thead>
        <tr>
            <th>Application ID</th>
            <th>Date</th>
            <th>Type</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($applications as $app): ?>
            <tr>
                <td>#<?= $app['Application_ID'] ?></td>
                <td><?= e($app['Application_date']) ?></td>
                <td><?= e($app['Application_type']) ?></td>
                <td><strong><?= e($app['Application_status']) ?></strong></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>