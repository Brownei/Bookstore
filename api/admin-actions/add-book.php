<?php
session_start();
header("Content-Type: application/json");
require "../../db.php";

if (!isset($_SESSION['user-id'])) {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit();
}

$userId = $_SESSION['user-id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'] ?? '';
    $cover = $_POST['cover'] ?? '';
    $author = $_POST['author'] ?? '';
    $quantity = $_POST['quantity'] ?? '';
    $published_year = $_POST['published_year'] ?? '';

    // Basic validation
    if (!$title || !$cover || !$quantity || !$author || !$published_year) {
        echo json_encode(["success" => false, "message" => "All fields are required"]);
        exit();
    }

    try {
        $stmt = $conn->prepare("
            INSERT INTO books (title, cover, author, quantity, published_year, owner_id)
            VALUES (:title, :cover, :author, :quantity, :published_year, :owner_id)
        ");
        $stmt->execute([
            'title' => $title,
            'cover' => $cover,
            'author' => $author,
            'quantity' => $quantity,
            'published_year' => $published_year,
            'owner_id' => $userId
        ]);

        echo json_encode(["success" => true, "message" => "Book added successfully"]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
    }
}
?>

