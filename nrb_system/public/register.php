<?php
require_once __DIR__ . '/../includes/header.php';

$errors = [];
$old = []; // To keep form data if there's an error

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Grab the data and trim whitespace
    $fname = trim($_POST['fname'] ?? '');
    $lname = trim($_POST['lname'] ?? '');
    $dob   = $_POST['dob'] ?? '';
    $gender= $_POST['gender'] ?? '';
    $district_id = (int)($_POST['district_id'] ?? 0);
    
    // Save data in case we need to redisplay the form
    $old = compact('fname','lname','dob','gender','district_id');

    // 2. Validate
    if ($fname === '') $errors[] = 'First name is required.';
    if ($lname === '') $errors[] = 'Last name is required.';
    if (empty($dob)) $errors[] = 'Date of birth is required.';
    if (!in_array($gender, ['M','F','O'])) $errors[] = 'Please select a gender.';
    if ($district_id <= 0) $errors[] = 'Please select a district.';

    // 3. Insert into database if no errors
    if (empty($errors)) {
        // Auto-generate Citizen_ID (e.g., MW-CIT-12345)
        $citizen_id = 'MW-CIT-' . str_pad(random_int(1, 99999), 5, '0', STR_PAD_LEFT);

        try {
            $pdo->beginTransaction();

            // Insert Citizen
            $sql = "INSERT INTO MALAWIAN_CITIZEN (Fname, Lname, DoB, Gender, District_ID, Citizen_ID)
                    VALUES (:fname, :lname, :dob, :gender, :district, :cid)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':fname' => $fname,
                ':lname' => $lname,
                ':dob'   => $dob,
                ':gender'=> $gender,
                ':district' => $district_id,
                ':cid'      => $citizen_id,
            ]);
            
            $person_id = $pdo->lastInsertId();

            // Automatically create a 'Pending' application for them
            $pdo->prepare("INSERT INTO NEW_APPLICATION (Application_date, Application_status, Person_ID, Registration_date)
                           VALUES (CURDATE(), 'Pending', :pid, CURDATE())")
                ->execute([':pid' => $person_id]);

            $pdo->commit();
            
            // Success! Redirect back to home or list
            $_SESSION['success'] = "Applicant registered successfully! Citizen ID: $citizen_id";
            header("Location: index.php");
            exit;

        } catch (PDOException $e) {
            $pdo->rollBack();
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    }
}

// Fetch districts for the dropdown menu
$districts = $pdo->query("SELECT District_ID, District_name FROM DISTRICT ORDER BY District_name")->fetchAll();
?>

<h1>Register New Applicant</h1>

<?php if ($errors): ?>
    <div class="alert alert-error">
        <ul>
            <?php foreach ($errors as $err): ?>
                <li><?= e($err) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" class="form-card">
    <div class="form-row">
        <label>First Name *</label>
        <input type="text" name="fname" value="<?= e($old['fname'] ?? '') ?>" required>
    </div>
    
    <div class="form-row">
        <label>Last Name *</label>
        <input type="text" name="lname" value="<?= e($old['lname'] ?? '') ?>" required>
    </div>
    
    <div class="form-row">
        <label>Date of Birth *</label>
        <input type="date" name="dob" value="<?= e($old['dob'] ?? '') ?>" required>
    </div>
    
    <div class="form-row">
        <label>Gender *</label>
        <select name="gender" required>
            <option value="">-- Select --</option>
            <option value="M" <?= ($old['gender'] ?? '') === 'M' ? 'selected' : '' ?>>Male</option>
            <option value="F" <?= ($old['gender'] ?? '') === 'F' ? 'selected' : '' ?>>Female</option>
            <option value="O" <?= ($old['gender'] ?? '') === 'O' ? 'selected' : '' ?>>Other</option>
        </select>
    </div>
    
    <div class="form-row">
        <label>District *</label>
        <select name="district_id" required>
            <option value="">-- Select District --</option>
            <?php foreach ($districts as $d): ?>
                <option value="<?= $d['District_ID'] ?>" <?= ($old['district_id'] ?? 0) == $d['District_ID'] ? 'selected' : '' ?>>
                    <?= e($d['District_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">Register Applicant</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>