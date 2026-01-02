<?php
// reset_admin.php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'library_db';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete existing admin
$conn->query("DELETE FROM users WHERE username = 'admin'");

// Insert admin with correct MD5 hash
$password = 'admin123';
$md5_hash = md5($password);
$stmt = $conn->prepare("INSERT INTO users (username, password, email, full_name, user_type) VALUES (?, ?, ?, ?, 'admin')");
$stmt->bind_param("ssss", 'admin', $md5_hash, 'admin@university.edu', 'System Administrator');
$stmt->execute();

echo "Admin reset successfully!<br>";
echo "Username: admin<br>";
echo "Password: admin123<br>";
echo "MD5 Hash: $md5_hash<br>";
echo "<a href='login.php'>Go to Login</a>";
?>