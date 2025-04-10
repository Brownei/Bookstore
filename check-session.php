<?php
session_start();
header("Content-Type: application/json");

if (isset($_SESSION['user-id'])) {
    echo json_encode([
        "loggedIn" => true,
        "userId" => $_SESSION['user-id'],
        // You can return more session data if needed
    ]);
} else {
    echo json_encode([
        "loggedIn" => false
    ]);
}
?>

