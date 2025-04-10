<?php
header("Content-Type: application/json");
session_start();
require "../../db.php";

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['user-id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "Unauthorized. Admins only."]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullname = $_POST["fullname"] ?? '';
    $email = $_POST["email"] ?? '';
    $role = $_POST["role"] ?? '';
    $username = $_POST["username"] ?? '';
    $password = $_POST["password"] ?? '';

    // Validate all fields
    if (!$fullname || !$email || !$role || !$username || !$password) {
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        exit();
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Check for duplicate email or username
        $check = $conn->prepare("SELECT id FROM users WHERE email = :email OR username = :username");
        $check->execute(['email' => $email, 'username' => $username]);

        if ($check->fetch()) {
            echo json_encode(["success" => false, "message" => "Email or username already exists."]);
            exit();
        }

        // Insert user
        $insert = $conn->prepare("INSERT INTO users (fullname, email, role, username, password) VALUES (:fullname, :email, :role, :username, :password)");
        $insert->execute([
            'fullname' => $fullname,
            'email' => $email,
            'role' => $role,
            'username' => $username,
            'password' => $hashedPassword
        ]);

        echo json_encode(["success" => true, "message" => "User created successfully."]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
    }
}
?>

