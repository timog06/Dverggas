<?php
session_start();
include_once '../db/connection.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['cart_id'])) {
    die(json_encode(['success' => false, 'message' => 'Invalid request']));
}

$cart_id = intval($_POST['cart_id']);
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
if (!$stmt) {
    die(json_encode(['success' => false, 'message' => 'Database error']));
}

$stmt->bind_param("ii", $cart_id, $user_id);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to remove item']);
}

$stmt->close();
$conn->close();
