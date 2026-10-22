<?php
require_once __DIR__ . '/../includes/header.php';

// Fetch all issued cards and join with the citizen's name
$stmt = $pdo->query("
    SELECT nic.*, mc.Fname, mc.Lname
    FROM NATIONAL_ID_CARD nic
    INNER JOIN MALAWIAN_CITIZEN mc ON nic.Person_ID = mc.Person_ID
    ORDER BY nic.Issue_date DESC
");
$cards = $stmt->fetchAll();
?>

<div style="display: flex; justify-content: space-between; align-items: center;">
    <h1>National ID Cards</h1>
    <a href="card_issue.php" class="btn btn-primary">+ Issue New ID Card</a>
</div>

<table class="data-table">
    <thead>
        <tr>
            <th>Card ID</th>
            <th>Holder Name</th>
            <th>National ID No</th>
            <th>Issue Date</th>
            <th>Expiry Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    <?php if (empty($cards)): ?>
        <tr><td colspan="6" style="text-align: center; color: #888;">No cards issued yet.</td></tr>
    <?php else: ?>
        <?php foreach ($cards as $c): ?>
            <tr>
                <td><?= (int)$c['Card_ID'] ?></td>
                <td><?= e($c['Fname'] . ' ' . $c['Lname']) ?></td>
                <td><?= e($c['National_ID_No']) ?></td>
                <td><?= e($c['Issue_date']) ?></td>
                <td><?= e($c['Expired_date']) ?></td>
                <td><span class="badge badge-<?= strtolower($c['Card_Status']) ?>"><?= e($c['Card_Status']) ?></span></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>