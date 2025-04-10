<?php
header("Content-Type: application/json");
session_start();
require "../../db.php";

// Only admins can edit users
if (!isset($_SESSION['user-id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "Unauthorized. Admins only."]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_POST["user_id"] ?? '';
    $fullname = $_POST["fullname"] ?? '';
    $email = $_POST["email"] ?? '';
    $username = $_POST["username"] ?? '';
    $role = $_POST["role"] ?? '';

    if (!$user_id || !$fullname || !$email || !$username || !$role) {
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        exit();
    }

    try {
        // Update user info
        $stmt = $conn->prepare("UPDATE users SET fullname = :fullname, email = :email, username = :username, role = :role WHERE id = :id");
        $stmt->execute([
            'fullname' => $fullname,
            'email' => $email,
            'username' => $username,
            'role' => $role,
            'id' => $user_id
        ]);

        echo json_encode(["success" => true, "message" => "User updated successfully."]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
    }
}
?>

