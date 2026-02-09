<?php
// Database connection settings (already identified as root for local)
$host = '127.0.0.1';
$user = 'root';
$pass = '';
$db   = 'csirt_rri';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// User data
$username = 'admin_local';
$email = 'admin@rri-local.test';
$password = 'admin123';
$role = 'admin';

// Hash password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Check if user already exists
$check = $conn->prepare("SELECT id FROM users WHERE username = ?");
$check->bind_param("s", $username);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo "User '$username' already exists.\n";
} else {
    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (username, password, email, role, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssss", $username, $hashed_password, $email, $role);
    
    if ($stmt->execute()) {
        echo "Admin user created successfully!\n";
        echo "Username: $username\n";
        echo "Password: $password\n";
    } else {
        echo "Error creating user: " . $stmt->error . "\n";
    }
    $stmt->close();
}

$check->close();
$conn->close();
