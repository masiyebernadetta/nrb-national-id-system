<?php
require_once __DIR__ . '/../includes/header.php';

$id = (int)($_GET['id'] ?? 0);

// Get the person's name for the confirmation screen
$stmt = $pdo->prepare("SELECT Fname, Lname FROM MALAWIAN_CITIZEN WHERE Person_ID = :id");
$stmt->execute([':id' => $id]);
$applicant = $stmt->fetch();

if (!$applicant) {
    $_SESSION['error'] = "Applicant not found.";
    header("Location: applicants_list.php");
    exit;
}

// If the user clicked "Yes, Delete"
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo->beginTransaction();

        // We must delete related records first to respect Foreign Key constraints
        $pdo->prepare("DELETE FROM IDENTIFICATION_DOCUMENT WHERE Person_ID = :id")->execute([':id' => $id]);
        $pdo->prepare("DELETE FROM NATIONAL_ID_CARD WHERE Person_ID = :id")->execute([':id' => $id]);
        $pdo->prepare("DELETE FROM NEW_APPLICATION WHERE Person_ID = :id")->execute([':id' => $id]);
        $pdo->prepare("DELETE FROM BIO_DATA WHERE Person_ID = :id")->execute([':id' => $id]);
        $pdo->prepare("DELETE FROM DEPENDENT WHERE Person_ID = :id")->execute([':id' => $id]);
        $pdo->prepare("DELETE FROM PERSON_CONTACT WHERE Person_ID = :id")->execute([':id' => $id]);
        
        // Finally, delete the person
        $pdo->prepare("DELETE FROM MALAWIAN_CITIZEN WHERE Person_ID = :id")->execute([':id' => $id]);

        $pdo->commit();
        
        $_SESSION['success'] = "Applicant deleted successfully.";
        header("Location: applicants_list.php");
        exit;

    } catch (PDOException $e) {
        $pdo->rollBack();
        $error = "Error deleting record: " . $e->getMessage();
    }
}
?>

<h1>Confirm Deletion</h1>

<?php if (isset($error)): ?>
    <div class="alert alert-error"><?= e($error) ?></div>
<?php endif; ?>

<div class="alert alert-error" style="font-size: 1.1em;">
    <p>Are you sure you want to permanently delete <strong><?= e($applicant['Fname'] . ' ' . $applicant['Lname']) ?></strong>?</p>
    <p style="font-size: 0.9em; margin-top: 10px;">This will also permanently delete all their applications, ID cards, and biometric data. This action cannot be undone.</p>
</div>

<form method="post">
    <button type="submit" class="btn" style="background: #e53e3e; color: white;">Yes, Delete Applicant</button>
    <a href="applicants_list.php" class="btn">Cancel</a>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>