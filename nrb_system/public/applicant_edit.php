<?php
require_once __DIR__ . '/../includes/header.php';

$id = (int)($_GET['id'] ?? 0);
$errors = [];

// Fetch current data
$stmt = $pdo->prepare("SELECT * FROM MALAWIAN_CITIZEN WHERE Person_ID = :id");
$stmt->execute([':id' => $id]);
$applicant = $stmt->fetch();

if (!$applicant) {
    die("Applicant not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = trim($_POST['fname'] ?? '');
    $lname = trim($_POST['lname'] ?? '');
    $dob   = $_POST['dob'] ?? '';

    if ($fname === '' || $lname === '' || empty($dob)) {
        $errors[] = 'Please fill in all required fields.';
    }

    if (empty($errors)) {
        try {
            $pdo->prepare("UPDATE MALAWIAN_CITIZEN SET Fname=:f, Lname=:l, DoB=:d WHERE Person_ID=:id")
                ->execute([':f' => $fname, ':l' => $lname, ':d' => $dob, ':id' => $id]);
            
            $_SESSION['success'] = "Applicant record updated successfully!";
            header("Location: applicant_view.php?id=$id");
            exit;
        } catch (PDOException $e) {
            $errors[] = 'Error updating record: ' . $e->getMessage();
        }
    }
}
?>

<h1>Edit Applicant Record</h1>

<?php if ($errors): ?>
    <div class="alert alert-error"><ul>
        <?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?>
    </ul></div>
<?php endif; ?>

<form method="post" class="form-card">
    <div class="form-row">
        <label>First Name *</label>
        <input type="text" name="fname" value="<?= e($applicant['Fname']) ?>" required>
    </div>
    <div class="form-row">
        <label>Last Name *</label>
        <input type="text" name="lname" value="<?= e($applicant['Lname']) ?>" required>
    </div>
    <div class="form-row">
        <label>Date of Birth *</label>
        <input type="date" name="dob" value="<?= e($applicant['DoB']) ?>" required>
    </div>
    
    <button type="submit" class="btn btn-primary">Save Changes</button>
    <a href="applicant_view.php?id=<?= $id ?>" class="btn">Cancel</a>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>