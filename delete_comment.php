<?php
session_start();

// Provjera korisnikove prijave
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Provjera pripada li komentar određenom korisniku
    $commentId = (int)$_GET['comment_id']; 
    $conn = new mysqli("localhost", "root", "2023", "moviesdb");

    // Korak protiv SQL injection
    $deleteQuery = $conn->prepare("DELETE FROM comments WHERE comment_id = ? AND user_id = ?");
    $deleteQuery->bind_param("ii", $commentId, $userId);
    $deleteQuery->execute();
    
    $deleteQuery->close();
    
    $conn->close();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>
