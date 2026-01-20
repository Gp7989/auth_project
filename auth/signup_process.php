<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);  ?>
<?php
// Step 1: Include database connection
session_start();

include "../database/db.php";

// Step 2: Check if the form was submitted using POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Step 3: Get form data
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Step 4: Validate if passwords match
    if ($password !== $confirm_password) {
        die("Error: Passwords do not match.");
    }

    // Step 5: Check if email already exists
    $check_email_query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $check_email_query);

    if (mysqli_num_rows($result) > 0) {
        die("Error: Email already exists. Please use a different email.");
    }

    // Step 6: Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Step 7: Insert data into the database
    $insert_query = "INSERT INTO users (full_name, email, phone, password)
                     VALUES ('$full_name', '$email', '$phone', '$hashed_password')";

    if (mysqli_query($conn, $insert_query)) {
        $_SESSION['signup_success'] = true;

        // Step 8: Redirect to login page after successful signup
        header("Location: login.php");
        exit();
    } else {
        die("Error inserting data: " . mysqli_error($conn));
    }
} else {
    // Step 9: If someone tries to access directly without POST
    die("Invalid Request.");
}

?>
