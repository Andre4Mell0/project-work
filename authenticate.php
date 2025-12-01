<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();



// 1. Make sure the form sent data
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request.");
}

// 2. Get the username & password from the form
$username = $_POST["username"];
$password = $_POST["password"];

// 3. Connect to your database
$conn = new mysqli("127.0.0.1", "phpuser", "phpuser123", "project_work");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 4. Use prepared statements — prevents SQL injection
$stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// 5. Check if user exists
if ($result->num_rows === 0) {
    die("User not found.");
}

$user = $result->fetch_assoc();

// 6. Verify the hashed password
if (!password_verify($password, $user["password"])) {
    die("Incorrect password.");
}

// 7. If OK → store user info in session
$_SESSION["user_id"] = $user["id"];
$_SESSION["username"] = $user["username"];

// 8. Redirect to protected page
header("Location: dashboard.php");
exit;
