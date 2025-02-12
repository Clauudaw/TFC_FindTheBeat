<?php
session_start();
include './db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $space_id = $_POST['space_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    if ($rating < 1 || $rating > 5 || empty($comment)) {
        die("Error: Datos inválidos.");
    }

    $stmt = $db->prepare("INSERT INTO reviews (user_id, space_id, rating, comment, created_at, updated_at) 
                          VALUES (:user_id, :space_id, :rating, :comment, NOW(), NOW())");
    $stmt->execute([
        ':user_id' => $user_id,
        ':space_id' => $space_id,
        ':rating' => $rating,
        ':comment' => $comment
    ]);

    header("Location: detalles.php?id=$space_id");
    exit();
} else {
    die("Acceso denegado.");
}
?>
