<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $newsId = $_POST['news_id'];
        $comment = $_POST['comment'];


        $conn = new mysqli("localhost", "root", "2023", "moviesdb");
        $insertQuery = "INSERT INTO comments (news_id, user_id, comment) VALUES ($newsId, $userId, '$comment')";
        $conn->query($insertQuery);
        $conn->close();
    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>