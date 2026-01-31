<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);  ?>
<?php session_start(); ?>
<?php
if (isset($_SESSION['error'])) {
    echo '
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        ' . $_SESSION['error'] . '
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    ';
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>

    <!-- Bootstrap 5 CDN -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">

                <div class="card shadow-lg p-4">
                    <h3 class="text-center mb-4">Create an Account</h3>

                    <!-- Signup Form -->
                    <form action="signup_process.php" method="POST">

                        <!-- Full Name -->
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" name="full_name" class="form-control" id="full_name" value="<?= $_SESSION['old']['full_name'] ?? '' ?>" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" id="email" value="<?= $_SESSION['old']['email'] ?? '' ?>" required>
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" id="phone"  maxlength="10" pattern="[0-9]{10}" title="Phone number must be exactly 10 digits"
                            value="<?= $_SESSION['old']['phone'] ?? '' ?>" required>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100">Sign Up</button>

                        <!-- Login Link -->
                        <p class="text-center mt-3">
                            Already have an account? <a href="login.php">Login</a>
                        </p>

                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
