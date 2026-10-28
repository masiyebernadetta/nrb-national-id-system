<?php
require_once __DIR__ . '/../includes/header.php';

// 1. Get search and sort variables
$search = trim($_GET['q'] ?? '');
$sort = $_GET['sort'] ?? 'ID';

// 2. Base query (Notice the space at the very end of the string)
$sql = "SELECT mc.Person_ID, mc.Fname, mc.Lname, mc.DoB, mc.Gender,
               mc.Citizen_ID, mc.National_ID, d.District_name
        FROM MALAWIAN_CITIZEN mc
        LEFT JOIN DISTRICT d ON mc.District_ID = d.District_ID ";

$params = [];

// 3. Search logic
if ($search !== '') {
    $sql .= " WHERE mc.Fname LIKE :q1 OR mc.Lname LIKE :q2
              OR mc.Citizen_ID LIKE :q3 OR mc.National_ID LIKE :q4";
              
    $searchTerm = "%$search%";
    $params[':q1'] = $searchTerm;
    $params[':q2'] = $searchTerm;
    $params[':q3'] = $searchTerm;
    $params[':q4'] = $searchTerm;
}

// 4. Sort logic
if ($sort === 'Name') {
    $sql .= " ORDER BY mc.Lname ASC";
} elseif ($sort === 'DoB') {
    $sql .= " ORDER BY mc.DoB ASC";
} elseif ($sort === 'District') {
    $sql .= " ORDER BY d.District_name ASC";
} elseif ($sort === 'Gender') {
    $sql .= " ORDER BY mc.Gender ASC";  
} elseif ($sort === 'ID') {
    $sql .= " ORDER BY mc.Person_ID ASC"; 
} else {
    $sql .= " ORDER BY mc.Person_ID DESC"; // Default (Newest first)
}
// 5. Execute
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$applicants = $stmt->fetchAll();
?>
<h1>Registered Applicants</h1>

<!-- Search Bar -->
<form method="get" style="display: flex; gap: 10px; margin-bottom: 20px;">
    <input type="text" name="q" placeholder="Search by Name, Citizen ID, or National ID..." 
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
        <th><a href="?sort=ID<?= $search ? '&q='.urlencode($search) : '' ?>" style="color: inherit; text-decoration: none;">ID ↕</th>
        
        <!-- Name Header -->
        <th><a href="?sort=Name<?= $search ? '&q='.urlencode($search) : '' ?>" style="color: inherit; text-decoration: none;">Name ↕</a></th>
        
        <!-- DoB Header -->
        <th><a href="?sort=DoB<?= $search ? '&q='.urlencode($search) : '' ?>" style="color: inherit; text-decoration: none;">DoB ↕</a></th>
        
        <th><a href="?sort=Gender<?= $search ? '&q='.urlencode($search) : '' ?>" style="color: inherit; text-decoration: none;">Gender ↕</a></th>
        <th>Citizen ID</th>
        <th>National ID</th>
        
        <!-- District Header -->
        <th><a href="?sort=District<?= $search ? '&q='.urlencode($search) : '' ?>" style="color: inherit; text-decoration: none;">District ↕</a></th>
        
        <th style="text-align: center;">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($applicants)): ?>
        <tr>
            <td colspan="8" style="text-align: center; color: #888;">No applicants found.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($applicants as $a): ?>
            <tr>
                <!-- Centered ID -->
                <td style="text-align: center;"><?= (int)$a['Person_ID'] ?></td>
                
                <!-- Name -->
                <td><?= e($a['Fname'] . ' ' . $a['Lname']) ?></td>
                
                <!-- Date Formatt  -->
                <td><?= e(date('M j, Y', strtotime($a['DoB']))) ?></td>
                
                <!-- Centered Gender -->
                <td style="text-align: center;"><?= e($a['Gender']) ?></td>
                
                <!-- Citizen ID -->
                <td><?= e($a['Citizen_ID']) ?></td>
                
                <!-- National ID  -->
                <td>
                    <?php if (!empty($a['National_ID'])): ?>
                        <?= e($a['National_ID']) ?>
                    <?php else: ?>
                        <span style="color: #d97706; font-weight: bold; font-size: 0.9em;">Pending</span>
                    <?php endif; ?>
                </td>
                
                <!-- District -->
                <td><?= e($a['District_name'] ?? '—') ?></td>
                
                <!-- Centered Action Buttons -->
                <td style="text-align: center; white-space: nowrap;">
                    <a href="applicant_view.php?id=<?= $a['Person_ID'] ?>" class="btn" style="padding: 4px 8px; font-size: 0.8em; background: #3182ce; color: white;">View</a>
                    <a href="applicant_delete.php?id=<?= $a['Person_ID'] ?>" class="btn" style="padding: 4px 8px; font-size: 0.8em; background: #e53e3e; color: white;">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>