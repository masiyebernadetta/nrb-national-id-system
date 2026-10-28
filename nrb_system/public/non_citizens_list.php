<?php
require_once __DIR__ . '/../includes/header.php';

// Fetch non-citizens and join with District
$sql = "SELECT nc.Person_ID, nc.Fname, nc.Lname, nc.DoB, nc.Nationality, 
               nc.Resident_ID, nc.Permit_type, nc.Expiry_date, d.District_name
        FROM NON_CITIZEN nc
        LEFT JOIN DISTRICT d ON nc.District_ID = d.District_ID
        ORDER BY nc.Person_ID DESC";

$stmt = $pdo->query($sql);
$nonCitizens = $stmt->fetchAll();
?>

<h1>Registered Non-Citizens</h1>

<table class="data-table">
    <thead>
        <tr>
            <th style="text-align: center;">ID</th>
            <th>Name</th>
            <th>Nationality</th>
            <th>Resident ID</th>
            <th>Permit Type</th>
            <th>Expiry Date</th>
            <th>District</th>
        </tr>
    </thead>
    <tbody>
    <?php if (empty($nonCitizens)): ?>
        <tr>
            <td colspan="7" style="text-align: center; color: #888;">No non-citizens found.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($nonCitizens as $nc): ?>
            <tr>
                <td style="text-align: center;"><?= (int)$nc['Person_ID'] ?></td>
                <td><?= e($nc['Fname'] . ' ' . $nc['Lname']) ?></td>
                <td><?= e($nc['Nationality']) ?></td>
                <td><?= e($nc['Resident_ID']) ?></td>
                <td><?= e($nc['Permit_type'] ?? '—') ?></td>
                <td><?= e($nc['Expiry_date'] ?? '—') ?></td>
                <td><?= e($nc['District_name'] ?? '—') ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>