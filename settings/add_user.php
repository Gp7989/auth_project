<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../helpers/auth_helper.php';
require_once __DIR__ . '/../helpers/permission_helper.php';
require_once __DIR__ . '/../database/db.php';

requireLogin();

if (!isAdmin()) {
    die("Access denied.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name  = $_POST['name'];
    $email = $_POST['email'];
    $pass  = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role  = $_POST['role'];
    $perms = $_POST['permissions'] ?? [];

    // Create user
    $phone = $_POST['phone'] ?? '';

    $stmt = $conn->prepare(
    "INSERT INTO users (full_name, email, phone, password)
     VALUES (?, ?, ?, ?)"
     );
    $stmt->bind_param("ssss", $name, $email, $phone, $pass);

    $stmt->execute();
    $userId = $conn->insert_id;

    // Assign role
    $stmt = $conn->prepare(
        "INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)"
    );
    $stmt->bind_param("ii", $userId, $role);
    $stmt->execute();

    // Assign permissions
   // Extra permissions (optional overrides)
foreach ($perms as $pid) {
    $stmt = $conn->prepare(
        "INSERT IGNORE INTO user_permissions (user_id, permission_id)
         VALUES (?, ?)"
    );
    $stmt->bind_param("ii", $userId, $pid);
    $stmt->execute();
}


    header("Location: ../dashboard/dashboard.php");
    exit();
}

$roles = $conn->query("SELECT * FROM roles");
$permissions = $conn->query("SELECT * FROM permissions");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
<div class="card p-4 shadow">
<h3>Add User (Admin)</h3>

<form method="POST">

<input class="form-control mb-2" name="name" placeholder="Full Name" required>
<input class="form-control mb-2" name="email" placeholder="Email" required>
<input class="form-control mb-2" name="phone" placeholder="Phone Number" required>
<input class="form-control mb-2" name="password" type="password" placeholder="Password" required>

<select class="form-control mb-3" name="role">
    <?php while ($r = $roles->fetch_assoc()): ?>
        <option value="<?= $r['id'] ?>"><?= $r['role_name'] ?></option>
    <?php endwhile; ?>
</select>

<label>Permissions</label><br>
<?php while ($p = $permissions->fetch_assoc()): ?>
    <input type="checkbox" name="permissions[]" value="<?= $p['id'] ?>">
    <?= $p['permission_name'] ?><br>
<?php endwhile; ?>

<br>
<button class="btn btn-success">Create User</button>

</form>
</div>
</div>

</body>
</html>
