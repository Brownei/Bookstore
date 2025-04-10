<?php
header("Content-Type: application/json"); 
session_start();
require "../../db.php"; // Include database connection
require_once "../../helper.php"; // Include helper function


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST["role"] ?? '';
    $username = $_POST["username"] ?? '';
    $password = $_POST["password"] ?? '';

    // Validate inputs
    if (!$role || !$username || !$password) {
        echo json_encode(["success" => false, "message" => "All fields needs to be occupied"]);
        exit();
    }

    try {
        // Check if the username or email already exists
        $stmt = $conn->prepare("SELECT id, email, fullname, role, password FROM users WHERE role = :role AND username = :username");
        $stmt->execute(["role" => $role, "username" => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
                  echo json_encode(["success" => false, "message" => "There is no user like this!"]);
            exit();
        } 

        if (!password_verify($password, $user['password'])) {
            echo json_encode(["success" => false, "message" => "Invalid password"]);
        }

    $payload = [
      "user-id" => $user['id'],
      "email" => $user['email'],
      "fullname" => $user['fullname'],
    ];

        $secret = 'secret_key';

        $jwt = create_jwt($payload, $secret);

        $_SESSION['user-id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['role'] = $user['role'];
        echo json_encode(["success" => true, "message" => $jwt]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
    }
}
?>


