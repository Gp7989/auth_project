<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);  ?>
<?php
// Step 1: Start the session
session_start();

// Step 2: Destroy all session data
session_unset();
session_destroy();

// Step 3: Redirect to login page
header("Location: ../auth/login.php");
exit();
?>
