<?php
require_once __DIR__ . '/../includes/header.php';

// Get the search query from the URL (if it exists)
$search = trim($_GET['q'] ?? '');

// Base SQL query joining Citizens and Districts
$sql = "SELECT mc.Person_ID, mc.Fname, mc.Lname, mc.DoB, mc.Gender,
               mc.Citizen_ID, mc.National_ID, d.District_name
        FROM MALAWIAN_CITIZEN mc
        LEFT JOIN DISTRICT d ON mc.District_ID = d.District_ID";

$params = [];

// If they searched for something, add a WHERE clause
if ($search !== '') {
    $sql .= " WHERE mc.Fname LIKE :q1 OR mc.Lname LIKE :q2
              OR mc.Citizen_ID LIKE :q3 OR mc.National_ID LIKE :q4";
              
    $searchTerm = "%$search%";
    $params[':q1'] = $searchTerm;
    $params[':q2'] = $searchTerm;
    $params[':q3'] = $searchTerm;
    $params[':q4'] = $searchTerm;
}


$sql .= " ORDER BY mc.Person_ID DESC"; // Newest first

// Run the query safely
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$applicants = $stmt->fetchAll();
?>

<h1>Registered Applicants</h1>

<!-- Search Bar -->
<form method="get" style="display: flex; gap: 10px; margin-bottom: 20px;">
    <input type="text" name="q" placeholder="Search by name, Citizen ID, or National ID..." 
           value="<?= e($search) ?>" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
    <button type="submit" class="btn btn-primary">Search</button>
    <?php if ($search !== '') {?>
        <a href="applicants_list.php" class="btn">Clear</a>
    <?php } ?>
</form>

<!-- Results Table -->
<table class="data-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>DoB</th>
            <th>Gender</th>
            <th>Citizen ID</th>
            <th>National ID</th>
            <th>District</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if (empty($applicants)): ?>
        <tr>
            <td colspan="7" style="text-align: center; color: #888;">No applicants found.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($applicants as $a): ?>
            <tr>
                <td><?= (int)$a['Person_ID'] ?></td>
                <td><?= e($a['Fname'] . ' ' . $a['Lname']) ?></td>
                <td><?= e($a['DoB']) ?></td>
                <td><?= e($a['Gender']) ?></td>
                <td><?= e($a['Citizen_ID']) ?></td>
                <td><?= e($a['National_ID'] ?? '—') ?></td>
                <td><?= e($a['District_name'] ?? '—') ?></td>
                <td>
    <a href="applicant_view.php?id=<?= $a['Person_ID'] ?>" class="btn" style="padding: 4px 8px; font-size: 0.8em; background: #3182ce; color: white;">View</a>
</td>
                <td>
    <a href="applicant_delete.php?id=<?= $a['Person_ID'] ?>" class="btn" style="padding: 4px 8px; font-size: 0.8em; background: #e53e3e; color: white;">Delete</a>
</td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>