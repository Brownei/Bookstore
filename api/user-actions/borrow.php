<?php
require "../../db.php";
session_start();

if (!isset($_SESSION['user-id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$book_id = $_POST['book_id'] ?? null;

if (!$book_id) {
    echo json_encode(["error" => "Book ID is required"]);
    exit();
}

try {
    $userId = $_SESSION['user-id'];

    // Check if book is available
    $checkQuantity = $conn->prepare("SELECT quantity FROM books WHERE id = :book_id");
    $checkQuantity->execute(['book_id' => $book_id]);
    $book = $checkQuantity->fetch(PDO::FETCH_ASSOC);

    if (!$book || $book['quantity'] <= 0) {
        echo json_encode([
            "error" => "This book is currently unavailable."
        ]);
        exit();
    }

    // Check if user already borrowed this book and hasn't returned it
    $checkDuplicate = $conn->prepare("
        SELECT * FROM borrowed_books
        WHERE user_id = :user_id AND book_id = :book_id AND returned_at IS NULL
    ");
    $checkDuplicate->execute([
        'user_id' => $userId,
        'book_id' => $book_id
    ]);

    if ($checkDuplicate->fetch()) {
        echo json_encode([
            "error" => "You have already borrowed this book. Please return it before borrowing again."
        ]);
        exit();
    }

    // Count active borrowed books
    $checkBorrowed = $conn->prepare("
        SELECT COUNT(*) FROM borrowed_books
        WHERE user_id = :user_id AND returned_at IS NULL
    ");
    $checkBorrowed->execute(['user_id' => $userId]);
    $borrowedCount = $checkBorrowed->fetchColumn();

    if ($borrowedCount >= 3) {
        echo json_encode([
            "error" => "You have already borrowed the maximum of 3 books. Please return one before borrowing more."
        ]);
        exit();
    }

    // Proceed to borrow
    $conn->beginTransaction();

    $due_date = date('Y-m-d', strtotime('+14 days'));

    $stmt = $conn->prepare("
        INSERT INTO borrowed_books (user_id, book_id, due_date)
        VALUES (:user_id, :book_id, :due_date)
    ");
    $stmt->execute([
        'user_id' => $userId,
        'book_id' => $book_id,
        'due_date' => $due_date,
    ]);

    $updateQuantity = $conn->prepare("
        UPDATE books SET quantity = quantity - 1 WHERE id = :book_id
    ");
    $updateQuantity->execute(['book_id' => $book_id]);

    $conn->commit();

    echo json_encode([
        "success" => true,
        "message" => "Book borrowed successfully",
        "due_date" => $due_date
    ]);
} catch (PDOException $e) {
    $conn->rollBack();
    echo json_encode(["error" => "Failed to borrow book: " . $e->getMessage()]);
}} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>

