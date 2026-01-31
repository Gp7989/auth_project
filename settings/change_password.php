<?php
require_once __DIR__ . '/../helpers/auth_helper.php';
require_once __DIR__ . '/../database/db.php';

requireLogin();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = $_POST['current_password'];
    $new     = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if ($new !== $confirm) {
        $error = "New passwords do not match.";
    } else {
        $userId = currentUserId();

        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!password_verify($current, $user['password'])) {
            $error = "Current password is incorrect.";
        } else {
            $hash = password_hash($new, PASSWORD_DEFAULT);

            $update = $conn->prepare(
                "UPDATE users SET password = ? WHERE id = ?"
            );
            $update->bind_param("si", $hash, $userId);
            $update->execute();

            session_destroy();
            header("Location: ../auth/login.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card p-4 shadow">
        <h3>Change Password</h3>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label>Current Password</label>
                <input type="password" name="current_password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Confirm New Password</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>

            <button class="btn btn-primary">Update Password</button>
        </form>
    </div>
</div>

</body>
</html>
