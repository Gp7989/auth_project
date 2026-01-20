<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);  ?>
<?php
// Step 1: Start session
session_start();

// Step 2: Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    // If user not logged in, send them back to login page
    header("Location: ../auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="card shadow p-4">
            <h2>Welcome, <?php echo $_SESSION["user_name"]; ?> 👋</h2>
            <p class="mt-2">Your email: <?php echo $_SESSION["user_email"]; ?></p>

            <a href="../logout/logout.php" class="btn btn-danger mt-3">Logout</a>
        </div>

    </div>

</body>
</html>
