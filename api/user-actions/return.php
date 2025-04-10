<?php
require "../../db.php";
session_start();

if(!isset($_SESSION['user-id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Get the book ID from the POST request
$book_id = isset($_POST['book_id']) ? $_POST['book_id'] : null;

if (!$book_id) {
    echo json_encode(["error" => "Book ID is required"]);
    exit();
}

try {
    $user_id = $_SESSION['user-id'];
    $todayDate = date('Y-m-d');

    // Begin transaction
    $conn->beginTransaction();

    // Update returned_at in borrowed_books table
    $stmt = $conn->prepare("
        UPDATE borrowed_books 
        SET returned_at = :returned_at 
        WHERE user_id = :user_id 
          AND book_id = :book_id 
          AND returned_at IS NULL
    ");
    $stmt->execute([
        'user_id' => $user_id,
        'book_id' => $book_id,
        'returned_at' => $todayDate
    ]);

    // Ensure a row was updated
    if ($stmt->rowCount() === 0) {
        $conn->rollBack();
        echo json_encode(["error" => "No active borrow record found for this book."]);
        exit();
    }

    // Increase book quantity
    $updateQuantity = $conn->prepare("
        UPDATE books 
        SET quantity = quantity + 1 
        WHERE id = :book_id
    ");
    $updateQuantity->execute(['book_id' => $book_id]);

    // Commit transaction
    $conn->commit();

    echo json_encode([
        "success" => true,
        "message" => "Book returned successfully.",
        "date" => $todayDate
    ]);
} catch (PDOException $e) {
    $conn->rollBack();
    echo json_encode(["error" => $e->getMessage()]);
}
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>


