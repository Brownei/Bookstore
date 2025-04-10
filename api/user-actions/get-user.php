<?php 
header("Content-Type: application/json"); 
session_start();
require "../../db.php"; // Include database connection
require_once "../../helper.php"; // Include helper function

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST["token"] ?? '';

    // Validate inputs
    if (!$token) {
        echo json_encode(["success" => false, "message" => "Not a valid token"]);
        exit();
    }

    try {
        $secret = 'secret_key';
        $current_user = verify_jwt($token, $secret);

        // Check if the username or email already exists
        $stmt = $conn->prepare("SELECT id, email, fullname, role FROM users WHERE email = :email");
        $stmt->execute(["email" => $current_user['email']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
                  echo json_encode(["success" => false, "message" => "There is no user like this!"]);
            exit();
        }

        $_SESSION['user-id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['fullname'] = $user['fullname'];
        echo json_encode(["success" => true, "message" => $user]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
    }
}
?>
