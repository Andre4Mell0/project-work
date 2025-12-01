<?php
session_start();

// If the user is NOT logged in, redirect them
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
</head>
<body>

<h1>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>

<p>You are successfully logged in.</p>

<a href="logout.php">Logout</a>

</body>
</html>
