<?php
session_start();
if(!isset($_SESSION["user_id"])){
    header("Location: ../auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academy form</title>
</head>
<body>
    <h1>Academy form </h1>
   <div>
    <form action="" method = "POST">
      <div>
        <label for="" >First Name</label><br>
        <input type="text" name="first_name" required>
      </div>  <br>  
      <div>
        <label for="">Middle Name</label> <br>
        <input type="text" name=middle_name >
      </div><br>
      <div>
        <label for="">Last Name</label><br>
        <input type="text" name="last_name" required>
      </div><br>
      <div>
        <label for="">Address</label><br>
        <textarea name="address" id="" required></textarea>
      </div>
      <button type="Submit">Next</button>
    </form>
   </div>
</body>
</html>