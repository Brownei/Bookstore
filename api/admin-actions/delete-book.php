<?php
session_start();
require "../../db.php";

if (!isset($_SESSION['user-id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

$userId = $_SESSION['user-id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
$bookId = $_POST['id'] ?? null;

if (!$bookId) {
    echo json_encode(["success" => false, "message" => "Book ID required"]);
    exit();
}

// Check ownership
$stmt = $conn->prepare("
    SELECT * FROM books 
    WHERE id = :book_id AND owner_id = :owner_id
");
$stmt->execute(['book_id' => $bookId, 'owner_id' => $userId]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$book) {
    echo json_encode(["success" => false, "message" => "Book not found or unauthorized"]);
    exit();
}

// Proceed to delete — borrowed_books will be cleaned up due to ON DELETE CASCADE
$delete = $conn->prepare("DELETE FROM books WHERE id = :book_id");
$success = $delete->execute(['book_id' => $bookId]);

echo json_encode([
    "success" => $success,
    "message" => $success ? "Book deleted" : "Delete failed"
]);
}
?>

