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
    $title = $_POST['title'] ?? '';
    $cover = $_POST['cover'] ?? '';
    $author = $_POST['author'] ?? '';
    $published_year = $_POST['published_year'] ?? '';

    if (!$bookId || !$title || !$cover || !$author || !$published_year) {
        echo json_encode(["success" => false, "message" => "All fields are required"]);
        exit();
    }

    // Check ownership and borrow status
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

    // Check if the book is currently borrowed
    $borrowedCheck = $conn->prepare("
        SELECT * FROM borrowed_books 
        WHERE book_id = :book_id AND returned_at IS NULL
    ");
    $borrowedCheck->execute(['book_id' => $bookId]);
    if ($borrowedCheck->fetch()) {
        echo json_encode(["success" => false, "message" => "Book is currently borrowed and cannot be edited"]);
        exit();
    }

    // Proceed with update
    $update = $conn->prepare("
        UPDATE books SET title = :title, cover = :cover, author = :author, published_year = :published_year 
        WHERE id = :book_id
    ");
    $success = $update->execute([
        'title' => $title,
        'cover' => $cover,
        'author' => $author,
        'published_year' => $published_year,
        'book_id' => $bookId
    ]);

    echo json_encode(["success" => $success, "message" => $success ? "Book updated!" : "Update failed"]);
}
?>

