<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);  ?>
<?php
// Step 1: Start session
session_start();

// Step 2: Include database connection
include "../database/db.php";

// Step 3: Check if the form is submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Step 4: Get form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Step 5: Check if email exists in database
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    // Step 6: If no record found
    if (mysqli_num_rows($result) == 0) {
        die("Error: Email does not exist. Please sign up first.");
    }

    // Step 7: Fetch user data
    $user = mysqli_fetch_assoc($result);

    // Step 8: Verify password
    if (password_verify($password, $user["password"])) {

        // Step 9: Set session variables
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["full_name"];
        $_SESSION["user_email"] = $user["email"];

        // Step 10: Redirect to dashboard
        header("Location: ../dashboard/dashboard.php");
        exit();

    } else {
        die("Error: Incorrect password.");
    }

} else {
    die("Invalid Request.");
}
?>
