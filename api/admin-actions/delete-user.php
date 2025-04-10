
<?php
header("Content-Type: application/json");
session_start();
require "../../db.php";

// Only admins can delete users
if (!isset($_SESSION['user-id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "Unauthorized. Admins only."]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_POST["user_id"] ?? '';

    if (!$user_id) {
        echo json_encode(["success" => false, "message" => "User ID is required."]);
        exit();
    }

    try {
        // Prevent deleting self
        if ($user_id == $_SESSION['user-id']) {
            echo json_encode(["success" => false, "message" => "You cannot delete your own account."]);
            exit();
        }

        // Set returned_at for all borrowed books that are still out
        $return_stmt = $conn->prepare("
            UPDATE borrowed_books 
            SET returned_at = NOW() 
            WHERE user_id = :user_id AND returned_at IS NULL
        ");
        $return_stmt->execute(['user_id' => $user_id]);

        // Now delete the user
        $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute(['id' => $user_id]);

        echo json_encode(["success" => true, "message" => "User deleted and borrowed books returned successfully."]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
    }
}
?>

