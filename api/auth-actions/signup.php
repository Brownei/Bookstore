<?php
header("Content-Type: application/json"); 
session_start();
require "../../db.php"; // Include database connection
require_once "../../helper.php"; // Include helper function

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST["fullname"] ?? '';
    $email = $_POST["email"] ?? '';
    $role = $_POST["role"] ?? '';
    $username = $_POST["username"] ?? '';
    $password = $_POST["password"] ?? '';

    // Validate inputs
    if (!$fullname || !$email || !$role || !$username || !$password) {
        echo json_encode(["success" => false, "message" => "All fields needs to be occupied"]);
        exit();
    }

    // Hash the password before storing it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Check if the username or email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email OR username = :username");
        $stmt->execute(["email" => $email, "username" => $username]);

        if ($stmt->fetch()) {
            echo json_encode(["success" => false, "message" => "Email or Username already taken."]);
            exit();
        }

        // Insert new user into the database
        $stmt = $conn->prepare("INSERT INTO users (fullname, email, role, username, password) VALUES (:fullname, :email, :role, :username, :password)");
        $stmt->bindParam(":fullname", $fullname);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":role", $role);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $hashedPassword);

        if ($stmt->execute()) {
      $userId = $conn->lastInsertId();

            // Fetch the created user details
            $fetchStmt = $conn->prepare("SELECT id, fullname, email, username, role FROM users WHERE id = :id");
            $fetchStmt->execute(["id" => $userId]);
            $user = $fetchStmt->fetch(PDO::FETCH_ASSOC);

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

        } else {
            echo json_encode(["success" => false, "message" => "Failed to create an account."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
    }
}
?>

