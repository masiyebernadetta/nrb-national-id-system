<?php
require_once __DIR__ . '/../includes/header.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $app_id   = (int)($_POST['application_id'] ?? 0);
    $nid_no   = trim($_POST['national_id_no'] ?? '');
    $issue    = $_POST['issue_date'] ?? '';
    $expiry   = $_POST['expired_date'] ?? '';
    $status   = $_POST['card_status'] ?? 'Active';

    // Validation (Task 3b)
    if ($app_id <= 0) $errors[] = 'Please select an application.';
    if (!preg_match('/^MW-NID-\d{5}$/', $nid_no)) {
        $errors[] = 'National ID must match the format: MW-NID-12345.';
    }
    if (empty($issue)) $errors[] = 'Issue date is required.';

    if (empty($errors)) {
        try {
            // Find the Person_ID based on the selected Application
            $s = $pdo->prepare("SELECT Person_ID FROM NEW_APPLICATION WHERE Application_ID = :id");
            $s->execute([':id' => $app_id]);
            $person = $s->fetch();
            
            if (!$person) throw new Exception('Application not found.');

            $pdo->beginTransaction();

            // 1. Insert the Card
            $pdo->prepare("INSERT INTO NATIONAL_ID_CARD (National_ID_No, Issue_date, Expired_date, Card_Status, Person_ID, Application_ID)
                           VALUES (:nid, :iss, :exp, :st, :pid, :aid)")
                ->execute([
                    ':nid' => $nid_no, ':iss' => $issue, ':exp' => $expiry ?: null,
                    ':st' => $status, ':pid' => $person['Person_ID'], ':aid' => $app_id,
                ]);

            // 2. Update the Application Status to 'Issued'
            $pdo->prepare("UPDATE NEW_APPLICATION SET Application_status = 'Issued' WHERE Application_ID = :id")
                ->execute([':id' => $app_id]);

            // 3. Update the Citizen's National_ID field
            $pdo->prepare("UPDATE MALAWIAN_CITIZEN SET National_ID = :nid WHERE Person_ID = :pid")
                ->execute([':nid' => $nid_no, ':pid' => $person['Person_ID']]);

            $pdo->commit();
            
            $_SESSION['success'] = "ID Card $nid_no issued successfully!";
            header("Location: cards_list.php");
            exit;

        } catch (PDOException $e) {
            $pdo->rollBack();
            // Task 3c: Handle Duplicate Entry Error
            if ($e->getCode() === '23000') {
                $errors[] = 'Error: This National ID number or Application already has a card.';
            } else {
                $errors[] = 'Database error: ' . $e->getMessage();
            }
        }
    }
}

// Fetch 'Approved' applications that DO NOT have a card yet
$apps = $pdo->query("
    SELECT na.Application_ID, mc.Fname, mc.Lname
    FROM NEW_APPLICATION na
    INNER JOIN MALAWIAN_CITIZEN mc ON na.Person_ID = mc.Person_ID
    LEFT JOIN NATIONAL_ID_CARD nic ON na.Application_ID = nic.Application_ID
    WHERE nic.Card_ID IS NULL AND na.Application_status = 'Approved'
    ORDER BY na.Application_ID
")->fetchAll();
?>

<h1>Issue New National ID Card</h1>

<?php if ($errors): ?>
    <div class="alert alert-error"><ul>
        <?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?>
    </ul></div>
<?php endif; ?>

<form method="post" class="form-card">
    <div class="form-row">
        <label>Application (Approved Only) *</label>
        <select name="application_id" required>
            <option value="">-- Select Approved Application --</option>
            <?php foreach ($apps as $ap): ?>
                <option value="<?= (int)$ap['Application_ID'] ?>">
                    #<?= (int)$ap['Application_ID'] ?> — <?= e($ap['Fname'] . ' ' . $ap['Lname']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <small style="color: #666; margin-top: 5px;">Only approved applications without an existing card appear here.</small>
    </div>
    
    <div class="form-row">
        <label>National ID Number *</label>
        <input type="text" name="national_id_no" placeholder="MW-NID-12345" required pattern="MW-NID-\d{5}">
        <small style="color: #666; margin-top: 5px;">Format: MW-NID- followed by 5 digits.</small>
    </div>
    
    <div class="form-row">
        <label>Issue Date *</label>
        <input type="date" name="issue_date" value="<?= date('Y-m-d') ?>" required>
    </div>
    
    <div class="form-row">
        <label>Expiry Date</label>
        <input type="date" name="expired_date" value="<?= date('Y-m-d', strtotime('+10 years')) ?>">
    </div>
    
    <div class="form-row">
        <label>Card Status *</label>
        <select name="card_status" required>
            <option value="Active">Active</option>
            <option value="Suspended">Suspended</option>
            <option value="Revoked">Revoked</option>
            <option value="Expired">Expired</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">Issue Card</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>